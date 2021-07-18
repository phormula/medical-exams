require('./bootstrap');

// Get Regions
$(document).ready(function() {
    $.ajax({
        url: '/getregions/',
        type: "GET",
        data : {"_token":"{{ csrf_token() }}"},
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

// Select State based on Region
    $('#inputRegion').on('change', function() {
        var regionID = $(this).val();
        if(regionID) {
            $.ajax({
                url: '/findStateWithRegionID/'+regionID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
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
                data : {"_token":"{{ csrf_token() }}"},
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
                data : {"_token":"{{ csrf_token() }}"},
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
});