@extends('admin/main')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.font') }}">Edit Font</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Font</li>
    </ol>
</nav>

<h2>Add Fonts</h2>
<p>Create a brand new font and add them to this site.</p>
    <form action="{{ route('admin.addFont') }}" method="POST" id="form-add-font">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()&&Auth::user()->id ?Auth::user()->id:'' }}">

        <div class="form-group">
            <label for="key_font">Key font</label>
            <input type="text" class="form-control" name="key_font" id="key_font" placeholder="Key font">
            <span class="text-danger error-text key_font_error"></span>
        </div>

        <div class="form-group">
            <label for="name_font">Name font<span class="field__require">*</span></label>
            <input type="text" class="form-control" name="name_font" id="name_font" placeholder="Name font" required>
            <span class="text-danger error-text name_font_error"></span>
        </div>

        {{-- <div class="btn btn__add btn-get-font">font</div> --}}
        
        <div class="form-group">
            <label for="font_value">Font value<span class="field__require">*</span></label>
            <input type="text" class="form-control" id="font_value" name="font_value" readonly rows="10" placeholder="Font value" required>
        </div>

        <div class="form-group">
            <label for="font_family">Font family<span class="field__require">*</span></label>
            <input type="text" class="form-control" name="font_family" id="font_family" placeholder="Font Family">
            <span class="text-danger error-text font_family_error"></span>
        </div>        
        
        <button type="submit" class="btn btn__add btn__add-font">Add Font</button>
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $(document).on('submit', '#form-add-font', function (e) {
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
                                    $('#form-add-font')[0].reset();

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

            // $('.btn-get-font').click(function (e) {
            //     $nameFont = $('#name_font').val();

            //     if($nameFont == "") {
            //         Swal.fire(
            //                 'Error!',
            //                 'You have to enter the value of field name font!',
            //                 'error'
            //                 )
            //     }else {
            //         $url = 'https://fonts.googleapis.com/css?family='+$nameFont+':bold,bolditalic,medium,regular|Inconsolata:italic';
            //         console.log($url);

            //         $.ajax({
            //                 method: 'GET',
            //                 headers: {  'Access-Control-Allow-Origin': "http, https" },
            //                 headers: {  "Access-Control-Allow-Methods": "PUT, GET, POST, DELETE, OPTONS" },
            //                 url: $url,
            //                 data: "",
            //                 type: 'dataType',
            //                 success: function(data){
            //                     console.log(data);
                               
            //                 },
            //                 error: function (error){
            //                     console.log(error);
            //                 }
            //         });
            //     }
                
            // })
            
        });
    </script>
@endsection