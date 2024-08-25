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
                                                <img src="{{ asset('storage/media/' . $item->media_name) }}" draggable="false" alt="{{ $item->media_name }}">
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