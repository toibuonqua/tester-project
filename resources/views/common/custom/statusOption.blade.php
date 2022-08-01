@if(isset($status))
    <select name="{{$status['name'] ?? 'status' }}[{{ $item->id }}]" class="form-select status-select"
            aria-label="Select user status">
        @foreach ($status['options'] ?? [] as $statusOption)
            <option value="{{ $statusOption }}"
                {{ $statusOption === $item->status ? 'selected' : '' }}>{{ __("title.$statusOption") }}
            </option>
        @endforeach
    </select>
@else
    {{ __("title.$item->status") }}
@endif
