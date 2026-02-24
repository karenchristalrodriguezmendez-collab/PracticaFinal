@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación simple" class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled" aria-disabled="true"><span>@lang('pagination.previous')</span></span>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a></li>
        @else
            <span class="page-item disabled" aria-disabled="true"><span>@lang('pagination.next')</span></span>
        @endif
    </nav>
@endif
