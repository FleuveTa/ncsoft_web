@extends('admin/main')
@section('content')
<div class="d-flex align-items-center">
    <h1 class="mx-4">Content Language</h1>
    <a href="{{ route('admin.showAddContextLang') }}" class="btn btn__add">
        Add New Content Language
    </a>
</div>
<button class="btn btn-primary btn__save-content">save</button>

<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataContextLang') }}" id="categoryData">
    <table class="table table__manage" id="contextLangTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Keyword</th>
                <th scope="col">Content VN</th>
                <th scope="col ">Content EN</th>
                <th scope="col ">Account name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if (!empty($dataContentLanguage))
                @foreach ($dataContentLanguage as $contentLanguageItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $contentLanguageItem['keyword'] ?? '' }}</td>
                        <td >
                            <p class="three-line-paragraph">{{ $contentLanguageItem['content_vn'] ?? '' }}</p>
                        </td>
                        <td>
                            <p class="three-line-paragraph">{{ $contentLanguageItem['content_en'] ?? '' }}</p>
                        </td>
    
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a 
                                        class="dropdown-item" 
                                        href="{{ route('admin.contentLanguageEdit', ['id' => $contentLanguageItem['id'] ?? '']) }}"
                                    >
                                        Edit
                                    </a>
                                    <button class="dropdown-item btn__deleteContentLang" value="{{ $contentLanguageItem['id'] ?? '' }}">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <p>Không có kết quả hiển thị</p>
            </tr>
            @endif --}}
    
            <div class="modal fade" id="saveDataContent" tabindex="-1" role="dialog" aria-labelledby="saveDataContent"
                    aria-hidden="true">
                <form action="{{ route('admin.saveContent') }}" method="POST">
                    @csrf
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Save Content Language? </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <input type="hidden" name="content_lang_delete_id" class="content_lang_id">
                            <div class="modal-body">Are you sure you want to save?</div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" href=>Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </tbody>
    </table>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn__save-content').click(function (e) {
                e.preventDefault();
                $('#saveDataContent').modal('show');
            })

            $(function () {
                $urlData = $('#categoryData').val();
                $('#contextLangTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searchDelay: 1000,
                    responsive: true,
                    autoWidth: false,
                    ajax: $urlData,
                    columns: [
                        {"render": function ( data, type, full, meta ) {
                                    return  meta.row + 1;
                        }},
                        { data: 'keyword', name: 'keyword' },
                        { data: 'content_vn', name: 'content_vn' },
                        { data: 'content_en', name: 'content_en',searchable: false},
                        { data: 'account_name', name: 'account_name',searchable: false},
                        { data: 'action', name: 'action',searchable: false },
                    ]
                });
            });

            $(document).on('click','.btn__deleteLang',function (e) {
                e.preventDefault();
                $langId = $(this).val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                            url: '{{route("admin.destroyContentLang")}}',
                            data: {id: $langId},
                            success: function(data){
                                $('#contextLangTable').DataTable().ajax.reload();
                                if(data['status'] == 0){
                                    Swal.fire(
                                        'Deleted!',
                                        data['message'] ?? '',
                                        'success'
                                    )
                                }
                            },
                            error: function (error) {
                                $status = error['responseJSON']['status'] ?? '';
                                $message = error['responseJSON']['message'] ?? ''
                                if($status == 3 || $status == 4 || $status == 1){
                                    Swal.fire(
                                        'Deleted!',
                                        $message,
                                        'error'
                                    )
                                }
                            }
                        })
                    }
                })
        });

            
        })
    </script>
@endsection