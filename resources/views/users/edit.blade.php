@extends('layouts.app')

@section('content')
<div class="container h100 d-flex fx-center">
    <div class="card vself-center bg-blue3 shadow-1 rounded-1 p-4">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="txt-white pb-2">Edition utilisateur</p>
        </div>
        <div class="card-content p-0 pl-3 pr-3">
            <form class="form-material" method="POST" action="{{route('users.update', ['user' => $user->id])}}">
                @method('PUT')
                @csrf
                <div class="d-flex fx-col txt-white">
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" />
                        <label for="name">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="email" name="email" class="form-control" value="{{$user->email}}" />
                        <label for="email">Email</label>
                    </div>
                    <div class="form-field">
                        <label for="role">Rôle</label>
                        <select id="role" name="role" class="form-control txt-center" value="{{$user->role}}">
                            <option <?php echo $user->role == 0 ? 'selected' : '' ?> class="txt-dark" value="0">Mécanicien</option>
                            <option <?php echo $user->role == 1 ? 'selected' : '' ?> class="txt-dark" value="1">Magasinier</option>
                            @if(Auth()->user()->role > 3)
                            <option <?php echo $user->role == 2 ? 'selected' : '' ?> class="txt-dark" value="2">Facturation</option>
                            <option <?php echo $user->role == 3 ? 'selected' : '' ?> class="txt-dark" value="3">Admin</option>
                            <option <?php echo $user->role == 4 ? 'selected' : '' ?> class="txt-dark" value="4">Root</option>
                            @endif
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