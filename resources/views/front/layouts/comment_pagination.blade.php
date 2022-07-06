@if ($paginator->hasPages())
    <nav class="comment_pagination_wrap" aria-label="Page navigation example">
        <ul class="comment_pagination_list">
            @if ($paginator->onFirstPage())
                <li class="comment_pagination_direct dormant"><a class="comment_pagination_direct_link prev" tabindex="-1" aria-disabled="true">«</a></li>
            @else
                <li class="comment_pagination_direct"><a class="comment_pagination_direct_link prev" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" aria-disabled="true">«</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="comment_page-item dormant">{{ $element }}</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="comment_pagination_item"><span class="comment_pagination_link active">{{ $page }}</span></li>
                        @else
                            <li class="comment_pagination_item"><a class="comment_pagination_link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="comment_pagination_direct">
                    <a class="comment_pagination_direct_link next" href="{{ $paginator->nextPageUrl() }}">»</a>
                </li>
            @else
                <li class="comment_pagination_direct dormant">
                    <a class="comment_pagination_direct_link next">»</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
