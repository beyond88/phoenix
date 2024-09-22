<div>
    <form class="mb-9">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
                <h2 class="mb-2">Edit Post</h2>
                <h5 class="text-body-tertiary fw-semibold">Edit post across your store</h5>
            </div>
            <div class="col-auto">
                <a href="{{ url('admin/posts') }}" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</a>
                <button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button" wire:click="setStatusAndUpdate('draft')">Draft</button>
                <button class="btn btn-primary mb-2 mb-sm-0" type="button" wire:click="setStatusAndUpdate('publish')">Publish</button>
            </div>
        </div>

        @if(session()->has('success'))
            <div class="row">
                <div class="col-md-12 col-xl-8">
                    <div class="alert alert-outline-success d-flex align-items-center" role="alert">
                        <span class="fas fa-check-circle text-success fs-5 me-3"></span>
                        <p class="mb-0 flex-1">{{ session()->get('success') }}</p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="row">
                <div class="col-md-12 col-xl-8">
                    <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                        <span class="fas fa-times-circle text-danger fs-5 me-3"></span>
                        <p class="mb-0 flex-1">{{ session()->get('error') }}</p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-5">
            <div class="col-12 col-xl-8">
                <h4 class="mb-3">Title</h4>
                <input class="form-control mb-5" type="text" wire:model="postTitle" value=""placeholder="Write title here..." />
                <div class="mb-6">
                    <h4 class="mb-3">Description</h4>
                    <livewire:quill :value="$postContent" :reset-flag="$resetQuillFlag" wire:key="quill-{{ $resetQuillFlag }}">
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-12">
                        <div class="editor-post-featured-image">
                            <div class="editor-post-featured-image__container">
                                <img class="card-img-top" id="featured_image_src" wire:ignore src="{{ url($this->mediaName)}}" alt="Post featured image">
                                <input type="hidden" name="featured_media_id" id="featured_media_id" wire:model="mediaId"/>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#featureImageModal">Set featured image</button>
                            </div>
                        </div>

                        <!-- Modal -->
                        @include("backend.layouts.media-modal")

                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Categories</h4>
                                <div class="row gx-3">
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                                <h5 class="mb-0 text-body-highlight me-2">Category</h5>
                                                <a class="fw-bold fs-9" href="{{ url('admin/posts/categories')}}" target="_blank">Add New Category</a>
                                            </div>
                                            <select class="form-select mb-3" aria-label="category" wire:model="categoryId">
                                                <option value="">Select a Category</option>
                                                @foreach($cats as $cat)
                                                    <option value="{{$cat->term_id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const insertButton = document.querySelector('#featureImageModal .btn-primary');
            let placeHolderImage = document.querySelector("#featured_image_src");
            placeHolderImage = placeHolderImage.src;

            if (insertButton) {
                insertButton.addEventListener('click', function() {
                    const selectedAttachment = document.querySelector('#media-container .attachment.details.selected');
                    if (selectedAttachment) {
                        const mediaId = selectedAttachment.getAttribute('data-id');
                        const mediaSrc = selectedAttachment.querySelector('img, video, audio, embed').src;
                        const featuredImage = document.querySelector('#featured_image_src');
                        if (featuredImage) {
                            featuredImage.src = mediaSrc;
                        }
                        
                        const hiddenField = document.querySelector('#featured_media_id');
                        if (hiddenField) {
                            hiddenField.value = mediaId;
                        }
                        
                        @this.set('mediaId', mediaId);
                        
                        const modal = document.querySelector('#featureImageModal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                    }
                });
            }
        </script>
    </form>
</div>