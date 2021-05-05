@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="container">
            <form class="form-material" method="GET" action="searchVehicule">
                @csrf
                <div class="grix xs3">
                    <div class="form-field pos-xs1 col-xs2">
                        <input type="text" name="searchVehicule" id="searchVehicule" class="form-control" />
                        <label for="searchVehicule">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4 small"><i class="fa fa-search"></i></button>
                </div>
            </form>
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
                        <th class="txt-center">Capacité</th>
                        <th class="txt-center">Catégorie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicules as $vehicule)
                    <tr class="txt-grey txt-light-4">
                        <td class="txt-center txt-orange">{{ $vehicule->id }}</td>
                        <td class="txt-center">{{ $vehicule->brand }}</td>
                        <td class="txt-center">{{ $vehicule->model }}</td>
                        <td class="txt-center">{{ $vehicule->license_plate }}</td>
                        <td class="txt-center">{{ $vehicule->capacity }}</td>
                        <td class="txt-center">{{ $vehicule->category }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex fx-center mt-3">{{ $vehicules->links('pagination') }}</div>

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