<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
    // return view('welcome');
});
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{


Route::get('/ping',function(){
    return response()->json(["message","PONG"]);
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

// Route::post('login', 'AuthController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::patch('companies/{company}/logo-upload', [
        'as'   => 'companies.logo-upload',
        'uses' => 'CompaniesController@logoUpload',
    ]);

    Route::resource('companies', 'CompaniesController');
    Route::resource('employees', 'EmployeesController');

    Route::post('searchCompany', 'CompaniesController@search')->name('company.search');
    Route::post('searchEmployee', 'EmployeesController@search')->name('employee.search');

    Route::post('/changeTimezone','HomeController@changeTimezone');


    //reporting import/export
    Route::match(['get', 'post'],'{which}/{name}','Excel\ExcelController@index',function($which){
        // return $which;
    })->where("which","import|export")->name("excelFile");

    //tester
    Route::get('sendmail', 'Excel\ExcelController@test_mailer');
});
});
