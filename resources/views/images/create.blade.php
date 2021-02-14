@extends('layouts.app')

@section('content')
<p>TEST</p>
<div class="container">
    <div class="container">
        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data" class="form-material container txt-greyy">
            @csrf
            <!-- <div class="form-field">
                <input required type="text" name="ref" class="form-control txt-greyy"></input>
                <label for="ref">Référence</label>
            </div>
            <div class="form-field">
                <input required type="text" name="name" class="form-control txt-greyy"></input>
                <label for="name">Nom</label>
            </div>
            <div class="form-field">
                <input required type="number" name="qte" class="form-control txt-greyy"></input>
                <label for="qte">Qte</label>
            </div> -->
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