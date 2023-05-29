@extends('admin/main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.banner') }}">Manager Banner</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add banner</li>
    </ol>
</nav>

<h2>Add New Banner</h2>
<p>Create a brand new banner and add them to this site.</p>

<form action="{{ route('admin.addBanner') }}" method="POST" enctype="multipart/form-data" id="form-banner-add">
    @csrf

    <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

<div class="row">
    <div class="form-group col-md-6">
        <label for="title_vn">Title VN:</label>
        <input type="text" class="form-control" name="title_vn" id="title_vn" placeholder="Title Banner Vn">
        <span class="text-danger error-text title_vn_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="title_en">Title EN:</label>
        <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title Banner En">
        <span class="text-danger error-text title_en_error"></span>
    </div>
    <div class="form-group">
        <label for="description_vn">Description VN</label>
        <input type="description_vn" class="form-control" name="description_vn" id="description_vn" placeholder="Description VN">
        <span class="text-danger error-text description_vn_error"></span>
    </div>

    <div class="form-group">
        <label for="description_en">Description VN</label>
        <input type="description_en" class="form-control" name="description_en" id="description_en" placeholder="Description VN">
        <span class="text-danger error-text description_en_error"></span>
    </div>

    <div class="form-group col-md-6">
        <label for="button_name_vn">Title Button VN</label>
        <input type="text" class="form-control" name="button_name_vn" id="button_name_vn" placeholder="Title Button VN">
        <span class="text-danger error-text button_name_vn_error"></span>
    </div>

    <div class="form-group col-md-6">
        <label for="button_name_en">Title Button EN</label>
        <input type="text" class="form-control" name="button_name_en" id="button_name_en" placeholder="Title Button EN">
        <span class="text-danger error-text button_name_en_error"></span>
    </div>

    <div class="form-group mb-3">
        <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
        <input class="form-control" type="file" name="image" id="formFile">
        <span class="text-danger error-text image_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="order">Order<span class="field__require">*</span>:</label>
        <input type="number" class="form-control" id="order" value="1" name="order" min="1" max="9">
        <span class="text-danger error-text order_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="status">Status User</label>
        <select class="form-control" id="status" name="status">
                <option value="0">Active</option>
                <option value="1">Inactive</option>
        </select>
    </div>


</div>
<button type="submit" class="btn btn__add btn__add-user">Add New Banner</button>
</form>

@endsection


@section('script')
    <script type="text/javascript">
         $(function () {
            $(document).on('submit', '#form-banner-add', function (e) {

                e.preventDefault();
                const formData = new FormData(document.getElementById('form-banner-add'));

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
                                    $('#form-banner-add')[0].reset();

                                }
                                if(data.status == 1) {
                                    Swal.fire(
                                        'fail!',
                                        data.message,
                                        'error'
                                    );
                                }

                                if(data.status == 2) {
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
                            if($status == 3 || $status == 4){
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
