@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/qrcode.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();

?>
<div class="container mt-5">
    <div class="container txt-center d-flex vcenter">
        <button data-target="modal-recap" class="mx-auto btn rounded-1 txt-white shadow-1 orange dark-1 modal-trigger">
            Voir le récapitulatif
        </button>
        @if(Auth()->user()->name != $intervention->created_by)
        <a href="{{route('leaveIntervention', ['intervention' => $intervention->id])}}" class="btn rounded-1 txt-white shadow-1 red dark-1 mx-auto">
            Quitter
        </a>
        @endif
        <div class="modal white shadow-1 rounded-2 mt-4" id="modal-recap" data-ax="modal">
            <div class="card rounded-2 m-0 overflow-visible">
                <a href="" data-target="modal-comment" style="position:absolute;right:0;top:0;font-size:2.5rem;" class="<?php echo (empty($intervention->observations) ? 'hide' : 'txt-white') ?> fas fa-comment modal-trigger"></a>
                <div class="card-header rounded-tl2 rounded-tr2 orange dark-1 p-3 recap-infos">
                    <div class="grix txt-white md3">
                        <p class="pl-2 lh-normal">{{\Carbon\Carbon::parse($intervention->created_at)->isoFormat('LLLL')}}</p>
                        <p class="pl-2 lh-normal">Créateur : {{ $intervention->created_by }}</p>
                        <p class="pl-2 lh-normal">Ref Intervention : {{ $intervention->id }}</p>
                    </div>
                    @foreach($intervention->users as $user)
                    <span class="txt-white">{{ $user->name }}</span>
                    @endforeach
                </div>
                <div class="card-content p-3">
                    <div class="grix xs1 md2 gutter-xs5">
                        <div class="p-2 txt-airforce txt-dark-4 rounded-2 light-shadow-2">
                            <p class="bd-b-solid bd-orange bd-2 pb-2 mb-3">Véhicule</p>
                            @if(empty($intervention->vehicule_id))
                            <p class="txt-orange pb-2">Aucun véhicule sélectionné</p>
                            @else
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
                            @endif
                        </div>
                        <div class="p-2 txt-airforce txt-dark-4 rounded-2 light-shadow-2">
                            <p class="txt-airforce txt-dark-4 bd-b-solid bd-orange bd-2 pb-2 mb-3">Déplacements</p>
                            @if(empty($intervention->start_deplacement_aller))
                            <p class="txt-orange pb-2">Aucun déplacement</p>
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
                    <div class="grix xs1 sm2 gutter-xs5">
                        <div class="p-2 light-shadow-2 rounded-2">
                            <p class="txt-airforce txt-dark-4 bd-b-solid bd-orange bd-2 pb-2">Liste des opérations</p>
                            @if(!$intervention->categories()->exists())
                            <p class="txt-orange">Aucune opération en cours</p>
                            @else
                            <div class="grix xs2">
                                @foreach( $intervention->categories as $operation)
                                <div class="my-auto mx-auto txt-airforce txt-dark-4">
                                    <p>{{ $operation->name }}</p>
                                </div>
                                <div class="grix xs2 gutter-xs2">
                                    <div class="my-auto ml-auto">
                                        <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                            <i class="fas fa-comment-medical <?php echo (isset($operation->pivot->observations) ? 'txt-orange' : '') ?>"></i>
                                        </button>

                                    </div>
                                    <div class="mr-auto my-auto">
                                        <form class="form-material" method="POST" action="{{ route('deleteOperation') }}">
                                            @method('PUT')
                                            @csrf
                                            <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                            <input hidden name="categorie_id" value="{{ $operation->id}}" />
                                            <div class="mx-auto">
                                                <button type="submit" class="btn light-shadow-3 rounded-1 outline opening txt-white"><span class="outline-text outline-invert"><i class="fas fa-trash txt-red"></i></span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="p-2 rounded-2 light-shadow-2">
                            <p class="txt-airforce txt-dark-4 bd-b-solid bd-orange bd-2 pb-2">Liste des pièces</p>
                            @if(!$intervention->pieces()->exists())
                            <p class=" txt-orange">Aucune pièce utilisée</p>
                            @else
                            <div class="grix xs2 md4 txt-airforce txt-dark-4">
                                @foreach( $intervention->pieces as $piece)
                                <div class="my-auto mx-auto">
                                    <p>{{ $piece->name }}</p>
                                </div>
                                <div class="my-auto mx-auto">
                                    <p>x{{ $piece->pivot->qte }}</p>
                                </div>
                                <div class="grix xs2 col-xs2 gutter-xs2">
                                    <div class="my-auto ml-auto">
                                        <button data-target="edit-piece-{{ $piece->id }}" class="btn rounded-1 white light-shadow-3 txt-blue modal-trigger mx-auto">
                                            <i class="fas fa-comment-medical <?php echo (isset($piece->pivot->observations) ? 'txt-orange' : '') ?>"></i>
                                        </button>

                                    </div>
                                    <div class="my-auto">
                                        <form class="form-material" method="POST" action="{{ route('deletePiece') }}">
                                            @method('PUT')
                                            @csrf
                                            <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                            <input hidden name="piece_id" value="{{ $piece->id}}" />
                                            <div class="mx-auto">
                                                <button type="submit" class="btn light-shadow-3 rounded-1 outline opening txt-white"><span class="outline-text outline-invert"><i class="fas fa-trash txt-red"></i></span></button>
                                            </div>
                                        </form>
                                    </div>
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
</div>
<!-- Actions -->
<div class="container mt-5">
    <div class="tab rounded-3 full-width white shadow-1" id="example-tab" data-ax="tab">
        <ul class="tab-menu light-shadow-1 rounded-tl2 rounded-tr2 txt-black">
            <li class="tab-link">
                <a href="#tab-vehicule">Véhicule</a>
            </li>
            <li class="tab-link">
                <a href="#tab-operation">Opération</a>
            </li>
            <li class="tab-link">
                <a href="#tab-piece">Pièce</a>
            </li>
            <li class="tab-link">
                <a href="#tab-observation">Observations</a>
            </li>
            <li class="tab-link">
                <a href="#tab-deplacement">Déplacement</a>
            </li>
            <li class="tab-link">
                <a href="#tab-kilometrage">Kilométrage</a>
            </li>
            <li class="tab-link">
                <a href="#tab-gestion">Gestion</a>
            </li>
        </ul>

        <!-- Tab Déplacement -->
        <div id="tab-deplacement" class="p-3 container">
            @if(empty($intervention->start_deplacement_aller) || empty($intervention->end_deplacement_aller))
            <p class="txt-airforce txt-dark-4 txt-center">Déplacements ALLER</p>
            @endif
            @if(empty($intervention->start_deplacement_aller))
            <div>
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="start_deplacement_aller" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Début</span></button>
                    </div>
                </form>
            </div>
            @endif
            <!--End Déplacement Interventions Aller -->
            @if(!empty($intervention->start_deplacement_aller) && empty($intervention->end_deplacement_aller))
            <div class="">
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="end_deplacement_aller" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                    </div>
                </form>
            </div>
            @endif
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
            @if(!empty($intervention->start_deplacement_retour) && !empty($intervention->end_deplacement_retour) && !empty($intervention->end_deplacement_aller) && !empty($intervention->start_deplacement_retour))
            <p class="txt-center txt-airforce txt-dark-4">Déplacements enregistrés</p>
            @endif
        </div>
        <!-- TAB Véhicule -->
        <div id="tab-vehicule" class="p-4">
            @if(!empty($intervention->vehicule_id))
            <div class="grix xs1 sm2">
                <div class=my-auto>
                    <p class="txt-center txt-airforce txt-dark-4">Véhicule enregistré</p>
                </div>
                <div>
                    <img src="{{ asset('/images/car.svg') }}" class="responsive-media p-3" alt="">
                </div>
            </div>

            @else
            <div class="mt-2 mb-2 grix sm2 gutter-sm5">
                <div class="my-auto">
                    <div>
                        <form class="form-material" method="GET" action="{{ route('selectVehicule')}}">
                            @csrf
                            <div class="grix xs6">
                                <div class="form-field pos-xs1 col-xs5">
                                    <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}" />
                                    <input type="text" name="selectVehicule" id="selectVehicule" class="form-control txt-airforce txt-dark-4" />
                                    <label for="selectVehicule">Rechercher</label>
                                </div>
                                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange circle mx-auto vself-center rounded-4"><span class="outline-text outline-invert"><i class="fas fa-search"></i></span></button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-5">
                        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="form-field">
                                <label for="select">Véhicule</label>
                                <select class="form-control  txt-airforce txt-dark-4" id="select" name="vehicule_id">
                                    @foreach ( $vehicules as $vehicule)
                                    <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $vehicule->id }}">{{ $vehicule->immat }} - {{ $vehicule->marque }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="txt-center">
                                <button type="submit" class="btn shadow-1 outline opening txt-orange ml-auto vself-center rounded-2 mt-4"><span class="outline-text outline-invert">Valider</span></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="d-flex my-auto">
                    <img src="{{ asset('/images/car.svg') }}" class="responsive-media p-3" alt="">
                </div>
            </div>
            @endif
        </div>
        <!-- TAB Kilométrage -->
        <div id="tab-kilometrage" class="p-3 container">
            @if(!empty($intervention->km_vehicule))
            <p class="txt-center txt-airforce txt-dark-4">Kilométrage enregistré</p>
            @else
            <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1 txt-center">
                    <div class="form-field">
                        <input type="number" id="km_vehicule" name="km_vehicule" value="{{ $intervention->km_vehicule }}" class="form-control txt-center txt-airforce txt-dark-4" />
                        <label for="km_vehicule" class="">Kilométrage</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn shadow-1 outline opening txt-orange ml-auto vself-center rounded-2 mt-4"><span class="outline-text outline-invert">Valider</span></button>
                </div>
            </form>
            @endif
        </div>
        <!-- Tab opération -->
        <div id="tab-operation" class="p-3 container">
            <div class="grix xs1 md2">
                <div class="d-flex vcenter">
                    <form class="form-material container" method="POST" action="{{ route('addOperation')}}">
                        @csrf
                        <div class="form-field">
                            <label for="operation">Opération</label>
                            <select class="form-control rounded-1 txt-airforce txt-dark-4" name="categorie_id">
                                @foreach ( $categories as $categorie)
                                <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $categorie->id }}">{{ $categorie->name }}</option>
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
        <!-- Tab pièce -->
        <div id="tab-piece" class="p-3">
            <div class="grix xs1 md2 container">
                <div class="d-flex my-auto mx-auto w100 ">
                    <form class="form-material w100" method="POST" action="{{ route('addPiece')}}">
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
                            <input required type="text" id="qr-code-result" name="piece-ref" class="form-control txt-airforce txt-dark-4"></input>
                            <label for="qte">Pièce</label>
                        </div>
                        <div class="form-field">
                            <input required type="number" name="qte" class="form-control txt-airforce txt-dark-4"></input>
                            <label for="qte">Quantité</label>
                        </div>
                        <input hidden name="intervention-id" value="{{ $intervention->id }}">
                        <div class="txt-center">
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
                        </div>
                    </form>
                </div>
                <img src="{{ asset('/images/qrcode.png') }}" class="p-3 responsive-media" alt="">
            </div>
        </div>
        <!-- Tab observations -->
        <div id="tab-observation" class="p-3 container">
            <div class="grix xs1 md2">
                <div class="d-flex vcenter">
                    <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="grix xs1 txt-center">
                            <div class="form-field">
                                <textarea type="number" name="observations" class="form-control txt-center grey txt-airforce txt-dark-4">{{ $intervention->observations }}</textarea>
                                <label for="observations" class="">Observations</label>
                            </div>
                        </div>
                        <div class="txt-center">
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
                        </div>
                    </form>
                </div>
                <img src="{{ asset('/images/note.svg') }}" class="responsive-media p-3" alt="">
            </div>

        </div>
        <!-- Tab gestion -->
        <div id="tab-gestion" class="p-3">
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
        </div>
    </div>
</div>
<!-- MODALS -->

@foreach( $intervention->pieces as $piece)
<div class="modal white shadow-1 p-4 rounded-2" id="edit-piece-{{ $piece->id }}" data-ax="modal">
    <form class="form-material" method="POST" action="{{ route('editPiece') }}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <div class="form-field">
                <textarea type="text" id="piece-observations" name="observations" class="form-control txt-airforce txt-dark-4">{{ $piece->pivot->observations }}</textarea>
                <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                <input hidden name="piece_id" value="{{ $piece->id}}" />
                <label for="observations" class="">Observations</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>
@endforeach

@foreach( $intervention->categories as $operation)
<div class="modal white shadow-1 p-4 rounded-2" id="edit-operation-{{ $operation->id }}" data-ax="modal">
    <form class="form-material" method="POST" action="{{ route('editOperation') }}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <div class="form-field">
                <textarea type="text" id="operation-observations" name="observations" class="form-control txt-airforce txt-dark-4">{{ $operation->pivot->observations }}</textarea>
                <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                <input hidden name="categorie_id" value="{{ $operation->id}}" />
                <label for="observations" class="">Observations</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>
@endforeach

<div class="modal airforce dark-4 shadow-1 mb-3 h100 rounded-2" id="modal-comment" data-ax="modal">
    <div class="card m-0">
        <div class="card-header txt-white txt-center">Observations</div>
    </div>
    <div class="card-content p-4 txt-white">
        {{ $intervention->observations}}
    </div>
</div>

@endsection

@section('extra-js')

<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script type="text/javascript" src="{{ mix('js/qrCodeScanner.js') }}"></script>

<script>
    let toast = new Axentix.Toast();
</script>

@if(session('toast') == 'nopieceqte')
<script>
    toast.change('Pas assez de pièces', {
        classes: "rounded-1 red light-2 shadow-2 mt-5"
    });
    toast.show();
</script>
@elseif(session('toast') == 'addpiece')
<script>
    toast.change('Pièce ajoutée', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removepiece')
<script>
    toast.change('Pièce supprimée', {
        classes: "rounded-1 green light-2 shadow-2"
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
@elseif(session('toast') == 'addoperation')
<script>
    toast.change('Opération ajoutée', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removeoperation')
<script>
    toast.change('Opération supprimée', {
        classes: "rounded-1 green light-2 shadow-2"
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