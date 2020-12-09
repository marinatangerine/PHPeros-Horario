<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\DTOs\SignUpResultDTO;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UsersAdmin;

class UserController extends Controller
{
    public function login(Request $request) {
        //dd($request->all());
        $email = $request->email;
        $pass = $request->pass;

        $user = Student::where('email', $email)->first();
        if ($user) {
            if (password_verify($pass, $user->pass)) {
                $this->updateSessionData($user, 3);
            }
        } else {
            $user = Teacher::where('email', $email)->first();
            if ($user) {
                if (password_verify($pass, $user->pass)) {
                    $this->updateSessionData($user, 2);
                }
            } else {
                $user = UsersAdmin::where('email', $email)->first();
                if ($user) {
                    if (password_verify($pass, $user->password)) {
                        $this->updateSessionData($user, 1);
                    }
                } 
            }
        }
        
        if(Session::has('role')) {
            return redirect()->route('index');
        } else {
            return view("index", ["errorLogin" => "Usuario o contraseña incorrectos"]);
        }
    }

    public function logout() {
        Session::flush();
        return redirect()->route('index');
    }

    public function signup(Request $request) {
        //recuperar las variables
        $username=$request->username;
        $name=$request->name;
        $surname=$request->surname;
        $nif=$request->nif;
        $email=$request->email;
        $telephone=$request->telephone;
        $pass=$request->pass;

        $validationErrors = 0;

        //cifrado de password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        //validación de email
        $user = Student::where('email', $email)->first();
        if ($user) {
            $errorEmail = "Ya existe un usuario registrado con ese email";
            $validationErrors++;
        }

        //validación de username
        $user = Student::where('username', $username)->first();
        if ($user) {
            $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
            $validationErrors++;
        }

        //validación de nif
        $user = Student::where('nif', $nif)->first();
        if ($user) {
            $errorNIF = "Ya existe un usuario registrado con ese NIF";
            $validationErrors++;
        }

        $result = new SignUpResultDTO;
        $result->username = $username;
        $result->name =  $name;
        $result->surname =  $surname;
        $result->nif =  $nif;
        $result->email =  $email;
        $result->telephone =  $telephone;
        $result->pass =  $pass;

        if($validationErrors == 0) {
            $student = new Student;
            $student->date_registered = date("Y-m-d H:i:s");;
            $student->email = $email;
            $student->name = $name;
            $student->nif = $nif;
            $student->pass = $pass;
            $student->surname = $surname;
            $student->telephone = $telephone;
            $student->username = $username;

            try {
                $student->save();
                $result->success = true;
                $user = Student::where('email', $email)->first();
                $this->updateSessionData($user, 3);
            } catch (\Exception $ex) {
                $result->serverError = $ex->getMessage();
                $result->success = false;
            }
        } else {
            $result->success = false;
            $result->validationErrors = $validationErrors ?? 0;
            $result->errorEmail = $errorEmail ?? '';
            $result->errorUsername = $errorUsername ?? '';
            $result->errorNIF = $errorNIF ?? '';
        }

        return view("signup", ["result" => $result]);
    }
    
    protected function updateSessionData($user, $role) {
        //Roles:
        // 1: admin
        // 2: teacher
        // 3: student
        session(["user" => $user]);
        session(["role" => $role]);
    }
} 