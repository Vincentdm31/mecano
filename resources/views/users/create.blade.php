@extends('layouts.app')
@section('pageTitle')
Add Car
@endsection
@section('content')
<div class="container h100 d-flex fx-center">
    <div class="card vself-center rounded-2 shadow-1 dark pl-4 pr-4">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="txt-white bd-3 pb-2">Nouvel utilisateur</p>
        </div>
        <div class="card-content pl-3 pr-3 p-0 txt-white">
            <form class="form-material" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="grix xs2 txt-center">
                    <div class="form-field col-xs2">
                        <input required type="text" id="name" name="name" class="form-control" />
                        <label for="name" class="">Nom</label>
                    </div>
                    <div class="form-field col-xs2">
                        <input required type="email" id="email" name="email" class="form-control" />
                        <label for="email" class="">Email</label>
                    </div>
                    <div class="form-field">
                        <input required id="password" name="password" class="form-control" />
                        <label for="password" class="">Password</label>
                    </div>
                    <div class="form-field">
                        <select required id="role" name="role" class="form-control">
                            <option value='0' class="txt-dark">Membre</option>
                            <option value='1' class="txt-dark">Magasinier</option>
                            @if(Auth()->user()->role == 3)
                            <option value='2' class="txt-dark">Admin</option>
                            <option value='3' class="txt-dark">Root</option>
                            @endif
                        </select>
                        <label for="role">Rôle</label>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn rounded-1 orange dark-1 txt-white mt-3 mb-3">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection