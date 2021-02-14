@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('storage/images/'.$image->image) }}">
</div>

@endsection