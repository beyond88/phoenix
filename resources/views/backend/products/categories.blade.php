@extends("backend.layouts.layout")
@section("title", "Categories | Phoenix")
@section("content")    
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
   @include("backend.layouts.sidebar")
   <div class="content">
      
      @include("backend.layouts.breadcrumb")

      <form class="mb-9">
         <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
               <h2 class="mb-2">Categories</h2>
               <h5 class="text-body-tertiary fw-semibold">Create product categories across your store</h5>
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
                           <h4 class="card-title mb-4">Categories</h4>
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

      @include("backend.layouts.copyright")
   </div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
@endsection