@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <form  method="POST" action="{{ route('dashboard') }}" id="addstructure">
                            @csrf
                            <div class="alert" role="alert"></div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Structure Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPhone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputRegion">Region</label>
                                    <select id="inputRegion" class="form-control">
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">State</label>
                                    <select id="inputState" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <select id="inputCity" name="city_id" class="form-control">
                                </select>
                                </div>
                                <div class="form-group col-md-4">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Via...">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    Check me out
                                </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Structure</button>
                        </form>
                    </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Exams') }}</div>
                    <div class="card-body">
                        <p>Select list of medical exams offered by your Structure</p>
                        <form  method="POST" action="{{ route('dashboard') }}" id="addstructure">
                            @csrf
                            <div class="alert" role="alert"></div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputExams">Select Exams</label>
                                    <select class="custom-select" id="inputExams" multiple>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    </div>
    
</div>
@endsection
