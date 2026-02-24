@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación simple" class="d-flex justify-content-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline-secondary disabled" aria-disabled="true">@lang('pagination.previous')</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary" rel="prev">@lang('pagination.previous')</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary" rel="next">@lang('pagination.next')</a>
        @else
            <span class="btn btn-outline-secondary disabled" aria-disabled="true">@lang('pagination.next')</span>
        @endif
    </nav>
@endif
