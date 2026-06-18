@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-8">
    Welcome back, {{ auth()->user()->name }} 👋
</h2>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 uppercase tracking-wide">Total Students</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_students'] }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 uppercase tracking-wide">Total Lecturers</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_lecturers'] }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <p class="text-sm text-gray-500 uppercase tracking-wide">Departments</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_departments'] }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500 uppercase tracking-wide">Total Courses</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_courses'] }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-sm text-gray-500 uppercase tracking-wide">Documents</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_documents'] }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
    <p class="text-sm text-gray-500 uppercase tracking-wide">Pending Approval</p>
    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_documents'] }}</p>
    @if($stats['pending_documents'] > 0)
        <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}"
           class="text-orange-600 text-sm hover:underline mt-1 block">
            Review now →
        </a>
    @endif
</div>
</div>

{{-- Quick Links --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.departments.create') }}"
       class="bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700">
        + Add Department
    </a>
    <a href="{{ route('admin.lecturers.create') }}"
       class="bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700">
        + Add Lecturer
    </a>
    <a href="{{ route('admin.students.create') }}"
       class="bg-purple-600 text-white text-center py-3 rounded-lg hover:bg-purple-700">
        + Add Student
    </a>
</div>
@endsection