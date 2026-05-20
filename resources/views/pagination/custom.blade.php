@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-item disabled">&laquo; Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item">&laquo; Previous</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-item disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-item active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item">Next &raquo;</a>
        @else
            <span class="pagination-item disabled">Next &raquo;</span>
        @endif
    </div>

    <style>
        .pagination-wrapper {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .pagination-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 8px;
            border: 1px solid var(--line, #cfe3de);
            border-radius: 8px;
            text-decoration: none;
            color: var(--ink, #12312d);
            background: var(--panel, #ffffff);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .pagination-item:hover:not(.disabled):not(.active) {
            background: var(--accent, #0f8f84);
            color: white;
            border-color: var(--accent, #0f8f84);
        }

        .pagination-item.active {
            background: var(--accent, #0f8f84);
            color: white;
            border-color: var(--accent, #0f8f84);
        }

        .pagination-item.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endif
