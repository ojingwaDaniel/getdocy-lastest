@extends('layouts.admin')
@section('title', 'Edit Student')

@section('content')
<div class="max-w-xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Student</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $student->name) }}"
                       class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Matric Number</label>
                <input type="text" name="matric_number"
                       value="{{ old('matric_number', $student->student->matric_number ?? '') }}"
                       class="w-full border rounded px-3 py-2 @error('matric_number') border-red-500 @enderror">
                @error('matric_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" value="{{ $student->email }}"
                       class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-400 cursor-not-allowed"
                       disabled>
                <p class="text-gray-400 text-xs mt-1">Email cannot be changed here.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Phone <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" name="phone"
                       value="{{ old('phone', $student->phone) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Department</label>
                <select name="department_id"
                        class="w-full border rounded px-3 py-2 @error('department_id') border-red-500 @enderror">
                    <option value="">— Select Department —</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id', $student->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Level</label>
                <select name="level_id"
                        class="w-full border rounded px-3 py-2 @error('level_id') border-red-500 @enderror">
                    <option value="">— Select Level —</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}"
                            {{ old('level_id', $student->student->level_id ?? '') == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('level_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.students.index') }}"
                   class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection