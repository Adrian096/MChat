@extends('layouts.app')

@section('styles')
    <style>
        .settings-wrapper > form {
            display: flex;
            align-items: center;
            flex-direction: column; 
            justify-content: center;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="settings-wrapper d-flex justify-content-center">
        <settings-form :user="{{ Auth::user() }}"></settings-form>
    </div>
@endsection