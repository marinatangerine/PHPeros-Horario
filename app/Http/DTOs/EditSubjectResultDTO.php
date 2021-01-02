<?php

namespace App\Http\DTOs;

class EditSubjectResultDTO {
    public $id_class ='';
    public $name = '';
    public $color = '';
    public $id_teacher = '';
    public $id_course = '';
    public $name_teacher = '';
    
    public $teachers = array();
    public $courses = array();
    public $colors = array();

    public $formTitle = '';

    public $emptyDropDowns = 0;
}