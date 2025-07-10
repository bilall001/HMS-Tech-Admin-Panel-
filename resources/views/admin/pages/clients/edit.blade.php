@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <h2>Edit Client</h2>
    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ $client->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ $client->email }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" value="{{ $client->phone }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gender:</label>
            <select name="gender" class="form-control" required>
                <option value="male" {{ $client->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $client->gender == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $client->gender == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection