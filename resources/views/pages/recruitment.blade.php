@extends('main')
@section('banner')
        @if (!empty($bannerPage))
        <div class="banner__concat container-fluid px-0">
            <img src="{{ url('/images/pages/'.$bannerPage['image']) }}" alt="banner" class="img-fluid">
            <div class="overlay"></div>
            <div class="banner__content">
                {{ $bannerPage['heading'] ?? ''}}
            </div>
        </div>
        @endif
@endsection
@section('content')
    <div class="recruitment">
        <div class="recruitment__vantacy content__common">
            <div class="vacacy__heading content__heading text-center">
                <h1>{{ __('heading_recruitment') }} <span class="vacacy__hot">Hot</span></h1>
                <p class="content_z_title">
                    {{ __('title_recruitment') }}
                </p>
            </div>
            <div class="container">
                <div class="vacavy__list my-5">
                    <div class="row my-5">
                        @if (empty($dataRecruitments['data']) && is_array($dataRecruitments['data']))

                            @foreach ($dataRecruitments['data'] as $itemRecruitment)

                                <div class="col-sm-12 col-md-4 col-lg-4 my-4">
                                    <a href="{{ route('recruitment.detail', ['id'=>$itemRecruitment['id'] ?? '','recruitment'=>$itemRecruitment['slug'] ?? '']) }}" class="vacacy__item-link">
                                        <div class="vacacy__items">
                                            <h3 class="vacacy__item-heading">
                                               {{ $itemRecruitment['heading'] ?? '' }}
                                            </h3>
                                            <div class="vacacy__item-content">
        
                                                <div class="vacacy__item-crave">
                                                    <i class="fa-sharp fa-solid fa-location-dot"></i>
                                                    <span class="vacacy__item-text">Address:</span>
                                                    <span class="vacacy__item-sub">Ha Noi</span>
                                                </div>
        
                                                <div class="vacacy__item-crave">
                                                    <i class="fa-solid fa-dollar-sign"></i>
                                                    <span class="vacacy__item-text">Salary:</span>
                                                    <span class="vacacy__item-sub">
                                                        {{ $itemRecruitment['salary'] ?? '' }}
                                                    </span>
                                                </div>
        
                                                <div class="vacacy__item-crave">
                                                    <i class="fa-sharp fa-regular fa-calendar-days"></i>
                                                    <span class="vacacy__item-text">time:</span>
                                                    <span class="vacacy__item-sub">
                                                        {{  $itemRecruitment['timeout'] ?\Carbon\Carbon::parse($itemRecruitment['timeout'])->format('d-m-Y') : '' }}
                                                    </span>
                                                </div>
                                                
                                            </div>
                                            <button class="btn btn__custom-s">see more</button>
                                        </div>
                                    </a>
                                </div>

                            @endforeach

                        @else 

                                <h3 class="common__not-info">
                                    {{ __('common_no_info_recruitment') }}
                                </h3>

                        @endif
                    </div>

                    <div class="vacavy__pagination">
                        <ul class="pagination-list d-flex align-items-center justify-content-center">
                            {{-- <a href="#">
                                <i class="pagination-item fa-sharp fa-solid fa-left-long"></i>
                            </a> --}}    
                            @if ($dataRecruitments && !empty($dataRecruitments['last_page']) && $dataRecruitments['last_page'] > 1)
                            @for($i = 1 ; $i <= $dataRecruitments['last_page'] ; $i++)
                                    <a href="{{ route('recruitment.paginate', ['page' => $i]) }}">
                                        <li class="pagination-item mx-2 {{ $dataRecruitments['current_page'] == $i ? 'active' :'' }}">
                                            {{ $i }}
                                        </li>
                                    </a>
                                @endfor
                            @endif
                            {{-- <a href="#">
                                <i class="pagination-item fa-solid fa-right-long"></i>
                            </a> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection