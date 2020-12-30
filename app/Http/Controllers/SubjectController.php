<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetSubjectsResultDTO;


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
}