@extends('main')
@section('banner')
    @include('layout/banner/banner')
@endsection
@section('content')

{{-- <div class="container  container__common introducemt-5">
    <div class="content__common">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="content__heading">
                    <h1>{{ __('introduction') }}.</h1>
                    <p class="content__title my-4">
                        {{ __('introduction_content') }}
                    </p>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                @if (!empty($dataIntroduction))
                    <img src="{{ url('images/pages/'.$dataIntroduction['image']) }}" alt="introduce" class="img-fluid introduce__img">
                @else
                    <img src="{{ url('images/banner.jpg') }}" alt="introduce" class="img-fluid introduce__img">
                @endif

            </div>

        </div>

    </div>
</div> --}}


@if (!empty($dataActuallyDo))
<div class="container actually container__common">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 pl-40">
            @if (!empty($dataActuallyDo['image']))
                <img src="{{ url('images/pages/'.$dataActuallyDo['image']) }}" class="img-fluid" alt="banner">
            @else 
                <img src="{{ url('images/banner.jpg') }}" class="img-fluid" alt="banner">
            @endif
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6 pr-40">
            <div class="content__common">
                <span class="comment__heading actually__comment">
                    {{ __('comment_heading_actually_home') }}
                </span>
                <div class="content__heading actually__heading">
                    <h2>
                        {{ $dataActuallyDo['heading'] ?? ''}}
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
                    <p class="content__title-c actually__title">
                        {{ $dataActuallyDo['title']  ?? ''}}
                    </p>
                    <p class="content__description mb-5 actually__description">
                        {{ $dataActuallyDo['description']  ?? ''}}
                    </p>
                </div>
                <div class="btn__common mb-5">
                    <a href="{{ route('about-us') }}">
                        <i class="fa-solid fa-arrow-right-long btn__common-icon"></i>
                        <span class="btn__common-text">
                            {{ $dataActuallyDo['button']  ?? ''}}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- {{ dd($inprove_info_home) }} --}}
@if (!empty($dataImprove) && !empty($inprove_info_home))
<div class="container__common" id = "inprove">
    <div 
            class="inprove__wrapper common__background-field" 
            style="background-image: url({{ url('images/pages/'.$inprove_info_home['image']) }});
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;"
    >
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="content__common inprove__content">
                        <span class="comment__heading ">
                            {{ __('comment_heading_inprove_home') }}
                        </span>
                        <div class="content__heading">
                            <h2 class="">
                                {{ $inprove_info_home['heading'] ?? '' }}
                                {{-- {{ __('heading_inprove_home') }} --}}
                            </h2>
                            <p class="content__description mb-5 ">
                                {{ $inprove_info_home['description'] }}
                                {{-- {{ __('description_inprove_home') }} --}}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-4" >
                                <div class="icouter-wrapper">
                                    <div>
                                        <span class="num">
                                            {{ __('num_one_home') }}
                                        </span>
                                        <span>+</span>
                                    </div>
                                    <h5 class=" num-text">
                                        {{ __('title_num_one') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-4" >
                                <div class="icouter-wrapper">
                                    <div class="">
                                        <span class="num">
                                            {{ __('num_two_home') }}
                                        </span>
                                        <span>+</span>
                                    </div>
                                    <h5 class=" num-text">
                                        {{ __('title_num_two') }}
                                    </h5>
                                </div>
                            </div>
                            <div class=" col-sm-12 col-md-4">
                                <div class="icouter-wrapper">
                                    <div>
                                        <span class="num">
                                            {{ __('num_three_home') }}
                                        </span>
                                        <span>+</span>
                                    </div>
                                    <h5 class=" num-text">
                                        {{ __('title_num_three') }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        @foreach ($dataImprove as $itemImprove)
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="improve__img">
                                    <a href="#" class="improve__img-link">
                                        <img src="{{ url('images/pages/'.$itemImprove['image']) }}" class="img-fluid" alt="">
                                        <div class="overlay"></div>
                                        <div class="improve__img-text">
                                            {{ $itemImprove['heading'] }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif



@if (!empty($dataExperience))
<div class="container-fluid experience__wrapper container__common">
    <div class="container  experience__heading content__common">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <span class="comment__heading">
                    {{ __('comment_experience_home') }}
                </span>
                <div class="content__heading">
                    <h2>
                        {{ __('heading_experience_home') }}
                    </h2>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 my-5">
                <p class="intro__heading-title">
                    
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="experience__info">
            <div class="row">
                @foreach ($dataExperience as $keyExperience => $itemExperience)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="experience__item">
                            <div class="experience__heading">
                                <img src="{{ url('images/pages/'.$itemExperience['image']) }}" class="img-fluid" alt="">
                                <h3>{{ $itemExperience['heading'] ?? '' }}</h3>
                                <div class="number-box">
                                    @if ($keyExperience && $keyExperience + 1 < 9 )
                                        {{ $keyExperience + 1 }}
                                    @else
                                        {{ $keyExperience + 1 }}
                                    @endif
                                </div>
                            </div>

                            <div class="experience__subitem">
                                <div class="experience__overlay"></div>
                                <div class="experience__subitem-content">
                                    <div class="experience__item-text">
                                        {{ $itemExperience['description'] ?? '' }}
                                    </div>
                                    <div class="btn__common btn__experience mb-5">
                                        <i class="fa-solid fa-arrow-right-long btn__common-icon"></i>
                                        <a class="btn__common-text" href="{{ route('service') }}">
                                            {{ $itemExperience['button'] ?? '' }}
                                        </a>
                                    </div>
                                </div>
                                <div class="number-box">
                                    @if ($keyExperience && $keyExperience + 1 < 9)
                                        {{ $keyExperience + 1 }}
                                    @else
                                        {{ $keyExperience + 1 }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endif

{{-- <div class="container missing">
    <div class="content__common">
        <div class="content__heading text-center">
            <h1>Missing</h1>
            <p class="content__title-c">
                NCSoft is a company specializing in software development, training quality engineers,
                researching and developing products and services in the field of web solutions,
                mobile applications for all the world.
            </p>
        </div>
        <div class="missing__content">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="missing__item">
                        <h2 class="missing__heading">
                            Our People
                        </h2>
                        <p class="missing__text">
                            Every person is valued and empowered to make an impact
                        </p>

                    </div>

                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="missing__item">
                        <h2 class="missing__heading">
                            Our People
                        </h2>
                        <p class="missing__text">
                            Every person is valued and empowered to make an impact
                        </p>

                    </div>

                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="missing__item">
                        <h2 class="missing__heading">
                            Our People
                        </h2>
                        <p class="missing__text">
                            Every person is valued and empowered to make an impact
                        </p>

                    </div>

                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="missing__item">
                        <h2 class="missing__heading">
                            Our People
                        </h2>
                        <p class="missing__text">
                            Every person is valued and empowered to make an impact
                        </p>

                    </div>

                </div>
            </div>
    </div>
</div> --}}

{{-- <div class="container status mb-5">
    <div class="content__common">
        <div class="content__heading text-center">
            <h1>
                {{ __('context_content_home') }}
            </h1>
        </div>
    </div>
    <div class="row">
        @if (!empty($dataContext))
            @foreach ($dataContext as $contextItem)
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="state__wrapper">
                        <img src="{{ url('images/pages/'.$contextItem['image']) }}" alt="status" class="img-fluid">
                        <div class="overlay"></div>
                        <div class="status__content">
                            <h2 class="status__heading">
                                {{ $contextItem['heading'] ?? '' }}
                            </h2>
                            <button class="btn btn__custom">
                                {{ $contextItem['button'] ?? '' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div> --}}

<div class="fill__wrapper mt-5 common__slider common__background-field">
    <div class="container">
        <div class="content__common">
            <div class="content__heading text-center">
                <h2 style="color: #fff">
                    {{ __('fill_content_home') }}
                </h2>
            </div>
            <div class="content__fill-list mb-5">
                @if (!empty($dataFillContent))
                    @foreach ($dataFillContent as $fillItem)
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


{{-- <div class="container success">
    <div class="content__common">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 mt-5">
                <div class="content__heading text-center">
                    <h1>
                        {{ __('provide_heading_home') }}
                    </h1>
                    <p class="content__title-c">
                        {{ __('provide_title_home') }}
                    </p>
                </div>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="content__provide-list">
                    @foreach ($dataProvide as $provideItem)
                        <div class="content__provide-item">
                            <div class="content__provide">
                                <h3 class="content__provide-title">
                                    {{ $provideItem['heading'] ?? '' }}
                                </h3>

                                <img src="{{ url('images/pages/'.$provideItem['image']) }}" class="img-fluid content__provide-img" alt="">

                                <div class="content__provide-context">
                                    <p>
                                        {{ $provideItem['title'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}


</div>


<div class="container news container__common">
    <div class="content__common">
        <div class="content__heading text-center">
            <h2>
                {{ __('new_now') }}
            </h2>
        </div>
    </div>

    <div class="row">
        @if (!empty($dataNew))
            @foreach ($dataNew as $itemNews)
            <div class="col-sm-12 col-md-6 col-lg-4 new__items mb-4">
                <a href="{{ route('news.detail', ['id'=>$itemNews['id'] ?? '', 'slug' => $itemNews['slug'] ?? '']) }}">
                    <div class="new__wrapper">
                        <div class="new_img">
                            @php
                                $image = $itemNews['image']?? '';
                            @endphp
                            <img src="{{ url('images/news/'.$itemNews['image']) }}" alt="" class="img-fluid">
                        </div>
                        <div class="news__content">
                            <p class="new__heading two-line-paragraph">
                                {{ $itemNews['heading'] }}
                            </p>
                            <button class="btn btn__news mt-3">
                                Read the report
                            </button>
                        </div>
                    </div>
                </a>

            </div>
            @endforeach
        @endif
    </div>
</div>


<div class="container programming-language mb-5">
    <div class="row">
        <div class=" col-md-12 col-lg-6">
            <div class="content__common">
                <div class="heading__subtitle">
                    {{ __('heading__subtitle') }}
                </div>
                <div class="content__heading programming-language-heading">
                    <h2>{{ __('programming_language_heading_home') }}</h2>
                    <p class="content__title my-4">
                        {{ __('programming_language_title_home') }}
                    </p>
                </div>
                <a href = "#" class="btn btn__custom-h">
                    <i class="fa-solid fa-gears"></i>
                    {{ __('button_programming_home') }}
                </a>
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <div class="content__common">
                @if (!empty($dataProgramming))
                <div class="programming-accordion accordion"  id="accordionExample">
                @foreach ($dataProgramming as $key => $programmingItem)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ 'heading-'.$key }}">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{ '#collapse-'.$key }}"  aria-controls="{{ 'collapse-'.$key }}">
                                {{ $programmingItem['heading'] ?? '' }}
                              </button>
                            </h2>
                            <div id="{{ 'collapse-'.$key }}" class="accordion-collapse collapse show" aria-labelledby="{{ 'heading-'.$key }}" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                {{ $programmingItem['title'] ?? '' }}
                              </div>
                            </div>
                          </div>
                          @endforeach
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>




@if (!empty($dataConsultation))
    <div class="container-fluid consultation px-0">
        <img src="{{ url('/images/pages/'.$dataConsultation['image']) }}" class="cosultation_img" alt="">
        <div class="consultation__wrapper">
            <div class="container text-center">
                <span class="consultation__comment">
                    {{ __('consultation_comment_home') }}
                </span>
                <p class="cosultation__heading">
                    {{ $dataConsultation['heading'] }}
                </p>
                <a href="/contact-us" class="btn btn__custom-h">
                    {{ $dataConsultation['button'] }}
                </a>
            </div>
        </div>
    </div>
@endif


@endsection

@section('script')
    
    <script type="text/javascript">
        $(document).ready( function () {
            $numend = Number($('.num.client').text());


            $('.num').counterUp({
                delay: 20,
                time: 600
            });
            $('.num').addClass('animated fadeInDownBig');
        });
    </script>
@endsection
