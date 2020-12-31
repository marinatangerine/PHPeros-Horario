<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetSubjectsResultDTO;
use App\Http\DTOs\EditSubjectResultDTO;
use App\Http\DTOs\SelectResultDTO;


class SubjectController extends Controller 
{
    public function getSubjects(){
        $data = new ListResultDTO;
        $data->itemType = "subject";
        $data->listName = "Clases";
        $data->editItemUrl = "subjects";
        $data->newItemText = "Crear clase";

        $items = Subject::with('teacher', 'course')->get();
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
            $data->items[] = $result;
        }
        return view("list", ["data" => $data]);        
    }

    public function getSubject($id) {
        $result = new EditSubjectResultDTO;
        $result->teachers = Teacher::pluck('id_teacher', 'name');
        $result->courses = Course::pluck('id_course', 'name');
        $result->colors = Color::pluck('name');

        if($id == 'new') {
            $result->formTitle = 'Crear Clase';
        } else {
            $item = Subject::where('id_class', $id)->first();
            if ($item) {
                $result->name = $item->name;
                $result->color = $item->color;
                $result->id_teacher = $item->id_teacher;
                $result->id_course = $item->id_course;
            }
        }
        return view("editSubject", ["result" => $result]);
    }

    public function updateSubject($id, Request $request) {
        $name = $request->name;
        $color = $request->color;
        $teacherName = $request->teacherName;
        $courseName = $request->courseName;
        $courseActive = $request->courseActive;

        if($request->courseActive) {
            
        }
    }
}