<?php

namespace App\Http\Controllers;


use App\Company;
use App\Employee;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyLogoUploadRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\Request;
use Storage;

use Carbon\Carbon;

Use App\Mail\UserNotify;
use Illuminate\Support\Facades\Mail;

class CompaniesController extends Controller
{

    public function index()
    {   

        
        $companyList = Company::pluck('name', 'id'); 
        return view('companies.index', compact('companyList','timezonelist'));

    }


    public function create()
    {
        $this->authorize('create', new Company);

        return view('companies.create');
    }


    public function store(CompanyCreateRequest $request)
    {
        $newCompany = $request->validated();
        $newCompany['created_by'] = auth()->id();
        $newCompany['updated_by'] = auth()->id();

        $company = Company::create($newCompany);

        Mail::to($request->user())->queue(new UserNotify($company));

        return redirect()->route('companies.show', $company);
    }


    public function show(Company $company)
    {
        $employees = $company->employees()->where(function ($query) {
            $searchQuery = request('q');
            $query->where('first_name', 'like', '%'.$searchQuery.'%');
            $query->orWhere('last_name', 'like', '%'.$searchQuery.'%');
        })->paginate();

        return view('companies.show', compact('company', 'employees'));
    }


    public function edit(Company $company)
    {
        $this->authorize('update', $company);

        return view('companies.edit', compact('company'));
    }


    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $companyData = $request->validated();
        $companyData['updated_by'] = auth()->id();
        $company->update($companyData);
        // dd($company);

        return redirect()->route('companies.show', $company);
    }


    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $this->validate(request(), [
            'company_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');
        if (request('company_id') == $company->id && $company->delete()) {
            return redirect()->route('companies.index', $routeParam);
        }

        return back();
    }


    public function logoUpload(CompanyLogoUploadRequest $request, Company $company)
    {
        $disk = env('APP_ENV') == 'testing' ? 'avatars' : 'public';

        if (Storage::disk($disk)->exists($company->logo)) {
            Storage::disk($disk)->delete($company->logo);
        }

        $company->logo = $request->logo->store('', $disk);
        $company->save();

        return back();
    }

    public function search(Request $request){


        $timezone = $request->session()->get('newTimeZone') ?? null;

        if($request->datetime){
            $dates = explode(' - ', $request->datetime);
            $start_date = trim($dates[0]);
            $end_date = trim($dates[1]);

            if($timezone){
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', trim($dates[0]),$timezone)->setTimezone(config('app.timezone'));
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', trim($dates[1]),$timezone)->setTimezone(config('app.timezone'));
            }

            $search[] = ['created_at' , '>=' , $start_date];
            $search[] = ['created_at' , '<=' , $end_date];
           
        }
        if($request->company){
            $company=$request->company;
            $search[] = ['id', $company];            
        }
        if($request->website){
            $website=$request->website;
            $search[] = ['website', 'like', "%$website%"];            
        }

        $companies = Company::where($search);

        $company = $companies->get()->map(function($item, $key) use($timezone) {

            // created_at
            // updated_at

            extract($item->toArray());
            if($timezone){
                $dateCreated = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
                $dateCreated->setTimezone($timezone);
                
                $dateUpdated = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at);
                $dateUpdated->setTimezone($timezone);
                
                $item->created_at = $dateCreated;
                $item->updated_at = $dateUpdated;
            }


            $item->action = '<a target="_blank" href="companies/'.$id.'">View Details</a>';
            return $item;

        });


        // dd($companies);

        return response()->json(["data" => $company]);
    }
}
