@extends('layouts.app')
@section('content')

<div class="container">
    <div class="grix xs1">
        <p>Déplacements ?</p>
        <div class="grix xs2">
            <button id="btn_yes" class="btn shadow-1 airforce dark-4 w100">Oui</button>
            <button id="btn_no" class="btn shadow-1 airforce dark-4 w100">Non</button>
        </div>
    </div>
    <div id="km_section" class="d-hide">
        <form class="form-material" method="POST" action="{{ route('interventions.update', request('intervention'))}}">
            @method('PUT')
            @csrf
            <div class="grix xs1 txt-center">
                <div class="form-field">
                    <input type="text" id="distance_km_interv" name="distance_km_interv" class="form-control txt-center" />
                    <label for="distance_km_interv" class="">Distance (Km)</label>
                </div>                        
            </div>
            <div class="flex fx-right">
                <button type="submit" class="btn press mx-auto mt-5">
                    Envoyer
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
        sct.classList.remove("d-hide");
    });

    btn_no.addEventListener("click", function() {
        sct.classList.add("d-hide");
    });

</script>
@endsection