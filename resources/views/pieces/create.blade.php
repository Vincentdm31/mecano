@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="container shadow-1 pb-3  rounded-2">
        <form action="{{ route('pieces.store') }}" enctype="multipart/form-data" method="POST" class="form-material container txt-airforce txt-dark-4">
            @csrf
            <div class="form-field">
                <input required type="text" name="name" class="form-control txt-airforce txt-dark-4"></input>
                <label for="name">Nom</label>
            </div>
            <div class="form-field">
                <input required type="text" name="ref" class="form-control txt-airforce txt-dark-4"></input>
                <label for="ref">Référence</label>
            </div>
            <div class="form-field">
                <input required type="number" name="qte" class="form-control txt-airforce txt-dark-4"></input>
                <label for="qte">Qte</label>
            </div>
            <div class="form-field">
                <input required type="number" name="price" class="form-control txt-airforce txt-dark-4"></input>
                <label for="price">Prix</label>
            </div>
            <div class="form-field">
                <input required type="file" name="img" class="form-control"></input>
            </div>
            <div class="txt-center">
                <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-4"><span class="outline-text outline-invert">Valider</span></button>
            </div>
        </form>
    </div>
</div>
@endsection