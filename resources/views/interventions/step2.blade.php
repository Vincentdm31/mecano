@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>

<div class="container h100">
    <div class="container h100 d-flex">
        <div class="vself-center container card overflow-visible shadow-1 rounded-2 grey light-4">
            <div class="card-header p-1 bd-b-solid bd-orange bd-dark-1 bd-2 m-0 ml-4 mr-4">
                <p class="txt-airforce txt-dark-4 h6">Déplacement ?</p>
            </div>
            <div class="card-content">
                @if(!isset($intervention->needMove))
                <div class="grix xs2" id="select-move">
                    <form action="{{ route('needMove')}}" method="POST">
                        @csrf
                        <input hidden name="id" value="{{ $intervention->id }}"></input>
                        <input hidden name="needMove" value="1"></input>
                        <button type="submit" class="btn green dark-1 txt-white small rounded-1 w100">Oui</button>
                    </form>
                    <form action="{{ route('needMove')}}" method="POST">
                        @csrf
                        <input hidden name="id" value="{{ $intervention->id }}"></input>
                        <input hidden name="needMove" value="0"></input>
                        <button type="submit" class="btn red dark-1 txt-white small rounded-1 w100">Non</button>
                    </form>
                </div>
                @endif
                @if(isset($intervention->needMove) && $intervention->needMove == 1)
                <div class="grix xs1 md2">
                    @if(empty($intervention->start_deplacement_aller))
                    <div class="d-flex my-auto fx-col">
                        <div>
                            <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements ALLER</p>
                            <div>
                                <form method="POST" action="{{ route('setDeplacement')}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="txt-center">
                                        <input hidden value="{{ $date }}" name="start_deplacement_aller" />
                                        <input hidden name="id" value="{{ $intervention->id }}"></input>
                                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange small"><span class="outline-text outline-invert">Début</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-3" alt="">
                    @endif

                    <!--End Déplacement Interventions Aller -->
                    @if(!empty($intervention->start_deplacement_aller) && empty($intervention->end_deplacement_aller))
                    <div class="d-flex my-auto fx-col">
                        <div>
                            <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements Aller</p>
                        </div>
                        <form method="POST" action="{{ route('setDeplacement')}}">
                            @method('PUT')
                            @csrf
                            <div class="txt-center">
                                <input hidden value="{{ $date }}" name="end_deplacement_aller" />
                                <input hidden name="id" value="{{ $intervention->id }}"></input>
                                <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                            </div>
                        </form>
                    </div>
                    <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-3" alt="">
                    @endif

                </div>

                @endif
                @if(isset($intervention->needMove) && $intervention->needMove == 0)
                <div class="card-footer m-0 p-0">
                    <p class="mb-2">L'intervention nécessite aucun déplacement.</p>
                    <form action="{{ route('interventions.edit', ['intervention' => $intervention->id]) }}">
                        @csrf
                        <input hidden name="id" value="{{ $intervention->id }}" /></input>
                        <div class="d-flex fx-center">
                            <button type="submit" class="btn shadow-1 airforce dark-3 ml-auto txt-white rounded-1 hide-md-down mb-2 mr-2 small">Suivant</button>
                            <button type="submit" class="btn shadow-1 red dark-3 txt-white rounded-1 hide-md-up mb-2 mr-2 small">Suivant</button>
                        </div>
                    </form>
                </div>
                @endif

                @if($intervention->needMove ==1 && !empty($intervention->end_deplacement_aller))
                <p class="txt-center">Déplacements enregistrés</p>
            </div>
            <div class="card-footer m-0 p-0">
                <div class="">
                    <form action="{{ route('interventions.edit', ['intervention' => $intervention->id]) }}">
                        @csrf
                        <input hidden name="id" value="{{ $intervention->id }}" /></input>
                        <div class="d-flex fx-center">
                            <button type="submit" class="btn shadow-1 airforce dark-3 ml-auto txt-white rounded-1 hide-md-down mb-2 mr-2 small">Suivant</button>
                            <button type="submit" class="btn shadow-1 red dark-3 txt-white rounded-1 hide-md-up mb-2 mr-2 small">Suivant</button>
                        </div>
                    </form>
                </div>

            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection

@section('extra-js')
<script>
    let btn_yes = document.getElementById('btn-yes');
    let select_move = document.getElementById('select-move');

    btn_yes.onclick = function() {
        select_move.classList.add('hide');
    }
</script>
@endsection