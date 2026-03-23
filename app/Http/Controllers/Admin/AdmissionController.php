<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Dormitory;
use App\Models\DormitoryBed;
use App\Models\DormitoryRoom;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $pending  = Admission::where('status', 'pending')->latest()->get();
        $approved = Admission::where('status', 'approved')->latest()->get();
        $rejected = Admission::where('status', 'rejected')->latest()->get();
        return view('admin.admissions.index', compact('pending', 'approved', 'rejected'));
    }

    public function create()
    {
        $classes = SchoolClass::where('status', 'active')->get();
        return view('admin.admissions.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'gender'         => 'required|in:male,female',
            'date_of_birth'  => 'required|date',
            'applying_for_class' => 'required|string',
            'guardian_name'  => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
        ]);

        $appNumber = 'APP-' . date('Y') . '-' . str_pad(Admission::count() + 1, 5, '0', STR_PAD_LEFT);

        Admission::create([
            'application_number'   => $appNumber,
            'first_name'           => $request->first_name,
            'last_name'            => $request->last_name,
            'email'                => $request->email,
            'phone'                => $request->phone,
            'gender'               => $request->gender,
            'date_of_birth'        => $request->date_of_birth,
            'previous_school'      => $request->previous_school,
            'applying_for_class'   => $request->applying_for_class,
            'guardian_name'        => $request->guardian_name,
            'guardian_phone'       => $request->guardian_phone,
            'guardian_email'       => $request->guardian_email,
            'guardian_relationship'=> $request->guardian_relationship,
            'address'              => $request->address,
            'notes'                => $request->notes,
            'status'               => 'pending',
        ]);

        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Application submitted successfully!');
    }

    public function show(Admission $admission)
    {
        $classes     = SchoolClass::where('status', 'active')->get();
        $dormitories = Dormitory::where('is_active', true)->get();
        return view('admin.admissions.show', compact('admission', 'classes', 'dormitories'));
    }

    public function approve(Request $request, Admission $admission)
    {
        $request->validate([
            'class'        => 'required|string',
            'dormitory_id' => 'nullable|exists:dormitories,id',
        ]);

        // Generate admission number
        $admissionNumber = 'STU-' .
            strtoupper(substr($admission->first_name, 0, 2)) .
            '-' . date('Y') . '-' .
            str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);

        // Create the student record
        $student = Student::create([
            'admission_number' => $admissionNumber,
            'first_name'       => $admission->first_name,
            'last_name'        => $admission->last_name,
            'email'            => $admission->email,
            'phone'            => $admission->phone,
            'gender'           => $admission->gender,
            'date_of_birth'    => $admission->date_of_birth,
            'guardian_name'    => $admission->guardian_name,
            'guardian_phone'   => $admission->guardian_phone,
            'guardian_email'   => $admission->guardian_email,
            'address'          => $admission->address,
            'class'            => $request->class,
            'status'           => 'active',
        ]);

        // Auto assign bed if dormitory selected
        if ($request->dormitory_id) {
            $availableBed = DormitoryBed::where('dormitory_id', $request->dormitory_id)
                                        ->where('status', 'empty')
                                        ->whereNull('student_id')
                                        ->with('room', 'dormitory')
                                        ->first();
            if ($availableBed) {
                $availableBed->update([
                    'student_id' => $student->id,
                    'status'     => 'occupied',
                ]);
                $room = $availableBed->room;
                $room->increment('occupied_beds');
                if ($room->occupied_beds >= $room->total_beds) {
                    $room->update(['status' => 'full']);
                }
                $student->update([
                    'dormitory' => $availableBed->dormitory->name .
                                   ' | ' . $room->room_number .
                                   ' | ' . $availableBed->bed_number .
                                   ' (' . ucfirst($availableBed->position) . ')',
                ]);
            }
        }

        // Update admission record
        $admission->update([
            'status'      => 'approved',
            'student_id'  => $student->id,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Application approved! Student record created with admission number: ' . $admissionNumber);
    }

    public function reject(Request $request, Admission $admission)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $admission->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
        ]);

        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Application rejected.');
    }

    public function edit(Admission $admission)
    {
        $classes = SchoolClass::where('status', 'active')->get();
        return view('admin.admissions.edit', compact('admission', 'classes'));
    }

    public function update(Request $request, Admission $admission)
    {
        $request->validate([
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'gender'             => 'required|in:male,female',
            'date_of_birth'      => 'required|date',
            'applying_for_class' => 'required|string',
            'guardian_name'      => 'required|string|max:255',
            'guardian_phone'     => 'required|string|max:20',
        ]);

        $admission->update($request->all());

        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Application updated successfully!');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();
        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Application deleted.');
    }
}