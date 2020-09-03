<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Company;
use App\Employee;

class ReportingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    private  $modelClasses = [
        "employees"=> 'App\Employee',
        "company"=> 'App\Company'
    ];
    
    public function __construct($model){
        $this->model = $model;
    }

    public function collection()
    {
        try {
            if(!isset($this->modelClasses[$this->model])) throw new Exception('Invalid Model!');

            $collection = $this->modelClasses[$this->model]::all();
            
            return $collection;
            // return Employee::all();
            //code...
        } catch (\Throwable $th) {
            return abort(404);
        }   
    }
}
