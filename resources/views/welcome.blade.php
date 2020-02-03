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

        .tag-header {
            color: white;
            margin-top: 20px;
            border-style: none none dotted none;
        }

        .clr-list-style {
            list-style: none;
        }

        .fl-left {
            float: left;
        }

        .room-list {
            padding: 10px;
        }

        .room-list > li {
            text-decoration: none;
            font-size: 1rem; 
            margin-left: 15px;
            color: #3490dc;
            cursor: pointer;
        }

        .room-list > li:hover {
            color: #1270ba;
        }

        .badge-info {
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')
<div class="container">
    @foreach ($tags as $tag)
        <div class="tag-header dark-bg"><h2 style="margin-left: 15px;"> {{ $tag->name }} <span class="badge badge-info">{{ $tag->rooms->count() }}</span> </h2></div>
        <ul class="room-list clr-list-style">
            @foreach ($tag->rooms as $room)
                <li class="fl-left" v-on:click="changeRoom('{{$room->name}}')">{{$room->name}}</li>
            @endforeach
            @if($tag->rooms->count() > 0)
                <li style="clear:both;"></li>
            @endif
        </ul>
    @endforeach
</div>
@endsection


