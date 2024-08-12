@extends("client.layouts.layout")

@section("title", "Track Order | Phoenix")

@section("content")

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">

    @include("client.layouts.topbar")

    @include("client.layouts.navbar")

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-5 pb-9">

    <div class="container-small cart">
        <nav class="mb-2" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
            <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
            <li class="breadcrumb-item active" aria-current="page">Default</li>
        </ol>
        </nav>
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5">
        <div>
            <h2>Order #234 Status</h2>
            <p class="text-body-secondary mb-0">Payment Via <a class="fw-bold" href="#!">Cash on delivery</a>,<br class="d-sm-none"><span class="ms-sm-1">Nov 12, 2021, 8:54AM.</span></p>
        </div>
        <button class="btn btn-outline-primary mt-3"><span class="fa-solid fa-phone me-2"></span>Call Support</button>
        </div>
        <div class="row gy-9 gx-5">
        <div class="col-12 col-lg-6">
            <div class="border rounded-3 overflow-hidden h-100">
            <div class="googlemap h-100 min-vh-50" data-googlemap data-latlng="40.7228022,-74.0020158" data-scrollwheel="false" data-zoom="15">
                <div class="marker-content py-2">
                <h5>Google map </h5>
                <p class="mb-0">A nice template for your site.<br>Customize it as you want.</p>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="timeline-vertical">
            <div class="timeline-item">
                <div class="row g-md-3 align-items-center mb-8 mb-lg-10">
                <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date text-end order-1 order-md-0 me-md-4">
                    <p class="fs-10 fw-semibold text-body-tertiary mb-0">23 August, 2023<br class="d-none d-md-block"> 10:30 AM</p>
                    </div>
                    <div class="timeline-item-bar position-relative me-3 me-md-0">
                    <div class="icon-item icon-item-sm bg-success" data-bs-theme="light"><span class="fa-solid fa-check text-white fs-10"></span></div><span class="timeline-bar border-end border-success"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                    <h4>Order is processing</h4>
                    <p class="fs-9 text-body-secondary mb-0">Your package is ready for the seller to prepare.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="row g-md-3 align-items-center mb-8 mb-lg-10">
                <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date text-end order-1 order-md-0 me-md-4">
                    <p class="fs-10 fw-semibold text-body-tertiary mb-0">25 August, 2023<br class="d-none d-md-block"> 11:30 AM</p>
                    </div>
                    <div class="timeline-item-bar position-relative me-3 me-md-0">
                    <div class="icon-item icon-item-sm bg-success" data-bs-theme="light"><span class="fa-solid fa-check text-white fs-10"></span></div><span class="timeline-bar border-end border-warning"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                    <h4>Picked Up</h4>
                    <p class="fs-9 text-body-secondary mb-0">Your package has been picked up from the seller.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="row g-md-3 align-items-center mb-8 mb-lg-10">
                <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date text-end order-1 order-md-0 me-md-4">
                    <p class="fs-10 fw-semibold text-body-tertiary mb-0">27 August, 2023<br class="d-none d-md-block"> 6:30 AM</p>
                    </div>
                    <div class="timeline-item-bar position-relative me-3 me-md-0">
                    <div class="icon-item icon-item-sm bg-warning" data-bs-theme="light"><span class="fa-solid fa-truck-ramp-box text-white fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                    <h4>Ready to Ship</h4>
                    <p class="fs-9 text-body-secondary mb-0">Your package is now ready to be shipped.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="row g-md-3 align-items-center mb-8 mb-lg-10">
                <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date text-end order-1 order-md-0 me-md-4">
                    <p class="fs-10 fw-semibold text-body-tertiary mb-0">Estimated time<br class="d-none d-md-block"> 29 August, 2023</p>
                    </div>
                    <div class="timeline-item-bar position-relative me-3 me-md-0">
                    <div class="icon-item icon-item-sm bg-body-quaternary" data-bs-theme="light"><span class="fa-solid fa-truck text-white fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                    <h4>Shipped</h4>
                    <p class="fs-9 text-body-secondary mb-0">Pending</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="row g-md-3 align-items-center">
                <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date text-end order-1 order-md-0 me-md-4">
                    <p class="fs-10 fw-semibold text-body-tertiary mb-0">Estimated time<br class="d-none d-md-block"> 30 August, 2023</p>
                    </div>
                    <div class="timeline-item-bar position-relative me-3 me-md-0">
                    <div class="icon-item icon-item-sm bg-body-quaternary" data-bs-theme="light"><span class="fa-solid fa-truck-fast text-white fs-10"></span></div>
                    </div>
                </div>
                <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                    <h4>Delivered</h4>
                    <p class="fs-9 text-body-secondary mb-0">Pending</p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->


    @include("client.layouts.chat")
    
    @include("client.layouts.copyright")
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

@endsection