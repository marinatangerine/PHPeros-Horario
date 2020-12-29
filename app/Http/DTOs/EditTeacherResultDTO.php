<?php

namespace App\Http\DTOs;

class EditTeacherResultDTO {
    public $name = '';
    public $surname = '';
    public $nif = '';
    public $email = '';
    public $telephone = '';
    public $id_teacher = '';

    public $validationErrors = 0;
    public $errorEmail = '';
    public $errorNIF = '';
    public $serverError = '';

    public $success = false;
}