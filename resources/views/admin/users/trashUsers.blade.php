@extends('admin/main')
@section('content')

<div class="d-flex align-items-center justify-content-between">
        <h1 class="mx-4">Trash Users</h1>
</div>
<div class="table-responsive">
    <input hidden value="{{ route('admin.dataTrashUser') }}" id="trashUserData">
    <table class="table table-bordered table__manage" id="trashUserTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Account Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
                
            </tr>
        </thead>
    </table>
</div>

@endsection

@section('script')
<script type="text/javascript">

    $(function () {
            $urlData = $('#trashUserData').val();
            $i = 1;
            $('#trashUserTable').DataTable({
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
                            } },
                    { data: 'account_name', name: 'account_name' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name',searchable: false },
                    { data: 'email', name: 'email',searchable: false },
                    { data: 'address', name: 'address',searchable: false },
                    {   data: 'image',
                        render: function (data, type, row, meta){
                            $image = '<img src="http://ncsoft.localhost/images/'+data+'" alt="Cover" width="500" height="600">';
                            return $image;
                        },
                        name: 'image',
                        searchable: false,
                    },
                    { 
                        data: 'status', 
                        render: function (data, type, row, meta) {
                            if(data == '0'){
                                return 'active';
                            }else {
                                return 'Inactive';
                            }
                        },
                        name: 'status',
                        searchable: false 
                    },
                    {   
                        data: 'role', 
                        name: 'role',
                        searchable: false 
                    },
                    { data: 'action', name: 'action',searchable: false },
                ]
            });

            $(document).on('click','.btn__restoreUser',function (e) {
                e.preventDefault();
                $userId = $(this).val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                            url: '{{route("admin.restoreTrashUser")}}',
                            data: {id: $userId},
                            success: function(data){
                                $('#trashUserTable').DataTable().ajax.reload();
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
                                if($status == 1 || $status == 2){
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

            $(document).on('click','.btn__deleteUserTrash',function (e) {
                e.preventDefault();
                $userId = $(this).val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, permanent it!'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                            url: '{{route("admin.permanentTrashUser")}}',
                            data: {id: $userId},
                            success: function(data){
                                $('#trashUserTable').DataTable().ajax.reload();
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
                                if($status == 3){
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
    });


    
</script>

@endsection