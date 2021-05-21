@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="container">
        <p class="txt-gl4 font-s8 mt-5">Liste des interventions terminées</p>
        <form class="form-material ml-2" method="GET" action="searchIntervention">
            @csrf
            <div class="grix xs3">
                <div class="form-field pos-xs1 col-xs2">
                    <input type="text" name="searchIntervention" id="searchIntervention" class="form-control txt-gl4" />
                    <label for="searchIntervention">Rechercher</label>
                </div>
                <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4 small"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
    <div class="container shadow-1 rounded-2 mt-2">
        <div class="responsive-table bg-blue3 rounded-2">
            <table class="table striped">
                <thead>
                    <tr class="txt-gl4">
                        <th class="txt-center">#</th>
                        <th class="txt-center">Créateur</th>
                        <th class="txt-center">Date de création</th>
                        <th class="txt-center">Immatriculation</th>
                        <th class="txt-center">Facture</th>
                        <th class="txt-center">Verification</th>
                        <th class="txt-center">Correction</th>
                        <th class="txt-center">Informations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                    <tr class="txt-gl4">
                        <td class="<?php echo (($intervention->state_verif == 'checking') ?  'orange' : (($intervention->state_verif == 'checked') ?  'green' : '')) ?> txt-center">{{ $intervention->id }}</td>
                        <td class="txt-center">{{ $intervention->created_by }}</td>
                        <td class="txt-center">{{ $intervention->created_at }}</td>

                        <td class="txt-center">@if(!empty($intervention->vehicule_id)){{ $intervention->vehiculeList->license_plate }} @endif</td>

                        <td class="txt-center">
                            <a class="btn circle blue dark-1 txt-white" href="{{route('exportPDF', ['id' => $intervention->id])}}"><i class="fas fa-file-pdf"></i></a>
                        </td>
                        <td class="txt-center">
                            <form class="form-material container" method="POST" action="{{ route('sendVerif',  ['id' => $intervention->id])}}">
                                @csrf
                                <button type="submit" class="btn circle blue dark-1 txt-white"><i class="fas fa-check"></i></a>
                            </form>
                        </td>
                        <td class="txt-center">
                            <form class="form-material container" method="GET" action="{{ route('invoice.edit',  ['invoice' => $intervention->id])}}">
                                @csrf
                                <button type="submit" class="btn circle blue dark-1 txt-white"><i class="fas fa-edit"></i></a>
                            </form>
                        </td>
                        <td>
                            <button data-target="modal-infos-{{ $intervention->id }}" class="btn blue circle mx-auto d-block modal-trigger"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @foreach($interventions as $intervention)
            <div class="modal shadow-1 rounded-1 bg-blue3" id="modal-infos-{{ $intervention->id }}" data-ax="modal">
                <div class="modal-header txt-gl4">
                    <div class="d-flex">
                        <p>Intervention n° {{ $intervention->id}}</p>
                        <p class="ml-auto">{{ $intervention->vehiculeList->license_plate }}</p>
                    </div>
                </div>
                <div class="modal-content txt-gl4">
                    @foreach($intervention->operations as $operation)
                    <p>{{ $operation->operationList->name }}</p>
                    @foreach($operation->pieces as $piece)
                    <li class=><span class="mr-3">x{{ $piece->qte }}</span> {{ $piece->pieceList->name }}</li>
                    @endforeach
                    @endforeach
                </div>
            </div>
            @endforeach

            @if(empty($intervention))
            <p class="txt-center txt-orange txt-dark-1">Aucune intervention terminée</p>
            @endif
        </div>
    </div>
    <div class="d-flex fx-center mt-3">{{ $interventions->links('pagination') }}</div>
</div>
@endsection