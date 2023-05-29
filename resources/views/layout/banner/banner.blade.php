<section class="banner common__slider container-fluid px-0">
    @php
        $dataBanner = Helper::getDatabanner();
    @endphp
    @if (!empty($dataBanner))
        @foreach ($dataBanner as $bannerItem)
            <div class="banner__wrapper">
                @php
                    $imageBanner = $bannerItem['image'] ?? '';
                @endphp
                <img src='{{ url("images/banners/$imageBanner") }}' alt="" class="img-fluid" >
                <div class="overlay"></div>
                <div class="banner__content">
                    <div class="container">
                        <div class="banner__content-item">
                            <h1>
                                {{ $bannerItem['title'] ?? ''}}
                            </h1>

                            <p>
                                {{ $bannerItem['description'] ?? ''}}
                            </p>

                            <a class="btn btn__custom" href="{{ route('about-us') }}">
                                {{ $bannerItem['button_name'] ?? ''}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
     
</section>