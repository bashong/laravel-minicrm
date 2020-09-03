<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;

use App\Company;
use App\Employee;
use App\Exports\ReportingExport;

use Carbon\Carbon;

class EmployeesController extends Controller
{

    public function index()
    {
        $companyList = Company::pluck('name', 'id'); 
        
        return view('employees.index', compact('companyList'));
        
    }

    public function create()
    {

        $this->authorize('create', new Employee);
        $companyList = Company::pluck('name', 'id');
        return view('employees.create',compact('companyList'));
    }

    public function store(EmployeeCreateRequest $request)
    {
        $newEmployee = $request->validated();
        $newEmployee['created_by'] = auth()->id();
        $newEmployee['updated_by'] = auth()->id();

        Employee::create($newEmployee);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);

        $companyList = Company::pluck('name', 'id');

        return view('employees.edit', compact('employee','companyList'));
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employeeData = $request->validated();
        $employeeData['updated_by'] = auth()->id();
        $employee->update($employeeData);

        $routeParam = request()->only('page', 'q');

        return redirect()->route('employees.index', $routeParam);
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $this->validate(request(), [
            'employee_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('employee_id') == $employee->id && $employee->delete()) {
            return redirect()->route('employees.index', $routeParam);
        }

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

            $search[] = ['employees.created_at' , '>=' , $start_date];
            $search[] = ['employees.created_at' , '<=' , $end_date];

        }
        if($request->company){
            $company=$request->company;
            $search[] = ['company_id', $company];            
        }


        $employees = Employee::join('companies as c',function($join){
            $join->on('c.id', '=', 'employees.company_id');
        })->where($search);

        if($request->name){
            $name=$request->name;
            $employees->whereRaw("(first_name like '%$name%' OR last_name like '%$name%')");
        }

        


        $employee = $employees->get(["employees.id","c.name as company","first_name","last_name","phone","employees.created_at","employees.updated_at","employees.email"])->map(function($item, $key) use($timezone) {

            // dd($item,$item->toArray()[0]->relations);

            extract($item->toArray());

            if($timezone){
                $dateCreated = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
                $dateCreated->setTimezone($timezone);
                
                $dateUpdated = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at);
                $dateUpdated->setTimezone($timezone);
                
                $item->created_at = $dateCreated;
                $item->updated_at = $dateUpdated;
            }

            $item->name = "$first_name $last_name";

            $item->action = '<a target="_blank" href="employees/'.$id.'/edit">Edit</a> | ';
            $item->action .= '<a target="_blank" href="employees/'.$id.'/edit?action=delete">Delete</a>';
            return $item;

        });
        // dd($employee);

        return response()->json(["data" => $employee]);
    }
}
