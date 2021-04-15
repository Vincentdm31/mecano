@section('modal-km-vehicle')
<!-- Modal km vehicle -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-km" data-ax="modal">
  <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
    @method('PUT')
    @csrf
    <div class="grix xs1 txt-center">
      <div class="form-field">
        <input type="number" name="km_vehicule" class="form-control txt-center grey txt-airforce txt-dark-4">{{ $intervention->km_vehicule }}</textarea>
        <label for="km_vehicule" class="">Kilométrage</label>
      </div>
    </div>
    <div class="txt-center">
      <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-2 mb-2"><span class="outline-text outline-invert">Envoyer</span></button>
    </div>
  </form>
</div>
<!-- End modal vehicle -->
@endsection