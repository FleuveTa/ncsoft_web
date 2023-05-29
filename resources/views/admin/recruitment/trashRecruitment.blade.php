@extends('admin/main')
@section('content')


<div class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <h1 class="mx-4">Trash Recruitment</h1>
        {{-- <a href="{{ route('admin.showAddRecruitment') }}" class="btn btn__add">
            Rollback
        </a> --}}
    </div>
</div>



<table class="table table__manage">
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
            {{-- <th scope="col">User Create</th> --}}
            <th scope="col">time display</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($dataTrash))
            @foreach ($dataTrash as $recruimentItem)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $recruimentItem['heading_vn'] ?? '' }}</td>

                        <td>{{ $recruimentItem['heading_en'] ?? '' }}</td>

                        <td>{{ $recruimentItem['slug'] ?? '' }}</td>


                        <td>
                            <p class="three-line-paragraph">
                                {{ $recruimentItem['description_vn'] ?? '' }}
                            </p>
                        </td>

                        <td>
                            <p class="three-line-paragraph">
                                {{ $recruimentItem['description_en'] ?? '' }}
                            </p>
                        </td>


                        <td>{{ $recruimentItem['number_of_people'] ?? '' }}</td>
                        <td>{{ $recruimentItem['salary'] ?? '' }}</td>
                        <td>{{ $recruimentItem['timeout'] ?? '' }}</td>
                        {{-- <td>{{ $recruimentItem['account_name'] ?? '' }}</td> --}}

                        <td>{{ $recruimentItem['time_display'] ?? '' }}</td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button 
                                        class="dropdown-item trash-recruitment-restore" 
                                        {{-- href="{{ route('admin.recruitmentEdit', ['id' => $recruimentItem['id'] ?? '']) }}" --}}
                                        value="{{ $recruimentItem['id'] ?? '' }}"
                                    >
                                        Restore
                                    </button>
                                    <button 
                                        class="dropdown-item btn__delete-trash" 
                                        value="{{ $recruimentItem['id'] ?? '' }}"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-center">No information not found</td>
            </tr>
        @endif
        
    </tbody>
</table>

<div class="modal fade" id="deleteTrash" tabindex="-1" role="dialog" aria-labelledby="deleteTrash"
        aria-hidden="true">
    <form action="{{ route('admin.permanentTrash') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Permanently delete?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

                <input type="hidden" name="recruitment_delete_id" class="recruitment_id">
                
                <div class="modal-body">Do you want to permanently delete this recording?</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" href=>Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="restoreItemTrash" tabindex="-1" role="dialog" aria-labelledby="restoreItemTrash"
        aria-hidden="true">
    <form action="{{ route('admin.restoreTrash') }}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">restore Item Recruitment?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user() && Auth::user()->id ? Auth::user()->id : '' }}">

                <input type="hidden" name="recruitment_restore_id" class="recruitment_id-restore">
                
                <div class="modal-body">Are you sure you want to restore?</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" href=>restore</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.trash-recruitment-restore').click(function (e){
                e.preventDefault();
                $recruitment_id = $(this).val();
                $('.recruitment_id-restore').val($recruitment_id);
                $('#restoreItemTrash').modal('show');
                
                // $.ajax({
                //     type: 'POST',
                //     headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                //     url: "{{ route('admin.restoreTrash') }}",
                //     data: {},
                //     success: function(data) {
                //         $('.demo').text('demo');
                //         $id = setTimeout(() => {
                //             $('.demo').remove();
                //         }, 3000);
                //         // clearTimeout($id);
                //     },
                //     error: function(data) {
                //         console.log(2);
                //     },
                // });
            })

            $('.btn__delete-trash').click(function (e){
                e.preventDefault();
                $recruitment_id = $(this).val();
                $('.recruitment_id').val($recruitment_id);
                $('#deleteTrash').modal('show');
            })

            
        })
    </script>
@endsection