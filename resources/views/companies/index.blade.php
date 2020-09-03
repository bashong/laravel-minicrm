@extends('master')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content-header', trans('company.company'))
@section('breadcrumb-active', trans('company.company'))

@section('content')

<div class="card card-default">
    <div class="card-header">
      <h4 class="card-title">{{trans('app.search_filter')}}</h4>

      <div class="card-tools">
        @can('create', new App\Company)
        {{ link_to_route('companies.create', trans('company.create'), [], ['class' => 'btn btn-sm btn-primary']) }}
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#importForm">
            {{trans('app.import')}}
        </button>
        @endcan 
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form class="form_search">
        <div class="row d-flex justify-content-center">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input class="form-control float-right dateRange" name="datetime">
                        </div>
                        <!-- /.input group -->
                    </div>
                <!-- /.form-group -->
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="far fa-building"></i>
                            </span>
                        </div>
                        <select class="form-control float-right" name="company">
                            <option value="">Choose All</option>
                            @foreach($companyList as $key => $comp)
                            <option value="{{ $key }}">{{ $comp }}</option>
                            @endforeach
                        </select>
                        </div>
                        <!-- /.input group -->
                    </div>
                <!-- /.form-group -->
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {{-- <label>{{ trans('employee.name') }}:</label> --}}
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-link"></i>
                            </span>
                        </div>
                        <input value="" class="form-control" type="text" name="website" placeholder="http://">
                        </div>
                        <!-- /.input group -->
                    </div>
                <!-- /.form-group -->
                </div>

                <div class="col-sm-1">
                    <button type="button" onclick="searchCompany()" class="btnSubmit btn btn-default"> <i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-default cardTable" style="display: none;">
    <div class="card-body">
        <table id="companyDataTable" class="table table-bordered table-striped">
        </table>
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
        {{ Form::open(array('url' => 'import/company', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
            <div class="modal-body">
                <div class="custom-file">
                    <input type="file" name="excelFile" class="custom-file-input" accept=".xlsx" id="inputFile" required>
                    <label class="custom-file-label" for="inputFile">Choose file</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('app.cancel')}}</button>
                {{ Form::submit(trans('app.upload'), ['class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>

@endsection


@section('script')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script>
     
    var myDataTable='';
    function searchCompany(){

        $('.cardTable').show();

        var data = serializeArrayCustom($('.form_search').serializeArray());
        

        if(myDataTable) 
            myDataTable.destroy(); 
        myDataTable = $("#companyDataTable").DataTable({
            responsive: true,
            pageLength: 10,
            processing: true,
            serverSide: false,
            searching: true,
            ordering: true,
            info: true,
            ajax: {
                "url": "{{ route('company.search') }}",
                "headers" : {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                "method": "POST",
                "data": data,
            },
            columns: [
                { "title": "ID","data": "id" },
                { "title": "Name","data": "name" },
                { "title": "Email","data": "email" },
                { "title": "Website","data": "website" },
                { "title": "Address","data": "address" },
                { "title": "Date Created","data": "created_at" },
                { "title": "Date Updated","data": "updated_at" },
                { "title": "Action","data": "action" }
            ]
        });
    }
</script>  
@endsection
