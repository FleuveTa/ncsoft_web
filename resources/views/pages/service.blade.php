@extends('main')
@if (!empty($data))
@section('banner')
<div class="banner__serve container-fluid px-0" >

    @if (!empty($data['banner_service']))
        <img src="{{ url('images/pages/'.$data['banner_service']['image']) }}" alt="banner" class="img-fluid service__background-banner">
    @endif

    <div class="overlay"></div>

    <div class="service__content">
        <div class="container" >
            <div class="row">
                @if (!empty($data['banner_content_service']))
                    <div class="col-sm-12 col-md-12 col-lg-6 service__content-left">
                            <div class="service__left-content">
                                <span class="comment_banner">
                                    {{ __('comment_banner_service') }}
                                </span>
                                <h1>
                                    {{ $data['banner_content_service']['heading'] }}
                                </h1>
                                <p>
                                    {{ $data['banner_content_service']['description'] }}
                                </p>
                                <div class="service__button-video">

                                    <div class="btn__video-group">
                                        <div class="btn__inner">
                                            <button
                                                data-bs-toggle="modal"
                                                data-src="https://www.youtube.com/embed/NFWSFbqL0A0" 
                                                class="btn__play-video"
                                                data-bs-target="#myModal"
                                            >
                                                <i class="fa-solid fa-play"></i>
                                                <span class="circle-1"></span>
                                                <span class="circle-2"></span>
                                            </button>
                                        </div>

                                        <span class="btn__video-text">
                                            {{ $data['banner_content_service']['button'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        
                        
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__right-content">
                            @if (!empty($data['banner_content_service']['image']))
                                <img src="{{ url('images/pages/'.$data['banner_content_service']['image']) }}" alt=""  class="img-fluid">
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="service__box-banner">
        <div class="service__box-wrapper">
            @if (!empty($data['banner_box_item']))
            <div class="service__box-list">
                @foreach ($data['banner_box_item'] as $key => $itemBox)
                        <a href="#{{ $boxService[$key] ?? '' }}">
                            <div class="service__box-item">
                                <h2 class="box__item-heading two-line-paragraph-xl">
                                    {{ $itemBox['heading'] }}
                                </h2>
    
                                <div class="box__item-icon">
                                    {!! $itemBox['icon'] !!}
                                </div>
                                <div class="box__item-circle"></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('content')
<div id="service">
    <div class="container-fluid px-0" id="service__intro">
        @if (!empty($data['intro_service']))
            <div class="service_intro-background" 
                style="
                background-image: url('{{ 'images/pages/'. $data['intro_service']['image'] }}');
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                "
            >
                <div class="overlay"></div>
                <div class="service__intro-content" >
                    <div class="container">
                        <p class="service__intro-heading">
                            {{ $data['intro_service']['heading'] }}
                        </p>
                        <div class="service__intro-description">
                            {{ $data['intro_service']['description'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
    </div>

    @if (!empty($data['content_first_service']))
        <div class="service__common" id="box-technology">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-img service__one-img">
                            <img src="{{ url('/images/pages/'.$data['content_first_service']['image']) }}" alt="service" class="img-fluid">

                            <div class="service__common-heading service__one-heading">
                                {{ $data['content_first_service']['heading'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-content service__one-content">
                            <div class="service__common-count service__one-count">
                                {{ __('first_number_service') }}
                            </div>
                            <div class="service__common-title service__one-title">
                                {{ $data['content_first_service']['title'] }}
                            </div>

                            <div class="service__common-description service__one-description">
                                {{ $data['content_first_service']['description']  }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    @endif

   
    @if (!empty($data['content_second_service']))
        <div class="service__common" id="box-software">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-content service__one-content">
                            <div class="service__common-count service__one-count">
                                {{ __('second_number_service') }}
                            </div>

                            <div class="service__common-title service__one-title">
                                {{ $data['content_second_service']['title'] }}
                            </div>

                            <div class="service__common-description service__one-description">
                                {{ $data['content_first_service']['description']  }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-img service__one-img">
                            <img src="{{ url('/images/pages/'.$data['content_second_service']['image']) }}" alt="service" class="img-fluid">
                            <div class="service__common-heading service__one-heading">
                                {{ $data['content_second_service']['heading'] }}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div> 
    @endif

    @if (!empty($data['content_third_service']))
        <div class="service__common" id="box-web">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-img service__one-img">
                            <img src="{{ url('/images/pages/'.$data['content_first_service']['image']) }}" alt="service" class="img-fluid">

                            <div class="service__common-heading service__one-heading">
                                {{ $data['content_first_service']['heading'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="service__common-content service__one-content">
                            <div class="service__common-count service__one-count">
                                {{ __('third_number_service') }}
                            </div>
                            <div class="service__common-title service__one-title">
                                {{ $data['content_third_service']['title'] }}
                            </div>

                            <div class="service__common-description service__one-description">
                                {{ $data['content_third_service']['description']  }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    @endif


    @if (!empty($data['consultation_service']))
        <div class="container-fluid consultation px-0">
            <img src="{{ url('/images/pages/'.$data['consultation_service']['image']) }}" class="cosultation_img" alt="">
            <div class="consultation__wrapper">
                <div class="container text-center">
                    <span class="consultation__comment">
                        {{ __('consultation_comment_service') }}
                    </span>
                    <p class="cosultation__heading">
                        {{ $data['consultation_service']['heading'] }}
                    </p>
                    <a href="/contact-us" class="btn btn__custom-h">
                        {{ $data['consultation_service']['button'] }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal video --}}

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
        
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9 modal__video-wrapper">
                        <iframe class="embed-responsive-item modal__video-src" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>    


</div> 

  

  
@endsection
@endif


@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $videoSrc="";
            $('.btn__play-video').click(function () {
                $videoSrc = $(this).data( "src" );
            });


            if($videoSrc !== "") {
                $('#myModal').on('shown.bs.modal', function (e) {
                
                // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
                $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
                
                })
                
                
                
                // stop playing the youtube video when I close the modal
                $('#myModal').on('hide.bs.modal', function (e) {
                    // a poor man's stop video
                    $("#video").attr('src',$videoSrc); 
                })
            }
             
        })
    </script>
@endsection