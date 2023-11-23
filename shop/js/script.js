var sbmit = function() {
    $('#send').click();
};

$(document).ready(function() {

    var filtersHeight = $('#filters').css('height');
    filtersHeight = filtersHeight.replace('px','');
    var contentHeight = $('#products').css('height');
    contentHeight = contentHeight.replace('px','');

    if(parseInt(filtersHeight) > parseInt(contentHeight))
        $('#filters').css("border-right", "2px dashed #262626");
    else
        $('#products').css("border-left", "2px dashed #262626");

    $('.image-link').magnificPopup({type:'image'});
});

$('.without-caption').magnificPopup({
  type: 'image',
  closeOnContentClick: true,
  closeBtnInside: false,
  mainClass: 'mfp-no-margins mfp-with-zoom',
  image: {
      verticalFit: true
  },
  zoom: {
      enabled: true,
      duration: 300
  }
});

$('.with-caption').magnificPopup({
  type: 'image',
  closeOnContentClick: true,
  closeBtnInside: false,
  mainClass: 'mfp-with-zoom mfp-img-mobile',
  image: {
      verticalFit: true,
      titleSrc: function(item) {
          return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
      }
  },
  zoom: {
      enabled: true
  }
});