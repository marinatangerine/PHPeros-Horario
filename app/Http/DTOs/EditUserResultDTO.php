<?php

namespace App\Http\DTOs;

class EditUserResultDTO {
    public $username ='';
    public $name = '';
    public $surname = '';
    public $nif = '';
    public $email = '';
    public $telephone = '';
    public $pass = '';

    public $validationErrors = 0;
    public $errorEmail = '';
    public $errorUsername = '';
    public $errorNIF = '';
    public $serverError = '';

    public $notif_exam;
    public $notif_work;

    public $success = false;
}
