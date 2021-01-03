<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Work;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Student;
use App\Models\ExamMark;
use App\Models\WorkMark;
use App\Http\DTOs\SetMarksResultDTO;
use App\Http\DTOs\GetStudentMarkResultDTO;

class MarksController extends Controller
{
    public function getExamMarks($id) {
        $data = $this->getData($id, 'exam');

        return view('marks', ["data" => $data]);
    }

    public function getWorkMarks($id) {
        $data = $this->getData($id, 'work');

        return view('marks', ["data" => $data]);
    }

    public function saveExamMarks($id, Request $request) {
        ExamMark::where('id_exam', $id)->delete();

        $fields = $request->all();
        foreach ($fields as $key => $value) {
            if(substr($key, 0, 4) == 'mark' && $value) {
                $id_student = substr($key, 5);

                $mark = new ExamMark;
                $mark->id_exam = $id;
                $mark->id_student = $id_student;
                $mark->mark = $value;
                $mark->save();
            }
        }

        $data = $this->getData($id, 'exam');
        $data->success = true;
        return view('marks', ["data" => $data]);
    }

    public function saveWorkMarks($id, Request $request) {
        WorkMark::where('id_work', $id)->delete();

        $fields = $request->all();
        foreach ($fields as $key => $value) {
            if(substr($key, 0, 4) == 'mark' && $value) {
                $id_student = substr($key, 5);

                $mark = new WorkMark;
                $mark->id_work = $id;
                $mark->id_student = $id_student;
                $mark->mark = $value;
                $mark->save();
            }
        }

        $data = $this->getData($id, 'work');
        $data->success = true;
        return view('marks', ["data" => $data]);
    }

    protected function getData($id, $type){
        $result = new SetMarksResultDTO;
        switch ($type) {
            case 'work':
                $entity = Work::with('subject', 'work_marks')->where('id_work', $id)->first();
                $marks_entity = $entity->work_marks;
                $result->action = 'works';
                $result->back = 'schedulework';
                break;
            case 'exam':
                $entity = Exam::with('subject', 'exam_marks')->where('id_exam', $id)->first();
                $marks_entity = $entity->exam_marks;
                $result->action = 'exams';
                $result->back = 'scheduleexam';
                break;
        }

        $subject = Subject::where('id_class', $entity->id_class)->first();
        $id_course = $subject->id_course;

        $result->id = $id;
        $result->type = $type;
        $result->name = $entity->name;
        $result->date = $entity->date;
        $result->id_class = $subject->id_class;

        $items = Student::whereHas('enrollments', function($q) use($id_course) { $q->where(['id_course'=>$id_course, 'status'=>'1']); })->get();
        foreach ($items as $item) {
            $itemDTO = new GetStudentMarkResultDTO;
            $itemDTO->id_student = $item->id;
            $itemDTO->name = $item->name;
            $itemDTO->surname = $item->surname;
            $itemDTO->nif = $item->nif;
            $mark = $marks_entity->where('id_student', $item->id)->first();
            if($mark) {
                $itemDTO->mark = $mark->mark;
            }

            $result->items[] = $itemDTO;
        }

        return $result;
    }
}
