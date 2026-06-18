@extends('layouts.admin')
@section('title', 'Documents')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Documents</h2>
        @if($pendingCount > 0)
            <p class="text-yellow-600 text-sm mt-1">
                ⚠️ {{ $pendingCount }} document(s) awaiting approval
            </p>
        @endif
    </div>
</div>

{{-- Filters --}}
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('admin.documents.index') }}"
          class="flex gap-3 flex-wrap">

        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search title..."
               class="border rounded px-3 py-2 flex-1 min-w-48">

        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Statuses</option>
            <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <button type="submit"
                class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
            Filter
        </button>

        <a href="{{ route('admin.documents.index') }}"
           class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">
            Clear
        </a>
    </form>
</div>

{{-- Documents Table --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-gray-600 font-semibold">Document</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Uploaded By</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Course</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Category</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Status</th>
                <th class="px-6 py-3 text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($documents as $doc)
            <tr class="hover:bg-gray-50 {{ $doc->isPending() ? 'bg-yellow-50' : '' }}">
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $doc->title }}</p>
                    <p class="text-gray-400 text-xs">
                        {{ $doc->file_type }} · {{ $doc->file_size_formatted }}
                        · {{ $doc->created_at->format('d M Y') }}
                    </p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $doc->uploader->name ?? '—' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $doc->course->code ?? '—' }}
                    <br>
                    <span class="text-xs text-gray-400">
                        {{ $doc->course->department->name ?? '' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                        {{ $doc->category_label }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($doc->isPending())
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Pending</span>
                    @elseif($doc->isApproved())
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Approved</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Rejected</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col gap-1">

                        {{-- Approve --}}
                        @if(!$doc->isApproved())
                        <form method="POST"
                              action="{{ route('admin.documents.approve', $doc) }}">
                            @csrf @method('PATCH')
                            <button class="text-green-600 hover:underline text-sm">✓ Approve</button>
                        </form>
                        @endif

                        {{-- Reject --}}
                        @if(!$doc->isRejected())
                        <button onclick="showRejectModal({{ $doc->id }}, '{{ addslashes($doc->title) }}')"
                                class="text-red-500 hover:underline text-sm text-left">
                            ✗ Reject
                        </button>
                        @endif

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('admin.documents.destroy', $doc) }}"
                              onsubmit="return confirm('Permanently delete this document?')">
                            @csrf @method('DELETE')
                            <button class="text-gray-400 hover:text-red-500 hover:underline text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            {{-- Reject reason modal row (hidden) --}}
            <tr id="reject-row-{{ $doc->id }}" class="hidden bg-red-50">
                <td colspan="6" class="px-6 py-4">
                    <form method="POST"
                          action="{{ route('admin.documents.reject', $doc) }}"
                          class="flex gap-3 items-start">
                        @csrf @method('PATCH')
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-red-700 mb-1">
                                Rejection reason for: <em id="reject-title-{{ $doc->id }}"></em>
                            </label>
                            <textarea name="rejection_reason"
                                      rows="2"
                                      required
                                      placeholder="Explain why this document is being rejected..."
                                      class="w-full border border-red-300 rounded px-3 py-2 text-sm"></textarea>
                        </div>
                        <div class="flex flex-col gap-2 mt-5">
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                                Confirm Reject
                            </button>
                            <button type="button"
                                    onclick="hideRejectModal({{ $doc->id }})"
                                    class="text-gray-500 text-sm hover:underline">
                                Cancel
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    No documents found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $documents->links() }}</div>
</div>

<script>
function showRejectModal(id, title) {
    document.getElementById('reject-row-' + id).classList.remove('hidden');
    document.getElementById('reject-title-' + id).textContent = title;
}
function hideRejectModal(id) {
    document.getElementById('reject-row-' + id).classList.add('hidden');
}
</script>
@endsection