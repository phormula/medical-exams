const { result } = require('lodash');

require('./bootstrap');

$(document).ready(function() {
    _token="{{csrf_token()}}";
    $('#inputZip').empty();

    // Get Regions
    $.ajax({
        url: '/getregions/',
        type: "GET",
        data : {"_token":_token},
        dataType: "json",
        success:function(data) {
            if(data){
                $('#inputRegion').focus;
                $('#inputRegion').append('<option value="">-- Select Region --</option>'); 
                $.each(data, function(key, value){
                    $('select[id="inputRegion"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                });
            }else{
                    $('#inputRegion').empty();
            }
        }
    });

// Get Exams
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
            }else{
                    $('#inputExams').empty();
            }
        }
    });

// Select State based on Region
    $('#inputRegion').on('change', function() {
        var regionID = $(this).val();
        if(regionID) {
            $.ajax({
                url: '/findStateWithRegionID/'+regionID,
                type: "GET",
                data : {"_token":_token},
                dataType: "json",
                success:function(data) {
                    if(data){
                        $('#inputState').empty();
                        $('#inputState').focus;
                        $('#inputState').append('<option value="">-- Select State --</option>'); 
                        $.each(data, function(key, value){
                            $('select[id="inputState"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                        });
                    }else{
                            $('#inputState').empty();
                    }
                }
            });
        }else{
        $('#inputState').empty();
        $('#inputCity').empty();
        $('#inputZip').empty();
        }
    });

//Select City based on State
    $('#inputState').on('change', function() {
        var stateID = $(this).val();
        if(stateID) {
            $.ajax({
                url: '/findCityWithStateID/'+stateID,
                type: "GET",
                data : {"_token":_token},
                dataType: "json",
                success:function(data) {
                    if(data){
                        $('#inputCity').empty();
                        $('#inputCity').focus;
                        $('#inputCity').append('<option value="">-- Select City --</option>'); 
                        $.each(data, function(key, value){
                            $('select[id="inputCity"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                        });
                    }else{
                            $('#inputCity').empty();
                    }
                }
            });
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

        var data = {
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'name' : $('#inputName').val(),
            'phone' : $('#inputPhone').val(),
            'city_id' : selectedCity,
            'address' : $('#inputAddress').val()
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
                        console.log(response.status);
                        if(response.status == 'error'){
                            $('.alert').addClass('alert-danger');
                            $('.alert').html(response.message);
                        }else{
                            $('.alert').addClass('alert-success');
                            $('.alert').html(response.message);
                        }
                    }else{
                        $('.invalid-feedback').html('An internal servver error has occured');
                    }
                }
            });
        }
    });
});