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

    <div class="container mt-5 shadow-1 rounded-2">
        <div class="responsive-table rounded-2 dark">
            <table class="table striped centered">
                <thead class="txt-grey txt-light-4">
                    <tr class="txt-orange">
                        <th class="txt-center txt-white">#</th>
                        <th class="txt-center">Marque</th>
                        <th class="txt-center">Modèle</th>
                        <th class="txt-center">Immat</th>
                        <th class="txt-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    <tr class="txt-grey txt-light-4">
                        <td class="txt-center txt-orange">{{ $vehicule->id }}</td>
                        <td class="txt-center">{{ $vehicule->brand }}</td>
                        <td class="txt-center">{{ $vehicule->model }}</td>
                        <td class="txt-center">{{ $vehicule->license_plate }}</td>
                        <td>
                            <div class="grix xs2 gutter-xs2">
                                <div class="ml-auto">
                                    <a class="btn circle blue dark-1 txt-white small" href="{{route('vehicules.edit', ['vehicule' => $vehicule->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('vehicules.destroy', ['vehicule' => $vehicule->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white small"><i class="fas fa-trash"></i></button>
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
    <div class="d-flex fx-center mt-5">{{ $vehicules->links('pagination') }}</div>

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