@extends('layouts.app')

@section('content')
<div class="container mt-5 grix xs1 sm3">
    <div class="card shadow-1 pos-sm2 rounded-2">
        <div class="card-content">
            <form class="form-material" method="POST" action="{{route('vehicules.update', ['vehicule' => $vehicule->id])}}">
                @method('PUT')
                @csrf
                <div class="">
                    <div class="form-field">
                        <input type="text" id="marque" name="marque" class="form-control" value="{{$vehicule->marque}}" />
                        <label for="marque">Marque</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="modele" name="modele" class="form-control" value="{{$vehicule->modele}}" />
                        <label for="modele">Modele</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="immat" name="immat" class="form-control" value="{{$vehicule->immat}}" />
                        <label for="immat">Immatriculation</label>
                    </div>                 
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn orange dark-1 txt-white rounded-1 mt-5">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
