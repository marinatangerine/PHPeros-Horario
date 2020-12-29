<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetCoursesResultDTO;


class CourseController extends Controller 
{
    public function getCourses(){
        $data = new ListResultDTO;
        $data->itemType = "course";
        $data->listName = "Cursos";
        $data->editItemUrl = "courses";
        $data->newItemText = "Crear curso";

        foreach (Course::all() as $item) {
            $result = new GetCoursesResultDTO;
            $result->id_course = $item->id_course;
            $result->name = $item->name;
            $result->description = $item->description;
            $result->date_start = $item->date_start;
            $result->date_end = $item->date_end;
            $data->items[] = $result;
        }

        return view("list", ["data" => $data]);        
    }
}