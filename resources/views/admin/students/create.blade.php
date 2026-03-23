@extends('layouts.admin')

@section('page_title', 'Add New Student')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">

    <h3 class="text-lg font-semibold text-gray-700 mb-6">Add New Student</h3>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST" id="studentForm">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

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
                <select name="gender" id="genderSelect"
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name *</label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Email</label>
                <input type="email" name="guardian_email" value="{{ old('guardian_email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select name="class"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Class —</option>
                    @foreach(\App\Models\SchoolClass::where('status', 'active')->get() as $schoolClass)
                        <option value="{{ $schoolClass->name }}"
                            {{ old('class') == $schoolClass->name ? 'selected' : '' }}>
                            {{ $schoolClass->name }} — {{ $schoolClass->level }}
                            ({{ $schoolClass->available_spots }} spots left)
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dormitory Dropdown — filters by gender --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Dormitory
                    <span class="text-xs text-gray-400 ml-1">(Select gender first — only matching dormitories will show)</span>
                </label>
                <select name="dormitory_id" id="dormitorySelect"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Gender First —</option>
                    @foreach($dormitories as $dormitory)
                        <option value="{{ $dormitory->id }}"
                                data-gender="{{ $dormitory->gender }}"
                                data-available="{{ $dormitory->available_beds }}"
                                style="display:none"
                                {{ old('dormitory_id') == $dormitory->id ? 'selected' : '' }}>
                            {{ $dormitory->name }}
                            ({{ ucfirst($dormitory->gender) }})
                            — {{ $dormitory->available_beds }} beds available
                        </option>
                    @endforeach
                </select>
                <p id="noDormMessage" class="text-xs text-red-500 mt-1 hidden">
                    No available dormitories for this gender.
                </p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
            </div>

        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('admin.students.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Save Student
            </button>
        </div>

    </form>
</div>

<script>
    const genderSelect     = document.getElementById('genderSelect');
    const dormitorySelect  = document.getElementById('dormitorySelect');
    const noDormMessage    = document.getElementById('noDormMessage');
    const allOptions       = dormitorySelect.querySelectorAll('option[data-gender]');

    genderSelect.addEventListener('change', function () {
        const selectedGender = this.value;
        dormitorySelect.value = '';
        let visibleCount = 0;

        allOptions.forEach(option => {
            const dormGender    = option.getAttribute('data-gender');
            const availableBeds = parseInt(option.getAttribute('data-available'));
            const genderMatch   = (dormGender === selectedGender || dormGender === 'mixed');
            const hasSpace      = availableBeds > 0;

            if (genderMatch && hasSpace) {
                option.style.display = '';
                visibleCount++;
            } else {
                option.style.display = 'none';
            }
        });

        dormitorySelect.options[0].text = selectedGender
            ? '— Select Dormitory —'
            : '— Select Gender First —';

        noDormMessage.classList.toggle('hidden', visibleCount > 0);
    });

    if (genderSelect.value) {
        genderSelect.dispatchEvent(new Event('change'));
    }
</script>

@endsection