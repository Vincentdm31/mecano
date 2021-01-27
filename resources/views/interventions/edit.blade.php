@extends('layouts.app')
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>
<div class="container mt-5">
    <!-- Récapitulatif -->
    <div class="container shadow-1 p-2 mb-5">
        <p class="txt-center h3">Récapitulatif</p>
        <div class="grix xs1 md3">
            <!-- Déplacements -->
            <div>
                @if(empty($intervention->start_deplacement))
                <p class="txt-airforce txt-center txt-light-2">Pas de déplacements</p>
                @else
                <p class="txt-center h4 mb-2 txt-airforce txt-dark-4 bd-b-solid bd-b-4 p-3 bd-airforce bd-dark-4">Déplacements</p>
                <p class="txt-center txt-green txt-dark-2">{{ $intervention->start_deplacement}}</p>
                <p class="txt-center txt-red txt-dark-2">{{ $intervention->end_deplacement}}</p>
                @endif
            </div>
            <!-- Véhicule -->
            <div>
                @if(empty($intervention->vehicule_id))
                <p class="txt-airforce txt-center txt-light-2">Choisir un véhicule</p>
                @else
                <p class="txt-center h4 mb-2 txt-airforce txt-dark-4 bd-b-solid bd-b-4 p-3 bd-airforce bd-dark-4">Véhicule</p>
                <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->marque}}</p>
                <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->modele}}</p>
                <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->immat}}</p>
                @endif
            </div>
            <!-- Kilométrage -->
            <div>
                @if(empty($intervention->km_vehicule))
                <p class="txt-airforce txt-center txt-light-2">Saisir le kilométrage</p>
                @else
                <p class="txt-center h4 mb-2 txt-airforce txt-dark-4 bd-b-solid bd-b-4 p-3 bd-airforce bd-dark-4">Kilométrage</p>
                <p class="txt-center txt-green txt-dark-2">{{$intervention->km_vehicule}}</p>

                @endif
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="container">
    <div class="container shadow-1 mt-5">
        <div class="grix xs1 md3">
            <!-- Déplacement collapsible -->
            <div class="p-2">
                <button data-target="collapsible-deplacement" class="btn rounded-1 press airforce dark-4 collapsible-trigger w100 mx-auto">
                    Déplacements
                </button>
                <div class="collapsible mb-3" id="collapsible-deplacement" data-ax="collapsible">
                    <div class="grix xs1">
                        <!--Start Déplacement Interventions -->
                        <div id="kmSection" class="grix xs1 sm2">
                            <div class="">
                                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="txt-center">
                                        <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement" />
                                        <button type="submit" class="btn green dark-2 rounded-1 dark-4 mt-3">
                                            Start Déplacement
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--End Déplacement Interventions -->
                            <div class="mb-5">
                                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="txt-center">
                                        <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement" />
                                        <button type="submit" class="btn red dark-2 rounded-1 dark-4 mt-3">
                                            End Déplacement
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Choix Véhicule collapsible -->
            <div class="p-2">
                <button data-target="collapsible-vehicule" class="btn rounded-1 press airforce dark-4 collapsible-trigger w100 mx-auto">
                    Choix du véhicule
                </button>
                <div class="collapsible mb-3" id="collapsible-vehicule" data-ax="collapsible">
                    <div class="mt-2 mb-2">
                        <form class="form-material" method="GET" action="{{ route('selectVehicule')}}">
                            @csrf
                            <div class="grix xs6">
                                <div class="form-field pos-xs1 col-xs5">
                                    <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}" />
                                    <input type="text" name="selectVehicule" id="selectVehicule" class="form-control" />
                                    <label for="selectVehicule">Rechercher</label>
                                </div>
                                <button type="submit" class="btn circle ml-auto vself-center rounded-4"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-5">
                        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="form-field">
                                <label for="select">Véhicule</label>
                                <select class="form-control rounded-1" id="select" name="vehicule_id">
                                    @foreach ( $vehicules as $vehicule)
                                    <option value="{{ $vehicule->id }}">{{ $vehicule->immat }} - {{ $vehicule->marque }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="txt-center">
                                <button type="submit" class="btn green dark-2 rounded-1 mt-3">
                                    Valider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Kilométrage véhicule collapsible -->
            <div class="p-2">
                <button data-target="collapsible-kilometrage" class="btn rounded-1 press airforce dark-4 collapsible-trigger mx-auto w100">
                    Kilométrage
                </button>
                <div class="collapsible mb-3" id="collapsible-kilometrage" data-ax="collapsible">
                    <div class="">
                        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="grix xs1 txt-center">
                                <div class="form-field">
                                    <input type="number" id="km_vehicule" name="km_vehicule" value="{{ $intervention->km_vehicule }}" class="form-control txt-center" />
                                    <label for="km_vehicule" class="">Kilométrage</label>
                                </div>
                            </div>
                            <div class="txt-center">
                                <button type="submit" class="btn green dark-2 rounded-1 mt-3 mb-3">
                                    Valider Kilométrage
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')

@endsection