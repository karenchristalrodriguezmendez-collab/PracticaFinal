@if ($paginator->hasPages())
    <div class="ui pagination menu" role="navigation" aria-label="Paginación">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="disabled item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <i class="left chevron icon"></i>
            </div>
        @else
            <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                <i class="left chevron icon"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="disabled item">{{ $element }}</div>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="active item" aria-current="page">{{ $page }}</div>
                    @else
                        <a class="item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                <i class="right chevron icon"></i>
            </a>
        @else
            <div class="disabled item" aria-disabled="true" aria-label="@lang('pagination.next')">
                <i class="right chevron icon"></i>
            </div>
        @endif
    </div>
@endif
