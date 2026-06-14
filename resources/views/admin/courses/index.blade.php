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
                    No courses yet. Create one!
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