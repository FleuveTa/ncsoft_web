@extends('admin/main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.recruiment') }}">Manager recruiment</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit recruiment</li>
        </ol>
    </nav>

    <h2>Edit Recruitment</h2>

   
    @if (!empty($newDataRecruitment))
        <form 
            action="{{ route('admin.recruitmentUpdate', ['id' => $newDataRecruitment['id'] ?? ' ']) }}" 
            method="POST"
            id = "recruitment-form-edit"
        >

            @csrf

            @method('PATCH')

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="heading_vn">Heading VN:</label>
                    <input type="text" class="form-control" name="heading_vn" id="heading_vn" placeholder="Heading Banner Vn">
                    <span class="text-danger error-text heading_vn_error"></span>
                </div>

                <div class="form-group col-md-6">
                    <label for="heading_en">Heading EN:</label>
                    <input type="text" class="form-control" name="heading_en" id="heading_en" placeholder="Heading Banner En">
                    <span class="text-danger error-text heading_en_error"></span>
                </div>

                <div class="form-group">
                    <label for="description_vn">Description VN</label>
                    <textarea type="text" class="form-control" name="description_vn" id="description_vn"></textarea>
                    <span class="text-danger error-text description_vn_error"></span>
                </div>
            
                <div class="form-group">
                    <label for="description_en">Description EN</label>
                    <textarea type="description_en" class="form-control" name="description_en" id="description_en" ></textarea>
                    <span class="text-danger error-text description_en_error"></span>
                </div>

                <div class="form-group col-md-4">
                    <label for="slug">slug:</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="slug">
                    <span class="text-danger error-text slug_error"></span>
                </div>
            
                <div class="form-group col-md-4">
                    <label for="number_of_people">Number Of People</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="number_of_people" 
                        id="number_of_people" 
                        placeholder="Number Of people"
                    >
                    <span class="text-danger error-text number_of_people_error"></span>
                </div>
            
                <div class="form-group col-md-4">
                    <label for="salary">Salary</label>
                    <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary">
                </div>
                
                <div class="form-group col-md-6">
                    <label for="timeout">Time Out:<span class="field__require">*</span>:</label>
                    <input type="text" class="form-control" id="timeout" name="timeout" placeholder="Date time out">
                    <span class="text-danger error-text salary_error"></span>
                </div>

                <div class="form-group col-md-6">
                    <label for="time_display">Time Display:<span class="field__require">*</span>:</label>
                    <input type="text" class="form-control" id="time_display" name="time_display" placeholder="Date Time display">
                </div>

            </div>

            <button type="submit" class="btn btn__add btn__add-user">Edit Recruitment</button>

        </form>
    @endif
    

@endsection

@section('script')
    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript"> 
        $(document).ready(function () {
            $dataRecruitments = <?php echo json_encode($newDataRecruitment) ?? '';?> ;

        if($dataRecruitments) {
            $( "#time_display" ).datepicker();
            $( "#timeout" ).datepicker();
            function setDataView($dataNews) {
                if($dataNews != undefined || $dadtaNews != ''){
                    $('#heading_vn').val($dataNews['heading_vn'] ?? '');
                    $('#heading_en').val($dataNews['heading_en'] ?? '');
                    $('#slug').val($dataNews['slug'] ?? '');
                    $('#salary').val($dataNews['salary'] ?? '');
                    $('#number_of_people').val($dataNews['number_of_people'] ?? '');
                    $('#timeout').val($.datepicker.formatDate('dd/mm /yy', new Date($dataNews['timeout'])) ?? '');
                    $('#time_display').val($.datepicker.formatDate('dd/mm /yy', new Date($dataNews['time_display'])) ?? '');
                }
            }
            function setDataEditorView($element, $dataElement){ 
                    var editor1;
                ClassicEditor
                        .create(document.querySelector( $element ),{
                            ckfinder: {
                                uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                            },
                        })
                        .then(editor => {
                            window.editor = editor;
                            editor1 = editor;
                            editor1.data.set($dataElement ?? '')
                        })
                        .catch( error => {
                            console.error( error );
                        });
            }
            setDataEditorView('#description_vn', $dataRecruitments['description_vn'] ?? '');
            setDataEditorView('#description_en', $dataRecruitments['description_en'] ?? '');
            setDataView($dataRecruitments);
        }
       


        $(function () {
            $(document).on('submit', '#recruitment-form-edit', function (e) {
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
                            if($status == 4 || $status == 3){
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
    });
    </script>
@endsection