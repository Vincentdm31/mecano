@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>

<div class="container h100 d-flex">
    <div class="vself-center container card overflow-visible light-shadow-2 rounded-3 grey light-4">
        <div class="card-content p-0">
            @if(!isset($intervention->needMove))
            <p class="m-0 txt-gl4 p-3 font-s2 bg-blue3 mb-5 rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">Déplacement ?</p>
            <div class="grix xs2 mb-4 p-3">
                <form action="{{ route('needMove')}}" method="POST">
                    @csrf
                    <input hidden name="id" value="{{ $intervention->id }}"></input>
                    <input hidden name="needMove" value="1"></input>
                    <button type="submit" class="btn orange dark-1 txt-white small rounded-1 w100"><i class="fas fa-check"></i></button>
                </form>
                <form action="{{ route('needMove')}}" method="POST">
                    @csrf
                    <input hidden name="id" value="{{ $intervention->id }}"></input>
                    <input hidden name="needMove" value="0"></input>
                    <button type="submit" class="btn bg-blue3 txt-white small rounded-1 w100"><i class="fas fa-times"></i></button>
                </form>
            </div>
            @endif
            @if(isset($intervention->needMove) && $intervention->needMove == 1)
            @if(empty($intervention->start_move_begin))
            <div class="d-flex fx-col">
                <div>
                    <p class="txt-gl4 p-3 font-s2 bg-blue3 mb-5 rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">Déplacement ALLER</p>
                    <div>
                        <form method="POST" action="{{ route('setDeplacement')}}">
                            @method('PUT')
                            @csrf
                            <div class="txt-center">
                                <input hidden value="{{ $date }}" name="start_move_begin" />
                                <input hidden name="id" value="{{ $intervention->id }}"></input>
                                <button type="submit" class="btn txt-grey txt-light-4 shadow-1 rounded-1 orange dark-1 small">Début</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-4" alt="">
            @endif

            <!--End Déplacement Interventions Aller -->
            @if(!empty($intervention->start_move_begin) && empty($intervention->end_move_begin))
            <div class="d-flex fx-col">
                <div>
                    <p class="txt-gl4 p-3 font-s2 bg-blue3 mb-5 rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">Déplacement ALLER</p>
                </div>
                <form method="POST" action="{{ route('setDeplacement')}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="end_move_begin" />
                        <input hidden name="id" value="{{ $intervention->id }}"></input>
                        <button type="submit" class="btn txt-gl4 shadow-1 rounded-1 orange dark-1 small">Fin</button>
                    </div>
                </form>
            </div>
            <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-4" alt="">
            @endif
            @endif
        </div>
    </div>
</div>
@endsection