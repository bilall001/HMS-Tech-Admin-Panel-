@extends('admin.layouts.main')

@section('content')
<div class="container my-4">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary">💻 Developer Details</h1>
    <a href="{{ route('developers.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Back to List
    </a>
  </div>

  <!-- Developer Details Card -->
  <div class="card border-0 shadow-sm">
    <div class="card-header text-white h4" style="background-color: rgb(2, 2, 100)">
      {{ $developer->user->name ?? 'Developer' }}
    </div>
    <div class="card-body">
      <p><strong>Name:</strong> {{ $developer->user->name ?? '-' }}</p>
      <p><strong>Username:</strong> {{ $developer->user->username ?? '-' }}</p>
      <p><strong>Email:</strong> {{ $developer->user->email ?? '-' }}</p>
      <p><strong>Skills:</strong> {{ $developer->skill ?? '-' }}</p>
      <p><strong>Experience:</strong> {{ $developer->experience ?? '-' }}</p>
      <p><strong>Work Type:</strong>
        @if($developer->part_time) <span class="badge bg-info">Part Time</span> @endif
        @if($developer->full_time) <span class="badge bg-success">Full Time</span> @endif
        @if($developer->internship) <span class="badge bg-warning text-dark">Internship</span> @endif
        @if($developer->job) <span class="badge bg-primary">Job</span> @endif
      </p>
      <p><strong>Salary:</strong> 
        @if($developer->salary)
          ${{ number_format($developer->salary, 2) }}
        @else
          -
        @endif
      </p>

      <!-- Images and Files -->
      <div class="row mt-4">
        @if($developer->profile_image)
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-header fw-bold">Profile Image</div>
            <img src="{{ asset($developer->profile_image) }}" alt="Profile Image"  class="img-fluid">
          </div>
        </div>
        @endif

        @if($developer->cnic_front)
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-header fw-bold">CNIC Front</div>
            <img src="{{ asset($developer->cnic_front) }}" alt="CNIC Front"  class="img-fluid">
          </div>
        </div>
        @endif

        @if($developer->cnic_back)
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-header fw-bold">CNIC Back</div>
            <img src="{{ asset($developer->cnic_back) }}" alt="CNIC Back" class="img-fluid">
          </div>
        </div>
        @endif
      </div>

      @if($developer->contract_file)
      <div class="mt-3">
        <strong>Contract File:</strong> 
        <a href="{{ asset($developer->contract_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
          View / Download
        </a>
      </div>
      @endif

      <!-- Actions -->
      <div class="d-flex gap-2 mt-4">
        <a href="{{ route('developers.edit', $developer->id) }}" class="btn btn-primary">
          <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('developers.destroy', $developer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this developer?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Delete
          </button>
        </form>
      </div>

    </div>
  </div>

</div>
@endsection
