<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Pages</h2>
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

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
                <span>All </span>
                <span class="text-body-tertiary fw-semibold">
                    @php
                        $sub_total = $this->publish + $this->draft;
                        $grand_total = $totalPageCount;
                        if( $sub_total > $totalPageCount ){
                            $grand_total = $sub_total;
                        }
                    @endphp
                    ({{ $grand_total }})
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" wire:click.prevent="getPostByStatus('publish')">
                <span>Published </span><span class="text-body-tertiary fw-semibold">({{ $publish }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" wire:click.prevent="getPostByStatus('draft')">
                <span>Drafts </span><span class="text-body-tertiary fw-semibold">({{ $draft }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <span>Mine</span><span class="text-body-tertiary fw-semibold">(17)</span>
            </a>
        </li>
    </ul>
    <div id="pages">
    <div class="mb-4">
            <div class="d-flex flex-wrap gap-3" style="justify-content:space-between">
                <div class="d-flex flex-wrap search-box" style="width: 21rem; justify-content:space-between">
                    <form class="position-relative">
                        <input class="form-control search-input search" type="search" placeholder="Search pages" aria-label="Search" wire:model="search"/>
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                    <button class="btn btn-outline-primary" wire:click="performSearch" wire:loading.attr="disabled">
                        <span wire:loading.remove>Search</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Processing...</span>
                        </span>
                    </button>
                </div>
                <div class="ms-xxl-auto">
                    <button class="btn btn-primary" id="addBtn" onClick="window.location.href='{{ url('admin/pages/add')}}'"><span class="fas fa-plus me-2"></span>Add Page</button>
                </div>
            </div>
        </div>

        <div class="row margin-top-bottom-20">
            <div class="col-lg-3" style="display:flex;padding-left:0px;">
                <select id="posts-builk-actions" class="form-select" wire:model="bulkAction" style="margin-right:20px;">
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
            <div class="col-lg-8">
                <div class="scrollbar overflow-hidden-y">
                    <div class="btn-group position-static" role="group">
                        <div class="btn-group position-static text-nowrap">
                            <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                Date<span class="fas fa-angle-down ms-2"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" wire:click.prevent="selectDate('All Dates', 'all')">All Dates</a></li>
                                @foreach ($this->months as $arc_row)
                                    @if ((int) $arc_row->year === 0)
                                        @continue
                                    @endif

                                    @php
                                        $month = $this->zeroise($arc_row->month, 2);
                                        $year = $arc_row->year;
                                        $value = $year . $month;
                                        $dateLabel = \Carbon\Carbon::create($year, $month)->format('F Y')
                                    @endphp

                                    <li><a class="dropdown-item" href="#" wire:click.prevent="selectDate( '{{ $dateLabel }}', {{ $value }})">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1" style="text-align:right;">
                <div class="media-toolbar-primary search-form">
                    {{ $totalPageCount }} item(s)
                </div>
            </div>
        </div>

        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap align-middle fs-10" scope="col" style="width:70px;"></th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:350px;" data-sort="product">TITLE</th>
                        <th class="sort align-middle ps-4" scope="col" data-sort="vendor" style="width:200px;">AUTHOR</th>
                        <th class="sort align-middle ps-4" scope="col" data-sort="time" style="width:50px;">DATE</th>
                        <th class="sort text-end align-middle pe-0 ps-4" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="products-table-body">

                        @foreach ( $pageItems as $page )
                        @php
                            if (empty($post['media_name'])){
                                $mediaPath = 'img/placeholders/default.png';
                            } else {
                                $mediaPath = 'storage/media/' . $post['media_name'];
                            }
                        @endphp
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox" value="{{ $page['id'] }}" wire:model="selectedPages" />
                                </div>
                            </td>
                            <td class="align-middle white-space-nowrap py-0">
                                <a class="d-block border border-translucent rounded-2" href="{{ url('admin/pages/'.$page['id']) }}">
                                    <img src="{{ asset($mediaPath) }}" alt="" width="53" />
                                </a>
                            </td>
                            <td class="product align-middle ps-4">
                                <a class="fw-semibold line-clamp-3 mb-0" href="{{ url('admin/pages/' . $page['id']) }}">{{ $page['post_title'] }}</a>
                            </td>
                            <td class="price align-middle white-space-nowrap text-end fw-bold text-body-tertiary ps-4">John Doe</td>
                            <td class="time align-middle white-space-nowrap text-body-tertiary text-opacity-85 ps-4">{{ $this->formatDate( $page['created_at'] ) }}</td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="#!">View</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#!" wire:click="deletePage({{ $page['id'] }})">Remove</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        {{ empty( $pageItems ) ? '0 to 0' : (($currentPage - 1) * $perPage + 1) }} to 
                        {{ min($currentPage * $perPage, $totalPageCount) }} 
                        <span class="text-body-tertiary"> Items of </span>{{ $totalPageCount }}
                    </p>
                </div>
    
                <div class="col-auto d-flex">
                    <button class="page-link {{ ($currentPage == 1) ? 'disabled' : '' }}" wire:click="previousPage" {{ ($currentPage == 1) ? 'disabled' : '' }}>
                        <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path fill="currentColor" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                        </svg>
                    </button>

                    <ul class="mb-0 pagination pagination-custom-button">
                        @for ($i = 1; $i <= ceil($totalPageCount / $perPage); $i++)
                            <li class="{{ ($currentPage == $i) ? 'active' : '' }}">
                                <button class="page" type="button" wire:click="gotoPage({{ $i }})">{{ $i }}</button>
                            </li>
                        @endfor
                    </ul>

                    <button class="page-link {{ ($currentPage == ceil($totalPageCount / $perPage)) ? 'disabled' : '' }}" wire:click="nextPage" {{ ($currentPage == ceil($totalPageCount / $perPage)) ? 'disabled' : '' }}>
                        <svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>