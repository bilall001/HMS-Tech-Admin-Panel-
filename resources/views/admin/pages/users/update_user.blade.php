@extends('admin.layouts.main')

@section('content')
<div class="container my-4">
  <h1 class="h3 mb-4 text-primary">✏️ Edit User</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('add-users.update', $addUser->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" value="{{ $addUser->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" value="{{ $addUser->username }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" value="{{ $addUser->email }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>New Password (optional)</label>
      <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-select" required>
        <option value="">-- Select Role --</option>
        @foreach(['admin', 'developer', 'client', 'team manager', 'business developer'] as $role)
          <option value="{{ $role }}" {{ $addUser->role === $role ? 'selected' : '' }}>
            {{ ucfirst($role) }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="bi bi-save"></i> Update User
    </button>
  </form>
</div>
@endsection
