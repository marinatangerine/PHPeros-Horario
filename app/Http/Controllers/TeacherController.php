<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
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
            $result->username = $item->username;
            $result->name = $item->name;
            $result->surname = $item->surname;
            $result->nif = $item->nif;
            $result->email = $item->email;
            $result->telephone = $item->telephone;
            $result->hasChildren = Subject::where('id_teacher', $item->id_teacher)->count() > 0;
            $data->items[] = $result;
        }

        return view("list", ["data" => $data]);       
    }

    public function getTeacher($id){
        if ($id == 'new') {
            $result = new EditTeacherResultDTO;
            $result->formTitle = 'Crear Profesor';
        } else {
            $item = Teacher::where('id_teacher', $id)->first();
            if ($item) {
                $result = new EditTeacherResultDTO;
                $result->username = $item->username;
                $result->name = $item->name;
                $result->surname = $item->surname;
                $result->nif = $item->nif;
                $result->email = $item->email;
                $result->telephone = $item->telephone;
                $result->id_teacher = $item->id_teacher;
                $result->formTitle = 'Editar Profesor';
            }            
        }
        return view("editTeacher", ["result" => $result]);
    }

    public function updateTeacher($id, Request $request) {
        $username=$request->username;
        $name=$request->name;
        $email=$request->email;
        $surname=$request->surname;
        $nif=$request->nif;
        $telephone=$request->telephone;
    
        $validationErrors = 0;

        if ($id == 'new') {
            $user = new Teacher;
        } else {
            $user = Teacher::where('id_teacher', $id)->first();
        }

        if($username != $user->username) {
            $dbUser = Student::where('username', $username)->first();
            if ($dbUser) {
                $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
                $validationErrors++;
            }

            $dbUser = Teacher::where('username', $username)->first();
            if ($dbUser) {
                $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
                $validationErrors++;
            }

            $dbUser = UsersAdmin::where('username', $username)->first();
            if ($dbUser) {
                $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
                $validationErrors++;
            }
        }

        if ($email != $user->email || $id == 'new') {
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

        if ($nif != $user->nif || $id == 'new') {
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
        $result->username = $username;
        $result->name = $name;
        $result->email = $email;
        $result->nif = $nif;
        $result->surname = $surname;
        $result->telephone = $telephone;

        if ($validationErrors == 0) {
            $user->username = $username;
            $user->name = $name;
            $user->email = $email;
            $user->nif = $nif;
            $user->surname = $surname;
            $user->telephone = $telephone;
            $user->pass = '123';

            try {
                //guardamos el modelo
                $user->save();
                //si teacher.save no falla, marcamos el success de nuestro DTO a true
                $result->success = true;
            } catch (\Exception $ex) {
                $result->serverError = $ex->getMessage();
                $result->success = false;
                return view('editTeacher', ['id'=>$id, 'result' => $result]);
            }
        } else {
            $result->success = false;
            $result->validationErrors = $validationErrors ?? 0;
            $result->errorUserName = $errorUserName ?? '';
            $result->errorEmail = $errorEmail ?? '';
            $result->errorNIF = $errorNIF ?? '';
            return view('editTeacher', ['id'=>$id, 'result' => $result]);
        }

        return redirect()->route('teachers');
    }

    public function deleteTeacher($id) {
        Teacher::where('id_teacher', $id)->delete();
        return redirect()->route('teachers');
    }

}