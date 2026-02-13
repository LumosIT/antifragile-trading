<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title }}</title>
        <link rel="stylesheet" href="/assets/css/normalize.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <style>
            body{
                font: 14px Roboto, Arial;
            }

            .form{
                padding: 40px;
            }

            .group{
                margin-bottom: 30px;
                display: block;
                width: 100%;
                position: relative;
            }

            .input{
                border-bottom: 2px solid #e1e1e1;
                font-size: 14px;
                width: 100%;
                padding: 6.5px 0;
                transition: border-color 0.05s;
            }



            .h1{
                margin-top: 50px;
                font-size: 30px;
                font-weight: 200;
            }

            .h2{
                font-size: 18px;
                font-weight: 400;
                margin-top: 10px;
                margin-bottom: 40px;
            }

            .input:focus{
                border-color: #814be0;
            }

            .label{
                position: absolute;
                left: 0;
                transition: all 0.2s;
            }

            .input ~ .label{
                top: 50%;
                transform: translateY(-50%);
                color: #858585;
            }

            .input:focus ~ .label,
            .input.filled ~ .label{
                font-size: 10px;
                top: -5px;
                color: #814be0;
            }

            .select{
                margin-top: 10px;
                width: 100%;
                padding: 10px 10px;
                border-radius: 5px;
                color: #000000;
            }

            .select ~ .label{
                font-size: 10px;
                top: -5px;
                color: #858585;
            }

            .select.filled ~ .label{
                color: #814be0;
            }

            .button{
                background: #814be0;
                color: white;
                width: 100%;
                text-align: center;
                padding: 10px;
                border-radius: 5px;
            }

            .button:focus, .button:hover{
                background: #6c36cc;
            }

            .button[disabled]{
                background: #858585 !important;
            }

            .checkbox{
                position: relative;
                padding-left: 30px;
                display: block;
                min-height: 20px;
                margin-bottom: 20px;
                user-select: none;
            }

            .checkbox-body{
                position: absolute;
                top: 0;
                left: 0;
            }

            .checkbox-text{
                font-size: 12px;
                color: #858585;
                /*padding-top: 2px;*/
            }

            .checkbox-icon{
                color: white;
                width: 80%;
                height: 80%;
                display: inline-block;
                opacity: 0;
                mask: url("/assets/images/custom/check.svg") no-repeat;
                mask-size: contain;
                background: currentColor;
            }

            .checkbox-body{
                position: absolute;
                width: 20px;
                height: 20px;
                border: 2px solid #6c36cc;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .checkbox-input{
                position: fixed;
                left: -1000px;
                top: -1000px;
                opacity: 0;
            }

            .checkbox-input:checked ~ .checkbox-body .checkbox-icon{
                opacity: 1;
            }

            .checkbox-input:checked ~ .checkbox-body{
                background: #6c36cc;
            }

            .checkbox-text a{
                color: #6c36cc;
            }

            @media (min-width: 700px){
                .form{
                    margin: 0 auto;
                    max-width: 900px;
                }
            }

        </style>
        @stack('styles')
    </head>
    <body>
        @yield('content')
        <script src="/assets/libs/jquery/jquery.js"></script>
        @stack('scripts')
    </body>
</html>
