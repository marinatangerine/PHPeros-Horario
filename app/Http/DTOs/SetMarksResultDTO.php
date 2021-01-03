<?php

namespace App\Http\DTOs;

class SetMarksResultDTO {
    public $id = '';
    public $type = '';
    public $name = '';
    public $date = '';

    public $id_class = '';
    public $back = '';
    
    public $items = array();

    public $action = '';
    public $success = '';
}