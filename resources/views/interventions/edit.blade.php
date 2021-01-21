@extends('layouts.app')
@section('content')
<div class="container">
    <div class="grix xs1 p-2">
            <div>
                <p class="bd-airforce bd-b-solid bd-3">Déplacements ?</p>
            </div>
            <div>
            @if(empty($intervention->distance_km_interv))
            <p class="txt-airforce txt-light-2">Pas de déplacements</p>
            @else
            <p class="txt-airforce txt-light-2">{{ $intervention->distance_km_interv }} Km</p>
            @endif
            </div>
        <div class="grix xs2">
            <button id="btn_yes" class="btn shadow-1 rounded-1 airforce dark-4 w100">Oui</button>
            <form class="form-material" method="POST" action="{{ route('interventions.update', ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <input hidden value="0" name="distance_km_interv"></input>
                <button type="submit" id="btn_no" class="btn shadow-1 rounded-1 airforce dark-4 w100">Non</button>
            </form>
        </div>

    </div>
    <!-- Déplacements Interventions -->
    <div id="kmSection" class="grix xs1 mt-3 hide p-3">
        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
            @method('PUT')
            @csrf
            <div class="grix xs1 txt-center">
                <div class="form-field">
                    <input type="number" id="distance_km_interv" value="{{ $intervention->distance_km_interv }}" name="distance_km_interv" class="form-control txt-center" />
                    <label for="distance_km_interv" class="">Distance (Km)</label>
                </div>                        
            </div>
            <div class="txt-center">
                <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
                    Valider distance
                </button>
            </div>
        </form>
    </div>

    <!-- Choix Véhicule -->
    <div>
        <p class="bd-airforce bd-b-solid bd-3 mb-5">Choix du véhicule</p>
    </div>
    <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
        @method('PUT')
        @csrf
        <div class="form-field">
            <label for="select">Véhicule</label>
            <select class="form-control rounded-1" id="select" name="vehicule_id">
            @foreach ( $vehicules as $vehicule) 
                <option value="{{ $vehicule->id }}">{{ $vehicule->marque }} - {{ $vehicule->modele }} - {{ $vehicule->immat }}</option>
            @endforeach 
            </select>
        </div>
        <div class="txt-center">
                <button type="submit" class="btn airforce rounded-1 dark-4 mt-3">
                    Valider
                </button>
            </div>
    </form>
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
            isModifyVehicule = true;
        }
        else if(isModifyVehicule){
            sctVehicule.classList.add("hide");
            isModifyVehicule = false;
        }

    });

    
</script>
@endsection