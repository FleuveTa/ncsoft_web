@extends('admin/main')
@section('content')
<div class="d-flex align-items-center">
    <h1 class="mx-4">Category</h1>
    <a href="{{ route('admin.showAddCategory') }}" class="btn btn__add">
        Add New Category
    </a>
</div>

<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataCategory') }}" id="categoryData">
    <table class="table table__manage" id = "categoryTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name_en Category</th>
                <th scope="col">Name_vn Category</th>
                <th scope="col">User Create</th>
                <th scope="col">Slug</th>
                <th scope="col">Time Create</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if (!empty($listCategory))
            @foreach ($listCategory as $categoryItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $categoryItem->name_en ?? '' }}</td>
                        <td>{{ $categoryItem->name_vn ?? '' }}</td>
                        <td>{{ $categoryItem->account_name ?? '' }}</td>
                        <td>{{ $categoryItem->slug ?? '' }}</td>
                        <td>{{ $categoryItem->created_at ?? '' }}</td>
    
                        <td class="table__status text-center">
                            
                            <p class="{{ $categoryItem->status ==0?'status__lookup': 'status__nolook' }}">
                                {{$categoryItem && $categoryItem->status == 0 ? 'Active' : 'Inactive' }}
                            </p>
    
                        </td>
    
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a 
                                        class="dropdown-item" 
                                        href="{{ route('admin.showedit', ['slug' => $categoryItem->slug ?? '','id' => $categoryItem->id ?? '']) }}"
                                    >
                                        Edit
                                    </a>
                                    <button class="dropdown-item btn__deleteCategory" value="{{ $categoryItem->id ?? '' }}">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif --}}
            
        </tbody>
    </table>
</div>


<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
        aria-hidden="true">
        <form action="{{ route('admin.destroyCategory') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Category?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <input type="hidden" name="category_delete_id" class="category_id">
                    <div class="modal-body">Are you sure you want to delete?</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" href=>Delete</button>
                    </div>
                </div>
            </div>
        </form>
</div>
@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $urlData = $('#categoryData').val();
            $('#categoryTable').DataTable({
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
                    { data: 'name_en', name: 'name_en' },
                    { data: 'name_vn', name: 'name_vn' },
                    { data: 'account_name', name: 'account_name',searchable: false },
                    { data: 'slug', name: 'slug',searchable: false },
                    { data: 'created_at', name: 'created_at',searchable: false },
                    { data: 'status', name: 'status',searchable: false },
                    { data: 'action', name: 'action',searchable: false },
                ]
            });
        });


        $(document).on('click','.btn__deleteCategory',function (e) {
                e.preventDefault();
                $categoryId = $(this).val();
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
                            url: '{{route("admin.destroyCategory")}}',
                            data: {id: $categoryId},
                            success: function(data){
                                $('#categoryTable').DataTable().ajax.reload();
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
    </script>
@endsection