@extends('master')

@if (request('action') == 'delete')
    @section('content-header', trans('employee.delete'))
    @section('breadcrumb-active', trans('employee.delete'))
@else
    @section('content-header', trans('employee.edit'))
    @section('breadcrumb-active', trans('employee.edit'))
@endif

@section('content')
<div class="card card-info">
    <div class="card-body">
        @if (request('action') == 'delete' && $employee)
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                @can('delete', $employee)
                <div class="card card-info">
                    <div class="card-body">
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading text-center h3">{{ trans('employee.delete') }}</div> --}}
                            <div class="panel-body">
                                <label class="control-label">{{ trans('app.name') }}</label>
                                <p>{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                <label class="control-label">{{ trans('employee.company') }}</label>
                                <p>{{ $employee->company->name }}</p>
                                <label class="control-label">{{ trans('employee.email') }}</label>
                                <p>{{ $employee->email }}</p>
                                <label class="control-label">{{ trans('employee.phone') }}</label>
                                <p>{{ $employee->phone }}</p>
                                {!! $errors->first('employee_id', '<span class="form-error small">:message</span>') !!}
                            </div>
                            <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
                            <div class="panel-footer">
                                {!! FormField::delete(
                                    ['route' => ['employees.destroy', $employee]],
                                    trans('app.delete_confirm_button'),
                                    ['class'=>'btn btn-danger'],
                                    [
                                        'employee_id' => $employee->id,
                                        'page' => request('page'),
                                        'q' => request('q'),
                                    ]
                                ) !!}
                                {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        @else
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="panel panel-default">
                            {!! Form::model($employee, ['route' => ['employees.update', $employee],'method' => 'patch']) !!}
                            <div class="panel-body">
                                {!! FormField::text('first_name', ['required' => true, 'label' => trans('employee.first_name')]) !!}
                                {!! FormField::text('last_name', ['required' => true, 'label' => trans('employee.last_name')]) !!}
                                {!! FormField::text('password', ['required' => true, 'label' => trans('app.password')]) !!}
                                {!! FormField::select('company_id', $companyList, ['required' => true, 'label' => trans('employee.company'), 'placeholder' => trans('company.select')]) !!}
                                {!! FormField::email('email', ['label' => trans('employee.email')]) !!}
                                {!! FormField::text('phone', ['label' => trans('employee.phone')]) !!}
                                @if (request('q'))
                                    {{ Form::hidden('q', request('q')) }}
                                @endif
                                @if (request('page'))
                                    {{ Form::hidden('page', request('page')) }}
                                @endif
                            </div>
                            <div class="panel-footer">
                                {!! Form::submit(trans('employee.update'), ['class' => 'btn btn-success']) !!}
                                {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
