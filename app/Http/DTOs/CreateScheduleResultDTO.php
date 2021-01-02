<?php

namespace App\Http\DTOs;

class CreateScheduleResultDTO {
    public $id_class = '';
    public $name_class = '';
    public $course_start = '';
    public $course_end = '';
    public $day = '';
    public $time_start = '';
    public $time_end = '';
    public $items = array();

    public $dateError = '';
    public $timeError = '';

    public $success = false;
    
}