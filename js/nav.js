$(document).ready(function () {
    // Menambahkan event click pada elemen dengan ID "navbarDropdown"
    $("#navbarDropdown").click(function (e) {
        // Menghentikan peristiwa klik dari berpropagasi ke elemen lain
        e.stopPropagation();
        // Mencari elemen dropdown dan menampilkannya
        $(this).next(".dropdown-menu").toggle();
    });

    // Menambahkan event click ke elemen dokumen untuk menyembunyikan dropdown saat mengklik di luar dropdown
    $(document).click(function () {
        $(".dropdown-menu").hide();
    });
});