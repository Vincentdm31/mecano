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
        <button data-target="modal-recap" class="mx-auto btn rounded-1 txt-orange txt-dark-1 shadow-1 grey light-4 modal-trigger">
            Récapitulatif
        </button>
        @if(Auth()->user()->name != $intervention->created_by)
        <a href="{{route('leaveIntervention', ['intervention' => $intervention->id])}}" class="btn rounded-1 txt-white shadow-1 red dark-1 mx-auto">
            Quitter
        </a>
        @endif
        <div class="modal white shadow-1 rounded-2 mt-4" id="modal-recap" data-ax="modal">
            <div class="card rounded-2 m-0 overflow-visible">
                <a href="" data-target="modal-comment" style="position:absolute;right:5px;top:0;font-size:2.5rem;" class="txt-white fas fa-comment modal-trigger"></a>
                <div class="card-header rounded-tl2 rounded-tr2 orange dark-1 p-3 recap-infos">
                    <div class="grix txt-white gutter-xs5 xs2 md3">
                        <p class="pl-2 lh-normal mr-auto"><i class="far fa-id-card mr-2 font-s4 txt-white"></i>{{ $intervention->created_by }}</p>
                        <p class="pl-2 lh-normal mr-auto"><i class="fas fa-clipboard-list mr-2 font-s4 txt-white"></i>{{ $intervention->id }}</p>
                        <p class="pl-2 lh-normal mr-auto col-xs2"><i class="fas fa-calendar-alt mr-2 font-s4 txt-white"></i>{{\Carbon\Carbon::parse($intervention->created_at)->isoFormat('LLLL')}}</p>
                    </div>
                    @foreach($intervention->users as $user)
                    <span class="txt-white">{{ $user->name }}</span>
                    @endforeach
                </div>
                <div class="card-content p-3">
                    <div class="grix xs1 md2 gutter-xs5">
                        <div class="p-2 txt-airforce txt-dark-4 rounded-2 light-shadow-2">
                            <p class="bd-b-solid bd-orange bd-2 pb-2 mb-3 pl-2"><i class="fas fa-car font-s4 txt-airforce txt-dark-4 mr-4"></i>Véhicule</p>
                            <div class="grix xs2">
                                <p class="">{{$intervention->vehiculeList->marque}}</p>
                                <p class="">{{$intervention->vehiculeList->modele}}</p>
                                <p class="">{{$intervention->vehiculeList->immat}}</p>
                                @if(empty($intervention->km_vehicule))
                                <p class="txt-orange">Saisir kilométrage</p>
                                @else
                                <p class="">{{$intervention->km_vehicule}} Km</p>
                                @endif
                            </div>
                        </div>
                        <div class="p-2 txt-airforce txt-dark-4 rounded-2 light-shadow-2">
                            <p class="txt-airforce txt-dark-4 bd-b-solid bd-orange bd-2 pb-2 mb-3 pl-2"><i class="fas fa-car-crash font-s4 mr-4 txt-airforce txt-dark-4"></i>Déplacements</p>
                            @if(empty($intervention->start_deplacement_aller))
                            <p class="txt-orange pl-3">Aucun déplacement</p>
                            @else
                            <div class="grix xs1 sm2">
                                <div class="txt-airforce txt-dark-4">
                                    <p class="txt-orange">Aller</p>
                                    <p>{{ Carbon::parse($intervention->start_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                                    @if(!empty($intervention->end_deplacement_aller))
                                    <p>{{ Carbon::parse($intervention->end_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                                    @endif
                                </div>
                                <div class="txt-airforce txt-dark-4">
                                    <p class="txt-orange">Retour</p>
                                    @if(!empty($intervention->start_deplacement_retour))
                                    <p>{{ Carbon::parse($intervention->start_deplacement_retour)->format('d/m/Y h:m:s')  }}</p>
                                    @endif
                                    @if(!empty($intervention->end_deplacement_retour))
                                    <p>{{ Carbon::parse($intervention->end_deplacement_retour)->format('d/m/Y h:m:s')  }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer p-3 white">
                    <div class="p-2 shadow-2 rounded-2">
                        <p class="txt-airforce txt-dark-4 bd-b-solid bd-orange bd-2 pb-2 pl-2"><i class="fas fa-tools font-s4 mr-4 txt-airforce txt-dark-4"></i>Liste des opérations</p>
                        @if(!$intervention->operations()->exists())
                        <p class="txt-orange pl-3">Aucune opération en cours</p>
                        @else
                        <div class="grix xs1 md2">
                            @foreach( $intervention->operations as $operation)
                            <div class="my-auto pl-5 txt-airforce txt-dark-4 pb-2">
                                <li class="mb-2 mt-3">
                                    {{ $operation->operationList->name}}
                                </li>
                                @foreach($operation->pieces as $piece)
                                <em class="ml-5 mb-5 pb-5"><b> {{$piece->pieceList->name }}</b><span class="ml-3">x{{$piece->qte}}</span></em><br>
                                @endforeach
                            </div>

                            @endforeach
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Actions -->
<div class="container mt-5 mb-5">
    <div class="tab rounded-3 full-width white shadow-1 container" id="example-tab" data-ax="tab">
        <ul class="tab-menu light-shadow-1 rounded-tl2 rounded-tr2 txt-black">
            <li class="tab-link">
                <a href="#tab-operation">Mes opérations</a>
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
            <div class="grix xs1 sm2 ">
                <div class="">
                    <p class="h6 txt-center "><b> Mes opérations</b></p>
                </div>
                <div class="d-flex pos-row-xs1 pos-sm2">
                    <button data-target="modal-new-operation" class="mx-auto my-auto btn rounded-1 txt-white shadow-1 orange dark-1 modal-trigger">
                        Nouvelle opération
                    </button>
                </div>
            </div>
            <div>
                @if(!$intervention->operations()->exists())
                <p class="txt-orange pl-3 txt-center">Aucune opération</p>
                @else
                <div class="grix xs1">
                    @foreach( $intervention->operations as $operation)
                    <div class="my-auto pl-5 txt-airforce txt-dark-4 pb-2">
                        <li class="mb-2 mt-3">
                            {{ $operation->operationList->name}}
                        </li>
                        @foreach($operation->pieces as $piece)
                        <em class="ml-5 mb-5 pb-5"><b> {{$piece->pieceList->name }}</b><span class="ml-3">x{{$piece->qte}}</span></em><br>
                        @endforeach
                    </div>
                    <div class="grix xs2 md5 gutter-xs1">
                        <div class="my-auto mx-auto">
                            <!--  -->
                            @if($operation->state)
                            <div>
                                <form class="form-material" method="POST" action="{{ route('timeoperations.store') }}">
                                    @csrf
                                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                                    <input hidden name="operation_id" value="{{ $operation->id }}">
                                    <input hidden name="start_date" value="{{ $date }}">
                                    <div class="txt-center">
                                        <button type="submit" class="btn rounded-1 white light-shadow-3 txt-blue mx-auto">
                                            <i class="fas fa-pause txt-orange txt-dark-3"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @elseif(!$operation->state)
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
                        <div class="mx-auto my-auto">
                            <form class="form-material" method="POST" action="{{ route('operations.destroy', ['operation' => $operation->id]) }}">
                                @method('DELETE')
                                @csrf
                                <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                <div class="mx-auto">
                                    <button type="submit" class="btn light-shadow-3 rounded-1 outline opening txt-white"><span class="outline-text outline-invert"><i class="fas fa-trash txt-red"></i></span></button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <form class="form-material my-auto" method="POST" action="{{ route('totalTimeOp')}}">
                                @csrf
                                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                                <input hidden name="operation_id" value="{{ $operation->id }}">
                                <div class="txt-center">
                                    <button type="submit" class="btn rounded-1 white light-shadow-3 txt-blue mx-auto">
                                        <i class="fas fa-clock txt-green txt-dark-3"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
        <!-- Tab gestion -->
        <div id="tab-gestion" class="p-3">
            <div class="grix xs1 md2">
                <div>
                    @if($intervention->state == "doing")
                    <div>
                        <form class="form-material" method="POST" action="{{ route('timeinterventions.store') }}">
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}">
                            <input hidden name="start_date" value="{{ $date }}">
                            <div class="txt-center">
                                <button type="submit" class="btn txt-center rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Pause</span></button>
                            </div>
                        </form>
                    </div>
                    @elseif(($intervention->state == "pause"))
                    <div>
                        <form class="form-material my-auto" method="POST" action="{{ route('timeinterventions.store') }}">
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}">
                            <input hidden name="end_date" value="{{ $date }}">
                            <div class="txt-center">
                                <button type="submit" class="btn rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Reprendre</span></button>
                            </div>
                        </form>
                    </div>
                    @endif
                    <div>
                        <form class="form-material my-auto" method="POST" action="{{ route('totalTime')}}">
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}">
                            <div class="txt-center">
                                <button type="submit" class="btn rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">test time</span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <img src="{{ asset('/images/pause.svg') }}" class="responsive-media p-3" alt="">
            </div>
        </div>
    </div>
</div>
<!-- MODALS -->

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
        classes: "rounded-1 red dark-1 shadow-2 mt-5"
    });
    toast.show();
</script>
@elseif(session('toast') == 'pieceStore')
<script>
    toast.change('Pièce ajoutée', {
        classes: "rounded-1 green txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removepiece')
<script>
    toast.change('Pièce supprimée', {
        classes: "rounded-1 red dark-1 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'comment')
<script>
    toast.change('Commentaire ajouté', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'addOperation')
<script>
    toast.change('Opération ajoutée', {
        classes: "rounded-1 green txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removeOperation')
<script>
    toast.change('Opération supprimée', {
        classes: "rounded-1 red dark-1 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'update')
<script>
    toast.change('Intervention mise à jour', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@endif
@endsection