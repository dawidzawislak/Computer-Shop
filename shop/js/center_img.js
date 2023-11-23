$(window).on("load", function() {
    $(".product_img img").each(function() {
        var imgHeight = $(this).height();
        var imgWidth = $(this).width();

        var posX = (120.0-imgWidth)/2.0;
        var posY = (120.0-imgHeight)/2.0;

        $(this).css( {
            position: "relative",
            left: posX + "px",
            top: posY + "px",
        });
    });
});
