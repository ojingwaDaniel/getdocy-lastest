@extends('layouts.admin')
@section('title', 'Lecturers')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Lecturers</h2>
    <a href="{{ route('admin.lecturers.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Lecturer
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Name</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Staff ID</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Email</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Department</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($lecturers as $lecturer)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">
                    {{ $lecturer->lecturer->title ?? '' }} {{ $lecturer->name }}
                </td>
                <td class="px-6 py-4 font-mono text-sm">
                    {{ $lecturer->lecturer->staff_id ?? '—' }}
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $lecturer->email }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $lecturer->department->name ?? '—' }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.lecturers.edit', $lecturer) }}"
                       class="text-blue-600 hover:underline text-sm">Edit</a>
                    <form method="POST"
                          action="{{ route('admin.lecturers.destroy', $lecturer) }}"
                          class="inline"
                          onsubmit="return confirm('Remove this lecturer?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline text-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                    No lecturers yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $lecturers->links() }}</div>
</div>
@endsection