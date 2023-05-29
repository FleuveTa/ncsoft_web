@extends('admin/main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.banner') }}">Manager Banner</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit banner</li>
    </ol>
</nav>

<h2>Edit New Banner</h2>

@if (!empty($newDataBanner))
    <form
        action="{{ route('admin.bannerUpdate', ['id' => $newDataBanner['id'] ?? '']) }}"
        method="POST"
        enctype="multipart/form-data" id="form-banner-edit"
    >
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label for="title_vn">Title VN:</label>

                <input
                    type="text"
                    class="form-control"
                    name="title_vn"
                    value="{{ $newDataBanner['title_vn'] ?? '' }}"
                    id="title_vn"
                    placeholder="Title Banner Vn"
                >
                <span class="text-danger error-text title_vn_error"></span>

            </div>

            <div class="form-group col-md-6">
                <label for="title_en">Title EN:</label>
                <input
                    type="text"
                    class="form-control"
                    name="title_en"
                    value="{{ $newDataBanner['title_en'] ?? '' }}"
                    id="title_vn"
                    placeholder="Title Banner En"
                >
                <span class="text-danger error-text title_en_error"></span>

            </div>

            <div class="form-group">
                <label for="description_vn">Description VN</label>
                <input
                    type="description_vn"
                    class="form-control"
                    name="description_vn"
                    value="{{ $newDataBanner['description_vn'] ?? '' }}"
                    id="description_vn"
                    placeholder="Description VN"
                >
                <span class="text-danger error-text description_vn_error"></span>
            </div>

            <div class="form-group">
                <label for="description_en">Description VN</label>
                <input
                    type="description_en"
                    class="form-control"
                    name="description_en"
                    value="{{ $newDataBanner['description_en'] ?? '' }}"
                    id="description_en"
                    placeholder="Description VN"
                >
                <span class="text-danger error-text description_en_error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="button_name_vn">Title Button VN</label>
                <input
                    type="text"
                    class="form-control"
                    name="button_name_vn"
                    value="{{ $newDataBanner['button_name_vn'] ?? '' }}"
                    id="button_name_vn"
                    placeholder="Title Button VN"
                >
                <span class="text-danger error-text button_name_vn_error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="button_name_en">Title Button EN</label>
                <input
                    type="text"
                    class="form-control"
                    name="button_name_en"
                    value="{{ $newDataBanner['button_name_en'] ?? '' }}"
                    id="button_name_en"
                    placeholder="Title Button EN"
                >
                <span class="text-danger error-text button_name_en_error"></span>
            </div>

            <div class="img__preview my-3">
                @php
                    $imageBanner = $newDataBanner['image'] ?? " ";
                @endphp
                <img src='{{ url("images/banners/$imageBanner") }}' value = "$imageBanner" class="img-fluid image__preview-old" alt="img news">
            </div>

            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
                <input class="form-control" type="file" name="image" id="formFile">
                <span class="text-danger error-text image_error"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="order">Order<span class="field__require">*</span>:</label>
                <input
                    type="number"
                    class="form-control"
                    id="order"
                    value="{{ $newDataBanner['order'] ?? '' }}"
                    name="order"
                    min="1"
                    max="9"
                >
                <span class="text-danger error-text order_error"></span>

            </div>
            <div class="form-group col-md-6">
                <label for="status">Status Banner</label>
                <select class="form-control" id="status" name="status">
                        <option value="0" {{ $newDataBanner && $newDataBanner['status'] == 0 ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ $newDataBanner && $newDataBanner['status'] == 1 ? 'selected' : '' }}>Inactive</option>
                </select>

            </div>


        </div>
        <button type="submit" class="btn btn__add btn__add-user">Edit Banner</button>
    </form>
@endif


@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('submit', '#form-banner-edit', function (e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('form-banner-edit'));

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
                                )
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
