<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Lecturer\DashboardController as LecturerDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\StudentRegisterController;

Route::get('/', function () {
    return view('welcome');
});

//public routes
Route::post('/students/register', [StudentRegisterController::class, 'store'])
    ->name('students.register');


    Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('lecturer')) {
        return redirect()->route('lecturer.dashboard');
    }

    if ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }

    abort(403);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

 
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('departments', DepartmentController::class);
        Route::resource('levels', LevelController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('lecturers', LecturerController::class);
        Route::resource('students', StudentController::class);
        Route::get('/documents/create', [App\Http\Controllers\Admin\DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [App\Http\Controllers\Admin\DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents', [App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('documents.index');
        Route::patch('/documents/{document}/approve', [App\Http\Controllers\Admin\DocumentController::class, 'approve'])->name('documents.approve');
        Route::patch('/documents/{document}/reject', [App\Http\Controllers\Admin\DocumentController::class, 'reject'])->name('documents.reject');
        Route::delete('/documents/{document}', [App\Http\Controllers\Admin\DocumentController::class, 'destroy'])->name('documents.destroy');
        
                
    });

 
    Route::middleware('role:lecturer')->prefix('lecturer')->name('lecturer.')->group(function () {
        Route::get('/dashboard', [LecturerDashboard::class, 'index'])->name('dashboard');
        Route::get('/documents', [App\Http\Controllers\Lecturer\DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [App\Http\Controllers\Lecturer\DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [App\Http\Controllers\Lecturer\DocumentController::class, 'store'])->name('documents.store');
        Route::delete('/documents/{document}', [App\Http\Controllers\Lecturer\DocumentController::class, 'destroy'])->name('documents.destroy');
    });

  
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboard::class,'index'])->name('dashboard');
         Route::get('/documents', [App\Http\Controllers\Student\DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/{document}/download', [App\Http\Controllers\Student\DocumentController::class, 'download'])->name('documents.download');
    
    });

});

require __DIR__.'/auth.php';
