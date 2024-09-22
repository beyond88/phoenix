<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Posts</h2>
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
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#"><span>All </span><span class="text-body-tertiary fw-semibold">({{ $totalPostCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Published </span><span class="text-body-tertiary fw-semibold">({{ $publish }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Drafts </span><span class="text-body-tertiary fw-semibold">({{ $draft }})</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span>Mine</span><span class="text-body-tertiary fw-semibold">(17)</span></a></li>
    </ul>
    <div id="posts">
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative">
                    <input class="form-control search-input search" type="search" placeholder="Search posts" aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="scrollbar overflow-hidden-y">
                    <div class="btn-group position-static" role="group">
                    <div class="btn-group position-static text-nowrap">
                        <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        Category<span class="fas fa-angle-down ms-2"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($cats as $cat)
                                <li><a class="dropdown-item" href="{{ $cat['term_id'] }}">{{ $cat['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="btn-group position-static text-nowrap">
                        <button class="btn btn-sm btn-phoenix-secondary px-7 flex-shrink-0" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        Date<span class="fas fa-angle-down ms-2"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($this->months as $arc_row)
                                @if ((int) $arc_row->year === 0)
                                    @continue
                                @endif

                                @php
                                    $month = $this->zeroise($arc_row->month, 2);
                                    $year = $arc_row->year;
                                    $value = $year . $month;
                                @endphp
                                <li><a class="dropdown-item" href="#">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="ms-xxl-auto">
                    <button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Export</button>
                    <button class="btn btn-primary" id="addBtn" onClick="window.location.href='{{ url('admin/posts/add')}}'"><span class="fas fa-plus me-2"></span>Add Post</button>
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
            <div class="col-lg-8 col-sm-hidden col-xs-hidden"></div>
            <div class="col-lg-1" style="text-align:right;">
                <div class="media-toolbar-primary search-form">
                    {{ $totalPostCount }} items
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
                                <input class="form-check-input" id="checkbox-bulk-products-select" type="checkbox" data-bulk-select='{"body":"products-table-body"}' wire:model="selectAll" wire:click="toggleSelectAll" />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap align-middle fs-10" scope="col" style="width:70px;"></th>
                        <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:350px;" data-sort="product">TITLE</th>
                        <th class="sort align-middle ps-4" scope="col" data-sort="category" style="width:150px;">CATEGORY</th>
                        <th class="sort align-middle ps-4" scope="col" data-sort="vendor" style="width:200px;">AUTHOR</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="tags" style="width:250px;">TAGS</th>
                        <th class="sort align-middle ps-4" scope="col" style="width:50px;">COMMENT</th>
                        <th class="sort align-middle ps-4" scope="col" data-sort="time" style="width:50px;">DATE</th>
                        <th class="sort text-end align-middle pe-0 ps-4" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="products-table-body">
                        @foreach ($postItems as $post)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input" type="checkbox" value="{{ $post['id'] }}" data-bulk-select-row='{"product":"Fitbit Sense Advanced Smartwatch with Tools for Heart Health, Stress Management & Skin Temperature Trends, Carbon/Graphite, One Size (S & L Bands...","productImage":"/products/1.png","price":"$39","category":"Plants","tags":["Health","Exercise","Discipline","Lifestyle","Fitness"],"star":false,"vendor":"Blue Olive Plant sellers. Inc","publishedOn":"Nov 12, 10:45 PM"}' />
                                    </div>
                                </td>
                                <td class="align-middle white-space-nowrap py-0">
                                    <a class="d-block border border-translucent rounded-2" href="{{ url('admin/posts/1') }}">
                                        <img src="{{ asset('storage/media/' . $post['media_name']) }}" alt="" width="53" />
                                    </a>
                                </td>
                                <td class="product align-middle ps-4">
                                    <a class="fw-semibold line-clamp-3 mb-0" href="{{ url('admin/posts/' . $post['id']) }}">{{ $post['post_title'] }}</a>
                                </td>
                                <td class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">{{ $post['category_name'] }}</td>
                                <td class="price align-middle white-space-nowrap text-end fw-bold text-body-tertiary ps-4">{{ $post['user_id'] }}</td>
                                <td class="tags align-middle review pb-2 ps-3" style="min-width:225px;">
                                    <a class="text-decoration-none" href="#!"><span class="badge badge-tag me-2 mb-2">Health</span></a><a class="text-decoration-none" href="#!"><span class="badge badge-tag me-2 mb-2">Exercise</span></a><a class="text-decoration-none" href="#!"><span class="badge badge-tag me-2 mb-2">Discipline</span></a><a class="text-decoration-none" href="#!"><span class="badge badge-tag me-2 mb-2">Lifestyle</span></a><a class="text-decoration-none" href="#!"><span class="badge badge-tag me-2 mb-2">Fitness</span>
                                </a>
                                </td>
                                <td class="align-middle review fs-8 text-center ps-4">
                                    <div class="d-toggle-container">
                                        <div class="d-block-hover"><span class="fas fa-star text-warning"></span></div>
                                        <div class="d-none-hover"><span class="far fa-star text-warning"></span></div>
                                    </div>
                                </td>
                                <td class="time align-middle white-space-nowrap text-body-tertiary text-opacity-85 ps-4">
                                    {{ $this->formatDate( $post['created_at'] ) }}
                                </td>
                                <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs-10"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#!" wire:click="deletePost({{ $post['id'] }})">Remove</a>
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
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                    <a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>