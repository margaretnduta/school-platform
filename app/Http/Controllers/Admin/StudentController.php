<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Show all students
    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    // Show create form
    public function create()
    {
        return view('admin.students.create');
    }

    // Save new student
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|in:male,female',
            'date_of_birth'  => 'required|date',
            'guardian_name'  => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
        ]);

        // Auto generate admission number
        $admissionNumber = 'STU-' . strtoupper(substr($request->first_name, 0, 2)) . '-' . date('Y') . '-' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);

        Student::create([
            'admission_number' => $admissionNumber,
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'gender'           => $request->gender,
            'date_of_birth'    => $request->date_of_birth,
            'guardian_name'    => $request->guardian_name,
            'guardian_phone'   => $request->guardian_phone,
            'guardian_email'   => $request->guardian_email,
            'class'            => $request->class,
            'dormitory'        => $request->dormitory,
            'address'          => $request->address,
            'status'           => 'active',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully!');
    }

    // Show single student
    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    // Show edit form
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|in:male,female',
            'date_of_birth'  => 'required|date',
            'guardian_name'  => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }
}