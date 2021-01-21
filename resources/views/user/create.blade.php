@extends('layouts.app')
@section('pageTitle')
Add Car
@endsection
@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="card rounded-1 shadow-1 pos-sm2">
            <div class="card-content">
                <form class="form-material" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="grix xs1 txt-center">
                        <div class="form-field">
                            <input required type="text" id="name" name="name" class="form-control txt-center" />
                            <label for="name" class="">Nom</label>
                        </div>
                        <div class="form-field">
                            <input required type="email" id="email" name="email" class="form-control txt-center" />
                            <label for="email" class="">Email</label>
                        </div>
                        <div class="form-field">
                            <input required id="password" name="password" class="form-control txt-center" />
                            <label for="password" class="">Password</label>
                        </div>
                        <div class="form-field">
                            <select  required id="is_admin" name="is_admin" class="form-control txt-center">
                                <option value="0">Membre</option>
                                <option value="1">Admin</option>
                            </select>
                            <label for="is_admin">Rôle</label>
                        </div> 
                    </div>
                    <div class="txt-center">
                        <button type="submit" class="btn rounded-1 airforce dark-4 mt-5">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


