@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" name="search" 
                        value="@if(!empty($_GET) && !empty($_GET['search'])){{ $_GET['search'] }}@endif" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    @if(!empty($_GET) && !empty($_GET['search']))
                    @if($structures->isNotEmpty())
                    @foreach ($structures as $structure)
                        <div class="post-list">
                            <p @if($structure->premium) style="color:green" @endif >
                            {{ $structure->name }} {{ $structure->city }}
                            {{ $structure->state }}{{ $structure->region }}{{ $structure->address }}
                            {{ $structure->zip }}</p>
                        </div>
                    @endforeach
                    {{ $structures->appends(Request::get('page'))->links() }}
                    @else 
                        <div>
                            <h2>No Structure found matching your exams search term</h2>
                        </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
