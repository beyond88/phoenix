<div class="modal fade" id="featureImageModal" tabindex="-1" aria-labelledby="featureImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="featureImageModalLabel">Featured image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0 nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Upload Files</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0 nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Media Library</button>
                    </li>
                </ul>

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


                {{-- Upload Feature Image --}}
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-content-wrap">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="dropzone dropzone-multiple p-0 mb-5" id="my-awesome-dropzone" data-dropzone="data-dropzone">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple" />
                                </div>
                                <div class="dz-preview d-flex flex-wrap">
                                    <div class="border border-translucent bg-body-emphasis rounded-3 d-flex flex-center position-relative me-2 mb-2" style="height:80px;width:80px;"><img class="dz-image" src="{{ url('img/products/23.png') }}" alt="..." data-dz-thumbnail="data-dz-thumbnail" /><a class="dz-remove text-body-quaternary" href="#!" data-dz-remove="data-dz-remove"><span data-feather="x"></span></a></div>
                                </div>
                                <div class="dz-message text-body-tertiary text-opacity-85" data-dz-message="data-dz-message">Drag your photo here<span class="text-body-secondary px-1">or</span>
                                    <button class="btn btn-link p-0" type="button">Browse from device</button><br /><img class="mt-3 me-2" src="{{ url('img/icons/image-icon.png') }}" width="40" alt="" />
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 col-lg-2 item attachment details">
                                        <div class="attachment-preview js--select-attachment type-image subtype-png landscape">
                                            <div class="thumbnail">
                                                <div class="centered">
                                                    <img src="https://res.cloudinary.com/dpnaptcei/image/upload/v1537070505/Gallery/image1.jpg" draggable="false" alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="check" tabindex="0">
                                            <span class="media-modal-icon ms-1" data-feather="check" style="height:16px;width:15px;"></span>
                                            <span class="screen-reader-text">Deselect</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>