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

<div class="container">
    <div class="txt-center mt-5 mb-5">
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
<div class="container mb-5">
    <div class="tab rounded-3 full-width grey light-4 light-shadow-1 container" id="example-tab" data-ax="tab">
        <ul class="tab-menu light-shadow-1 rounded-tl2 rounded-tr2 txt-black">
            <li class="tab-link">
                <a href="#tab-operation">Opérations</a>
            </li>
            <li class="tab-link">
                <a href="#tab-gestion">Intervention</a>
            </li>
        </ul>
        <!-- Tab Déplacement -->
        <div id="tab-deplacement" class="p-3 container">
            <!--Start Déplacement Interventions Retour -->
            @if(!empty($intervention->end_move_begin) && empty($intervention->start_move_return))
            <p class="txt-airforce txt-dark-4 txt-center">Déplacements Retour</p>
            <div class="">
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="start_move_return" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Début</span></button>
                    </div>
                </form>
            </div>
            @endif
            <!--End Déplacement Interventions Retour -->
            @if(!empty($intervention->start_move_return) && empty($intervention->end_move_return))
            <p class="txt-airforce txt-dark-4 txt-center">Déplacements Retour</p>
            <div class="">
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="end_move_return" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                    </div>
                </form>
            </div>
            @endif

        </div>
        <!-- Tab opération -->
        <div id="tab-operation" class="p-1 container">

            @if($opDoing->count() < 1) <p class="txt-orange pl-3 txt-center">Aucune opération en cours</p>
                @else
                @foreach( $intervention->operations as $operation)
                @if($operation->state != 'finish')
                <div class="card light-shadow-1 dark rounded-2">
                    <div class="card-header p-2">
                        <p class="m-0 font-s3 txt-grey txt-light-4 txt-center">{{ $operation->operationList->name}}</p>
                        @foreach($operation->pieces as $piece)
                        <div class="grix xs3 p-1 mt-2">
                            <p class="my-auto m-0 font-s2 col-xs2 txt-grey txt-light-4"><span class="mr-3 txt-grey txt-light-3">{{$piece->qte}}x</span>{{$piece->pieceList->name }}</p>
                            <form method="POST" action="{{ route('pieces.destroy',  ['piece' => $piece->id])}}">
                                @method('delete')
                                @csrf
                                <div class="txt-center">
                                    <input hidden value="{{ $intervention->id }}" name="interventionId" />
                                    <button type="submit" class="btn rounded-1 small txt-red"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-content grey light-3 p-2">
                        <div class="grix xs2 md5">
                            <div>
                                <button data-target="add-piece-operation-{{ $operation->id }}" class="btn w100 rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                    <i class="fas fa-tools txt-amaranth txt-dark-3"></i>
                                </button>
                            </div>
                            <div>
                                <button data-target="edit-operation-{{ $operation->id }}" class="btn w100 rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                    <i class="fas fa-comment-medical <?php echo (isset($operation->op_comment) ? 'txt-orange' : '') ?>"></i>
                                </button>
                            </div>

                            <div>
                                <!--  -->
                                @if($operation->state == 'doing')
                                <div>
                                    <form class="form-material" method="POST" action="{{ route('timeoperations.store') }}">
                                        @csrf
                                        <input hidden name="intervention_id" value="{{ $intervention->id }}">
                                        <input hidden name="operation_id" value="{{ $operation->id }}">
                                        <input hidden name="start_date" value="{{ $date }}">
                                        <div class="txt-center">
                                            <button type="submit" class="btn w100 rounded-1 white light-shadow-3 txt-blue mx-auto">
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
                            <div>
                                <form class="form-material" method="POST" action="{{ route('operations.destroy', ['operation' => $operation->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                    <div class="mx-auto">
                                        <button type="submit" class="btn w100 white light-shadow-3 rounded-1 txt-white"><i class="fas fa-trash txt-red"></i></span></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs2 col-md1 w100 pl-4 pr-4">
                                <form method="POST" action="{{ route('finishOperation', ['operationId' => $operation->id, 'interventionId' => $intervention->id, 'state' => 'finish', 'endOperationTime' => $date])}}">
                                    @method('PUT')
                                    @csrf
                                    <div class="txt-center">
                                        <button type="submit" class="btn shadow-1 rounded-1 w100 white light-shadow-3 mx-auto">
                                            <i class="fas fa-check txt-green txt-dark-2 "></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endif
        </div>
        <!-- Tab gestion -->
        <div id="tab-gestion" class="p-3">
            <div class="grix xs2">
                <div>
                    @if($intervention->state == "doing")
                    <form class="form-material h100" method="POST" action="{{ route('timeinterventions.store') }}">
                        @csrf
                        <input hidden name="intervention_id" value="{{ $intervention->id }}">
                        <input hidden name="start_date" value="{{ $date }}">
                        <button type="submit" class="btn w100 h100 txt-center rounded-1 dark txt-orange  small"><i class="fas fa-pause font-s4"></i></button>
                    </form>

                    @elseif(($intervention->state == "pause"))
                    <form class="form-material h100" method="POST" action="{{ route('timeinterventions.store') }}">
                        @csrf
                        <input hidden name="intervention_id" value="{{ $intervention->id }}">
                        <input hidden name="end_date" value="{{ $date }}">
                        <button type="submit" class="btn w100 h100 rounded-1 dark txt-green txt-light-1 small"><i class="fas fa-play font-s4"></i></button>
                    </form>

                    @endif
                    @if($intervention->needMove && empty($intervention->end_move_return))
                    <div class="d-flex">
                        <button data-target="modal-end-deplacement" class="mx-auto my-auto btn rounded-1 txt-white shadow-1 orange dark-1 modal-trigger small">
                            Déplacement retour
                        </button>
                    </div>
                    @endif
                </div>
                <div class="">
                    <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="txt-center">
                            <input hidden value="finish" name="state" />
                            @if($opDoing->count() < 1 && $opPause->count() < 1 && !$intervention->needMove || $opDoing->count() < 1 && $opPause->count() < 1 && $intervention->needMove && !empty($intervention->end_move_return))
                                            <button type="submit" class="btn shadow-1 rounded-1 dark txt-white small">Terminer l'intervention</button>
                                            @else
                                            <button type="submit" class="btn disabled shadow-1 rounded-1 small">Terminer l'intervention</button>
                                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="txt-center mt-5">
        @if( $opDoing->count() < 1 && $opPause->count() < 1 && $opEnd->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
                    @elseif($opDoing->count() > 0)
                    <button data-target="modal-new-operation" class="disabled btn-tab-operation modal-trigger">Nouvelle opération</button>
                    @elseif($opDoing->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
                        @endif
    </div>



</div>

<div class="fab fab-checker" id="fab" data-ax="fab">

    <!-- Here is the fab-trigger -->
    <button id="fab-btn" class="fab-checker btn shadow-1 circle large dark txt-white fab-trigger">
        <i class="fas fa-plus fab-checker" aria-hidden="true"></i>
    </button>

    <!-- Here is the fab-menu -->
    <div class="fab-menu">
        <a data-target="modal-help" class="btn shadow-1 circle orange dark-1 txt-white fab-item mb-3 modal-trigger">
            <i class="far fa-lightbulb" aria-hidden="true"></i>
        </a>
        <a data-target="modal-comment" class="btn shadow-1 circle orange dark-1 txt-white fab-item mb-3 modal-trigger">
            <i class="<?php echo (!empty($intervention->observations) ? 'fas fa-comment-dots' : 'fas fa-comment') ?>" aria-hidden="true"></i>
        </a>
    </div>
</div>

<!-- Overlay FAB -->
<div id="fab-overlay" class="fab-overlay"></div>

<!-- Modal Recap -->
<div class="modal grey light-4 rounded-2" id="modal-recap" data-ax="modal">
    <div class="card dark shadow-2 mt-0 mb-0">
        <div class="card-header txt-white p-0">
            <p class=" m-2 font-s4"><i class="fas fa-car font-s6 mr-3 ml-2 mb-2"></i>Véhicule</p>
        </div>
        <div class="card-content p-2">
            <div class="grix xs2">
                <div>
                    <p class="font-s1 m-0 txt-orange txt-dark-1">Marque</p>
                    <p class="txt-white m-0">{{ $intervention->vehiculeList->brand }}</p>
                </div>
                <div>
                    <p class="font-s1 m-0 txt-orange txt-dark-1">Modèle</p>
                    <p class="txt-white m-0">{{ $intervention->vehiculeList->model }}</p>
                </div>
                <div>
                    <p class="font-s1 m-0 txt-orange txt-dark-1">Immatriculation</p>
                    <p class="txt-white m-0">{{ $intervention->vehiculeList->license_plate }}</p>
                </div>
                <div class="my-auto">
                    @if(empty($intervention->km_vehicule))
                    <button data-target="modal-km" class="btn orange dark-1 txt-white font-s2 rounded-2 modal-trigger small">Saisir km</button>
                    @else
                    <p class="font-s1 m-0 txt-orange txt-dark-1">Kilométrage</p>
                    <p class="txt-white m-0">{{ $intervention->km_vehicule }} Km</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <p class="txt-dark pl-2 m-0 p-4 font-s4"><i class="fas fa-tools font-s6 txt-dark mr-3 ml-2"></i>Mes opérations</p>

    @foreach( $intervention->operations as $operation)
    @if($operation->state == 'finish')
    <div class="card grey light-4 overflow-visible shadow-1 m-4 rounded-2">
        <div class="card-header dark p-1">
            <p class="m-0 font-s3 txt-center txt-white p-2">{{ $operation->operationList->name}}</p>
            <form method="POST" class="" action="{{ route('editOperation',  ['id' => $operation->id, 'interventionId' => $intervention->id ] ) }}">
                @method('PUT')
                @csrf

                <button type="submit" class="btn circle bd-solid bd-3 bd-white rounded-1 small dark txt-white" style="position:absolute;top:0;right:0;transform:translate(50%,-50%)"><i class="fas fa-pen"></i></button>
            </form>
        </div>
        @foreach($operation->pieces as $piece)
        <p class="pl-3 m-0 mb-1 pt-1 txt-airforce txt-dark-4"><span class="mr-3 txt-grey txt-dark-4">{{ $piece->qte }}x</span>{{ $piece->pieceList->name }}</p>
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
        @if(empty($intervention->start_move_return))
        <div class="d-flex my-auto fx-col">
            <div>
                <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements Retour</p>
                <div>
                    <form method="POST" action="{{ route('setEndDeplacement')}}">
                        @method('PUT')
                        @csrf
                        <div class="txt-center">
                            <input hidden value="{{ $date }}" name="start_move_return" />
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
        @if(!empty($intervention->start_move_return) && empty($intervention->end_move_return))
        <div class="d-flex my-auto fx-col">
            <div>
                <p class="txt-airforce txt-dark-4 txt-center mb-2">Déplacements Retour</p>
            </div>
            <form method="POST" action="{{ route('setEndDeplacement')}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden value="{{ $date }}" name="end_move_return" />
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

<!-- Modal HELP -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-help" data-ax="modal">
    <div class="modal-content">
        <p class="w100 font-s4 pb-2 bd-b-solid bd-2 bd-orange bd-dark-1 mb-5">Légende</p>
        <p><i class="fas fa-tools txt-amaranth txt-dark-3 mr-3"></i>Gestion des pièces</p>
        <p><i class="fas fa-comment-medical txt-blue mr-3"></i>Commentaire opération</p>
        <p><i class="fas fa-comment-medical txt-orange mr-3"></i>Opération commentée</p>
        <p><i class="fas fa-pause txt-orange txt-dark-1 mr-3"></i>Mettre l'opération en pause</p>
        <p><i class="fas fa-play txt-green txt-dark-3 mr-2"></i>Reprendre l'opération</p>
        <p><i class="fas fa-trash txt-red txt-dark-1 mr-2"></i>Supprimer l'opération</p>
        <p><i class="fas fa-check txt-green txt-dark-3 mr-2"></i>Terminer l'opération</p>
    </div>
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
<script>
    let fab = document.getElementById('fab');
    let fabOverlay = document.getElementById('fab-overlay');
    let overlay = false;
    let check = false;

    fab.addEventListener('click', function(event) {
        fabOverlay.classList.add('active');
        setTimeout(() => {
            overlay = true;
        }, 200);
    });

    window.onclick = function(e) {
        if (overlay && !e.target.classList.contains('fab-checker')) {
            fabOverlay.classList.remove('active');
            overlay = false;
        }
    }
</script>
@endsection