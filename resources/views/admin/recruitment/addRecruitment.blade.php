@extends('admin/main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.recruiment') }}">Manager recruiment</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add recruiment</li>
        </ol>
    </nav>

    <h2>Add New Recruitment</h2>
    
    <p>Create a brand new Recruitment and add them to this site.</p>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('admin.addRecruitment') }}" method="POST" enctype="multipart/form-data" id="form-add-recruitment">

        @csrf
    
        <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">
    
        <div class="row">
            <div class="form-group col-md-6">
                <label for="heading_vn">Heading VN:</label>
                <input type="text" class="form-control" name="heading_vn" id="heading_vn" placeholder="Heading Banner Vn">
                <span class="text-danger error-text heading_vn_error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="heading_en">Heading EN:</label>
                <input type="text" class="form-control" name="heading_en" id="heading_en" placeholder="Heading Banner En">
                <span class="text-danger error-text heading_en_error"></span>

            </div>

            <div class="form-group">
                <label for="description_vn">Description VN</label>
                <textarea type="text" class="form-control" name="description_vn" id="description_vn"></textarea>
                <span class="text-danger error-text description_vn_error"></span>
            </div>
        
            <div class="form-group">
                <label for="description_en">Description EN</label>
                <textarea type="description_en" class="form-control" name="description_en" id="description_en" ></textarea>
                <span class="text-danger error-text description_en_error"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="slug">slug:</label>
                <input type="text" class="form-control" name="slug" id="slug" placeholder="slug">
                <span class="text-danger error-text slug_error"></span>

            </div>
        
            <div class="form-group col-md-4">
                <label for="number_of_people">Number Of People</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="number_of_people" 
                    id="number_of_people" 
                    placeholder="Number Of people"
                >
                <span class="text-danger error-text number_of_people_error"></span>
            </div>
        
            <div class="form-group col-md-4">
                <label for="salary">Salary</label>
                <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary">
                <span class="text-danger error-text salary_error"></span>
            </div>
            
            <div class="form-group col-md-6">
                <label for="timeout">Time Out:<span class="field__require">*</span>:</label>
                <input type="text" class="form-control" id="timeout" name="timeout" placeholder="Date time out">
                <span class="text-danger error-text timeout_error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="time_display">Time Display:<span class="field__require">*</span>:</label>
                <input type="text" class="form-control" id="time_display" name="time_display" placeholder="Date Time display">
            </div>

        </div>

        <button type="submit" class="btn btn__add btn__add-user">Add New Recruitment</button>

    </form>

@endsection

@section('script')
    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript"> 
        $(document).ready(function () {

            $( "#time_display" ).datepicker();
            $( "#timeout" ).datepicker();

        ClassicEditor
            .create(document.querySelector( '#description_vn' ),{
                ckfinder: {
                    uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                }
            })
            .catch( error => {
                console.error( error );
            }); 


        ClassicEditor
            .create(document.querySelector( '#description_en' ),{
                ckfinder: {
                    uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                }
            })
            .catch( error => {
                console.error( error );
            });
        });
    
    </script>
    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#form-add-recruitment', function (e) {
                e.preventDefault();
                $url = $(this).attr('action');
                Swal.fire({
                    title: 'do you want create new recruitment?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Create',
                denyButtonText: `Don't create`,
                }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                        url: $url,
                        data: $('form').serialize(),
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
                                    $('#form-add-recruitment')[0].reset();
                                }
                                if(data.status == 1) {
                                    Swal.fire(
                                    'fail!',
                                    data.message,
                                    'error'
                                    )
                                }
                            }
                        },
                        error: function (error){
                            $status = error['responseJSON']['status'] ?? '';
                            $message = error['responseJSON']['message'] ?? ''
                            if($status == 4 || $status == 3){
                                Swal.fire(
                                    'Deleted!',
                                    $message,
                                    'error'
                                )
                            }
                        }
                    });

                } else if (result.isDenied) {

                    Swal.fire('New creation failed', '', 'info')
                }
                })
            });
        });
    </script>
@endsection