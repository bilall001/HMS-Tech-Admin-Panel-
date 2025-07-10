@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="page-title mb-0 text-primary fw-bold">Teams Management</h4>
        </div>
        <div class="col-md-6 text-md-right" >
            <a href="{{ route('admin.teams.index', ['add' => 1]) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> {{ isset($teamToEdit) ? 'Back' : 'Add Team' }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-white">All Teams</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Team Name</th>
                        <th>Members</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $index => $team)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $team->name }}</td>
                            <td>
                                @foreach($team->users as $user)
                                    <span class="badge bg-info text-dark">{{ $user->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.teams.index', ['edit' => $team->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="d-inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No teams found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add/Edit Modal --}}
    @if(isset($teamToEdit) || request('add') || $errors->any())
    <div class="modal show fade d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ isset($teamToEdit) ? route('admin.teams.update', $teamToEdit->id) : route('admin.teams.store') }}">
                @csrf
                @if(isset($teamToEdit)) @method('PUT') @endif
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">{{ isset($teamToEdit) ? 'Edit Team' : 'Add New Team' }}</h5>
                        <a href="{{ route('admin.teams.index') }}" class="btn-close btn-close-white"></a>
                    </div>
                    <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Please fix the following:</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Team Name *</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name', $teamToEdit->name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Choose Users *</label>
                            <div class="input-group">
                                <select class="form-select" id="userSelect">
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-secondary" id="addUserBtn">Add</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Selected Users</label>
                            <ul id="selectedUsersList" class="list-group">
                                @foreach(old('users', isset($teamToEdit) ? $teamToEdit->users->pluck('id')->toArray() : []) as $userId)
                                    @php $user = $users->find($userId); @endphp
                                    @if($user)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $user->name }}
                                            <input type="hidden" name="users[]" value="{{ $user->id }}">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-user">Remove</button>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> {{ isset($teamToEdit) ? 'Update' : 'Create' }}
                        </button>
                        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const addUserBtn = document.getElementById("addUserBtn");
            const userSelect = document.getElementById("userSelect");
            const selectedUsersList = document.getElementById("selectedUsersList");

            addUserBtn.addEventListener("click", function () {
                const userId = userSelect.value;
                const userName = userSelect.options[userSelect.selectedIndex].dataset.name;

                if (!userId) return;

                // Avoid duplicates
                if ([...selectedUsersList.querySelectorAll("input")].some(input => input.value == userId)) return;

                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.innerHTML = `${userName}
                    <input type="hidden" name="users[]" value="${userId}">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-user">Remove</button>`;

                selectedUsersList.appendChild(li);
                userSelect.value = '';
            });

            selectedUsersList.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-user")) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
    @endif
</div>
@endsection
