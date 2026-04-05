@extends('layouts.admin')

@section('page_title', 'Edit Event')

@section('content')

<div class="max-w-2xl mx-auto">
    <x-card>
        <x-card-header>
            <h3 class="text-lg font-semibold text-gray-900">Edit Event</h3>
        </x-card-header>

        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-card-body class="space-y-6">
                <!-- Title -->
                <div>
                    <x-input-label for="title" value="Event Title" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $event->title) }}" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" value="Short Description" />
                    <textarea id="description" name="description" rows="3" class="textarea" required>{{ old('description', $event->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <!-- Detailed Description -->
                <div>
                    <x-input-label for="detailed_description" value="Detailed Description" />
                    <textarea id="detailed_description" name="detailed_description" rows="4" class="textarea">{{ old('detailed_description', $event->detailed_description) }}</textarea>
                    <x-input-error :messages="$errors->get('detailed_description')" class="mt-1" />
                </div>

                <!-- Event Date -->
                <div>
                    <x-input-label for="event_date" value="Event Date & Time" />
                    <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required />
                    <x-input-error :messages="$errors->get('event_date')" class="mt-1" />
                </div>

                <!-- Location -->
                <div>
                    <x-input-label for="location" value="Location" />
                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ old('location', $event->location) }}" />
                    <x-input-error :messages="$errors->get('location')" class="mt-1" />
                </div>

                <!-- Organizer -->
                <div>
                    <x-input-label for="organizer" value="Organizer" />
                    <x-text-input id="organizer" class="block mt-1 w-full" type="text" name="organizer" value="{{ old('organizer', $event->organizer) }}" />
                    <x-input-error :messages="$errors->get('organizer')" class="mt-1" />
                </div>

                <!-- Category -->
                <div>
                    <x-input-label for="category" value="Category" />
                    <select id="category" name="category" class="select">
                        <option value="">-- Select Category --</option>
                        <option value="Sports" {{ old('category', $event->category) === 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Academic" {{ old('category', $event->category) === 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Cultural" {{ old('category', $event->category) === 'Cultural' ? 'selected' : '' }}>Cultural</option>
                        <option value="Ceremony" {{ old('category', $event->category) === 'Ceremony' ? 'selected' : '' }}>Ceremony</option>
                        <option value="Social" {{ old('category', $event->category) === 'Social' ? 'selected' : '' }}>Social</option>
                        <option value="Workshop" {{ old('category', $event->category) === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="Other" {{ old('category', $event->category) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Current Image -->
                @if($event->image)
                <div>
                    <x-input-label value="Current Image" />
                    <div class="mt-2 relative inline-block">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="h-24 rounded-lg">
                    </div>
                </div>
                @endif

                <!-- New Image -->
                <div>
                    <x-input-label for="image" value="Update Image" />
                    <input id="image" class="block mt-1 w-full border border-gray-300 rounded-lg p-2" type="file" name="image" accept="image/*" />
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="select" required>
                        <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>

                <!-- Max Participants -->
                <div>
                    <x-input-label for="max_participants" value="Max Participants" />
                    <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="1" />
                    <x-input-error :messages="$errors->get('max_participants')" class="mt-1" />
                </div>

                <!-- Registered Participants -->
                <div>
                    <x-input-label for="registered_participants" value="Registered Participants" />
                    <x-text-input id="registered_participants" class="block mt-1 w-full" type="number" name="registered_participants" value="{{ old('registered_participants', $event->registered_participants) }}" min="0" />
                    <x-input-error :messages="$errors->get('registered_participants')" class="mt-1" />
                </div>

                <!-- Is Public -->
                <div class="flex items-center">
                    <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', $event->is_public) ? 'checked' : '' }} class="rounded">
                    <label for="is_public" class="ml-2 block text-sm text-gray-700">
                        Make event visible on welcome page
                    </label>
                </div>
            </x-card-body>

            <x-card-footer>
                <a href="{{ route('admin.events.index') }}" class="btn btn-white">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Update Event
                </button>
            </x-card-footer>
        </form>
    </x-card>
</div>

@endsection
