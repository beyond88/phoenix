@extends("backend.layouts.layout")
@section("title", "Add New Media File | Phoenix")

@section("content")

<main class="main" id="top">
    @include("backend.layouts.sidebar")

    <div class="content create-media">
        <h3 class="upload-cls">Upload New Media</h3>

        <form action="" class="" id="mediaDropzone" method="POST" enctype="multipart/form-data">
            @csrf

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
        </form>

        {{-- Intructions --}}
        <p class="upload-flash-bypass">You are using the multi-file uploader. Problems? Try the <a href="#" target="_blank">browser uploader</a> instead.</p>
        <p class="max-upload-size">Maximum upload file size: 512 MB.</p>

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
