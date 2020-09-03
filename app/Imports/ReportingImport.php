<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithProgressBar;

use App\Company;
use App\Employee;

class ReportingImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
//class ReportingImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    
    private  $modelClasses = [
        "employee"=> 'App\Employee',
        "company"=> 'App\Company'
    ];

    public function __construct($params){
       
        $this->params = $params;
        $this->model = $params['model'];
    }

    public function model(array $row)
    {
        if(!isset($this->modelClasses[$this->model])) throw new Exception('Invalid 
        Model!');

        $myModel = new $this->modelClasses[$this->model];   
        
        $fillable = array_flip($myModel->getFillable());

        
        $row['created_by'] = $this->params['created_by'];
        $row['updated_by'] = $this->params['updated_by'];
        
        if(isset($this->params['company_id'])) $row['company_id'] = $this->params['company_id'];
        
        $insertValues = array_intersect_key($row,$fillable);
        // dd($insertValues,$row);

        return $myModel->fill($insertValues);

    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

}
