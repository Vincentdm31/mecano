@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 container">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('vehicules.create') }}" class="btn rounded-1 orange dark-1 txt-white">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchVehicule">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchVehicule" id="searchVehicule" class="form-control" />
                        <label for="searchVehicule">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>


    <!--  -->
    <div class="container mt-5 shadow-1">
        <div class="responsive-table">
            <table class="table striped ">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Marque</th>
                        <th class="txt-center">Modèle</th>
                        <th class="txt-center">Immat</th>
                        <th class="txt-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    <tr>
                        <td class="txt-center">{{ $vehicule->id }}</td>
                        <td class="txt-center">{{ $vehicule->marque }}</td>
                        <td class="txt-center">{{ $vehicule->modele }}</td>
                        <td class="txt-center">{{ $vehicule->immat }}</td>
                        <td>
                            <div class="grix xs2 gutter-xs2">
                                <div class="ml-auto">
                                    <a class="btn circle blue dark-1 txt-white push" href="{{route('vehicules.edit', ['vehicule' => $vehicule->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('vehicules.destroy', ['vehicule' => $vehicule->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white push"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    let toast = new Axentix.Toast();
</script>

@if(session('toast') == 'vehiculeUpdate')
<script>
    toast.change('Véhicules mis à jour', {
        classes: "rounded-1 green dark-2 shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection