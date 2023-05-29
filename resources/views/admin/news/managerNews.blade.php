@extends('admin/main')
@section('content')
<div class="d-flex align-items-center">
    <h1 class="mx-4">Category</h1>
    @can('create', Helper::handlePermission())
        <a href="{{ route('admin.showAddNew') }}" class="btn btn__add">
            Add New News
        </a>
    @endcan
</div>
<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataNews') }}" id="newsData">
    <table class="table table__manage" id="newsTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Heading VN</th>
                <th scope="col">Heading En</th>
                <th scope="col">slug</th>
                <th scope="col">title Vn</th>
                <th scope="col">Title EN</th>
                <th scope="col">Description VN</th>
                <th scope="col">Description EN</th>
                <th scope="col">Image</th>
                <th scope="col">User Create</th>
                <th scope="col">time display</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if (!empty($dataNews))
            @foreach ($dataNews as $newsItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>
                            <p class="three-line-paragraph-s "> 
                                {{ $newsItem['heading_vn'] ?? '' }}
                            </p>
                            
                        
                        </td>
    
                        <td>
                            <p class="three-line-paragraph-s "> 
                                {{ $newsItem['heading_en'] ?? '' }}
                            </p>
                        </td>
    
                        <td>
                            <p class="three-line-paragraph "> 
                                {{ $newsItem['slug'] ?? '' }}
                            </p>
                        </td>
    
                        <td>
                            <p class="three-line-paragraph ">{{ $newsItem['title_vn'] ?? '' }}</p>
                        </td>
    
                        <td>
                            <p class="three-line-paragraph ">{{ $newsItem['title_en'] ?? '' }}</p>
                        </td>
    
                        <td>
                            <p class="three-line-paragraph">
                                {{ $newsItem['description_vn'] ?? '' }}
                            </p>
                        </td>
    
                        <td>
                            <p class="three-line-paragraph">
                                {{ $newsItem['description_en'] ?? '' }}
                            </p>
                        </td>
    
                        <td class="table__img">
                            @php
                                $imageNews = $newsItem['image']??''
                            @endphp
                            @if ($imageNews != '')
                                <img src='{{ url("images/$imageNews") }}' alt="">
                            @endif
                        </td>
    
                        <td>{{ $newsItem['account_name'] ?? '' }}</td>
    
                        <td>{{ $newsItem['time_display'] ?? '' }}</td>
    
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @can('update', Helper::handlePermission())
                                        <a 
                                            class="dropdown-item" 
                                            href="{{ route('admin.newEdit', ['id' => $newsItem['id'] ?? '']) }}"
                                        >
                                            Edit
                                        </a>
                                    @endcan
                                    
                                    @can('delete', Helper::handlePermission())
                                        <button 
                                            class="dropdown-item btn__deleteNews" 
                                            value="{{ $newsItem['id'] ?? '' }}"
                                        >
                                            Delete
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif --}}
            
        </tbody>
    </table>
</div>


<div class="modal fade" id="deleteNews" tabindex="-1" role="dialog" aria-labelledby="deleteNew"
        aria-hidden="true">
    <form action="{{ route('admin.destroyNews') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete News?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">
                <input type="hidden" name="news_delete_id" class="news_id">

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
        $(document).ready(function () {
            $urlData = $('#newsData').val();
            $i = 1;
            $('#newsTable').DataTable({
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
                    { data: 'heading_vn', name: 'heading_vn' },
                    { data: 'heading_en', name: 'heading_en' },
                    { data: 'slug', name: 'slug',searchable: false },
                    { data: 'title_vn', name: 'title_vn',searchable: false },
                    { data: 'title_en', name: 'title_en',searchable: false },
                    { data: 'description_vn', name: 'description_vn',searchable: false },
                    { data: 'description_en', name: 'description_en',searchable: false },
                    {   data: 'image',
                        name: 'image',
                        searchable: false,
                    },
                    { data: 'account_name', name: 'account_name',searchable: false },
                    { data: 'time_display', name: 'time_display',searchable: false },
                    { data: 'action', name: 'action',searchable: false },
                ]
            });


            $(document).on('click','.btn__deleteNews',function (e) {
                e.preventDefault();
                $newsId = $(this).val();
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
                            url: '{{route("admin.destroyNews")}}',
                            data: {id: $newsId},
                            success: function(data){
                                $('#newsTable').DataTable().ajax.reload();
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