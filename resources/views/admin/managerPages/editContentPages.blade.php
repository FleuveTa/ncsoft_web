@extends('admin/main')

@section('content')

<h2>Edit Content Page</h2>


@if (!empty($newDataContentPage))
<form 
    action="{{ route('page.handleEditContent', ['id' => $newDataContentPage['id'] ?? '']) }}" 
    method="POST" 
    enctype="multipart/form-data" 
    id="form-edit-Pages"
>
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label for="heading_vn">Heading VN:</label>
            <input 
                type="text" 
                class="form-control" 
                name="heading_vn" 
                id="heading_vn" 
                placeholder="Heading Vn"
                value="{{ $newDataContentPage['heading_vn'] ?? '' }}"
            >

        </div>
        <div class="form-group col-md-6">
            <label for="heading_en">Heading EN:</label>
            <input 
                type="text" 
                class="form-control" 
                name="heading_en" 
                id="heading_en" 
                placeholder="Heading Vn"
                value="{{ $newDataContentPage['heading_en'] ?? '' }}"
            >
        </div>
        <div class="form-group col-md-6">
            <label for="title_en">Title EN:</label>
            <input 
                type="text" 
                class="form-control" 
                name="title_en" 
                id="title_en" 
                placeholder="Title Banner En"
                value="{{ $newDataContentPage['title_en'] ?? '' }}"
            >
        </div>
        <div class="form-group col-md-6">
            <label for="title_vn">Title VN:</label>
            <input 
                type="text" 
                class="form-control" 
                name="title_vn" 
                id="title_vn" 
                placeholder="Title Banner Vn"
                value="{{ $newDataContentPage['title_vn'] ?? '' }}"
            >
        </div>
        <div class="form-group">
            <label for="description_vn">Description VN</label>
            <input 
                type="description_vn" 
                class="form-control" 
                name="description_vn" 
                id="description_vn" 
                placeholder="Description VN"
                value="{{ $newDataContentPage['description_vn'] ?? '' }}"
            >
        </div>

        <div class="form-group">
            <label for="description_en">Description VN</label>
            <input 
                type="description_en" 
                class="form-control" 
                name="description_en" 
                id="description_en" 
                placeholder="Description VN"
                value="{{ $newDataContentPage['description_en'] ?? '' }}"  
            >

        </div>

        <div class="form-group col-md-6">
            <label for="button_vn">Button VN</label>
            <input 
                type="text" class="form-control" 
                name="button_vn" 
                id="button_vn" 
                placeholder="Button VN"
                value="{{ $newDataContentPage['button_vn'] ?? '' }}"
            >

        </div>

        <div class="form-group col-md-6">
            <label for="button_en">Button EN</label>
            <input 
                type="text" 
                class="form-control" 
                name="button_en" 
                id="button_en" 
                placeholder="Button EN"
                value="{{ $newDataContentPage['button_en'] ?? '' }}"
            >
        </div>

        <div class="form-group mb-3">
            <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
            <input 
                class="form-control" 
                type="file" 
                name="image" 
                id="formFile"
            >

        </div>

        <div class="form-group col-md-6">
            <label for="icon">Icon</label>
            <input 
                type="text" 
                class="form-control" 
                name="icon" 
                id="icon" 
                placeholder="icon ..."
                value="{{ $newDataContentPage['icon'] ?? '' }}"
            >
        </div>
        <div class="form-group col-md-6">
            <label for="page">Page</label>
            <select class="form-control" id="page" name="page">
                    @if (!empty($Pages))
                        @foreach ($Pages as  $PageItem)
                            <option 
                                value="{{ $PageItem }}" 
                                {{ $newDataContentPage['page_keyword'] && $newDataContentPage['page_keyword'] == $PageItem ? 'selected' : '' }}
                            >
                                {{ $PageItem }}
                            </option>
                        @endforeach
                    @endif
            </select>
            <span class="text-danger error-text role_error"></span>

        </div>
        <div class="form-group col-md-6">
            <label for="status">Status User</label>
            <select class="form-control" id="status" name="status">
                    <option 
                        value="0" 
                        {{ $newDataContentPage['status'] && $newDataContentPage['status'] == $PageItem ? 'selected' : '' }}
                    >
                        Active
                    </option>
                    <option 
                        value="1" 
                        {{ $newDataContentPage['status'] && $newDataContentPage['status'] == $PageItem ? 'selected' : '' }}
                    >
                        Inactive
                    </option>
            </select>
        </div>
        
        
    </div>
    <button type="submit" class="btn btn__add btn__edit-page">Edit Content Page</button>
</form>
@endif


@endsection


@section('script')
    <script type="text/javascript">
         $(document).on('submit', '#form-edit-Pages', function (e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('form-edit-Pages'));
            
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
    </script>
@endsection