@extends('layouts.app')
@section('content')
<?php 
use Carbon\Carbon;
$date = Carbon::now();
?>
<div class="container mt-5">
    <div class="container shadow-1 p-2">
        <!-- Déplacement collapsible -->
        <button data-target="collapsible-deplacement" class="btn rounded-1 press airforce dark-4 collapsible-trigger mx-auto w100">
            Déplacements
        </button>
        <div class="collapsible mb-3" id="collapsible-deplacement" data-ax="collapsible">
            <div class="grix xs1">
                <div>
                @if(empty($intervention->start_deplacement))
                <p class="txt-airforce txt-light-2">Pas de déplacements</p>
                @else
                <div class="card shadow-1">
                    <div class="grix xs2">
                        <div>
                        <p class="txt-center">{{ $intervention->start_deplacement}}</p>
                        </div>
                        <div>
                        <p class="txt-center">{{ $intervention->end_deplacement}}</p>
                        </div>
                    </div>
                </div>
                @endif
                </div>

                <!--Start Déplacement Interventions -->
                <div id="kmSection" class="grix xs2">
                    <div class="">
                        <form  method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="txt-center">
                                <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement"/>
                                <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
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
                                <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement"/>
                                <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
                                    End Déplacement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Choix Véhicule collapsible -->
        <button data-target="collapsible-vehicule" class="btn rounded-1 press airforce dark-4 collapsible-trigger mx-auto w100 mt-3">
                Choix du véhicule
        </button>
        <div class="collapsible mb-3" id="collapsible-vehicule" data-ax="collapsible">
            @if(empty($intervention->vehicule_id))
            <div class="mt-2 mb-2">
                <form class ="form-material" method="GET" action="{{ route('selectVehicule')}}">
                    @csrf
                    <div class="grix xs6">
                        <div class="form-field pos-xs1 col-xs5">
                            <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}"/>
                            <input type="text" name="selectVehicule" id="selectVehicule"class="form-control"/>
                            <label for="selectVehicule">Rechercher</label>
                        </div>
                        <button type ="submit" class="btn circle ml-auto vself-center rounded-4"><i class="fa fa-search"></i></button>
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
                        <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
                            Valider
                        </button>
                    </div>
                </form>
                @endif
                @if(!empty($intervention->vehicule_id))
                    <div class="container grix xs1">
                        <div class="card shadow-1">
                            <div class="card-content">
                                <p>{{$intervention->vehiculeList->marque}}</p>
                                <p>{{$intervention->vehiculeList->modele}}</p>
                                <p>{{$intervention->vehiculeList->immat}}</p>
                            </div>            
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kilométrage véhicule collapsible -->
    <button data-target="collapsible-kilometrage" class="btn rounded-1 press airforce dark-4 collapsible-trigger mx-auto w100 mt-3 mb-3">
            Kilométrage du véhicule
    </button>
    <div class="collapsible mb-3" id="collapsible-kilometrage" data-ax="collapsible">
        <div class="">
            <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1 txt-center">
                    <div class="form-field">
                        <input type="number" id="km_vehicule" name="km_vehicule" value="{{ $intervention->km_vehicule }}" class="form-control txt-center" />
                        <label for="km_vehicule" class="">Kilométrage véhicule (Km)</label>
                    </div>                        
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn airforce rounded-1 dark-4 mt-3 mb-3">
                        Valider Kilométrage
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>
    </div>
</div>
@endsection

@section('extra-js')

@endsection