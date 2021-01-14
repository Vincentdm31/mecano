@extends('layouts.app')

@section('title')
Index
@endsection
@section('pageTitle')
Index Sim   
@endsection
@section('content')

<div class="container sim-index">
    <div class="grix xs5">
        <div class="col-xs1 ml-auto vself-center">
            <a class="btn shadow-1 rounded-1 outline opening font-w500 add" href="{{route('sims.create')}}"><span class="outline-text">Ajouter</span></a>
        </div>
        <div class="col-xs3">   
            <form class ="form-material" method="GET" action="search">
                @csrf
                <div class="grix xs5 m-5">
                    <div class="form-field pos-xs2 col-xs3">
                        <input type="text" name="search" id="search"class="form-control" />
                        <label for="search">Rechercher</label>
                    </div>
                    <button type ="submit" class="btn circle search-icon vself-center rounded-4"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-xs1 mr-auto vself-center">
            <a class="btn shadow-1 rounded-1 outline opening font-w500 reset" href="{{route('sims.index')}}"><span class="outline-text">Reset</span></a>
        </div>
    </div>
    <div class="responsive-table">
        <table class="table striped centered mt-5">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>ID GPS</th>
                    <th>Immatriculation</th>
                    <th>N° Supp Géoloc</th>
                    <th>N° Ligne</th>
                    <th>N° Sim Vierge Reaffect</th>
                    <th>Autre</th>
                    <th>Actions</th>
                </tr>
            </thead>
         <tbody>
            @foreach($sims as $sim)
            
            <tr>
                <td class="<?php echo 'state-'.$sim->state ?>"></td>
                <td>-{{$sim->id}}-</td>
                <td>{{$sim->idgps}}</td>
                <td>{{$sim->immat}}</td>
                <td>{{$sim->numsupgeoloc}}</td>
                <td>{{$sim->numligne}}</td>
                <td>{{$sim->numsimviergereafect}}</td> 
                <td>{{$sim->F}}</td>
                <td>
                    <div class="flex grix xs3 gutter-xs1 center ">
                        <a href="{{route('sims.show', ['sim' => $sim->id])}}" class="btn circle table-show-icon ml-auto txt-white push"><i class="fas fa-info"></i></a>
                        <a class="btn circle table-edit-icon txt-white push" href="{{route('sims.edit', ['sim' => $sim->id])}}"><i class="fas fa-pen"></i></a>
                        <div class="mr-auto">
                            <form method="POST" action="{{route('sims.destroy', ['sim' => $sim->id])}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="btn circle txt-white table-del-icon push"><i class="fas fa-trash"></i></button>
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
@endsection

@section('extra-js')

<script>
    let toast = new Axentix.Toast(); 
</script>

@if(session('toast') == 'simStore')
<script>
    toast.change('Carte sim ajoutée', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'simUpdate')
<script>
    toast.change('Carte sim modifiée', {
        classes: "rounded-1 green light-2 shadow-2"
    });
    toast.show();
</script>
@elseif(session('toast') == 'simDelete')
<script>
    toast.change('Carte sim supprimée', {
        classes: "rounded-1 red light-2 shadow-2"
    });
    toast.show();
</script>
@endif
@endsection