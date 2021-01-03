<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Color;
use App\Models\Schedule;
use App\Models\Work;
use App\Models\Exam;
use App\Models\Percentage;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetSubjectsResultDTO;
use App\Http\DTOs\EditSubjectResultDTO;
use App\Http\DTOs\SelectResultDTO;
use App\Http\DTOs\EditSubjectPercentagesResultDTO;


class SubjectController extends Controller 
{
    public function getSubjects(){
        $role = Session::get('role');
        $user = Session::get('user');

        $data = new ListResultDTO;
        $data->itemType = "subject";
        $data->listName = "Clases";
        $data->editItemUrl = "subjects";
        $data->newItemText = "Crear clase";

        if($role == 1) {
            $items = Subject::with('teacher', 'course')->get();
        } else {
            $id_teacher = $user->id_teacher;
            $items = Subject::with('teacher', 'course')->where('id_teacher', $id_teacher)->get();
        }

        foreach ($items as $item) {
            $teacher = $item->teacher;
            $course = $item->course;

            $result = new GetSubjectsResultDTO;
            $result->id_class = $item->id_class;
            $result->name = $item->name;
            $result->color = $item->color;
            $result->teacherName = $teacher->name .' '. $teacher->surname;
            $result->courseName = $course->name;
            $result->courseActive = $course->active;
            $result->hasChildren = (Schedule::where('id_class', $item->id_class)->count()) + (Work::where('id_class', $item->id_class)->count()) + (Exam::where('id_class', $item->id_class)->count()) > 0;

            $data->items[] = $result;
        }
        return view("list", ["data" => $data]);        
    }

    public function getSubject($id) {
        $result = new EditSubjectResultDTO;
        $result->id_class = $id;

        $teachers = Teacher::doesntHave('subjects')->get();
        foreach ($teachers as $teacher) {
            $teachersResult = new SelectResultDTO;
            $teachersResult->id = $teacher->id_teacher;
            $teachersResult->name = $teacher->name .' '. $teacher->surname;
            $result->teachers[] = $teachersResult;
        }

        if($id == 'new' && count($teachers) == 0) {
            $result->emptyDropDowns++;
        }
        
        $courses = Course::all('id_course', 'name');
        foreach ($courses as $course) {
            $coursesResult = new SelectResultDTO;
            $coursesResult->id = $course->id_course;
            $coursesResult->name = $course->name;
            $result->courses[] = $coursesResult;
        }

        if($id == 'new' && count($courses) == 0) {
            $result->emptyDropDowns++;
        }

        $colors = Color::doesntHave('subjects')->get();
        foreach ($colors as $color) {
            $colorsResult = new SelectResultDTO;
            $colorsResult->name = $color->name;
            $result->colors[] = $colorsResult;
        }

        if($id == 'new' && count($colors) == 0) {
            $result->emptyDropDowns++;
        }

        if($id == 'new') {
            $result->formTitle = 'Crear Clase';
        } else {
            $item = Subject::with('teacher')->where('id_class', $id)->first();
            if ($item) {
                $teacher = $item->teacher;
                $result->name = $item->name;
                $result->color = $item->color;
                $result->id_teacher = $item->id_teacher;
                $result->id_course = $item->id_course;
                $result->name_teacher = $teacher->name .' '. $teacher->surname;
            }
        }
        return view("editSubject", ["result" => $result]);
    }

    public function getSubjectPercentages($id) {
        $result = new EditSubjectPercentagesResultDTO;
        
        $subject = Subject::with('percentages')->where('id_class', $id)->first();
        $result->name = $subject->name;
        $result->id_class = $id;

        $percentages = $subject->percentages->first();
        if ($percentages) {
            $result->continuous_assessment = $percentages->continuous_assessment;
            $result->exams = $percentages->exams;
        }

        return view("editSubjectPercentages", ["result" => $result]);
    }

    public function saveSubjectPercentages($id, Request $request) {
        $continuous_assessment = $request->continuous_assessment;
        $exams = $request->exams;

        Percentage::where('id_class', $id)->delete();
        $percentage = new Percentage;
        $percentage->id_class = $id;
        $percentage->continuous_assessment = $continuous_assessment;
        $percentage->exams = $exams;
        $percentage->save();

        return redirect()->route('subjects');
    }

    public function updateSubject($id, Request $request) {
        $name = $request->name;
        $color = $request->color;
        $id_teacher = $request->id_teacher;
        $id_course = $request->id_course;

        if ($id == 'new') {
            $subject = new Subject;
        } else {
            $subject = Subject::where('id_class', $id)->first();
        }

        $subject->name = $name;
        $subject->id_teacher = $id_teacher;
        $subject->id_course = $id_course;
        $subject->color = $color;

        try{
            $subject->save();
        }catch(\Exception $ex) {
            $result->serverError = $ex->getMessage();
            $result->success = false;
            return view('editSubject', ['id'=>$id, 'result' => $result]);
        }

        return redirect()->route('subjects');

    }

    public function deleteSubject($id) {
        Subject::where('id_class', $id)->delete();
        return redirect()->route('subjects');
    }
}