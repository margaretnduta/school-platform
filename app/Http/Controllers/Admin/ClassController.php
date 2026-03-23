<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('classTeacher')->latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Staff::where('role', 'teacher')
                         ->where('status', 'active')
                         ->get();
        return view('admin.classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:school_classes,name',
            'level'    => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        SchoolClass::create([
            'name'             => $request->name,
            'level'            => $request->level,
            'stream'           => $request->stream,
            'capacity'         => $request->capacity,
            'class_teacher_id' => $request->class_teacher_id,
            'room_number'      => $request->room_number,
            'status'           => 'active',
        ]);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class created successfully!');
    }

    public function show(SchoolClass $class)
    {
        $students = Student::where('class', $class->name)->paginate(20);
        return view('admin.classes.show', compact('class', 'students'));
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Staff::where('role', 'teacher')
                         ->where('status', 'active')
                         ->get();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:school_classes,name,' . $class->id,
            'level'    => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $class->update([
            'name'             => $request->name,
            'level'            => $request->level,
            'stream'           => $request->stream,
            'capacity'         => $request->capacity,
            'class_teacher_id' => $request->class_teacher_id,
            'room_number'      => $request->room_number,
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class updated successfully!');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class deleted successfully!');
    }
}