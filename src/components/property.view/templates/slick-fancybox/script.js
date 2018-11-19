window.addEventListener('DOMContentLoaded', function(){
    $(".jsPropertyViewSlickFancyboxMainArea").slick({
        infinite: false,
    })
    $(".jsPropertyViewSlickFancyboxSmallGalery").slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
    })
    $(".jsPropertyViewSlickFancyboxSmallGalery .propertyViewSlickFancyboxSmallGalery__item").on("click", function(){
        var index = $(this).data('slick-index')
        $(".jsPropertyViewSlickFancyboxMainArea").slick('slickGoTo', index)
    })
})
