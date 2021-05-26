@section('modal-operation')
<!-- Modal Opération -->
<div class="modal grey light-4 rounded-2 p-2" id="modal-new-operation" data-ax="modal">
  <div class="grix xs1">
    <div class="d-flex vcenter">
      <form class="form-material container" method="POST" action="{{ route('operations.store')}}">
        @csrf
        <div class="form-field">
          <input type="text" id="filterOp" class="form-control txt-center grey txt-airforce txt-dark-4" />
          <label for="filterOp" class="">Filtrer</label>
        </div>
        <div class="form-field">
          <label for="operation">Opération</label>
          <select class="form-control rounded-1 txt-airforce txt-dark-4" id="operation_id" name="operation_id">
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

@section('extra-js')
<script>
  let operationsList = <?php echo (json_encode($operationsList)); ?>;
  let inputOp = document.getElementById('filterOp');
  let selectOp = document.getElementById('operation_id');

  inputOp.addEventListener('input', () => {
    let filteredEventsOp = operationsList.filter(function(e) {
      return e.name.includes(inputOp.value) || e.ref.includes(inputOp.value);
    });

    if (selectOp.childElementCount >= 1) {
      for (i = selectOp.childElementCount; i >= 0; i--) {
        selectOp.remove(i);
      }
    }

    for (const elem of filteredEventsOp) {
      selectOp.add(new Option(elem.name, elem.id));
    }
  });
</script>
@endsection