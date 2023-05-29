@extends('admin/main')

@section('content')

<h2>Add New Content Page</h2>
<p>Create a brand new content page and add them to this site.</p>

<form action="{{ route('page.handleAddPage') }}" method="POST" enctype="multipart/form-data" id="form-add-Pages">
    @csrf

    <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

<div class="row">
    <div class="form-group col-md-6">
        <label for="heading_vn">Heading VN:</label>
        <input type="text" class="form-control" name="heading_vn" id="heading_vn" placeholder="Heading Vn">
        <span class="text-danger error-text heading_vn_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="heading_en">Heading EN:</label>
        <input type="text" class="form-control" name="heading_en" id="heading_en" placeholder="Heading Vn">
        <span class="text-danger error-text heading_en_error"></span>

    </div>
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
        <label for="description_en">Description EN</label>
        <input type="description_en" class="form-control" name="description_en" id="description_en" placeholder="Description VN">
        <span class="text-danger error-text description_en_error"></span>
    </div>

    <div class="form-group col-md-6">
        <label for="button_vn">Button VN</label>
        <input type="text" class="form-control" name="button_vn" id="button_vn" placeholder="Button VN">
        <span class="text-danger error-text button_vn_error"></span>
    </div>

    <div class="form-group col-md-6">
        <label for="button_en">Button EN</label>
        <input type="text" class="form-control" name="button_en" id="button_en" placeholder="Button EN">
        <span class="text-danger error-text button_en_error"></span>
    </div>
    <div class="form-group col-md-6">
        <label for="button_en">Icon</label>
        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon...">
        <span class="text-danger error-text icon_error"></span>
    </div>

    <div class="form-group mb-3">
        <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
        <input class="form-control" type="file" name="image" id="formFile">
        <span class="text-danger error-text image_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="page">Page</label>
        <select class="form-control" id="page" name="page">
                @if (!empty($Pages))
                    @foreach ($Pages as  $PageItem)
                        <option value="{{ $PageItem }}">{{ $PageItem }}</option>
                    @endforeach
                @endif
        </select>
        <span class="text-danger error-text role_error"></span>

    </div>
    <div class="form-group col-md-6">
        <label for="status">Status User</label>
        <select class="form-control" id="status" name="status">
                <option value="0">Active</option>
                <option value="1">Inactive</option>
        </select>
    </div>
    
    
</div>
<button type="submit" class="btn btn__add btn__add-page">Add New Banner</button>
</form>

@endsection


@section('script')
    <script type="text/javascript">
         $(function () {
            $(document).on('submit', '#form-add-Pages', function (e) {

                e.preventDefault();
                const formData = new FormData(document.getElementById('form-add-Pages'));

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
                            if( data ) {
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
                                    $('#form-add-Pages')[0].reset();

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