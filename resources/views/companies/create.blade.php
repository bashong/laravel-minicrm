@extends('master')

@section('content-header', trans('company.create'))
@section('breadcrumb-active', trans('company.create'))

@section('content')
<div class="card card-info">
    <div class="card-body">
        <div class="panel panel-default">
            <div class="card card-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default ">
            {!! Form::open(['route' => 'companies.store']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('company.name')]) !!}
                {!! FormField::email('email', ['required' => true, 'label' => trans('company.email')]) !!}
                {!! FormField::text('website', ['label' => trans('company.website')]) !!}
                {!! FormField::textarea('address', ['label' => trans('company.address')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('company.create'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('companies.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
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