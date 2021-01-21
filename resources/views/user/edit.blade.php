@extends('layouts.app')

@section('content')
<div class="container grix xs1 sm3">
    <div class="card pos-sm2">
        <div class="card-content">
            <form class="form-material" method="POST" action="{{route('users.update', ['user' => $user->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control txt-center" value="{{$user->name}}" />
                        <label for="name">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="email" name="email" class="form-control txt-center" value="{{$user->email}}" />
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
                    <button type="submit" class="btn airforce dark-4 mt-5">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
