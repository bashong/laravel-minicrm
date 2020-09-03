@extends('layouts.app')

@section('title', trans('company.list'))

@section('content')
<div class="page-header">
    <div class="pull-right">
    @can('create', new App\Company)
        {{ link_to_route('companies.create', trans('company.create'), [], ['class' => 'btn btn-primary']) }}
        {{ link_to_route('excelFile', trans('app.export'), ["which" => "export","name" => "company"], ['class' => 'btn btn-primary']) }}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importForm">
            Import
        </button>
    @endcan
    </div>
    <span class="h2">{{ trans('company.list') }}</span>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => trans('company.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit('search', ['class' => 'btn btn-sm']) }}
                {{ link_to_route('companies.index', trans('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('company.name') }}</th>
                        <th>{{ trans('company.email') }}</th>
                        <th>{{ trans('company.website') }}</th>
                        <th>{{ trans('company.address') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $key => $company)
                    <tr>
                        <td class="text-center">{{ $companies->firstItem() + $key }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->website }}</td>
                        <td>{{ $company->address }}</td>
                        <td class="text-center">
                        @can('view', $company)
                            {!! link_to_route(
                                'companies.show',
                                trans('app.show'),
                                [$company],
                                ['class' => 'btn btn-default btn-xs', 'id' => 'show-company-' . $company->id]
                            ) !!}
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12">{{ $companies->links() }}
                </div>
                <i class='pull-right'>{{ $companies->total() }}  total records.</i>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="importForm" tabindex="-1" role="dialog" aria-labelledby="importForm" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Excel Importer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::open(array('url' => 'import/company', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
            <div class="modal-body">
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