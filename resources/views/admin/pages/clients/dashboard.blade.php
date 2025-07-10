@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Welcome, {{ $client->name }}</h1>

    <h2>My Projects</h2>

    @if ($projects->count())
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Assigned To</th>
                    <th>Total Price</th>
                    <th>Paid Price</th>
                    <th>Remaining Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ ucfirst($project->type) }}</td>
                        <td>
                            @if ($project->type === 'team' && $project->team)
                                Team: {{ $project->team->name }}
                            @elseif ($project->type === 'individual' && $project->user)
                                Developer: {{ $project->user->name }}
                            @else
                                Not Assigned
                            @endif
                        </td>
                        <td>${{ number_format($project->price, 2) }}</td>
                        <td>${{ number_format($project->paid_price, 2) }}</td>
                        <td>${{ number_format($project->remaining_price, 2) }}</td>
                    </tr>
                @endforeach

                <!-- Totals Row -->
                <tr style="font-weight: bold; background: #f0f0f0;">
                    <td colspan="3" style="text-align: right;">Totals:</td>
                    <td>${{ number_format($totalPrice, 2) }}</td>
                    <td>${{ number_format($totalPaid, 2) }}</td>
                    <td>${{ number_format($totalRemaining, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 20px;"><strong>Total Projects:</strong> {{ $projects->count() }}</p>
    @else
        <p>No projects found.</p>
    @endif
</div>
@endsection
