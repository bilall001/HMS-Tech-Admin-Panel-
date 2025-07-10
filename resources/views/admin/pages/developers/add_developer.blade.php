@extends('admin.layouts.main')

@section('content')
<div class="container my-4">
  <h1 class="h3 text-primary">Add Developer Details</h1>

<form action="{{ route('developers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label>Select Developer User</label>
      <select name="add_user_id" class="form-select" required>
        <option value="">-- Select Developer --</option>
        @foreach($developers as $dev)
          <option value="{{ $dev->id }}">{{ $dev->name }} ({{ $dev->username }})</option>
        @endforeach
      </select>
    </div>

    {{-- new --}}
<div class="mb-3">
    <label class="form-label">Profile Image</label>
    <input type="file" name="profile_image" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">CNIC Front</label>
    <input type="file" name="cnic_front" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">CNIC Back</label>
    <input type="file" name="cnic_back" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Contract File</label>
    <input type="file" name="contract_file" class="form-control">
  </div>
    {{-- end --}}

    <div class="mb-3">
      <label>Skills</label>
      <input type="text" name="skill" class="form-control">
    </div>

    <div class="mb-3">
      <label>Experience</label>
      <input type="text" name="experience" class="form-control">
    </div>

    <div class="mb-3">
      <label>Work Type</label><br>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="part_time" value="1" class="form-check-input">
        <label class="form-check-label">Part Time</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="full_time" value="1" class="form-check-input">
        <label class="form-check-label">Full Time</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="internship" value="1" class="form-check-input">
        <label class="form-check-label">Internship</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="job" value="1" class="form-check-input">
        <label class="form-check-label">Job</label>
      </div>
    </div>

    <div class="mb-3">
      <label>Salary</label>
      <input type="number" name="salary" step="0.01" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save Developer</button>
  </form>
</div>
@endsection
