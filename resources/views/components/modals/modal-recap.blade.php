@section('modal-recap')
<!-- Modal Recap -->
<div class="modal grey light-4 rounded-2" id="modal-recap" data-ax="modal">
  <div class="card bg-blue3 shadow-2 mt-0 mb-0">
    <div class="card-header txt-white p-0">
      <p class=" m-2 font-s4"><i class="fas fa-car font-s6 mr-3 ml-2 mb-2"></i>Véhicule</p>
    </div>
    <div class="card-content p-2">
      <div class="grix xs2">
        <div>
          <p class="font-s1 m-0 txt-orange txt-dark-1">Marque</p>
          <p class="txt-white m-0">{{ $intervention->vehiculeList->brand }}</p>
        </div>
        <div>
          <p class="font-s1 m-0 txt-orange txt-dark-1">Modèle</p>
          <p class="txt-white m-0">{{ $intervention->vehiculeList->model }}</p>
        </div>
        <div>
          <p class="font-s1 m-0 txt-orange txt-dark-1">Immatriculation</p>
          <p class="txt-white m-0">{{ $intervention->vehiculeList->license_plate }}</p>
        </div>
        <div class="my-auto">
          @if(empty($intervention->km_vehicule))
          <button data-target="modal-km" class="btn orange dark-1 txt-white font-s2 rounded-2 modal-trigger small">Saisir km</button>
          @else
          <p class="font-s1 m-0 txt-orange txt-dark-1">Kilométrage</p>
          <p class="txt-white m-0">{{ $intervention->km_vehicule }} Km</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <p class="txt-dark pl-2 m-0 p-4 font-s4"><i class="fas fa-tools font-s6 txt-dark mr-3 ml-2"></i>Mes opérations</p>

  @foreach( $intervention->operations as $operation)
  @if($operation->state == 'finish')
  <div class="card grey light-4 overflow-visible shadow-1 m-4 rounded-2">
    <div class="card-header bg-blue3 p-1">
      <div class="d-flex fx-row">
      <p class="m-0 font-s3 mx-auto txt-white p-2">{{ $operation->operationList->name}}</p>
      </div>
      <form method="POST" class="" action="{{ route('editOperation',  ['id' => $operation->id, 'interventionId' => $intervention->id ] ) }}">
        @method('PUT')
        @csrf
        <button type="submit" class="btn circle bd-solid bd-3 bd-white rounded-1 small bg-blue2 txt-orange txt-dark-1 " style="position:absolute;top:0;right:0;transform:translate(50%,-50%)"><i class="fas fa-pen"></i></button>
      </form>
    </div>
    @foreach($operation->pieces as $piece)
    <p class="pl-3 m-0 mb-1 pt-1 txt-airforce txt-dark-4"><span class="mr-3 txt-grey txt-dark-4">{{ $piece->qte }}x</span>{{ $piece->pieceList->name }}</p>
    @endforeach
  </div>
  @endif
  @endforeach
</div>
<!-- End Modal Recap -->
@endsection