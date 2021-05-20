@section('operation-list')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>
<div class="container">
  @if($opDoing->count() < 1 && $opPause->count() < 1) <p class="white rounded-2  m-0 txt-light-4 p-3 font-s3 txt-center">Aucune opération en cours</p>
      @endif
      @foreach( $intervention->operations as $operation)
      @if($operation->state != "finish")
      <div class="card overflow-visible bg-blue3 mb-3">
        @if(Auth()->user()->id != $operation->user_id && Cookie::has('joinOp') == false)
        <form method="POST" action="{{ route('joinOperation', ['intervention' => $intervention->id]) }}">
          @csrf
          <input hidden name="operation" value="{{ $operation->id }}" />
          <button type="submit" class="btn blue circle absolute-pos" style="right:0; top:0;transform:translate(50%,-50%)"><i class="fas fa-plus txt-white"></i></button>
        </form>
        @endif
        @if(Auth()->user()->id != $operation->user_id && Cookie::has('joinOp') == true)
        <form method="POST" id="leaveOp" action="{{ route('leaveOperation', ['intervention' => $intervention->id]) }}">
          @csrf
          @method('PUT')
          <input hidden name="operation" value="{{ $operation->id }}" />
          <button type="submit" class="btn red circle absolute-pos" style="right:0; top:0;transform:translate(50%,-50%)"><i class="fas fa-times txt-white"></i></button>
        </form>
        @endif
        <div class="card-header">
          <p class="p-0 m-0 font-s3 txt-grey txt-light-4 txt-center">{{ $operation->operationList->name }}</p>
          <p class="p-0 m-0 font-s2 txt-grey txt-light-2 txt-center">{{ $operation->user->name }}</p>
          @if ($operation->pieces()->exists())
          @foreach($operation->pieces as $piece)
          <div class="card overflow-visible rounded-1 grey light-4 p-1 ml-5 mr-5 mt-2 mb-3">
            <div class="card-header p-0">
              <p class="my-auto m-0 font-s2 col-xs2 txt-dark"><span class="mr-3 txt-orange txt-dark-1 font-w600 pl-3 font-s3">{{ $piece->qte }}x</span>{{ $piece->pieceList->name }}</p>
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
          <p class="m-0 p-3 font-s3 white txt-center txt-orange">Aucune pièce utilisée</p>
          @endif
        </div>
        <div class="card-content grey light-4">
          <div class="grix xs2 md5 gutter-xs3">
            <!-- Pièces -->
            <div>
              <button data-target="add-piece-operation-{{ $operation->id }}" class="btn w100 rounded-1 bg-blue3 modal-trigger mx-auto">
                <i class="fas fa-tools txt-gl4"></i>
              </button>
            </div>
            <!-- Commentaire opération -->
            <div>
              <button data-target="edit-operation-{{ $operation->id }}" class="btn w100 rounded-1 bg-blue3 txt-gl4 modal-trigger mx-auto">
                <i class="fas fa-comment-medical <?php echo (isset($operation->op_comment) ? 'txt-orange' : '') ?>"></i>
              </button>
            </div>
            <!-- Pause / Reprendre -->
            @if($operation->state == 'doing')
            <!-- Mettre en pause l'opération -->
            <div>
              <form class="form-material" onsubmit="return confirm('Mettre l\'opération en pause ?');" method="POST" action="{{ route('timeoperations.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="operation_id" value="{{ $operation->id }}">
                <input hidden name="start_date" value="{{ $date }}">
                <button type="submit" class="btn w100 rounded-1 bg-blue3 mx-auto">
                  <i class="fas fa-pause txt-orange"></i>
                </button>
              </form>
            </div>
            @elseif($operation->state == 'pause')
            <!-- Reprendre l'opération -->
            <div>
              <form class="form-material" onsubmit="return confirm('Reprendre l\'opération ?');" method="POST" action="{{ route('timeoperations.store') }}">
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}">
                <input hidden name="operation_id" value="{{ $operation->id }}">
                <input hidden name="end_date" value="{{ $date }}">
                <button type="submit" class="btn w100 rounded-1 bg-blue3 mx-auto">
                  <i class="fas fa-play txt-green txt-dark-1"></i>
                </button>
              </form>
            </div>
            @endif
            <div>
              <form class="form-material" onsubmit="return confirm('Supprimer l\opération ?');" method="POST" action="{{ route('operations.destroy', ['operation' => $operation->id]) }}">
                @method('DELETE')
                @csrf
                <input hidden name="intervention_id" value="{{ $intervention->id }}" />
                <button type="submit" class="btn w100 bg-blue3 rounded-1 txt-red"><i class="fas fa-trash"></i></span></button>
              </form>
            </div>
            <div class="col-xs2 col-md1">
              <form method="POST" action="{{ route('finishOperation', ['operationId' => $operation->id, 'interventionId' => $intervention->id, 'state' => 'finish'])}}">
                @method('PUT')
                @csrf
                <div class="txt-center">
                  <button type="" class="btn w100 rounded-1 bg-blue3 mx-auto">
                    <i class="fas fa-check txt-green txt-dark-1"></i>
                  </button>
                </div>
              </form>
            </div>
            <!-- Fin GRIX -->
          </div>
        </div>
      </div>
      <!-- Fin if $operation->state != "finish" -->
      @endif
      <!-- Fin foreach $intervention->operations as $operation-->
      @endforeach
      <div class="txt-center my-3">
        @if($opUserDoing->count() > 0)
        <button data-target="modal-new-operation" class="disabled btn-tab-operation modal-trigger">Nouvelle opération</button>
        @else
        <button data-target="modal-new-operation" class=" btn-tab-operation modal-trigger">Nouvelle opération</button>
        @endif
      </div>
</div>
@endsection
@section('extra-js')
<script>
  function removePieces(id) {
    let input = document.getElementById('rm_piece_' + id);
    var pieceCount = window.prompt('Combien de pièces voulez vous supprimer ?');
    input.value = pieceCount;
  }

</script>
@endsection