<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-width="default" data-menu-styles="color" data-toggled="close">
    <head>
        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title') | Petr Kraev Admin</title>

        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" />

        <!-- Choices JS -->
        <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

        <!-- Main Theme Js -->
        <script src="/assets/js/main.js"></script>

        <!-- Bootstrap Css -->
        <link id="style" href="/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

        <!-- Style Css -->
        <link href="/assets/css/styles.css" rel="stylesheet" >

        <!-- Icons Css -->
        <link href="/assets/css/icons.css" rel="stylesheet" >

        <!-- Node Waves Css -->
        <link href="/assets/libs/node-waves/waves.min.css" rel="stylesheet" >

        <!-- Simplebar Css -->
        <link href="/assets/libs/simplebar/simplebar.min.css" rel="stylesheet" >

        <!-- Color Picker Css -->
        <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
        <link rel="stylesheet" href="/assets/libs/@simonwep/pickr/themes/nano.min.css">

        <!-- Choices Css -->
        <link rel="stylesheet" href="/assets/libs/choices.js/public/assets/styles/choices.min.css">

        <!-- FlatPickr CSS -->
        <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">

        <!-- Auto Complete CSS -->
        <link rel="stylesheet" href="/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css">

        <link rel="stylesheet" href="/assets/libs/toastify-js/src/toastify.css">

        <link rel="stylesheet" href="/assets/libs/custom-datatables/datatables.css">

        <!-- Tagify CSS -->
        <link rel="stylesheet" href="/assets/libs/@yaireo/tagify/tagify.css">

        <link rel="stylesheet" href="/assets/libs/select2/select2.min.css">

        <link rel="stylesheet" href="/assets/libs/nouislider/nouislider.min.css">

        <link rel="stylesheet" href="/assets/libs/quill/quill.snow.css">

        <link rel="stylesheet" href="/assets/libs/highlight/styles/kimbie-light.css">

        <link rel="stylesheet" href="/assets/libs/summernote/summernote.min.css">

        <link rel="stylesheet" href="{{ tempAsset('/assets/css/tg-picker.css') }}">

        <style>
            .note-editable p{
                margin-bottom: 0;
            }
        </style>

        @yield('styles')

    </head>

    <body>

        <!-- Start Switcher -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom d-block p-0">
                <div class="d-flex align-items-center justify-content-between p-3">
                    <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <nav class="border-top border-block-start-dashed">
                    <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                        <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab" data-bs-target="#switcher-home"
                                type="button" role="tab" aria-controls="switcher-home" aria-selected="true">Theme Styles</button>
                        <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab" data-bs-target="#switcher-profile"
                                type="button" role="tab" aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                    </div>
                </nav>
            </div>
            <div class="offcanvas-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel" aria-labelledby="switcher-home-tab"
                         tabindex="0">
                        <div class="">
                            <p class="switcher-style-head">Theme Color Mode:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-light-theme">
                                            Light
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                               checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-dark-theme">
                                            Dark
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Directions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-ltr">
                                            LTR
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-rtl">
                                            RTL
                                        </label>
                                        <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Navigation Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-vertical">
                                            Vertical
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style" id="switcher-vertical"
                                               checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-horizontal">
                                            Horizontal
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style"
                                               id="switcher-horizontal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="navigation-menu-styles">
                            <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                            <div class="row switcher-style gx-0 pb-2 gy-2">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-click">
                                            Menu Click
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                               id="switcher-menu-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-hover">
                                            Menu Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                               id="switcher-menu-hover">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-click">
                                            Icon Click
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                               id="switcher-icon-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-hover">
                                            Icon Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                               id="switcher-icon-hover">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidemenu-layout-styles">
                            <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                            <div class="row switcher-style gx-0 pb-2 gy-2">
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-default-menu">
                                            Default Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-default-menu" checked>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-closed-menu">
                                            Closed Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-closed-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icontext-menu">
                                            Icon Text
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-icontext-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-overlay">
                                            Icon Overlay
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-icon-overlay">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-detached">
                                            Detached
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-detached">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-double-menu">
                                            Double Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                               id="switcher-double-menu">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Page Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-regular">
                                            Regular
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular"
                                               checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-classic">
                                            Classic
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-classic">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-modern">
                                            Modern
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-modern">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Layout Width Styles:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-default-width">
                                            Default
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-default-width"
                                               checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-full-width">
                                            Full Width
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-full-width">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-boxed">
                                            Boxed
                                        </label>
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-boxed">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Menu Positions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-fixed">
                                            Fixed
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-fixed"
                                               checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-scroll">
                                            Scrollable
                                        </label>
                                        <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Header Positions:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-fixed">
                                            Fixed
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                               id="switcher-header-fixed" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-scroll">
                                            Scrollable
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                               id="switcher-header-scroll">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="switcher-style-head">Loader:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-enable">
                                            Enable
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                               id="switcher-loader-enable">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-disable">
                                            Disable
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                               id="switcher-loader-disable" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel" aria-labelledby="switcher-profile-tab" tabindex="0">
                        <div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Menu Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                               id="switcher-menu-light" >
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                               id="switcher-menu-dark" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Color Menu" type="radio" name="menu-colors"
                                               id="switcher-menu-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Gradient Menu" type="radio" name="menu-colors"
                                               id="switcher-menu-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Menu"
                                               type="radio" name="menu-colors" id="switcher-menu-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Header Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Light Header" type="radio" name="header-colors"
                                               id="switcher-header-light" checked>
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Dark Header" type="radio" name="header-colors"
                                               id="switcher-header-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Color Header" type="radio" name="header-colors"
                                               id="switcher-header-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Gradient Header" type="radio" name="header-colors"
                                               id="switcher-header-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Transparent Header" type="radio" name="header-colors"
                                               id="switcher-header-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Theme Primary:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-1" type="radio"
                                               name="theme-primary" id="switcher-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-2" type="radio"
                                               name="theme-primary" id="switcher-primary1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary"
                                               id="switcher-primary2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary"
                                               id="switcher-primary3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary"
                                               id="switcher-primary4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                        <div class="theme-container-primary"></div>
                                        <div class="pickr-container-primary"  onchange="updateChartColor(this.value)"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Theme Background:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-1" type="radio"
                                               name="theme-background" id="switcher-background">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-2" type="radio"
                                               name="theme-background" id="switcher-background1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-3" type="radio" name="theme-background"
                                               id="switcher-background2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-4" type="radio"
                                               name="theme-background" id="switcher-background3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-5" type="radio"
                                               name="theme-background" id="switcher-background4">
                                    </div>
                                    <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                        <div class="theme-container-background"></div>
                                        <div class="pickr-container-background"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-image mb-3">
                                <p class="switcher-style-head">Menu With Background Image:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img1" type="radio"
                                               name="menu-background" id="switcher-bg-img">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img2" type="radio"
                                               name="menu-background" id="switcher-bg-img1">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img3" type="radio" name="menu-background"
                                               id="switcher-bg-img2">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img4" type="radio"
                                               name="menu-background" id="switcher-bg-img3">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img5" type="radio"
                                               name="menu-background" id="switcher-bg-img4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="canvas-footer">
                        <a href="javascript:void(0);" id="reset-all" class="btn btn-danger m-1 w-100">Reset</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Switcher -->


        <!-- Loader -->
        <div id="loader" >
            <img src="/assets/images/media/loader.svg" alt="">
        </div>
        <!-- Loader -->

        <div class="page">
            <!-- app-header -->
            <header class="app-header sticky" id="header">

                <!-- Start::main-header-container -->
                <div class="main-header-container container-fluid">

                    <!-- Start::header-content-left -->
                    <div class="header-content-left">

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <div class="horizontal-logo">
                                <a href="{{ route('admin') }}" class="header-logo">
                                    <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-logo">
                                    <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="toggle-logo">
                                    <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-dark">
                                    <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-white">
                                    <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="toggle-dark">
                                </a>
                            </div>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element mx-lg-0 mx-2">
                            <a aria-label="Hide Sidebar"
                               class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                               data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->

                        <!-- End::header-element -->

                    </div>
                    <!-- End::header-content-left -->

                    <!-- Start::header-content-right -->
                    <ul class="header-content-right">

                        <!-- Start::header-element -->
                        <li class="header-element d-md-none d-block">
                            <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
                               data-bs-target="#header-responsive-search">
                                <!-- Start::header-link-icon -->
                                <i class="bi bi-search header-link-icon"></i>
                                <!-- End::header-link-icon -->
                            </a>
                        </li>
                        <!-- End::header-element -->


                        <!-- Start::header-element -->
                        <li class="header-element header-theme-mode">
                            <!-- Start::header-link|layout-setting -->
                            <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon"
                             enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px"
                             fill="#000000">
                            <rect fill="none" height="24" width="24" />
                            <path
                                d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27 C17.45,17.19,14.93,19,12,19c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z"
                                opacity=".1" />
                            <path
                                d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z" />
                        </svg>
                        <!-- End::header-link-icon -->
                    </span>
                                <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon"
                             enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px"
                             fill="#000000">
                            <rect fill="none" height="24" width="24" />
                            <circle cx="12" cy="12" opacity=".1" r="3" />
                            <path
                                d="M12,9c1.65,0,3,1.35,3,3s-1.35,3-3,3s-3-1.35-3-3S10.35,9,12,9 M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5 S14.76,7,12,7L12,7z M2,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13l2,0c0.55,0,1-0.45,1-1 s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1C11.45,19,11,19.45,11,20z M5.99,4.58c-0.39-0.39-1.03-0.39-1.41,0 c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0s0.39-1.03,0-1.41L5.99,4.58z M18.36,16.95 c-0.39-0.39-1.03-0.39-1.41,0c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0c0.39-0.39,0.39-1.03,0-1.41 L18.36,16.95z M19.42,5.99c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06c-0.39,0.39-0.39,1.03,0,1.41 s1.03,0.39,1.41,0L19.42,5.99z M7.05,18.36c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06 c-0.39,0.39-0.39,1.03,0,1.41s1.03,0.39,1.41,0L7.05,18.36z" />
                        </svg>
                                    <!-- End::header-link-icon -->
                    </span>
                            </a>
                            <!-- End::header-link|layout-setting -->
                        </li>
                        <!-- End::header-element -->



                        <!-- Start::header-element -->
                        {{--<li class="header-element notifications-dropdown d-xl-block d-none dropdown">--}}
                        {{--    <!-- Start::header-link|dropdown-toggle -->--}}
                        {{--    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"--}}
                        {{--       data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">--}}
                        {{--        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon animate-bell" height="24px"--}}
                        {{--             viewBox="0 0 24 24" width="24px" fill="#000000">--}}
                        {{--            <path d="M0 0h24v24H0V0z" fill="none" />--}}
                        {{--            <path d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z" opacity=".1" />--}}
                        {{--            <path--}}
                        {{--                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z" />--}}
                        {{--        </svg>--}}
                        {{--        <span class="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span>--}}
                        {{--    </a>--}}
                        {{--    <!-- End::header-link|dropdown-toggle -->--}}
                        {{--    <!-- Start::main-header-dropdown -->--}}
                        {{--    <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">--}}
                        {{--        <div class="p-3">--}}
                        {{--            <div class="d-flex align-items-center justify-content-between">--}}
                        {{--                <p class="mb-0 fs-16">Notifications</p>--}}
                        {{--                <span class="badge bg-primary-transparent" id="notifiation-data">5 Unread</span>--}}
                        {{--            </div>--}}
                        {{--        </div>--}}
                        {{--        <div class="dropdown-divider"></div>--}}
                        {{--        <ul class="list-unstyled mb-0" id="header-notification-scroll">--}}
                        {{--            <li class="dropdown-item">--}}
                        {{--                <div class="d-flex align-items-start">--}}
                        {{--                    <div class="pe-2 lh-1">--}}
                        {{--            <span class="avatar avatar-md avatar-rounded bg-light p-1 svg-white">--}}
                        {{--               <img src="/assets/images/faces/15.jpg">--}}
                        {{--            </span>--}}
                        {{--                    </div>--}}
                        {{--                    <div class="flex-grow-1 d-flex align-items-start justify-content-between">--}}
                        {{--                        <div>--}}
                        {{--                            <p class="mb-0 fw-medium"><a href="javascript:void(0);">Luther Mahin<span class="text-muted fs-11 ms-2">2 Min Ago</span></a></p>--}}
                        {{--                            <div class="fw-normal fs-12 header-notification-text text-truncate">--}}
                        {{--                                Asked to join<span class="text-primary fw-medium ms-1">Ui Dashboad</span></div>--}}
                        {{--                            <div class="d-flex align-items-center gap-2 mt-2">--}}
                        {{--                                <button class="btn btn-sm btn-primary-light">Accept</button>--}}
                        {{--                                <button class="btn btn-sm btn-danger-light">Reject</button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <a href="javascript:void(0);"--}}
                        {{--                               class="min-w-fit-content text-muted dropdown-item-close1"><i--}}
                        {{--                                    class="ri-close-circle-line fs-5"></i></a>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </li>--}}
                        {{--            <li class="dropdown-item">--}}
                        {{--                <div class="d-flex align-items-center">--}}
                        {{--                    <div class="pe-2 lh-1">--}}
                        {{--            <span class="avatar avatar-md bg-light p-1 avatar-rounded svg-white">--}}
                        {{--                <img src="/assets/images/faces/2.jpg">--}}
                        {{--            </span>--}}
                        {{--                    </div>--}}
                        {{--                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">--}}
                        {{--                        <div>--}}
                        {{--                            <p class="mb-0 fw-medium"><a href="javascript:void(0);">Ronald Richard <span class="text-muted fs-11 ms-2">5 Min Ago</span></a></p>--}}
                        {{--                            <div class="fw-normal fs-12 header-notification-text text-truncate">--}}
                        {{--                                add New Products in <span class="text-secondary fw-medium ms-1">Cloth Category</span></div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <a href="javascript:void(0);"--}}
                        {{--                               class="min-w-fit-content text-muted dropdown-item-close1"><i--}}
                        {{--                                    class="ri-close-circle-line fs-5"></i></a>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </li>--}}
                        {{--            <li class="dropdown-item">--}}
                        {{--                <div class="d-flex align-items-center">--}}
                        {{--                    <div class="pe-2 lh-1">--}}
                        {{--            <span class="avatar avatar-md bg-light p-1 avatar-rounded svg-white">--}}
                        {{--                <img src="/assets/images/faces/6.jpg">--}}
                        {{--            </span>--}}
                        {{--                    </div>--}}
                        {{--                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">--}}
                        {{--                        <div>--}}
                        {{--                            <p class="mb-0 fw-medium"><a href="javascript:void(0);">--}}
                        {{--                                    Liam Parker<span class="text-muted fs-11 ms-2">1 Hr Ago</span></a></p>--}}
                        {{--                            <div class="fw-normal fs-12 header-notification-text text-truncate">--}}
                        {{--                                Mentioned You in Jobs Landing Page.</div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <a href="javascript:void(0);"--}}
                        {{--                               class="min-w-fit-content text-muted dropdown-item-close1"><i--}}
                        {{--                                    class="ri-close-circle-line fs-5"></i></a>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </li>--}}
                        {{--            <li class="dropdown-item">--}}
                        {{--                <div class="d-flex align-items-center">--}}
                        {{--                    <div class="pe-2 lh-1">--}}
                        {{--            <span class="avatar avatar-md bg-light p-1 avatar-rounded svg-white">--}}
                        {{--                <img src="/assets/images/faces/9.jpg">--}}
                        {{--            </span>--}}
                        {{--                    </div>--}}
                        {{--                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">--}}
                        {{--                        <div>--}}
                        {{--                            <p class="mb-0 fw-medium"><a href="javascript:void(0);">Owen Foster <span class="text-muted fs-11 ms-2">3 Day Ago</span></a></p>--}}
                        {{--                            <div class="fw-normal fs-12 header-notification-text text-truncate">--}}
                        {{--                                Invited To His Team As Lead</div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <a href="javascript:void(0);"--}}
                        {{--                               class="min-w-fit-content text-muted dropdown-item-close1"><i--}}
                        {{--                                    class="ri-close-circle-line fs-5"></i></a>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </li>--}}
                        {{--            <li class="dropdown-item">--}}
                        {{--                <div class="d-flex align-items-center">--}}
                        {{--                    <div class="pe-2 lh-1">--}}
                        {{--            <span class="avatar avatar-md bg-light p-1 avatar-rounded svg-white">--}}
                        {{--                <img src="/assets/images/faces/14.jpg">--}}
                        {{--            </span>--}}
                        {{--                    </div>--}}
                        {{--                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">--}}
                        {{--                        <div>--}}
                        {{--                            <p class="mb-0 fw-medium"><a href="javascript:void(0);">Henry Morgan <span class="text-muted fs-11 ms-2">5 Day Ago</span></a></p>--}}
                        {{--                            <div class="fw-normal fs-12 header-notification-text text-truncate">--}}
                        {{--                                Shared <span  class="text-success fw-medium ms-1">12 post</span> with you</div>--}}
                        {{--                        </div>--}}
                        {{--                        <div>--}}
                        {{--                            <a href="javascript:void(0);"--}}
                        {{--                               class="min-w-fit-content text-muted dropdown-item-close1"><i--}}
                        {{--                                    class="ri-close-circle-line fs-5"></i></a>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </li>--}}
                        {{--        </ul>--}}
                        {{--        <div class="p-3 empty-header-item1 border-top">--}}
                        {{--            <div class="d-grid">--}}
                        {{--                <a href="javascript:void(0);" class="btn btn-primary btn-wave">View All</a>--}}
                        {{--            </div>--}}
                        {{--        </div>--}}
                        {{--        <div class="p-5 empty-item1 d-none">--}}
                        {{--            <div class="text-center">--}}
                        {{--    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">--}}
                        {{--        <i class="ri-notification-off-line fs-2"></i>--}}
                        {{--    </span>--}}
                        {{--                <h6 class="fw-medium mt-3">No New Notifications</h6>--}}
                        {{--            </div>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}
                        {{--    <!-- End::main-header-dropdown -->--}}
                        {{--</li>--}}
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element header-fullscreen">
                            <!-- Start::header-link -->
                            <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                                <svg xmlns="http://www.w3.org/2000/svg" class=" full-screen-open header-link-icon" height="24px"
                                     viewBox="0 0 24 24" width="24px" fill="#000000">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="full-screen-close header-link-icon d-none"
                                     height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                </svg>
                            </a>
                            <!-- End::header-link -->
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        @yield('header:end')
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element">
                            <!-- Start::header-link|switcher-icon -->

                            <!-- End::header-link|switcher-icon -->
                        </li>
                        <!-- End::header-element -->

                    </ul>
                    <!-- End::header-content-right -->

                </div>
                <!-- End::main-header-container -->

            </header>
            <!-- /app-header -->
            <!-- Start::app-sidebar -->
            <aside class="app-sidebar sticky" id="sidebar">

                <!-- Start::main-sidebar-header -->
                <div class="main-sidebar-header">
                    <a href="{{ route('admin') }}" class="header-logo">
                        <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-logo" style="height: 40px;">
                        <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="toggle-dark" style="height: 40px;">
                        <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-dark" style="height: 40px;">
                        <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="desktop-white" style="height: 40px;">
                        <img src="{{ tempAsset('/assets/logos/logo.png') }}" alt="logo" class="toggle-logo" style="height: 40px;">
                    </a>
                </div>
                <!-- End::main-sidebar-header -->

                <!-- Start::main-sidebar -->
                <div class="main-sidebar" id="sidebar-scroll">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills flex-column sub-open">
                        <div class="slide-left" id="slide-left">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                        </div>
                        @yield('header:menu')
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->

            </aside>
            <!-- End::app-sidebar -->

            <!-- Start::app-content -->
            <div class="main-content app-content">
                <div class="container-fluid">
                    <br>
                    @yield('content')
                </div>
            </div>
            <!-- End::app-content -->


            <!-- Footer Start -->
            <footer class="footer mt-auto py-3 bg-white text-center">
                <div class="container">
                    <span class="text-muted"> All rights reserved</span>
                </div>
            </footer>
            <!-- Footer End -->

            @yield('modals')

        </div>

        <!-- Scroll To Top -->
        <div class="scrollToTop">
            <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
        </div>
        <div id="responsive-overlay"></div>
        <!-- Scroll To Top -->

        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="primaryToast" class="toast colored-toast" role="alert" aria-live="assertive"
                 aria-atomic="true">
                <div class="toast-header text-fixed-white">
                    <strong class="me-auto">Уведомление</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Your,toast message here.
                </div>
            </div>
        </div>

        <div class="modal effect-rotate-left" id="confirmation_modal" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel1">Уверены?</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="button" class="modal-link btn btn-primary" id="confirmation_modal_button">Подтвердить</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/libs/moment/moment.min.js?sdsdds"></script>

        <!-- Popper JS -->
        <script src="/assets/libs/@popperjs/core/umd/popper.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Defaultmenu JS -->
        <script src="/assets/js/defaultmenu.min.js"></script>

        <!-- Node Waves JS-->
        <script src="/assets/libs/node-waves/waves.min.js"></script>

        <!-- Sticky JS -->
        <script src="/assets/js/sticky.js"></script>

        <!-- Simplebar JS -->
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/js/simplebar.js"></script>

        <script src="/assets/libs/fg-emoji-picker/fgEmojiPicker.js"></script>

        <!-- Auto Complete JS -->
        <script src="/assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js"></script>

        <!-- Color Picker JS -->
        <script src="/assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

        <!-- Date & Time Picker JS -->
        <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>

        <!-- Tagify JS -->
        <script src="/assets/libs/@yaireo/tagify/tagify.js"></script>

        <!-- Apex Charts JS -->
        <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Custom JS -->
        <script src="/assets/js/custom.js"></script>


        <!-- Custom-Switcher JS -->
        <script src="/assets/js/custom-switcher.min.js"></script>

        <script src="/assets/libs/toastify-js/src/toastify.js"></script>


        <script src="/assets/libs/jquery/jquery.js"></script>

        <script src="/assets/libs/custom-datatables/datatables.jquery.js?1"></script>
        <script src="/assets/libs/masks/masks.jquery.js?2"></script>
        <script src="/assets/libs/select2/select2.min.js"></script>

        <script src="/assets/libs/nouislider/nouislider.min.js"></script>
        <script src="/assets/libs/wnumb/wNumb.min.js"></script>
        <script src="/assets/libs/quill/quill.min.js"></script>
        <script src="/assets/libs/libphonenumber/libphonenumber.min.js"></script>
        <script src="/assets/libs/he/he.js"></script>
        <script src="/assets/libs/clipboard/clipboard.js"></script>
        <script src="/assets/libs/accounting/accounting.js"></script>

        <script src="/assets/libs/highlight/highlight.min.js"></script>
        <script src="/assets/libs/highlight/languages/javascript.min.js"></script>
        <script src="/assets/libs/highlight/languages/json.min.js"></script>
        <script src="/assets/libs/highlight/languages/php.min.js"></script>
        <script src="/assets/libs/highlight/languages/http.min.js"></script>
        <script src="/assets/libs/highlight/languages/plaintext.min.js"></script>
        <script src="/assets/libs/summernote/summernote.min.js"></script>

        <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                }
            });

        </script>
        <script type="text/javascript" src="/assets/js/notifications.js?2"></script>
        <script type="text/javascript" src="/assets/js/active-links.js"></script>
        <script type="text/javascript" src="{{ tempAsset('/assets/js/tg-picker.js') }}"></script>
        <script type="text/javascript" src="{{ tempAsset('/assets/js/core.js') }}"></script>
        <script type="text/javascript" src="{{ tempAsset('/assets/js/helpers.js') }}"></script>
        <script type="text/javascript" src="{{ tempAsset('/assets/js/plugins.js') }}"></script>

        @yield('scripts')

    </body>

</html>
