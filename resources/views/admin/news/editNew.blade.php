@extends('admin/main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.news') }}">Manager News</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit News</li>
        </ol>
    </nav>
    <h2>Edit News</h2>

    @if (!empty($newDataNews))
        <form
            action="{{ route('admin.newEdit', ['id' => $newDataNews['id'] ?? '']) }}"
            method="POST"
            enctype="multipart/form-data"
            id="form-news-edit"
        >

            @csrf
            {{-- @method('PATCH') --}}

            <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="heading_vn">Heading VN:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="heading_vn"
                        id="heading_vn"
                        placeholder="Title Banner Vn"
                    >
                    <span class="text-danger error-text heading_vn_error"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="heading_en">Heading EN:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="heading_en"
                        id="heading_en"
                        placeholder="Title Banner En"
                    >
                    <span class="text-danger error-text heading_en_error"></span>
                </div>



                <div class="form-group">
                    <label for="description_vn">Description VN</label>
                    <textarea
                        type="text"
                        class="form-control"
                        name="description_vn"
                        id="description_vn"
                    >
                    </textarea>
                    <span class="text-danger error-text description_vn_error"></span>
                </div>

                <div class="form-group">
                    <label for="description_en">Description EN</label>
                    <textarea type="description_en" class="form-control" name="description_en" id="description_en" ></textarea>
                    <span class="text-danger error-text description_en_error"></span>
                </div>

                <div class="form-group col-md-4">
                    <label for="slug">slug:</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug">
                </div>

                <div class="form-group col-md-4">
                    <label for="title_vn">Title VN</label>
                    <input type="text" class="form-control" name="title_vn" id="title_vn" placeholder="Title Button VN">
                    <span class="text-danger error-text title_vn_error"></span>
                </div>

                <div class="form-group col-md-4">
                    <label for="title_en">Title EN</label>
                    <input type="text" class="form-control" name="title_en" id="title_en" placeholder="Title Button EN">
                    <span class="text-danger error-text title_en_error"></span>
                </div>

                <div class="img__preview my-3">
                    @php
                        $imageNews= $newDataNews['image'] ?? ' ' ;
                    @endphp
                    <img src='{{ url("images/news/$imageNews") }}' value = "$imageNews" class="img-fluid image__preview-old" alt="img news">
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Image<span class="field__require">*</span></label>
                    <input class="form-control" type="file" name="image" id="formFile">
                    <span class="text-danger error-text image_error"></span>

                </div>


                <div class="form-group col-md-6">
                    <label for="order">Time Display:<span class="field__require">*</span>:</label>
                    <input type="text" class="form-control" id="time_display" name="time_display">
                    <span></span>
                </div>

            </div>

            <button type="submit" class="btn btn__add btn__add-user">Edit News</button>

        </form>
    @endif


@endsection

@section('script')
    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $dataNews = <?php echo json_encode($newDataNews) ?? '';?> ;
            $( "#time_display" ).datepicker();

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

            setDataEditorView('#description_vn', $dataNews['description_vn']);
            setDataEditorView('#description_en', $dataNews['description_en']);


                function setDataView($dataNews) {
                    if($dataNews != undefined || $dadtaNews != ''){
                        $('#heading_vn').val($dataNews['heading_vn'] ?? '');
                        $('#heading_en').val($dataNews['heading_en'] ?? '');
                        $('#slug').val($dataNews['slug'] ?? '');
                        $('#title_vn').val($dataNews['title_vn'] ?? '');
                        $('#title_en').val($dataNews['title_en'] ?? '');
                        $('#time_display').val($.datepicker.formatDate('dd/mm /yy', new Date($dataNews['time_display'])) ?? '');
                    }
                }
                setDataView($dataNews);



            //  Submit  form
            $(document).on('submit', '#form-news-edit', function (e) {
                e.preventDefault();

                const formData = new FormData(document.getElementById('form-news-edit'));

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
        });
    </script>
@endsection
