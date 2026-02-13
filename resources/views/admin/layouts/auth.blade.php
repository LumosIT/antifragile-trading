<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

    <head>

        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Restricted area</title>
        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

        <!-- Main Theme Js -->
        <script src="/assets/js/authentication-main.js"></script>

        <!-- Bootstrap Css -->
        <link id="style" href="/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

        <!-- Style Css -->
        <link href="/assets/css/styles.css" rel="stylesheet" >

        <!-- Icons Css -->
        <link href="/assets/css/icons.css" rel="stylesheet" >


    </head>

    <body class="authentication-background">

        <div class="container">
            <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    @yield('content')
                </div>
            </div>
        </div>


        <!-- Bootstrap JS -->
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Show Password JS -->
        <script src="/assets/js/show-password.js"></script>

        <script src="/assets/libs/jquery/jquery.js"></script>

        <script src="/assets/libs/libphonenumber/libphonenumber.min.js"></script>
        <script src="/assets/libs/he/he.js"></script>
        <script src="/assets/libs/clipboard/clipboard.js"></script>
        <script src="/assets/libs/accounting/accounting.js"></script>

        <script type="text/javascript" src="/assets/js/notifications.js"></script>
        <script type="text/javascript" src="/assets/js/core.js?z"></script>

        <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                }
            });

        </script>

        @yield('scripts')

    </body>

</html>
