@section('modal-operation')
<!-- Modal Opération -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-new-operation" data-ax="modal">
  <div class="">
    <form class="form-material container" method="GET" action="{{ route('interventions.edit', ['intervention' => $intervention->id])}}">
      @csrf
      <div class="grix xs6">
        <div class="form-field pos-xs1 col-xs5">
          <input type="text" name="selectOperation" id="selectOperation" class="form-control txt-airforce txt-dark-4" />
          <label for="selectOperation">Rechercher</label>
        </div>
        <div class="d-flex vcenter">
          <button type="submit" class="btn shadow-1 rounded-1 orange dark-1 circle rounded-4 small"><i class="fas fa-search txt-white"></i></button>
        </div>
      </div>
    </form>
  </div>
  <div class="grix xs1 md2">
    <div class="d-flex vcenter">
      <form class="form-material container" method="POST" action="{{ route('operations.store')}}">
        @csrf
        <div class="form-field">
          <label for="operation">Opération</label>
          <select class="form-control rounded-1 txt-airforce txt-dark-4" name="operation_id">
            @foreach ( $operationsList as $operationList)
            <option class="grey light-4 txt-airforce txt-dark-4" value="{{ $operationList->id }}">{{ $operationList->name }}</option>
            @endforeach
          </select>
        </div>
        <input hidden name="intervention_id" value="{{ $intervention->id }}">
        <div class="txt-center">
          <button type="submit" class="btn shadow-1 rounded-1 orange txt-grey txt-light-4 mt-4">Valider</button>
        </div>
      </form>
    </div>
    <img src="{{ asset('/images/operation.png') }}" class="responsive-media p-3" alt="">
  </div>
</div>
@endsection