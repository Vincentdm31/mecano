@extends('layouts.app')
@section('content')
<div class="h100 d-flex fx-center">
    <div class="card vself-center rounded-2 shadow-1 dark p-3">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="pb-2 txt-grey txt-light-4">Nouvelle opération</p>
        </div>
        <div class="card-content pl-3 pr-3 p-0">
            <form class="form-material" method="POST" action="{{ route('operationsList.store') }}">
                @csrf
                <div class="grix xs1 txt-center">
                    <div class="form-field">
                        <input required type="text" id="name" name="name" class="form-control txt-white" />
                        <label for="name" class="">Nom</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn rounded-1 orange dark-1 txt-white mt-3 mb-3">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection