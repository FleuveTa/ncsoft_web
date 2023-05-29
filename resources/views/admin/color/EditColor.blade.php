@extends('admin/main')

@section('content')

<h2>Add Color</h2>

@if (!empty($fetchColor))
<form action="{{ route('admin.updateColor') }}" method="POST" id="form-edit-color">
    @csrf

    <div class="row mt-5">

        <h3>Primary</h3>

        <div class="col-sm-12 col-md-6 col-lg-6">
            <label for="primary_color" class="form-label">Primary color</label>
            <input type="color" class="form-control form-control-color" name="primary_color" id="primary_color" value="{{ $fetchColor->primary_color ?? '#1fdf66'}}" title="Choose your color">
            <span class="text-danger error-text primary_color_error"></span>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6">
            <label for="sub_primary_color" class="form-label">Sub Primary color</label>
            <input type="color" class="form-control form-control-color" name="sub_primary_color" id="sub_primary_color" value="{{ $fetchColor->sub_primary_color ?? ''}}" title="Choose your color">
            <span class="text-danger error-text sub_primary_color_error"></span>
        </div>

        <h3 class="mt-5">Background</h3>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="background_color" class="form-label">Background color</label>
            <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="{{ $fetchColor->background_color ?? '#232223'}}" title="Choose your color">
            <span class="text-danger error-text text_color_error"></span>
        </div>

        <h3 class="mt-5">Color Text</h3>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="text_primary_color" class="form-label">Text color</label>
            <input type="color" class="form-control form-control-color" id="text_primary_color" name="text_primary_color" value="{{ $fetchColor->text_primary_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text text_primary_color_error"></span>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="sub_text_primary_color" class="form-label">Sub Text color</label>
            <input type="color" class="form-control form-control-color" id="sub_text_primary_color" name="sub_text_primary_color" value="{{ $fetchColor->sub_text_primary_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text sub_text_primary_color_error"></span>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="text_background_color" class="form-label">Text Background color</label>
            <input type="color" class="form-control form-control-color" id="text_background_color" name="text_background_color" value="{{ $fetchColor->text_background_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text text_background_color_error"></span>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="text_hover_color" class="form-label">Text Hover color</label>
            <input type="color" class="form-control form-control-color" name="text_hover_color" id="text_hover_color" value="{{ $fetchColor->text_hover_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text text_hover_color_error"></span>
        </div>

        <h3 class="mt-5">Button Color</h3>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="background_button_color" class="form-label">Background button color</label>
            <input type="color" class="form-control form-control-color" name="background_button_color" id="background_button_color" value="{{ $fetchColor->background_button_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text background_button_color_error"></span>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="background_hover_color" class="form-label">Background hover color</label>
            <input type="color" class="form-control form-control-color" name="background_hover_color" id="background_hover_color" value="{{ $fetchColor->background_hover_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text background_hover_color_error"></span>
        </div>


        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="text_button_color" class="form-label">Text button color</label>
            <input type="color" class="form-control form-control-color" name="text_button_color" id="text_button_color" value="{{ $fetchColor->text_button_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text text_button_color_error"></span>
        </div>

        <div class="col-sm-3 col-md-3 col-lg-3">
            <label for="hover_text_button_color" class="form-label">Hover Text button color</label>
            <input type="color" class="form-control form-control-color" name="hover_text_button_color" id="hover_text_button_color" value="{{ $fetchColor->hover_text_button_color ?? '#0f3c11'}}" title="Choose your color">
            <span class="text-danger error-text hover_text_button_color_error"></span>
        </div>

        <h3 class="mt-5">Header Color</h3>
        
        <div class="form-group col-md-4">
            <label for="header_background_color">Header Background color:</label>
            <input type="color" class="form-control form-control-color"  name="header_background_color" id="header_background_color" value="{{ $fetchColor->header_background_color ?? '#000000'}}">
            <span class="text-danger error-text header_background_color_error"></span>
        </div>



        <div class="form-group col-md-4">
            <label for="header_text_color">Header Text color:</label>
            <input type="color" class="form-control form-control-color"  name="header_text_color" id="header_text_color" value="{{ $fetchColor->header_text_color ?? '#000000'}}">
            <span class="text-danger error-text header_text_color_error"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="header_active_color">Header active color:</label>
            <input type="color" class="form-control form-control-color"  name="header_active_color" id="header_active_color" value="{{ $fetchColor->header_active_color ?? '#000000'}}">
            <span class="text-danger error-text header_active_color_error"></span>
        </div>

        <h3 class="mt-5">Comment Color</h3>
        
        <div class="form-group col-md-4">
            <label for="comment_background_color">Comment Background color:</label>
            <input type="color" class="form-control form-control-color"  name="comment_background_color" id="comment_background_color" value="{{ $fetchColor->comment_background_color ?? '#000000'}}">
            <span class="text-danger error-text comment_background_color_error"></span>
        </div>



        <div class="form-group col-md-4">
            <label for="comment_text_color">Comment Text color:</label>
            <input type="color" class="form-control form-control-color"  name="comment_text_color" id="comment_text_color" value="{{ $fetchColor->comment_text_color ?? '#000000'}}">
            <span class="text-danger error-text comment_text_color_error"></span>
        </div>

        <h3 class="mt-5">Icon Color</h3>
        
        <div class="form-group col-md-4">
            <label for="icon_color">Icon color:</label>
            <input type="color" class="form-control form-control-color"  name="icon_color" id="icon_color" value="{{ $fetchColor->icon_color ?? '#000000'}}">
            <span class="text-danger error-text icon_color_error"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="icon_background_color">Icon background color:</label>
            <input type="color" class="form-control form-control-color"  name="icon_background_color" id="icon_background_color" value="{{ $fetchColor->icon_background_color ?? '#000000'}}">
            <span class="text-danger error-text icon_background_color_error"></span>
        </div>

        <h3 class="mt-5">Slider Color</h3>
        
        <div class="form-group col-md-4">
            <label for="slider_color">slider Color:</label>
            <input type="color" class="form-control form-control-color"  name="slider_color" id="slider_color" value="{{ $fetchColor->slider_color ?? '#000000'}}">
            <span class="text-danger error-text slider_color_error"></span>
        </div>

        <h3 class="mt-5">Border Color</h3>
        
        <div class="form-group col-md-4">
            <label for="border_color">Border color:</label>
            <input type="color" class="form-control form-control-color"  name="border_color" id="border_color" value="{{ $fetchColor->border_color ?? '#000000'}}">
            <span class="text-danger error-text border_color_error"></span>
        </div>

        <h3 class="mt-5">box service Color</h3>
        
        <div class="form-group col-md-4">
            <label for="box_service_color">Border color:</label>
            <input type="color" class="form-control form-control-color"  name="box_service_color" id="box_service_color" value="{{ $fetchColor->box_service_color ?? '#000000'}}">
            <span class="text-danger error-text box_service_color_error"></span>
        </div>

    </div>

    <button type="submit" class="btn btn__add btn__add-page">Edit Color</button>

</form>
@endif


@endsection

@section('script')
    <script type="text/javascript">
    $(function () {
            $(document).on('submit', '#form-edit-color', function (e) {
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
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            });
        })
    </script>
@endsection

