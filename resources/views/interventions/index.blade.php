@extends('layouts.app')
@section('extra-css')
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <p class="txt-white txt-center h5 mt-5">Liste des Interventions</p>
    <div class="container shadow-1 rounded-2 mt-5">
        <div class="responsive-table grey light-4 rounded-2">
            <table class="table striped">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Créateur</th>
                        <th class="txt-center">Date de création</th>
                        <th class="txt-center">Immatriculation</th>
                        <th class="txt-center">Rejoindre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                    <tr>
                        <td class="txt-center txt-white <?php echo ('state-' . $intervention->state) ?>">{{ $intervention->id }}</td>
                        <td class="txt-center">{{ $intervention->created_by }}</td>
                        <td class="txt-center">{{ $intervention->created_at }}</td>

                        <td class="txt-center">@if(!empty($intervention->vehicule_id)){{ $intervention->vehiculeList->immat }} @endif</td>
                        <td class="txt-center">
                            <a class="btn circle orange dark-1 txt-white push" href="{{route('interventions.edit', ['intervention' => $intervention->id])}}"><i class="fas fa-pen"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            @if(empty($intervention))
            <p class="txt-center txt-orange txt-dark-1">Aucune intervention à rejoindre</p>
            @endif
        </div>
    </div>
</div>
@endsection