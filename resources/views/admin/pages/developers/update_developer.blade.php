@extends('admin.layouts.main')

@section('content')
<div class="container my-4">
  <h1 class="h3 text-primary">Update Developer Details</h1>

  <form action="{{ route('developers.update', $developer->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- User selection -->
    <div class="mb-3">
      <label>Select Developer User</label>
      <select name="add_user_id" class="form-select" required>
        <option value="">-- Select Developer --</option>
        @foreach($developers as $dev)
          <option value="{{ $dev->id }}" {{ $developer->add_user_id == $dev->id ? 'selected' : '' }}>
            {{ $dev->name }} ({{ $dev->username }})
          </option>
        @endforeach
      </select>
    </div>

    <!-- Skill -->
    <div class="mb-3">
      <label>Skills</label>
      <input type="text" name="skill" class="form-control" value="{{ $developer->skill }}">
    </div>

    <!-- Experience -->
    <div class="mb-3">
      <label>Experience</label>
      <input type="text" name="experience" class="form-control" value="{{ $developer->experience }}">
    </div>

    <!-- Work type -->
    <div class="mb-3">
      <label>Work Type</label><br>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="part_time" value="1" class="form-check-input" {{ $developer->part_time ? 'checked' : '' }}>
        <label class="form-check-label">Part Time</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="full_time" value="1" class="form-check-input" {{ $developer->full_time ? 'checked' : '' }}>
        <label class="form-check-label">Full Time</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="internship" value="1" class="form-check-input" {{ $developer->internship ? 'checked' : '' }}>
        <label class="form-check-label">Internship</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="checkbox" name="job" value="1" class="form-check-input" {{ $developer->job ? 'checked' : '' }}>
        <label class="form-check-label">Job</label>
      </div>
    </div>

    <!-- Salary -->
    <div class="mb-3">
      <label>Salary</label>
      <input type="number" name="salary" step="0.01" class="form-control" value="{{ $developer->salary }}">
    </div>

    <!-- Profile Image -->
    <div class="mb-3">
      <label>Profile Image</label>
      <input type="file" name="profile_image" class="form-control">
      @if($developer->profile_image)
        <div class="mt-2">
          <img src="{{ asset($developer->profile_image) }}" alt="Profile Image" width="150">
        </div>
      @endif
    </div>

    <!-- CNIC Front -->
    <div class="mb-3">
      <label>CNIC Front Image</label>
      <input type="file" name="cnic_front" class="form-control">
      @if($developer->cnic_front)
        <div class="mt-2">
          <img src="{{ asset($developer->cnic_front) }}" alt="CNIC Front" width="150">
        </div>
      @endif
    </div>

    <!-- CNIC Back -->
    <div class="mb-3">
      <label>CNIC Back Image</label>
      <input type="file" name="cnic_back" class="form-control">
      @if($developer->cnic_back)
        <div class="mt-2">
          <img src="{{ asset($developer->cnic_back) }}" alt="CNIC Back" width="150">
        </div>
      @endif
    </div>

    <!-- Contract File -->
    <div class="mb-3">
      <label>Contract File</label>
      <input type="file" name="contract_file" class="form-control">
      @if($developer->contract_file)
        <div class="mt-2">
          <a href="{{ asset($developer->contract_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
            View Current Contract
          </a>
        </div>
      @endif
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary">Update Developer</button>
  </form>
</div>
@endsection
