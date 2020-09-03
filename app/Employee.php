<?php

namespace App;

use App\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['first_name', 'last_name', 'company_id', 'email', 'phone','password', 'created_by','updated_by'];

    protected $perPage = 10;


    // public function nameLink()
    // {
    //     return link_to_route('employees.show', $this->name, [$this], [
    //         'title' => trans(
    //             'app.show_detail_title',
    //             ['name' => $this->name, 'type' => trans('company.company')]
    //         ),
    //     ]);
    // }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
