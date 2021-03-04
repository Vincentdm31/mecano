@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container h100 d-flex">
    <div class="vself-center container card overflow-visible shadow-1 rounded-2 grey light-4">
        @if(empty($intervention->vehicule_id))
        <div class="card-header p-1 bd-b-solid bd-orange bd-dark-1 bd-2 m-0 ml-4 mr-4">
            <p class="txt-airforce txt-dark-4 h6">Choix du véhicule</p>
        </div>
        <div class="card-content">
            <div class="mt-2 mb-2 grix sm2 gutter-sm5">
                <div class="my-auto">
                    <div>
                        <form class="form-material" method="GET" action="{{ route('searchIntervVehicule')}}">
                            @csrf
                            <div class="grix xs6">
                                <div class="form-field pos-xs1 col-xs5">
                                    <input type="text" name="searchIntervVehicule" id="searchIntervVehicule" class="form-control txt-airforce txt-dark-4" />
                                    <input hidden name="id" value="{{ $intervention->id }}" /></input>
                                    <label for="searchIntervVehicule">Rechercher</label>
                                </div>
                                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange circle mx-auto vself-center rounded-4"><span class="outline-text outline-invert"><i class="fas fa-search"></i></span></button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-5">
                        <form class="form-material" method="POST" action="{{ route('selectVehicule')}}">
                            @method('PUT')
                            @csrf
                            <div class="form-field">
                                <label for="select">Véhicule</label>
                                <select class="form-control  txt-airforce txt-dark-4" name="vehicule_id">
                                    @foreach ( $vehicules as $vehicule)
                                    <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $vehicule->id }}">{{ $vehicule->immat }} - {{ $vehicule->marque }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <input type="number" name="km_vehicule" id="km_vehicule" class="form-control txt-airforce txt-dark-4" />
                                <label for="km_vehicule">Kilométrage</label>
                            </div>

                            <input hidden name="id" value="{{ $intervention->id }}" /></input>

                            <div class="txt-center">
                                <button type="submit" class="btn shadow-1 outline opening txt-orange ml-auto vself-center rounded-2 mt-2 small"><span class="outline-text outline-invert">Valider</span></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="d-flex my-auto">
                    <img src="{{ asset('/images/car.svg') }}" class="responsive-media p-3" alt="">
                </div>
            </div>
            @else
            <div class="card-header p-1 bd-b-solid bd-orange bd-dark-1 bd-2 m-0 ml-4 mr-4">
                <p class="txt-airforce txt-dark-4 h6">Véhicule enregistré</p>
            </div>
            <div class="card-content">
                <p>Marque : {{ $intervention->vehiculeList->marque }}</p>
                <p>Modèle : {{ $intervention->vehiculeList->modele }}</p>
                <p>Kilométrage : {{ $intervention->km_vehicule }} Km</p>
            </div>
            @endif

            @if(!empty($intervention->vehicule_id))
            <div class="card-footer m-0 p-0">
                <form action="{{ route('stepTwo') }}" method="POST">
                @csrf
                    <input hidden name="id" value="{{ $intervention->id }}" /></input>
                    <div class="d-flex fx-center">
                        <button type="submit" class="btn shadow-1 airforce dark-3 ml-auto txt-white rounded-1 hide-md-down mb-2 mr-2 small">Suivant</button>
                        <button type="submit" class="btn shadow-1 red dark-3 txt-white rounded-1 hide-md-up mb-2 mr-2 small">Suivant</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection