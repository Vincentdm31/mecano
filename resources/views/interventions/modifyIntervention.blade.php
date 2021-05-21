@extends('layouts.facture')
@section('extra-css')
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')

<?php

use Carbon\Carbon;

?>

<div class="mx-3 grix xs1 md3 gutter-md6 mt-4">
    <div class="bg-blue3 p-2">
        <form class="form-material">
            <div class="grix xs1 sm2">
                <div class="form-field">
                    <input class="form-control rounded-1" value="{{ $intervention->id }}" readonly />
                    <label for="email">Intervention n°</label>
                </div>
                <div class="form-field">
                    <input type="text" class="form-control rounded-1" value="{{ $intervention->created_by }}" readonly />
                    <label for="email">Crée par</label>
                </div>
                <div class="form-field">
                    <input type="text"  class="form-control rounded-1" value="{{ Carbon::parse($intervention->start_intervention_time) }} " readonly />
                    <label for="email">Crée le</label>
                </div>
                <div class="form-field">
                    <input type="text"  class="form-control rounded-1" value="{{ Carbon::parse($intervention->end_intervention_time)->format('d/m/Y  Hms') }} " readonly />
                    <label for="email">Terminée le</label>
                </div>
            </div>
        </form>
    </div>
    <div class="red">
        <p>toto</p>
    </div>
    <div class="green">
        <p>toto</p>
    </div>
</div>

@endsection