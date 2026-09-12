<?php

namespace Modules\Billing\Http\Controllers;

use Modules\Billing\Models\Invoice;
use Modules\Appointments\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('patient')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->patient, fn($q) => $q->where('patient_id', $request->patient))
            ->latest()->paginate(20);

        return view('billing::invoices.index', compact('invoices'));
    }

    public function generateFromAppointment(Appointment $appointment)
    {
        if ($appointment->invoice()->exists()) {
            return redirect()->route('billing.invoices.show', $appointment->invoice)
                ->with('success', 'Invoice already exists for this appointment.');
        }

        $service = $appointment->service;
        $subtotal = $service?->price ?? 0;
        $taxRate = 18.0;
        $taxAmt = round($subtotal * ($taxRate / 100), 2);
        $total = $subtotal + $taxAmt;

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'generated_by' => auth()->id(),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmt,
            'total' => $total,
            'due_date' => now()->addDays(15),
            'status' => 'draft',
        ]);

        if ($service) {
            $invoice->items()->create([
                'service_id' => $service->id,
                'description' => $service->name,
                'quantity' => 1,
                'unit_price' => $service->price,
                'total' => $service->price,
            ]);
        }

        return redirect()->route('billing.invoices.show', $invoice)->with('success', 'Invoice generated successfully.');
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
       $maxAllowed = round($invoice->total - $invoice->payments->sum('amount'), 2);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $maxAllowed],
            'payment_method' => ['required', 'in:cash,card,upi,net_banking,cheque'],
            'reference_no' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $invoice->payments()->create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference_no' => $request->reference_no,
            'received_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        $totalPaid = $invoice->fresh()->payments->sum('amount');
        if (round($totalPaid, 2) >= round($invoice->total, 2) - 0.01)  {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partial']);
        }

        return back()->with('success', 'Payment of ₹' . number_format($request->amount, 2) . ' recorded.');
    }
}