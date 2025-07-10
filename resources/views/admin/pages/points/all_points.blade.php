@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">My Points</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Select Team --}}
    <div class="form-group">
        <label><strong>Select Team</strong></label>
        <select name="team_id" id="teamSelect" class="form-control">
            <option value="">-- Select Team --</option>
            @forelse($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @empty
                <option disabled>No teams available</option>
            @endforelse
        </select>
    </div>

    {{-- Select Developer --}}
    <div class="form-group">
        <label><strong>Select Developer</strong></label>
        <select name="developer_id" id="developerSelect" class="form-control">
            <option value="">-- Select Developer --</option>
            @forelse($developers as $dev)
                <option value="{{ $dev->id }}">{{ $dev->name }}</option>
            @empty
                <option disabled>No developers available</option>
            @endforelse
        </select>
    </div>

    {{-- Projects Table --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Projects</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Project Title</th>
                        <th>Project File</th>
                        <th>End Date</th>
                        <th>Developer</th>
                    </tr>
                </thead>
                <tbody id="projectsTableBody">
                    <tr><td colspan="4" class="text-center">Please select a team or developer.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Upload Form --}}
    <div class="card mt-5">
        <div class="card-header bg-success text-white">Upload Submission</div>
        <div class="card-body">
            <form action="{{ route('developer.points.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="team_id" id="selectedTeamId">

                <div class="form-group">
                    <label>Select Project</label>
                    <select name="project_id" id="projectSelect" class="form-control" required>
                        <option value="">-- Select Project --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Video Link</label>
                    <input type="url" name="video_link" class="form-control" placeholder="https://">
                </div>

                <div class="form-group">
                    <label>Or Upload Video File</label>
                    <input type="file" name="video_file" class="form-control">
                </div>

                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    {{-- Submitted Points History --}}
    <div class="card mt-5">
        <div class="card-header bg-info text-white">My Submitted Points</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr class="bg-light">
                        <th>Project</th>
                        <th>Team</th>
                        <th>Developer</th>
                        <th>Link/File</th>
                        <th>Uploaded At</th>
                        <th>Points</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($points as $point)
                        <tr>
                            <td>{{ $point->project->title ?? '-' }}</td>
                            <td>{{ $point->team->name ?? '-' }}</td>
                            <td>{{ $point->user->name ?? '-' }}</td>
                            <td>
                                @if($point->video_link)
                                    <a href="{{ $point->video_link }}" target="_blank">Link</a>
                                @elseif($point->video_file)
                                    <a href="{{ asset('storage/'.$point->video_file) }}" target="_blank">File</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $point->uploaded_at }}</td>
                            <td>
                                <span class="badge {{ $point->points >= 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $point->points }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('developer.points.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Delete this submission?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No submissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- JS: Fetch & Render Projects --}}
<script>
const tbody = document.getElementById('projectsTableBody');
const projectSelect = document.getElementById('projectSelect');

document.getElementById('teamSelect').addEventListener('change', function() {
    const teamId = this.value;
    document.getElementById('selectedTeamId').value = teamId;
    document.getElementById('developerSelect').value = '';

    if (!teamId) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Please select a team.</td></tr>';
        projectSelect.innerHTML = '<option value="">-- Select Project --</option>';
        return;
    }

    fetch(`/points/get-projects?team_id=${teamId}`)
        .then(res => res.json())
        .then(data => renderProjects(data))
        .catch(err => console.error(err));
});

document.getElementById('developerSelect').addEventListener('change', function() {
    const devId = this.value;
    document.getElementById('teamSelect').value = '';
    document.getElementById('selectedTeamId').value = '';

    if (!devId) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Please select a developer.</td></tr>';
        projectSelect.innerHTML = '<option value="">-- Select Project --</option>';
        return;
    }

    fetch(`/points/get-projects?developer_id=${devId}`)
        .then(res => res.json())
        .then(data => renderProjects(data))
        .catch(err => console.error(err));
});

function renderProjects(data) {
    if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No projects found.</td></tr>';
        projectSelect.innerHTML = '<option value="">-- Select Project --</option>';
    } else {
        tbody.innerHTML = '';
        projectSelect.innerHTML = '<option value="">-- Select Project --</option>';

        data.forEach(project => {
            const fileLink = project.file
                ? `<a href="/storage/${project.file}" target="_blank" class="btn btn-sm btn-outline-primary">View File</a>`
                : `<span class="text-muted">N/A</span>`;

            const developerName = project.user ? project.user.name : '-';

            tbody.innerHTML += `
                <tr>
                    <td>${project.title}</td>
                    <td>
                      <a href="/admin/projects/${project.id}" target="_blank" class="btn btn-sm btn-outline-info">
                        View Details
                      </a>
                    </td>
                    <td>${project.end_date ?? '-'}</td>
                    <td>${developerName}</td>
                </tr>
            `;

            projectSelect.innerHTML += `<option value="${project.id}">${project.title}</option>`;
        });
    }
}
</script>
@endsection
