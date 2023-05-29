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
   <div class="concat__content">
        <div class="concat container">
            <div class="row ">
                <div class="col-sm-12 col-md-12 col-lg-6 p-5">
                    <h2>
                        {{ __('send_info') ?? ''}}
                    </h2>
                    <p>
                        {{ __('contact_title-1') ?? ''}}
                    </p>
                    <p class="mb-3">
                        {{ __('contact_title-2') ?? ''}}
                    </p>
                    <form action="{{ route('sendMail') }}" method="POST" id="form-mail-concat">
                        @csrf
                        <div class="mb-3">
                            <input
                                type="text"
                                class="form-control concat__input-text"
                                name="fullname"
                                id="fullname"
                                placeholder="FullName"
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <input
                                type="text"
                                class="form-control concat__input-text"
                                name="phonenumber"
                                id="phonenumber"
                                placeholder="phone number"
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <input
                                type="email"
                                class="form-control concat__input-text"
                                name="email"
                                id="exampleFormControlInput1"
                                placeholder="name@example.com"
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <textarea
                                class="form-control concat__input-text"
                                id="content"
                                name="content"
                                rows="4"
                                placeholder="Content Email"
                                required
                            ></textarea>
                        </div>

                        <button  type="submit" class="btn btn__send-email">
                            Send Email
                        </button>
                    </form>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 px-0">
                    <div class="concat__info p-5" style="background-image: url('{{ url('images/concat.jpg') }}')">
                        {{-- <img src="{{ url('images/concat.jpg') }}" class="img-fluid concat__img" alt="concat"> --}}
                        <div class="concat__info-context">
                            <h2 class="">
                                {{ __('contact_info') }}
                            </h2>
                        </div>
                        <div class="concat__link">
                            <i class="fa-solid fa-phone"></i>
                            <p>
                                (+84) 2873 040 030
                            </p>
                        </div>
                        <div class="concat__link">
                            <i class="fa-solid fa-envelope"></i>
                            <p>
                                ncsoft@gmail.com
                            </p>
                        </div>
                        <div class="concat__link">
                            <i class="fa-solid fa-location-dot"></i>
                            <p>
                                Hancorp Plaza, 72 Trần Đăng Ninh, Dịch Vọng, Cầu Giấy
                            </p>
                        </div>
                        <div class="concat__link">
                            <i class="fa-solid fa-phone"></i>
                            <p>
                                Thứ 2 – Thứ 6,
                                Từ 8 giờ 30p sáng tới 5 giờ 30p chiều.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid px-0">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.
                85975630273!2d105.79188171476343!3d21.038296785993232!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.
                1!3m3!1m2!1s0x3135ab37899543c9%3A0x808b1dc5673ddb70!
                2sChung%20c%C6%B0%20Hancorp%20Plaza!5e0!3m2!1svi!2s!4v1680424598180!5m2!1svi!2s"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            >
            </iframe>
        </div>
   </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('submit', '#form-mail-concat', function (e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('form-mail-concat'));

            $url = $(this).attr('action');


            Swal.fire({
                title: 'Do you want to send mail?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'send',
                denyButtonText: `Don't send`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    url: $url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data){
                        if(data){
                            if(data.status == 0) {
                                Swal.fire(
                                    'success!',
                                    data.message,
                                    'success'
                                );
                            }

                        }
                    },
                    error: function (error){
                        $status = error['responseJSON']['status'] ?? '';
                        $message = error['responseJSON']['message'] ?? ''
                        if($status == 3){
                            Swal.fire(
                                'Deleted!',
                                $message,
                                'error'
                            )
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
            })
        });
    </script>
@endsection

