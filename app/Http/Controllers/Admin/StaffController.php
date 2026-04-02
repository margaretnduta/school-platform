<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::latest()->paginate(15);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:staff,email',
            'gender'          => 'required|in:male,female',
            'role'            => 'required',
            'joining_date'    => 'required|date',
            'employment_type' => 'required',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $staffNumber = 'STF-' . strtoupper(substr($request->first_name, 0, 2)) . '-' . date('Y') . '-' . str_pad(Staff::count() + 1, 4, '0', STR_PAD_LEFT);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/staff', 'public');
        }

        Staff::create([
            'staff_number'    => $staffNumber,
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'gender'          => $request->gender,
            'date_of_birth'   => $request->date_of_birth,
            'national_id'     => $request->national_id,
            'role'            => $request->role,
            'department'      => $request->department,
            'subject'         => $request->subject,
            'joining_date'    => $request->joining_date,
            'employment_type' => $request->employment_type,
            'status'          => 'active',
            'address'         => $request->address,
            'photo'           => $photoPath,
        ]);

        return redirect()->route('admin.staff.index')
                         ->with('success', 'Staff member added successfully!');
    }

    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:staff,email,' . $staff->id,
            'gender'          => 'required|in:male,female',
            'role'            => 'required',
            'joining_date'    => 'required|date',
            'employment_type' => 'required',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = $staff->photo;
        if ($request->hasFile('photo')) {
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }
            $photoPath = $request->file('photo')->store('photos/staff', 'public');
        }

        $staff->update([
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'gender'          => $request->gender,
            'date_of_birth'   => $request->date_of_birth,
            'national_id'     => $request->national_id,
            'role'            => $request->role,
            'department'      => $request->department,
            'subject'         => $request->subject,
            'joining_date'    => $request->joining_date,
            'employment_type' => $request->employment_type,
            'status'          => $request->status,
            'address'         => $request->address,
            'photo'           => $photoPath,
        ]);

        return redirect()->route('admin.staff.index')
                         ->with('success', 'Staff member updated successfully!');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }
        $staff->delete();
        return redirect()->route('admin.staff.index')
                         ->with('success', 'Staff member deleted successfully!');
    }
}