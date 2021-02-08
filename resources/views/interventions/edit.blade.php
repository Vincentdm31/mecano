@extends('layouts.app')
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();

?>

<!-- Actions -->
<div class="container">
    <div class="container shadow-1 rounded-3 mt-5 mb-5">
        <div class="grix xs1 md3 gutter-xs1 greyy">
            <button data-target="modal-operation" class="btn press orange h100 w100 modal-trigger mb-2">
                Opération<i class="far fa-plus-square ml-3"></i>
            </button>
            <button data-target="modal-observation" class="btn press orange h100 w100 modal-trigger mb-2">
                Observations<i class="far fa-plus-square ml-3"></i>
            </button>
            @if($intervention->state == "doing")
            <form class="form-material" method="POST" action="{{ route('timeinterventions.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="start_date" value="{{ $date }}">
                <button type="submit" class="btn press orange h100 w100">Mettre en pause</button>
            </form>
            @elseif(($intervention->state == "pause"))
            <form class="form-material" method="POST" action="{{ route('timeinterventions.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="end_date" value="{{ $date }}">
                <button type="submit" class="btn press orange h100 w100">Reprendre</button>
            </form>
            @endif
        </div>
        <div class="tab full-width shadow-1" id="example-tab" data-ax="tab">
            <ul class="tab-menu greyy txt-white">
                <li class="tab-link">
                    <a href="#tab-deplacement">Déplacement</a>
                </li>
                <li class="tab-link">
                    <a href="#tab-vehicule">Véhicule</a>
                </li>
                <li class="tab-link">
                    <a href="#tab-kilometrage">Kilométrage</a>
                </li>
            </ul>

            <!-- Here are your tab contents -->
            <div id="tab-deplacement" class="p-3 greyy">
                @if(empty($intervention->start_deplacement_aller) || empty($intervention->end_deplacement_aller))
                <p class="txt-white txt-center">Déplacements ALLER</p>
                @endif
                @if(empty($intervention->start_deplacement_aller))
                <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                    @method('PUT')
                    @csrf
                    <div class="txt-center">
                        <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement_aller" />
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
                            <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement_aller" />
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
                        </div>
                    </form>
                </div>
                @endif
                <!--Start Déplacement Interventions Retour -->
                @if(!empty($intervention->end_deplacement_aller) && empty($intervention->start_deplacement_retour))
                <p class="txt-white txt-center">Déplacements Retour</p>
                <div class="">
                    <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="txt-center">
                            <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement_retour" />
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Début</span></button>
                        </div>
                    </form>
                </div>
                @endif
                <!--End Déplacement Interventions Retour -->
                @if(!empty($intervention->start_deplacement_retour) && empty($intervention->end_deplacement_retour))
                <p class="txt-white txt-center">Déplacements Retour</p>
                <div class="">
                    <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                        @method('PUT')
                        @csrf
                        <div class="txt-center">
                            <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement_retour" />
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
            <div id="tab-vehicule" class="p-3 greyy">
                <div class="mt-2 mb-2">
                    <form class="form-material" method="GET" action="{{ route('selectVehicule')}}">
                        @csrf
                        <div class="grix xs6">
                            <div class="form-field pos-xs1 col-xs5">
                                <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}" />
                                <input type="text" name="selectVehicule" id="selectVehicule" class="form-control txt-white" />
                                <label for="selectVehicule">Rechercher</label>
                            </div>
                            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange circle ml-auto vself-center rounded-4"><span class="outline-text outline-invert"><i class="fa fa-search"></i></span></button>
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
            <div id="tab-kilometrage" class="p-3 greyy">
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
    <div class="container rounded-3 card overflow-visible shadow-4 mb-5">
        <div class="card-header orange p-0">
            <p class="txt-center txt-black">Récapitulatif</p>
            <a href="" data-target="modal-comment" style="position:absolute;right:0;top:0;transform:translate(50%,-50%); font-size:2.5rem;" class="<?php echo (empty($intervention->observations) ? 'txt-airforce txt-light-4' : 'txt-green') ?> fas fa-comment modal-trigger"></a>
        </div>
        <div class="card-content greyy">
            <div class="grix xs1 txt-white md3">
                <div>
                    <p class="txt-center">Créateur : {{ $intervention->created_by }}</p>
                </div>
                <div>
                    <p class="txt-center">
                        Ref Intervention : {{ $intervention->id }}
                    </p>
                </div>
                <div>
                    <p class="txt-center">{{\Carbon\Carbon::parse($intervention->created_at)->isoFormat('LLLL')}}</p>
                </div>
                @foreach($intervention->users as $user)
                <div>
                    <li class="txt-center">{{ $user->name }}</li>
                </div>
                @endforeach

            </div>
        </div>


        <div class="grix xs1 gutter-xs5">
            <!-- Véhicule -->
            <div>
                @if(empty($intervention->vehicule_id))
                <p class="greyy txt-orange h100 m-0 p-2 txt-center">Aucun véhicule sélectionné</p>
                @else
                <div class="card m-0 greyy h100">
                    <div class="grix xs1 md4 txt-white txt-center">
                        <p class="">Marque : {{$intervention->vehiculeList->marque}}</p>
                        <p class="">Modèle : {{$intervention->vehiculeList->modele}}</p>
                        <p class="">Immatriculation : {{$intervention->vehiculeList->immat}}</p>
                        @if(empty($intervention->km_vehicule))
                        <p class="txt-orange">Saisir kilométrage</p>
                        @else
                        <p class="">Kilométrage : {{$intervention->km_vehicule}}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Opérations -->
<div class="container mb-5">
    <div class="container">
        <div class="card txt-center shadow-4">
            <div class="card-header orange txt-center txt-black">
                <p class="h5 p-2">Liste des opérations</p>
            </div>
            @foreach ($intervention->operations as $operation)
            <div class="card-content greyy txt-white grix xs2">
                <p class="my-auto">{{ $operation->name }}</p>
                <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 press orange txt-white modal-trigger mx-auto">
                    <i class="fas fa-comment-medical <?php echo (isset($operation->commentaire) ? 'txt-green' : '') ?>"></i>
                </button>
                <div class="modal grey light-4 shadow-1 mb-3 p-4" id="edit-operation-{{ $operation->id }}" data-ax="modal">
                    <div class="">
                        <form class="form-material" method="POST" action="{{ route('operations.update',['operation' => $operation->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="grix xs1 txt-center">
                                <div class="form-field">
                                    <textarea type="text" id="commentaire" name="commentaire" class="form-control" value="">{{ $operation->commentaire }}</textarea>
                                    <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                    <label for="commentaire" class="">Commentaire</label>
                                </div>
                            </div>
                            <div class="txt-center">
                                <button type="submit" class="btn green dark-2 rounded-1 mt-3 mb-3">
                                    Valider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal grey light-4 shadow-1 mb-3 p-4" id="modal-deplacement" data-ax="modal">
    <!--Start Déplacement Interventions Aller -->
    <div id="kmSection" class="grix xs1 sm2">
        <p class="txt-airforce txt-dark-4 col-sm2">Déplacements ALLER</p>
        @if(empty($intervention->start_deplacement_aller))
        <div class="">
            <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement_aller" />
                    <button type="submit" class="btn green dark-2 w100 rounded-1 dark-4 mt-3">
                        Start Déplacement
                    </button>
                </div>
            </form>
        </div>
        @endif
        <!--End Déplacement Interventions Aller -->
        @if(!empty($intervention->start_deplacement_aller) && empty($intervention->end_deplacement_aller))
        <div class="mb-5">
            <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement_aller" />
                    <button type="submit" class="btn red dark-2 rounded-1 w100 dark-4 mt-3">
                        End Déplacement
                    </button>
                </div>
            </form>
        </div>
        @endif
        <!--Start Déplacement Interventions Retour -->
        <p class="txt-airforce txt-dark-4 col-sm2">Déplacements Retour</p>
        @if(!empty($intervention->end_deplacement_aller) && empty($intervention->start_deplacement_retour) )
        <div class="">
            <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden id="start_deplacement" value="{{ $date }}" name="start_deplacement_retour" />
                    <button type="submit" class="btn green dark-2 w100 rounded-1 dark-4 mt-3">
                        Start Déplacement
                    </button>
                </div>
            </form>
        </div>
        @endif
        <!--End Déplacement Interventions Retour -->
        @if(!empty($intervention->start_deplacement_retour) && empty($intervention->end_deplacement_retour))
        <div class="mb-5">
            <form method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                    <input hidden id="end_deplacement" value="{{ $date }}" name="end_deplacement_retour" />
                    <button type="submit" class="btn red dark-2 rounded-1 w100 dark-4 mt-3">
                        End Déplacement
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<div class="modal grey light-4 shadow-1 mb-3 p-4" id="modal-vehicule" data-ax="modal">
    <div class="mt-2 mb-2">
        <form class="form-material" method="GET" action="{{ route('selectVehicule')}}">
            @csrf
            <div class="grix xs6">
                <div class="form-field pos-xs1 col-xs5">
                    <input hidden type="text" id="intervention_id" name="intervention_id" value="{{ $intervention->id }}" />
                    <input type="text" name="selectVehicule" id="selectVehicule" class="form-control" />
                    <label for="selectVehicule">Rechercher</label>
                </div>
                <button type="submit" class="btn circle ml-auto vself-center rounded-4"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
    <div class="mt-5">
        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
            @method('PUT')
            @csrf
            <div class="form-field">
                <label for="select">Véhicule</label>
                <select class="form-control rounded-1" id="select" name="vehicule_id">
                    @foreach ( $vehicules as $vehicule)
                    <option value="{{ $vehicule->id }}">{{ $vehicule->immat }} - {{ $vehicule->marque }}</option>
                    @endforeach
                </select>
            </div>
            <div class="txt-center">
                <button type="submit" class="btn green dark-2 rounded-1 mt-3">
                    Valider
                </button>
            </div>
        </form>
    </div>
</div>


<div class="modal grey light-4 shadow-1 mb-3 p-4" id="modal-operation" data-ax="modal">
    <form class="form-material" method="POST" action="{{ route('operations.store')}}">
        @csrf
        <div class="form-field">
            <label for="operation">Opération</label>
            <select class="form-control rounded-1" id="operation" name="name">
                @foreach ( $categories as $categorie)
                <option value="{{ $categorie->name }}">{{ $categorie->name }}</option>
                @endforeach
            </select>
        </div>
        <input hidden name="intervention_id" value="{{ $intervention->id }}">
        <div class="txt-center">
            <button type="submit" class="btn green dark-2 rounded-1 mt-3 mb-3">
                Valider
            </button>
        </div>
    </form>
</div>

<div class="modal grey light-4 shadow-1 mb-3 p-4" id="modal-observation" data-ax="modal">
    <div class="">
        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
            @method('PUT')
            @csrf
            <div class="grix xs1 txt-center">
                <div class="form-field">
                    <textarea type="number" id="km_vehicule" name="observations" class="form-control txt-center">{{ $intervention->observations }}</textarea>
                    <label for="km_vehicule" class="">Observations</label>
                </div>
            </div>
            <div class="txt-center">
                <button type="submit" class="btn green dark-2 rounded-1 mt-3 mb-3">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal grey light-4 shadow-1 mb-3 h100 rounded-3" id="modal-comment" data-ax="modal">
    <div class="card m-0">
        <div class="card-header greyy txt-orange txt-center">Observations</div>
    </div>
    <div class="card-content p-4">
        {{ $intervention->observations}}
    </div>
</div>

@endsection