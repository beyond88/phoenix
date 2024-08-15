@extends("backend.layouts.layout")
@section("title", "Add New Media File | Phoenix")

@section("content")

<main class="main" id="top">
    @include("backend.layouts.sidebar")

    <div class="content">
        <h1>Upload New Media</h1>

        <form action="  " class="dropzone" id="mediaDropzone" method="POST" enctype="multipart/form-data">
            @csrf
        </form>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.10.2/dropzone.min.js"></script>
        <script>
            Dropzone.options.mediaDropzone = {
                paramName: "file",
                maxFilesize: 20, // MB
                acceptedFiles: "image/*,application/pdf,video/*,audio/*",
                success: function (file, response) {
                    console.log('File uploaded successfully:', response);
                },
                error: function (file, response) {
                    console.error('Error uploading file:', response);
                }
            };
        </script>
    </div>
</main>

@endsection
