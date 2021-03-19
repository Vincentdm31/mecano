@extends('layouts.app')
@section('pageTitle')
Add Car
@endsection
@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="card rounded-2 shadow-1 pos-sm2">
            <div class="card-header pl-3 pr-3 p-0">
                <p class="bd-b-solid bd-orange bd-3 pb-2">Nouvel utilisateur</p>
            </div>
            <div class="card-content pl-3 pr-3 p-0">
                <form class="form-material" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="grix xs1 txt-center">
                        <div class="form-field">
                            <input required type="text" id="name" name="name" class="form-control" />
                            <label for="name" class="">Nom</label>
                        </div>
                        <div class="form-field">
                            <input required type="email" id="email" name="email" class="form-control" />
                            <label for="email" class="">Email</label>
                        </div>
                        <div class="form-field">
                            <input required id="password" name="password" class="form-control" />
                            <label for="password" class="">Password</label>
                        </div>
                        <div class="form-field">
                            <select required id="is_admin" name="is_admin" class="form-control">
                                <option <?php 'value="0"' ?>>Membre</option>
                                <option <?php 'value="1"' ?>>Magasinier</option>
                                @if(Auth()->user()->is_admin == 3)
                                <option <?php 'value="2"' ?>>Admin</option>
                                <option <?php 'value="3"' ?>>Root</option>
                                @endif
                            </select>
                            <label for="is_admin">Rôle</label>
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