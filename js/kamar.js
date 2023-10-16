$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        items: 3, // Menampilkan 3 item dalam satu tampilan
        loop: true,
        nav: true,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
    });
});