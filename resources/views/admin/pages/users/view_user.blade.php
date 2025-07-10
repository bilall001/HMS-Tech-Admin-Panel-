@extends('admin.layouts.main')

@section('content')
<div class="container my-4">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary">👤 View User</h1>
    <a href="{{ route('add-users.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

  <!-- User Details Card -->
  <div class="card border-0 shadow-sm">
    <div class="card-header text-white h4" style="background-color: rgb(2, 2, 100)">
      User Information
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label fw-bold">Name:</label>
        <p class="form-control-plaintext">{{ $user->name }}</p>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Username:</label>
        <p class="form-control-plaintext">{{ $user->username }}</p>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Email:</label>
        <p class="form-control-plaintext">{{ $user->email }}</p>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Role:</label>
        <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
      </div>
    </div>
  </div>

</div>
@endsection
