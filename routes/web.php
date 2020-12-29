<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\DTOs\SignUpResultDTO;
use App\Http\DTOs\EditUserResultDTO;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("index", ["errorLogin" => ""]);
})->name('index');

Route::get('/index', function () {
    return view("index", ["errorLogin" => ""]);
});

Route::get('/signup', function () {
    return view("signup", ["result" => new SignUpResultDTO]);
})->name('signup');

Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/signup', [UserController::class, 'signup']);
Route::get('/editUser', [UserController::class, 'loadUser'])->name('editUser');
Route::post('/editUser', [UserController::class, 'updateUser'])->name('editUser');
Route::get('/teachers', [TeacherController::class, 'getTeachers'])->name('teachers');
Route::get('/subjects', [SubjectController::class, 'getSubjects'])->name('subjects');
Route::get('/courses', [CourseController::class, 'getCourses'])->name('courses');
