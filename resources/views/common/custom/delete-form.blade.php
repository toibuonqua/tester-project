{!! Form::open(['url' => route($deleteForm['route'],[$deleteForm['param']=> $item->id ] ), 'method' => 'DELETE']) !!}
    <button class="{{ $deleteForm['class'] ?? 'btn btn-danger' }}" type="submit">
        <i class="{{ $deleteForm['icon'] ?? 'fas fa-trash' }}"></i>
        {{ $deleteForm['name'] ?? '' }}
    </button>
{!! Form::close() !!}
