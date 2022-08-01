<div class="modal fade" id="{{ $name ?? 'confirm-modal' }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('title.'.( $title ?? ($name ?? 'confirm') )) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('title.'.($message ?? 'confirm')) }}</p>
                <div>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('title.'.($cancel ?? 'cancel')) }}</button>
                    <button class="btn btn-primary {{ $confirmed['class'] ?? '' }}" id="{{$confirmed['id'] ?? ''}}" >{{ __('title.'.($confirmed['title'] ?? 'continue')) }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
