<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\AddUser;
use App\Models\Developer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::with('users')->get();

        // Fetch only users with role 'developer' who are present in Developer table
        $developerIds = Developer::pluck('add_user_id');
        $users = AddUser::where('role', 'developer')
                        ->whereIn('id', $developerIds)
                        ->get();

        $teamToEdit = null;
        if ($request->has('edit')) {
            $teamToEdit = Team::with('users')->findOrFail($request->get('edit'));
        }

        return view('admin.pages.team', compact('teams', 'users', 'teamToEdit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
            'users.*' => 'exists:add_users,id'
        ]);

        $team = Team::create(['name' => $validated['name']]);
        $team->users()->attach($validated['users']);

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
            'users.*' => 'exists:add_users,id'
        ]);

        $team->update(['name' => $validated['name']]);
        $team->users()->sync($validated['users']);

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->users()->detach();
        $team->delete();

        return back()->with('success', 'Team deleted successfully.');
    }

    public function getTeamUsers($teamId)
    {
        $team = Team::with('users')->findOrFail($teamId);
        return response()->json($team->users);
    }
}
