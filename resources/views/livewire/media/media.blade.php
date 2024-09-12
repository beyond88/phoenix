<div class="content">
    <div class="add-new-media-file-heading" style="">
        <h3 class="upload-cls">Media Library</h3>
        <a href="{{ url('admin/media/add') }}" class="btn btn-outline-primary me-1 mb-1">Add New Media File</a>
    </div>

    <div class="row g-5">
        <div class="col-12 col-xl-8">
            @if(session()->has('success'))
                <div class="alert alert-outline-success d-flex align-items-center" role="alert">
                    <span class="fas fa-check-circle text-success fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('success') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                    <span class="fas fa-times-circle text-danger fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('error') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    <div class="modal-content library">
        <div class="modal-body">
            <div class="media-toolbar">
                <div class="media-toolbar-secondary">
                    <a href="{{ url()->current() }}?mode=list" 
                        class="{{ request()->query('mode') == 'list' || !request()->has('mode') ? 'active' : '' }}" 
                        style="margin-right: 5px; text-decoration: none;">
                            <span data-feather="list"></span>
                    </a>
                    <a href="{{ url()->current() }}?mode=grid" 
                        class="{{ request()->query('mode') == 'grid' ? 'active' : '' }}" 
                        style="margin-right: 5px; text-decoration: none;">
                            <span data-feather="grid"></span>
                    </a>

                    <label for="media-attachment-filters" class="screen-reader-text">Filter by type</label>
                    <select id="media-attachment-filters" class="attachment-filters">
                        <option value="all">Images</option>
                        <option value="uploaded">Uploaded to this post</option>
                        <option value="unattached">Unattached</option>
                        <option value="mine">Mine</option>
                    </select>
                    <label for="media-attachment-date-filters" class="screen-reader-text">Filter by date</label>
                    <select id="media-attachment-date-filters" class="attachment-filters">
                        <option value="all">All dates</option>
                        <option value="0">August 2024</option>
                    </select>
                    <span class="spinner"></span>
                </div>
                <div class="media-toolbar-primary search-form">
                    <label for="media-search-input" class="media-search-input-label">Search media</label>
                    <input type="text" wire:model.debounce.300ms="searchTerm" id="media-search-input" class="search" placeholder="Search media files...">
                </div>
            </div>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-content-wrap">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @if($mode === 'list')
                        <div class="card shadow-none border mb-3">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div class="table-responsive">
                                        <table class="table table-sm fs-9 mb-0">
                                            <thead>
                                            <tr>
                                                <th class="sort border-top border-translucent">
                                                    <input type="checkbox">
                                                </th>
                                                <th class="sort border-top border-translucent" data-sort="name">File</th>
                                                <th class="sort border-top border-translucent" data-sort="email">Date</th>
                                                <th class="sort text-end align-middle pe-0 border-top border-translucent" scope="col">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody class="list" style="max-height: 600px; overflow-y: auto;" wire:scroll.debounce.200ms="loadMore">
                                                @if(empty($mediaItems))
                                                <tr>
                                                    <td class="align-middle">
                                                        No media files found.
                                                    </td>
                                                </tr>
                                                @else
                                                    @foreach($mediaItems as $item)
                                                    <tr wire:key="media-{{ $item->id }}">
                                                        <td class="align-middle">
                                                            <input type="checkbox">
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="attachment-list">
                                                                <img 
                                                                    src="{{ $this->getMediaPlaceholderIcon(asset('storage/media/' . $item->media_name)) }}" 
                                                                    draggable="false" 
                                                                    alt="{{ $item->media_name }}" 
                                                                    width="60px" 
                                                                    height="60px"
                                                                    data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})"
                                                                >
                                                                &nbsp; <a href="#!" data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})"><strong>{{ $item->media_name }}</strong></a>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $this->getFormattedDate( $item->created_at ) }}
                                                        </td>
                                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                                            <div class="btn-reveal-trigger position-static">
                                                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                                        <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                                    </svg>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                                    <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})">View</a>
                                                                    <a class="dropdown-item" href="{{ route('media.download', $item->id) }}" download>Download</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <button type="button" class="dropdown-item text-danger" wire:click="deleteMedia({{ $item->id }})">Delete</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        @if($this->hasMorePages)
                                            <div class="row">
                                                <div class="col-md-4 col-sm-hidden col-xs-hidden"></div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 button-load-area">
                                                    <button type="button" class="btn btn-primary me-1 mb-1" wire:click="loadMore" wire:loading.attr="disabled">
                                                        <span wire:loading.remove>Load More</span>
                                                        <span wire:loading>
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Loading...</span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="col-md-4 col-sm-hidden col-xs-hidden"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($mode === 'grid')
                        <div class="container">
                            <div class="row">
                                @if(empty($mediaItems))
                                    <div class="col-12">
                                        <p class="text-center">No media files found.</p>
                                    </div>
                                @else
                                    @foreach($mediaItems as $item)
                                        <div class="col-md-6 col-lg-2 item attachment details">
                                            <div class="attachment-preview js--select-attachment type-image subtype-png landscape" data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img 
                                                            src="{{ $this->getMediaPlaceholderIcon(asset('storage/media/' . $item->media_name)) }}" 
                                                            draggable="false" 
                                                            alt="{{ $item->media_name }}"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if($this->hasMorePages)
                            <div class="row">
                                <div class="col-md-4 col-sm-hidden col-xs-hidden"></div>
                                <div class="col-md-4 col-sm-12 col-xs-12 button-load-area">
                                    <button type="button" class="btn btn-primary me-1 mb-1" wire:click="loadMore" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Load More</span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            <span class="visually-hidden">Loading...</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-md-4 col-sm-hidden col-xs-hidden"></div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Livewire.on('media-deleted', function () {
                    var modal = new bootstrap.Modal(document.getElementById('verticallyCentered'));
                    modal.hide();
                });

                Livewire.on('error', function (event) {
                        alert(event.message); // Show error message if needed
                    });
                });
            </script>

            <div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Media Details</h5>
                            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close">
                                <span class="fas fa-times fs-9"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if($selectedMedia)
                                @php
                                    $filePath = storage_path('app/public/media/' . $selectedMedia->media_name);
                                    $mimeType = mime_content_type($filePath) ?? 'unknown';
                                    $extension = strtolower(pathinfo($selectedMedia->media_name, PATHINFO_EXTENSION));
                                @endphp

                                @switch($mimeType)
                                    {{-- Images --}}
                                    @case('image/jpg')
                                    @case('image/jpeg')
                                    @case('image/png')
                                    @case('image/gif')
                                    @case('image/webp')
                                    @case('image/svg+xml')  {{-- Ensure correct MIME for SVG --}}
                                        <img src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" class="img-fluid" alt="{{ $selectedMedia->media_name }}">
                                        @break

                                    {{-- Audio --}}
                                    @case('audio/mpeg')
                                    @case('audio/wav')
                                    @case('audio/ogg')
                                    @case('audio/x-m4a')
                                        <audio controls>
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the audio element.
                                        </audio>
                                        @break

                                    {{-- Video --}}
                                    @case('video/mp4')
                                    @case('video/quicktime')
                                    @case('video/x-msvideo')
                                    @case('video/x-ms-wmv')
                                    @case('video/3gpp')
                                    @case('video/ogg')
                                        <video controls width="100%">
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @break

                                    {{-- PDF --}}
                                    @case('application/pdf')
                                        <embed src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                        @break

                                    {{-- Office Documents (Group similar MIME types) --}}
                                    @case('application/msword')
                                    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                    @case('application/vnd.ms-powerpoint')
                                    @case('application/vnd.openxmlformats-officedocument.presentationml.presentation')
                                    @case('application/vnd.ms-excel')
                                    @case('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                        <embed src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}" width="100%" height="500px" />
                                        @break

                                    {{-- Default for unknown or unhandled file types --}}
                                    @default
                                        @php
                                            $iconMap = [
                                                'zip' => 'archive.svg',
                                                'rar' => 'archive.svg',
                                                '7z'  => 'archive.svg',
                                                'psd' => 'psd.svg',
                                                'xml' => 'xml.svg',
                                                'default' => 'default.svg'
                                            ];
                                            $icon = $iconMap[$extension] ?? 'default.svg';
                                        @endphp
                                        <div class="file-icon">
                                            <img src="{{ asset('img/placeholders/' . $icon) }}" alt="{{ $extension }} file" width="100">
                                            <p>{{ $selectedMedia->media_name }}</p>
                                        </div>
                                @endswitch

                                {{-- Additional media details --}}
                                <div class="media-item-details" style="margin-top: 20px;">
                                    <h5>{{ $selectedMedia->media_name }}</h5>
                                    <p>File type: {{ $mimeType }}</p>
                                </div>
                            @else
                                <p>No media selected.</p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            
                            @if($selectedMedia)
                                <a href="{{ route('media.download', $selectedMedia->id) }}" class="btn btn-outline-success me-1 mb-1" type="button" download>Download</a>
                            @endif
                            <button class="btn btn-outline-primary me-1 mb-1" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
