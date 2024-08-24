<div class="content create-media">
    <h3 class="upload-cls">Upload New Media</h3>

    @if(session()->has('success'))
        <div class="alert alert-outline-success d-flex align-items-center" role="alert">
            <span class="fas fa-check-circle text-success fs-5 me-3"></span>
            <p class="mb-0 flex-1">{{ session()->get('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form  class="" id="mediaDropzone" enctype="multipart/form-data">
        @csrf

        <div class="dropzone dropzone-multiple p-0 mb-5" id="my-awesome-dropzone" data-dropzone="data-dropzone" data-options='{"url":"admin/media/upload"}'>

            <div class="fallback">
                <input name="file" type="file" multiple="multiple"/>
            </div>
            <div class="dz-preview d-flex flex-wrap">
                <div class="border border-translucent bg-body-emphasis rounded-3 d-flex flex-center position-relative me-2 mb-2" style="height:80px;width:80px;">
                    <img class="dz-image" src="{{ url('img/products/23.png') }}" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                    <a class="dz-remove text-body-quaternary" href="#!" data-dz-remove="data-dz-remove"><span data-feather="x"></span></a>
                </div>
            </div>
            <div class="dz-message text-body-tertiary text-opacity-85" data-dz-message="data-dz-message">Drag your photo here<span class="text-body-secondary px-1">or</span>
                <button class="btn btn-link p-0" type="button">Browse from device</button><br />
                <img class="mt-3 me-2" src="{{ url('img/icons/image-icon.png') }}" width="40" alt="" />
            </div>
        </div>
    </form>

    {{-- Intructions --}}
    <p class="upload-flash-bypass">You are using the multi-file uploader. Problems? Try the <a href="#" target="_blank">browser uploader</a> instead.</p>
    <p class="max-upload-size">Maximum upload file size: 512 MB.</p>
</div>

