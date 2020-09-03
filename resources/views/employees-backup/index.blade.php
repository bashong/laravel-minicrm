@extends('layouts.app')

@section('title', trans('employee.list'))

@section('content')
<div class="page-header">
    <div class="pull-right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importForm">
            Import
        </button>
    </div>
    <span class="h2">{{ trans('employee.list') }}</span>
</div>

{{-- <span class="h2">{{ trans('employee.list') }}</span>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importForm">
    Import
</button> --}}
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
                    @if(count($employees) > 0)
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
                    @else
                    <tr>
                        <td class="text-center">No Data</td>
                    @endif

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

    <div class="modal fade" id="importForm" tabindex="-1" role="dialog" aria-labelledby="importForm" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Excel Importer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(array('url' => 'import/employee', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
                <div class="modal-body">
                    {!! FormField::select('company_id', $companyList, ['label' => trans('employee.search'), 'placeholder' => trans('company.select'), 'required' => true]) !!}
                    {!! FormField::file('excelFile', ['label' => false, 'required' => true]) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    {{ Form::submit(trans('app.save'), ['class' => 'btn btn-primary']) }}
                </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
