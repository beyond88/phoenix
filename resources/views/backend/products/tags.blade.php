@extends("backend.layouts.layout")
@section("title", "Tags | Phoenix")
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
               <h2 class="mb-2">Tags</h2>
               <h5 class="text-body-tertiary fw-semibold">Create product tags across your store</h5>
            </div>
            <div class="col-auto">
               <button class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</button>
               <button class="btn btn-phoenix-primary me-2 mb-2 mb-sm-0" type="button">Save Draft</button>
               <button class="btn btn-primary mb-2 mb-sm-0" type="submit">Save</button>
            </div>
         </div>
         <div class="row g-5">
            <div class="col-12 col-xl-8">
               <h4 class="mb-3">Name</h4>
               <input class="form-control mb-5" type="text" placeholder="" />
               <h4 class="mb-3">Slug</h4>
               <input class="form-control mb-5" type="text" placeholder="" />
            </div>
            <div class="col-12 col-xl-4">
               <div class="row g-2">
                  <div class="col-12 col-xl-12">
                     <div class="card mb-3">
                        <div class="card-body">
                           <h4 class="card-title mb-4">Tags</h4>
                           <div class="row gx-3">
                              <div class="col-12 col-sm-6 col-xl-12">
                                 <div class="mb-4">
                                 </div>
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
               <p class="mb-0 mt-2 mt-sm-0 text-body">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2024 &copy;<a class="mx-1" href="#">Themewagon</a></p>
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