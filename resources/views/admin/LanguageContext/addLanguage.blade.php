@extends('admin/main')

@section('content')

<h2>Add Content Language</h2>
<p>Create a brand new Content language and add them to this site.</p>

<form action="" method="POST" enctype="multipart/form-data" id="form-add-lang">
    @csrf

    <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

<div class="row">
    <div class="form-group">
        <label for="keyword">keyword: </label>
        <input 
            type="text" 
            class="form-control" 
            name="keyword" 
            id="keyword" 
            placeholder="Keyword Content" 
            required
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
            required
        ></textarea>
        <span class="text-danger error-text content_vn_error"></span>
    </div>
    <div class="form-group col-md-6">
        <label for="content_en">Content EN</label>
        <textarea 
            class="form-control" 
            name="content_en" 
            id="content_en" 
            rows="4" cols="50"
            required
        ></textarea>
        <span class="text-danger error-text content_en_error"></span>
    </div>
</div>
<button type="submit" class="btn btn__add btn__add-user mt-5">Add Content Language</button>
</form>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#form-add-lang', function (e) {
                e.preventDefault();
                $url = $(this).attr('action');
                Swal.fire({
                    title: 'do you want create new Context Lang?',
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
                                    $('#form-add-lang')[0].reset();

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