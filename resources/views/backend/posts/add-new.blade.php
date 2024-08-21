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
                            @include("backend.layouts.media-modal")

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
        
        @include("backend.layouts.copyright")
   </div>
</main>

<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
@endsection