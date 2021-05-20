@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <div class="grix xs1 sm3 container">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('piecesList.create') }}" class="btn rounded-1 orange dark-1 txt-white small">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchPiecesList">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchPiecesList" id="searchPiecesList" class="form-control txt-gl4" />
                        <label for="searchPiecesList">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4 small"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 container bg-blue3 shadow-2 rounded-2">
        <div class="responsive-table rounded-2">
            <table class="table striped centered">
                <thead class="txt-white">
                    <tr class="txt-orange">
                        <th class="txt-center txt-white">#</th>
                        <th class="txt-center">Nom</th>
                        <th class="txt-center">Reférence</th>
                        <th class="txt-center">Localisation</th>
                        <th class="txt-center">Quantité</th>
                        <th class="txt-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($piecesList as $pieceList)
                    <tr class="txt-white">
                        <td class="txt-center txt-orange">{{ $pieceList->id }}</td>
                        <td class="txt-center">{{ $pieceList->name }}</td>
                        <td class="txt-center">{{ $pieceList->ref }}</td>
                        <td class="txt-center">{{ $pieceList->localisation }}</td>
                        <td class="txt-center">{{ $pieceList->qte }}</td>
                        <td>
                            <div class="grix xs3 gutter-xs2">
                                <div class="ml-auto">
                                    <a class="btn circle blue dark-1 txt-white small" href="{{route('piecesList.show', ['piecesList' => $pieceList->id])}}"><i class="fas fa-eye"></i></a>
                                </div>
                                <div class="mx-auto">
                                    <a class="btn circle orange dark-1 txt-white small" href="{{route('piecesList.edit', ['piecesList' => $pieceList->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div class="mr-auto">
                                    <form method="POST" action="{{route('piecesList.destroy', ['piecesList' => $pieceList->id])}}">
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
    <div class="d-flex fx-center mt-3">{{ $piecesList->links('pagination') }}</div>
</div>
@endsection

@section('extra-js')
<script>
    let toast = new Axentix.Toast();
</script>
@if(session('toast') == 'editSuccess')
<script>
    toast.change('Pièce éditée avec succés', {
        classes: "rounded-1 green dark-1 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@elseif(session('toast') == 'deleteSuccess')
<script>
    toast.change('Pièce supprimée avec succés', {
        classes: "rounded-1 red dark-1 txt-white shadow-2 mt-5"
    });
    toast.show();
</script>
@endif
@endsection