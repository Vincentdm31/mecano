@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')

<?php

use App\Models\Operation;
use App\Models\OperationList;
use Carbon\Carbon;

?>

<div class="mx-3 grix xs1 md2 gutter-md6 gutter-xs5 mt-4 p-3">
    <div>
        <!-- Interventions -->
        <div class="bg-blue3 p-2 mb-5 relative-pos">
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-intervention-date"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Intervention</p>
            <form class="form-material">
                <div class="grix xs1 sm2 gutter-sm5 p-2">
                    <div class="form-field">
                        <input class="form-control rounded-1" value="{{ $intervention->id }}" readonly />
                        <label>Intervention n°</label>
                    </div>
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="{{ $intervention->created_by }}" readonly />
                        <label>Crée par</label>
                    </div>
                </div>
                <div class="grix xs3">
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="{{ Carbon::parse($intervention->start_intervention_time)->translatedFormat('d-m-Y H:i:s') }} " readonly />
                        <label>Crée le</label>
                    </div>
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="{{ Carbon::parse($intervention->end_intervention_time)->translatedFormat('d-m-Y H:i:s') }}" readonly />
                        <label>Terminée le</label>
                    </div>
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="<?php echo (round(Carbon::parse($intervention->end_intervention_time)->diffInMinutes(Carbon::parse($intervention->start_intervention_time)) / 60, 2)) ?>" readonly />
                        <label>Total</label>
                    </div>
                </div>
            </form>
        </div>
        <!-- Pause Intervention -->
        @foreach($pauseInterventions as $pauseIntervention)
        <div class="bg-blue3 p-2 mb-5 relative-pos">
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-pause-intervention-{{ $pauseIntervention->id }}"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Pause intervention</p>
            <form class="form-material">
                <div class="grix xs1 sm3 gutter-sm5 p-2">
                    <div class="form-field">
                        <input class="form-control rounded-1" value="{{ Carbon::parse($pauseIntervention->start_date)->translatedFormat('d-m-Y H:i:s') }}" readonly />
                        <label>Date début</label>
                    </div>
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="{{ Carbon::parse($pauseIntervention->end_date)->translatedFormat('d-m-Y H:i:s') }}" readonly />
                        <label>Date fin</label>
                    </div>
                    <div class="form-field">
                        <input type="text" class="form-control rounded-1" value="<?php echo (round((Carbon::parse($pauseIntervention->end_date)->diffInMinutes(Carbon::parse($pauseIntervention->start_date)) / 60), 2)) ?>" readonly />
                        <label>Total</label>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
        <!-- Véhicule -->
        <div class="bg-blue3 p-2 mb-5 relative-pos">
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-vehicule"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Véhicule</p>
            <form class="form-material">
                <div class="grix xs1 sm2 gutter-sm5 p-2">
                    <div class="form-field">
                        <input class="form-control rounded-1" value="{{ $intervention->vehiculeList->brand }}" readonly />
                        <label>Marque</label>
                    </div>
                    <div class="form-field">
                        <input class="form-control rounded-1" value="{{ $intervention->vehiculeList->model }}" readonly />
                        <label>Modèle</label>
                    </div>
                    <div class="form-field">
                        <input class="form-control rounded-1" value="{{ $intervention->vehiculeList->license_plate }}" readonly />
                        <label>Immatriculation</label>
                    </div>
                    <div class="form-field">
                        <input class="form-control rounded-1" value="<?php echo ($intervention->km_vehicule > 0 ? $intervention->km_vehicule : 'Non renseigné') ?>" readonly />
                        <label>Kilométrage</label>
                    </div>
                </div>
            </form>
        </div>
        <!-- Déplacements -->
        <div class="bg-blue3 p-2 mb-5 relative-pos">
            @if($intervention->needMove)
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-vehicule"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Déplacements</p>
            <form class="form-material">
                <div class="grix xs1 sm3 gutter-sm5 p-2 txt-gl4">
                    <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-deplacement"><i class="fas fa-pen txt-white"></i></button>
                    <div class="form-field">
                        <input readonly type="text" name="start_move_begin" class="form-control rounded-1" value="{{ $intervention->start_move_begin }}" />
                        <label>Début déplacement aller</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_begin" class="form-control rounded-1" value="{{ $intervention->end_move_begin }}" />
                        <label>Fin déplacement aller</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_begin" class="form-control rounded-1" value="{{ Carbon::parse($intervention->end_move_begin)->diffInMinutes(Carbon::parse($intervention->start_move_begin)) }}" />
                        <label>Total aller (min)</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="start_move_return" class="form-control rounded-1" value="{{ $intervention->start_move_return }}" />
                        <label>Début déplacement retour</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_return" class="form-control rounded-1" value="{{ $intervention->end_move_return }}" />
                        <label>Fin déplacement retour</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_begin" class="form-control rounded-1" value="{{ Carbon::parse($intervention->end_move_return)->diffInMinutes(Carbon::parse($intervention->start_move_return)) }}" />
                        <label>Total retour (min)</label>
                    </div>
                </div>
            </form>
            @else
            <div class="d-flex fx-center fx-col vcenter h100">
                <p class="txt-orange font-s6">Aucun déplacement</p>
                <button class="btn rounded-1 grey light-4 txt-orange outline modal-trigger" data-target="modal-deplacement"><span class="outline-text">Ajouter</span></button>
            </div>
            @endif
        </div>
        <!-- Commentaires -->
        <div class="bg-blue3 p-2 mb-5 relative-pos">
            @if($intervention->observations)
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-commentaire"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Commentaires</p>
            <form class="form-material">
                <div class="grix xs1 sm2 gutter-sm5 p-2 txt-gl4">
                    <div class="form-field col-sm2">
                        <label>Observations</label>
                        <textarea readonly class="form-control rounded-1">{{ $intervention->observations }}</textarea>
                    </div>
                </div>
            </form>
            @else
            <div class="d-flex fx-center fx-col vcenter h100">
                <p class="txt-orange font-s6">Aucun commentaire</p>
                <button class="btn rounded-1 grey light-4 txt-orange outline modal-trigger" data-target="modal-commentaire"><span class="outline-text">Ajouter</span></button>
            </div>
            @endif
        </div>
    </div>
    <!-- Opérations -->
    <div>
        @foreach($operations as $operation)
        <div class="bg-blue3 txt-gl4 mb-4 p-2 relative-pos ">
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-operation-{{ $operation->id }}"><i class="fas fa-pen txt-white"></i></button>
            <div class="d-flex">
                <p class="txt-gl4 ml-2 font-s5">Opération</p>
                <form class="ml-auto" method="POST" action="{{ route('deleteOperation', ['id' => $operation->id]) }}">
                    @csrf
                    <button type="submit" class="btn circle txt-gl4 mr-2 white font-s5"><i class="fas fa-trash txt-red"></i></button>
                </form>
            </div>

            <button class="btn orange modal-trigger txt-white" data-target="modal-piece-{{ $operation->id }}">Nouvelle pièce</button>
            <form class="form-material">
                <div class="grix xs1 sm2 gutter-sm5 p-2 txt-gl4">
                    <div class="form-field">
                        <input readonly type="text" name="start_move_begin" class="form-control rounded-1" value="{{ $operation->operationList->name }}" />
                        <label>Nom de l'opération</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_begin" class="form-control rounded-1" value="{{ $operation->user->name }}" />
                        <label>Crée par</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="start_move_return" class="form-control rounded-1" value="{{ Carbon::parse($operation->start_operation_time)->translatedFormat('d-m-Y H:i:s') }}" />
                        <label>Crée le</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_return" class="form-control rounded-1" value="{{ Carbon::parse($operation->end_operation_time)->translatedFormat('d-m-Y H:i:s') }}" />
                        <label>Terminée le</label>
                    </div>
                </div>
            </form>
            @foreach($operation->pieces as $piece)
            <form class="form-material">
                <div class="grix xs2 bg-blue my-3 gutter-xs2 p-2 txt-gl4 relative-pos">
                    <div class="form-field">
                        <input readonly type="text" name="name" class="form-control rounded-1" value="{{ $piece->pieceList->name }}" />
                        <label>Nom de la pièce</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="qte" class="form-control rounded-1" value="{{ $piece->qte }}" />
                        <label>Quantité</label>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
        @endforeach
        @foreach($pauseOperations as $pauseOperation)
        <div class="bg-blue3 txt-gl4 mb-4 p-2 relative-pos ">
            <?php
            $timeOpId = $pauseOperation->operation_id;
            $opId = Operation::where('id', $timeOpId)->get();
            $op = OperationList::where('id', $opId[0]->operation_id)->get();
            $opName = $op[0]->name;
            ?>
            <button class="btn circle small orange modal-trigger absolute-pos" style="top:0;right:0;transform:translate(50%,-50%)" data-target="modal-pause-operation-{{ $pauseOperation->id }}"><i class="fas fa-pen txt-white"></i></button>
            <p class="txt-gl4 ml-2 font-s5">Pause opération {{ $opName }} </p>
            <form class="form-material">
                <div class="grix xs1 sm3 gutter-sm5 p-2 txt-gl4">
                    <div class="form-field">
                        <input readonly type="text" name="start_move_begin" class="form-control rounded-1" value="{{ $pauseOperation->start_date }}" />
                        <label>Début pause opération</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" name="end_move_begin" class="form-control rounded-1" value="{{ $pauseOperation->end_date }}" />
                        <label>Fin pause opération</label>
                    </div>
                    <div class="form-field">
                        <input readonly type="text" class="form-control rounded-1" value="<?php echo (round(Carbon::parse($pauseOperation->end_date)->diffInMinutes(Carbon::parse($pauseOperation->start_date)) / 60, 2)) ?>" />
                        <label>Total pause (h)</label>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

<!-- MODALS -->
<!--Modal Intervention -->
<div class="modal bg-blue3 txt-gl4" id="modal-intervention-date" data-ax="modal">
    <div class="modal-header d-flex">
        <p> Intervention n°{{ $intervention->id }}</p>
        <p class="ml-auto">{{ $intervention->created_by }}</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyInterventionDate', ['id' => $intervention->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1 sm2">
                <div class="form-field">
                    <input type="text" name="start_intervention_time" class="form-control rounded-1" value="{{ $intervention->start_intervention_time }}" />
                    <label>Début intervention</label>
                    <span class="form-helper txt-orange font-w600">Format de la date: Année-Mois-Jour Heure:Minute:Seconde</span>
                    <span class="form-helper txt-orange">Exemple : 8 Juin 2021 09:30:25 = 2021-06-08 09:30:25</span>
                </div>
                <div class="form-field">
                    <input type="text" name="end_intervention_time" class="form-control rounded-1" value="{{ $intervention->end_intervention_time }}" />
                    <label>Fin intervention</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
    </div>
</div>
<!--Modal Pauses intervention -->
@foreach($pauseInterventions as $pauseIntervention)
<div class="modal bg-blue3 txt-gl4" id="modal-pause-intervention-{{ $pauseIntervention->id }}" data-ax="modal">
    <div class="modal-header d-flex">
        <p>Pause intervention</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyPauseIntervention', ['id' => $pauseIntervention->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1 sm2">
                <div class="form-field">
                    <input type="text" name="start_date" class="form-control rounded-1" value="{{ $pauseIntervention->start_date }}" />
                    <label>Début pause intervention</label>
                    <span class="form-helper txt-orange font-w600">Format de la date: Année-Mois-Jour Heure:Minute:Seconde</span>
                    <span class="form-helper txt-orange">Exemple : 8 Juin 2021 09:30:25 = 2021-06-08 09:30:25</span>
                </div>
                <div class="form-field">
                    <input type="text" name="end_date" class="form-control rounded-1" value="{{ $pauseIntervention->end_date }}" />
                    <label>Fin pause intervention</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
    </div>
</div>
@endforeach
<!--Modal Pauses opérations -->
@foreach($pauseOperations as $pauseOperation)
<?php
$timeOpId = $pauseOperation->operation_id;
$opId = Operation::where('id', $timeOpId)->get();
$op = OperationList::where('id', $opId[0]->operation_id)->get();
$opName = $op[0]->name;
?>
<div class="modal bg-blue3 txt-gl4" id="modal-pause-operation-{{ $pauseOperation->id }}" data-ax="modal">
    <div class="modal-header d-flex">
        <p>Pause Opération {{ $opName }}</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyPauseOperation', ['id' => $pauseOperation->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1 sm2">
                <div class="form-field">
                    <input type="text" name="start_date" class="form-control rounded-1" value="{{ $pauseOperation->start_date }}" />
                    <label>Début pause intervention</label>
                    <span class="form-helper txt-orange font-w600">Format de la date: Année-Mois-Jour Heure:Minute:Seconde</span>
                    <span class="form-helper txt-orange">Exemple : 8 Juin 2021 09:30:25 = 2021-06-08 09:30:25</span>
                </div>
                <div class="form-field">
                    <input type="text" name="end_date" class="form-control rounded-1" value="{{ $pauseOperation->end_date }}" />
                    <label>Fin pause intervention</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
    </div>
</div>
@endforeach
<!--Modal Déplacement -->
<div class="modal bg-blue3 txt-gl4" id="modal-deplacement" data-ax="modal">
    <div class="modal-header d-flex">
        <p> Déplacement intervention n° {{ $intervention->id }}</p>
        <p class="ml-auto">{{ $intervention->created_by }}</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyDeplacement', ['id' => $intervention->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1 sm2">
                <div class="form-field">
                    <input type="text" name="start_move_begin" class="form-control rounded-1" value="{{ $intervention->start_move_begin }}" />
                    <label>Début déplacement aller</label>
                    <span class="form-helper txt-orange font-w600">Format de la date: Année-Mois-Jour Heure:Minute:Seconde</span>
                    <span class="form-helper txt-orange">Exemple : 8 Juin 2021 09:30:25 = 2021-06-08 09:30:25</span>
                </div>
                <div class="form-field">
                    <input type="text" name="end_move_begin" class="form-control rounded-1" value="{{ $intervention->end_move_begin }}" />
                    <label>Fin déplacement aller</label>
                </div>
                <div class="form-field">
                    <input type="text" name="start_move_return" class="form-control rounded-1" value="{{ $intervention->start_move_return }}" />
                    <label>Début déplacement retour</label>
                </div>
                <div class="form-field">
                    <input type="text" name="end_move_return" class="form-control rounded-1" value="{{ $intervention->end_move_return }}" />
                    <label>Fin déplacement retour</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
    </div>
</div>
<!--Modal Véhicule -->
<div class="modal bg-blue3 txt-gl4" id="modal-vehicule" data-ax="modal">
    <div class="modal-header d-flex">
        <p>Véhicule</p>
        <p class="ml-auto">{{ $intervention->created_by }}</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyVehicule', ['id' => $intervention->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1">
                <div class="form-field">
                    <input type="text" name="km_vehicule" class="form-control rounded-1" value="<?php echo ($intervention->km_vehicule > 0 ? $intervention->km_vehicule : 'Non renseigné') ?>" />
                    <label>Kilométrage</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
    </div>
</div>
<!--Modal Commentaire -->
<div class="modal bg-blue3 txt-gl4" id="modal-commentaire" data-ax="modal">
    <div class="modal-header d-flex">
        <p> Observations Générales</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyObservations', ['id' => $intervention->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs1 sm2">
                <div class="form-field col-sm2">
                    <label>Observations</label>
                    <textarea name="observations" class="form-control rounded-1">{{ $intervention->observations }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange">Modifier</button>
        </form>
    </div>
</div>
<!--Modal Opérations -->
@foreach($operations as $operation)
<div class="modal bg-blue3 txt-gl4" id="modal-operation-{{ $operation->id }}" data-ax="modal">
    <div class="modal-header d-flex">
        <div class="d-flex fx-col">
            <p>Opération</p>

        </div>
        <p class="ml-auto">{{ $operation->operationList->name }}</p>
        <button data-target="modal-intervention-date" class="modal-trigger">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('modifyOperation', ['id' => $operation->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs2">
                <div class="form-field">
                    <input type="text" name="start_operation_time" class="form-control rounded-1" value="{{ $operation->start_operation_time }}" />
                    <label>Date début</label>
                    <span class="form-helper txt-orange font-w600">Format de la date: Année-Mois-Jour Heure:Minute:Seconde</span>
                    <span class="form-helper txt-orange">Exemple : 8 Juin 2021 09:30:25 = 2021-06-08 09:30:25</span>
                </div>
                <div class="form-field">
                    <input type="text" name="end_operation_time" class="form-control rounded-1" value="{{ $operation->end_operation_time }}" />
                    <label>Date fin</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
        <p class="txt-gl4">Pieces</p>
        @foreach($operation->pieces as $piece)
        <form class="form-material" method="POST" action="{{ route('modifyPiece', ['id' => $piece->id ]) }}">
            @csrf
            @method('PUT')
            <div class="grix xs2">
                <input hidden name="piece_id" value="{{ $piece->id }}" />
                <div class="form-field">
                    <input readonly class="form-control rounded-1" value="{{ $piece->pieceList->name }}" />
                    <label>Nom de la pièce</label>
                </div>
                <div class="form-field">
                    <input type="text" name="qte" class="form-control rounded-1" value="{{ $piece->qte }}" />
                    <label>Quantité</label>
                </div>
            </div>
            <button type="submit" class="btn d-block mx-auto orange txt-white">Modifier</button>
        </form>
        @endforeach
    </div>
</div>
<!-- Modal Pieces -->
<div class="modal white" id="modal-piece-{{ $operation->id }}" data-ax="modal">
    <div class="modal-header">
        Nouvelle pièce
    </div>
    <div class="modal-content">
        <form class="form-material" method="POST" action="{{ route('addPiece', ['id' => $operation->id ]) }}">
            @csrf
            <div class="grix xs1">
                <div class="form-field">
                    <input type="text" name="test" id="filterPieces" class="form-control rounded-1" />
                    <label>Filtre</label>
                </div>
                <div class="form-field">
                    <label>Choisir une pièce</label>
                    <select class="form-control rounded-1" id="piece_id" name="piece_id">

                        <!-- @foreach($piecesList as $piece)
                        <option value="{{ $piece->id }}">{{ $piece->name }}</option>
                        @endforeach -->
                    </select>
                </div>
                <div class="form-field">
                    <input type="number" name="qte" class="form-control rounded-1" />
                    <label>Quantité</label>
                </div>
            </div>
            <button type="submit" class="btn orange txt-white">Valider</button>
        </form>
    </div>
</div>
@endforeach
<!-- FIN  MODALS -->
@endsection

@section('extra-js')

<script>
    let piecesList = <?php echo (json_encode($piecesList)); ?>;
    let input = document.getElementById('filterPieces');
    let select = document.getElementById('piece_id');

    input.addEventListener('change', () => {
        let filteredEvents = piecesList.filter(function(e) {
            return e.ref.includes(input.value);
        });
        console.log(filteredEvents);

        if (select.childElementCount >= 1) {
            for (i = select.childElementCount; i >= 0; i--) {
                select.remove(i);
            }
        }

        for (const elem of filteredEvents) {
            select.add(new Option(elem.name, elem.id));
        }
    });
</script>


<script>
    let toast = new Axentix.Toast();
</script>


@if($errors->has('start_intervention_time') || $errors->has('end_intervention_time')
|| $errors->has('start_date') || $errors->has('end_date')
|| $errors->has('start_move_begin') || $errors->has('end_move_begin')
|| $errors->has('start_move_return') || $errors->has('end_move_return')
|| $errors->has('start_operation_time') || $errors->has('end_operation_time'))

<script>
    toast.change('ERREUR: Vous ne respectez pas le format Année-Mois-Jour H:min:s', {
        classes: "rounded-1 red dark-2 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif

@if($errors->has('km_vehicule'))
<script>
    toast.change('ERREUR: Le kilométrage doit être un nombre', {
        classes: "rounded-1 red dark-2 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif

@if(session('toast') == 'notEnoughQte')
<script>
    toast.change('Pas assez de pièces en stock', {
        classes: "rounded-1 red dark-2 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection