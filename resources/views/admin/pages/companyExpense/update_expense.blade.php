@extends('admin.layouts.main')

@section('content')
<div class="container my-5">

  <h1 class="h3 text-primary mb-4">
    ✏️ Edit Company Expense
  </h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Whoops!</strong> Please fix the following issues:
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm border-0">
    <div class="card-body">
      <form action="{{ route('companyExpense.update', $companyExpense) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
          <input 
            type="text" 
            name="title" 
            class="form-control border-primary" 
            value="{{ old('title', $companyExpense->title) }}" 
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Description</label>
          <textarea name="description" class="form-control border-primary" rows="3">{{ old('description', $companyExpense->description) }}</textarea>
        </div>

        <div class="row mb-3">
          <div class="col-md-4 mb-3 mb-md-0">
            <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
            <input 
              type="number" 
              name="amount" 
               
              class="form-control border-primary" 
              value="{{ old('amount', $companyExpense->amount) }}" 
              required
            >
          </div>
          <div class="col-md-4 mb-3 mb-md-0">
            <label class="form-label fw-bold">Currency</label>
            <input 
              type="text" 
              name="currency" 
              class="form-control border-primary" 
              value="{{ old('currency', $companyExpense->currency ?? 'PKR') }}"
            >
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">Category</label>
            <input 
              type="text" 
              name="category" 
              class="form-control border-primary" 
              value="{{ old('category', $companyExpense->category) }}"
            >
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
          <input 
            type="date" 
            name="date" 
            class="form-control border-primary" 
            value="{{ old('date', $companyExpense->date) }}" 
            required
          >
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold">Receipt (optional)</label>
          <input 
            type="file" 
            name="receipt_file" 
            class="form-control border-primary"
          >
          @if($companyExpense->receipt_file)
            <p class="mt-2 mb-0">
              📎 <strong>Current Receipt:</strong> 
              <a href="{{ asset('storage/' . $companyExpense->receipt_file) }}" target="_blank" class="text-decoration-underline text-primary fw-semibold">
                View Receipt
              </a>
            </p>
          @endif
        </div>

        <div class="d-flex align-items-center">
          <button type="submit" class="btn btn-primary shadow-sm me-2">
            <i class="bi bi-check-circle me-1"></i> Update Expense
          </button>
          <a href="{{ route('companyExpense.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Cancel
          </a>
        </div>

      </form>
    </div>
  </div>

</div>
@endsection
