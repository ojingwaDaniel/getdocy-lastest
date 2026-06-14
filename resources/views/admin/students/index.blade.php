@extends('layouts.admin')
@section('title', 'Students')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Students</h2>
    <a href="{{ route('admin.students.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Student
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Name</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Matric No.</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Email</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Department</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Level</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $student->name }}</td>
                <td class="px-6 py-4 font-mono text-sm">{{ $student->student->matric_number ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $student->email }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $student->department->name ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $student->student->level->name ?? '—' }}</td>
               <td class="px-6 py-4 space-x-2">
    <a href="{{ route('admin.students.edit', $student) }}"
       class="text-blue-600 hover:underline text-sm">Edit</a>

    <form method="POST"
          action="{{ route('admin.students.destroy', $student) }}"
          class="inline"
          onsubmit="return confirm('Remove this student?')">
        @csrf
        @method('DELETE')
        <button class="text-red-500 hover:underline text-sm">Remove</button>
    </form>
</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">No students yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $students->links() }}</div>
</div>
@endsection