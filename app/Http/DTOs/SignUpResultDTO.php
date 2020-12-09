<?php

namespace App\Http\DTOs;

class SignUpResultDTO {
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

    public $success = false;
}
