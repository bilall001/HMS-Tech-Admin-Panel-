@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="page-title">Projects</h4>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('admin.projects.index', ['add' => true]) }}" class="btn btn-primary">Add Project</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">All Projects</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>File</th>
                        <th>Team</th>
                        <th>Developer</th>
                        <th>Total Price</th>
                        <th>Paid Price</th>
                        <th>Remaining Price</th>
                        <th>Duration</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Developer End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                           <td>
    @if($project->file)
        <a href="{{ asset('storage/' . $project->file) }}" target="_blank">View</a>
    @else
        N/A
    @endif
</td>
                            <td>{{ $project->team->name ?? '-' }}</td>
                            <td>{{ $project->user->name ?? '-' }}</td>
                            <td>${{ number_format($project->price, 2) }}</td>
                            <td>${{ number_format($project->paid_price, 2) }}</td>
                            <td>
                                @if($project->remaining_price >= 0)
                                    ${{ number_format($project->remaining_price, 2) }}
                                @else
                                    <span class="text-danger">Overpaid</span>
                                @endif
                            </td>
                            <td>{{ $project->duration }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date }}</td>
                            <td>{{ $project->developer_end_date }}</td>
                          <td>
    <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-primary">View</a>
    <a href="{{ route('admin.projects.index', ['edit_id' => $project->id]) }}" class="btn btn-sm btn-info">Edit</a>
    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
    </form>
</td>

                        </tr>
                    @empty
                        <tr><td colspan="12">No projects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add/Edit Modal --}}
    @if($showModal)
    <div class="modal show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ $editProject ? route('admin.projects.update', $editProject) : route('admin.projects.store') }}" enctype="multipart/form-data">
                @csrf
                @if($editProject) @method('PUT') @endif
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editProject ? 'Edit Project' : 'Add Project' }}</h5>
                        <a href="{{ route('admin.projects.index') }}" class="close">&times;</a>
                    </div>
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input name="title" class="form-control" value="{{ old('title', $editProject->title ?? '') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Total Price</label>
                                <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $editProject->price ?? '') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Paid Price</label>
                                <input name="paid_price" type="number" step="0.01" class="form-control" value="{{ old('paid_price', $editProject->paid_price ?? 0) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Remaining Price</label><br>
                                <strong id="remaining-display">$0.00</strong>
                                <small class="text-muted d-block">Automatically calculated</small>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
    <label>Client</label>
    <select name="client_id" class="form-control">
        <option value="">Select Client</option>
        @foreach($clients as $client)
            <option value="{{ $client->id }}" {{ old('client_id', $editProject->client_id ?? '') == $client->id ? 'selected' : '' }}>
                {{ $client->name }}
            </option>
        @endforeach
    </select>
</div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Duration</label>
                                <input name="duration" class="form-control" value="{{ old('duration', $editProject->duration ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>File</label>
                                <input type="file" name="file" class="form-control">
                                @if($editProject && $editProject->file)
                                    <small>Current File: <a href="{{ asset('storage/' . $editProject->file) }}" target="_blank">View</a></small>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $editProject->start_date ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $editProject->end_date ?? '') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Developer End Date</label>
                                <input type="date" name="developer_end_date" class="form-control" value="{{ old('developer_end_date', $editProject->developer_end_date ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="team" {{ old('type', $editProject->type ?? '') == 'team' ? 'selected' : '' }}>Team</option>
                                    <option value="individual" {{ old('type', $editProject->type ?? '') == 'individual' ? 'selected' : '' }}>Individual</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6" id="team-group">
                                <label>Team</label>
                                <select name="team_id" class="form-control">
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id', $editProject->team_id ?? '') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="user-group">
                                <label>Developer</label>
                                <select name="user_id" class="form-control">
                                    <option value="">Select Developer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $editProject->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{ $editProject ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateRemaining() {
            const total = parseFloat(document.querySelector('[name="price"]').value) || 0;
            const paid = parseFloat(document.querySelector('[name="paid_price"]').value) || 0;
            const remaining = Math.max(total - paid, 0);
            document.getElementById('remaining-display').innerText = '$' + remaining.toFixed(2);
        }

        document.querySelector('[name="price"]').addEventListener('input', calculateRemaining);
        document.querySelector('[name="paid_price"]').addEventListener('input', calculateRemaining);

        window.onload = function() {
            toggleFields();
            calculateRemaining();
        }

        function toggleFields() {
            const type = document.getElementById('type')?.value;
            document.getElementById('team-group').style.display = (type === 'team') ? 'block' : 'none';
            document.getElementById('user-group').style.display = (type === 'individual') ? 'block' : 'none';
        }

        document.getElementById('type')?.addEventListener('change', toggleFields);
    </script>
    @endif
</div>
@endsection
