@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="card rounded-2 shadow-1 pos-sm2">
            <div class="card-header pl-3 pr-3 p-0">
                <p class="bd-b-solid bd-orange bd-3 pb-2">Nouveau véhicule</p>
            </div>
            <div class="card-content p-0 pl-3 pr-3">
                <form class="form-material" method="POST" action="{{ route('vehicules.store') }}">
                    @csrf
                    <div class="grix xs1 txt-center">
                        <div class="form-field">
                            <input required type="text" id="marque" name="marque" class="form-control" />
                            <label for="marque" class="">Marque</label>
                        </div>
                        <div class="form-field">
                            <input required type="text" id="modele" name="modele" class="form-control" />
                            <label for="modele" class="">Modele</label>
                        </div>
                        <div class="form-field">
                            <input required id="immat" name="immat" class="form-control" />
                            <label for="immat" class="">Immat</label>
                        </div>
                    </div>
                    <div class="txt-center">
                        <button type="submit" class="btn rounded-1 orange dark-1 rounded-2 txt-white mt-3 mb-3">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection