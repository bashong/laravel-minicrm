function serializeArrayCustom(arr){
    var data = [];
    for(var i=0; i<arr.length; i++){
        data[arr[i]['name']] = arr[i]['value'];
    }
    return data;
}

$(document).ready(function () {
    bsCustomFileInput.init();
});

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

var defaultTimezone = "";
var locale = "";
function changeTimeZone(defaultTimezone, locale) {
    var newTimezone = $('#header_timezone').val();
    // $('this').val();
    // if(defaultTimezone != newTimezone){
        console.log("changing timezones");
        console.log(locale);
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
        $.ajax({
            type: "POST",
            url: '/'+locale+'/changeTimezone',
            data: {
                "timezone": newTimezone,
                "local": locale
            },success: function(data){
               console.log(data['msg']); 
               if(myDataTable) myDataTable.ajax.reload();
            //    window.location.href = data['url'];
            }
          });
    // } 
    
}