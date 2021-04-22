@extends('layouts.app')

@section('content')
<div class="container h100 d-flex fx-center">

    <div class="vself-center p-4 dark rounded-2">
        <p class="bd-b-solid bd-orange bd-3 pb-2 h5 txt-white">Nouvelle pièce</p>

        <form action="{{ route('piecesList.store') }}" method="POST" class="form-material txt-white txt-dark-4">
            @csrf
            <div class="grix xs2">
                <div class="form-field col-xs2">
                    <input required type="text" name="name" class="form-control txt-white txt-dark-4"></input>
                    <label for="name">Nom</label>
                </div>
                <div class="form-field col-xs2">
                    <input required type="text" name="ref" class="form-control txt-white txt-dark-4"></input>
                    <label for="ref">Référence</label>
                </div>
                <div class="form-field">
                    <input required type="number" name="qte" class="form-control txt-white txt-dark-4"></input>
                    <label for="qte">Qte</label>
                </div>
                <div class="form-field">
                    <input required type="number" name="price" class="form-control txt-white txt-dark-4"></input>
                    <label for="price">Prix</label>
                </div>
            </div>

            <div class="txt-center">
                <button type="submit" class="btn shadow-1 txt-white rounded-1 orange mt-4">Valider</button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    let toast = new Axentix.Toast();
</script>
@if(session('toast') == 'errorDuplicate')
<script>
    toast.change('Nom ou Référence déjà utilisé</br> Veuillez réessayer', {
        classes: "rounded-1 red dark-1 shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection