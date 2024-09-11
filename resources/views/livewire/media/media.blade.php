<div class="content">
    <h3 class="upload-cls">Media Library</h3>
    <div class="modal-content library">
        <div class="modal-body">
            <div class="media-toolbar">
                <div class="media-toolbar-secondary">
                    <a href="{{ url()->current() }}?mode=list" class="active" style="margin-right: 5px; text-decoration: none;" >
                        <span data-feather="list"></span>
                    </a>
                    <a href="{{ url()->current() }}?mode=grid" class="" style="margin-right: 5px; text-decoration: none;">
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
                    <input type="search" id="media-search-input" class="search">
                </div>
            </div>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-content-wrap">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @if($mode === 'list')
                        <div class="table-responsive">
                          <table class="table table-sm fs-9 mb-0">
                            <thead>
                              <tr>
                                <th class="sort border-top border-translucent ps-3">
                                    <input type="checkbox">
                                </th>
                                <th class="sort border-top border-translucent ps-3" data-sort="name">File</th>
                                <th class="sort border-top border-translucent" data-sort="email">Date</th>
                                <th class="sort text-end align-middle pe-0 border-top border-translucent" scope="col">ACTION</th>
                              </tr>
                            </thead>
                            <tbody class="list">
                                @if(empty($mediaItems))
                                <tr>
                                    <td class="align-middle">
                                        Media Not Available
                                    </td>
                                </tr>
                                @else
                                    @foreach($mediaItems as $item)
                                    <tr>
                                        <td class="align-middle">
                                            <input type="checkbox">
                                        </td>
                                        <td class="align-middle">
                                            <div class="attachment-list">
                                                @php
                                                    $extension = pathinfo($item->media_name, PATHINFO_EXTENSION);
                                                    $mimeType = mime_content_type(storage_path('app/public/media/' . $item->media_name));
                                                @endphp
                                                @switch($mimeType)
                                                    @case('image/jpeg')
                                                    @case('image/png')
                                                    @case('image/gif')
                                                    @case('image/webp')
                                                        <img src="{{ asset('storage/media/' . $item->media_name) }}" draggable="false" alt="{{ $item->media_name }}" width="60px" height="60px">
                                                        @break

                                                    @case('audio/mpeg')
                                                    @case('audio/wav')
                                                    @case('audio/ogg')
                                                        <audio controls>
                                                            <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}" width="60px" height="60px">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                        @break

                                                    @case('video/mp4')
                                                    @case('video/avi')
                                                    @case('video/mpeg')
                                                        <video controls width="100%">
                                                            <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}" width="60px" height="60px">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                        @break

                                                    @case('application/pdf')
                                                        <embed src="{{ asset('storage/media/' . $item->media_name) }}" type="application/pdf" width="60px" height="60px" />
                                                        @break

                                                    @case('application/msword')
                                                    @case('application/vnd.ms-excel')
                                                    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                    @case('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                        <div class="file-icon">
                                                            <i class="fas fa-file-alt"></i>
                                                            <p>{{ $item->media_name }}</p>
                                                        </div>
                                                        @break

                                                    @default
                                                        <div class="file-icon">
                                                            <i class="fas fa-file"></i>
                                                            <p>{{ $item->media_name }}</p>
                                                        </div>
                                                @endswitch
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            2024/09/09
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
                                                    <a class="dropdown-item" href="#!">Export</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="#!">Remove</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                          </table>
                        </div>
                        @elseif($mode === 'grid')
                        <div class="container" style="max-height: 600px; overflow-y: auto;" wire:scroll.debounce.200ms="loadMore">
                            <div class="row">
                                @if(empty($mediaItems))
                                    <div class="col-12">
                                        <p class="text-center">No media items available.</p>
                                    </div>
                                @else
                                    @foreach($mediaItems as $item)
                                        <div class="col-md-6 col-lg-2 item attachment details">
                                            <div class="attachment-preview js--select-attachment type-image subtype-png landscape" data-bs-toggle="modal" data-bs-target="#verticallyCentered" wire:click="loadMediaDetails({{ $item->id }})">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        @php
                                                            $extension = pathinfo($item->media_name, PATHINFO_EXTENSION);
                                                            $mimeType = mime_content_type(storage_path('app/public/media/' . $item->media_name));
                                                        @endphp
                                                        @switch($mimeType)
                                                            @case('image/jpeg')
                                                            @case('image/png')
                                                            @case('image/gif')
                                                            @case('image/webp')
                                                                <img src="{{ asset('storage/media/' . $item->media_name) }}" draggable="false" alt="{{ $item->media_name }}">
                                                                @break

                                                            @case('audio/mpeg')
                                                            @case('audio/wav')
                                                            @case('audio/ogg')
                                                                <audio controls>
                                                                    <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                                @break

                                                            @case('video/mp4')
                                                            @case('video/avi')
                                                            @case('video/mpeg')
                                                                <video controls width="100%">
                                                                    <source src="{{ asset('storage/media/' . $item->media_name) }}" type="{{ $mimeType }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                                @break

                                                            @case('application/pdf')
                                                                <embed src="{{ asset('storage/media/' . $item->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                                                @break

                                                            @case('application/msword')
                                                            @case('application/vnd.ms-excel')
                                                            @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                            @case('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                                                                <div class="file-icon">
                                                                    <i class="fas fa-file-alt"></i>
                                                                    <p>{{ $item->media_name }}</p>
                                                                </div>
                                                                @break

                                                            @default
                                                                <div class="file-icon">
                                                                    <i class="fas fa-file"></i>
                                                                    <p>{{ $item->media_name }}</p>
                                                                </div>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

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
                                    $mimeType = mime_content_type(storage_path('app/public/media/' . $selectedMedia->media_name));
                                @endphp

                                @switch($mimeType)
                                    @case('image/jpeg')
                                    @case('image/png')
                                    @case('image/gif')
                                    @case('image/webp')
                                        <img src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" class="img-fluid" alt="{{ $selectedMedia->media_name }}">
                                        @break

                                    @case('audio/mpeg')
                                    @case('audio/wav')
                                    @case('audio/ogg')
                                        <audio controls>
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the audio element.
                                        </audio>
                                        @break

                                    @case('video/mp4')
                                    @case('video/avi')
                                    @case('video/mpeg')
                                        <video controls width="100%">
                                            <source src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="{{ $mimeType }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @break

                                    @case('application/pdf')
                                        <embed src="{{ asset('storage/media/' . $selectedMedia->media_name) }}" type="application/pdf" width="100%" height="500px" />
                                        @break

                                    @default
                                        <div class="file-icon">
                                            <i class="fas fa-file"></i>
                                            <p>{{ $selectedMedia->media_name }}</p>
                                        </div>
                                @endswitch
                                
                                <div class="media-item-details" style="margin-top: 20px;">
                                    <h5>{{ $selectedMedia->media_name }}</h5>
                                    <p>File type: {{ mime_content_type(storage_path('app/public/media/' . $selectedMedia->media_name)) }}</p>
                                </div>
                            @else
                                <p>No media selected.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn btn-primary" type="button">Okay</button> -->
                            <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
