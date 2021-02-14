@extends('layouts.app')

@section('content')
<p>TEST</p>
<div class="container">
    <div class="container">
        <form action="{{ route('upload.store') }}" enctype="multipart/form-data" method="POST" class="form-material container txt-greyy">
            @csrf
            <!-- <div class="form-field">
                <input required type="text" name="ref" class="form-control txt-greyy"></input>
                <label for="ref">Référence</label>
            </div>
            <div class="form-field">
                <input required type="text" name="name" class="form-control txt-greyy"></input>
                <label for="name">Nom</label>
            </div> -->
            <!-- <div class="form-field">
                <input required type="text" name="path" class="form-control txt-greyy"></input>
                <label for="path">Qte</label>
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