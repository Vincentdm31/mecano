@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="card rounded-1 shadow-1 pos-sm2">
            <div class="card-content">
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
                        <button type="submit" class="btn rounded-1 orange dark-1 rounded-2 txt-white mt-5">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


