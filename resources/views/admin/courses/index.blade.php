@extends('layouts.admin')
@section('title', 'Courses')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Courses</h2>
    <a href="{{ route('admin.courses.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + New Course
    </a>
</div>


<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('admin.courses.index') }}"
          class="flex gap-3 flex-wrap">

        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search title or code..."
               class="border rounded px-3 py-2 flex-1 min-w-48">

        <select name="department_id" class="border rounded px-3 py-2 min-w-48">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}"
                    {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
            Filter
        </button>

        @if(request()->hasAny(['search', 'department_id']))
        <a href="{{ route('admin.courses.index') }}"
           class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">
            Clear
        </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Title</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Code</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Department</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Level</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Credits</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($courses as $course)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $course->title }}</td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm font-mono">
                        {{ $course->code }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $course->department->name ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $course->level->name ?? '—' }}</td>
                <td class="px-6 py-4 text-center">{{ $course->credit_units }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.courses.edit', $course) }}"
                       class="text-blue-600 hover:underline text-sm">Edit</a>

                    <form method="POST"
                          action="{{ route('admin.courses.destroy', $course) }}"
                          class="inline"
                          onsubmit="return confirm('Delete this course?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    @if(request()->hasAny(['search', 'department_id']))
                        No courses match your filters.
                    @else
                        No courses yet. Create one!
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $courses->links() }}
    </div>
</div>
@endsection