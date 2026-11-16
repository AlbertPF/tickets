// Inicializar AOS
AOS.init({ duration: 700, once: true });

// 1. Inicializar Typed.js (Letras dinámicas)
new Typed('#typed-hero', {
    strings: [
        'Asistencia Técnica',
        'Soporte SIGA y SIAF',
        'Infraestructura de Redes',
        'Soluciones Informáticas'
    ],
    typeSpeed: 55,
    backSpeed: 35,
    backDelay: 2000,
    loop: true
});

// 2. Inicializar Swiper.js (Carrusel de ilustraciones)
new Swiper('.heroSwiper', {
    loop: true,
    autoplay: {
        delay: 4500,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});
