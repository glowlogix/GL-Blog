$ = jQuery;
$(function() {
    //caches a jQuery object containing the header element
    var header = $(".navigationwrape ");
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 50) {
            $(".navigationwrape").addClass("sticky");

        } else {
            $(".navigationwrape").removeClass("sticky");
        }
    });
});