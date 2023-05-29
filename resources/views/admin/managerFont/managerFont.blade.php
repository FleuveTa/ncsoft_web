@extends('admin/main')

@section('content')

<h2>Add Color</h2>

<form action="{{ route('admin.updateFont') }}"  id="form-edit-font">
    @csrf

    @if (!empty($listFont))
        <select class="form-select" aria-label="Default select example" name="font">
            <option selected value="">-- Choose font --</option>
            @foreach ($listFont as  $itemFont)
                <option value="{{ $itemFont['key_font'] ?? '' }}">
                    {{ $itemFont['name_font'] ?? '' }}
                </option>
            @endforeach
        </select>
    @endif
    

    <button type="submit" class="btn btn__add btn__add-page my-5">Edit Font</button>
</form>

<div class="custom-font text-center">
    <h1>
        Custom font heading
    </h1>
    
    <p class="my-5" style="font-size: 16px;">Custom font title</p>
</div>

@endsection

@section('script')
    <script type="text/javascript">
    $(function () {
            $(document).on('submit', '#form-edit-font', function (e) {

                
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
                    })
                    
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            });
        })
    </script>
@endsection