@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 container">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('pieces.create') }}" class="btn rounded-1 orange dark-1 txt-white">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchPiecesList">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchPiecesList" id="searchPiecesList" class="form-control" />
                        <label for="searchPiecesList">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>


    <!--  -->
    <div class="mt-5 shadow-1">
        <div class="responsive-table">
            <table class="table striped ">
                <thead>
                    <tr>
                        <th class="txt-center">#</th>
                        <th class="txt-center">Nom</th>
                        <th class="txt-center">Reférence</th>
                        <th class="txt-center">Quantité</th>
                        <th class="txt-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($piecesList as $pieceList)
                    <tr>
                        <td class="txt-center">{{ $pieceList->id }}</td>
                        <td class="txt-center">{{ $pieceList->name }}</td>
                        <td class="txt-center">{{ $pieceList->ref }}</td>
                        <td class="txt-center">{{ $pieceList->qte }}</td>
                        <td>
                            <div class="grix xs3 gutter-xs2">
                            <div class="ml-auto">
                                    <a class="btn circle blue dark-1 txt-white push" href="{{route('piecesList.show', ['piecesList' => $pieceList->id])}}"><i class="fas fa-eye"></i></a>
                                </div>
                                <div class="mx-auto">
                                    <a class="btn circle green dark-1 txt-white push" href="{{route('piecesList.edit', ['piecesList' => $pieceList->id])}}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{route('piecesList.destroy', ['piecesList' => $pieceList->id])}}">
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