const { result } = require('lodash');

require('./bootstrap');

$(document).ready(function() {
    _token="{{csrf_token()}}";
    $('#inputZip').empty();
    $("#success-alert").hide();


    function getstates(regionID, token, selectedState){
        var select = '';
        $.ajax({
            url: '/findStateWithRegionID/'+regionID,
            type: "GET",
            data : {"_token":token},
            dataType: "json",
            success:function(data) {
                if(data){
                    $('#inputState').empty();
                    $('#inputState').focus;
                    $('#inputState').append('<option value="">-- Select State --</option>'); 
                    $.each(data, function(key, value){
                        if(value.id == selectedState){
                            $('select[id="inputState"]').append('<option value="'+ value.id +'" selected>' + value.name+ '</option>');
                        }else{
                            $('select[id="inputState"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                        }
                    });
                }else{
                        $('#inputState').empty();
                }
            }
        });
    }

    function getcities(stateID, token, selectedCity){
        $.ajax({
            url: '/findCityWithStateID/'+stateID,
            type: "GET",
            data : {"_token":token},
            dataType: "json",
            success:function(data) {
                if(data){
                    $('#inputCity').empty();
                    $('#inputCity').focus;
                    $('#inputCity').append('<option value="">-- Select City --</option>'); 
                    $.each(data, function(key, value){
                        if(value.id == selectedCity){
                            $('select[id="inputCity"]').append('<option value="'+ value.id +'" selected>' + value.name+ '</option>');
                        }else{
                            $('select[id="inputCity"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                        }
                    });
                }else{
                        $('#inputCity').empty();
                }
            }
        });
    }

    // Get Structure Exams
    function getstructureexams(token){
        $.ajax({
            url: '/getstructureexams/',
            type: "GET",
            data : {"_token":token},
            dataType: "json",
            success:function(data) {
                if(data){
                    $.each(data, function(key, value){
                        $('select[id="inputExams"] option[value='+value.id+']').attr('selected', 'selected');
                        // console.log(value.id);
                    });
                }
            }
        });
    }

    // Get Regions
    $.ajax({
        url: '/getregions/',
        type: "GET",
        data : {"_token":_token},
        dataType: "json",
        success:function(data) {
            if(data){
                $('#inputRegion').append('<option value="">-- Select Region --</option>'); 
                $.each(data, function(key, value){
                    $('#inputRegion').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                });
            }else{
                    $('#inputRegion').empty();
            }
        }
    });

    // Get Structure details of user if it exists
    $.ajax({
        url: '/getstructure/',
        type: "GET",
        data : {"_token":_token},
        dataType: "json",
        success:function(response) {
            if(response){
                $.each(response, function(key, value){
                    getstates(value.region, _token, value.state);
                    getcities(value.state, _token, value.city);
                    $('#inputName').val(value.name);
                    $('#inputPhone').val(value.phone);
                    $('#inputRegion option[value='+value.region+']').attr('selected', 'selected');
                    $('#inputZip').val(value.zip);
                    $('#inputAddress').val(value.address);
                    if(value.premium == '1'){
                        $('#gridCheck').attr('checked', 'checked');
                    }
                });
            }
        }
    });

// Get All Exams
    $.ajax({
        url: '/getexams/',
        type: "GET",
        data : {"_token":_token},
        dataType: "json",
        success:function(data) {
            if(data){
                $.each(data, function(key, value){
                    $('select[id="inputExams"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                });
                getstructureexams(_token);
            }else{
                    $('#inputExams').empty();
            }
        }
    });

    $('#addexams').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize()+'&_token=' + $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"/addstructureexams",
            method:"POST",
            data:form_data,
            success:function(response){
                if(response){
                    console.log(response);
                    $('#formMsg').html('');
                    if(response.status == 'error'){
                        $("#error-alert-exams").html(response.message);
                        $("#error-alert-exams").fadeTo(2000, 500).slideUp(500, function() {
                            $("#error-alert-exams").slideUp(500);
                        });
                    }else{
                        $("#success-alert-exams").html(response.message);
                        $("#success-alert-exams").fadeTo(2000, 500).slideUp(500, function() {
                            $("#success-alert-exams").slideUp(500);
                        });
                    }
                }else{
                    $("#error-alert-exams").html('An internal servver error has occured');
                    $("#error-alert-exams").fadeTo(2000, 500).slideUp(500, function() {
                        $("#error-alert-exams").slideUp(500);
                    });
                }
            }
        });
      
    });

// Select State based on Region
    $('#inputRegion').on('change', function() {
        var regionID = $(this).val();
        var select = '';
        if(regionID) {
            getstates(regionID, _token, select);
        }else{
        $('#inputState').empty();
        $('#inputCity').empty();
        $('#inputZip').empty();
        }
    });

//Select City based on State
    $('#inputState').on('change', function() {
        var stateID = $(this).val();
        var select = '';
        if(stateID) {
            getcities(stateID, _token, select);
        }else{
        $('#inputCity').empty();
        $('#inputZip').empty();
        }
    });

//Get City Post code
    $('#inputCity').on('change', function() {
        var cityID = $(this).val();
        if(cityID) {
            $.ajax({
                url: '/findZipWithCityID/'+cityID,
                type: "GET",
                data : {"_token":_token},
                dataType: "json",
                success:function(data) {
                    if(data){
                        $('#inputZip').empty();
                        $.each(data, function(key, value){
                            $('#inputZip').val(value.code);
                        });
                    }else{
                            $('#inputZip').empty();
                    }
                }
            });
        }else{
        $('#inputZip').empty();
        }
    });

    $("#addstructure").submit(function( event ) {
        event.preventDefault();
        
        var selectedCity = $("select#inputCity").children("option:selected").val();

        var premium = '';

        if($('input#gridCheck').prop("checked") == true){
            premium = 1;
        }
        else if($('input#gridCheck').prop("checked") == false){
            premium = 0;
        }

        var data = {
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'name' : $('#inputName').val(),
            'phone' : $('#inputPhone').val(),
            'city_id' : selectedCity,
            'address' : $('#inputAddress').val(),
            'premium' : premium,
        }
        if(data){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/addstructure',
                type: "POST",
                data : data,
                dataType: "json",
                success:function(response) {
                    if(response){
                        $('#formMsg').html('');
                        if(response.status == 'error'){
                            $("#error-alert").html(response.message);
                            $("#error-alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#error-alert").slideUp(500);
                            });
                        }else{
                            $("#success-alert").html(response.message);
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#success-alert").slideUp(500);
                            });
                        }
                    }else{
                        $("#error-alert").html('An internal servver error has occured');
                        $("#error-alert").fadeTo(2000, 500).slideUp(500, function() {
                            $("#error-alert").slideUp(500);
                        });
                    }
                }
            });
        }
    });
});