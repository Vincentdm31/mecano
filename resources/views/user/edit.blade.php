@extends('layouts.app')

@section('content')

<h1 class="flex fx-center txt-airforce txt-dark-3"></h1>
<div class="container edit-car">
    <div class="card">
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
                <button type="submit" class="btn press mx-auto edit-button mt-5">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
    
@endsection
