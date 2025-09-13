// jQuery sicher laden
var slider = document.querySelector('.bv24-swiper');
if (slider && slider.slick) {
  alert('Slick wird entfernt');
  slider.slick.unslick();
}
// Nur Swiper initialisieren, falls jQuery nicht vorhanden ist
document.addEventListener('DOMContentLoaded', function () {
  new Swiper('.swiper', {
    slidesPerView: 1.5,
    spaceBetween: 10,
    loop: true,
    //autoplay: { delay: 3000 },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    breakpoints: {
      1024: { slidesPerView: 4 },
      600: { slidesPerView: 2.5 }
    },

  });

  new Swiper('.usp-swiper', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    autoplay: { delay: 3000 },
    
    breakpoints: {
      1440: { slidesPerView: 4 },
      1024: { slidesPerView: 3 },
      600: { slidesPerView: 2 }
    },

  });
});





/* require(['jquery', 'slick'], function ($) {
  $(document).ready(function () {
    $('.wat-product-slider .products-grid .product-items').slick({
      slidesToShow: 6,
      responsive: [
        {
          breakpoint: 1024,
          settings: { slidesToShow: 2 }
        },
        {
          breakpoint: 600,
          settings: { slidesToShow: 1 }
        }
      ],
      slidesToScroll: 1,
      infinite: false,
      draggable: false,
      swipe: true,
      touchThreshold: 5,
      arrows: true,
      dots: false,
      variableWidth: false
    });
  });
});


 */