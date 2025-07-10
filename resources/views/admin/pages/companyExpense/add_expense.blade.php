@extends('admin.layouts.main')

@section('content')
<div class="container my-5">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0 text-white"><i class="bi bi-cash-stack me-2 "></i>➕ Add Company Expense</h5>
    </div>
    <div class="card-body">

      {{-- Validation Errors --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('companyExpense.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-bold h6">Expense Title</label>
          <input type="text" name="title" class="form-control border-primary-subtle shadow-sm" placeholder="Enter expense title" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold h6">Description</label>
          <textarea name="description" rows="3" class="form-control border-primary-subtle shadow-sm" placeholder="Optional details..."></textarea>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold h6">Amount</label>
            <input type="number" name="amount"  class="form-control border-primary-subtle shadow-sm" placeholder="0.00" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold h6">Currency</label>
            <input type="text" name="currency" value="PKR" class="form-control border-primary-subtle shadow-sm">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold h6">Category</label>
            <input type="text" name="category" class="form-control border-primary-subtle shadow-sm" placeholder="e.g., Rent, Supplies">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold h6">Date</label>
          <input type="date" name="date" class="form-control border-primary-subtle shadow-sm" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold h6">Receipt File (optional)</label>
          <input type="file" name="receipt_file" class="form-control border-primary-subtle shadow-sm">
        </div>

        <button class="btn btn-success">
          <i class="bi bi-save me-1"></i> Save Expense
        </button>
        <a href="{{ route('companyExpense.index') }}" class="btn btn-secondary ms-2">
          <i class="bi bi-arrow-left"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
