<?php

namespace App\Http\DTOs;

class EditTeacherResultDTO {
    public $username = '';
    public $name = '';
    public $surname = '';
    public $nif = '';
    public $email = '';
    public $telephone = '';
    public $id_teacher = '';

    public $formTitle = '';

    public $validationErrors = 0;
    public $errorUserName = '';
    public $errorEmail = '';
    public $errorNIF = '';
    public $serverError = '';

    public $success = false;
}