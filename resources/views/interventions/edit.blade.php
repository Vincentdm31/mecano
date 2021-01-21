@extends('layouts.app')
@section('content')

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
    <!-- Choix véhicule -->
    <div class="grix xs1 mt-3 p-3">
        @if(empty($intervention->vehicule->marque))
        <div class="grix xs1">
            <div>
                <p class="bd-airforce bd-b-solid bd-3">Choix du véhicule</p>
            </div>
            <form class="form-material" method="POST" action="{{ route('vehicules.store')}}">
                @csrf
                <div class="form-field">
                    <input required type="text" id="marque" name="marque"class="form-control txt-center" />
                    <label for="marque" class="">Marque</label>
                </div> 
                <div class="form-field">
                    <input required type="text" id="modele" name="modele"class="form-control txt-center" />
                    <label for="modele" class="">Modèle</label>
                </div>
                <div class="form-field">
                    <input required type="text" id="km" name="km"class="form-control txt-center" />
                    <label for="km" class="">Kilométrage</label>
                </div>
                <div class="form-field">
                    <input required type="text" id="immat" name="immat" class="form-control txt-center" />
                    <label for="immat" class="">Immatriculation</label>
                </div>
                <input hidden id="intervention_id" name="intervention_id" value="{{ $intervention->id }}"/></input>
                <button type="submit" class="btn shadow-1 rounded-1 airforce dark-4 w100">Ajouter Véhicule</button>
            </form>
        </div>
        @else
        <div class="grix xs1">
            <p class="bd-airforce bd-b-solid bd-3">Véhicule</p>
            <div class="grix xs3">
                <div>
                    <p class="txt-airforce txt-dark-2">{{ $intervention->vehicule->marque }}</p>
                    <p class="txt-airforce txt-dark-2">{{ $intervention->vehicule->modele }}</p>
                </div>
                <div>
                    <p class="txt-airforce txt-dark-2">{{ $intervention->vehicule->immat }}</p>
                    <p class="txt-airforce txt-dark-2">{{ $intervention->vehicule->km }}</p>
                </div>
                <div class="my-auto">
                    <button id="btnModifyVehicule"class="btn airforce dark-4 rounded-1">Modifier</button>
                </div>
            </div>
            
            <!-- Modif Vehicule -->
            <form class="form-material hide" id="vehiculeForm" method="POST" action="{{ route('vehicules.update', ['vehicule' => $intervention->vehicule->id])}}">
                @method('PUT')
                @csrf
                <div class="form-field">
                    <input required type="text" id="marque" name="marque" class="form-control txt-center" value="{{ $intervention->vehicule->marque }}" />
                    <label for="marque" class="">Marque</label>
                </div> 
                <div class="form-field">
                    <input required type="text" id="modele" name="modele"class="form-control txt-center" value="{{ $intervention->vehicule->modele }}" />
                    <label for="modele" class="">Modèle</label>
                </div>
                <div class="form-field">
                    <input required type="text" id="km" name="km"class="form-control txt-center" value="{{ $intervention->vehicule->km }}" />
                    <label for="km" class="">Kilométrage</label>
                </div>
                <div class="form-field">
                    <input required type="text" id="immat" name="immat" class="form-control txt-center" value="{{ $intervention->vehicule->immat }}" />
                    <label for="immat" class="">Immatriculation</label>
                </div>
                <input hidden id="intervention_id" name="intervention_id" value="{{ $intervention->id }}"/></input>
                <button type="submit" class="btn shadow-1 rounded-1 airforce dark-4 w100">Modifier Véhicule</button>
            </form>
        </div>
        @endif
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