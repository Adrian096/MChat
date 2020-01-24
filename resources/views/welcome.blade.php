@extends('layouts.app')

@section('styles')
    <style>
        #search-box{
            text-align: left;
            width: 100%;
            border: 1px solid #d9d9d9;
            margin: auto;
            display: block;
            border-radius: 0;
        }

        .room-expanded-list-box > ul{
            list-style: none;
            margin: 0;
            padding: 0;
            border-width: 1px;
            border-color: #d9d9d9;
            border-style: none solid solid solid;
        }

        .room-expanded-list-box > ul > li {
            cursor: pointer;
            padding: 10px;
            transition: 0.3s;
        }

        .room-expanded-list-box > ul > li:hover {
            background-color: #d9d9d9;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <room-expanded-list :rooms="{{$rooms}}"></room-expanded-list> --}}
            <!--<room-list :items="{{$rooms}}" current-item="{{Request::route('id')}}"></room-list>-->
        </div>
    </div>
</div>
@endsection


