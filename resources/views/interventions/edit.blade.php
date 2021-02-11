@extends('layouts.app')
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();

?>

<!-- Actions -->
<div class="container mt-5">
    <div class="container bd-solid bd-3 bd-orange bd-light-4 shadow-1 rounded-3">
        <div class="grix xs1 md3 gutter-xs3 vcenter center p-4">
            <button data-target="modal-add-operation" class="btn w100 modal-trigger rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Operation<i class="far fa-plus-square ml-3"></i></span></button>
            <div class="modal greyy light-4 shadow-1 mb-3 p-4" id="modal-add-operation" data-ax="modal">
                <form class="form-material" method="POST" action="{{ route('addOperation')}}">
                    @csrf
                    <div class="form-field">
                        <label for="operation">Opération</label>
                        <select class="form-control rounded-1 txt-white" name="categorie_id">
                            @foreach ( $categories as $categorie)
                            <option class="greyy txt-white" value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                    <div class="txt-center">
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
                    </div>
                </form>
            </div>
            <button data-target="modal-observation" class="btn w100 modal-trigger rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Observation<i class="far fa-plus-square ml-3"></i></span></button>
            <div class="modal greyy shadow-1 mb-3 p-4" id="modal-observation" data-ax="modal">
                <div class="">
                    <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="grix xs1 txt-center">
                            <div class="form-field">
                                <textarea type="number" id="km_vehicule" name="observations" class="form-control txt-center txt-white">{{ $intervention->observations }}</textarea>
                                <label for="km_vehicule" class="">Observations</label>
                            </div>
                        </div>
                        <div class="txt-center">
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
                        </div>
                    </form>
                </div>
            </div>
            @if($intervention->state == "doing")
            <form class="form-material my-auto w100" method="POST" action="{{ route('timeinterventions.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="start_date" value="{{ $date }}">
                <button type="submit" class="btn w100 modal-trigger rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Pause</span></button>
            </form>
            @elseif(($intervention->state == "pause"))
            <form class="form-material my-auto w100" method="POST" action="{{ route('timeinterventions.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="end_date" value="{{ $date }}">
                <button type="submit" class="btn w100 modal-trigger rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Reprendre</span></button>
            </form>
            @endif
        </div>
        <div class="tab full-width shadow-1 p-3" id="example-tab" data-ax="tab">
            <ul class="tab-menu greyy txt-white">
                <li class="tab-link">
                    <a href="#tab-vehicule">Véhicule</a>
                </li>
                <li class="tab-link">
                    <a href="#tab-deplacement">Déplacement</a>
                </li>
                <li class="tab-link">
                    <a href="#tab-kilometrage">Kilométrage</a>
                </li>
            </ul>

            <!-- Here are your tab contents -->
            <div id="tab-deplacement" class="p-3 greyy rounded-3">
                @if(empty($intervention->start_deplacement_aller) || empty($intervention->end_deplacement_aller))
                <p class="txt-white txt-center">Déplacements ALLER</p>
                @endif
                @if(empty($intervention->start_deplacement_aller))
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden value="{{ $date }}" name="start_deplacement_aller" />
                        <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Début</span></button>
                    </div>
                </form>
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
                <p class="txt-orange txt-center">Déplacements Retour</p>
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
                <p class="txt-orange txt-center">Déplacements Retour</p>
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
                <p class="txt-center txt-white">Déplacements enregistrés</p>
                @endif
            </div>
            <!-- TAB 2 -->
            <div id="tab-vehicule" class="p-3 greyy rounded-3">
                <div class="mt-2 mb-2">
                    <form class="form-material" method="GET" action="{{ route('selectVehicule')}}">
                        @csrf
                        <div class="grix xs6">
                            <div class="form-field pos-xs1 col-xs5">
                                <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}" />
                                <input type="text" name="selectVehicule" id="selectVehicule" class="form-control txt-white" />
                                <label for="selectVehicule">Rechercher</label>
                            </div>
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange circle mx-auto vself-center rounded-4"><span class="outline-text outline-invert"><i class="fa fa-search"></i></span></button>
                        </div>
                    </form>
                </div>
                <div class="mt-5">
                    <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="form-field">
                            <label for="select">Véhicule</label>
                            <select class="form-control greyy txt-white" id="select" name="vehicule_id">
                                @foreach ( $vehicules as $vehicule)
                                <option class="greyy" value="{{ $vehicule->id }}">{{ $vehicule->immat }} - {{ $vehicule->marque }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="txt-center">
                            <button type="submit" class="btn shadow-1 outline opening txt-orange ml-auto vself-center rounded-2 mt-4"><span class="outline-text outline-invert">Valider</span></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- TAB 3 -->
            <div id="tab-kilometrage" class="p-3 greyy rounded-3">
                <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="grix xs1 txt-center">
                        <div class="form-field">
                            <input type="number" id="km_vehicule" name="km_vehicule" value="{{ $intervention->km_vehicule }}" class="form-control txt-center txt-white" />
                            <label for="km_vehicule" class="">Kilométrage</label>
                        </div>
                    </div>
                    <div class="txt-center">
                        <button type="submit" class="btn shadow-1 outline opening txt-orange ml-auto vself-center rounded-2 mt-4"><span class="outline-text outline-invert">Valider</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <!-- Récapitulatif -->
    <div class="container bd-orange bd-light-4 bd-solid bd-3 rounded-3 card overflow-visible shadow-4 mb-5">
        <div class="card-header p-0 txt-center">
            <p class="m-3 txt-white">Infos générales</p>
            <a href="" data-target="modal-comment" style="position:absolute;right:0;top:0;transform:translate(50%,-50%); font-size:2.5rem;" class="<?php echo (empty($intervention->observations) ? 'hide' : 'txt-orange') ?> fas fa-comment modal-trigger"></a>
            <div class="modal grey light-4 shadow-1 mb-3 h100 rounded-3" id="modal-comment" data-ax="modal">
                <div class="card m-0">
                    <div class="card-header greyy txt-white txt-center">Observations</div>
                </div>
                <div class="card-content p-4">
                    {{ $intervention->observations}}
                </div>
            </div>
        </div>
        <div class="card-content rounded-bl3 rounded-br3 p-2 greyy">
            <div class="grix xs1 txt-white md3 mt-4 mb-5">
                <div class="">
                    <p class="txt-center">Créateur : {{ $intervention->created_by }}</p>
                </div>
                <div class="pos-row-xs1 txt-center">
                    <p class="">{{\Carbon\Carbon::parse($intervention->created_at)->isoFormat('LLLL')}}</p>
                </div>
                <div>
                    <p class="txt-center">
                        Ref Intervention : {{ $intervention->id }}
                    </p>
                </div>
            </div>
            @foreach($intervention->users as $user)
            <div>
                <li class="txt-center txt-white">{{ $user->name }}</li>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="container">
    <div class="container grix xs1 md2 gutter-xs5 mt-4 mb-4 ">
        <!-- Véhicule -->
        <div class="rounded-3 bd-orange bd-light-4 bd-solid bd-3">
            @if(empty($intervention->vehicule_id))
            <p class="greyy txt-orange h100 m-0 p-4 rounded-3 vself-center txt-center">Aucun véhicule sélectionné</p>
            @else
            <div class="card m-0 greyy rounded-3 bd-orange bd-3 bd-light-4 bd-solid txt-center h100">
                <div class="card-header p-2 txt-white">Véhicule</div>
                <div class="card-content rounded-bl3 rounded-br3">
                    <div class="grix xs1 md2 txt-white">
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
            </div>
            @endif
        </div>
        <!-- Déplacements -->
        @if(!empty($intervention->start_deplacement_aller))
        <div class="grix xs1 greyy rounded-3 bd-orange bd-light-4 bd-3 bd-solid txt-white">
            <div class="card m-0">
                <div class="card-header txt-center p-2 txt-white rounded-tl3 rounded-tr3">Déplacement</div>
                <div class="card-content rounded-bl3 rounded-br3">
                    <div class="grix sm1 md2 txt-center">
                        <div>
                            <p class="pb-2 txt-orange">Aller</p>
                            <p>{{ Carbon::parse($intervention->start_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                            <p>{{ Carbon::parse($intervention->end_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                        </div>
                        <div>
                            <p class="pb-2 txt-orange">Retour</p>
                            <p>{{ Carbon::parse($intervention->start_deplacement_retour)->format('d/m/Y h:m:s')  }}</p>
                            <p>{{ Carbon::parse($intervention->end_deplacement_retour)->format('d/m/Y h:m:s')  }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="greyy bd-solid bd-3 bd-orange bd-light-4 rounded-3">
            <p class="m-0 p-4 txt-center txt-orange"> Pas de déplacement</p>
        </div>
        @endif
    </div>
</div>



<!-- Opérations -->
<div class="container mb-5">
    <div class="container">
        <div class="card rounded-3 txt-center bd-orange bd-light-4 bd-solid bd-3 shadow-4">
            <div class="card-header p-0  txt-center txt-white">
                <p class="">Liste des opérations</p>
            </div>
            <div class="card-content">
                <div class="grix xs3">
                    @foreach( $intervention->categories as $operation)
                    <div class="my-auto txt-white">
                        <p>{{ $operation->name }}</p>
                    </div>
                    <div class="my-auto">
                        <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 txt-blue modal-trigger mx-auto">
                            <i class="fas fa-comment-medical <?php echo (isset($operation->observations) ? 'txt-orange' : '') ?>"></i>
                        </button>
                        <div class="modal greyy shadow-1 mb-3 p-4" id="edit-operation-{{ $operation->id }}" data-ax="modal">
                            <form class="form-material" method="POST" action="{{ route('editOperation') }}">
                                @method('PUT')
                                @csrf
                                <div class="grix xs1 txt-center">
                                    <div class="form-field">
                                        <textarea type="text" id="observations" name="observations" class="form-control txt-white">{{ $operation->pivot->observations }}</textarea>
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
                    </div>
                    <div>
                        <form class="form-material" method="POST" action="{{ route('deleteOperation') }}">
                            @method('PUT')
                            @csrf
                            <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                            <input hidden name="categorie_id" value="{{ $operation->id}}" />
                            <div class="mx-auto">
                                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">delete</span></button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection