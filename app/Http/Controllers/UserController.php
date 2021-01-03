<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\DTOs\SignUpResultDTO;
use App\Http\DTOs\EditUserResultDTO;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UsersAdmin;

class UserController extends Controller
{
    public function login(Request $request) {
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

    public function loadUser() {
        $user = Session::get('user');
        $role = Session::get('role');

        $result = new EditUserResultDTO;
        $result->username = $user->username;
        $result->name = $user->name;
        $result->email = $user->email;

        if($role > 1){            
            $result->surname = $user->surname;
            $result->nif = $user->nif;
            $result->telephone = $user->telephone;
        }

        return view("editUser", ["result" => $result]);
    }

    public function updateUser(Request $request) {
        $user = Session::get('user');
        $role = Session::get('role');

        $username=$request->username;
        $name=$request->name;
        $email=$request->email;
        $pass=$request->pass;

        if ($role > 1) {
            $surname=$request->surname;
            $nif=$request->nif;
            $telephone=$request->telephone;
        }

        $validationErrors = 0;

        if ($pass != "") {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $pass = $user->pass;
        }

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

        if ($role > 1 && $nif != $user->nif) {
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

        $result = new EditUserResultDTO;
        $result->username = $username;
        $result->name = $name;
        $result->email = $email;
        if ($role > 1) {
            $result->nif = $nif;
            $result->surname = $surname;
            $result->telephone = $telephone;
        }

        if ($validationErrors == 0) {
            $user->username = $username;
            $user->name = $name;
            $user->email = $email;
            $user->pass = $pass;

            if ($role > 1) {
                $user->nif = $nif;
                $user->surname = $surname;
                $user->telephone = $telephone;
            }

            try {
                //guardamos el modelo
                $user->save();
                //si strudent.save no falla, marcamos el success de nuestro DTO a true
                $result->success = true;
                //cargamos el usuario en sesión para que se loguee automáticamente
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

        return view("editUser", ["result" => $result]);
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

        $user = Teacher::where('email', $email) ->first();
        if ($user) {
            $errorEmail = "Ya existe un usuario registrado con ese email";
            $validationErrors++;
        }

        $user = UsersAdmin::where('email', $email) ->first();
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

        $user = Teacher::where('username', $username)->first();
        if ($user) {
            $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
            $validationErrors++;
        }

        $user = UsersAdmin::where('username', $username)->first();
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

        $user = Teacher::where('nif', $nif)->first();
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
            $student->date_registered = date("Y-m-d H:i:s");
            $student->email = $email;
            $student->name = $name;
            $student->nif = $nif;
            $student->pass = $pass;
            $student->surname = $surname;
            $student->telephone = $telephone;
            $student->username = $username;

            try {
                //guardamos el modelo
                $student->save();
                //si strudent.save no falla, marcamos el success de nuestro DTO a true
                $result->success = true;
                //cargamos el usuario en sesión para que se loguee automáticamente
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