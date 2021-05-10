@extends('layouts.facture')

@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now()->format('d/m/Y');

?>

<div class="dark m-0 h100 txt-gl4 p-5">
  <form class="form-material" method="POST" action="{{ route('editInvoice',['id'=> $intervention->id]) }}">
    @csrf
    <div class="grix xs1 md3 gutter-xs3">
      <div>
        <div class="form-field">
          <input type="text" class="form-control rounded-1" value="{{ $intervention->id}}" readonly />
          <label for="address">Intervention n°</label>
        </div>
        <div class="form-field">
          <input type="text" class="form-control rounded-1" value="{{Carbon::parse($intervention->created_at)->translatedFormat('d F Y à H\hi')}}" readonly></input>
          <label for="address">Date de l'intervention</label>
        </div>
        <div class="form-field">
          <input type="text" class="form-control rounded-1" value="{{ $intervention->vehiculeList->brand}}" readonly />
          <label for="address">Marque</label>
        </div>
        <div class="form-field">
          <input type="text" class="form-control rounded-1" value="{{ $intervention->vehiculeList->model}}" readonly />
          <label for="vehicle_model">Modèle</label>
        </div>
        <div class="form-field">
          <input type="text" class="form-control rounded-1" value="{{ $intervention->vehiculeList->license_plate}}" readonly />
          <label for="vehicle_license_plate">Immatriculation</label>
        </div>
        <div class="form-field">
          <input type="text" name="vehicle_km" class="form-control rounded-1" value="{{ $intervention->km_vehicule}}" />
          <label for="vehicle_km">Kilométrage</label>
        </div>
      </div>
      <div>
        <div class="form-field">
          <input type="text" name="client_name" class="form-control rounded-1" />
          <label for="address">Nom du client</label>
        </div>
        <div class="form-field">
          <input type="text" name="client_address" class="form-control rounded-1" />
          <label for="address">Adresse du client</label>
        </div>
        <div class="form-field">
          <textarea type="text" name="observations" class="form-control rounded-1">{{ $intervention->observations}}</textarea>
          <label for="observations">Observations générales</label>
        </div>
      </div>
    </div>
    <button type="submit" class="btn orange rounded-1">Générer la facture</button>
  </form>
</div>


@endsection

<!--  -->