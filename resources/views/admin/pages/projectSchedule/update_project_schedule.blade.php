@extends('admin.layouts.main')

@section('content')
<div class="container my-5">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0 text-white"><i class="bi bi-cash-stack me-2 "></i>➕Update Project Schedule</h5>
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

      <form action="{{ route('projectSchedule.update', $editSchedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label fw-bold h6">Schedule Title</label>
          <input type="text" name="title" value="{{ $editSchedule->title }}" class="form-control border-primary-subtle shadow-sm" placeholder="Enter schedule title" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold h6">Date</label>
          <input type="date" name="date" value="{{ $editSchedule->date }}" class="form-control border-primary-subtle shadow-sm" required>
        </div>

        <div class="mb-3">
             <label class="form-label fw-semibold h6">Select Project Schedule</label>
             <br>
                <select name="status"  class="form-select" aria-label="Default select example" id="">
                    <option selected value="{{ $editSchedule->status }}" > Select Schedule Status </option>
                    <option value="deliver">Deliver</option>
                    <option value="pending">Pending</option>
                    <option value="complete">Complete</option>
                </select>
        </div>
       
        <button class="btn btn-success">
          <i class="bi bi-save me-1"></i> Update Schedule
        </button>
        <a href="{{ route('projectSchedule.index') }}" class="btn btn-secondary ms-2">
          <i class="bi bi-arrow-left"></i> Cancel
        </a>
      </form>
    </div>
  </div>
</div>
@endsection
