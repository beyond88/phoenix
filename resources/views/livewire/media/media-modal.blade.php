<div>
    <div class="container" id="media-container" style="max-height: 400px; overflow-y: auto !important;" wire:scroll.debounce.200ms="loadMore">
        <div class="row">
            @foreach($mediaItems as $item)
                <div class="col-md-6 col-lg-2 item attachment details">
                    <div class="attachment-preview js--select-attachment type-image subtype-png landscape">
                        <div class="thumbnail">
                            <div class="centered">
                                <img src="{{ asset('storage/media/' . $item['media_name']) }}" draggable="false" alt="{{ $item['media_name'] }}">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="check" tabindex="0">
                        <span class="media-modal-icon ms-1" data-feather="check" style="height:16px;width:15px;"></span>
                        <span class="screen-reader-text">Deselect</span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>