<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelLocalization;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function changeTimezone(Request $request)
    {
        // print_r($request->session()->all());
        // echo "<br /><br />";

        // dd($request);
        
        // $timezonelist = new \DateTimeZone($request->timezone);
        // $new_locale = strtolower(trim($timezonelist->getLocation()['country_code']));

        // if(strpos($request->timezone,"America") !== FALSE){
        //     $new_locale = "en";
        // }

        // $redirectURL=$request->server()['HTTP_REFERER'];

        // if(isset(LaravelLocalization::getLocalesOrder()[$new_locale])){
        //     $currentLocal = LaravelLocalization::getCurrentLocale();            
        //     LaravelLocalization::setLocale($new_locale);       

        //     $redirectURL = str_replace("/{$currentLocal}/","/{$new_locale}/",$request->server()['HTTP_REFERER']);
        // }

        $request->session()->put('newTimeZone', $request->timezone);
        
        // return response()->json(["url" => $redirectURL]);
        return response()->json(["msg" => "Timezone has been set to " . $request->timezone]);
    }
}
