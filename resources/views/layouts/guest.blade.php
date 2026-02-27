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
            .area{
                position:fixed;
                inset:0;
                z-index:-1;
                background: linear-gradient(to left, #8f94fb, #4e54c8);
                overflow:hidden;
            }

            .circles{
                position:absolute;
                inset:0;
            }

            .circles li{
                position:absolute;
                display:block;
                list-style:none;
                width:20px;
                height:20px;
                background: rgba(255,255,255,0.2);
                animation: animate 25s linear infinite;
                bottom:-150px;
            }

            /* размеры кружков */
            .circles li:nth-child(1){ left:25%; width:80px; height:80px;}
            .circles li:nth-child(2){ left:10%; animation-duration:12s;}
            .circles li:nth-child(3){ left:70%;}
            .circles li:nth-child(4){ left:40%; width:60px; height:60px; animation-duration:18s;}
            .circles li:nth-child(5){ left:65%;}
            .circles li:nth-child(6){ left:75%; width:110px; height:110px;}
            .circles li:nth-child(7){ left:35%; width:150px; height:150px;}
            .circles li:nth-child(8){ left:50%; animation-duration:45s;}
            .circles li:nth-child(9){ left:20%; animation-duration:35s;}
            .circles li:nth-child(10){ left:85%; width:150px; height:150px;}

            @keyframes animate {
                0%{
                    transform:translateY(0) rotate(0deg);
                    opacity:1;
                    border-radius:0;
                }
                100%{
                    transform:translateY(-1000px) rotate(720deg);
                    opacity:0;
                    border-radius:50%;
                }
            }
        </style>

    </head>

    <body>

    <div class="area">
        <ul class="circles">
            <li></li><li></li><li></li><li></li><li></li>
            <li></li><li></li><li></li><li></li><li></li>
        </ul>
    </div>

        <div class="page">
            <!-- Start::app-content -->
            <div class="app-content">
                <div class="container-fluid">
                    <br>
                    @yield('content')
                </div>
            </div>
            <!-- End::app-content -->

            @yield('modals')
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
