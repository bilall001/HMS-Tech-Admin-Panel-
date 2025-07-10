<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientDashbordController extends Controller
{
 public function dashboard()
    {
        // Get the logged-in client
        $client = Auth::user();
        $clientId = $client->id;

        // Load projects assigned to this client
        $projects = Project::with(['team', 'user'])
            ->where('client_id', $clientId)
            ->get();

        // Debug
        // dd($clientId, $projects);

        // Totals
        $totalPrice = $projects->sum('price');
        $totalPaid = $projects->sum('paid_price');
        $totalRemaining = $projects->sum('remaining_price');

        return view('admin.pages.clients.dashboard', compact(
            'client',
            'projects',
            'totalPrice',
            'totalPaid',
            'totalRemaining'
        ));
    }


}