@extends('layouts.portal')

@section('page_title', 'Apply for Admission')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">

    <h3 class="text-lg font-semibold text-gray-700 mb-2">Apply for Admission</h3>
    <p class="text-sm text-gray-500 mb-6">Fill in your child's details below. We will review and get back to you.</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parent.admissions.store') }}" method="POST">
        @csrf

        <p class="text-sm font-semibold text-blue-900 mb-4 border-b pb-2">Child's Information</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                <select name="gender"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Select Gender</option>
                    <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Child's Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Child's Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Previous School</label>
                <input type="text" name="previous_school" value="{{ old('previous_school') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Applying For Class *</label>
                <select name="applying_for_class"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->name }}"
                            {{ old('applying_for_class') == $class->name ? 'selected' : '' }}>
                            {{ $class->name }} — {{ $class->level }}
                            ({{ $class->available_spots }} spots left)
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <p class="text-sm font-semibold text-blue-900 mb-4 border-b pb-2">Guardian Information</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name *</label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name', auth()->user()->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone *</label>
                <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to Child</label>
                <select name="guardian_relationship"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Relationship</option>
                    <option value="Father"         {{ old('guardian_relationship') == 'Father'         ? 'selected' : '' }}>Father</option>
                    <option value="Mother"         {{ old('guardian_relationship') == 'Mother'         ? 'selected' : '' }}>Mother</option>
                    <option value="Uncle"          {{ old('guardian_relationship') == 'Uncle'          ? 'selected' : '' }}>Uncle</option>
                    <option value="Aunt"           {{ old('guardian_relationship') == 'Aunt'           ? 'selected' : '' }}>Aunt</option>
                    <option value="Grandparent"    {{ old('guardian_relationship') == 'Grandparent'    ? 'selected' : '' }}>Grandparent</option>
                    <option value="Legal Guardian" {{ old('guardian_relationship') == 'Legal Guardian' ? 'selected' : '' }}>Legal Guardian</option>
                    <option value="Other"          {{ old('guardian_relationship') == 'Other'          ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                <textarea name="notes" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
            </div>

        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('parent.admissions.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Submit Application
            </button>
        </div>

    </form>
</div>

@endsection