$(window).on("load", function() {
    $(".product_img2 img").each(function() {
        var imgHeight = $(this).height();
        var imgWidth = $(this).width();

        var posX = (70.0-imgWidth)/2.0;
        var posY = (70.0-imgHeight)/2.0;

        $(this).css( {
            position: "relative",
            left: posX + "px",
            top: posY + "px",
        });
    });
});
