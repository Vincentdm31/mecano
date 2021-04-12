@extends('layouts.app')

@section('content')
<div class="container mt-5 grix xs1 sm3">
    <div class="card shadow-1 pos-sm2 rounded-2">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="bd-b-solid bd-orange bd-3 pb-2">Editer véhicule</p>
        </div>
        <div class="card-content p-0 pl-3 pr-3">
            <form class="form-material" method="POST" action="{{route('vehicules.update', ['vehicule' => $vehicule->id])}}">
                @method('PUT')
                @csrf
                <div class="">
                    <div class="form-field">
                        <input type="text" name="brand" class="form-control" value="{{$vehicule->brand}}" />
                        <label for="brand">Marque</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="model" class="form-control" value="{{$vehicule->model}}" />
                        <label for="model">Modele</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="license_plate" class="form-control" value="{{$vehicule->license_plate}}" />
                        <label for="license_plate">Immatriculation</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn orange dark-1 txt-white rounded-1 mt-3 mb-3">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection