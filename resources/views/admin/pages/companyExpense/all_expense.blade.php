@extends('admin.layouts.main')

@section('content')
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary mb-0">
      <i class="bi bi-receipt-cutoff me-2 text-white"></i> 📊 Company Expenses
    </h1>
    <a href="{{ route('companyExpense.create') }}" class="btn btn-success shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Add Expense
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle shadow-sm">
      <thead class="bg-dark text-white">
        <tr>
          <th class="text-white">Title</th>
          <th class="text-white">Amount</th>
          <th class="text-white">Currency</th>
          <th class="text-white">Category</th>
          <th class="text-white">Date</th>
          <th class="text-center text-white">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($expenses as $expense)
        <tr>
          <td>{{ $expense->title }}</td>
          <td><span class="badge bg-light text-dark">{{ number_format($expense->amount, 2) }}</span></td>
          <td>{{ $expense->currency }}</td>
          <td>{{ $expense->category }}</td>
          <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
          <td class="text-center">
            <a href="{{ route('companyExpense.show', $expense) }}" class="btn btn-info btn-sm" title="View full details">
              <i class="bi bi-eye"></i> View
            </a>
            <a href="{{ route('companyExpense.edit', $expense) }}" class="btn btn-warning btn-sm">
              <i class="bi bi-pencil-square"></i> Edit
            </a>
            <form action="{{ route('companyExpense.destroy', $expense) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this expense?');">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Delete
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted">No expenses found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection
