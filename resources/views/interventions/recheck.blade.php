@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <p class="txt-airforce txt-dark-4 txt-center font-s3 mt-5">Liste des Interventions à checker</p>
    <div class="container rounded-2 mt-5">
    @if(!count($interventions))
    <p class="txt-center font-s2">Aucune intervention à checker</p>
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
            <a class="btn circle small orange dark-1 txt-white" style="position:absolute;top:0;right:0;transform:translate(50%,-50%)" href="{{route('resumeCorrectIntervention', ['id' => $intervention->id])}}"><i class="fas fa-pen"></i></a>
        </div>
    </div>
    @endforeach
    @endif
    </div>
    <div class="d-flex fx-center mt-3">{{ $interventions->links('pagination') }}</div>

</div>
@endsection