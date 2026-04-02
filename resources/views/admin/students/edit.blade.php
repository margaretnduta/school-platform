@extends('layouts.admin')

@section('page_title', 'Edit Student')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">

    <h3 class="text-lg font-semibold text-gray-700 mb-6">Edit Student — {{ $student->full_name }}</h3>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($currentBed)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm font-semibold text-blue-900">Current Bed Assignment</p>
        <p class="text-sm text-blue-700 mt-1">
            🏠 {{ $currentBed->dormitory->name }} &nbsp;|&nbsp;
            {{ $currentBed->room->room_number }} &nbsp;|&nbsp;
            {{ $currentBed->bed_number }} ({{ ucfirst($currentBed->position) }})
        </p>
    </div>
    @endif

    <form action="{{ route('admin.students.update', $student) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                <select name="gender" id="genderSelect"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="male"   {{ $student->gender == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $student->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name *</label>
                <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone *</label>
                <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Email</label>
                <input type="email" name="guardian_email" value="{{ old('guardian_email', $student->guardian_email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select name="class"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Class —</option>
                    @foreach(\App\Models\SchoolClass::where('status', 'active')->get() as $schoolClass)
                        <option value="{{ $schoolClass->name }}"
                            {{ $student->class == $schoolClass->name ? 'selected' : '' }}>
                            {{ $schoolClass->name }} — {{ $schoolClass->level }}
                            ({{ $schoolClass->available_spots }} spots left)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="active"    {{ $student->status == 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="inactive"  {{ $student->status == 'inactive'  ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ $student->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            {{-- Dormitory --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Change Dormitory
                    <span class="text-xs text-gray-400 ml-1">(Changing will release current bed)</span>
                </label>
                <select name="dormitory_id" id="dormitorySelect"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Keep Current Dormitory —</option>
                    @foreach($dormitories as $dormitory)
                        <option value="{{ $dormitory->id }}"
                                data-gender="{{ $dormitory->gender }}"
                                data-available="{{ $dormitory->available_beds }}"
                                {{ old('dormitory_id') == $dormitory->id ? 'selected' : '' }}>
                            {{ $dormitory->name }} ({{ ucfirst($dormitory->gender) }})
                            — {{ $dormitory->available_beds }} beds available
                        </option>
                    @endforeach
                </select>
                <p id="noDormMessage" class="text-xs text-red-500 mt-1 hidden">
                    No available dormitories for this gender.
                </p>
            </div>

            {{-- Photo Upload --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Student Photo
                    <span class="text-xs text-gray-400 ml-1">(JPG or PNG, max 2MB — leave blank to keep current)</span>
                </label>
                <div class="flex items-center space-x-4">
                    <div id="photoPreview"
                         class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-300 flex items-center justify-center bg-gray-100">
                        @if($student->photo)
                            <img src="{{ Storage::url($student->photo) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <x-avatar :name="$student->full_name" size="16" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="photo" id="photoInput"
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <p class="text-xs text-gray-400 mt-1">
                            Upload a new photo to replace the current one.
                        </p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $student->address) }}</textarea>
            </div>

        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('admin.students.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Update Student
            </button>
        </div>

    </form>
</div>

<script>
    const genderSelect    = document.getElementById('genderSelect');
    const dormitorySelect = document.getElementById('dormitorySelect');
    const noDormMessage   = document.getElementById('noDormMessage');
    const allOptions      = dormitorySelect.querySelectorAll('option[data-gender]');

    function filterDormitories(selectedGender) {
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
        noDormMessage.classList.toggle('hidden', visibleCount > 0);
    }

    genderSelect.addEventListener('change', function () {
        filterDormitories(this.value);
    });

    filterDormitories(genderSelect.value);

    // Photo preview
    document.getElementById('photoInput').addEventListener('change', function () {
        const file    = this.files[0];
        const preview = document.getElementById('photoPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = `<img src="${e.target.result}"
                    class="w-full h-full object-cover rounded-full">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection