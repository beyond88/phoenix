        
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
            document.addEventListener('DOMContentLoaded', function() {
                const attachmentPreviews = document.querySelectorAll('#media-container .attachment-preview .thumbnail');
                attachmentPreviews.forEach(preview => {
                    preview.addEventListener('click', function(event) {
                        event.stopPropagation();
                        attachmentPreviews.forEach(item => item.closest('.attachment.details').classList.remove('selected'));
                        const attachment = this.closest('.attachment.details');
                        if (attachment) {
                            attachment.classList.add('selected');
                        }
                    });
                });
            });
        </script>
        @livewireScripts
    </body>
</html>