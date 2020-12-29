<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetTeachersResultDTO;


class TeacherController extends Controller 
{
    public function getTeachers(){
        $data = new ListResultDTO;
        $data->itemType = "teacher";
        $data->listName = "Profesores";
        $data->editItemUrl = "teachers";
        $data->newItemText = "Crear profesor";

        foreach (Teacher::all() as $item) {
            $result = new GetTeachersResultDTO;
            $result->id_teacher = $item->id_teacher;
            $result->name = $item->name;
            $result->surname = $item->surname;
            $result->nif = $item->nif;
            $result->email = $item->email;
            $result->telephone = $item->telephone;
            $data->items[] = $result;
        }

        return view("list", ["data" => $data]);        
    }
}