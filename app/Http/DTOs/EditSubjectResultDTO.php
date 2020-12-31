<?php

namespace App\Http\DTOs;

class EditSubjectResultDTO {
    public $id_class ='';
    public $name = '';
    public $color = '';
    public $id_teacher = '';
    public $id_course = '';
    
    public $teachers = array();
    public $courses = array();
    public $colors = array();

    public $formTitle = '';

    public $validationErrors = 0;
    public $serverError = '';
    public $success = false;
}