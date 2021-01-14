@extends('layouts.app')
@section('pageTitle')
Edit Sim
@endsection
 @section('content')

<h1 class="flex fx-center txt-airforce txt-dark-3"></h1>
<div class="container edit-car">
    <div class="card">
        <div class="card-content pt-0">
            <form class="form-material" method="POST" action="{{route('sims.update', ['sim' => $sim->id])}}">
                @method('PUT')
                @csrf
                <div class="grix xs1">
                    <div class="form-field mb-1">
                        <input type="text" id="idgps" name="idgps" class="form-control mt-3 txt-center" value="{{$sim->idgps}}" />
                        <label for="idgps" style="transform: translateX(-50%);left:50%;">ID GPS</label>
                    </div>
                    <div class="form-field  mb-1">
                        <input id="immat" name="immat" class="form-control mt-3 txt-center" value="{{$sim->immat}}" />
                        <label for="immat" style="transform: translateX(-50%);left:50%;">Immatriculation</label>
                    </div>
                    <div class="form-field  mb-1">
                        <input id="numsupgeoloc" name="numsupgeoloc" class="form-control mt-3 txt-center" value="{{$sim->numsupgeoloc}}" />
                        <label for="numsupgeoloc" style="transform: translateX(-50%);left:50%;">N° Sup Géoloc</label>
                    </div>
                    <div class="form-field  mb-1">
                        <input id="numligne" name="numligne" class="form-control mt-3 txt-center" value="{{$sim->numligne}}" />
                        <label for="numligne" style="transform: translateX(-50%);left:50%;">N° Ligne</label>
                    </div>
                    <div class="form-field  mb-1">
                        <input id="numsimviergereafect" name="numsimviergereafect" class="form-control mt-3 txt-center" value="{{$sim->numsimviergereafect}}" />
                        <label for="numsimviergereafect" style="transform: translateX(-50%);left:50%;">N° Sim Reaffect</label>
                    </div>
                    <div class="form-field">
                        <input id="F" name="F" class="form-control mt-1 txt-center" value="{{$sim->F}}" />
                        <label for="F" style="transform: translateX(-50%);left:50%;">Autre</label>
                    </div>
                    <div class="form-field">
                        <label for="state" class="txt-center">Etat</label>
                        <select name="state" id="state" class="form-control">
                            <option <?php echo $sim->state == '' ? 'selected' : '' ?>></option>
                            <option <?php echo $sim->state == 'up' ? 'selected': '' ?>>up</option>
                            <option <?php echo $sim->state == 'down' ? 'selected' : ''  ?>>down</option>
                            <option <?php echo $sim->state == 'check' ? 'selected' : ''  ?>>check</option>
                            <option <?php echo $sim->state == 'other' ? 'selected' : '' ?>>other</option>
                        </select>
                    </div>
                </div>
                <button type="submit"  class="btn press mx-auto edit-button mt-5">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
    
@endsection