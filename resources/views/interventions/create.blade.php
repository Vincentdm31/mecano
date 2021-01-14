@extends('layouts.app')
@section('content')

<div class="container">
    <div class="grix xs1">
        <div class="grix xs2">
            <div>
                <p>Déplacements ?</p>
            </div>
            <div>
               <p class="txt-airforce txt-light-2">{{ request('kmVehicule') }} Km</p> 
            </div>
        </div>
        <div class="grix xs2">
            <button id="btn_yes" class="btn shadow-1 rounded-1 airforce dark-4 w100">Oui</button>
            <form class="form-material" method="POST" action="{{ route('interventions.update', request('intervention'))}}">
                @method('PUT')
                @csrf
                <input hidden value="0" name="distance_km_interv"></input>
                <button type="submit" id="btn_no" class="btn shadow-1 rounded-1 airforce dark-4 w100">Non</button>
            </form>
        </div>
    </div>
    <!-- Déplacements Interventions -->
    <div id="km_section" class="grix xs1 mt-3 hide">
        <form class="form-material" method="POST" action="{{ route('interventions.update', request('intervention'))}}">
            @method('PUT')
            @csrf
            <div class="grix xs1 txt-center">
                <div class="form-field">
                    <input type="text" id="distance_km_interv" value="{{request('kmVehicule')}}" name="distance_km_interv" class="form-control txt-center" />
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
    <div class="grix xs1">
        <div class="grix xs2">
            <div>
                <p>Choix du véhicule</p>
            </div>
            <div>
               <p class="txt-airforce txt-light-2">Le vehicule</p> 
            </div>
        </div>
        <div class="grix xs1">
            <form class="form-material" method="POST" action="{{ route('vehicules.store')}}">
                @csrf
                <div class="form-field">
                    <input type="text" id="marque" name="marque" value="" class="form-control txt-center" />
                    <label for="marque" class="">Marque</label>
                </div> 
                <div class="form-field">
                    <input type="text" id="modele" name="modele" value="" class="form-control txt-center" />
                    <label for="modele" class="">Modèle</label>
                </div>
                <div class="form-field">
                    <input type="text" id="km" name="km" value="" class="form-control txt-center" />
                    <label for="km" class="">Kilométrage</label>
                </div>
                <div class="form-field">
                    <input type="text" id="immat" name="immat" value="" class="form-control txt-center" />
                    <label for="immat" class="">Immatriculation</label>
                </div>
                <input hidden id="intervention_id" name="intervention_id" value="{{ request('intervention') }}"/></input>
                <button type="submit" class="btn shadow-1 rounded-1 airforce dark-4 w100">Ajouter Véhicule</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    var btn_yes = document.getElementById('btn_yes');
    var btn_no = document.getElementById('btn_no');
    var sct = document.getElementById('km_section');

    btn_yes.addEventListener("click", function() {
        sct.classList.remove("hide");
    });

    btn_no.addEventListener("click", function() {
        sct.classList.add("hide");
    });

</script>
@endsection