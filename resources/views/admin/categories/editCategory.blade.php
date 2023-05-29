@extends('admin/main')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Manager Category</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
    </ol>
</nav>

<h2>Edit Category</h2>

@if (!empty($newDataCategory))
<form 
    action="{{ 
            route('admin.patchCategory', 
            ['id' => $newDataCategory['id'] ?? '']) 
        }}" 
        method="POST"
        id = "category-form-edit"
>

    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="name_en">Category Name EN<span class="field__require">*</span></label>
        <input 
            type="text" 
            class="form-control"
            value="{{ $newDataCategory['name_en'] ?? ''}}" 
            name="name_en" 
            id="name_en" 
            placeholder="Category Name EN" 
            required
        >
        <span class="text-danger error-text name_en_error"></span>
        
    </div>
    <div class="form-group">
        <label for="name_vn">Category Name VN<span class="field__require">*</span></label>
        <input 
            type="text" 
            class="form-control"
            value="{{ $newDataCategory['name_vn'] ?? ''}}" 
            name="name_vn" 
            id="name_vn" 
            placeholder="Category Name VN" 
            required
        >
        <span class="text-danger error-text name_vn_error"></span>

        
    </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input 
            type="text" 
            class="form-control"
            value="{{ $newDataCategory['slug'] ?? ''}}" 
            name="slug" 
            id="slug" 
            placeholder="Slug"
        >
        <span class="text-danger error-text slug_error"></span>

    </div>
    <div class="form-group">
        <label for="name_create_category">User Create Category</label>
        <input 
            readonly
            type="text" 
            class="form-control"
            value="{{ $newDataCategory['account_name'] ?? ''}}" 
            name="name_create_category" 
            id="name_create_category" 
            placeholder="Slug"
        >

    </div>
    <div class="form-group">
        <label for="status">Status Category</label>
        <select class="form-control" id="status" name="status">
                <option value="0">Active</option>
                <option value="1">Inactive</option>
        </select>
        {{-- @if ($errors->any() && $errors->get('status'))
            <ul class="message-error my-2">
                @foreach ((array) $errors->get('status') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif --}}
    </div>
    <button type="submit" class="btn btn__add btn__add-category" value="{{ $newDataCategory['id'] }}">Edit Category</button>
</form>
@endif
@endsection

@section('script')

    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#category-form-edit', function (e) {
                e.preventDefault();
                $url = $(this).attr('action');
                Swal.fire({
                    title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'PATCH',
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
                                    )
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
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            });
        })
    </script>
@endsection