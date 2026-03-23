<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ParentAdmissionController extends Controller
{
    public function index()
    {
        $applications = Admission::where('guardian_email', auth()->user()->email)
                                 ->latest()->get();
        return view('parent.admissions.index', compact('applications'));
    }

    public function create()
    {
        $classes = SchoolClass::where('status', 'active')->get();
        return view('parent.admissions.create', compact('classes'));
    }

    public function store(Request $request)
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

        $appNumber = 'APP-' . date('Y') . '-' . str_pad(Admission::count() + 1, 5, '0', STR_PAD_LEFT);

        Admission::create([
            'application_number'    => $appNumber,
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'gender'                => $request->gender,
            'date_of_birth'         => $request->date_of_birth,
            'previous_school'       => $request->previous_school,
            'applying_for_class'    => $request->applying_for_class,
            'guardian_name'         => $request->guardian_name,
            'guardian_phone'        => $request->guardian_phone,
            'guardian_email'        => auth()->user()->email,
            'guardian_relationship' => $request->guardian_relationship,
            'address'               => $request->address,
            'notes'                 => $request->notes,
            'status'                => 'pending',
        ]);

        return redirect()->route('parent.admissions.index')
                         ->with('success', 'Application submitted successfully! We will review it shortly.');
    }

    public function show($id)
    {
        $application = Admission::where('guardian_email', auth()->user()->email)
                                ->findOrFail($id);
        return view('parent.admissions.show', compact('application'));
    }
}