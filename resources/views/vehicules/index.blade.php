@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('vehicules.create') }}" class="btn rounded-1 airforce dark-4">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class ="form-material" method="GET" action="searchVehicule">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchVehicule" id="searchVehicule"class="form-control" />
                        <label for="searchVehicule">Rechercher</label>
                    </div>
                    <button type ="submit" class="btn circle search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="grix xs1 mt-5 sm3 gutter-xs5">
        @foreach($vehicules as $vehicule)
        <div class="card shadow-1 rounded-2">
            <div class="card-header">
                {{$vehicule->id}}
            </div>
            <div class="card-content">
               <p>{{$vehicule->marque}}</p>
               <p>{{$vehicule->modele}}</p>
               <p>{{$vehicule->immat}}</p>
            </div>
            <div class="card-footer">
                <div class="flex grix xs2 gutter-xs0 center ">
                    <a class="btn circle airforce dark-4 txt-white push" href="{{route('vehicules.edit', ['vehicule' => $vehicule->id])}}"><i class="fas fa-pen"></i></a>
                    <div class="mx-auto">
                        <form method="POST" action="{{route('vehicules.destroy', ['vehicule' => $vehicule->id])}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle airforce dark-4 txt-white push"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection
