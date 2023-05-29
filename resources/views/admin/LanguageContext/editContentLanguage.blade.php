@extends('admin/main')

@section('content')

<h2>Edit Content Language</h2>

@if (!empty($newDataContentLang))

    <form 
        action="{{ route('admin.contentLanguageUpdate', ['id' =>  $newDataContentLang['id'] ?? '']) }}" 
        method="POST" 
        id = "lang-form-edit"
    >
        @csrf
        @method('PATCH')

                <div class="row">
                    <div class="form-group">
                        <label for="keyword">keyword: </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="keyword" 
                            id="keyword" 
                            value="{{ $newDataContentLang['keyword'] ?? ''}}"
                            readonly
                        >
                        <span class="text-danger error-text keyword_error"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="content_vn">Content VN:</label>
                        <textarea 
                            class="form-control" 
                            name="content_vn" 
                            id="content_vn" 
                            rows="4" cols="50"
                        >{{ $newDataContentLang['content_vn'] ?? ''}}</textarea>
                        <span class="text-danger error-text content_vn_error"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="content_en">Content EN</label>
                        <textarea 
                            class="form-control" 
                            name="content_en" 
                            id="content_en" 
                            rows="4" cols="50"
                        >{{ $newDataContentLang['content_en'] ?? ''}}</textarea>
                        <span class="text-danger error-text content_en_error"></span>
                    </div>
                </div>
        <button type="submit" class="btn btn__add btn__add-user mt-5">Edit Content Language</button>
    </form>
@endif
@endsection

@section('script')

    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#lang-form-edit', function (e) {
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