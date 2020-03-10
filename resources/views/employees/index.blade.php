@extends('layouts.app')

@section('title', trans('employee.list'))

@section('content')
<span class="h2">{{ trans('employee.list') }}</span>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::select('company_id', $companyList, ['label' => trans('employee.search'), 'placeholder' => trans('company.select'), 'class' => 'input-sm']) !!}
                {!! FormField::text('q', ['value' => request('q'), 'label' => false, 'class' => 'input-sm']) !!}
                {{ Form::submit(trans('employee.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('employees.index', trans('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('app.name') }}</th>
                        <th>{{ trans('employee.company') }}</th>
                        <th>{{ trans('employee.email') }}</th>
                        <th>{{ trans('employee.phone') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $key => $employee)
                    <tr>
                        <td class="text-center">{{ $employees->firstItem() + $key }}</td>
                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td>{{ $employee->company->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td class="text-center">
                        @can('update', $employee)
                            {!! link_to_route(
                                'employees.index',
                                trans('app.edit'),
                                ['action' => 'edit', 'id' => $employee->id] + Request::only('page', 'q'),
                                ['id' => 'edit-employee-'.$employee->id]
                            ) !!} |
                        @endcan
                        @can('delete', $employee)
                            {!! link_to_route(
                                'employees.index',
                                trans('app.delete'),
                                ['action' => 'delete', 'id' => $employee->id] + Request::only('page', 'q'),
                                ['id' => 'del-employee-'.$employee->id]
                            ) !!}
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12">{{ $employees->links() }}
                </div>
                <i class='pull-right'>{{ $employees->total() }}  total records.</i>
        </div>
    </div>
    <div class="col-md-4">
            <div class="panel panel-default">
            <div class="panel-body">
                @include('employees.forms')
                </div>
                </div>
    </div>
</div>
@endsection
