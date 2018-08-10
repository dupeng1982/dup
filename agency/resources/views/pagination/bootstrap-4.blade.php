@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">首页</span></li>
            <li class="page-item disabled"><span class="page-link">上一页</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}" rel="prev">首页</a></li>
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">尾页</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">下一页</span></li>
            <li class="page-item disabled"><span class="page-link">尾页</span></li>
        @endif
    </ul>
@endif
