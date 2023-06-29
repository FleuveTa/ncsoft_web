<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ url('images/logo_primary.png') }}">
    <title>NCsoft</title>

    <link rel="stylesheet" href="{{ url('bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('slick/slick.css') }}">
    <link rel="stylesheet" href="{{ url('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ url('js/magnific_popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('fontawesome/all.min.css') }}">
    @vite(['resources/js/app.js?v=123', 'resources/sass/app.scss'])


    @php
        $color = Helper::getColor();
        $dataFont = Helper::getFont();
        $font_family = $dataFont['font_family'].', sans-serif';
        $font_face = $dataFont['font_value'];
    @endphp

    <style>
        :root {
            --primary-color: {{ $color->primary_color ?? '#1fdf66'}};
            --heading-color: {{ $color->text_color ?? '#0f3c11'}};
            --background-color: {{ $color->background_color ?? '#232223'}};
            --border-color: {{ $color->border_color ?? '#179a47' }};
            --text-primary-color: {{ $color->text_primary_color ?? '#0f3c11' }};
            --sub-text-primary-color: {{ $color->sub_text_primary_color ?? '#0f3c11' }};
            --text-background-color: {{ $color->text_background_color ?? '#0f3c11' }};
            --background-button-color: {{ $color->background_button_color ?? '#0f3c11' }};
            --background-hover-color : {{  $color->background_hover_color ?? '#0f3c11' }};
            --text-button-color: {{  $color->text_button_color ?? '#0f3c11' }};
            --hover-text-button-color: {{  $color->hover_text_button_color ?? '#0f3c11' }};
            --icon-color: {{  $color->icon_color ?? '#0f3c11' }};
            --icon-background-color: {{  $color->icon_background_color ?? '#0f3c11' }};
            --header-background-color: {{ $color->header_background_color ?? '#ffffff' }};
            --header-text-color: {{ $color->header_text_color ?? '#ffffff' }};
            --header-active-color: {{ $color->header_active_color ??  '#1fdf66'}};
            --comment-text-color: {{ $color->comment_text_color ??  '#0f3c11'}};
            --comment-background-color: {{ $color->comment_background_color ??  '#0f3c11'}};
            --slider-color: {{ $color->slider_color ?? '#1fdf66' }};
            --box-service-color: {{ $color->box_service_color ??  '#1fdf66'}};
        }

        body,html {
            font-family: {{ $font_family }};
            {{ $font_face }}
        }

        
    </style>
</head>
<body style="position:relative;">
        <div class="container-fluid px-0">
            @include('component/header')
            @yield('banner')
        </div>

        <section id="content">
            @yield('content')
        </section>

        @include('component/footer')

        <div class="scroll-to-top">
            <i class="fa-solid fa-chevron-up"></i>
        </div>
        <script src="{{ url('jquery/jquery2-2-4.min.js') }}"></script>
        <script src="{{ url('bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ url('slick/slick.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('sweetalert2/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/magnific_popup/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ url('jquery/waypoints.min.js') }}"></script>
        <script src="{{ url('jquery/jquery.counterup.min.js') }}"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $('.banner').slick({

                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                speed: 500,
                //fade: true,
                dots: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>'
            });

        
            // news orther slider
            $('.slide-news').slick({
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>',
                responsive: [
                    {
                    breakpoint: 1204,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                    }
                    },
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.content__provide-list').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>',
                responsive: [
                    {
                    breakpoint: 1224,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.content__fill-list').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>',
                responsive: [
                    {
                    breakpoint: 1224,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false
                        }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.content__photo-list').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 2,
                prevArrow: false,
                nextArrow: false,
                responsive: [
                    {
                    breakpoint: 1224,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.testi__list').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                speed: 500,
                dots: false,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: '<div class="slick-prev"><i class="fa-solid fa-chevron-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa-solid fa-chevron-right"></i></div>'
            });

            
            $('.intro_list').slick({
                centerMode: true,
                dots: true,
                centerPadding: '60px',
                slidesToShow: 3,
                prevArrow: false,
                nextArrow: false,
                responsive: [
                    {
                    breakpoint: 1280,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                    },
                    {
                    breakpoint: 1080,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                    },
                    {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                    },
                    ,
                    {
                    breakpoint: 520,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                    }
                ]
            });

            $('.service__box-list').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                autoplay: true,
                autoplaySpeed: 1000,
                slidesToScroll: 1,
                prevArrow: false,
                nextArrow: false,
                responsive: [
                    {
                    breakpoint: 1224,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });


            
            // scroll Top
            $(window).scroll(function () {
                if ($(this).scrollTop() > 125) {
                    $('.scroll-to-top').addClass("active");
                    $('#header').addClass("active");
                } else {
                    $('.scroll-to-top').removeClass("active");
                    $('#header').removeClass("active");
                }
            });

            $('.scroll-to-top').click(function () {
                $(window).scrollTop({ top: 0, behavior: 'smooth' });
            });

            $('.navbar-toggler').click(function () {
                $('#header').toggleClass("expanded")
            });

            // end scroll top


            $('.content__photo-list').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                }
            });

            //toggle header search
            $('.header__search-icon-search').click(function(e){
                $('.header__search').addClass('active');
            });
            $('.header__search-icon-close').click(function(){
                $('.header__search').removeClass('active');
            })
        })
    </script>

    @yield('script')
</body>
</html>
