@extends('admin/main')
@section('content')
    <div class="d-flex align-items-center">
        <h1 class="mx-4">Pages</h1>
        @can('create', Helper::handlePermission())
            <a href="{{ route('page.showAddPage') }}" class="btn btn__add">
                Add New Pages
            </a>
        @endcan
    </div>
    <div class="table-responsive">
        <input hidden value="{{ route('page.getDataTable') }}" id="pagesData">
        <table class="table table__manage" id="pagesTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Heading VN</th>
                    <th scope="col">Heading En</th>
                    <th scope="col">title Vn</th>
                    <th scope="col">Title EN</th>
                    <th scope="col">Description VN</th>
                    <th scope="col">Description EN</th>
                    <th scope="col">Image</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Button VN</th>
                    <th scope="col">Button EN</th>
                    <th scope="col">User Create</th>
                    <th scope="col">Page</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $urlData = $('#pagesData').val();
            $i = 1;
            $('#pagesTable').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                responsive: true,
                autoWidth: false,
                ajax: $urlData,
                order: [
                    [1, 'asc']
                ],
                columns: [
                    {"render": function ( data, type, full, meta ) {
                                return  meta.row + 1;
                            } 
                    },
                    { data: 'heading_vn', name: 'heading_vn', searchable: false },
                    { data: 'heading_en', name: 'heading_en', searchable: false },
                    { data: 'title_vn', name: 'title_vn',searchable: false },
                    { data: 'title_en', name: 'title_en',searchable: false },
                    { data: 'description_vn', name: 'description_vn',searchable: false },
                    { data: 'description_en', name: 'description_en',searchable: false },
                    {   data: 'image',
                        name: 'image',
                        searchable: false,
                    },
                    { data: 'icon', name: 'icon', searchable: false },
                    { data: 'button_vn', name: 'button_vn', searchable: false },
                    { data: 'button_en', name: 'button_en', searchable: false },
                    { data: 'account_name', name: 'account_name', searchable: false },
                    { data: 'page_keyword', name: 'page_keyword' },
                    { data: 'status', name: 'status', searchable: false },
                    { data: 'action', name: 'action', searchable: false },
                ]
            });


            $(document).on('click','.btn__deletePages',function (e) {
                e.preventDefault();
                $pageId = $(this).val();
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
                            url: '{{route("page.deletePage")}}',
                            data: {id: $pageId},
                            success: function(data){
                                $('#pagesTable').DataTable().ajax.reload();
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
                                if($status == 4 || $status == 3){
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