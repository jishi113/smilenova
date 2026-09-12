<?php

namespace Modules\Billing\Http\Controllers;

use Modules\Billing\Models\Invoice;
use Modules\Billing\Models\Payment;
use Modules\Billing\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        $period = $request->input('period', 'month');
        [$startDate, $endDate] = match ($period) {
            'week' => [now()->startOfWeek(), now()->endOfWeek()],
            'year' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };

        $stats = [
            'total_invoiced' => Invoice::whereBetween('created_at', [$startDate, $endDate])->sum('total'),
            'total_collected' => Payment::whereBetween('paid_at', [$startDate, $endDate])->sum('amount'),
            'invoice_count' => Invoice::whereBetween('created_at', [$startDate, $endDate])->count(),
            'paid_count' => Invoice::where('status', 'paid')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        $byService = InvoiceItem::select('description', DB::raw('SUM(quantity) as units'), DB::raw('SUM(total) as revenue'))
            ->whereHas('invoice', fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->groupBy('description')->orderByDesc('revenue')->get();

        return view('billing::reports.revenue', compact('stats', 'byService', 'period'));
    }
}