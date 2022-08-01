<button class="{{ $button['class'] ?? 'btn btn-primary' }}" type="{{ $button['type'] ?? 'button' }}"  value="{{ $item->id ?? 0 }}" {{ $button['attributes'] ?? '' }}>
    <i class="{{ $button['icon'] ?? '' }}"></i>
    {{ __("title.".($button['name'] ?? 'edit')) }}
</button>
