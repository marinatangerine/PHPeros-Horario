<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\MarksController;
use App\Http\DTOs\SignUpResultDTO;


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
Route::get('/teachers/{id}', [TeacherController::class, 'getTeacher']);
Route::post('/teachers/{id}', [TeacherController::class, 'updateTeacher']);
Route::get('/teachers/{id}/delete', [TeacherController::class, 'deleteTeacher']);
Route::get('/courses/{id}', [CourseController::class, 'getCourse']);
Route::post('/courses/{id}', [CourseController::class, 'updateCourse']);
Route::get('/courses/{id}/delete', [CourseController::class, 'deleteCourse']);
Route::get('/subjects/{id}', [SubjectController::class, 'getSubject']);
Route::post('/subjects/{id}', [SubjectController::class, 'updateSubject']);
Route::get('/subjects/{id}/delete', [SubjectController::class, 'deleteSubject']);
Route::get('/subjects/{id}/schedule', [ScheduleController::class, 'getSchedule']);
Route::post('/subjects/{id}/schedule', [ScheduleController::class, 'saveSchedule']);
Route::get('/schedules/{id}/delete', [ScheduleController::class, 'deleteSchedule']);
Route::get('/courses/{id}/enrollment', [EnrollmentController::class, 'getEnrollment']);
Route::post('/courses/{id}/enrollment', [EnrollmentController::class, 'saveEnrollment']);
Route::get('/calendar', [CalendarController::class, 'getCalendarData'])->name('calendar');;
Route::get('/subjects/{id}/scheduleexam', [ExamController::class, 'getExamsData']);
Route::post('/subjects/{id}/scheduleexam', [ExamController::class, 'saveExam']);
Route::get('/exams/{id}/delete', [ExamController::class, 'deleteExam']);
Route::get('/subjects/{id}/schedulework', [WorkController::class, 'getWorksData']);
Route::post('/subjects/{id}/schedulework', [WorkController::class, 'saveWork']);
Route::get('/works/{id}/delete', [WorkController::class, 'deleteWork']);
Route::get('/exams/{id}/marks', [MarksController::class, 'getExamMarks']);
Route::get('/works/{id}/marks', [MarksController::class, 'getWorkMarks']);
Route::post('/exams/{id}/marks', [MarksController::class, 'saveExamMarks']);
Route::post('/works/{id}/marks', [MarksController::class, 'saveWorkMarks']);
Route::get('/subjects/{id}/percentages', [SubjectController::class, 'getSubjectPercentages']);
Route::post('/subjects/{id}/percentages', [SubjectController::class, 'saveSubjectPercentages']);