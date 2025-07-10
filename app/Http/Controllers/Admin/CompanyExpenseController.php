<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyExpense;

class CompanyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = CompanyExpense::latest()->get();
        return view('admin.pages.companyExpense.all_expense', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.companyExpense.add_expense');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'amount' => 'required|numeric',
            'currency' => 'nullable',
            'category' => 'nullable',
            'date' => 'required|date',
            'receipt_file' => 'required',
        ]);

        $data = $request->only([
            'title',
            'description',
            'amount',
            'currency',
            'category',
            'date',
        ]);

        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/expenses/receipts');

            // Make sure directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['receipt_file'] = 'uploads/expenses/receipts/' . $filename;
        }

        CompanyExpense::create($data);

        return redirect()->route('companyExpense.index')->with('success', 'Expense created successfully!');
    }

    public function show(CompanyExpense $companyExpense)
{
    return view('admin.pages.companyExpense.show_expense', compact('companyExpense'));
}
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyExpense $companyExpense)
    {
        return view('admin.pages.companyExpense.update_expense', compact('companyExpense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyExpense $companyExpense)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'amount' => 'required|numeric',
            'currency' => 'nullable',
            'category' => 'nullable',
            'date' => 'required|date',
            'receipt_file' => 'nullable',
        ]);

        $data = $request->only([
            'title',
            'description',
            'amount',
            'currency',
            'category',
            'date',
        ]);

        if ($request->hasFile('receipt_file')) {
            // Delete old file if exists
            $oldFile = public_path($companyExpense->receipt_file);
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }

            $file = $request->file('receipt_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/expenses/receipts');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['receipt_file'] = 'uploads/expenses/receipts/' . $filename;
        }

        $companyExpense->update($data);

        return redirect()->route('companyExpense.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyExpense $companyExpense)
    {
        if ($companyExpense->receipt_file) {
            $oldFile = public_path($companyExpense->receipt_file);
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $companyExpense->delete();

        return redirect()->route('companyExpense.index')->with('success', 'Expense deleted successfully!');
    }
}