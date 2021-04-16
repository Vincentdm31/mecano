@extends('layouts.app')

@section('content')
<div class="container d-flex fx-center h100">
    <div class="card vself-center rounded-2 shadow-1 dark p-3">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="pb-2 txt-grey txt-light-4">Edition opération</p>
        </div>
        <div class="card-content p-0 pl-3 pr-3">
            <form class="form-material" method="POST" action="{{route('operationsList.update', ['operationsList' => $operationList->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control txt-white" value="{{$operationList->name}}" />
                        <label for="name">Nom</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn rounded-1 orange dark-1 txt-white mt-3 mb-3">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection