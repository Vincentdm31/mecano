@section('modal-comment')
<!-- Modal comment global -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-comment" data-ax="modal">
  <form class="form-material container" method="POST" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
    @method('PUT')
    @csrf
    <div class="grix xs1 txt-center">
      <div class="form-field">
        <textarea type="text" name="observations" class="form-control txt-center grey txt-airforce txt-dark-4">{{ $intervention->observations }}</textarea>
        <label for="observations" class="">Observations</label>
      </div>
    </div>
    <div class="txt-center">
      <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange mt-2 mb-2"><span class="outline-text outline-invert">Envoyer</span></button>
    </div>
  </form>
</div>
@endsection