@extends('layouts.app')
@section('content')
<p class=" txt-center h5 mt-5 mb-4">Liste des interventions<br>en pause</p>
<div class="container">
    @if(!count($interventions))
    <p class="txt-center font-w600">Aucune intervention en pause</p>
    @else
    @foreach($interventions as $intervention)
    <div class="card overflow-visible dark rounded-2 m-2">
        <div class="grix xs2 p-3">
            <div>
                <p class="txt-orange m-0">Intervention n°</p>
                <p class="txt-grey txt-light-4 m-0">{{ $intervention->id }}</p>
            </div>
            <div>
                <p class="txt-orange m-0">Immatriculation</p>
                <p class="txt-grey txt-light-4 m-0">{{ $intervention->vehiculeList->license_plate }}</p>
            </div>
            <div>
                <p class="txt-orange m-0">Créée par</p>
                <p class="txt-grey txt-light-4 m-0">{{ $intervention->created_by }}</p>
            </div>
            <div>
                <p class="txt-orange m-0">Créée le</p>
                <p class="txt-grey txt-light-4 m-0">{{ $intervention->created_at }}</p>
            </div>
            <a class="btn circle small orange dark-1 txt-white" style="position:absolute;top:0;right:0;transform:translate(50%,-50%)" href="{{route('goToIntervention', ['intervention' => $intervention->id])}}"><i class="fas fa-pen"></i></a>
        </div>
    </div>
    @endforeach
    @endif
    <div class="d-flex fx-center mt-3">{{ $interventions->links('pagination') }}</div>

</div>
@endsection