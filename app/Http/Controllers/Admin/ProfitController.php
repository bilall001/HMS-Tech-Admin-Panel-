<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyProfit;
use App\Models\Partner;
use App\Models\PartnerProfit;
use App\Models\Project;
use App\Models\CompanyExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function generateMonthlyProfit(Request $request)
    {
        $month = $request->input('month') ?? now()->format('Y-m');

        // check if already generated
        if (MonthlyProfit::where('month', $month)->exists()) {
            return back()->with('error', "Profit for $month already calculated.");
        }

        // revenue from paid projects in month
        $totalRevenue = Project::whereMonth('created_at', Carbon::parse($month)->month)
            ->whereYear('created_at', Carbon::parse($month)->year)
            ->sum('paid_price');

        // expenses in month
        $totalExpenses = CompanyExpense::whereMonth('date', Carbon::parse($month)->month)
            ->whereYear('date', Carbon::parse($month)->year)
            ->sum('amount');

        $netProfit = $totalRevenue - $totalExpenses;

        // save monthly profit
        $monthlyProfit = MonthlyProfit::create([
            'month' => $month,
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'net_profit' => $netProfit,
        ]);

        // distribute among partners
        $partners = Partner::all();
        foreach ($partners as $partner) {
            $share = ($netProfit * $partner->profit_percentage) / 100;

            PartnerProfit::create([
                'monthly_profit_id' => $monthlyProfit->id,
                'partner_id' => $partner->id,
                'percentage' => $partner->profit_percentage,
                'profit_amount' => $share,
            ]);
        }

        return back()->with('success', "Profit for $month calculated and distributed!");
    }

    public function index()
    {
        $monthlyProfits = MonthlyProfit::with('partnerProfits.partner')->latest()->paginate(12);
        return view('admin.pages.partnerprofit', compact('monthlyProfits'));
    }

    public function markReceived($id)
    {
        $profit = PartnerProfit::findOrFail($id);
        $profit->update([
            'is_received' => true,
            'reinvested' => false
        ]);

        return back()->with('success', 'Profit marked as received.');
    }

    public function markReinvested($id)
    {
        $profit = PartnerProfit::findOrFail($id);
        $profit->update([
            'is_received' => false,
            'reinvested' => true
        ]);

        return back()->with('success', 'Profit marked as reinvested.');
    }
}
