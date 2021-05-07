@extends('layouts.app')
@include('components.fab')
@include('components.modals.modal-recap')
@include('components.modals.modal-comment')
@include('components.modals.modal-operation')
@include('components.modals.modal-end-deplacement')
@include('components.modals.modal-help')
@include('components.modals.modal-km-vehicle')
@include('components.operation-list')
@section('extra-css')
<link href="{{ mix('css/qrcode.css') }}" rel="stylesheet">
<link href="{{ mix('css/intervention.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>


<div class="container">
    <div class="d-flex fx-row fx-center txt-center mt-3 mb-3">
        <button data-target="modal-recap" class="btn mr-3 rounded-1 txt-white shadow-1 orange dark-1 modal-trigger small">
            Récapitulatif
        </button>
        @if(Auth()->user()->name != $intervention->created_by)
            <a href="{{route('leaveIntervention', ['intervention' => $intervention->id])}}" class="btn small rounded-1 txt-white shadow-1 red dark-1">
                Quitter
            </a>
        @endif
    </div>
</div>

@yield('operation-list')

@yield('fab')

@yield('modal-recap')

@foreach( $intervention->operations as $operation)
<div class="modal white shadow-1 p-4 rounded-2" id="edit-operation-{{ $operation->id }}" data-ax="modal">
    <form class="form-material" method="POST" action="{{ route('operations.update', ['operation' => $operation->id]) }}">
        @method('PUT')
        @csrf
        <div class="grix xs1 txt-center">
            <input name="intervention_id" hidden value="{{ $intervention->id }}"></input>
            <div class="form-field">
                <textarea type="text" id="op_comment" name="op_comment" class="form-control txt-airforce txt-dark-4">{{ $operation->op_comment}}</textarea>
                <label for="op_comment" class="">Observations</label>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Envoyer</span></button>
        </div>
    </form>
</div>

<!-- Modal pièces -->
<div class="modal white shadow-1 p-4 rounded-2" id="add-piece-operation-{{ $operation->id }}" data-ax="modal">
    <div class="d-flex my-auto mx-auto w100 ">
        <form class="form-material w100" method="POST" action="{{ route('pieces.store') }}">
            @csrf
            <div class="txt-center">
                <a id="btn-scan-qr" class="btn rounded-1 shadow-1 orange dark-1 txt-white">SCAN</a>
                <a id="btn-stop-qr" class="btn rounded-1 shadow-1 orange dark-1 txt-white hide">STOP</a>
            </div>
            <canvas hidden="" id="qr-canvas"></canvas>
            <div id="qr-result" hidden="">
                <b>Data:</b> <span id="outputData"></span>
            </div>

            <div class="form-field">
                <input required type="text" id="qr-code-result" name="pieceref" class="form-control txt-airforce txt-dark-4"></input>
                <label for="pieceref">Pièce</label>
            </div>
            <div class="form-field">
                <input required type="number" name="qte" class="form-control txt-airforce txt-dark-4"></input>
                <label for="qte">Quantité</label>
            </div>
            <input hidden name="interventionId" value="{{ $intervention->id }}">
            <input hidden name="operationId" value="{{ $operation->id }}">
            <div class="txt-center">
                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
            </div>
        </form>
    </div>
</div>
@endforeach

@yield('modal-km-vehicle')
@yield('modal-end-deplacement')
@yield('modal-comment')
@yield('modal-operation')
@yield('modal-help')

@endsection

@section('extra-js')

<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script type="text/javascript" src="{{ mix('js/qrCodeScanner.js') }}"></script>

<script>
    let toast = new Axentix.Toast();
</script>

@if(session('toast') == 'notEnoughQte')
<script>
    toast.change('Pas assez de pièces <?php echo ('<br/> Stock dispo : ' . request()->pieceQte) ?>', {
        classes: "rounded-1 red dark-2 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@elseif(session('toast') == 'pieceStore')
<script>
    toast.change('Pièce ajoutée', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'removepiece')
<script>
    toast.change('Pièce supprimée', {
        classes: "rounded-1 red dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'comment')
<script>
    toast.change('Commentaire ajouté', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'addOperation')
<script>
    toast.change('Opération ajoutée', {
        classes: "rounded-1 green  dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'editOperation')
<script>
    toast.change('Opération modifiée', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'update')
<script>
    toast.change('Intervention mise à jour', {
        classes: "rounded-1 green dark-2 txt-white shadow-2"
    });
    toast.show();
</script>
@elseif(session('error') == 'restrictAccess')
<script>
    toast.change('Vous n\'avez pas accès à cette page', {
        classes: "rounded-1 red dark-2 txt-white shadow-2"
    });
    toast.show();
</script>

@endif
<script>
    let fab = document.getElementById('fab');
    let fabOverlay = document.getElementById('fab-overlay');
    let overlay = false;
    let check = false;

    fab.addEventListener('click', function(event) {
        fabOverlay.classList.add('active');
        setTimeout(() => {
            overlay = true;
        }, 200);
    });

    window.onclick = function(e) {
        if (overlay && !e.target.classList.contains('fab-checker')) {
            fabOverlay.classList.remove('active');
            overlay = false;
        }
    }
</script>
@endsection