<?php

namespace App\Http\Controllers\Excel;
// use App\Jobs\NotifyUserOfCompletedImport;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Exports\ReportingExport;
use App\Imports\ReportingImport;
use Maatwebsite\Excel\Facades\Excel;

Use App\Mail\UserNotify;
use Illuminate\Support\Facades\Mail;
use Auth, Log;

class ExcelController extends Controller
{
    //xlsx,csv
    private $fileType = ".csv";
    private $model = null;
    private $user = null;
    private $shouldEmail = TRUE;
    private $models = ["employee","company"];

    public function index($which,$model, Request $request){

        if(!in_array($model,$this->models)) throw new Exception("Model $model is not Available");

        $this->model = $model;
        $this->params = [
            'model' => $model,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ];

        $this->user = $request->user();
        

        if(isset($request->company_id)){
            $this->params['company_id'] = $request->company_id;
            $this->shouldEmail = FALSE;
        }

        if($which == "export"){
            return self::exportFile();
        }else{
            return self::importFile($request->excelFile);
        }
    }

    private function importFile($file){

        try {
            Excel::import(new ReportingImport($this->params), $file);
            if($this->shouldEmail !== FALSE){
                self::UserSendEmail();
            }
        } catch (\Throwable $th) {
        }
        
        return back();
    }

    private function exportFile(){
        return Excel::download(new ReportingExport($this->model), $this->model.$this->fileType);
    }


    private function UserSendEmail(){
        Mail::to(auth()->user())
        ->queue(new UserNotify());
    }
    public function test_mailer(Request $request){

        // Log::debug('XXXX');

        // echo "PONG";
        Mail::to($request->user())->send(new UserNotify([]));

        echo json_encode(["msg" => "done"]);
        // print_r($request->user());
        
    }
}
