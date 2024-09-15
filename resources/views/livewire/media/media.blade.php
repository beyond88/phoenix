<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="add-new-media-file-heading" style="">
                <h3 class="upload-cls">Media Library</h3>
                <a href="{{ url('admin/media/add') }}" class="btn btn-outline-primary me-1 mb-1">Add New Media File</a>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="alert alert-outline-success d-flex align-items-center" role="alert">
                    <span class="fas fa-check-circle text-success fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('success') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                    <span class="fas fa-times-circle text-danger fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('error') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row padding-20">
        <div class="col-lg-4 padding-20 listing-mode bg-white ph-flex">
            <a href="{{ url('admin/media?mode=list') }}" 
                class="{{ request()->query('mode') == 'list' || !request()->has('mode') ? 'active' : '' }}" 
                style="margin-right: 5px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            </a>
            <a href="{{ url('admin/media?mode=grid') }}" 
                class="{{ request()->query('mode') == 'grid' ? 'active' : '' }}" 
                style="margin-right: 10px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </a>
            @if( $this->monthCount || ( 1 === $this->monthCount && 0 === (int) $this->months[0]->month ) )
            <select name="m" id="media-attachment-date-filters" class="form-select" style="margin-right: 10px">
                <option value="all">All dates</option>
                @foreach ($this->months as $arc_row)
                    @if ((int) $arc_row->year === 0)
                        @continue
                    @endif

                    @php
                        $month = $this->zeroise($arc_row->month, 2, '0', STR_PAD_LEFT); // Zeroise month
                        $year = $arc_row->year;
                        $value = $year . $month;
                    @endphp

                    <option value="{{ $value }}">
                        {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
                    </option>
                @endforeach
            </select>
            <button type="button" 
                class="btn btn-outline-primary" 
                >
                Filter
            </button>
            @endif
        </div>
        <div class="col-lg-5 padding-20 bg-white col-sm-hidden col-xs-hidden"></div>
        <div class="col-lg-3 padding-20 bg-white">
            <div class="row ph-flex">
                <div class="col-sm-8">
                    <input 
                        type="text"
                        class="form-control" 
                        wire:model="search"
                        placeholder="Search media files..."
                    >
                </div>
                <div class="col-sm-4">
                    <button type="button" 
                        class="btn btn-outline-primary" 
                        wire:click="performSearch">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row margin-top-bottom-20">
        <div class="col-lg-3" style="display:flex;padding-left:0px;">
            <select id="media-buil-actions" class="form-select" wire:model="bulkAction" style="margin-right:20px;">
                <option value="">Bulk Actions</option>
                <option value="delete">Delete Permanently</option>
            </select>
            <button type="button" name="apply" id="apply" class="btn btn-outline-primary me-1 mb-1 padding-top-bottom-btn" wire:click="applyBulkAction" wire:loading.attr="disabled">
                <span wire:loading.remove>Apply</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="visually-hidden">Processing...</span>
                </span>
            </button>
        </div>
        <div class="col-lg-8 col-sm-hidden col-xs-hidden"></div>
        <div class="col-lg-1" style="text-align:right;">
            <div class="media-toolbar-primary search-form">
                {{ $this->totalMediaCount }} items
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if($mode === 'list')
            <div class="card shadow-none border mb-3">
                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <div class="table-responsive">
                            <table class="table table-sm fs-9 mb-0" style="overflow-y: auto;">
                                <thead>
                                <tr>
                                    <th class="sort border-top border-translucent">
                                        <input type="checkbox" class="select-all-checkbox" id="select-all-media" wire:model="selectAll" wire:click="toggleSelectAll">                                            
                                    </th>
                                    <th class="sort border-top border-translucent">
                                        <a href="#" wire:click.prevent="sortBy('media_name')">
                                            File Name
                                            @if($sortField === 'media_name')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="sort border-top border-translucent">
                                        <a href="#" wire:click.prevent="sortBy('created_at')">
                                            Date
                                            @if($sortField === 'created_at')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="sort text-end align-middle pe-0 border-top border-translucent" scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list media-list">
                                    @if($isEmptyResult)
                                    <tr>
                                        <td class="align-middle" colspan="4">
                                            No media files found.
                                        </td>
                                    </tr>
                                    @else
                                        @foreach($mediaItems as $item)
                                        <tr wire:key="media-item-{{ $item->id }}">
                                            <td class="align-middle">
                                                <input type="checkbox" class="select-all-checkbox" value="{{ $item->id }}" wire:model="selectedMedia" @if(in_array($item->id, $selectedMedia)) checked @endif>
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
                                    @if($this->hasMorePages)
                                        <tr>
                                            <td colspan="4">
                                                <div class="margin-top-20 text-align-center">
                                                    <button type="button" class="btn btn-primary me-1 mb-1" wire:click="loadMore" wire:loading.attr="disabled">
                                                        <span wire:loading.remove>Load More</span>
                                                        <span wire:loading>
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Loading...</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($mode === 'grid')
            <div class="container">
                <div class="row">
                    @if($isEmptyResult)
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
                    <div class="col-md-4 col-sm-12 col-xs-12 margin-top-20">
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

    <!--- Modal --->
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
                    @if($popupMedia)
                        @php
                            $filePath = storage_path('app/public/media/' . $popupMedia->media_name);
                            $mimeType = mime_content_type($filePath) ?? 'unknown';
                            $extension = strtolower(pathinfo($popupMedia->media_name, PATHINFO_EXTENSION));
                        @endphp

                        @switch($mimeType)
                            {{-- Images --}}
                            @case('image/jpg')
                            @case('image/jpeg')
                            @case('image/png')
                            @case('image/gif')
                            @case('image/webp')
                            @case('image/svg+xml')  {{-- Ensure correct MIME for SVG --}}
                                <img src="{{ asset('storage/media/' . $popupMedia->media_name) }}" class="img-fluid" alt="{{ $popupMedia->media_name }}">
                                @break

                            {{-- Audio --}}
                            @case('audio/mpeg')
                            @case('audio/wav')
                            @case('audio/ogg')
                            @case('audio/x-m4a')
                                <audio controls>
                                    <source src="{{ asset('storage/media/' . $popupMedia->media_name) }}" type="{{ $mimeType }}">
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
                                    <source src="{{ asset('storage/media/' . $popupMedia->media_name) }}" type="{{ $mimeType }}">
                                    Your browser does not support the video tag.
                                </video>
                                @break

                            {{-- PDF --}}
                            @case('application/pdf')
                                <embed src="{{ asset('storage/media/' . $popupMedia->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                @break

                            {{-- Office Documents (Group similar MIME types) --}}
                            @case('application/msword')
                            @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                            @case('application/vnd.ms-powerpoint')
                            @case('application/vnd.openxmlformats-officedocument.presentationml.presentation')
                            @case('application/vnd.ms-excel')
                            @case('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                <embed src="{{ asset('storage/media/' . $popupMedia->media_name) }}" type="{{ $mimeType }}" width="100%" height="500px" />
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
                                    <p>{{ $popupMedia->media_name }}</p>
                                </div>
                        @endswitch

                        {{-- Additional media details --}}
                        <div class="media-item-details" style="margin-top: 20px;">
                            <h5>{{ $popupMedia->media_name }}</h5>
                            <p>File type: {{ $mimeType }}</p>
                        </div>
                    @else
                        <p>No media selected.</p>
                    @endif
                </div>

                <div class="modal-footer">
                    @if($popupMedia)
                        <a href="{{ route('media.download', $popupMedia->id) }}" class="btn btn-outline-primary me-1 mb-1" type="button" download>Download</a>
                    @endif
                    <button class="btn btn-outline-primary me-1 mb-1" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('mediaDeleted', function () {
        });
    });
    window.addEventListener('contentChanged', event => {
    Livewire.emit('refreshComponent');
});
</script>
