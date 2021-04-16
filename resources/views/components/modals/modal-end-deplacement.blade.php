@section('modal-end-deplacement')

<?php

use Carbon\Carbon;

$date = Carbon::now();
?>
<!-- Modal fin déplacement -->
<div class="modal grey light-4 rounded-2" id="modal-end-deplacement" data-ax="modal">
  <div class="grix xs1 md2">
    @if(empty($intervention->start_move_return))
    <div class="d-flex my-auto fx-col">
      <div>
        <p class="txt-center dark txt-grey txt-light-4 mb-4 m-0 p-3 font-s3">Déplacements Retour</p>
        <div>
          <form method="POST" action="{{ route('setEndDeplacement')}}">
            @method('PUT')
            @csrf
            <div class="txt-center">
              <input hidden value="{{ $date }}" name="start_move_return" />
              <input hidden name="id" value="{{ $intervention->id }}"></input>
              <button type="submit" class="btn shadow-1 rounded-1 outline opening txt-orange small"><span class="outline-text outline-invert">Début</span></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-4" alt="">
    @endif

    <!--End Déplacement Interventions Aller -->
    @if(!empty($intervention->start_move_return) && empty($intervention->end_move_return))
    <div class="d-flex my-auto fx-col">
      <div>
        <p class="txt-center dark txt-grey txt-light-4 mb-4 m-0 p-3 font-s3">Déplacements Retour</p>
      </div>
      <form method="POST" action="{{ route('setEndDeplacement')}}">
        @method('PUT')
        @csrf
        <div class="txt-center">
          <input hidden value="{{ $date }}" name="end_move_return" />
          <input hidden name="id" value="{{ $intervention->id }}"></input>
          <button type="submit" class="btn small shadow-1 rounded-1 outline opening txt-orange"><span class="outline-text outline-invert">Fin</span></button>
        </div>
      </form>
    </div>
    <img src="{{ asset('/images/deplacement.svg') }}" class="responsive-media p-4" alt="">
    @endif
  </div>
</div>
@endsection