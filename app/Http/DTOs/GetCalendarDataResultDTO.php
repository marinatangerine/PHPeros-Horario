<?php

namespace App\Http\DTOs;

class GetCalendarDataResultDTO {
    public $month = '';
    public $year = '';

    public $next_month = '';
    public $next_year = '';
    public $previous_month = '';
    public $previous_year = '';

    public $last_month_day = '';
    public $month_start_week_day = '';

    public $items = array();
    public $exams = array();
    public $works = array();
    public $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
}