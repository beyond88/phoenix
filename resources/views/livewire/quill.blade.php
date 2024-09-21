<div
    wire:ignore
    x-data="{ 
        quill: null,
        resetFlag: @entangle('resetFlag'),
        init() {
            this.quill = new Quill('#{{ $quillId }}', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            this.quill.root.innerHTML = @js($value);

            this.quill.on('text-change', () => {
                $wire.set('value', this.quill.root.innerHTML);
            });

            this.$watch('resetFlag', () => {
                this.quill.setContents([]);
                $wire.set('value', '');
            });
        }
    }"
>
    <!-- Include stylesheet -->
    <link href="{{ url('css/quill.snow.css') }}" type="text/css" rel="stylesheet" id="quill-snow-css">
    <style>
        .ql-toolbar.ql-snow{
            background-color: #fff;
            border: var(--phoenix-border-width) solid var(--phoenix-border-color);
            border-top-right-radius: var(--phoenix-border-radius);
            border-top-left-radius: var(--phoenix-border-radius);
        }
        .ql-container{
            height: 300px;
            background-color: #fff;
            border-bottom-right-radius: var(--phoenix-border-radius);
            border-bottom-left-radius: var(--phoenix-border-radius);
        }
    </style>
    <!-- Create the editor container -->
    <div id="{{ $quillId }}"></div>

    <!-- Include the Quill library -->
    <script src="{{ url('js/quill.js') }}"></script>

    <script>
        window.addEventListener('reset-quill-editor', function(event) {
            if (event.detail.quillId === '{{ $quillId }}') {
                if (this.quill) {
                    this.quill.setText('');
                }
            }
        });
        $wire.on('reinit', () => {
            this.quill.root.innerHTML = @js($value);
        });
    </script>


</div>