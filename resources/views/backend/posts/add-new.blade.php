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

               <h4 class="mb-3">Feature Images</h4>
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
            <div class="col-12 col-xl-4">
               <div class="row g-2">
                  <div class="col-12 col-xl-12">
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
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
@endsection