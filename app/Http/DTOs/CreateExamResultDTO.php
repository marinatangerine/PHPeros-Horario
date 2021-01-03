<?php

namespace App\Http\DTOs;

class CreateExamResultDTO {
    public $id_class = '';
    public $name_class = '';
    public $course_start = '';
    public $course_end = '';
    public $date = '';
    public $name = '';

    public $items = array();

    public $dateError = '';

    public $success = false;
}