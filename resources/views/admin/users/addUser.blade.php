@extends('admin/main')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Manager Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Users</li>
        </ol>
    </nav>

    <h2>Add New User</h2>
    <p>Create a brand new user and add them to this site.</p>
        <form 
            action="{{ route('admin.addUser') }}" 
            method="POST" 
            enctype="multipart/form-data" 
            id="form-add-user"
        >
            @csrf
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="account_name">Account Name <span class="field__require">*</span></label>
                    <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Account" required>
                    <span class="text-danger error-text account_name_error"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="password">Password <span class="field__require">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <span class="text-danger error-text password_error"></span>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="first_name">first Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first Name">
                    <span class="text-danger error-text first_name_error"></span>
                </div>
            </div>
            
    
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                    <span class="text-danger error-text last_name_error"></span>
                </div>
        
                <div class="form-group col-md-7">
                    <label for="email">Email <span class="field__require">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Last Name" required>
                    <span class="text-danger error-text email_error"></span>
                </div>
            </div>
    
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Last Name">
                <span class="text-danger error-text address_error"></span>
            </div>
           

            <div class="form-group">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="formFile">
                <span class="text-danger error-text image_error"></span>
            </div>
            <div class="form-group">
                <label for="status">Status User</label>
                <select class="form-control" id="status" name="status">
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                </select>
                <span class="text-danger error-text status_error"></span>
            </div>
            <div class="form-group">
                <label for="role">Role User</label>
                <select class="form-control" id="role" name="role">
                        @if (!empty($role))
                            @foreach ($role as $key => $roleItem)
                                <option value="{{ $key }}">{{ $roleItem }}</option>
                            @endforeach
                        @endif
                </select>
                <span class="text-danger error-text role_error"></span>

            </div>
            <button type="submit" class="btn btn__add btn__add-user">Add New User</button>
        </form>
@endsection

@section('script')
    <script type="text/javascript">

        // const formData = new FormData(document.getElementById('form-add-user'));
        // formData.append('parameters', 'demo');

        // for (const entry of formData.entries())
        // {
        //     document.write(entry);
        // }
         $(function () {
            $(document).on('submit', '#form-add-user', function (e) {

                e.preventDefault();
                const formData = new FormData(document.getElementById('form-add-user'));

                $url = $(this).attr('action');

                Swal.fire({
                title: 'do you want create new user?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Create',
                denyButtonText: `Don't create`,
                }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
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
                                    $('#form-add-user')[0].reset();
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
                            if($status == 1) {
                                    Swal.fire(
                                        'fail!',
                                        $message,
                                        'error'
                                    );
                                }
                        }
                    });

                } else if (result.isDenied) {

                    Swal.fire('New creation failed', '', 'info')
                }
                })
            });
        });
    </script>
@endsection