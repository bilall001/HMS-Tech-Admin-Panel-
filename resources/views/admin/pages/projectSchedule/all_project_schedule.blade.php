@extends('admin.layouts.main') 

@section('content')
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 text-primary mb-0">
      📅 All Projects Schedule
    </h2>
    <a href="{{ route('projectSchedule.create') }}" class="btn btn-success shadow-sm">
      <i class="bi bi-plus-circle"></i> Add New
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
    </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped  mb-0">
        <thead class="table-primary">
          <tr>
            <th scope="col">#ID</th>
            <th scope="col">Title</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($schedules as $schedule)
            <tr>
    <td>{{ $loop->iteration }}</td>
              <td>{{ $schedule->title }}</td>
              <td>{{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }}</td>
              <td>
                @if($schedule->status === 'completed')
                  <span class="badge bg-success">Completed</span>
                @elseif($schedule->status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($schedule->status) }}</span>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('projectSchedule.edit', $schedule->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('projectSchedule.destroy', $schedule->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this Schedule?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">No schedules found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
