@extends('admin/main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Manager News</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add News</li>
        </ol>
    </nav>

    <h2>Add News</h2>

    <p>Create a brand news and add them to this site.</p>
    
    <form action="" method="POST" enctype="multipart/form-data" id="form-add-news">

        @csrf
    
        <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">
    
        <div class="row">
            <div class="form-group col-md-6">
                <label for="heading_vn">Heading VN:</label>
                <input type="text" class="form-control" name="heading_vn" id="heading_vn" placeholder="Title Banner Vn">
                <span class="text-danger error-text heading_vn_error"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="heading_en">Heading EN:</label>
                <input type="text" class="form-control" name="heading_en" id="heading_en" placeholder="Title Banner En">
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
                <input type="text" class="form-control" name="slug" id="slug" placeholder="Title Banner En">
            </div>
        
            <div class="form-group col-md-4">
                <label for="title_vn">Title VN</label>
                <input type="text" class="form-control" name="title_vn" id="title_vn" placeholder="Title Button VN">
                <span class="text-danger error-text title_vn_error"></span>
            </div>
        
            <div class="form-group col-md-4">
                <label for="title_en">Title EN</label>
                <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title Button EN">
                <span class="text-danger error-text title_en_error"></span>
            </div>
        
            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
                <input class="form-control" type="file" name="image" id="formFile">
                <span class="text-danger error-text image_error"></span>
            </div>
            
            
            <div class="form-group col-md-6">
                <label for="order">Time Display:<span class="field__require">*</span>:</label>
                <input type="text" class="form-control" id="time_display" name="time_display">
                <span></span>
            </div>

        </div>

        <button type="submit" class="btn btn__add btn__add-user">Add New Banner</button>

    </form>

@endsection

@section('script')
    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript"> 
        $(document).ready(function () {
            $( "#time_display" ).datepicker();

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


        $(function () {
            $(document).on('submit', '#form-add-news', function (e) {

                e.preventDefault();
                const formData = new FormData(document.getElementById('form-add-news'));

                $url = $(this).attr('action');

                Swal.fire({
                title: 'do you want create new user?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Create',
                denyButtonText: `Don't create`,
                }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
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
                                    $('#form-add-news')[0].reset();

                                }
                                if(data.status == 1) {
                                    Swal.fire(
                                        'fail!',
                                        data.message,
                                        'error'
                                    );
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