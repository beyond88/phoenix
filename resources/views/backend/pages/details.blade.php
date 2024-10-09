@extends("backend.layouts.layout")
@section("title", "Edit Page | Phoenix")
@section("content")    
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
   @include("backend.layouts.sidebar")
   <div class="content">
      @include("backend.layouts.breadcrumb")
      
      @livewire('pages.edit', ['id' => $id])

      @include("backend.layouts.copyright")
   </div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
@endsection