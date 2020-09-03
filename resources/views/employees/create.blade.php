@extends('master')

@section('content-header', trans('employee.create'))
@section('breadcrumb-active', trans('employee.create'))

@section('content')
<div class="card card-info">
    <div class="card-body">
        <div class="panel panel-default">
            <div class="card card-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default ">
                        {!! Form::open(['route' => 'employees.store']) !!}
                        <div class="panel-body">
                            {!! FormField::text('first_name', ['required' => true, 'label' => trans('employee.first_name')]) !!}
                            {!! FormField::text('last_name', ['required' => true, 'label' => trans('employee.last_name')]) !!}
                            {!! FormField::text('password', ['type' => 'password', 'required' => true, 'label' => trans('app.password')]) !!}
                            {!! FormField::select('company_id', $companyList, ['required' => true, 'label' => trans('employee.company'), 'placeholder' => trans('company.select')]) !!}
                            {!! FormField::email('email', ['label' => trans('employee.email')]) !!}
                            {!! FormField::text('phone', ['label' => trans('employee.phone')]) !!}
                        </div>
                        <div class="panel-footer">
                            {!! Form::submit(trans('employee.create'), ['class' => 'btn btn-primary']) !!}
                            {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
