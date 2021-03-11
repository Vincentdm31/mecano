@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container">
        <div class="card grey light-4 my-auto mx-auto shadow-2 rounded-2">
            <div class="grix xs1 md2">
                <div class="p-4">
                    <div>
                        <p class="m-0 txt-airforce txt-dark-4 font-s3">Nom</p>
                        <em class="m-0 txt-airforce txt-dark-4 font-s2" id="name">{{ $pieceList->name }}</em>
                    </div>
                    <div class="mt-3">
                        <p class="m-0 txt-airforce txt-dark-4 font-s3">Référence</p>
                        <em class="m-0 txt-airforce txt-dark-4 font-s2" id="ref">{{ $pieceList->ref }}</em>
                    </div>
                    <div class="mt-3">
                        <p class="m-0 txt-airforce txt-dark-4 font-s3">Stock</p>
                        <em class="m-0 txt-airforce txt-dark-4 font-s2" id="ref">{{ $pieceList->qte }}</em>
                    </div>
                    <div class="mt-3">
                        <p class="m-0 txt-airforce txt-dark-4 font-s3">Prix</p>
                        <em class="m-0 txt-airforce txt-dark-4 font-s2" id="ref">{{ $pieceList->price }} €/u</em>
                    </div>
                </div>
                <div class="d-flex fx-col">
                    <img src="{{ asset('storage/images/'.$pieceList->path) }}" id="imgPiece" class="responsive-media p-3 mx-auto">
                    <button id="btn" class="btn orange dark-1 txt-white mx-auto dark-2 mt-2 mb-2 rounded-2" onclick="PrintElem(btn)">Imprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    let toast = new Axentix.Toast();
</script>
@if(session('toast') == 'addSuccess')
<script>
    toast.change('Pièce enregistrée avec succés', {
        classes: "rounded-1 green dark-1 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
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
