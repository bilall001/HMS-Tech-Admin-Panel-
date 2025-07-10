@extends('admin.layouts.main')

@section('content')
<div class="container my-5">

  <div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
      <h3 class="mb-0 text-white">➕ Add New User</h3>
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

      <form action="{{ route('add-users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
          <label class="form-label fw-bold">Name</label>
          <input type="text" name="name" class="form-control border-primary rounded-3" placeholder="Enter name" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold">Username</label>
          <input type="text" name="username" class="form-control border-primary rounded-3" placeholder="Enter username" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold">Email</label>
          <input type="email" name="email" class="form-control border-primary rounded-3" placeholder="Enter email" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold">Password</label>
          <input type="password" name="password" class="form-control border-primary rounded-3" placeholder="Enter password" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control border-primary rounded-3" placeholder="Confirm password" required>
        </div>

        <div class="mb-7">
          <label for="role" class="form-label fw-bold">Role</label>
          <select 
            name="role" 
            id="role" 
            class="form-select border-primary rounded-3"
            required
          style="transition: border-color .3s, box-shadow .3s; width: 100%; height: 40px; margin-bottom: 10px;"
            onfocus="this.style.borderColor='#020264'; this.style.boxShadow='0 0 0 0.25rem rgba(2, 2, 100, 0.25)';"
            onblur="this.style.borderColor='#0d6efd'; this.style.boxShadow='none';"
          >
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="developer">Developer</option>
            <option value="client">Client</option>
            <option value="team manager">Manager</option>
            <option value="business developer">Business Developer</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success px-4 py-2">
          <i class="bi bi-person-plus me-1"></i> Save User
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
