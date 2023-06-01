
<header id="header" class="header__border">
    <div class="container">
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
              <a class="navbar-brand logo-link" href="{{ route('home') }}">
                <img src="{{ url('images/logo_primary.png') }}" class="img-fluid" alt="">
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                {{-- <span class="navbar-toggler-icon"></span> --}}
                <i class="fa-solid fa-bars navbar-icon-mb"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  @php
                      $dataCategory = Helper::getCategoryHeader();
                  @endphp
                  @if (!empty($dataCategory))
                    @foreach ($dataCategory as $categoryItem)
                    <li class="nav-item">
                      <a 
                        class="nav-link {{ request()->is($categoryItem['slug'] ??'') ? 'active' : '' }}" 
                        aria-current="page" 
                        href="/{{ $categoryItem['slug'] ?? '/' }}"
                      >
                       {{ $categoryItem['name']}}
                      </a>
                        
                   </li>
                    @endforeach
                  @endif
                </ul>
                <div class="ms-auto d-lg-flex align-items-center">
                  <a class="navbar-nav mx-2" href="{{ route('concat') }}">
                    <button class="btn btn__talk">{{ __('let_talk') ?? ''}}</button>
                  </a>
                  <div class="dropdown language">
                    <button class="btn  dropdown-toggle language__show" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      @if (Helper::getLocalization() == 'vn')
                        <img src="{{ url('images/vietnam.png') }}" class="img-fluid img-language" alt="">
                      @else
                        <img src="{{ url('images/america.png') }}" class="img-fluid img-language" alt="">

                      @endif
                    </button>
                    <ul class="dropdown-menu language__list" aria-labelledby="dropdownMenuButton1">
                      <li class="language__item text-center">
                        <a class="dropdown-item" href="{!! route('change-language', ['vn']) !!}">
                          <img src="{{ url('images/vietnam.png') }}" class="img-fluid language-img-item" alt="">
                        </a>
                      </li>
                      <li class="language__item text-center">
                        <a class="dropdown-item" href="{!! route('change-language', ['en']) !!}">
                          <img src="{{ url('images/america.png') }}" class="img-fluid language-img-item" alt="">
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </nav>
    </div>
</header>