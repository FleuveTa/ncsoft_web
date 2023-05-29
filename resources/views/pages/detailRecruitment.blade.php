@extends('main')
@section('banner')
    <div class="banner__concat container-fluid px-0">
        <img src="{{ url('/images/banner.jpg') }}" alt="banner" class="img-fluid">
        <div class="overlay"></div>
        <div class="banner__content">
            recruitment details
        </div>
    </div>
@endsection
@section('content')
    @if (!empty($dataRecruitmentDetail))
    <div class="container my-5">
        <div class="row">
            {{-- Detail Recruiment --}}
            <div class="col-sm-12 col-md-8 mb-4 recruitment-wrapper">
                <div class="detail-recruitment">
                    <h1 class="recruiment__detail-heading">
                        {{ $dataRecruitmentDetail['heading'] ?? ''}}
                    </h1>
                    <div class="recruiment__detail-content">
                        {!! $dataRecruitmentDetail['description'] ?? "" !!}
                    </div>
                </div>

                <button  type="button" class="btn btn__apply" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Apply now
                </button>


            </div>

            <div class="col-sm-12 col-md-4 ">
                <div class="recruitment-wrapper">
                    <div class="detail-recruitment">
                        <h2 class="recruiment__detail-heading">
                            Thông tin công việc
                        </h2>
                        <div class="recruiment__detail-item">
                            <div class="mb-3">
                                <strong>Mức lương: </strong>
                                {{  $dataRecruitmentDetail['salary'] ?? ''  }}
                            </div>
                            <div class="mb-3">
                                <strong>Địa điểm: </strong>
                                Hà nội
                            </div>
                            <div class="mb-3">
                                <strong>Hình thức làm việc: </strong>
                                Toàn thời gian
                            </div>
                            <div class="mb-3">
                                <strong>Cấp bậc: </strong>
                                {{  $dataRecruitmentDetail['heading'] ?? ''  }}
                            </div>
                        </div>
                        <button  type="button" class="btn btn__apply" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Apply now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- FORM apply --}}
        <form
            action="{{ route('recruitment.sendMail', ['id' => $dataRecruitmentDetail['id']]) }}"
            method="POST"
            enctype="multipart/form-data"
            id="form-recruitment-mail"
        >
            @csrf
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content col-md-6">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Apply directly</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nominee" class="form-label">nominee</label>
                                        <input
                                            type="text"
                                            class="form-control modal-input"
                                            id="nominee"
                                            placeholder="nominee"
                                            name="heading"
                                            value="{{ $dataRecruitmentDetail['heading'] ?? ''}}"
                                            readonly
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="1" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check mx-2 ">
                                                <input class="form-check-input" type="radio" name="gender" value="2" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                female
                                                </label>
                                            </div>
                                        </div>
                                        <label for="exampleFormControlInput1" class="form-label">first name & last name</label>
                                        <input type="text" class="form-control modal-input" id="exampleFormControlInput1" name="name" placeholder="Example: Nguyen Tien Anh">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control modal-input" id="email" name="email" placeholder="nominee">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone-number" class="form-label">Phone number</label>
                                        <input type="text" class="form-control modal-input" name="phonenumber" id="phone-number" placeholder="nominee">
                                        <span class="text-danger error-text phonenumber_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Default file input example</label>
                                        <input class="form-control modal-input" type="file" name="fileMail"  id="formFile">
                                        <span class="text-danger error-text fileMail_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                                        <textarea class="form-control modal-input" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>

                                </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn__apply">Send</button>
                            </div>
                        </div>
                </div>
            </div>
        </form>
    @endif


@endsection
@section('script')
    <script type="text/javascript">

        $(document).on('submit', '#form-recruitment-mail', function (e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('form-recruitment-mail'));

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
                            if(data.status == 3) {
                                $.each(data.error, function (prefix, val)  {
                                    $('span.'+prefix+'_error').text(val[0]);
                                })
                            }
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
