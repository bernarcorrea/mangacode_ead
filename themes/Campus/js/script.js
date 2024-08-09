(function (document, window, $) {
    $(document).ready(function () {
        $(".slide_courses_home").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            pauseOnHover: false,
            autoplay: true,
            autoplaySpeed: 5000,
            speed: 1000,
            prevArrow: '.prev',
            nextArrow: '.next',
        });

        $(".slide_classes_home").slick({
            centerMode: true,
            slidesToShow: 1,
            pauseOnHover: false,
            autoplay: true,
            autoplaySpeed: 5000,
            prevArrow: '.prev',
            nextArrow: '.next',
        });

        $(".slide_classes").slick({
            centerMode: true,
            slidesToShow: 1,
            pauseOnHover: false,
            autoplay: false,
            prevArrow: '.prev',
            nextArrow: '.next',
        });
    });
})(document, window, jQuery);