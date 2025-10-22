@extends('layouts.app')

@section('title', $title . ' | Discorev')

@section('content')
    <div class="container my-5">
        <div class="legal-content">
            <h1>{{ $title }}</h1>
            <hr>
            @include($viewName)
        </div>
    </div>
@endsection
