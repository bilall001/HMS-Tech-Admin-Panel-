<?php

namespace App\Http\Controllers\Admin;

use App\Models\AddUser;
use App\Models\Developer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $developers = Developer::with('user')->latest()->get();
    return view('admin.pages.developers.all_developer', compact('developers'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Get all users with role developer
    $developers = AddUser::where('role', 'developer')->get();
    return view('admin.pages.developers.add_developer', compact('developers'));
}

    /**
     * Store a newly created resource in storage.
     */
// In your DeveloperController.php




public function store(Request $request)
{
    $data = $request->validate([
        'add_user_id' => 'required|exists:add_users,id',
        'profile_image' => 'nullable|image',
        'cnic_front' => 'nullable|image',
        'cnic_back' => 'nullable|image',
        'contract_file' => 'nullable',
        'skill' => 'nullable|string',
        'experience' => 'nullable|string',
        'salary' => 'nullable|numeric',
    ]);

    // ✅ Handle booleans like you do in update()
    $data['part_time'] = $request->has('part_time');
    $data['full_time'] = $request->has('full_time');
    $data['internship'] = $request->has('internship');
    $data['job'] = $request->has('job');

    // File upload logic stays the same...
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/developers'), $filename);
        $data['profile_image'] = 'uploads/developers/'.$filename;
    }

    if ($request->hasFile('cnic_front')) {
        $file = $request->file('cnic_front');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/developers'), $filename);
        $data['cnic_front'] = 'uploads/developers/'.$filename;
    }

    if ($request->hasFile('cnic_back')) {
        $file = $request->file('cnic_back');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/developers'), $filename);
        $data['cnic_back'] = 'uploads/developers/'.$filename;
    }

    if ($request->hasFile('contract_file')) {
        $file = $request->file('contract_file');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/developers'), $filename);
        $data['contract_file'] = 'uploads/developers/'.$filename;
    }

    Developer::create($data);

    return redirect()->route('developers.index')->with('success', 'Developer created!');
}







    /**
     * Display the specified resource.
     */
   public function show(string $id)
    {
        $developer = Developer::with('user')->findOrFail($id);
        return view('admin.pages.developers.show_developer', compact('developer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $developer = Developer::findOrFail($id);
    $developers = AddUser::where('role', 'developer')->get();
    return view('admin.pages.developers.update_developer', compact('developer', 'developers'));
}

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
{
    $data = $request->validate([
        'add_user_id'   => 'required|exists:add_users,id',
        'skill'         => 'nullable|string',
        'experience'    => 'nullable|string',
        'salary'        => 'nullable|numeric',
        'profile_image' => 'nullable|image',
        'cnic_front'    => 'nullable|image',
        'cnic_back'     => 'nullable|image',
        'contract_file' => 'nullable|file',
    ]);

    $developer = Developer::findOrFail($id);

    // Handle booleans
    $data['part_time'] = $request->has('part_time');
    $data['full_time'] = $request->has('full_time');
    $data['internship'] = $request->has('internship');
    $data['job'] = $request->has('job');

    $uploadPath = public_path('uploads/developers');

    // Make sure upload path exists
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Handle file fields
    foreach (['profile_image', 'cnic_front', 'cnic_back', 'contract_file'] as $field) {
        if ($request->hasFile($field)) {
            // Delete old file if exists
            if ($developer->$field && file_exists(public_path($developer->$field))) {
                unlink(public_path($developer->$field));
            }

            $file = $request->file($field);
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $data[$field] = 'uploads/developers/'.$filename;
        }
    }

    $developer->update($data);

    return redirect()->route('developers.index')->with('success', 'Developer details updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    $developer = Developer::findOrFail($id);

    // Delete uploaded files if they exist
    foreach (['profile_image', 'cnic_front', 'cnic_back', 'contract_file'] as $field) {
        if ($developer->$field && file_exists(public_path($developer->$field))) {
            unlink(public_path($developer->$field));
        }
    }

    // Delete the developer record
    $developer->delete();

    return redirect()->route('developers.index')->with('success', 'Developer deleted successfully!');
}

}