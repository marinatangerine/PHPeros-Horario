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

        foreach (Subject::all() as $item) {
            $result = new GetSubjectsResultDTO;
            $result->id_class = $item->id_class;
            $result->name = $item->name;
            $result->color = $item->color;
            $result->teacherName = $item->teacherName;
            $result->courseName = $item->courseName;
            $result->courseActive = $item->courseActive;
            $data->items[] = $result;
        }

        return view("list", ["data" => $data]);        
    }
}