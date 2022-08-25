<table class="table table-hover table-light table-stripped align-middle">
    <thead>
    <tr>
        <th scope="col">#</th>
        @foreach ($fields ?? [] as $key => $value)
            @if ($value === 'pattern.tick')
                <th></th>
            @else
                <th scope="col">{{ __("title.$key") }}</th>
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($items ?? [] as $item)
        <tr>
            <td class="id" scope="row">{{ $item->id }}</td>
            @foreach ($fields ?? [] as $key => $value)
                @if ($value === 'pattern.tick')
                    <td class="tick" style="min-width: 40px"><i class="fas fa-check" style="display: none"></i></td>
                @elseif ($value === 'pattern.modified')
                    <td><a href="{{ route($edit_route ?? 'home', [$id_param ?? 'id' => $item->id]) }}"
                           {{-- Them parameter moi --}}
                           class="btn btn-success">{{ __('title.' . ($edit_text ?? 'edit')) }}</a>
                    </td>
                @elseif ($value === 'pattern.view')
                    <td><a href="{{ route($view_route ?? 'home', [$id_param ?? 'id' => $item->id]) }}"
                           {{-- Them parameter moi --}}
                           class="btn btn-success">{{ __('title.' . ($view_text ?? 'view')) }}</a>
                    </td>
                @elseif ($value === 'pattern.delete')
                    <td>
                        <form method="post" action="{{ route($delete_route, [$id_param ?? 'id' => $item->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-success" onclick="return confirm('{{ $notice_delete }}')" type="submit">{{ __('title.' . ($delete_text ?? 'delete')) }}</button>
                        </form>
                    </td>
                @elseif ($value === 'pattern.status')
                    <td>
                        <form method="post" action="{{ route($status_route, [$id_param ?? 'id' => $item->id]) }}">
                            @csrf
                            @method('POST')
                            <button class="btn btn-success" onclick="return confirm('{{ $notice_active }}')" type="submit">{{ __('title.' . ($status_text ?? 'action')) }}</button>
                        </form>
                    </td>
                @elseif ($value === 'pattern.reset')
                    <td>
                        <form method="post" action="{{ route($reset_route, [$id_param ?? 'id' => $item->id]) }}">
                            @csrf
                            @method('POST')
                            <button class="btn btn-success" onclick="return confirm('{{ $notice_reset_pw }}')" type="submit">{{ __('title.' . ($reset_text ?? 'reset-pw')) }}</button>
                        </form>
                    </td>
                @elseif ($value === 'pattern.image')
                    <td>
                        @if ($item->image)
                            <img src="{{ $item->image }}" alt="" srcset="" width="50" height="50">
                        @endif
                    </td>
                @elseif (strpos($value, 'pivot.')===0)
                    <td class="{{ $key }}">{{ $item->pivot[str_replace('pivot.','',$value)] ?? '' }}</td>
                @elseif (strpos($value, 'custom.'))
                    <td>
                        @include($value,['item'=>$item])
                    </td>
                @else
                    <td class="{{ $key }}">{{ isset($$value) && is_array($$value) && array_key_exists($item->$value, $$value) ? $$value[$item->$value] : $item->$value }}</td>
                @endif

            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>


{{-- Example of invocation
@include('common.block.table', [
'fields' => [                               // Field name and value
'modify' => 'pattern.modified',         // pattern.modified is a specific value field
'exam-name' => 'name',                  // will show $item->name
'status' => 'status',
'exam-type' => 'type',
'created-at' => 'created_at'
],
'items' => $exams,                          // Parse data items
'edit_route' => 'exam-detail',              // When click on edit button
'ediit_text' => 'detail',                   // Modify text on edit button
'delete_route' => 'delete-exam',            // When click on delete button
'type' => [                                 // If it's necessary to transform value in exam-type column to a readable info
                                // use name of the value field with the corresponding value
'multiple_choice' => __('title.multi_choice'),
'mixing' => __('title.mixing')
]
]) --}}
