<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="http://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div id="app">
        @include('layouts.partials.top-nav')

        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
   
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    

    <script src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
    $('.dateRange').daterangepicker({
        "timePicker": true,
        "timePickerIncrement": 1,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "locale": {
            "format": 'YYYY-MM-DD H:mm:ss'
        },
        "setStartDate" : "03-01-2014",
    });

    var myDataTable='';
    function searchCompany(){

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
                { "title": "Action","data": "action" }
            ]
        });
    }

    function searchEmployee(){

var data = serializeArrayCustom($('.form_search').serializeArray());

if(myDataTable) 
    myDataTable.destroy(); 
myDataTable = $("#employeeDataTable").DataTable({
    responsive: true,
    pageLength: 10,
    processing: true,
    serverSide: false,
    searching: true,
    ordering: true,
    info: true,
    ajax: {
        "url": "{{ route('employee.search') }}",
        "headers" : {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        "method": "POST",
        "data": data,
    },
    columns: [
        { "title": "Name","data": "name" },
        { "title": "Company","data": "company" },
        { "title": "Email","data": "email" },
        { "title": "Phone","data": "phone" },
        { "title": "Action","data": "action" }
    ]
});
}


    function serializeArrayCustom(arr){
        var data = [];
        for(var i=0; i<arr.length; i++){
            data[arr[i]['name']] = arr[i]['value'];
        }
        return data;
    }

    </script>
    
     


</body>
</html>
