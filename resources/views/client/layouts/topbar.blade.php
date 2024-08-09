<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="py-0">

    <div class="container-small">
        <div class="ecommerce-topbar">
            <nav class="navbar navbar-expand-lg navbar-light px-0">
                <div class="row gx-0 gy-2 w-100 flex-between-center">
                    <div class="col-auto">
                        <a class="text-decoration-none" href="../../../index.html">
                            <div class="d-flex align-items-center">
                                <img src="{{ url('img/icons/logo.png') }}" alt="phoenix" width="27" />
                                <p class="logo-text ms-2">phoenix</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto order-md-1">
                        <ul class="navbar-nav navbar-nav-icons flex-row me-n2">
                            <li class="nav-item d-flex align-items-center">
                                <div class="theme-control-toggle fa-icon-wait px-2">
                                    <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" />
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme" style="height:32px;width:32px;">
                                        <span class="icon" data-feather="moon"></span>
                                    </label>
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme" style="height:32px;width:32px;">
                                        <span class="icon" data-feather="sun"></span>
                                    </label>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 icon-indicator icon-indicator-primary" href="../../../apps/e-commerce/landing/cart.html" role="button">
                                    <span class="text-body-tertiary" data-feather="shopping-cart" style="height:20px;width:20px;"></span>
                                    <span class="icon-indicator-number">3</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link px-2 icon-indicator icon-indicator-sm icon-indicator-danger" id="navbarTopDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-body-tertiary" data-feather="bell" style="height:20px;width:20px;"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret mt-2" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
                                    <div class="card position-relative border-0">
                                        <div class="card-header p-2">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="text-body-emphasis mb-0">Notifications</h5>
                                                <button class="btn btn-link p-0 fs-9 fw-normal" type="button">Mark all as read</button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="scrollbar-overlay" style="height: 27rem;">
                                                <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar avatar-m status-online me-3">
                                                                <img class="rounded-circle" src="{{ url('img/team/40x40/30.webp') }}" alt="" />
                                                            </div>
                                                            <div class="flex-1 me-sm-3">
                                                                <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal">
                                                                    <span class='me-1 fs-10'>💬</span>Mentioned you in a comment.
                                                                    <span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">10m</span>
                                                                </p>
                                                                <p class="text-body-secondary fs-9 mb-0">
                                                                    <span class="me-1 fas fa-clock"></span><span class="fw-bold">10:41 AM </span>August 7, 2021
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown notification-dropdown">
                                                            <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                <span class="fas fa-ellipsis-h fs-10 text-body"></span>
                                                            </button>
                                                            <div class="dropdown-menu py-2">
                                                                <a class="dropdown-item" href="#!">Mark as unread</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar avatar-m status-online me-3">
                                                                <div class="avatar-name rounded-circle"><span>J</span></div>
                                                            </div>
                                                            <div class="flex-1 me-sm-3">
                                                                <h4 class="fs-9 text-body-emphasis">Jane Foster</h4>
                                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal">
                                                                    <span class='me-1 fs-10'>📅</span>Created an event.
                                                                    <span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">20m</span>
                                                                </p>
                                                                <p class="text-body-secondary fs-9 mb-0">
                                                                    <span class="me-1 fas fa-clock"></span><span class="fw-bold">10:20 AM </span>August 7, 2021
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown notification-dropdown">
                                                            <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                <span class="fas fa-ellipsis-h fs-10 text-body"></span>
                                                            </button>
                                                            <div class="dropdown-menu py-2">
                                                                <a class="dropdown-item" href="#!">Mark as unread</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar avatar-m status-online me-3">
                                                                <img class="rounded-circle avatar-placeholder" src="{{ url('img/team/40x40/avatar.webp') }}" alt="" />
                                                            </div>
                                                            <div class="flex-1 me-sm-3">
                                                                <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal">
                                                                    <span class='me-1 fs-10'>👍</span>Liked your comment.
                                                                    <span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">1h</span>
                                                                </p>
                                                                <p class="text-body-secondary fs-9 mb-0">
                                                                    <span class="me-1 fas fa-clock"></span><span class="fw-bold">9:30 AM </span>August 7, 2021
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown notification-dropdown">
                                                            <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                <span class="fas fa-ellipsis-h fs-10 text-body"></span>
                                                            </button>
                                                            <div class="dropdown-menu py-2">
                                                                <a class="dropdown-item" href="#!">Mark as unread</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="px-2 px-sm-3 py-3 notification-card position-relative unread border-bottom">
                                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                                        <div class="d-flex">
                                                            <div class="avatar avatar-m status-online me-3">
                                                                <img class="rounded-circle" src="{{ url('img/team/40x40/57.webp') }}" alt="" />
                                                            </div>
                                                            <div class="flex-1 me-sm-3">
                                                                <h4 class="fs-9 text-body-emphasis">Ben Bailey</h4>
                                                                <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal">
                                                                    <span class='me-1 fs-10'>📅</span>Requested to join the event.
                                                                    <span class="ms-2 text-body-quaternary text-opacity-75 fw-bold fs-10">2h</span>
                                                                </p>
                                                                <p class="text-body-secondary fs-9 mb-0">
                                                                    <span class="me-1 fas fa-clock"></span><span class="fw-bold">8:00 AM </span>August 7, 2021
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown notification-dropdown">
                                                            <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                <span class="fas fa-ellipsis-h fs-10 text-body"></span>
                                                            </button>
                                                            <div class="dropdown-menu py-2">
                                                                <a class="dropdown-item" href="#!">Mark as unread</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer border-0 py-2 px-2 px-sm-3 text-center">
                                            <a class="btn btn-link fw-medium" href="../../../pages/notifications.html">View all notifications</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link px-2 icon-indicator icon-indicator-sm" id="navbarTopDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="avatar rounded-circle" src="{{ url('img/team/40x40/1.webp') }}" alt="..." />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0 shadow border navbar-dropdown-caret mt-2" id="navbarDropdownUser" aria-labelledby="navbarDropdownUser">
                                    <div class="card position-relative border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar me-3">
                                                    <img class="rounded-circle" src="{{ url('img/team/40x40/1.webp') }}" alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="fs-9 text-body-emphasis mb-0">James Doe</h5>
                                                    <p class="fs-9 mb-0">james.doe@example.com</p>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <a class="btn btn-outline-primary" href="../../../pages/profile.html">Profile settings</a>
                                                <a class="btn btn-outline-primary" href="../../../apps/dashboard.html">Dashboard</a>
                                                <a class="btn btn-outline-primary" href="../../../apps/social.html">Posts & Activity</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/settings.html">Settings</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/activities.html">Activity Log</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/projects.html">Projects</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/team.html">Team</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/settings.html">Settings</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/reports.html">Reports</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/todo.html">To-Do</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/messages.html">Messages</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/favorites.html">Favorites</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/notifications.html">Notifications</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/index.html">Home</a>
                                                <a class="btn btn-outline-primary" href="../../../pages/logout.html">Log Out</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="form-control">
                                <div class="input-group">
                                    <span class="input-group-text"><span data-feather="search" style="height:20px;width:20px;"></span></span>
                                    <input class="form-control" type="search" placeholder="Search..." />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

</section>
<!-- <section> end ============================-->
