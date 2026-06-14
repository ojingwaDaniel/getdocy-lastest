@extends('layouts.admin')
@section('title', 'Edit Lecturer')

@section('content')
<div class="max-w-xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Lecturer</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.lecturers.update', $lecturer) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $lecturer->name) }}"
                       class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Title <span class="text-gray-400 font-normal">(optional)</span></label>
                <select name="title" class="w-full border rounded px-3 py-2">
                    <option value="">— None —</option>
                    @foreach(['Mr.', 'Mrs.', 'Dr.', 'Prof.'] as $t)
                        <option value="{{ $t }}"
                            {{ old('title', $lecturer->lecturer->title ?? '') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Staff ID</label>
                <input type="text" name="staff_id"
                       value="{{ old('staff_id', $lecturer->lecturer->staff_id ?? '') }}"
                       class="w-full border rounded px-3 py-2 @error('staff_id') border-red-500 @enderror">
                @error('staff_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" value="{{ $lecturer->email }}"
                       class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-400 cursor-not-allowed"
                       disabled>
                <p class="text-gray-400 text-xs mt-1">Email cannot be changed here.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Phone <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" name="phone"
                       value="{{ old('phone', $lecturer->phone) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Department</label>
                <select name="department_id"
                        class="w-full border rounded px-3 py-2 @error('department_id') border-red-500 @enderror">
                    <option value="">— Select Department —</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id', $lecturer->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.lecturers.index') }}"
                   class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection