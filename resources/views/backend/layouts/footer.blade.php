        @livewireScripts

        <!-- ===============================================-->
        <!--    JavaScripts -->
        <!-- ===============================================-->
        <script src="{{ url('js/popper.min.js') }}"></script>
        <script src="{{ url('js/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/anchor.min.js') }}"></script>
        <script src="{{ url('js/is.min.js') }}"></script>
        <script src="{{ url('js/all.min.js') }}"></script>
        <script src="{{ url('js/lodash.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@babel/polyfill/dist/polyfill.min.js"></script>
        <script src="{{ url('js/list.min.js') }}"></script>
        <script src="{{ url('js/feather.min.js') }}"></script>
        <script src="{{ url('js/dayjs.min.js') }}"></script>
        <script src="{{ url('js/tinymce.min.js') }}"></script>
        <script src="{{ url('js/dropzone-min.js') }}"></script>
        <script src="{{ url('js/choices.min.js') }}"></script>
        <script src="{{ url('js/flatpickr.min.js') }}"></script>
        <script src="{{ url('js/phoenix.js') }}"></script>
        <script src="{{ url('js/leaflet.js') }}"></script>
        <script src="{{ url('js/leaflet.markercluster.js') }}"></script>
        <script src="{{ url('js/leaflet-tilelayer-colorfilter.min.js') }}"></script>
        <script src="{{ url('js/echarts.min.js') }}"></script>
        <script src="{{ url('js/ecommerce-dashboard.js') }}"></script>

        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                ],
                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
            });


            // Media popup modal
            // document.addEventListener('DOMContentLoaded', function() {
            //     const attachmentPreviews = document.querySelectorAll('.attachment-preview .thumbnail');
            //     attachmentPreviews.forEach(preview => {
            //         preview.addEventListener('click', function(event) {
            //             event.stopPropagation();
            //             const attachment = this.closest('.attachment.details');
            //             if (attachment) {
            //                 attachment.classList.toggle('selected');
            //             }
            //         });
            //     });
            // });

        </script>

        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#verticallyCentered">Vertically centered modal</button>
        <div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticallyCenteredModalLabel">Modal title</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs-9"></span></button>
                </div>
                <div class="modal-body">
                    <p class="text-body-tertiary lh-lg mb-0">This is a static modal example (meaning its position and display have been overridden). Included are the modal header, modal body (required for padding), and modal footer (optional). </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button">Okay</button>
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>