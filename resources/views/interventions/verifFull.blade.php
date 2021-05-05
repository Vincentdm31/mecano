@extends('layouts.facture')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <p class="txt-airforce txt-dark-4 txt-center h5 mt-2">Liste des Interventions terminées</p>
    <div class="container">
            <form class="form-material" method="GET" action="searchInterventionFull">
                @csrf
                <div class="grix xs3">
                    <div class="form-field pos-xs1 col-xs2">
                        <input type="text" name="searchInterventionFull" id="searchInterventionFull" class="form-control" />
                        <label for="searchInterventionFull">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4 small"><i class="fa fa-search"></i></button>
                </div>
            </form>
    </div>
    <div class="container shadow-1 rounded-2 mt-2">
        <div class="responsive-table white rounded-2">
            <table class="table striped">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Créateur</th>
                        <th class="txt-center">Date de création</th>
                        <th class="txt-center">Immatriculation</th>
                        <th class="txt-center">Facture</th>
                        <th class="txt-center">Verification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                    <tr>
                        <td class="<?php echo( ($intervention->state_verif == 'checking') ?  'orange': (($intervention->state_verif == 'checked') ?  'green' : '')) ?> txt-center txt-airforce txt-dark-4">{{ $intervention->id }}</td>
                        <td class="txt-center">{{ $intervention->created_by }}</td>
                        <td class="txt-center">{{ $intervention->created_at }}</td>

                        <td class="txt-center">@if(!empty($intervention->vehicule_id)){{ $intervention->vehiculeList->license_plate }} @endif</td>

                        <td class="txt-center">
                            <a class="btn circle blue dark-1 txt-white push" href="{{route('exportPDF', ['id' => $intervention->id])}}"><i class="fas fa-file-pdf"></i></a>
                        </td>
                        <td class="txt-center">
                            <form class="form-material container" method="POST" action="{{ route('validateVerif',  ['id' => $intervention->id])}}">
                                @csrf
                                <button type="submit" class="btn circle blue dark-1 txt-white push"><i class="fas fa-check"></i></a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(empty($intervention))
            <p class="txt-center txt-orange txt-dark-1">Aucune intervention terminée</p>
            @endif
        </div>
    </div>
    <div class="d-flex fx-center mt-3">{{ $interventions->links('pagination') }}</div>

</div>
@endsection