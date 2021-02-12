@extends('layouts.app')
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();

?>
<div class="container mt-5">
    <div class="container shadow-3">
        <button data-target="modal-recap" class="btn w100 txt-white greyy collapsible-trigger mx-auto">
            Voir le récapitulatif
        </button>
        <div class="collapsible greyy shadow-3" id="modal-recap" data-ax="collapsible">
            <div class="card">
                <div class="card-header p-3 recap-infos">
                    <p class="txt-white bd-b-solid bd-white bd-2 pb-2 ml-2">Infos générales</p>
                    <a href="" data-target="modal-comment" style="position:absolute;right:0;top:0;transform:translate(-50%,10%); font-size:3rem;" class="<?php echo (empty($intervention->observations) ? 'hide' : 'txt-orange') ?> fas fa-comment modal-trigger"></a>
                    <div class="modal grey light-4 shadow-1 mb-3 h100 rounded-3" id="modal-comment" data-ax="modal">
                        <div class="card m-0">
                            <div class="card-header greyy txt-white txt-center">Observations</div>
                        </div>
                        <div class="card-content p-4">
                            {{ $intervention->observations}}
                        </div>
                    </div>
                    <div class="grix xs1 txt-white md3">
                        <p class="pl-2 lh-normal">{{\Carbon\Carbon::parse($intervention->created_at)->isoFormat('LLLL')}}</p>
                        <p class="pl-2 lh-normal">Créateur : {{ $intervention->created_by }}</p>
                        <p class="pl-2 lh-normal">Ref Intervention : {{ $intervention->id }}</p>
                    </div>
                </div>
                <div class="card-content white p-3">
                    <div class="grix xs1 md2 gutter-xs5">
                        <div class="greyy p-2">
                            @if(empty($intervention->vehicule_id))
                            <p class="txt-orange pb-2">Aucun véhicule sélectionné</p>
                            @else
                            <div class="txt-white">
                                <p class="txt-white bd-b-solid bd-white bd-2 pb-2 mb-3">Véhicule</p>
                                <p class="">{{$intervention->vehiculeList->marque}}</p>
                                <p class="">{{$intervention->vehiculeList->modele}}</p>
                                <p class="">{{$intervention->vehiculeList->immat}}</p>
                                @if(empty($intervention->km_vehicule))
                                <p class="txt-orange">Saisir kilométrage</p>
                                @else
                                <p class="">{{$intervention->km_vehicule}} Km</p>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="greyy p-2">
                            <p class="txt-white bd-b-solid bd-white bd-2 pb-2 mb-3">Déplacements</p>
                            @if(empty($intervention->start_deplacement_aller))
                            <p class="txt-orange pb-2">Aucun déplacement</p>
                            @else
                            <div class="grix xs1 sm2">
                                <div class="txt-white">
                                    <p class="txt-orange">Aller</p>
                                    <p>{{ Carbon::parse($intervention->start_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                                    @if(!empty($intervention->end_deplacement_aller))
                                    <p>{{ Carbon::parse($intervention->end_deplacement_aller)->format('d/m/Y h:m:s')  }}</p>
                                    @endif
                                </div>
                                <div class="txt-white">
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
                        <div class="greyy p-2">
                            <p class="txt-white bd-b-solid bd-white bd-2 pb-2">Liste des opérations</p>
                            @if(!$intervention->categories()->exists())
                            <p class="txt-orange">Aucune opération en cours</p>
                            @else
                            <div class="grix xs2">
                                @foreach( $intervention->categories as $operation)
                                <div class="my-auto mx-auto txt-white">
                                    <p>{{ $operation->name }}</p>
                                </div>
                                <div class="grix xs2 gutter-xs2">
                                    <div class="my-auto ml-auto">
                                        <button data-target="edit-operation-{{ $operation->id }}" class="btn rounded-1 txt-blue modal-trigger mx-auto">
                                            <i class="fas fa-comment-medical <?php echo (isset($operation->pivot->observations) ? 'txt-orange' : '') ?>"></i>
                                        </button>
                                        <div class="modal greyy shadow-1 mb-3 p-4 col-md3" id="edit-operation-{{ $operation->id }}" data-ax="modal">
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
                                    <div class="mr-auto my-auto">
                                        <form class="form-material" method="POST" action="{{ route('deleteOperation') }}">
                                            @method('PUT')
                                            @csrf
                                            <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                            <input hidden name="categorie_id" value="{{ $operation->id}}" />
                                            <div class="mx-auto">
                                                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-white"><span class="outline-text outline-invert"><i class="fas fa-trash txt-red"></i></span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="greyy p-2">
                            <p class="txt-white bd-b-solid bd-white bd-2 pb-2">Liste des pièces</p>
                            @if(!$intervention->pieces()->exists())
                            <p class="txt-center txt-orange">Aucune pièce utilisée</p>
                            @else
                            <div class="grix xs2 md4">
                                @foreach( $intervention->pieces as $piece)
                                <div class="my-auto mx-auto txt-white">
                                    <p>{{ $piece->name }}</p>
                                </div>
                                <div class="my-auto mx-auto txt-white">
                                    <p>x{{ $piece->pivot->qte }}</p>
                                </div>
                                <div class="grix xs2 col-xs2 gutter-xs2">
                                    <div class="my-auto ml-auto">
                                        <button data-target="edit-piece-{{ $piece->id }}" class="btn rounded-1 txt-blue modal-trigger mx-auto">
                                            <i class="fas fa-comment-medical <?php echo (isset($piece->pivot->observations) ? 'txt-orange' : '') ?>"></i>
                                        </button>
                                        <div class="modal greyy shadow-1 mb-3 p-4" id="edit-piece-{{ $piece->id }}" data-ax="modal">
                                            <form class="form-material" method="POST" action="{{ route('editPiece') }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="grix xs1 txt-center">
                                                    <div class="form-field">
                                                        <textarea type="text" id="observations" name="observations" class="form-control txt-white">{{ $piece->pivot->observations }}</textarea>
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
                                    </div>
                                    <div class="my-auto">
                                        <form class="form-material" method="POST" action="{{ route('deletePiece') }}">
                                            @method('PUT')
                                            @csrf
                                            <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                                            <input hidden name="piece_id" value="{{ $piece->id}}" />
                                            <div class="mx-auto">
                                                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-white"><span class="outline-text outline-invert"><i class="fas fa-trash txt-red"></i></span></button>
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
    <div class="tab container full-width shadow-3" id="example-tab" data-ax="tab">
        <ul class="tab-menu greyy txt-white">
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
        <div id="tab-deplacement" class="p-3 greyy">
            @if(empty($intervention->start_deplacement_aller) || empty($intervention->end_deplacement_aller))
            <p class="txt-white txt-center">Déplacements ALLER</p>
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
        <!-- TAB Véhicule -->
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
        <!-- TAB Kilométrage -->
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
        <!-- Tab opération -->
        <div id="tab-operation" class="p-3 greyy">
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
        <!-- Tab pièce -->
        <div id="tab-piece" class="p-3 greyy">
            <form class="form-material" method="POST" action="{{ route('addPiece')}}">
                @csrf
                <div class="form-field">
                    <label for="operation">Piece</label>
                    <select class="form-control rounded-1 txt-white" name="piece_id">
                        @foreach ( $pieces as $piece)
                        <option class="greyy txt-white" value="{{ $piece->id }}">{{ $piece->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-field">
                    <input required type="number" name="qte" class="form-control txt-white"></input>
                    <label for="qte">Quantité</label>
                </div>
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <div class="txt-center">
                    <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
                </div>
            </form>
        </div>
        <!-- Tab observations -->
        <div id="tab-observation" class="p-3 greyy">
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
        <div id="tab-gestion" class="p-3 greyy">
            @if($intervention->state == "doing")
            <div>
                <form class="form-material" method="POST" action="{{ route('timeinterventions.store') }}">
                    @csrf
                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                    <input hidden name="start_date" value="{{ $date }}">
                    <button type="submit" class="btn  rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Pause</span></button>
                </form>
            </div>
            @elseif(($intervention->state == "pause"))
            <div>
                <form class="form-material my-auto" method="POST" action="{{ route('timeinterventions.store') }}">
                    @csrf
                    <input hidden name="intervention_id" value="{{ $intervention->id }}">
                    <input hidden name="end_date" value="{{ $date }}">
                    <button type="submit" class="btn rounded-1 outline opening txt-orange txt-light-4"><span class="outline-text outline-invert">Reprendre</span></button>
                </form>
            </div>

            @endif
        </div>
    </div>

</div>

@endsection

@section('extra-js')

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