@extends('layouts.app')

@section('content')
<div class="container mt-5 grix xs1 sm3">
    <div class="card shadow-1 pos-sm2">
        <div class="card-content">
            <form class="form-material" method="POST" action="{{route('vehicules.update', ['vehicule' => $vehicule->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="marque" name="marque" class="form-control txt-center" value="{{$vehicule->marque}}" />
                        <label for="marque">Marque</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="modele" name="modele" class="form-control txt-center" value="{{$vehicule->modele}}" />
                        <label for="modele">Modele</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="immat" name="immat" class="form-control txt-center" value="{{$vehicule->immat}}" />
                        <label for="immat">Immatriculation</label>
                    </div>                 
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn airforce dark-4 mt-5">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
