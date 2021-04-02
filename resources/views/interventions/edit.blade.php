@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/qrcode.css') }}" rel="stylesheet">
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>

<div class="container mt-5">
    <div class="container d-flex vcenter">
        <button data-target="modal-recap" class="mx-auto btn rounded-1 txt-white shadow-1 orange dark-1 modal-trigger small">
            Récapitulatif
        </button>
        @if(Auth()->user()->name != $intervention->created_by)
        <a href="{{route('leaveIntervention', ['intervention' => $intervention->id])}}" class="btn rounded-1 txt-white shadow-1 red dark-1 mx-auto">
            Quitter
        </a>
        @endif
    </div>
</div>
<!-- Actions -->
<div class="container mt-5 mb-5">
    <div class="tab rounded-3 full-width grey light-4 shadow-1 container" id="example-tab" data-ax="tab">
        <ul class="tab-menu light-shadow-1 rounded-tl2 rounded-tr2 txt-black">
            <li class="tab-link">
                <a href="#tab-operation">Opérations</a>
            </li>
            <li class="tab-link">
                <a href="#tab-gestion">Gestion</a>
            </li>
        </ul>
        <!-- Tab Déplacement -->
        <div id="tab-deplacement" class="p-3 container">
            <!--Start Déplacement Interventions Retour -->
            @if(!empty($intervention->end_deplacement_aller) && empty($intervention->start_deplacement_retour))
            <p class="txt-airforce txt-dark-4 txt-center">Déplacements Retour</p>
            <div class="">
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="start_deplacement_retour" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Début</span></button>
                    </div>
                </form>
            </div>
            @endif
            <!--End Déplacement Interventions Retour -->
            @if(!empty($intervention->start_deplacement_retour) && empty($intervention->end_deplacement_retour))
            <p class="txt-airforce txt-dark-4 txt-center">Déplacements Retour</p>
            <div class="">
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="end_deplacement_retour" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                    </div>
                </form>
            </div>
            @endif

        </div>
        <!-- Tab opération -->
        <div id="tab-operation" class="p-3 container">
            <div class="d-flex">
                @if( $opDoing->count() < 1 && $opPause->count() < 1 && $opEnd->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
                            @elseif($opDoing->count() > 0)
                            <button data-target="modal-new-operation" class="disabled btn-tab-operation modal-trigger">Nouvelle opération</button>
                            @elseif($opDoing->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
                                @endif
            </div>
            <div>
                @if(!$intervention->operations()->exists())
                <p class="txt-orange pl-3 txt-center">Aucune opération</p>
                @else
                <div class="grix xs1">
                    @foreach( $intervention->operations as $operation)
                    @if($operation->state != 'finish')
                    <div class="my-auto pl-5 txt-airforce txt-dark-4 pb-2">
                        <li class="mb-2 mt-3">
                            {{ $operation->operationList->name}}
                        </li>
                        @if(!$operation->pieces()->exists())
                        <em class=" mb-5 pb-5 txt-orange txt-dark-1">Aucune pièce affectée</em>
                        @endif
                        @foreach($operation->pieces as $piece)
                        <div class="grix xs2">
                            <em class="my-auto"><b> {{$piece->pieceList->name }}</b><span class="ml-3">x{{$piece->qte}}</span></em>
                            <form method="POST" action="{{ route('pieces.destroy',  ['piece' => $piece->id])}}">
                                @method('delete')
                                @csrf
                                <div class="txt-center">
                                    <input hidden value="{{ $intervention->id }}" name="interventionId" />
                                    <button type="submit" class="btn light-shadow-1 rounded-1 small txt-red"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    <div class="grix xs2 md5 gutter-xs1 grey light-3 p-2 rounded-2">

                        <div class="my-auto mx-auto">
                            <button data-target="add-piece-operation-{{ $operation->id }}" class="btn rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                <i class="fas fa-tools txt-amaranth txt-dark-3"></i>
                            </button>
                        </div>
                        <div class="my-auto mx-auto">
                            <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                <i class="fas fa-comment-medical <?php echo (isset($operation->op_comment) ? 'txt-orange' : '') ?>"></i>
                            </button>
                        </div>

                        <div class="my-auto mx-auto">
                            <!--  -->
                            @if($operation->state == 'doing')
                            <div>
                                <form class="form-material" method="POST" action="{{ route('timeoperations.store') }}">
                                    @csrf
                                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                                    <input hidden name="operation_id" value="{{ $operation->id }}">
                                    <input hidden name="start_date" value="{{ $date }}">
                                    <div class="txt-center">
                                        <button type="submit" class="btn rounded-1 white light-shadow-3 txt-blue mx-auto">
                                            <i class="fas fa-pause txt-orange txt-dark-1"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @elseif($operation->state == 'pause')
                            <div>
                                <form class="form-material my-auto" method="POST" action="{{ route('timeoperations.store') }}">
                                    @csrf
                                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                                    <input hidden name="operation_id" value="{{ $operation->id }}">
                                    <input hidden name="end_date" value="{{ $date }}">
                                    <div class="txt-center">
                                        <button type="submit" class="btn rounded-1 white light-shadow-3 txt-blue mx-auto">
                                            <i class="fas fa-play txt-green txt-dark-3"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                        <div class="mx-auto my-auto">
                            <form class="form-material" method="POST" action="{{ route('operations.destroy', ['operation' => $operation->id]) }}">
                                @method('DELETE')
                                @csrf
                                <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                <div class="mx-auto">
                                    <button type="submit" class="btn white light-shadow-3 rounded-1 txt-white"><i class="fas fa-trash txt-red"></i></span></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs2 col-md1 w100 pl-4 pr-4">
                            <form method="POST" action="{{ route('operations.update',  ['operation' => $operation->id])}}">
                                @method('PUT')
                                @csrf
                                <div class="txt-center">
                                    <input hidden value="finish" name="state" />
                                    <input hidden value="{{ $intervention->id }}" name="intervention_id" />
                                    <input hidden value="{{ $date }}" name="end_operation_time" />
                                    <button type="submit" class="btn shadow-1 rounded-1 w100 white light-shadow-3 mx-auto">
                                        <i class="fas fa-check txt-green txt-dark-2 "></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
            <img src="{{ asset('/images/car.svg') }}" class="responsive-media p-3" alt="">
        </div>
        <!-- Tab gestion -->
        <div id="tab-gestion" class="p-3">
            <div class="grix xs1 md2">
                <div>
                    @if($intervention->state == "doing")
                    <div class="mb-2">
                        <form class="form-material" method="POST" action="{{ route('timeinterventions.store') }}">
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}">
                            <input hidden name="start_date" value="{{ $date }}">
                            <div class="txt-center">
                                <button type="submit" class="btn txt-center rounded-1 outline opening txt-orange small"><span class="outline-text outline-invert">Pause</span></button>
                            </div>
                        </form>
                    </div>
                    @elseif(($intervention->state == "pause"))
                    <div class="mb-2">
                        <form class="form-material my-auto" method="POST" action="{{ route('timeinterventions.store') }}">
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}">
                            <input hidden name="end_date" value="{{ $date }}">
                            <div class="txt-center mb-2">
                                <button type="submit" class="btn rounded-1 outline opening txt-orange small"><span class="outline-text outline-invert">Reprendre</span></button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @if($intervention->needMove && empty($intervention->end_deplacement_retour))
                    <div class="d-flex">
                        <button data-target="modal-end-deplacement" class="mx-auto my-auto btn rounded-1 txt-white shadow-1 orange dark-1 modal-trigger small">
                            Déplacement retour
                        </button>
                    </div>
                    @endif
                    <div class="mt-2">
                        <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="txt-center">
                                <input hidden value="finish" name="state" />
                                @if($opDoing->count() < 1 && $opPause->count() < 1 && !$intervention->needMove || $opDoing->count() < 1 && $opPause->count() < 1 && $intervention->needMove && !empty($intervention->end_deplacement_retour))
                                                <button type="submit" class="btn shadow-1 rounded-1 red small">Terminer l'intervention</button>
                                                @else
                                                <button type="submit" class="btn disabled shadow-1 rounded-1 red small">Terminer l'intervention</button>
                                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <img src="{{ asset('/images/pause.svg') }}" class="responsive-media p-5" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Modal Recap -->
<div class="modal white rounded-2" id="modal-recap" data-ax="modal">
    <div class="m-2 txt-center">
        @if(!empty($intervention->observations))
        <a data-target="modal-comment" class="btn-modal-comment modal-trigger">Observations<span class="fas fa-comment-dots pl-2 font-s3"></span></a>
        @else
        <a data-target="modal-comment" class="btn-modal-comment modal-trigger">Observations<span class="fas fa-comment pl-2 font-s3"></span></a>
        @endif
    </div>
    <div class="card grey light-4 light-shadow-2 rounded-tl0 rounded-bl2 rounded-tr0 rounded-br4 m-2 mb-5">
        <div class="card-header p-1 airforce dark-4 rounded-br4">
            <p class="txt-grey txt-light-4 m-1 font-s3"><i class="fas fa-car font-s4 txt-grey txt-light-4 mr-3 ml-2"></i>Véhicule</p>
        </div>
        <div class="card-content p-2">
            <div class="grix xs2">
                <div>
                    <em class="font-s1 txt-orange txt-dark-1">Marque</em>
                    <p class="m-0">{{ $intervention->vehiculeList->mark }}</p>
                </div>
                <div>
                    <em class="font-s1 txt-orange txt-dark-1">Modèle</em>
                    <p class="m-0">{{ $intervention->vehiculeList->model }}</p>
                </div>
                <div>
                    <em class="font-s1 txt-orange txt-dark-1">Immatriculation</em>
                    <p class="m-0">{{ $intervention->vehiculeList->license_plate }}</p>
                </div>
                <div>
                    @if(empty($intervention->km_vehicule))
                    <button data-target="modal-km" class="btn orange dark-1 shadow-1 txt-white m-0 p-2 font-s2 rounded-2 modal-trigger">Saisir km</button>
                    @else
                    <em class="font-s1 txt-orange txt-dark-1">Kilométrage</em>
                    <p class="m-0">{{ $intervention->km_vehicule }} Km</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card grey light-4 rounded-tl0 light-shadow-2 rounded-bl2 rounded-tr0 rounded-br2 m-2 mb-5">
        <div class="card-header airforce dark-4 rounded-br4 p-1">
            <p class="txt-grey txt-light-4 m-1 font-s3"><i class="fas fa-tools font-s4 txt-grey txt-light-4 mr-3 ml-2"></i>Mes opérations</p>
        </div>
        <div class="card-content p-2">
            @foreach( $intervention->operations as $operation)
            @if($operation->state == 'finish')
            <div class="shadow-1 mb-2 rounded-1">
                <div class="grix xs3 p-2">
                    <div class="col-xs2 my-auto txt-center">
                        {{ $operation->operationList->name}}
                    </div>
                    <div class="d-flex vself-bottom mx-auto">
                        <form method="POST" class="" action="{{ route('editOperation',  ['id' => $operation->id])}}">
                            @method('PUT')
                            @csrf
                            <input hidden value="{{ $intervention->id }}" name="interventionId" />
                            <input hidden value="doing" name="state" />
                            <button type="submit" class="btn light-shadow-1 rounded-1 small orange txt-white"><i class="fas fa-edit"></i></button>
                        </form>
                    </div>
                </div>
                @foreach($operation->pieces as $piece)
                <div class="pb-2 p-3">
                    <em class=""><b>{{ $piece->pieceList->name }}</b><span class="ml-3">x{{ $piece->qte }}</span></em>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<!-- End Modal Recap -->

@foreach( $intervention->operations as $operation)
<div class="modal white shadow-1 p-4 rounded-2" id="edit-operation-{{ $operation->id }}" data-ax="modal">
    <form class="form-material" method="POST" action="{{ route('operations.update', ['operation' => $operation->id]) }}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <input name="intervention_id" hidden value="{{ $intervention->id }}"></input>
            <div class="form-field">
                <textarea type="text" id="op_comment" name="op_comment" class="form-control txt-airforce txt-dark-4">{{ $operation->op_comment}}</textarea>
                <label for="op_comment" class="">Observations</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>

<!-- Modal pièces -->
<div class="modal white shadow-1 p-4 rounded-2" id="add-piece-operation-{{ $operation->id }}" data-ax="modal">
    <div class="d-flex my-auto mx-auto w100 ">
        <form class="form-material w100" method="POST" action="{{ route('pieces.store') }}">
            @csrf
            <div class="txt-center">
                <a id="btn-scan-qr" class="btn rounded-1 shadow-1 orange dark-1 txt-white">SCAN</a>
                <a id="btn-stop-qr" class="btn rounded-1 shadow-1 orange dark-1 txt-white hide">STOP</a>
            </div>
            <canvas hidden="" id="qr-canvas"></canvas>
            <div id="qr-result" hidden="">
                <b>Data:</b> <span id="outputData"></span>
            </div>

            <div class="form-field">
                <input required type="text" id="qr-code-result" name="pieceref" class="form-control txt-airforce txt-dark-4"></input>
                <label for="pieceref">Pièce</label>
            </div>
            <div class="form-field">
                <input required type="number" name="qte" class="form-control txt-airforce txt-dark-4"></input>
                <label for="qte">Quantité</label>
            </div>
            <input hidden name="interventionId" value="{{ $intervention->id }}">
            <input hidden name="operationId" value="{{ $operation->id }}">
            <div class="txt-center">
                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal comment global -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-comment" data-ax="modal">
    <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <div class="form-field">
                <textarea type="text" name="observations" class="form-control txt-center grey txt-airforce txt-dark-4">{{ $intervention->observations }}</textarea>
                <label for="observations" class="">Observations</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-2 mb-2"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>

<!-- Modal Opération -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-new-operation" data-ax="modal">
    <div class="grix xs1 md2">
        <div class="d-flex vcenter">
            <form class="form-material container" method="POST" action="{{ route('operations.store')}}">
                @csrf
                <div class="form-field">
                    <label for="operation">Opération</label>
                    <select class="form-control rounded-1 txt-airforce txt-dark-4" name="operation_id">
                        @foreach ( $operationsList as $operationList)
                        <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $operationList->id }}">{{ $operationList->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <div class="txt-center">
                    <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
                </div>
            </form>
        </div>
        <img src="{{ asset('/images/operation.png') }}" class="responsive-media p-3" alt="">
    </div>
</div>

<!-- Modal fin déplacement -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-end-deplacement" data-ax="modal">
    <div class="grix xs1 md2">
        @if(empty($intervention->start_deplacement_retour))
        <div class="d-flex my-auto fx-col">
            <div>
                <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements Retour</p>
                <div>
                    <form method="POST" action="{{ route('setEndDeplacement')}}">
                        @method('PUT')
                        @csrf
                        <div class="txt-center">
                            <input hidden value="{{ $date }}" name="start_deplacement_retour" />
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
        @if(!empty($intervention->start_deplacement_retour) && empty($intervention->end_deplacement_retour))
        <div class="d-flex my-auto fx-col">
            <div>
                <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements Retour</p>
            </div>
            <form method="POST" action="{{ route('setEndDeplacement')}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden value="{{ $date }}" name="end_deplacement_retour" />
                    <input hidden name="id" value="{{ $intervention->id }}"></input>
                    <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                </div>
            </form>
        </div>
        <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-3" alt="">
        @endif
    </div>
</div>

<!-- Modal comment global -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-km" data-ax="modal">
    <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <div class="form-field">
                <input type="number" name="km_vehicule" class="form-control txt-center grey txt-airforce txt-dark-4">{{ $intervention->km_vehicule }}</textarea>
                <label for="km_vehicule" class="">Kilométrage</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-2 mb-2"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>


@endsection

@section('extra-js')

<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script type="text/javascript" src="{{ mix('js/qrCodeScanner.js') }}"></script>

<script>
    let toast = new Axentix.Toast();
</script>

@if(session('toast') == 'notEnoughQte')
<script>
    toast.change('Pas assez de pièces <?php echo ('<br/> Stock dispo : ' . request()->pieceQte) ?>', {
        classes: "rounded-1 red dark-2 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@elseif(session('toast') == 'pieceStore')
<script>
    toast.change('Pièce ajoutée', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removepiece')
<script>
    toast.change('Pièce supprimée', {
        classes: "rounded-1 red dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'comment')
<script>
    toast.change('Commentaire ajouté', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'addOperation')
<script>
    toast.change('Opération ajoutée', {
        classes: "rounded-1 green  dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'editOperation')
<script>
    toast.change('Opération modifiée', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'update')
<script>
    toast.change('Intervention mise à jour', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('error') == 'restrictAccess')
<script>
    toast.change('Vous n\'avez pas accès à cette page', {
        classes: "rounded-1 red dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@endif
@endsection