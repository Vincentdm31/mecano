@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container shadow-1 grix xs1 md3 mt-5">
        <div class="p-3">
            <p id="name">Nom : {{ $pieceList->name }}</p>
            <p id="ref">Ref : {{ $pieceList->ref }}</p>
            <p>Prix : {{ $pieceList->price }} €/u</p>
            <p>Quantité : {{ $pieceList->qte }}</p>
        </div>
        <img src="{{ asset('storage/images/'.$pieceList->path) }}" id="imgPiece" class="responsive-media p-3">
        di
        <button id="btn" class="btn blue dark-2" onclick="PrintElem(btn)">Imprimer</button>
    </div>

</div>

@endsection

@section('extra-js')
<script>
    function PrintElem(elem) {
        let path = document.getElementById('imgPiece').src;
        let name = document.getElementById('name').innerHTML;
        let ref = document.getElementById('ref').innerHTML;

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + name + '</h1>');
        mywindow.document.write('<h1>' + ref + '</h1>');
        mywindow.document.write('<img src="' + path + '">');
        mywindow.document.write('</body></html>');

        mywindow.document.close();
        mywindow.print();

        return true;
    }
</script>

@endsection