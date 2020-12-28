<?php

namespace App\Http\DTOs;

class ListResultDTO {
    public $itemType = '';
    public $listName ='';
    public $editItemUrl = '';
    public $editItemName = '';
    public $newItemText = '';
    public $items = array();
}