<div class="modal fade" id="featureImageModal" tabindex="-1" aria-labelledby="featureImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="featureImageModalLabel">Select or Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="media-modal-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0 nav-link active" id="uploader-tab" data-bs-toggle="tab" data-bs-target="#uploader" type="button" role="tab" aria-controls="uploader" aria-selected="true">Upload Files</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0 nav-link" id="library-tab" data-bs-toggle="tab" data-bs-target="#library" type="button" role="tab" aria-controls="library" aria-selected="false">Media Library</button>
                    </li>
                </ul>

                <div class="media-toolbar">
                    <!-- Your filter toolbar here -->
                </div>

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-content-wrap">
                        <div class="tab-pane fade show active" id="uploader" role="tabpanel" aria-labelledby="uploader-tab">
                            <div class="dropzone dropzone-multiple p-0 mb-5" id="my-awesome-dropzone" data-dropzone="data-dropzone">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple" />
                                </div>
                                <div class="dz-preview d-flex flex-wrap">
                                    <div class="border border-translucent bg-body-emphasis rounded-3 d-flex flex-center position-relative me-2 mb-2" style="height:80px;width:80px;">
                                        <img class="dz-image" src="{{ url('img/products/23.png') }}" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                                        <a class="dz-remove text-body-quaternary" href="#!" data-dz-remove="data-dz-remove">
                                            <span data-feather="x"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dz-message text-body-tertiary text-opacity-85" data-dz-message="data-dz-message">Drag your photo here<span class="text-body-secondary px-1">or</span>
                                    <button class="btn btn-link p-0" type="button">Browse from device</button>
                                    <br />
                                    <img class="mt-3 me-2" src="{{ url('img/icons/image-icon.png') }}" width="40" alt="" />
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="library" role="tabpanel" aria-labelledby="library-tab">
                            @livewire('media.media-modal')
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="insert-this-into-content" class="btn btn-primary">Insert</button>
            </div>
        </div>
    </div>
</div>


