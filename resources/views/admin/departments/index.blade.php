@extends('layouts.admin')
@section('title', 'Departments')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Departments</h2>
    <a href="{{ route('admin.departments.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + New Department
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Name</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Code</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Faculty</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Courses</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($departments as $dept)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $dept->name }}</td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm font-mono">
                        {{ $dept->code }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $dept->faculty ?? '—' }}</td>
                <td class="px-6 py-4">{{ $dept->courses_count }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.departments.edit', $dept) }}"
                       class="text-blue-600 hover:underline text-sm">Edit</a>

                    <form method="POST"
                          action="{{ route('admin.departments.destroy', $dept) }}"
                          class="inline"
                          onsubmit="return confirm('Delete this department?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                    No departments yet. Create one!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t">
        {{ $departments->links() }}
    </div>
</div>
@endsection