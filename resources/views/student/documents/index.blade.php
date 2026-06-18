@extends('layouts.student')
@section('title', 'Documents')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Browse Documents</h2>

{{-- Search & Filters --}}
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('student.documents.index') }}"
          class="grid grid-cols-2 md:grid-cols-4 gap-3">

        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search documents..."
               class="border rounded px-3 py-2 col-span-2 md:col-span-1">

        <select name="course_id" class="border rounded px-3 py-2">
            <option value="">All Courses</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}"
                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->code }}
                </option>
            @endforeach
        </select>

        <select name="category" class="border rounded px-3 py-2">
            <option value="">All Categories</option>
            <option value="handout"       {{ request('category') == 'handout'       ? 'selected' : '' }}>Handouts</option>
            <option value="past_question" {{ request('category') == 'past_question' ? 'selected' : '' }}>Past Questions</option>
            <option value="textbook"      {{ request('category') == 'textbook'      ? 'selected' : '' }}>Textbooks</option>
            <option value="note"          {{ request('category') == 'note'          ? 'selected' : '' }}>Lecture Notes</option>
            <option value="assignment"    {{ request('category') == 'assignment'    ? 'selected' : '' }}>Assignments</option>
        </select>

        <select name="level_id" class="border rounded px-3 py-2">
            <option value="">All Levels</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}"
                    {{ request('level_id') == $level->id ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 col-span-2 md:col-span-1">
            Search
        </button>

        @if(request()->hasAny(['search', 'course_id', 'category', 'level_id']))
        <a href="{{ route('student.documents.index') }}"
           class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50 text-center">
            Clear
        </a>
        @endif
    </form>
</div>

{{-- Document Cards --}}
@if($documents->isEmpty())
    <div class="bg-white rounded-lg shadow p-12 text-center text-gray-400">
        <p class="text-lg">No documents found.</p>
        <p class="text-sm mt-1">Try adjusting your filters.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($documents as $doc)
        <div class="bg-white rounded-lg shadow p-5 hover:shadow-md transition-shadow">

            {{-- Category Badge --}}
            <div class="flex justify-between items-start mb-3">
                <span class="bg-{{ $doc->category_color }}-100 text-{{ $doc->category_color }}-700
                             px-2 py-1 rounded text-xs font-medium">
                    {{ $doc->category_label }}
                </span>
                <span class="text-gray-400 text-xs">{{ $doc->file_size_formatted }}</span>
            </div>

            {{-- Title --}}
            <h3 class="font-semibold text-gray-800 mb-1 leading-snug">
                {{ $doc->title }}
            </h3>

            {{-- Course & Uploader --}}
            <p class="text-sm text-gray-500 mb-1">
                📚 {{ $doc->course->code ?? '—' }}
            </p>
            <p class="text-xs text-gray-400 mb-4">
                By {{ $doc->uploader->name ?? 'Unknown' }}
                · {{ $doc->created_at->format('d M Y') }}
            </p>

            {{-- Description --}}
            @if($doc->description)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                {{ $doc->description }}
            </p>
            @endif

            {{-- Footer --}}
            <div class="flex justify-between items-center pt-3 border-t">
                <span class="text-xs text-gray-400">
                    ⬇️ {{ $doc->download_count }} downloads
                </span>
                <a href="{{ route('student.documents.download', $doc) }}"
                   class="bg-emerald-600 text-white text-sm px-4 py-1.5 rounded hover:bg-emerald-700">
                    Download
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $documents->links() }}</div>
@endif
@endsection