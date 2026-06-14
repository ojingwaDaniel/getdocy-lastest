@extends('layouts.admin')
@section('title', 'Create Level')

@section('content')
<div class="max-w-xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Level</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.levels.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Level Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="e.g. 100 Level"
                       class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Value</label>
                <input type="number" name="value" value="{{ old('value') }}"
                       placeholder="e.g. 100"
                       class="w-full border rounded px-3 py-2 @error('value') border-red-500 @enderror">
                @error('value')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Create Level
                </button>
                <a href="{{ route('admin.levels.index') }}"
                   class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection