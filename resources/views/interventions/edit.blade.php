@extends('layouts.app')
@section('content')
<?php 
use Carbon\Carbon;
$date = Carbon::now();
?>
<div class="container">
    <div class="container grix xs1 p-2">
            <div>
                <p class="bd-airforce bd-b-solid bd-3">Déplacements ?</p>
            </div>
            <div>
            @if(empty($intervention->start_deplacement))
            <p class="txt-airforce txt-light-2">Pas de déplacements</p>
            @else
            <div class="card shadow-1">
                <div class="card-content">
                    <p class="">{{ $intervention->start_deplacement}}</p>
                </div>
            </div>
            @endif
            </div>
        <div class="grix xs2">
            <button id="btn_yes" class="btn shadow-1 rounded-1 airforce dark-4 w100">Oui</button>
        </div>

    </div>
    <!--Start Déplacement Interventions -->
    <div id="kmSection" class="container grix xs2 mt-3 hide">
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
        <div class="">
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

    <!-- Choix Véhicule -->
    <div class="container">
        <p class="bd-airforce bd-b-solid bd-3  mt-3 mb-5">Choix du véhicule</p>
    </div>
    @if(empty($intervention->vehicule_id))
    <div class="container mt-2 mb-2">
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
    <div class="container mt-5 ">
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
        </form>
    </div>
    <div class="container mt-5 mb-5">
        <div class="">
            <p class="bd-airforce bd-b-solid bd-3  mt-3 mb-5">Kilométrage du véhicule</p>
        </div>
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
                    <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
                        Valider Kilométrage
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection

@section('extra-js')
<script>
    let btnYes = document.getElementById('btn_yes');
    let btnNo = document.getElementById('btn_no');
    let sct = document.getElementById('kmSection');
    let sctVehicule = document.getElementById('vehiculeForm');
    let btnModifyVehicule = document.getElementById('btnModifyVehicule');
    let isModifyVehicule = false;

    btnYes.addEventListener("click", function() {
        sct.classList.remove("hide");
    });

    btnNo.addEventListener("click", function() {
        sct.classList.add("hide");
    });

    
    btnModifyVehicule.addEventListener("click", function() {
        if(isModifyVehicule === false){
            sctVehicule.classList.remove("hide");
            isModifyVehicule = !isModifyVehicule;
        }
        else if(isModifyVehicule){
            sctVehicule.classList.add("hide");
            isModifyVehicule = !isModifyVehicule;
        }

    });

    
</script>
@endsection