@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="grix xs1 sm3 container mb-5">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('operationsList.create') }}" class="btn rounded-1 orange dark-1 txt-white">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchOperationsList">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchOperationsList" id="searchOperationsList" class="form-control" />
                        <label for="searchOperationsList">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="container mt-5">
        <div class="responsive-table dark rounded-2">
            <table class="table striped centered">
                <thead>
                    <tr class="txt-orange">
                        <th class="txt-white">#</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operationsLists as $operationList)
                    <tr class="txt-white">
                        <td>{{ $operationList->id }}</td>
                        <td>{{ $operationList->name }}</td>
                        <td>
                            <div class="grix xs2">
                                <div>
                                    <a class="btn circle orange dark-1 txt-white small" href="{{ route('operationsList.edit', ['operationsList' => $operationList->id]) }}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div>
                                    <form method="POST" action="{{ route('operationsList.destroy', ['operationsList' => $operationList->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle red dark-1 txt-white push small"><i class="fas fa-trash"></i></button>
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
<div class="d-flex fx-center mt-5">{{ $operationsLists->links('pagination') }}</div>
@endsection