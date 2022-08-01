<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    @foreach ($itemList as $key => $item)
        @if(is_array($item))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ in_array(Route::currentRouteName(),$item)   ? 'active' : '' }}" href="#" id="drop-down{{$key}}" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    {{ __("title.$key") }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="drop-down{{$key}}">
                    @foreach($item as $subKey => $subItem)
                    <li class="nav-item">
                        <a class="dropdown-item {{ Route::currentRouteName() === $subItem ? 'active' : '' }}"
                           href="{{ route($subItem) }}">{{ __("title.$subKey") }}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === $item ? 'active' : '' }}"
                   href="{{ route($item) }}">{{ __("title.$key") }}</a>
            </li>
        @endif
    @endforeach
</ul>

