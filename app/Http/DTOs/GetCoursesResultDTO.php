<?php

namespace App\Http\DTOs;

class GetCoursesResultDTO {
    public $id_course ='';
    public $name = '';
    public $description = '';
    public $date_start = '';
    public $date_end = '';
    public $active = '';
    public $status = '';

    public $hasChildren = false;
}