document.addEventListener("DOMContentLoaded", function () {
    // Seleksi elemen dengan kelas "fade-in"
    const elements = document.querySelectorAll(".fade-in");
    
    // Tambahkan animasi pada elemen-elemen tersebut
    elements.forEach(function (element, index) {
        element.style.animationDelay = `${index * 0.2}s`;
    });
});