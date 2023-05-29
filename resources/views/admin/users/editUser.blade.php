@extends('admin/main')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Manager Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Users</li>
        </ol>
    </nav>

    <h2>Edit User</h2>
    {{-- <p>Create a brand new user and add them to this site.</p> --}}
       @if (!empty($dataOnlyUser))
            <form
                action="{{ route('admin.patchUser', ['id' => $dataOnlyUser['id']]) }}"
                method="POST"
                enctype="multipart/form-data"
                id="form-user-edit"
            >
                @csrf

                <div class="form-group">
                    <label for="account_name">Account Name<span class="field__require">*</span></label>
                    <input
                        readonly
                        type="text"
                        class="form-control"
                        value="{{ $dataOnlyUser['account_name'] }}"
                        name="account_name"
                        id="account_name"
                        placeholder="Account"
                        required
                    >
                    <span class="text-danger error-text account_name_error"></span>
                </div>
                <div class="form-group">
                    <label for="first_name">first Name</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $dataOnlyUser['first_name'] }}"
                        name="first_name"
                        id="first_name"
                        placeholder="first Name"
                    >
                    <span class="text-danger error-text first_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $dataOnlyUser['last_name'] }}"
                        name="last_name"
                        id="last_name"
                        placeholder="Last Name"
                    >
                    <span class="text-danger error-text last_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="field__require">*</span></label>
                    <input
                        readonly
                        type="email"
                        class="form-control"
                        value="{{ $dataOnlyUser['email']}}"
                        name="email"
                        id="email"
                        placeholder="Last Name"
                        required
                    >
                    <span class="text-danger error-text email_error"></span>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $dataOnlyUser['address']  }}"
                        name="address"
                        id="address"
                        placeholder="Last Name"
                    >
                    <span class="text-danger error-text address_error"></span>
                </div>
                <div class="img__preview">
                    @php
                        $imageUser = $dataOnlyUser['image'];
                    @endphp
                    <img src='{{ url("images/users/$imageUser") }}' value = "$imageUser" class="img-fluid image__preview-old" alt="img user">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input
                        class="form-control"
                        value="{{ $imageUser  }}"
                        type="file"
                        name="image"
                        id="formFile"
                    >
                    <span class="text-danger error-text image_error"></span>
                </div>
                <div class="form-group">
                    <label for="status">Status User</label>
                    <select class="form-control" id="status" name="status">
                            <option
                                value="0"
                                {{ $dataOnlyUser['status']==0? 'selected':'' }}
                            >
                                Active
                            </option>
                            <option
                                value="1"
                                {{ $dataOnlyUser['status']==1? 'selected':'' }}
                            >
                                Inactive
                            </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="role">Role User</label>
                    <select class="form-control" id="role" name="role">
                            @if (!empty($role))
                                @foreach ($role as $key => $roleItem)
                                    <option
                                        value="{{ $key }}"
                                        {{ $dataOnlyUser['role']==$key? 'selected':'' }}
                                    >
                                        {{ $roleItem }}
                                    </option>
                                @endforeach
                            @endif
                    </select>
                </div>

                    <div class="permision mb-5">
                        <p>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Permistion
                            </a>
                        </p>
                        <div class="collapse " id="collapseExample">
                            <div class="card card-body">
                                @if (!empty($permissionModel))
                                    @foreach ($permissionModel as $key => $itemPermission)
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                name="permission[]"
                                                type="checkbox"
                                                value="{{ $key }}"
                                                id="persision-{{ $key }}"
                                                {{ isset($dataOnlyUser['permission']) && isset($dataOnlyUser['permission'][$key]) && $dataOnlyUser['permission'][$key] == $key ?  'checked' :''}}
                                            >
                                            <label class="form-check-label" for="persision-{{ $key }}">
                                                    {{ $itemPermission }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                <button type="submit" class="btn btn__add btn__edit-user">Edit User</button>
            </form>
       @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('submit', '#form-user-edit', function (e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('form-user-edit'));

            $url = $(this).attr('action');
            $imageOld = $('.image__preview-old').val();
            formData.append('imageOld', $imageOld);
            console.log($imageOld);
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
                        if($status == 4 || $status == 3){
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
    </script>
@endsection
