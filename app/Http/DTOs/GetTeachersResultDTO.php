<?php

namespace App\Http\DTOs;

class GetTeachersResultDTO {
    public $id_teacher ='';
    public $username = '';
    public $name = '';
    public $surname = '';
    public $nif = '';
    public $email = '';
    public $telephone = '';

    public $hasChildren = false;
}