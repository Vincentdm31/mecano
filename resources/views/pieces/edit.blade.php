@extends('layouts.app')

@section('content')
<div class="container grix xs1 sm3 mt-5">
    <div class="card pos-sm2 shadow-1 rounded-1">
        <div class="p-0 pl-4 pr-4 pt-1">
            <p class="bd-b-solid bd-orange bd-3 pb-2 h5">Editer pièce</p>
        </div>
        <div class="card-content">
            <form class="form-material" method="POST" action="{{route('piecesList.update', ['piecesList' => $pieceList->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control" value="{{$pieceList->name}}" />
                        <label for="name">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="ref" name="ref" class="form-control" value="{{$pieceList->ref}}" />
                        <label for="ref">Référence</label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="qte" name="qte" class="form-control" value="{{$pieceList->qte}}" />
                        <label for="qte">Quantité</label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="price" name="price" class="form-control" value="{{$pieceList->qte}}" />
                        <label for="price">Prix</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn orange dark-1 txt-white rounded-1 mt-5">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('extra-js')
<script>
    let toast = new Axentix.Toast();
</script>
@if(session('toast') == 'errorDuplicate')
<script>
    toast.change('Nom ou référence déjà utilisé', {
        classes: "rounded-1 red dark-1 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection