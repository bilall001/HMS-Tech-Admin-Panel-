@extends('admin.layouts.main')

@section('content')
<div class="container my-5">

    <h1 class="h3 text-primary mb-4">
        <i class="bi bi-eye me-2"></i> 📄 View Company Expense
    </h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ $companyExpense->title }}</h4>

            <p><strong>Description:</strong><br>
                {{ $companyExpense->description ?? 'N/A' }}</p>

            <p><strong>Amount:</strong>
                <span class="badge bg-success">
                    {{ number_format($companyExpense->amount, 2) }} {{ $companyExpense->currency }}
                </span>
            </p>

            <p><strong>Category:</strong> {{ $companyExpense->category ?? 'N/A' }}</p>

            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($companyExpense->date)->format('M d, Y') }}</p>

          <div class="mb-3">
    <strong>Receipt:</strong><br>
    @if($companyExpense->receipt_file)
    <a href="{{ asset($companyExpense->receipt_file) }}" target="_blank"
        class="btn btn-outline-primary btn-sm">
        <i class="bi bi-file-earmark-text"></i> View Receipt
    </a>
    @else
    <span class="text-muted">No receipt uploaded.</span>
    @endif
</div>

            <a href="{{ route('companyExpense.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Expenses
            </a>
        </div>
    </div>

</div>
@endsection