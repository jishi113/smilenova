<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Billing\Models\Invoice;
use Modules\Billing\Models\InvoiceItem;
use Modules\Billing\Models\Payment;
use Modules\Billing\Models\Service;
use Modules\Patients\Models\Patient;
use Modules\Appointments\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillingController extends Controller
{
    // ============= INVOICES =============

    public function index(Request $request)
    {
        $invoices = Invoice::with(['patient'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                  ->orWhereHas('patient', function ($q2) use ($request) {
                      $q2->where('first_name', 'like', "%{$request->search}%")
                         ->orWhere('last_name', 'like', "%{$request->search}%");
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total_invoiced' => Invoice::sum('total'),
            'total_collected' => Payment::sum('amount'),
            'total_pending' => Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->sum('total'),
            'invoice_count' => Invoice::count(),
        ];

        return view('billing::invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $appointments = Appointment::with('patient')
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->orderBy('appointment_date', 'desc')
            ->take(20)
            ->get();

        return view('billing::invoices.create', compact('patients', 'services', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['nullable', 'exists:services,id'],
            'items.*.description' => ['required', 'string', 'max:200'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        // Calculate totals
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $discount = $validated['discount'] ?? 0;
        $taxRate = $validated['tax_rate'] ?? 18;
        $taxable = $subtotal - $discount;
        $taxAmount = round($taxable * ($taxRate / 100), 2);
        $total = $taxable + $taxAmount;

        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'patient_id' => $validated['patient_id'],
            'appointment_id' => $validated['appointment_id'] ?? null,
            'generated_by' => auth()->id(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'status' => 'draft',
            'due_date' => $validated['due_date'] ?? now()->addDays(15),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create items
        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'service_id' => $item['service_id'] ?? null,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()
            ->route('admin.billing.invoices.show', $invoice)
            ->with('success', 'Invoice ' . $invoice->invoice_number . ' created.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment.doctor.user', 'items', 'payments']);
        
        $totalPaid = $invoice->payments->sum('amount');
        $balanceDue = $invoice->total - $totalPaid;

        return view('billing::invoices.show', compact('invoice', 'totalPaid', 'balanceDue'));
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $totalPaid = $invoice->payments->sum('amount');
        $maxAllowed = $invoice->total - $totalPaid;

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $maxAllowed],
            'payment_method' => ['required', 'in:cash,card,upi,net_banking,cheque'],
            'reference_no' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $invoice->payments()->create([
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'reference_no' => $validated['reference_no'] ?? null,
            'received_by' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Auto-update status
        $totalPaidNow = $invoice->fresh()->payments->sum('amount');
        if ($totalPaidNow >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaidNow > 0) {
            $invoice->update(['status' => 'partial']);
        }

        return back()->with('success', 'Payment of ₹' . number_format($validated['amount'], 2) . ' recorded.');
    }

    // ============= SERVICES CATALOG =============

    public function services()
    {
        $services = Service::orderBy('category')->orderBy('name')->paginate(20);
        return view('billing::services.index', compact('services'));
    }

    // ============= PAYMENTS =============

    public function payments()
    {
        $payments = Payment::with(['invoice.patient'])
            ->orderBy('paid_at', 'desc')
            ->paginate(30);

        $stats = [
            'total_collected' => Payment::sum('amount'),
            'cash' => Payment::where('payment_method', 'cash')->sum('amount'),
            'card' => Payment::where('payment_method', 'card')->sum('amount'),
            'upi' => Payment::where('payment_method', 'upi')->sum('amount'),
        ];

        return view('billing::payments.index', compact('payments', 'stats'));
    }

    // ============= REVENUE REPORT =============

    public function revenueReport(Request $request)
    {
        $period = $request->input('period', 'month');
        
        $startDate = match ($period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };
        $endDate = match ($period) {
            'week' => now()->endOfWeek(),
            'month' => now()->endOfMonth(),
            'year' => now()->endOfYear(),
            default => now()->endOfMonth(),
        };

        $stats = [
            'total_invoiced' => Invoice::whereBetween('created_at', [$startDate, $endDate])->sum('total'),
            'total_collected' => Payment::whereBetween('paid_at', [$startDate, $endDate])->sum('amount'),
            'invoice_count' => Invoice::whereBetween('created_at', [$startDate, $endDate])->count(),
            'paid_count' => Invoice::where('status', 'paid')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        return view('billing::reports.revenue', compact('stats', 'period'));
    }

    // ============= HELPER =============

    private function generateInvoiceNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $count = Invoice::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        return 'SNV-' . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}