@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <p class="txt-gl4 txt-center h5 mt-5">Liste des Interventions</p>
    <div class="container shadow-1 rounded-2 mt-5">
        <div class="responsive-table bg-blue3 txt-gl4 rounded-2">
            <table class="table striped">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Créateur</th>
                        <th class="txt-center">Date de création</th>
                        <th class="txt-center">Immatriculation</th>
                        @if(Auth()->user()->role)
                        <th class="txt-center">Facture</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                    <tr>
                        <td class="txt-center txt-white <?php echo ('state-' . $intervention->state) ?>">{{ $intervention->id }}</td>
                        <td class="txt-center">{{ $intervention->created_by }}</td>
                        <td class="txt-center">{{ $intervention->created_at }}</td>

                        <td class="txt-center">@if(!empty($intervention->vehicule_id)){{ $intervention->vehiculeList->license_plate }} @endif</td>
                        @if(Auth()->user()->role)
                        <td class="txt-center">
                            <a class="btn circle blue dark-1 txt-white push" href="{{route('exportPDF', ['id' => $intervention->id])}}"><i class="fas fa-file-pdf"></i></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>

            </table>
            @if(empty($intervention))
            <p class="txt-center txt-orange txt-dark-1">Aucune intervention à rejoindre</p>
            @endif
        </div>
    </div>
    <div class="d-flex fx-center mt-3">{{ $interventions->links('pagination') }}</div>

</div>
@endsection