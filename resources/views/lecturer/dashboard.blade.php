@extends('layouts.admin')
@section('title', 'Lecturer Dashboard')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-8">
    Welcome, {{ auth()->user()->lecturer->title ?? '' }} {{ auth()->user()->name }} 👨‍🏫
</h2>

<div class="grid grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 uppercase">Documents Uploaded</p>
        <p class="text-3xl font-bold mt-1">{{ $stats['my_uploads'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 uppercase">Total Downloads</p>
        <p class="text-3xl font-bold mt-1">{{ $stats['total_downloads'] }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold text-gray-700 mb-4">Recent Uploads</h3>
    @forelse($recentDocuments as $doc)
        <div class="flex justify-between py-2 border-b last:border-0">
            <span>{{ $doc->title }}</span>
            <span class="text-gray-400 text-sm">{{ $doc->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <p class="text-gray-400">No documents uploaded yet.</p>
    @endforelse
</div>
@endsection