@extends('admin/main')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Manager Category</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Category</li>
    </ol>
</nav>

<h2>Add New Category</h2>
<p>Create a brand new category and add them to this site.</p>
    <form action="{{ route('admin.addCategory') }}" method="POST" id="form-add-categoty">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()&&Auth::user()->id ?Auth::user()->id:'' }}">
        <div class="form-group">
            <label for="name_category_en">Category Name EN <span class="field__require">*</span></label>
            <input type="text" class="form-control" name="name_category_en" id="name_category_en" placeholder="Name Category EN" required>
            <span class="text-danger error-text name_category_en_error"></span>
        </div>
        <div class="form-group">
            <label for="name_category_vn">Category Name VN <span class="field__require">*</span></label>
            <input type="text" class="form-control" name="name_category_vn" id="name_category_vn" placeholder="Name Category VN" required>
            <span class="text-danger error-text name_category_vn_error"></span>

        </div>
        <div class="form-group">
            <label for="slug">slug</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="Category Slug">
            <span class="text-danger error-text slug_error"></span>
        </div>

        
        <div class="form-group">
            <label for="status">Status Category</label>
            <select class="form-control" id="status" name="status">
                    <option value="0">Active</option>
                    <option value="1">Inactive</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn__add btn__add-category">Add New Category</button>
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#form-add-categoty', function (e) {
                e.preventDefault();
                $url = $(this).attr('action');
                Swal.fire({
                    title: 'do you want create new category?',
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
                                    $('#form-add-categoty')[0].reset();

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