@extends('admin/main')
@section('content')
<div class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <h1 class="mx-4">Recruitment</h1>
        @can('create', Helper::handlePermission())
            <a href="{{ route('admin.showAddRecruitment') }}" class="btn btn__add">
                Add New Recruitment
            </a>
        @endcan
    </div>
    
    {{-- <a class="recruitment-trash" href="{{ route('admin.showTrash') }}">
        <i class="fa-solid fa-trash"></i>
    </a> --}}
</div>

<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataRecruitment') }}" id="recruitmentData">
    <table class="table table__manage" id = "recruitmentTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Heading VN</th>
                <th scope="col">Heading En</th>
                <th scope="col">slug</th>
                <th scope="col">Description VN</th>
                <th scope="col">Description EN</th>
                <th scope="col">number of people</th>
                <th scope="col">salary</th>
                <th scope="col">TimeOut</th>
                <th scope="col">User Create</th>
                <th scope="col">time display</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="body-content">
            
            
        </tbody>
    </table>
</div>


{{-- <div class="modal fade" id="deleteRecruitment" tabindex="-1" role="dialog" aria-labelledby="deleteRecruitment"
        aria-hidden="true">
    <form action="{{ route('admin.destroyRecruitment') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Recruitment?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

                <input type="hidden" name="recruitment_delete_id" class="recruitment_id">
                
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
         $(function () {
            // Get data, add Data to table
            $urlData = $('#recruitmentData ').val();
            $('#recruitmentTable').DataTable({
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
                    { data: 'heading_vn', name: 'heading_vn' },
                    { data: 'heading_en', name: 'heading_en' },
                    { data: 'slug', name: 'slug',searchable: false },
                    { data: 'description_vn', name: 'description_vn',searchable: false },
                    { data: 'description_en', name: 'description_en',searchable: false },
                    { data: 'number_of_people', name: 'number_of_people',searchable: false },
                    { data: 'salary', name: 'salary',searchable: false },
                    { data: 'timeout', name: 'timeout',searchable: false },
                    { data: 'account_name', name: 'account_name',searchable: false },
                    { data: 'time_display', name: 'time_display',searchable: false },
                    { data: 'action', name: 'action',searchable: false },
                ]
            });
            // End Get data, add Data to table


            // delete item recruiment 
            $(document).on('click','.btn__deleteRecruitment',function (e) {
                e.preventDefault();
                $recruitmentId = $(this).val();
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
                            url: '{{route("admin.destroyRecruitment")}}',
                            data: {id: $recruitmentId},
                            success: function(data){
                                $('#recruitmentTable').DataTable().ajax.reload();
                                if( data['status'] == 0 ) {
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

            // end delete item recruiment 

        });
    </script>
@endsection