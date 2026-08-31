<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes - E-Learning Video Protection System
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('course.watch', ['slug' => 'mastering-web-development', 'lessonId' => 1]);
});

// Route untuk menonton materi kursus
Route::get('/course/{slug}/lesson/{lessonId}', [CourseController::class, 'watch'])
    ->name('course.watch');
