@extends('layouts.app')

@section('content')
    <div class="jumbotron shadow-sm">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form>
                        <div class="form-row">
                            <div class="col-md-2 mb-3"></div>
                            <div class="col-md-6 mb-3">
                                <input class="form-control" name="search" 
                                    value="{{ request()->get('search') }}" 
                                    type="text" placeholder="Search" aria-label="Search">
                                @if(!request())
                                    <input type="hidden" name="sortBy" value="">
                                @endif
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                            <div class="col-md-2 mb-3"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                        @if(request()->get('search'))
                            @if($structures->isNotEmpty())
                                <div class="float-right form-inline">
                                    Displaying {{$structures->firstItem()}} 
                                    - {{$structures->lastItem()}} of {{ $structures->total() }} result(s)&nbsp &nbsp
                                    <select class="form-control" id="sortResult" name="sortBy" onchange="this.form.submit()">
                                        <option value="" selected>
                                            -- Default Sorting --
                                        </option>
                                        @if(request()->get('sortBy'))
                                        <option value="region" {{ (request()->get('sortBy') == 'region' ? "selected":"") }}>
                                            Sort by Region
                                        </option>
                                        <option value="city" {{ (request()->get('sortBy') == 'city' ? "selected":"") }}>
                                            Sort by City</option>
                                        <option value="exams.name" {{ (request()->get('sortBy') == 'exams.name' ? "selected":"") }}>
                                            Sort by Exam
                                        </option>
                                        @else
                                        <option value="region">Sort by Region</option>
                                        <option value="city">Sort by City</option>
                                        <option value="exams.name">Sort by Exam</option>
                                        @endif
                                    </select>
                                </div>
                                </form>
                                {{ $structures->appends(Request::get('page'))->links() }} 

                                @foreach ($structures as $structure)
                                    <div class="card @if($structure->premium) border-success @endif mb-3">
                                        <div class="card-body @if($structure->premium) text-success @endif">
                                        @if($structure->premium) <div class="float-right">Sponsored</div>@endif
                                            <h5 class="card-title">{{ $structure->name }}</h5>
                                            <p class="card-text">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i> 
                                                    {{ $structure->address }}, 
                                                    {{ $structure->city->name }}, {{ $structure->state->name }}, 
                                                    {{ $structure->region->name }},
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $structures->appends(Request::get('page'))->links() }}
                            @else
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">
                                            No results found your search criteria
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
