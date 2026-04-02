@extends('layouts.admin')

@section('page_title', 'Edit Staff Member')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">

    <h3 class="text-lg font-semibold text-gray-700 mb-6">Edit Staff — {{ $staff->full_name }}</h3>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name', $staff->first_name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name', $staff->last_name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $staff->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="male"   {{ $staff->gender == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $staff->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $staff->date_of_birth) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">National ID</label>
                <input type="text" name="national_id" value="{{ old('national_id', $staff->national_id) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="teacher"       {{ $staff->role == 'teacher'       ? 'selected' : '' }}>Teacher</option>
                    <option value="admin_staff"   {{ $staff->role == 'admin_staff'   ? 'selected' : '' }}>Admin Staff</option>
                    <option value="support_staff" {{ $staff->role == 'support_staff' ? 'selected' : '' }}>Support Staff</option>
                    <option value="nurse"         {{ $staff->role == 'nurse'         ? 'selected' : '' }}>Nurse</option>
                    <option value="librarian"     {{ $staff->role == 'librarian'     ? 'selected' : '' }}>Librarian</option>
                    <option value="counselor"     {{ $staff->role == 'counselor'     ? 'selected' : '' }}>Counselor</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <input type="text" name="department" value="{{ old('department', $staff->department) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input type="text" name="subject" value="{{ old('subject', $staff->subject) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date *</label>
                <input type="date" name="joining_date" value="{{ old('joining_date', $staff->joining_date) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type *</label>
                <select name="employment_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="full_time" {{ $staff->employment_type == 'full_time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time" {{ $staff->employment_type == 'part_time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract"  {{ $staff->employment_type == 'contract'  ? 'selected' : '' }}>Contract</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="active"   {{ $staff->status == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $staff->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="on_leave" {{ $staff->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                </select>
            </div>

            {{-- Photo Upload --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Staff Photo
                    <span class="text-xs text-gray-400 ml-1">(Leave blank to keep current)</span>
                </label>
                <div class="flex items-center gap-4">
                    <div id="photoPreview"
                         class="flex-shrink-0 rounded-full overflow-hidden border-2 border-gray-300 bg-gray-100"
                         style="width:56px; height:56px; min-width:56px;">
                        @if($staff->photo)
                            <img src="{{ Storage::url($staff->photo) }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <x-avatar :name="$staff->full_name" size="md" />
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="photo" id="photoInput"
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <p class="text-xs text-gray-400 mt-1">
                            Upload a new photo to replace the current one.
                        </p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $staff->address) }}</textarea>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.staff.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition">
                Update Staff
            </button>
        </div>

    </form>
</div>

<script>
    document.getElementById('photoInput').addEventListener('change', function () {
        const file    = this.files[0];
        const preview = document.getElementById('photoPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = `<img src="${e.target.result}"
                    style="width:100%;height:100%;object-fit:cover;">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection