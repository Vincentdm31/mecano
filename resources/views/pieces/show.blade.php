@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container shadow-1 grix xs1 md2 mt-5">
        <div class="p-3">
            <p>Nom : {{ $piece->name }}</p>
            <p>Ref : {{ $piece->ref }}</p>
            <p>Prix : {{ $piece->price }} €/u</p>
            <p>Quantité : {{ $piece->qte }}</p>
        </div>
        <img src="{{ asset('storage/images/'.$piece->img) }}" class="responsive-media p-3">
    </div>

</div>

@endsection