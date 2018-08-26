<?php include 'header.php'; ?>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <!-- begin::Header -->
        <header class="m-grid__item    m-header "  data-minimize-mobile="hide" data-minimize-offset="200" data-minimize-mobile-offset="200" data-minimize="minimize" >
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <?php include 'top_bar.php'; ?>
                </div>                        
            </div>           
        </header>

        <!-- begin::Body -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <!-- BEGIN: Left Aside -->
            <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
                <!-- BEGIN: Aside Menu -->
                <?php include 'menu.php'; ?>
                <!-- END: Aside Menu -->
            </div>
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <!-- BEGIN: Subheader -->
                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title ">
                                {SubTitle}
                            </h3>
                        </div>
                        <!--                        <div>
                                                    <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                                                        <span class="m-subheader__daterange-label">
                                                            <span class="m-subheader__daterange-title"></span>
                                                            <span class="m-subheader__daterange-date m--font-brand"></span>
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                            <i class="la la-angle-down"></i>
                                                        </a>
                                                    </span>
                                                </div>-->
                    </div>
                </div>
                <!-- END: Subheader -->
                <div class="m-content">
                    {Content}
                </div>
            </div>
        </div>

        <!-- BEGIN: Footer -->
        <?php include 'footer.php'; ?>
        <!-- END: Footer -->
    </div>
    <!-- begin::Scroll Top -->
    <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
        <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->
        <!-- BEGIN: Footer -->
        <?php include 'script.php'; ?>
</body>

</html>