<!-- The Modal -->
<div class="modal fade" id={{ $id_modal }}>
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">{{ __('title.confirm') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
        {{ $content }}
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('title.cancel') }}</button>
        <button form="{{ $id_form }}" type="submit" class="btn btn-success">{{ $name_but }}</button>
        </div>

    </div>
    </div>
</div>
