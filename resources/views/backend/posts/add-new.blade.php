@extends("backend.layouts.layout")
@section("title", "Add New Post | Phoenix")
@section("content")
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
   @include("backend.layouts.sidebar")
   <div class="content">
      <nav class="mb-2" aria-label="breadcrumb">
         <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
            <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
            <li class="breadcrumb-item active">Default</li>
         </ol>
      </nav>
      <form class="mb-9">
         <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
               <h2 class="mb-2">Add New Post</h2>
               <h5 class="text-body-tertiary fw-semibold">Create post across your store</h5>
            </div>
            <div class="col-auto">
               <button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</button>
               <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0" type="button">Save Draft</button>
               <button class="btn btn-primary mb-2 mb-sm-0" type="submit">Publish</button>
            </div>
         </div>
         <div class="row g-5">
            <div class="col-12 col-xl-8">
               <h4 class="mb-3">Title</h4>
               <input class="form-control mb-5" type="text" placeholder="Write title here..." />
               <div class="mb-6">
                  <h4 class="mb-3">Description</h4>
                  <textarea class="tinymce" name="content"></textarea>
               </div>
            </div>



            <div class="col-12 col-xl-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-12">
                        <!-- Button to open the modal -->
                        <div class="editor-post-featured-image">
                            <div class="editor-post-featured-image__container">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#featureImageModal">Set featured image</button>
                            </div>
                        </div>

                        <!-- Modal -->
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
                                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Upload Files</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Media Library</button>
                                            </li>
                                        </ul>


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

                                                            {{-- Add another div --}}
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

                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Categories</h4>
                                <div class="row gx-3">
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                            <h5 class="mb-0 text-body-highlight me-2">Category</h5>
                                            <a class="fw-bold fs-9" href="#!">Add new category</a>
                                            </div>
                                            <select class="form-select mb-3" aria-label="category">
                                            <option value="men-cloth">Men's Clothing</option>
                                            <option value="women-cloth">Womens's Clothing</option>
                                            <option value="kid-cloth">Kid's Clothing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap mb-2">
                                            <h5 class="mb-0 text-body-highlight me-2">Author</h5>
                                            </div>
                                            <select class="form-select mb-3" aria-label="category">
                                            <option value="men-cloth">Men's Clothing</option>
                                            <option value="women-cloth">Womens's Clothing</option>
                                            <option value="kid-cloth">Kid's Clothing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-12">
                                        <div class="d-flex flex-wrap mb-2">
                                            <h5 class="mb-0 text-body-highlight me-2">Tags</h5>
                                            <a class="fw-bold fs-9 lh-sm" href="#!">View all tags</a>
                                        </div>
                                        <select class="form-select" aria-label="category">
                                            <option value="men-cloth">Men's Clothing</option>
                                            <option value="women-cloth">Womens's Clothing</option>
                                            <option value="kid-cloth">Kid's Clothing</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
         </div>
      </form>
      <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-body">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2024 &copy;<a class="mx-1" href="https://themewagon.com">Themewagon</a></p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-body-tertiary text-opacity-85">v1.17.0</p>
                </div>
            </div>
      </footer>
   </div>
</main>


<style>
    .tox-notification.tox-notification--in.tox-notification--warning {
        display: none !important;
    }
    .modal-dialog .col-md-6.col-lg-2.item {
        margin-bottom: 30px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attachmentPreviews = document.querySelectorAll('.attachment-preview .thumbnail');
        attachmentPreviews.forEach(preview => {
            preview.addEventListener('click', function(event) {
                event.stopPropagation();
                const attachment = this.closest('.attachment.details');
                if (attachment) {
                    attachment.classList.toggle('selected');
                }
            });
        });

        // Hide the .tox-notifications-container element after the DOM is fully loaded
        const notificationElement = document.querySelector('.tox-notification--warning');
        if (notificationElement) {
            notificationElement.style.display = 'none';
        }
    });
</script>

<style>
    #featureImageModal {
        z-index: 99999;
    }
    #featureImageModal .modal-dialog {
        max-width: 65%;
        min-height: 700px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
        gap: 10px;
    }

    #featureImageModal button#profile-tab {
        cursor: pointer;
    }

    .tab-content-wrap .tab-pane {
        display: none;
    }
    .tab-content-wrap .tab-pane.active {
        display: block;
    }

.dropzone.dropzone-multiple .dz-message {
    height: 91%;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
}
div#myTabContent {
    height: 100%;
}
.dropzone.dropzone-multiple {
    border: 0;
    height: 100%;
}
div#home {
    height: 100%;
}
.tab-content-wrap {
    height: 100%;
}

.editor-post-featured-image .btn.btn-primary {
    width: 100%;
    margin-bottom: 30px;
    box-shadow: inset 0 0 0 1px #ccc;
    height: 100%;
    line-height: 20px;
    text-align: center;
    align-items: center;
    -webkit-appearance: none;
    background: none;
    border: 0;
    box-sizing: border-box;
    color: #1e1e1e;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    padding: 16px 12px;
    text-decoration: none;
    transition: box-shadow .1s linear;
    text-align: center;
    border-radius: 6px;
}

.editor-post-featured-image .btn.btn-primary:hover {
    color: #3874ff
}
.tox-statusbar {
    display: none !important;
}



.attachment.details.selected {
    box-shadow: inset 0 0 0 3px #fff, inset 0 0 0 7px #2271b1;
}
.attachment-preview {
    position: relative;
    box-shadow: inset 0 0 15px rgba(0, 0, 0, .1), inset 0 0 0 1px rgba(0, 0, 0, .05);
    background: #f0f0f1;
    cursor: pointer;
    overflow: hidden;
}
.attachment-preview:before {
    content: "";
    display: block;
    padding-top: 100%;
}
.attachment {
    position: relative;
    float: left;
    padding: 8px;
    margin: 0;
    color: #3c434a;
    cursor: pointer;
    list-style: none;
    text-align: center;
    -webkit-user-select: none;
    user-select: none;
    box-sizing: border-box;
}
.attachment .thumbnail .centered {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: translate(50%, 50%);
}
.attachment .thumbnail .centered img {
    transform: translate(-50%, -50%);
}
.attachment .thumbnail img {
    position: absolute;
}

.attachment .thumbnail img {
    top: 0;
    left: 0;
}
.attachment .landscape img {
    max-height: 100%;
}
.attachment .thumbnail:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .1);
    overflow: hidden;
}
.attachment.details .check, .attachment.selected .check:focus, .media-frame.mode-grid .attachment.selected .check {
    background-color: #2271b1;
    box-shadow: 0 0 0 1px #fff, 0 0 0 2px #2271b1;
}
.attachment .check {
    display: none;
    height: 24px;
    width: 24px;
    padding: 0;
    border: 0;
    position: absolute;
    z-index: 10;
    top: 0;
    right: 0;
    outline: 0;
    background: #f0f0f1;
    cursor: pointer;
    box-shadow: 0 0 0 1px #fff, 0 0 0 2px rgba(0, 0, 0, .15);
    color: #fff;
}
.attachment.selected .check {
    display: block;
}
.attachment .check .media-modal-icon {
    display: block;
    background-position: -1px 0;
    height: 15px;
    width: 15px;
    margin: 5px;
}
.screen-reader-text {
    border: 0;
    clip: rect(1px, 1px, 1px, 1px);
    clip-path: inset(50%);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
    word-wrap: normal !important;
}
</style>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
@endsection