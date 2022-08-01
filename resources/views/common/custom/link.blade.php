@if(isset($link))
    <a href="{{ route($link['route'] ?? 'home', [$link['param'] ?? 'id' => $item->id]) }}"
       class="btn btn-primary">{{ __('title.' . ($link['text'] ?? 'edit')) }}</a>
@endif
