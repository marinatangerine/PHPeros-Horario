<?php

namespace App\Http\DTOs;

class TranscriptSubjectResultDTO {
    public $id_class = '';
    public $name = '';
    public $courseName = '';
    public $exams_avg_mark = '';
    public $works_avg_mark = '';
    public $avg_mark = '';

    public $exams = array();
    public $works = array();
}