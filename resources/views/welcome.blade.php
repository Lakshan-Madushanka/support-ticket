@extends('layouts.main')

@push('css')
    <style>
        .navbar a:hover {
            background-color: greenyellow !important;
        }
    </style>
@endpush

@section('header')
    {{strtoupper("Support ticket system")}}
@endsection

@section('main')
    <div class="row justify-content-between my-5">
        <div class="col-md test-center">
            <div class="p-5 text-white bg-info">
                <nav class="navbar navbar-dark justify-content-center bg-light">
                    <a href="{{route('support-ticket.createSearchByRefId')}}" class="nav-link text-center">
                        <h4>{{strtoupper('Search ticket')}}</h4>
                    </a>
                </nav>
            </div>
        </div>
        <div class="col-md ">
            <div class="p-5 bg-info">
                    <nav class="navbar navbar-dark justify-content-center bg-light">
                        <a href="{{route('support-ticket.create')}}" class="nav-link text-center">
                          <h4>{{strtoupper('New ticket')}}</h4>
                        </a>
                    </nav>
            </div>
        </div>

        @if(\Illuminate\Support\Facades\Gate::allows('supportAgent'))
            <div class="col-md">
                <div class="p-5 text-white bg-info">
                    <nav class="navbar navbar-dark justify-content-center bg-light">
                        <a href="{{route('support-ticket.index')}}" class="nav-link text-center">
                            <h4>{{strtoupper('Support agent')}}</h4>
                        </a>
                    </nav>
                </div>
            </div>
        @endif
    </div>
@endsection