@extends('layouts.app')
@section('pageTitle')
Add Sim
@endsection
@section('content')
<div class="container sim-create">
    <div class="card-content">
        <form class="form-material" method="POST" action="{{ route('sims.store') }}">
            @csrf
                    <div class="grix xs1 txt-center">
                        <div class="form-field">
                            <input type="text" id="idgps" name="idgps" class="form-control txt-center" />
                            <label style="transform: translateX(-50%);left:50%;"for="idgps" class="">ID GPS</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="immat" name="immat" class="form-control txt-center" required />
                            <label style="transform: translateX(-50%);left:50%;" for="immat">Immatriculation</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="numsupgeo" name="numsupgeoloc" class="form-control txt-center" required />
                            <label style="transform: translateX(-50%);left:50%;"for="numsupgeo">N° Sup Geoloc</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="numligne" name="numligne" class="form-control txt-center" required />
                            <label style="transform: translateX(-50%);left:50%;"for="numligne">N° Ligne</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="numsimviergereafect" name="numsimviergereafect" class="form-control txt-center" required />
                            <label style="transform: translateX(-50%);left:50%;"for="numsimviergereafect">N° Sim Vierge Reaffect</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="F" name="F" class="form-control txt-center" required />
                            <label style="transform: translateX(-50%);left:50%;"for="F">Autre</label>
                        </div>
                        
                    </div>
                    <div class="flex fx-right">

                        <button type="submit" class="btn press create-send mx-auto mt-5">
                            Envoyer
                        </button>
                    </div>
                </form>
    </div>
</div>
@endsection

