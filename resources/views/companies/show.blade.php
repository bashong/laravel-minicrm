@extends('layouts.app')

@section('title', trans('company.detail'))

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading text-center h3">{{ trans('company.detail') }}</div>
            @if ($company->logo && is_file(public_path('storage/'.$company->logo)))
                <div class="panel-body">
                    {{ Html::image('storage/'.$company->logo, $company->name, ['style' => 'width:100%']) }}
                </div>
            @endif
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <td class="col-xs-4">{{ trans('company.name') }}</td>
                        <td>{{ $company->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('company.email') }}</td>
                        <td>{{ $company->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('company.website') }}</td>
                        <td>{{ $company->website }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('company.address') }}</td>
                        <td>{{ $company->address }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                @can('update', $company)
                    {{ link_to_route('companies.edit', trans('company.edit'), [$company], ['class' => 'btn btn-primary', 'id' => 'edit-company-'.$company->id]) }}
                @endcan
                {{ link_to_route('companies.index', trans('company.back_to_index'), [], ['class' => 'btn btn-default pull-right']) }}
            </div>
        </div>
    </div>
    
</div>
@endsection
