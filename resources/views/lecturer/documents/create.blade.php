@extends('layouts.lecturer')
@section('title', 'Upload Document')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Upload Document</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST"
              action="{{ route('lecturer.documents.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Document Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="e.g. Introduction to Data Structures - Week 1"
                       class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Category</label>
                <select name="category"
                        class="w-full border rounded px-3 py-2 @error('category') border-red-500 @enderror">
                    <option value="">— Select Category —</option>
                    <option value="handout"       {{ old('category') == 'handout'       ? 'selected' : '' }}>Handout</option>
                    <option value="past_question" {{ old('category') == 'past_question' ? 'selected' : '' }}>Past Question</option>
                    <option value="textbook"      {{ old('category') == 'textbook'      ? 'selected' : '' }}>Textbook</option>
                    <option value="note"          {{ old('category') == 'note'          ? 'selected' : '' }}>Lecture Note</option>
                    <option value="assignment"    {{ old('category') == 'assignment'    ? 'selected' : '' }}>Assignment</option>
                    <option value="other"         {{ old('category') == 'other'         ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Course</label>
                <select name="course_id"
                        class="w-full border rounded px-3 py-2 @error('course_id') border-red-500 @enderror">
                    <option value="">— Select Course —</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->code }} — {{ $course->title }} ({{ $course->level->name }})
                        </option>
                    @endforeach
                </select>
                @error('course_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">
                    Description
                    <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea name="description" rows="3"
                          placeholder="Brief description of the document content..."
                          class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">File</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center
                            hover:border-indigo-400 transition-colors">
                    <input type="file"
                           name="file"
                           id="file"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx"
                           class="hidden"
                           onchange="updateFileLabel(this)">
                    <label for="file" class="cursor-pointer">
                        <div class="text-4xl mb-2">📄</div>
                        <p class="text-gray-600" id="file-label">
                            Click to select a file
                        </p>
                        <p class="text-gray-400 text-sm mt-1">
                            PDF, DOC, DOCX, PPT, PPTX — Max 20MB
                        </p>
                    </label>
                </div>
                @error('file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Upload notice --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-6 text-sm text-yellow-800">
                ⚠️ Documents require admin approval before students can access them.
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Upload Document
                </button>
                <a href="{{ route('lecturer.documents.index') }}"
                   class="px-6 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function updateFileLabel(input) {
    const label = document.getElementById('file-label');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const size = (file.size / 1024 / 1024).toFixed(2);
        label.textContent = `${file.name} (${size} MB)`;
        label.classList.add('text-indigo-600', 'font-medium');
    }
}
</script>
@endsection