@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container h100 d-flex pb-5">
    <div class="vself-center container card overflow-visible shadow-1 rounded-3 white">
        <div class="card-header p-0">
            <p class="m-0 txt-grey txt-light-4 p-3 font-s2 dark mb-4 rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">Choix du véhicule</p>
        </div>
        <div class="card-content pl-4 pr-4 pt-0 pb-0">
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
                                <div class="d-flex vcenter">
                                    <button type="submit" class="btn shadow-1 rounded-1 orange dark-1 circle rounded-4 small"><i class="fas fa-search txt-white"></i></button>
                                </div>
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
                                    <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $vehicule->id }}">{{ $vehicule->brand }} - {{ $vehicule->license_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <input type="number" name="km_vehicule" id="km_vehicule" class="form-control txt-airforce txt-dark-4" />
                                <label for="km_vehicule">Kilométrage</label>
                            </div>

                            <input hidden name="id" value="{{ $intervention->id }}" /></input>

                            <div class="txt-center pt-2">
                                <button type="submit" class="btn orange dark-1 small txt-white rounded-1"><i class="fas fa-check pl-3 pr-3"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex my-auto">
                    <img src="{{ asset('/images/car.svg') }}" class="responsive-media p-3" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection