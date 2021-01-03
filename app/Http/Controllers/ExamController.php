<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Exam;
use App\Http\DTOs\CreateExamResultDTO;
use App\Http\DTOs\GetExamResultDTO;

class ExamController extends Controller
{
    public function getExamsData($id) {
        $result = $this->getData($id);
        return view("exam", ["result" => $result]);
    }

    protected function getData($id){
        $subject = Subject::with('course', 'teacher')->where('id_class', $id)->first();
        if($subject) {
            $course = $subject->course;
            $teacher = $subject->teacher;

            $result = new CreateExamResultDTO;
            $result->id_class = $subject->id_class;
            $result->name_class = $subject->name;
            $result->course_start = Carbon::parse($course->date_start)->format('d-m-Y');
            $result->course_end = Carbon::parse($course->date_end)->format('d-m-Y');

            $items = Exam::where('id_class', $id)->get();
            foreach($items as $item) {
                $itemDTO = new GetExamResultDTO;
                $itemDTO->id_exam = $item->id_exam;
                $itemDTO->date = Carbon::parse($item->date)->format('d-m-Y h:i');
                $itemDTO->name = $item->name;
                $itemDTO->course_name = $course->name;
                $itemDTO->teacher_name = $teacher->name .' '. $teacher->surname;
                $result->items[] = $itemDTO;
            }
            return $result;
        }
    }

    public function saveExam($id, Request $request) {
        $id_class = $id;
        $date = $request->date;
        $name = $request->name;

        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $dateCmp = strtotime($date);
        $datestartCmp = strtotime($min_date);
        $dateendCmp = strtotime($max_date);
        if($dateCmp < $datestartCmp || $dateCmp > $dateendCmp) {
            $result = $this->getData($id);
            $result->date = $request->date;
            $result->name = $request->name;
            $result->dateError = "La fecha debe estar entre el $min_date y el $max_date";
            $result->success = false;
        } else {
            $exam = new Exam;
            $exam->id_class = $id_class;
            $exam->date = $date;
            $exam->name = $name;

            $exam->save();
            $result = $this->getData($id);
            $result->success = true;
        }
        return view("exam", ["result" => $result]);
    }

    public function deleteExam($id) {
        $exam = Exam::where('id_exam', $id)->first();
        $id_class = $exam->id_class;
        $exam->delete();
        $result = $this->getData($id_class);
        return view("exam", ["result" => $result]);
    }
}
