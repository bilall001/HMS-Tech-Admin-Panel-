<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectSchedule;
use Illuminate\Http\Request;

class ProjectScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = ProjectSchedule::orderBy('id', 'desc')->get();
        return view('admin.pages.projectSchedule.all_project_schedule', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.projectSchedule.add_project_schedule');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'status' => 'required'
        ]);

        $schedule = ProjectSchedule::create($data);
        return redirect()->route('projectSchedule.index')->with('success', 'Schedules are created successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editSchedule = ProjectSchedule::find($id);
        return view('admin.pages.projectSchedule.update_project_schedule', compact('editSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateSchedule = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'status' => 'required'
        ]); 

        ProjectSchedule::where('id', $id)->update($updateSchedule);
        return redirect()->route('projectSchedule.index')->with('success', 'Schedules are Updated  successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProjectSchedule::where('id', $id)->delete();
        return redirect()->route('projectSchedule.index')->with('success', 'Schedules are Deleted successfuly');
    }
}