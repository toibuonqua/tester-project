<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($label ?? ($name ?? 'tags'))) }}</label>
    <div class="{{ $holderClass ?? 'col-sm-3' }}">
        @foreach($tags ?? [] as $tag)
            <span class="btn btn-sm btn-warning disabled mx-1 {{ $tag->name }}">{{ $tag->name }}</span>
        @endforeach
    </div>
</div>
