@extends('layouts.admin')
@section('title', 'Edit Course')

@section('content')
<div class="max-w-xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Course</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Course Title</label>
                <input type="text" name="title"
                       value="{{ old('title', $course->title) }}"
                       class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Course Code</label>
                <input type="text" name="code"
                       value="{{ old('code', $course->code) }}"
                       class="w-full border rounded px-3 py-2 @error('code') border-red-500 @enderror">
                @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Department</label>
                <select name="department_id"
                        class="w-full border rounded px-3 py-2 @error('department_id') border-red-500 @enderror">
                    <option value="">— Select Department —</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id', $course->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Level</label>
                <select name="level_id"
                        class="w-full border rounded px-3 py-2 @error('level_id') border-red-500 @enderror">
                    <option value="">— Select Level —</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}"
                            {{ old('level_id', $course->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('level_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Credit Units</label>
                <input type="number" name="credit_units"
                       value="{{ old('credit_units', $course->credit_units) }}"
                       min="1" max="6"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection