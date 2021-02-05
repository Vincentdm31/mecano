@extends('layouts.app')
@section('content')
<?php

use Carbon\Carbon;
$date = Carbon::now()->format('d/m/Y');  

?>

<!-- Actions -->
<div class="container">
    <div class="container shadow-1 mt-5 mb-5">
        <p class="txt-center h5 pt-3">Liste des actions</p>
        <div class="grix xs1 md3">
            <!-- Déplacement modal -->
            <div class="p-2">
                <button data-target="modal-deplacement" class="btn rounded-1 press airforce dark-4 modal-trigger w100 mx-auto">
                    Déplacements
                </button>
            </div>
            <!-- Choix Véhicule modal -->
            <div class="p-2">
                <button data-target="modal-vehicule" class="btn rounded-1 press airforce dark-4 modal-trigger w100 mx-auto">
                    Choix du véhicule
                </button>
            </div>
            <!-- Kilométrage véhicule modal -->
            <div class="p-2">
                <button data-target="modal-kilometrage" class="btn rounded-1 press airforce dark-4 modal-trigger mx-auto w100">
                    Kilométrage
                </button>
            </div>
            <!-- Opération modal -->
            <div class="p-2">
                <button data-target="modal-operation" class="btn rounded-1 press airforce dark-4 modal-trigger mx-auto w100">
                    <i class="far fa-plus-square mr-3"></i>Opération
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <!-- Récapitulatif -->
    <div class="container rounded-3 card shadow-4 mb-5">
        <div class="card-hearder airforce dark-4 txt-white">
            <p class="txt-center h5 p-2">Récapitulatif</p>
        </div>
        <div class="grix xs2 md3">
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

        <div class="grix xs1 gutter-xs5 md2 p-4">
            <!-- Déplacements -->
            <div>
                @if(empty($intervention->start_deplacement_aller))
                <p class="txt-airforce txt-center txt-light-2">Pas de déplacement aller</p>
                @else
                <div class="card h100 shadow-4 rounded-2">
                    <div class="card-header p-2 airforce dark-4">
                        <p class="txt-center txt-white">Déplacement Aller</p>
                    </div>
                    <p class="txt-center txt-green txt-dark-2">{{ $intervention->start_deplacement_aller }}</p>
                    <p class="txt-center txt-red txt-dark-2">{{ $intervention->end_deplacement_aller }}</p>
                </div>

                @endif
            </div>
            <div>
                @if(empty($intervention->start_deplacement_retour))
                <p class="txt-airforce txt-center txt-light-2">Pas de déplacement retour</p>
                @else
                <div class="card h100 shadow-4 rounded-2">
                    <div class="card-header p-2 airforce dark-4">
                        <p class="txt-center txt-white">Déplacement Retour</p>
                    </div>
                    <p class="txt-center txt-green txt-dark-2">{{ $intervention->start_deplacement_retour }}</p>
                    <p class="txt-center txt-red txt-dark-2">{{ $intervention->end_deplacement_retour }}</p>
                </div>

                @endif
            </div>
            <!-- Véhicule -->
            <div>
                @if(empty($intervention->vehicule_id))
                <p class="txt-airforce txt-center txt-light-2">Choisir un véhicule</p>
                @else
                <div class="card h100 shadow-4 rounded-2">
                    <div class="card-header p-2 airforce dark-4">
                        <p class="txt-center txt-white">Véhicule</p>
                    </div>
                    <div class="grix xs2">
                        <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->marque}}</p>
                        <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->modele}}</p>
                    </div>
                    <p class="txt-center txt-green txt-dark-2">{{$intervention->vehiculeList->immat}}</p>
                </div>

                @endif
            </div>
            <!-- Kilométrage -->
            <div>
                @if(empty($intervention->km_vehicule))
                <p class="txt-airforce txt-center txt-light-2">Saisir le kilométrage</p>
                @else
                <div class="card h100 shadow-4 rounded-2">
                    <div class="card-header p-2 airforce dark-4">
                        <p class="txt-center txt-white">Kilométrage</p>
                    </div>
                    <p class="txt-center txt-green my-auto txt-dark-2">{{$intervention->km_vehicule}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Opérations -->
<div class="container mb-5">
    <div class="container">
        <div class="card rounded-3 txt-center shadow-4">
            <div class="card-header airforce dark-4 txt-center txt-white">
                <p class="h5 p-2">Liste des opérations</p>
            </div>
            @foreach ($intervention->operations as $operation)
            <div class="card-content grix xs2">
                <p class="my-auto">{{ $operation->name }}</p>
                <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 press airforce dark-4 modal-trigger mx-auto">
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

<div class="modal grey light-4 shadow-1 mb-3 p-4" id="modal-kilometrage" data-ax="modal">
    <div class="">
        <form class="form-material" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
            @method('PUT')
            @csrf
            <div class="grix xs1 txt-center">
                <div class="form-field">
                    <input type="number" id="km_vehicule" name="km_vehicule" value="{{ $intervention->km_vehicule }}" class="form-control txt-center" />
                    <label for="km_vehicule" class="">Kilométrage</label>
                </div>
            </div>
            <div class="txt-center">
                <button type="submit" class="btn green dark-2 rounded-1 mt-3 mb-3">
                    Valider Kilométrage
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
@endsection