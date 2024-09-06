<div>
    <div class="container" id="media-container" style="max-height: 400px; overflow-y: auto !important;" wire:scroll.debounce.200ms="loadMore">
        <div class="row">
            @foreach($mediaItems as $item)
                <div class="col-md-6 col-lg-2 item attachment details" aria-label="{{ $item->media_name }}" data-id="{{ $item->id }}">
                    <div class="attachment-preview js--select-attachment type-image subtype-png landscape">
                        <div class="thumbnail">
                            <div class="centered">
                                @php
                                    $extension = pathinfo($item->media_name, PATHINFO_EXTENSION);
                                    $mimeType = mime_content_type(storage_path('app/public/media/' . $item->media_name));
                                @endphp
                                @switch($mimeType)
                                    @case('image/jpeg')
                                    @case('image/png')
                                    @case('image/gif')
                                    @case('image/webp')
                                        <img src="{{ asset('storage/media/' . $item->media_name) }}" draggable="false" alt="{{ $item->media_name }}">
                                        @break

                                    @case('audio/mpeg')
                                    @case('audio/wav')
                                    @case('audio/ogg')
                                        <audio controls>
                                            <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the audio element.
                                        </audio>
                                        @break

                                    @case('video/mp4')
                                    @case('video/avi')
                                    @case('video/mpeg')
                                        <video controls width="100%">
                                            <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @break

                                    @case('application/pdf')
                                        <embed src="{{ asset('storage/media/' . $item->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                        @break

                                    @case('application/msword')
                                    @case('application/vnd.ms-excel')
                                    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                    @case('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                        <div class="file-icon">
                                            <i class="fas fa-file-alt"></i>
                                            <p>{{ $item->media_name }}</p>
                                        </div>
                                        @break

                                    @default
                                        <div class="file-icon">
                                            <i class="fas fa-file"></i>
                                            <p>{{ $item->media_name }}</p>
                                        </div>
                                @endswitch
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