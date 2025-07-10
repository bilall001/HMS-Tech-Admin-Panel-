<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CompanyExpense;
use App\Models\Project;
use App\Models\ProjectSchedule;
// use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function TotalCLients(){
        $clients = Client::count();
        $projects = Project::count();
        $currentProjects = ProjectSchedule::where('status', 'deliver')->count();
            $monthCompletedProjects = ProjectSchedule::where('status', 'complete')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

        $totalIncome = Project::sum('price');
        $monthExpense  = CompanyExpense::whereMonth('created_at', Carbon::now()->month)
        ->sum('amount');

        $monthProfit = $totalIncome - $monthExpense;
        return view('admin.index',
         compact('clients', 'projects', 'currentProjects', 'monthCompletedProjects', 'totalIncome', 'monthExpense', 'monthProfit' ));
    }
}