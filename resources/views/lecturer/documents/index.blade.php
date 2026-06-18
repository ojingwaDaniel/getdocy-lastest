@extends('layouts.lecturer')
@section('title', 'My Documents')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">My Uploads</h2>
    <a href="{{ route('lecturer.documents.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + Upload Document
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Title</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Category</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Course</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Size</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Status</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Uploaded</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($documents as $doc)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $doc->title }}</p>
                    @if($doc->description)
                        <p class="text-gray-400 text-xs mt-1">{{ Str::limit($doc->description, 60) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="bg-{{ $doc->category_color }}-100 text-{{ $doc->category_color }}-700 px-2 py-1 rounded text-xs font-medium">
                        {{ $doc->category_label }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm">
                    {{ $doc->course->code ?? '—' }}
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">
                    {{ $doc->file_size_formatted }}
                </td>
                <td class="px-6 py-4">
                    @if($doc->isPending())
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                            Pending
                        </span>
                    @elseif($doc->isApproved())
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                            Approved
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                            Rejected
                        </span>
                        @if($doc->rejection_reason)
                            <p class="text-red-500 text-xs mt-1">{{ $doc->rejection_reason }}</p>
                        @endif
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-400 text-sm">
                    {{ $doc->created_at->diffForHumans() }}
                </td>
                <td class="px-6 py-4">
                    @if($doc->isPending())
                        <form method="POST"
                              action="{{ route('lecturer.documents.destroy', $doc) }}"
                              class="inline"
                              onsubmit="return confirm('Delete this document?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline text-sm">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    <p class="text-lg mb-2">No documents uploaded yet.</p>
                    <a href="{{ route('lecturer.documents.create') }}"
                       class="text-indigo-600 hover:underline">Upload your first document →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $documents->links() }}</div>
</div>
@endsection