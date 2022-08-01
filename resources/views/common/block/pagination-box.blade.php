<div class="pagination-bar">
    <nav aria-label="Question set pagination">
        <ul class="pagination">
            @php
                $queries = Request::all()
            @endphp
       
            <li class="page-item"><a class="page-link"
                    href="{{ route(Route::currentRouteName(), array_merge($queries, $params ?? [], ['page' => 1])) }}">{{ __('title.first') }}</a>
            </li>

            @if ($currentPage - 1 > 1)
                <li class="page-item"><a class="page-link">...</a></li>
            @endif

            @if ($currentPage - 1 > 0)
                <li class="page-item"><a class="page-link"
                        href="{{ route(Route::currentRouteName(), array_merge($queries, $params ?? [], ['page' => $currentPage - 1])) }}">{{ $currentPage - 1 }}</a>
                </li>
            @endif

            <li class="page-item active"><a class="page-link"
                    href="{{ route(Route::currentRouteName(), array_merge($queries, $params ?? [], ['page' => $currentPage])) }}">{{ $currentPage }}</a>
            </li>

            @if ($currentPage + 1 <= $totalPage)
                <li class="page-item"><a class="page-link"
                        href="{{ route(Route::currentRouteName(), array_merge($queries, $params ?? [], ['page' => $currentPage + 1])) }}">{{ $currentPage + 1 }}</a>
                </li>
            @endif

            @if ($currentPage + 2 <= $totalPage)
                <li class="page-item"><a class="page-link">...</a></li>
            @endif

            <li class="page-item"><a class="page-link"
                    href="{{ route(Route::currentRouteName(), array_merge($queries, $params ?? [], ['page' => $totalPage])) }}">{{ __('title.last') }}</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">(</a></li>
            <li class="perpage-input"><input type="text" maxlength="2" class="form-control" value="{{ $limit }}"
                    name="numberPerPage"></li>
            <li class="page-item"><a class="page-link" onclick="updateNumberPerPage()">/page)</a></li>
        </ul>
    </nav>

</div>
