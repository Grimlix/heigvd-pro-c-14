$(function () {
    $(".menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $("#sidebar-wrapper").toggleClass("shadow-lg");
    });
});