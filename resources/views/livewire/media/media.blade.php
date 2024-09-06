<div class="content">
    <h3 class="upload-cls">Media Library</h3>
    <div class="modal-content library">
        <div class="modal-body">
            <div class="media-toolbar">
                <div class="media-toolbar-secondary">
                    <h2 class="media-attachments-filter-heading">Filter media</h2>
                    <label for="media-attachment-filters" class="screen-reader-text">Filter by type</label>
                    <select id="media-attachment-filters" class="attachment-filters">
                        <option value="all">Images</option>
                        <option value="uploaded">Uploaded to this post</option>
                        <option value="unattached">Unattached</option>
                        <option value="mine">Mine</option>
                    </select>
                    <label for="media-attachment-date-filters" class="screen-reader-text">Filter by date</label>
                    <select id="media-attachment-date-filters" class="attachment-filters">
                        <option value="all">All dates</option>
                        <option value="0">August 2024</option>
                    </select>
                    <span class="spinner"></span>
                </div>
                <div class="media-toolbar-primary search-form">
                    <label for="media-search-input" class="media-search-input-label">Search media</label>
                    <input type="search" id="media-search-input" class="search">
                </div>
            </div>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-content-wrap">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="container" style="max-height: 600px; overflow-y: auto;" wire:scroll.debounce.200ms="loadMore">
                            <div class="row">
                                @if(empty($mediaItems))
                                    <div class="col-12">
                                        <p class="text-center">No media items available.</p>
                                    </div>
                                @else
                                    @foreach($mediaItems as $item)
                                        <div class="col-md-6 col-lg-2 item attachment details">
                                            <div class="attachment-preview js--select-attachment type-image subtype-png landscape" data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})">
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
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Attachment details</h5>
                            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close">
                                <span class="fas fa-times fs-9"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if($selectedMedia)                                
                                @php
                                    $mimeType = mime_content_type(storage_path('app/public/media/' . $selectedMedia->media_name));
                                @endphp

                                @switch($mimeType)
                                    @case('image/jpeg')
                                    @case('image/png')
                                    @case('image/gif')
                                    @case('image/webp')
                                        <img src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" class="img-fluid" alt="{{ $selectedMedia->media_name }}">
                                        @break

                                    @case('audio/mpeg')
                                    @case('audio/wav')
                                    @case('audio/ogg')
                                        <audio controls>
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the audio element.
                                        </audio>
                                        @break

                                    @case('video/mp4')
                                    @case('video/avi')
                                    @case('video/mpeg')
                                        <video controls width="100%">
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @break

                                    @case('application/pdf')
                                        <embed src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                        @break

                                    @default
                                        <div class="file-icon">
                                            <i class="fas fa-file"></i>
                                            <p>{{ $selectedMedia->media_name }}</p>
                                        </div>
                                @endswitch
                                
                                <div class="media-item-details" style="margin-top: 20px;">
                                    <h5>{{ $selectedMedia->media_name }}</h5>
                                    <p>File type: {{ mime_content_type(storage_path('app/public/media/' . $selectedMedia->media_name)) }}</p>
                                </div>
                            @else
                                <p>No media selected.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn btn-primary" type="button">Okay</button> -->
                            <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
