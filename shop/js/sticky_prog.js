$(document).ready(function() {
    var NavY = $('#prog').offset().top;

    var stickyNav = function() {
        var ScrollY = $(window).scrollTop();

        if(ScrollY > NavY)
            $('#prog').addClass('sticky');
        else
            $('#prog').removeClass('sticky');
    };

    stickyNav();
    $(window).scroll(function() { stickyNav(); });
});
