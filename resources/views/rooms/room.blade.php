@extends('layouts.app')

@section('styles')
    <style>
        .chat-container {
            width: 100%;
            height: 100%;
        }
        .chat-container > * {
            color: white;
        }
        .room-title-header {
            margin: 0 0 0 10px;
        }
        .room-nav {
            margin: 1px;
            font-size: 25px;
            border-style: none none solid none;
        }
        .flex-row {
            padding: 0;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
        }
        .flex-col {
            display: flex;
            flex-direction: column;
            flex-flow: column;
            justify-content: flex-start;
            flex-wrap: nowrap;
        }
        #msgBox{
            flex: 1 100%;
            border-style: none none none solid;
            overflow-y: auto;
        }
        #fav-button {
            cursor: pointer;
            border: none;
            margin: 5px;
            border-radius: 50%;
            transition: 0.3s;
        }
        #fav-button:hover {
            background-color: #1f7f5c;
        }
        #message{
            height: 4em;
            flex: 1 0 auto;
            resize: none;
            border-style: solid;
        }
        #sendBtn{
            padding: 6px 24px 6px 24px;
            font-size: 1em;
            color: white;
            flex: 0 0 auto;
            border-style: solid none solid none;
        }
        #room-selection  {
            -moz-appearance:none; /* Firefox */
            -webkit-appearance:none; /* Safari and Chrome */
            appearance:none;
            padding: 0.8em;
        }
        select.minimal {
            background-image:
                linear-gradient(45deg, transparent 50%, gray 50%),
                linear-gradient(135deg, gray 50%, transparent 50%),
                linear-gradient(to right, gray, gray);
            background-position:
                calc(100% - 20px) calc(1em + 2px),
                calc(100% - 15px) calc(1em + 2px),
                calc(100% - 2.5em) 0.5em;
            background-size:
                5px 5px,
                5px 5px,
                1px 1.5em;
            background-repeat: no-repeat;
        }
        select.minimal:focus {
            background-image:
                linear-gradient(45deg, green 50%, transparent 50%),
                linear-gradient(135deg, transparent 50%, green 50%),
                linear-gradient(to right, #ccc, #ccc);
            background-position:
                calc(100% - 15px) 1em,
                calc(100% - 20px) 1em,
                calc(100% - 2.5em) 0.5em;
            background-size:
                5px 5px,
                5px 5px,
                1px 1.5em;
            background-repeat: no-repeat;
            outline: 0;
        }

        .message-card{
            display: inline-block;
            max-width: 300px;
            margin-top: 5px;
        }
        .message-header{
            color: #65e669;
        }

        .list-messages{
            list-style: none;
            text-decoration: none;
        }
        .list-messages > li {
            margin-top: 10px;
        }

    </style>
@endsection

@section('content')
    <div class="chat-container flex-col dark-bg">
        <div class="nav-content room-nav dark-bg">
            <ul class="mr-auto-nav clr-mg-pd dark-bg">
                <h3 class="room-title-header dark-bg" style="height: 100%;">{{Request::route('id')}}</h3>
            </ul>
            <ul class="nav-auto-right ml-auto-nav clr-mg-pd dark-bg">
                <span id="fav-button" class="dark-bg" style="float: right; padding: 1px 8px; text-align: center;"
                    v-on:click="addFavorite('{{Request::route('id')}}')">
                    <i style="vertical-align: middle;" class="material-icons" v-if="favorites.includes('{{Request::route('id')}}')">favorite</i>
                    <i style="vertical-align: middle;" class="material-icons" v-else>favorite_border</i>
                </span>
            </ul>
        </div>
        <div id="msgBox" class="dark-bg">
            <chat-messages 
                :messages="messages" 
                v-on:fetchmessage="fetchMessages('{{ route('fetch-messages', ['id' => Request::route('id')]) }}')"
                v-on:joinchannel="joinChannel('{{ Request::route('id') }}')"/>
        </div>

        <div class="flex-row">
            <textarea name="message" id="message" class="dark-bg" v-model="message"></textarea>
            <input type="button" id="sendBtn" class="dark-bg" 
                v-on:click.prevent="sendMessage('{{ route('send-message', ['id' => Request::route('id')]) }}')" value="Send"/>
        </div>
    </div>
@endsection