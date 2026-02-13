(function () {
    "use strict";

    var lightboxVideo = GLightbox({
        selector: '.glightbox'
    });
    lightboxVideo.on('slide_changed', ({ prev, current }) => {
        console.log('Prev slide', prev);
        console.log('Current slide', current);

        const { slideIndex, slideNode, slideConfig, player } = current;
    });

    // swiper with navigation
    var swiper = new Swiper(".swiper-related-products", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        }
    });

    // swiper with navigation
    var swiper1 = new Swiper(".swiper-reviews", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        }
    });

     // for nummber of products selected 
     var value = 1,
     minValue = 0,
     maxValue = 30;

 let productMinusBtn = document.querySelectorAll(".product-quantity-minus")
 let productPlusBtn = document.querySelectorAll(".product-quantity-plus")
 productMinusBtn.forEach((element) => {
     element.onclick = () => {
         value = Number(element.parentElement.childNodes[3].value)
         if (value > minValue) {
             value = Number(element.parentElement.childNodes[3].value) - 1;
             element.parentElement.childNodes[3].value = value;
         }
     }
 })
 productPlusBtn.forEach((element) => {
     element.onclick = () => {
         if (value < maxValue) {
             value = Number(element.parentElement.childNodes[3].value) + 1;
             element.parentElement.childNodes[3].value = value;
         }
     }
 })
    
})();

