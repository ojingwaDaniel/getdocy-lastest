@extends('layouts.student') 
@section('title', 'Student Dashboard')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-8">
    Welcome, {{ auth()->user()->name }} 🎓
</h2>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold text-gray-700 mb-4">Recent Documents in Your Department</h3>
    @forelse($recentDocuments as $doc)
        <div class="flex justify-between items-center py-3 border-b last:border-0">
            <div>
                <p class="font-medium">{{ $doc->title }}</p>
                <p class="text-sm text-gray-400">{{ $doc->course->code }}</p>
            </div>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                {{ $doc->type }}
            </span>
        </div>
    @empty
        <p class="text-gray-400">No documents available yet.</p>
    @endforelse
</div>
@endsection