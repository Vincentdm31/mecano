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
    <div id="km_section" class="hide">
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
                <button type="submit" class="btn airforce rounded-1 dark-4 mt-5">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
    <div class="class">
    <form class="form-material" method="POST" action="{{ route('operations.store')}}">
            @csrf
            <div class="txt-center">
                <input hidden name="intervention_id" value="{{request('intervention')}}"></input>
                <button type="submit" class="btn airforce rounded-1 dark-4 mt-5">
                    Nouvelle opération
                </button>
            </div>
    </form>
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