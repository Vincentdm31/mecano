@section('operation-list')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>
<!-- Test -->

<div class="container grey light-4 rounded-2">
  @if($opDoing->count() < 1 && $opPause->count() < 1) <p class="dark rounded-2 txt-grey m-0 txt-light-4 p-3 font-s3 txt-center">Aucune opération en cours</p>
      @else
      @foreach( $intervention->operations as $operation)
      @if($operation->state != "finish")
      <div class="rounded-tl2 rounded-tr2 pb-2 dark">
        <p class="p-3 m-0 font-s3 txt-grey txt-light-4 txt-center">{{ $operation->operationList->name}}</p>

        @if ($operation->pieces()->exists())
        @foreach($operation->pieces as $piece)
        <div class="card overflow-visible rounded-1 grey light-4 p-1 ml-5 mr-5 mt-2 mb-3">
          <div class="card-header p-0">
            <p class="my-auto m-0 font-s2 col-xs2 txt-dark"><span class="mr-3 txt-orange txt-dark-1 font-w600 pl-3 font-s3">{{$piece->qte}}x</span>{{$piece->pieceList->name }}</p>
            <form method="POST" onsubmit="removePieces('{{ $piece->id }}');" action="{{ route('pieces.destroy', ['piece' => $piece->id])}}">
              @method('delete')
              @csrf
              <div class="txt-center">
                <input hidden value="{{ $intervention->id }}" name="interventionId" />
                <input hidden type="number" id="rm_piece_{{ $piece->id }}" name="piece_count" />
                <button type="submit" class="btn rounded-1 bd-dark bd-light-4 bd-solid bd-3 circle small grey light-4 txt-orange txt-dark-1" style="position:absolute;top:0;right:0;transform:translate(50%,-50%)"><i class=" fas fa-trash"></i></button>
              </div>
            </form>
          </div>
        </div>
        @endforeach
        @else
        <p class="m-0 p-3 dark txt-center txt-orange">Aucune pièce utilisée</p>
        @endif
      </div>

      <!-- opérations -->
      <div class="mr-5 ml-5 mt-3 pb-3 grix xs2 gutter-xs3 md5 rounded-2 pl-3 pr-3">
        <!-- Ajout piece -->
        <div>
          <button data-target="add-piece-operation-{{ $operation->id }}" class="btn w100 rounded-1 dark light-shadow-3 txt-blue modal-trigger mx-auto">
            <i class="fas fa-tools txt-grey txt-light-4"></i>
          </button>
        </div>
        <!-- Modal comment operation -->
        <div>
          <button data-target="edit-operation-{{ $operation->id }}" class="btn w100 rounded-1 dark light-shadow-3 txt-grey txt-light-4 modal-trigger mx-auto">
            <i class="fas fa-comment-medical <?php echo (isset($operation->op_comment) ? 'txt-orange' : '') ?>"></i>
          </button>
        </div>

        <div>
          <!-- Mettre en pause -->
          @if($operation->state == 'doing')
          <div>
            <form class="form-material" onsubmit="return confirm('Mettre l\'opération en pause ?');" method="POST" action="{{ route('timeoperations.store') }}">
              @csrf
              <input hidden name="intervention_id" value="{{ $intervention->id }}">
              <input hidden name="operation_id" value="{{ $operation->id }}">
              <input hidden name="start_date" value="{{ $date }}">
              <button type="submit" class="btn w100 rounded-1 dark light-shadow-3 txt-blue mx-auto">
                <i class="fas fa-pause txt-orange txt-dark-1"></i>
              </button>
            </form>
          </div>
          <!-- Reprendre  -->
          @elseif($operation->state == 'pause')
          <div>
            <form class="form-material" onsubmit="return confirm('Reprendre l\'opération ?');" method="POST" action="{{ route('timeoperations.store') }}">
              @csrf
              <input hidden name="intervention_id" value="{{ $intervention->id }}">
              <input hidden name="operation_id" value="{{ $operation->id }}">
              <input hidden name="end_date" value="{{ $date }}">
              <button type="submit" class="btn w100 rounded-1 dark light-shadow-3 txt-blue mx-auto">
                <i class="fas fa-play txt-green txt-dark-2"></i>
              </button>
            </form>
          </div>
          @endif
        </div>
        <!-- DELETE -->
        <div>
          <form class="form-material" onsubmit="return confirm('Supprimer l\opération ?');" method="POST" action="{{ route('operations.destroy', ['operation' => $operation->id]) }}">
            @method('DELETE')
            @csrf
            <input hidden name="intervention_id" value="{{ $intervention->id }}" />

            <button type="submit" class="btn w100 dark light-shadow-3 rounded-1 txt-red"><i class="fas fa-trash"></i></span></button>

          </form>
        </div>
        <!-- Terminer -->
        <div class="col-xs2 col-md1">
          <form method="POST" onsubmit="return confirm('Terminer l\'opération ?');" action="{{ route('finishOperation', ['operationId' => $operation->id, 'interventionId' => $intervention->id, 'state' => 'finish'])}}">
            @method('PUT')
            @csrf
            <div class="txt-center">
              <button type="submit" class="btn shadow-1 rounded-1 w100 dark light-shadow-3 mx-auto">
                <i class="fas fa-check txt-green txt-dark-2"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
</div>

@endif
@endforeach
@endif
</div>
</div>
<div class="txt-center mt-3">
  @if( $opDoing->count() < 1 && $opPause->count() < 1 && $opEnd->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
        @elseif($opDoing->count() > 0)
        <button data-target="modal-new-operation" class="disabled btn-tab-operation modal-trigger">Nouvelle opération</button>
        @elseif($opDoing->count() < 1) <button data-target="modal-new-operation" class="btn-tab-operation modal-trigger">Nouvelle opération</button>
          @endif
</div>
</div>
<!-- Test -->
@endsection

@section('extra-js')

<script>

function removePieces(id){
  let input = document.getElementById('rm_piece_' + id);
  var pieceCount = window.prompt('Combien de pièces voulez vous supprimer ?');
  input.value = pieceCount;
}

</script>

@endsection