<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<!-- carousel styles -->
<style>
    .carousel {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        background: #f8f8f8;
        padding: 10px;
    }

    .carousel-inner {
        width: 100%;
        text-align: center;
    }

    .carousel-inner img {
        max-width: 100%;
        max-height: 320px;
        width: auto;
        height: auto;
        object-fit: contain; /* ВАЖНО */
    }

    .carousel-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-top: 12px;
    }

    .nav-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: #0d6efd;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: 0.2s;
    }

    .nav-btn:hover {
        background: #0b5ed7;
    }

    .counter {
        font-size: 14px;
        color: #666;
    }

    .clickable {
        cursor: zoom-in;
    }

    /* затемнённый фон */
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: zoom-out;
    }

    /* большая картинка */
    .lightbox-img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    }
</style>

<style>
    @import url('https://fonts.googleapis.com/css?family=Exo:400,700');

    *{
        margin:0;
        padding:0;
    }

    body{
        font-family:'Exo', sans-serif;
        min-height:100vh;
    }

    /* ================= BACKGROUND ================= */

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

    .media-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        display: block;
    }
    .media-loader {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    [v-cloak] {
        display: none;
    }

    .need-colored:nth-of-type(odd) {
        background-color: #212529;
        color: #fff;
    }

    .need-colored:nth-child(odd) {
        background-color: #212529;
        color: #fff;
    }

    video {
        position: relative;
        z-index: 1;
    }
</style>

<!-- carousel -->
<style>
    .custom-indicators {
        position: static !important;
        margin-top: 15px;
    }

    .carousel-controls {
        margin-top: 15px;
    }

</style>