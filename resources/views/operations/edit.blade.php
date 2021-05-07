@extends('layouts.app')

@section('content')
<div class="container d-flex fx-center h100">
    <div class="card vself-center rounded-2 shadow-1 dark p-3">
        <div class="card-header pl-3 pr-3 p-0">
            <p class="pb-2 txt-grey txt-light-4">Edition opération</p>
        </div>
        <div class="card-content p-0 pl-3 pr-3">
            <form class="form-material" method="POST" action="{{route('operationsList.update', ['operationsList' => $operationList->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field">
                        <input type="text" id="ref" name="ref" class="form-control txt-white" value="{{$operationList->ref}}" />
                        <label for="ref">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="form-control txt-white" value="{{$operationList->name}}" />
                        <label for="name">Nom</label>
                    </div>
                    <div class="grix xs2">
                        <div class="form-field">
                            <input type="number" id="price" name="price" class="form-control txt-white" value="{{$operationList->price}}" />
                            <label for="price">Prix</label>
                        </div>
                        <div class="form-field h100 p-0 m-0">
                            <label class="form-check mt-auto pb-3">
                                <input type="checkbox" name="isPackage" <?php echo($operationList->isPackage ? 'checked' : '')?>/>
                                <span class="txt-gl4">Forfait ?</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="txt-center">
                    <button type="submit" class="btn rounded-1 orange dark-1 txt-white mt-3 mb-3">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection