@extends('admin/main')
@section('content')
<div class="d-flex align-items-center">
    <h1 class="mx-4">Banner</h1>
    <a href="{{ route('admin.showAddBanner') }}" class="btn btn__add">
        Add New Banner
    </a>
</div>
<div class="table-responsive">
    <input hidden value="{{ route('admin.getDataBanner') }}" id="bannerData">

    
    <table class="table table__manage" id = "bannerTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title VN</th>
                <th scope="col">Title EN</th>
                <th scope="col ">Description VN</th>
                <th scope="col">Description EN</th>
                <th scope="col">Image</th>
                <th scope="col">User Create</th>
                <th scope="col">Title Button VN</th>
                <th scope="col">Title Button EN</th>
                <th scope="col">order</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @if (!empty($dataBanner))
                @foreach ($dataBanner as $BannerItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $BannerItem['title_vn'] ?? '' }}</td>
                        <td>{{ $BannerItem['title_en'] ?? '' }}</td>
                        <td>
                            <p class="three-line-paragraph">{{ $BannerItem['description_vn'] ?? '' }}</p>
                        </td>
                        <td>
                            <p class="three-line-paragraph">{{ $BannerItem['description_en'] ?? '' }}</p>
                        </td>

                        <td class="table__img">
                            @php
                                $imageBanner = $BannerItem['image']??''
                            @endphp
                            @if ($imageBanner != '')
                                <img src='{{ url("images/$imageBanner") }}' alt="">
                            @endif
                        </td>

                        <td>{{ $BannerItem['account_name'] ?? '' }}</td>

                        <td>{{ $BannerItem['button_name_vn'] ?? '' }}</td>

                        <td>{{ $BannerItem['button_name_en'] ?? '' }}</td>

                        <td>{{ $BannerItem['order'] ?? '' }}</td>

                        <td class="table__status text-center">

                            <p class="{{ $BannerItem['status'] ==0?'status__lookup': 'status__nolook' }}">
                                {{$BannerItem && $BannerItem['status'] == 0 ? 'Active' : 'Inactive' }}
                            </p>

                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.bannerEdit', ['id' => $BannerItem['id'] ?? '']) }}">Edit</a>
                                    <button class="dropdown-item btn__deleteBanner" value="{{ $BannerItem['id'] ?? '' }}">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <p>Không có kết quả hiển thị</p>
            @endif --}}
        <div class="modal fade" id="deleteBanner" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
                aria-hidden="true">
            <form action="{{ route('admin.destroyBanner') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Banner?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <input type="hidden" name="Banner_delete_id" class="Banner_id">
                        <div class="modal-body">Are you sure you want to delete?</div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" href=>Delete</button>
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
        $(function () {
            $urlData = $('#bannerData').val();
            $('#bannerTable').DataTable({
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
                    { data: 'title_vn', name: 'title_vn' },
                    { data: 'title_en', name: 'title_en' },
                    { data: 'description_vn', name: 'description_vn',searchable: false },
                    { data: 'description_en', name: 'description_en',searchable: false },
                    {   data: 'image',
                        name: 'image',
                        searchable: false,
                    },
                    { data: 'account_name', name: 'account_name',searchable: false },
                    { data: 'button_name_vn', name: 'button_name_vn',searchable: false },
                    { data: 'button_name_en', name: 'button_name_en',searchable: false },
                    { data: 'order', name: 'order',searchable: false },
                    { data: 'status', name: 'status',searchable: false },
                    { data: 'action', name: 'action',searchable: false },
                ]
            });


            // delete Banner

            $(document).on('click','.btn__deleteBanner',function (e) {
                e.preventDefault();
                $bannerId = $(this).val();
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
                            url: '{{route("admin.destroyBanner")}}',
                            data: {id: $bannerId},
                            success: function(data){
                                $('#bannerTable').DataTable().ajax.reload();
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
                                if($status == 3 || $status == 4){
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


            //end delete banner
        });
    </script>
@endsection
