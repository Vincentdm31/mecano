@if ($paginator->hasPages())
<div>
  <ul class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="disabled">
      <a href=""><i class="fas fa-step-backward txt-gl4"></i></a>
    </li>

    <li class="disabled">
      <a href=""><i class="fas fa-angle-left txt-gl4"></i></a>
    </li>
    @else
    <li>
      <a href="?page=1" class="bg-blue3 txt-white rounded-1"><i class="fas fa-step-backward"></i></a>
    </li>

    <li>
      <a href="{{ $paginator->previousPageUrl() }}" class="bg-blue3 txt-white rounded-1"><i class="fas fa-angle-left"></i></a>
    </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="disabled txt-white"><a href="">{{ $element }}</a></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="active"><a href="">{{ $page }}</a></li>
    @else
    <li><a href="{{ $url }}" class="blue txt-white rounded-1">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li>
      <a href="{{ $paginator->nextPageUrl() }}" class="bg-blue3 txt-white rounded-1"><i class="fas fa-angle-right"></i></a>
    </li>

    <li>
      <a href="?page={{ $paginator->lastPage() }}" class="bg-blue3 txt-white rounded-1"><i class="fas fa-step-forward"></i></a>
    </li>
    @else
    <li class="disabled">
      <a href=""><i class="fas fa-angle-right txt-gl4"></i></a>
    </li>

    <li class="disabled">
      <a href=""><i class="fas fa-step-forward txt-gl4"></i></a>
    </li>
    @endif
  </ul>
</div>
@endif