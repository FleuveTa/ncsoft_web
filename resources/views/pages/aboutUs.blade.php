@extends('main')
@section('banner')
        @if (!empty($data) && !empty($data['dataBanner']))
            <div class="banner__concat container-fluid px-0">
                <img src="{{ url('/images/pages/'.$data['dataBanner']['image']) }}" alt="banner" class="img-fluid">
                <div class="overlay"></div>
                <div class="banner__content left">
                    <div class="container">
                        {{ $data['dataBanner']['heading'] ?? ''}}
                        <div class="banner__title">
                            {{ $data['dataBanner']['title'] ?? ''}}
                        </div>
                    </div>
                </div>
                
        </div>
        @endif
@endsection
@section('content')

@if (!empty($data) && !empty($data['dataActuallyDo']))
<div class="container container__common">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 pr-40">
            <div class="content__common">
                <span class="comment__heading">
                    {{ __('comment_actually_about') }}
                </span>
                <div class="content__heading">
                    <h2>
                        {{ $data['dataActuallyDo']['heading'] ?? '' }}
                    </h2>
                    <div class="tech__box">
                        <div class="icon__wrapper">
                            <div class="icon__main">
                                <i class="fa-brands fa-php"></i>
                                <span class="tool__tip">{{ __('php_tooltip') }}</span>
                            </div>
                        </div>
                        <div class="icon__wrapper">
                            <div class="icon__main">
                                <i class="fa-brands fa-node-js"></i>
                                <span class="tool__tip">{{ __('js_tooltip') }}</span>
                            </div>
                        </div>
                        <div class="icon__wrapper">
                            <div class="icon__main">
                                <i class="fa-brands fa-react"></i>
                                <span class="tool__tip">{{ __('react_tooltip') }}</span>
                            </div>
                        </div>
                        <div class="icon__wrapper">
                            <div class="icon__main">
                                <i class="fa-brands fa-css3-alt"></i>
                                <span class="tool__tip">{{ __('css_tooltip') }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="content__title-c">
                        {{ $data['dataActuallyDo']['title'] ?? '' }}
                    </p>
                    <p class="content__description mb-5">
                        {{ $data['dataActuallyDo']['description'] ?? '' }}
                    </p>
                </div>
                @if (!empty($data['dataActuallyDo']['button']))
                    <div class="btn__common mb-5">
                        <i class="fa-solid fa-arrow-right-long btn__common-icon"></i>
                        <span class="btn__common-text">
                            {{ $data['dataActuallyDo']['button'] ?? '' }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6 pl-40">
            <img src="{{ url('images/pages/'.$data['dataActuallyDo']['image'] ?? '') }}" class="img-fluid" alt="actuallydo">
        </div>
    </div>
</div>
@endif

<div class="fill__wrapper mt-5 common__slider common__background-field">
    <div class="container">
        <div class="content__common">
            <div class="content__heading text-center">
                <h2 style="color: #fff">
                    {{ __('fill_content_about') }}?
                </h2>
            </div>
            <div class="content__fill-list mb-5">
                @if (!empty($data['dataFillContent']))
                    @foreach ($data['dataFillContent'] as $fillItem)
                        <div class="content__fill-item">
                            {!! $fillItem['icon'] ?? '' !!}
                            <h3 class="content__fill-heading">
                                {{ $fillItem['heading'] ?? '' }}
                            </h3>
                            <p class="content__fill-text five-line-paragraph-l">
                                {{ $fillItem['title'] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@if (!empty($data))
<div class="container container__common" id="testimonial">
    @if (!empty($data['dataTestimonialsAbout']))
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 testimonial_img pr-40">
            <img src="{{ url('images/pages/'.$data['dataTestimonialsAbout']['image']) }}" class="img-fluid" alt="">
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6 testimonial__content pl-40 my-5">
            <div class="content__common">
                <span class="comment__heading-note">
                    our clients
                </span>
                <div class="content__heading">
                    <h2>
                        {{ $data['dataTestimonialsAbout']['heading'] ?? '' }}
                    </h2>
                </div>
                <div class="testi__list">
                    @if (!empty($data['datalistContentTesti']))
                        @foreach ($data['datalistContentTesti'] as $itemListContent)
                            <div class="testi__items">
                                <div class="testi__item-text">
                                    {{ $itemListContent['description'] ?? '' }}
                                </div>
                                <div class="testi__item-head">
                                    {{ $itemListContent['title'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    @endif
    
</div>
@endif


<div class="container container__common">
    @if (!empty($data) && !empty($data['dataAboutLibrary']))
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 mt-5 content__common">
                <div class="container text-center content__heading">
                    <h2>Thư viện ảnh</h2>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="content__photo-list">
                    @foreach ($data['dataAboutLibrary'] as $provideItem)
                        <div class="content__photo-item">
                            <a href="{{ url('images/pages/'.$provideItem['image']) }}" class="content__photo-link">
                                <img src="{{ url('images/pages/'.$provideItem['image']) }}" class="img-fluid content__photo-img" alt="about">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
</div>


@if (!empty($data))
<div class="container-fluid intro__about container__common">
    <div class="container intro_heading content__common">
        @if (!empty($data['dataIntroProject']))
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    
                    <span class="comment__heading">
                        {{ __('comment_intro_about') }}
                        
                    </span>
                    <div class="content__heading">
                        <h2>
                            {{ $data['dataIntroProject']['heading'] ?? '' }}
                        </h2>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 my-5">
                    <p class="intro__heading-title">
                        {{ $data['dataIntroProject']['title'] ?? '' }}
                    </p>
                </div>
            </div>      
        @endif
        
    </div>

    @if (!empty($data['dataIntroContent']))
        <div class="intro_list">
            @foreach ($data['dataIntroContent'] as $itemIntroContent)
                <div class="intro_item">
                    <div class="intro__item-img">
                        <img src="{{ url('images/pages/'.$itemIntroContent['image']) }}" class="img-fluid" alt="intro">
                        <div class="intro__overlay"></div>
                    </div>
                    <div class="intro__info">
                        <div class="intro__info-inner">
                            <h5>{{ $itemIntroContent['heading'] ?? ''}}</h5>
                            <p class="intro__info-cates">
                                {{ $itemIntroContent['title']  ?? ""}}
                            </p>
                            <div class="intro__cicle-inner"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@if (!empty($data['dataConsultation']))
    <div class="container-fluid consultation px-0">
        <img src="{{ url('/images/pages/'.$data['dataConsultation']['image']) }}" class="cosultation_img" alt="consulation">
        <div class="consultation__wrapper">
            <div class="container text-center">
                <span class="consultation__comment">
                    {{ __('consultation_comment_about') }}
                </span>
                <p class="cosultation__heading">
                    {{ $data['dataConsultation']['heading'] }}
                </p>
                <a href="/contact-us" class="btn btn__custom-h">
                    {{ $data['dataConsultation']['button'] }}
                </a>
            </div>
        </div>
    </div>
@endif
@endif

@endsection