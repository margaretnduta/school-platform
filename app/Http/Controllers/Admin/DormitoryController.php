<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\DormitoryRoom;
use App\Models\DormitoryBed;
use App\Models\Student;
use Illuminate\Http\Request;

class DormitoryController extends Controller
{
    // List all dormitories
    public function index()
    {
        $dormitories = Dormitory::latest()->get();
        return view('admin.dormitories.index', compact('dormitories'));
    }

    // Show create form
    public function create()
    {
        return view('admin.dormitories.create');
    }

    // Save dormitory and auto-generate rooms & beds
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:male,female,mixed',
            'beds_per_room' => 'required|integer|min:1|max:20',
            'warden_name'   => 'nullable|string|max:255',
            'warden_phone'  => 'nullable|string|max:20',
        ]);

        // Create the dormitory
        $dormitory = Dormitory::create([
            'name'          => $request->name,
            'gender'        => $request->gender,
            'rooms_count'   => 24,
            'beds_per_room' => $request->beds_per_room,
            'warden_name'   => $request->warden_name,
            'warden_phone'  => $request->warden_phone,
            'description'   => $request->description,
        ]);

        // Auto-generate 24 rooms with beds
        for ($roomNum = 1; $roomNum <= 24; $roomNum++) {

            $room = DormitoryRoom::create([
                'dormitory_id' => $dormitory->id,
                'room_number'  => 'Room ' . str_pad($roomNum, 2, '0', STR_PAD_LEFT),
                'total_beds'   => $request->beds_per_room,
                'occupied_beds'=> 0,
                'status'       => 'available',
            ]);

            // Auto-generate beds inside this room
            for ($bedNum = 1; $bedNum <= $request->beds_per_room; $bedNum++) {
                // Odd beds = bottom, Even beds = top (double decker logic)
                $position = ($bedNum % 2 == 0) ? 'top' : 'bottom';

                DormitoryBed::create([
                    'dormitory_id'      => $dormitory->id,
                    'dormitory_room_id' => $room->id,
                    'bed_number'        => 'Bed ' . $bedNum,
                    'position'          => $position,
                    'status'            => 'empty',
                ]);
            }
        }

        return redirect()->route('admin.dormitories.index')
                         ->with('success', 'Dormitory created with 24 rooms and all beds generated successfully!');
    }

    // Show single dormitory with rooms and beds
    public function show(Dormitory $dormitory)
    {
        $rooms = $dormitory->rooms()->with('beds.student')->get();
        return view('admin.dormitories.show', compact('dormitory', 'rooms'));
    }

    // Auto-assign next available bed to a student
    public function assignBed(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'dormitory_id' => 'required|exists:dormitories,id',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Check if student already has a bed
        $existingBed = DormitoryBed::where('student_id', $student->id)->first();
        if ($existingBed) {
            return back()->with('error', 'This student already has a bed assigned.');
        }

        // Find the first available empty bed in the selected dormitory
        $availableBed = DormitoryBed::where('dormitory_id', $request->dormitory_id)
                                    ->where('status', 'empty')
                                    ->whereNull('student_id')
                                    ->with('room')
                                    ->first();

        if (!$availableBed) {
            return back()->with('error', 'No available beds in this dormitory.');
        }

        // Assign the bed to the student
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

        // Update student record with dormitory info
        $student->update([
            'dormitory' => $availableBed->dormitory->name .
                           ' | ' . $room->room_number .
                           ' | ' . $availableBed->bed_number .
                           ' (' . $availableBed->position . ')',
        ]);

        return back()->with('success', 'Bed assigned: ' . $room->room_number . ' — ' . $availableBed->bed_number . ' (' . $availableBed->position . ')');
    }

    // Release a bed (when student leaves)
    public function releaseBed(DormitoryBed $bed)
    {
        $room = $bed->room;

        // Update student record
        if ($bed->student) {
            $bed->student->update(['dormitory' => null]);
        }

        // Free the bed
        $bed->update([
            'student_id' => null,
            'status'     => 'empty',
        ]);

        // Update room count
        $room->decrement('occupied_beds');
        $room->update(['status' => 'available']);

        return back()->with('success', 'Bed released successfully.');
    }

    public function edit(Dormitory $dormitory)
    {
        return view('admin.dormitories.edit', compact('dormitory'));
    }

    public function update(Request $request, Dormitory $dormitory)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'gender'      => 'required|in:male,female,mixed',
            'warden_name' => 'nullable|string|max:255',
            'warden_phone'=> 'nullable|string|max:20',
        ]);

        $dormitory->update($request->only([
            'name', 'gender', 'warden_name', 'warden_phone', 'description'
        ]));

        return redirect()->route('admin.dormitories.index')
                         ->with('success', 'Dormitory updated successfully!');
    }

    public function destroy(Dormitory $dormitory)
    {
        $dormitory->delete();
        return redirect()->route('admin.dormitories.index')
                         ->with('success', 'Dormitory deleted successfully!');
    }
}