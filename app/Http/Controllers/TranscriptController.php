<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamMark;
use App\Models\WorkMark;
use App\Http\DTOs\TranscriptResultDTO;
use App\Http\DTOs\TranscriptSubjectResultDTO;
use App\Http\DTOs\TranscriptExamResultDTO;
use App\Http\DTOs\TranscriptWorkResultDTO;


class TranscriptController extends Controller 
{
    public function getUserData() {
        $id = Session::get('user')->id;
        $data = $this->getData($id);
        return view("transcript", ["data" => $data]);
    }

    public function getStudentData($id) {
        $id_student = $id;
        $data = $this->getData($id);
        return view("transcript", ["data" => $data]);
    }

    protected function getData($id_student){
        $student = Student::where('id', $id_student)->first();
        $data = new TranscriptResultDTO;
        $data->id_student = $id_student;
        $data->name = $student->name . ' ' . $student->surname;
        
        $subjects = Subject::with('course', 'percentages')->get();
        foreach ($subjects as $subject) {
            $course = $subject->course;
            $id_class = $subject->id_class;

            $subjectDTO = new TranscriptSubjectResultDTO;
            $subjectDTO->id_class = $subject->id_class;
            $subjectDTO->name = $subject->name;
            $subjectDTO->courseName = $course->name;

            $examCount = 0;
            $examSum = 0;
            $examAvg = null;
            $examMarks = ExamMark::with('exam')->where('id_student', $id_student)->whereHas('exam', function($q) use($id_class) { $q->where('id_class', $id_class); })->get();
            if(count($examMarks) > 0) {
                foreach ($examMarks as $examMark) {
                    $exam = $examMark->exam;

                    $examDTO = new TranscriptExamResultDTO;
                    $examDTO->id_exam = $exam->id_exam;
                    $examDTO->name = $exam->name;
                    $examDTO->date = $exam->date;
                    $examDTO->mark = $examMark->mark;

                    $subjectDTO->exams[] = $examDTO;

                    $examSum += $examMark->mark;
                    $examCount++;
                }

                $examAvg = $examSum / $examCount;
            }

            $workCount = 0;
            $workSum = 0;
            $workAvg = null;
            $workMarks = WorkMark::with('work')->where('id_student', $id_student)->whereHas('work', function($q) use($id_class) { $q->where('id_class', $id_class); })->get();
            if(count($workMarks) > 0) {
                foreach ($workMarks as $workMark) {
                    $work = $workMark->work;

                    $workDTO = new TranscriptWorkResultDTO;
                    $workDTO->id_work = $work->id_work;
                    $workDTO->name = $work->name;
                    $workDTO->date = $work->date;
                    $workDTO->mark = $workMark->mark;

                    $subjectDTO->works[] = $workDTO;

                    $workSum += $workMark->mark;
                    $workCount++;
                }

                $workAvg = $workSum / $workCount;
            }

            $subjectDTO->exams_avg_mark = $examAvg ?? '';
            $subjectDTO->works_avg_mark = $workAvg ?? '';

            $percentage = $subject->percentages->first();
            if($percentage && $examAvg && $workAvg) {
                $examPonderated = ($examAvg * $percentage->exams) / 100;
                $workPonderated = ($workAvg * $percentage->continuous_assessment) / 100;
                $subjectDTO->avg_mark = $examPonderated + $workPonderated;
            }

            $data->subjects[] = $subjectDTO;
        }

        return $data;
    }
}