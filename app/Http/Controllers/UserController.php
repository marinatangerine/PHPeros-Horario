<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UsersAdmin;

class UserController extends Controller
{
    public function login(Request $request)
    {
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

    public function logout(){
        Session::flush();
        return redirect()->route('index');
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