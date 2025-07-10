@extends('admin.layouts.main')

@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-primary">👥 All Users</h1>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('add-users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New
        </a>
    @endif
</div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header text-white h4" style="background-color: rgb(2, 2, 100)">
            User List
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-primary h5">
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                           <td>
          {{-- ✅ Only Admin can Edit/Delete --}}
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('add-users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

            <form action="{{ route('add-users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
          @else
            <span>-</span> {{-- Managers see dash only --}}
          @endif
        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
