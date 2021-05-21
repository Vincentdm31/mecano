@extends('layouts.facture')

@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now()->format('d/m/Y');

?>

<div class="bg-blue m-0 h100 txt-gl4 p-5">
  <form class="form-material" method="POST" action="{{ route('editInvoice',['id'=> $intervention->id]) }}">
    @csrf
    <p>EDIT</p>
  </form>
</div>

@endsection