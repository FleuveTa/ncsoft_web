{{-- <footer id="footer" class="footer container-fluid">
    <div class="container">
        <h2 class="footer__heading">{{ __('about') ?? ''}}</h2>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-5  mb-5">
                <div class="footer__item">
                    <p class="footer__item-content"><strong>{{ __('address') }}:</strong>{{ __('address_detail_footer') }}</p>
                </div>
                <div class="footer__item">
                    <p class="footer__item-content"><strong>{{ __('holine') }}:</strong> {{ __('hotline_detail_footer') }}</p>
                </div>
                <div class="footer__item">
                    <p class="footer__item-content"><strong>{{ __('email') }}:</strong>{{ __('email_detail_footer') }}</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 mb-5">
                <a href="#" class="footer__link-item">
                    <span class="footer__text">{{ __('service_text_footer') }}</span>
                </a>
                <a href="#" class="footer__link-item">
                    <span class="footer__text">{{ __('method_text_footer') }} </span>
                </a>
                <a href="#" class="footer__link-item">
                    <span class="footer__text">{{ __('field_text_footer') }}</span>
                </a>
                <a href="#" class="footer__link-item">
                    <span class="footer__text">{{ __('study_text_footer') }}</span>
                </a>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3 mb-5">
                @php
                    $dataCategory = Helper::getCategoryHeader();
                @endphp
                @if (!empty($dataCategory))
                    @foreach ($dataCategory as $categoryItem)
                        <a href="/{{ $categoryItem['slug'] ?? '/' }}" class="footer__link-item">
                            <span class="footer__text">
                                {{ $categoryItem['name']}}
                            </span>
                        </a>


                    @endforeach
                @endif
            </div>
        </div>
        <div class="footer__end">
            <p class="footer__end-text text-center">
                {{ __('license-footer') }}
            </p>
        </div>
    </div>
</footer> --}}

<footer id = "footer" class="footer container-fluid common__background-field">
    <div class="container text-center">
        <div class="footer__logo">
            <a class="footer__logo-link" href="{{ route('home') }}">
                <img src="{{ url('images/logo_primary.png') }}" class="img-fluid" alt="">
            </a>
        </div>

        <div class="footer__info">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="footer__info-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="footer__info-text">
                            {{ __('address_detail_footer') }}
                        </p>
                        <p class="footer__info-subtext">
                            {{ __('address') }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="footer__info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <p class="footer__info-text">
                            {{ __('email_detail_footer') }}
                        </p>
                        <p class="footer__info-subtext">
                            {{ __('email') }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="footer__info-item">
                        <i class="fa-solid fa-phone-volume"></i>
                        <p class="footer__info-text">
                            {{ __('hotline_detail_footer') }}
                        </p>
                        <p class="footer__info-subtext">
                            {{ __('holine') }}
                        </p>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="footer__nav">
            <ul class="footer__nav-list">
                @php
                    $dataCategory = Helper::getCategoryHeader();
                @endphp

                @foreach ($dataCategory as $categoryItem)
                    <li class="footer__nav-item">
                        <a href="/{{ $categoryItem['slug'] ?? '/' }}">
                            <span class="footer__nav-item-text">{{ $categoryItem['name']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="footer__end-text">
            {{ __('license-footer') }}
        </div>

        <div class="footer__social-network">
            <!-- <div class="footer__social-network-item">
                <a href="#">
                    <i class="fa-brands fa-twitter social-network-twitter"></i>
                </a>
            </div> -->
            <div class="footer__social-network-item">
                <a target="_blank" href="https://www.facebook.com/NCsoftJSC">
                    <i class="fa-brands fa-facebook-f social-network-facebook"></i>
                </a>
            </div>
            <!-- <div class="footer__social-network-item " >
                <a href="#">
                    <i class="fa-brands fa-instagram social-network-instagram"></i>
                </a>
            </div> -->
            <div class="footer__social-network-item">
                <a href="#">
                    <i class="fa-brands fa-invision social-network-invision"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
