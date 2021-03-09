@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container d-flex h100 mt-5">
        <div class="container card my-auto mx-auto shadow-2">
            <div class="card-header dark txt-white">
                <div class="grix xs1 md2">
                    <div>
                        <p id="name">Nom: {{ $pieceList->name }}</p>
                        <p id="ref">Référence: {{ $pieceList->ref }}</p>
                    </div>
                    <div class="mx-auto">
                        <p>Prix : {{ $pieceList->price }} €/u</p>
                        <p>Stock disponible : {{ $pieceList->qte }}</p>
                    </div>
                </div>


            </div>
            <div class="card-content d-flex fx-col">
                <img src="{{ asset('storage/images/'.$pieceList->path) }}" id="imgPiece" class="responsive-media mx-auto p-3">
                <button id="btn" class="btn orange dark-1 txt-white large mx-auto dark-2 mt-5" onclick="PrintElem(btn)">Imprimer</button>
            </div>

        </div>
    </div>

</div>
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