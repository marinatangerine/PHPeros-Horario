<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UsersAdmin;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetTeachersResultDTO;
use App\Http\DTOs\EditTeacherResultDTO;


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

    public function getTeacher($id){
        $item = Teacher::where('id_teacher', $id)->first();
        if ($item) {
            $result = new EditTeacherResultDTO;
            $result->name = $item->name;
            $result->surname = $item->surname;
            $result->nif = $item->nif;
            $result->email = $item->email;
            $result->telephone = $item->telephone;
            $result->id_teacher = $item->id_teacher;

            return view("editTeacher", ["result" => $result]);
        }
    }

    public function updateTeacher($id, Request $request) {
        $name=$request->name;
        $email=$request->email;
        $surname=$request->surname;
        $nif=$request->nif;
        $telephone=$request->telephone;
    
        $validationErrors = 0;

        $user = Teacher::where('id_teacher', $id)->first();

        if ($email != $user->email) {
            $dbUser = Student::where('email', $email)->first();
            if ($dbUser) {
                $errorEmail = "Ya existe un usuario registrado con ese email";
                $validationErrors++;
            }

            $dbUser = Teacher::where('email', $email)->first();
            if ($dbUser) {
                $errorEmail = "Ya existe un usuario registrado con ese email";
                $validationErrors++;
            }

            $dbUser = UsersAdmin::where('email', $email)->first();
            if ($dbUser) {
                $errorEmail = "Ya existe un usuario registrado con ese email";
                $validationErrors++;
            }
        }

        if ($nif != $user->nif) {
            $dbUser = Student::where('nif', $nif)->first();
            if ($dbUser) {
                $errorNIF = "Ya existe un usuario registrado con ese NIF";
                $validationErrors++;
            }

            $dbUser = Teacher::where('nif', $nif)->first();
            if ($dbUser) {
                $errorNIF = "Ya existe un usuario registrado con ese NIF";
                $validationErrors++;
            }
        }

        $result = new EditTeacherResultDTO;
        $result->name = $name;
        $result->email = $email;
        $result->nif = $nif;
        $result->surname = $surname;
        $result->telephone = $telephone;

        if ($validationErrors == 0) {
            $user->name = $name;
            $user->email = $email;
            $user->nif = $nif;
            $user->surname = $surname;
            $user->telephone = $telephone;

            try {
                //guardamos el modelo
                $user->save();
                //si strudent.save no falla, marcamos el success de nuestro DTO a true
                $result->success = true;
            } catch (\Exception $ex) {
                $result->serverError = $ex->getMessage();
                $result->success = false;
                return view('editTeacher', ['id'=>$id, 'result' => $result]);
            }
        } else {
            $result->success = false;
            $result->validationErrors = $validationErrors ?? 0;
            $result->errorEmail = $errorEmail ?? '';
            $result->errorNIF = $errorNIF ?? '';
            return view('editTeacher', ['id'=>$id, 'result' => $result]);
        }

        return redirect()->route('teachers');
    }

}