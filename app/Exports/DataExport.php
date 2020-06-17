<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class DataExport implements FromArray
{   
    protected $location_id;

    public function __construct(array $location_id)
    {
        $this->location_id = $location_id;
    }

    public function array():array
    {
        return $this->location_id;
    }
}

// Source: https://laravel-excel.com/