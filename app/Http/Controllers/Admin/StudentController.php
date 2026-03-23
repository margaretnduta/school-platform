<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Dormitory;
use App\Models\DormitoryBed;
use App\Models\DormitoryRoom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $dormitories = Dormitory::where('is_active', true)->get();
        return view('admin.students.create', compact('dormitories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|in:male,female',
            'date_of_birth'  => 'required|date',
            'guardian_name'  => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'dormitory_id'   => 'nullable|exists:dormitories,id',
        ]);

        // Auto generate admission number
        $admissionNumber = 'STU-' . strtoupper(substr($request->first_name, 0, 2)) . '-' . date('Y') . '-' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);

        $student = Student::create([
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
            'address'          => $request->address,
            'status'           => 'active',
        ]);

        // Auto assign bed if dormitory selected
        if ($request->dormitory_id) {
            $this->autoAssignBed($student, $request->dormitory_id);
        }

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student added successfully!');
    }

    public function show(Student $student)
    {
        $bed = DormitoryBed::where('student_id', $student->id)
                           ->with('room', 'dormitory')
                           ->first();
        return view('admin.students.show', compact('student', 'bed'));
    }

    public function edit(Student $student)
    {
        $dormitories = Dormitory::where('is_active', true)->get();
        $currentBed  = DormitoryBed::where('student_id', $student->id)
                                   ->with('room', 'dormitory')
                                   ->first();
        return view('admin.students.edit', compact('student', 'dormitories', 'currentBed'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|in:male,female',
            'date_of_birth'  => 'required|date',
            'guardian_name'  => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'dormitory_id'   => 'nullable|exists:dormitories,id',
        ]);

        $student->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'gender'         => $request->gender,
            'date_of_birth'  => $request->date_of_birth,
            'guardian_name'  => $request->guardian_name,
            'guardian_phone' => $request->guardian_phone,
            'guardian_email' => $request->guardian_email,
            'class'          => $request->class,
            'address'        => $request->address,
            'status'         => $request->status,
        ]);

        // Handle dormitory change
        if ($request->dormitory_id) {
            // Release old bed if exists
            $oldBed = DormitoryBed::where('student_id', $student->id)->first();
            if ($oldBed && $oldBed->dormitory_id != $request->dormitory_id) {
                $this->releaseBed($oldBed);
                $this->autoAssignBed($student, $request->dormitory_id);
            } elseif (!$oldBed) {
                $this->autoAssignBed($student, $request->dormitory_id);
            }
        }

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        // Release bed before deleting
        $bed = DormitoryBed::where('student_id', $student->id)->first();
        if ($bed) {
            $this->releaseBed($bed);
        }
        $student->delete();
        return redirect()->route('admin.students.index')
                         ->with('success', 'Student deleted successfully!');
    }

    // ─── Private Helpers ────────────────────────────────────────────

    private function autoAssignBed(Student $student, $dormitoryId)
    {
        $availableBed = DormitoryBed::where('dormitory_id', $dormitoryId)
                                    ->where('status', 'empty')
                                    ->whereNull('student_id')
                                    ->with('room', 'dormitory')
                                    ->first();

        if (!$availableBed) return;

        $availableBed->update([
            'student_id' => $student->id,
            'status'     => 'occupied',
        ]);

        // Update room occupied count
        $room = $availableBed->room;
        $room->increment('occupied_beds');
        if ($room->occupied_beds >= $room->total_beds) {
            $room->update(['status' => 'full']);
        }

        // Save dormitory info on student record
        $student->update([
            'dormitory' => $availableBed->dormitory->name .
                           ' | ' . $room->room_number .
                           ' | ' . $availableBed->bed_number .
                           ' (' . ucfirst($availableBed->position) . ')',
        ]);
    }

    private function releaseBed(DormitoryBed $bed)
    {
        $room = $bed->room;
        $bed->update(['student_id' => null, 'status' => 'empty']);
        $room->decrement('occupied_beds');
        $room->update(['status' => 'available']);
    }
}