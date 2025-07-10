@extends('admin.layouts.main')

@section('content')
<div class="container my-4">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary">💻 Developers</h1>
    <a href="{{ route('developers.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Add Developer Details
    </a>
  </div>

  <!-- Success Alert -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Developers Table Card -->
  <div class="card border-0 shadow-sm">
    <div class="card-header text-white h4" style="background-color: rgb(2, 2, 100)">
      Developer List
    </div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-primary h5">
          <tr>
            <th>Name</th>
            <th>Skills</th>
            <th>Experience</th>
            <th>Work Type</th>
            <th>Salary</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        @forelse($developers as $developer)
          <tr>
            <td>{{ $developer->user->name ?? '-' }}</td>
            <td>{{ $developer->skill ?? '-' }}</td>
            <td>{{ $developer->experience ?? '-' }}</td>
            <td>
              @if($developer->part_time) <span class="badge bg-info text-white">Part Time</span> @endif
              @if($developer->full_time) <span class="badge bg-success ">Full Time</span> @endif
              @if($developer->internship) <span class="badge bg-warning text-white">Internship</span> @endif
              @if($developer->job) <span class="badge bg-primary text-white">Job</span> @endif
            </td>
            <td>${{ number_format($developer->salary, 2) }}</td>
            <td class="d-flex gap-2">
              <a href="{{ route('developers.show', $developer->id) }}" class="btn btn-sm btn-warning">View</a>
              <a href="{{ route('developers.edit', $developer->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('developers.destroy', $developer->id) }}" method="POST" onsubmit="return confirm('Delete this developer?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">No developers found.</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
