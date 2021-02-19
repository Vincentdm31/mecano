@extends('layouts.app')

@section('content')
<div class="container grix xs1 sm3 mt-5">
    <div class="card pos-sm2 shadow-1 rounded-1">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="bd-b-solid bd-orange bd-3 pb-2">Edition utilisateur</p>
        </div>
        <div class="card-content p-0 pl-3 pr-3">
            <form class="form-material" method="POST" action="{{route('users.update', ['user' => $user->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" />
                        <label for="name">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="email" name="email" class="form-control" value="{{$user->email}}" />
                        <label for="email">Email</label>
                    </div>
                    <div class="form-field">
                        <label for="is_admin">Rôle</label>
                        <select id="is_admin" name="is_admin" class="form-control txt-center" value="{{$user->is_admin}}">
                            <option <?php echo $user->is_admin == 1 ? 'selected' : '' ?> value="0">Membre</option>
                            <option <?php echo $user->is_admin == 1 ? 'selected' : '' ?> value="1">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn orange dark-1 txt-white rounded-1 mt-3 mb-3">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection