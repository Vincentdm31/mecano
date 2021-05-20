@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="grix xs1 sm3 container mb-3">
        <div class="col-sm1 mx-auto my-auto">
            <a href="{{ route('operationsList.create') }}" class="btn rounded-1 orange dark-1 txt-white small">Ajouter</a>
        </div>
        <div class="col-sm2">
            <form class="form-material" method="GET" action="searchOperationsList">
                @csrf
                <div class="grix xs5">
                    <div class="form-field pos-xs1 col-xs4">
                        <input type="text" name="searchOperationsList" id="searchOperationsList" class="form-control txt-gl4" />
                        <label for="searchOperationsList">Rechercher</label>
                    </div>
                    <button type="submit" class="btn circle orange dark-1 txt-white search-icon vself-center rounded-4 small"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="container mt-5">
        <div class="responsive-table bg-blue3 shadow-1 rounded-2">
            <table class="table striped centered">
                <thead>
                    <tr class="txt-orange">
                        <th class="txt-white">#</th>
                        <th>Ref</th>
                        <th>Nom</th>
                        <th>Forfait</th>
                        <th>Durée estimée</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operationsLists as $operationList)
                    <tr class="txt-white">
                        <td class="txt-orange">{{ $operationList->id }}</td>
                        <td>{{ $operationList->ref }}</td>
                        <td>{{ $operationList->name }}</td>
                        <td>
                            <i class="<?php echo($operationList->isPackage ? 'fas fa-check' : 'fas fa-times' ) ?>">
                        </td>
                        <td><?php echo($operationList->duration > 0 ? $operationList->duration . ' H' : '')?></td>
                        <td>{{ $operationList->price }}</td>
                        <td>
                            <div class="grix xs2 gutter-xs4">
                                <div class="ml-auto">
                                    <a class="btn circle orange dark-1 txt-white small" href="{{ route('operationsList.edit', ['operationsList' => $operationList->id]) }}"><i class="fas fa-pen"></i></a>
                                </div>
                                <div class="mr-auto">
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
<div class="d-flex fx-center mt-3">{{ $operationsLists->links('pagination') }}</div>
@endsection