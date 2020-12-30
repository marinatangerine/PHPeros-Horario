<?php

namespace App\Http\DTOs;

class EditCourseResultDTO {
    public $id_course ='';
    public $name = '';
    public $description = '';
    public $date_start = '';
    public $date_end = '';
    public $active = '';

    public $formTitle = '';

    public $validationErrors = 0;
    public $datesError = '';
    public $serverError = '';

    public $success = false;
}