<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Http\DTOs\EditEnrollmentResultDTO;

class EnrollmentController extends Controller {
    
    public function getEnrollment($id) {
        $result = $this->getData($id);
        return view("enrollment", ["result" => $result]);
    }

    protected function getData($id) {
        $student = Session::get('user');
        $id_student = $student->id;

        $result = new EditEnrollmentResultDTO;

        $course = Course::where('id_course', $id)->first();
        if($course) {
            $result->id_course = $course->id_course;
            $result->course_name = $course->name;
            $result->course_date_start = Carbon::parse($course->date_start)->format('d-m-Y');
            $result->course_date_end = Carbon::parse($course->date_end)->format('d-m-Y');
        }

        $enrollment = Enrollment::where(['id_student'=>$id_student, 'id_course'=>$id])->first();
        if($enrollment) {
            $result->id_enrollment = $enrollment->id_enrollment;
            $result->id_student = $enrollment->id_student;
            $result->status = $enrollment->status;
        }

        return $result;
    }

    protected function saveEnrollment($id) {
        $student = Session::get('user');
        $id_student = $student->id;

        $enrollment = Enrollment::where(['id_student'=>$id_student, 'id_course'=>$id])->first();
        if($enrollment) {
            if($enrollment->status == 1) {
                $enrollment->status = 0;
            } else {
                $enrollment->status = 1;
            }
        } else {
            $enrollment = new Enrollment;
            $enrollment->id_student = $id_student;
            $enrollment->id_course = $id;
            $enrollment->status = 1;
        }

        $enrollment->save();

        return redirect()->route('courses');
    }
}