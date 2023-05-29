@extends('main')
@section('banner')
    <div class="banner__concat container-fluid px-0">
        <img src="{{ url('/images/banner.jpg') }}" alt="banner" class="img-fluid">
        <div class="overlay"></div>
        <div class="banner__content">
            News details
        </div>
    </div>
@endsection
@section('content')
    @if (!empty($onlyDataNew))
    <div class="container my-5">
        <div class="news-detail">
            <h2 class="news-heading">
                {{ $onlyDataNew['heading'] ?? '' }}
            </h2>
            <div class="news-title">
                {{ $onlyDataNew['title'] ?? '' }}
            </div>
            <div class="news-content">
                {!! $onlyDataNew['description'] ?? '' !!}
            </div>
        </div>
        <div class="news-orther mt-4">
            <h3> Tin tức khác </h3>
            <div class="slide-news common__slider mt-5">
                @if (!empty($dataOrtheNews) && is_array($dataOrtheNews))
                    @foreach ($dataOrtheNews as $itemOtherNews)
                    <a 
                     href="{{ route('news.detail', ['id'=>$itemOtherNews['id'] ?? 'm', 'slug' => $itemOtherNews['slug'] ?? 'm']) }}"
                    >
                        <div class="slide-news-item">
                            <div class="slide__new-img">
                                @php
                                    $imageOrtherNews = $itemOtherNews['image'] ?? '';
                                @endphp
                                <img src='{{ url("images/news/$imageOrtherNews") }}' alt="" class="img-fluid">
                            </div>
                            <div class="slide__new-content">
                                <div class="slide__new-heading two-line-paragraph">
                                    {{ $itemOtherNews['heading'] ?? '' }} 
                                </div>
                                <p class="slide__new-time">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{  $itemOtherNews['time_display'] ?\Carbon\Carbon::parse($itemOtherNews['time_display'])->format('d-m-Y') : '' }} 
                                </p>
                                <p class="two-line-paragraph-s">
                                    {{ $itemOtherNews['title'] ?? '' }} 
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                @else 
                    <div class="text-center">
                        <p>Hiện không có tin tức khác</p>
                    </div>

                @endif
            </div>
        </div>
    </div>

    
        
    @endif
    
    
@endsection