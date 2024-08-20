@extends("backend.layouts.layout")
@section("title", "Media Library | Phoenix")

@section("content")

<main class="main" id="top">
    @include("backend.layouts.sidebar")

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


                {{-- Upload Feature Image --}}
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-content-wrap">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
        </div>
    </div>

    </div>
</main>

@endsection
