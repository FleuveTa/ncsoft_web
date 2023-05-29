@extends('admin/main')
@section('content')

<div class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <h1 class="mx-4">User</h1>
        @can('isAdmin')
            <a href="{{ route('admin.showaddUser') }}" class="btn btn__add">
                Add New User
            </a>
        @endcan
    </div>

    <a class="user-trash" href="{{ route('admin.showTrashUser') }}">
        <i class="fa-solid fa-trash"></i>
    </a>

</div>
<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataUser') }}" id="userData">
    <table class="table table-bordered table__manage" id="userTable">
        <thead>
            <tr>
                {{-- <th>@lang('user.name')</th>
                <th>@lang('user.post')</th>
                <th>@lang('user.address')</th>
                <th>@lang('user.email')</th> --}}
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
{{-- <table class="table table__manage">

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
    <tbody> --}}
        {{-- @if (!empty($dataUser))
            @foreach ($dataUser as $userItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $userItem->account_name ??'' }}</td>
                        <td>{{ $userItem->first_name ??'' }}</td>
                        <td>{{ $userItem->last_name ??'' }}</td>
                        <td>{{ $userItem->email ??'' }}</td>
                        <td>{{ $userItem->address ??'' }}</td>
                        <td class="table__img">
                            @php
                                $imageUser = $userItem->image??''
                            @endphp
                            @if ($imageUser != '')
                                <img src='{{ url("images/$imageUser") }}' alt="">
                            @endif
                        </td>

                        <td class="table__status text-center">
                            <p
                                class="{{ $userItem->status ==0?'status__lookup': 'status__nolook' }}"
                            >
                                {{ $userItem->status ==0?'Active': 'Inactive' }}
                            </p>
                        </td>

                        <td class="table__role">
                            {{ !empty($role[$userItem->role])? $role[$userItem->role]:'' }}
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.getOnlyUser', ['id'=>$userItem->id]) }}">Edit</a>
                                    <button class="dropdown-item btn__deleteUser" value="{{ $userItem->id ?? '' }}">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
            @endforeach
        @endif --}}

    {{-- </tbody>
</table> --}}

{{-- <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
        aria-hidden="true">
        <form action="{{ route('admin.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <input type="hidden" name="user_delete_id" class="user_id">
                    <div class="modal-body">Are you sure you want to delete?</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit-delete" href=>Delete</button>
                    </div>
                </div>
            </div>
        </form>
</div> --}}

@endsection

@section('script')
<script type="text/javascript">
    // $(document).ready(function () {
    //     $(document).on('click','.btn__deleteUser', function(e){
    //         e.preventDefault();
    //         $user_id = $(this).val();
    //         $('.user_id').val($user_id);
    //         $('#deleteUserModal').modal('show');
    //     });

    //     // $('.btn-submit-delete').click(function(e) {
    //     //     e.preventDefault();
    //     //     e.stopPropagation();
    //     //     $.ajax({
    //     //             type: 'DELETE',
    //     //             headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
    //     //             url: "{{ route('admin.destroy') }}",
    //     //             data: {},
    //     //             success: function(data) {
    //     //                 if(data && data['status'] == 0){
    //     //                     $toastMessages = toastMessage(data['message'], data['status']);
    //     //                     $('.toast-message').html($toastMessages);
    //     //                     $('.toast').toast('show');
    //     //                 }
    //     //             },
    //     //             error: function(data) {
    //     //                 if(data && data['status'] == 1){
    //     //                     $toastMessages = toastMessage(data['message'], data['status']);
    //     //                     $('.toast-message').html($toastMessages);
    //     //                     $('.toast').toast('show');
    //     //                 }
    //     //             },
    //     //         });
    //     // })



    //     // $('.tungancut').click(function (e) {
    //     //     e.preventDefault();
    //     //     $demo = toastMessage("demo", 0);
    //     //     $('.toast-demo').html($demo);
    //     //     $('.toast').toast('show');
    //     // })
    // })

    $(function () {
            $urlData = $('#userData').val();
            $i = 1;
            $('#userTable').DataTable({
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

            $(document).on('click','.btn__deleteUser',function (e) {
                e.preventDefault();
                $userId = $(this).val();
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
                            url: '{{route("admin.destroy")}}',
                            data: {id: $userId},
                            success: function(data){
                                $('#userTable').DataTable().ajax.reload();
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
                                $message = error['responseJSON']['message'] ?? '';
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
    });


</script>

@endsection
