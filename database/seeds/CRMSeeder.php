<?php

use Illuminate\Database\Seeder;

use App\Imports\ReportingImport;
use Maatwebsite\Excel\Facades\Excel;

class CRMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $models = [
            "company",
            "employee"
        ];


        foreach ($models as $model) {
            # code...

            $params = [
                "model" => "$model",
                "creator_id" => "1"
            ];
        
            if($model == "employee") $params['company_id'] = 1;

             Excel::import(new ReportingImport($params), "database/seeds/".$model.".xlsx");

             sleep(1.5);

        }
    }
}
