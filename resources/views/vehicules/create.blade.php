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
                            <input required type="text" name="brand" class="form-control" />
                            <label for="brand" class="">Marque</label>
                        </div>
                        <div class="form-field">
                            <input required type="text" name="model" class="form-control" />
                            <label for="model" class="">Modele</label>
                        </div>
                        <div class="form-field">
                            <input required id="immat" name="license_plate" class="form-control" />
                            <label for="license_plate" class="">Immat</label>
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