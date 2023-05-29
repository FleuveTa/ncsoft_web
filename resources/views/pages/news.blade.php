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
@if (!empty($dataNews) && !empty($dataNews['data']))
    <div class="container">
        <div class="news">
            <div class="news-list">
                @foreach ($dataNews['data'] as $newItem)
                        <a href="{{ route('news.detail', ['id'=>$newItem['id'] ?? '', 'slug' => $newItem['slug'] ?? '']) }}" class="news-link">
                            <div class="news-item row my-5">
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="news-img">
                                    @php
                                        $newImage = $newItem['image'] ?? '';
                                    @endphp
                                        <img src='{{ url("images/news/$newImage") }}' class="img-fluid" alt="news-image">
                                </div>
                                </div>
                                <div class="col-sm-6 col-md-8 col-lg-9">
                                    <div class="news-content">
                                        <h3 class="three-line-paragraph"> 
                                            {{ $newItem['heading'] ?? '' }}
                                        </h3>
                                        <p class="news-time">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            {{  $newItem['time_display'] ?\Carbon\Carbon::parse($newItem['time_display'])->format('d-m-Y') : '' }} 
                                        </p>
                                        <p class="five-line-paragraph">
                                            {{ $newItem['title'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                    @endforeach
                
            </div>

            <div class="news__pagination">
                <ul class="pagination-list d-flex align-items-center justify-content-center">
                    {{-- <a href="#">
                        <i class="pagination-item fa-sharp fa-solid fa-left-long"></i>
                    </a> --}}    
                    @if ($dataNews && !empty($dataNews['last_page']) && $dataNews['last_page'] > 0)
                        @for($i = 1 ; $i <= $dataNews['last_page'] ; $i++)
                            <a href="{{ route('news.paginate', ['page' => $i]) }}">
                                <li class="pagination-item mx-2 {{ $dataNews['current_page'] == $i ? 'active' :'' }}">
                                    {{ $i }}
                                </li>
                            </a>
                        @endfor
                    @else
                            <p></p>
                    @endif
                    {{-- <a href="#">
                        <i class="pagination-item fa-solid fa-right-long"></i>
                    </a> --}}
                </ul>
            </div>
        </div>
    </div>
@else 
    <h3 class="common__not-info">
        {{ __('common_no_info_news') }}
    </h3>
@endif
@endsection