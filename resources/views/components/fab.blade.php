@section('fab')
<?php

use Carbon\Carbon;

$date = Carbon::now();
?>

<div class="fab fab-checker" id="fab" data-ax="fab">
  <!-- Here is the fab-trigger -->
  <button id="fab-btn" class="fab-checker btn shadow-1 circle large grey light-4 txt-orange fab-trigger">
    <i class="fas fa-plus fab-checker" aria-hidden="true"></i>
  </button>

  <!-- Here is the fab-menu -->
  <div class="fab-menu">
    <form method="POST" class="fab-item" onsubmit="return confirm('Terminer l\'intervention ?');" action="{{ route('interventions.update',  ['intervention' => $intervention->id])}}">
      @method('PUT')
      @csrf
      <input hidden value="finish" name="state" />
      <button type="submit" class="<?php echo ($opDoing->count() < 1 && $opPause->count() < 1 && !$intervention->needMove || $opDoing->count() < 1 && $opPause->count() < 1 && $intervention->needMove && !empty($intervention->end_move_return) ? '' : 'hide') ?> btn mb-3 circle shadow-1 grey light-4 txt-green"><i class="fas fa-check" aria-hidden="true"></i></button>
    </form>


    @if($intervention->needMove && empty($intervention->end_move_return))
    <a data-target="modal-end-deplacement" class="btn shadow-1 circle grey light-4 txt-orange txt-dark-1 fab-item mb-3 modal-trigger">
      <i class="fas fa-car" aria-hidden="true"></i>
    </a>
    @endif

    @if($intervention->state == "doing")
    <form class="form-material h100 fab-item" onsubmit="return confirm('Mettre l\'intervention en pause ?');" method="POST" action="{{ route('timeinterventions.store') }}">
      @csrf
      <input hidden name="intervention_id" value="{{ $intervention->id }}">
      <input hidden name="start_date" value="{{ $date }}">
      <button type="submit" class="btn shadow-1 circle grey light-4 txt-orange txt-dark-1 mb-3"><i class="fas fa-pause"></i></button>
    </form>

    @elseif(($intervention->state == "pause"))
    <form class="form-material h100 fab-item" onsubmit="return confirm('Reprendre l\'intervenion? ?');" method="POST" action="{{ route('timeinterventions.store') }}">
      @csrf
      <input hidden name="intervention_id" value="{{ $intervention->id }}">
      <input hidden name="end_date" value="{{ $date }}">
      <button type="submit" class="btn shadow-1 circle grey light-4 txt-green txt-dark-1 mb-3"><i class="fas fa-play"></i></button>
    </form>
    @endif

    <a data-target="modal-comment" class="btn shadow-1 circle grey light-4 txt-orange txt-dark-1 fab-item mb-3 modal-trigger">
      <i class="<?php echo (!empty($intervention->observations) ? 'fas fa-comment-dots' : 'fas fa-comment') ?>" aria-hidden="true"></i>
    </a>
    <a data-target="modal-help" class="btn shadow-1 circle grey light-4 txt-orange txt-dark-1 fab-item mb-3 modal-trigger">
      <i class="far fa-lightbulb" aria-hidden="true"></i>
    </a>
  </div>
</div>

<!-- Overlay FAB -->
<div id="fab-overlay" class="fab-overlay"></div>
@endsection