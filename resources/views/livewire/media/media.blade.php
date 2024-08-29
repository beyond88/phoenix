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
                                @foreach($mediaItems as $item)
                                <div class="col-md-6 col-lg-2 item attachment details">
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
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>