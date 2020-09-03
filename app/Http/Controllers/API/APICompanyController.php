<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AuthController;

use Validator;
use App\Company;
use App\Employee;
use JWTAuth, Exception;
class APICompanyController extends AuthController
{
    //
    function __construct() {
        try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    $err = ['status' => 'Token is Invalid'];
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    $err = ['status' => 'Token is Expired'];
                }else{
                    $err = ['status' => 'Authorization Token not found'];
                }
                
                header("HTTP/1.1 401 Unauthorized");
                header("application/json ");
                echo json_encode($err);
                exit();
            }

    }

    public function listEmployees(Request $request){

        $validator = Validator::make($request->all(), [
            'company_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $list = Company::with(['employees'])->where(["id" => $request->company_id])->get();

        return response()->json($list);
    }
    
}
