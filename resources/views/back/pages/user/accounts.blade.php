@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30 shadow-lg">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Account List</h4>
                    </div>
                    <div class="pull-right">
                        @if ($role)
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAccount">
                                Add Account
                            </button>
                        @endif
                    </div>
                    <!-- Modal for Adding Account -->
                    <div class="modal fade" id="addAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.store-account') }}" method="post" enctype="multipart/form-data" class="mt-3">
                                        @csrf
                                        @method('post')
                                        <!-- Form Fields for Adding Account -->
                                        <div class="form-group row">
                                            <div class="col-md-6 pt-0">
                                                <label for="name" class="text-muted">Name</label>
                                                <input type="text" class="form-control form-control-sm text-muted" id="name" name="name" required>
                                                @error('name')
                                                    <span class="text-danger ml-2">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 pt-0">
                                                <label for="password" class="text-muted">Password</label>
                                                <input type="text" class="form-control form-control-sm text-muted" id="password" name="password" required>
                                                @error('password')
                                                    <span class="text-danger ml-2">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6 pt-0">
                                                <label for="username" class="text-muted">Email/Username</label>
                                                <input type="email" class="form-control form-control-sm text-muted" id="username" name="username" required>
                                                @error('username')
                                                    <span class="text-danger ml-2">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 pt-0">
                                                <label for="role" class="text-muted">Role</label>
                                                <select class="form-control form-control-sm form-select text-muted" name="role" id="role" required>
                                                    <option value="">--Select--</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="staff">Staff</option>
                                                </select>
                                                @error('role')
                                                    <span class="text-danger ml-2">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer border-blue">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Flash Message Using SweetAlert -->
                    @if (session('actionMessage'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                Swal.fire({
                                    title: '{{ session("color") === "success" ? "Success!" : "Error!" }}',
                                    text: '{{ session("actionMessage") }}',
                                    icon: '{{ session("color") === "success" ? "success" : "error" }}',
                                    confirmButtonText: 'OK'
                                });
                            });
                        </script>
                    @endif

                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-sm table-borderless table-striped p-1">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="text-nowrap px-0"> No. </th>
                                <th class="text-nowrap px-0"> Username </th>
                                <th class="text-nowrap px-0"> Name </th>
                                <th class="text-nowrap px-0"> Role </th>
                                <th class="text-nowrap px-0"> Date Added </th>
                                @if ($role)
                                    <th class="text-nowrap px-0 text-center"> Action </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($accounts as $account)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $account->username }}</td>
                                    <td class="text-nowrap">{{ $account->name }}</td>
                                    <td class="text-nowrap">{{ $account->role }}</td>
                                    <td class="text-nowrap">{{ $account->date_created }}</td>
                                    @if ($role)
                                        <td class="d-flex justify-content-center p-1">
                                            <!-- Update button -->
                                            <!-- Update button -->
                                            <button type="button" class="btn btn-info btn-sm btn-update" 
                                                    data-username="{{ $account->username }}" 
                                                    data-name="{{ $account->name }}" 
                                                    data-password="{{ $account->password }}" 
                                                    data-email="{{ $account->username }}" 
                                                    data-role="{{ $account->role }}" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#updateAccountModal">
                                                <i class="fa fa-pencil"></i>
                                            </button>

                                            <!-- Delete button -->
                                            <button type="button" class="btn btn-danger btn-sm btn-delete ml-2" data-id="{{ $account->username }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $account->username }}" action="{{ route('admin.delete-account') }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('post')
                                                <input type="hidden" name="username" value="{{ $account->username }}" >
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Updating Account -->
    <div class="modal fade" id="updateAccountModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateAccountForm" action="{{ route('admin.update-account') }}" method="post" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        @method('post')
                        <!-- Form Fields for Updating Account -->
                        <input type="hidden" id="update_username" name="username">
                        <div class="form-group row">
                            <div class="col-md-6 pt-0">
                                <label for="update_name" class="text-muted">Name</label>
                                <input type="text" class="form-control form-control-sm text-muted" id="update_name" name="name" required>
                                @error('name')
                                    <span class="text-danger ml-2">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 pt-0">
                                <label for="update_role" class="text-muted">Role</label>
                                <select class="form-control form-control-sm form-select text-muted" name="role" id="update_role" required>
                                    <option value="">--Select--</option>
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                </select>
                                @error('role')
                                    <span class="text-danger ml-2">{{$message}}</span>
                                @enderror
                            </div>
                            <input type="hidden" class="form-control form-control-sm text-muted" id="update_email" name="username" required>
                        </div>
                        <div class="modal-footer border-blue">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateButtons = document.querySelectorAll('.btn-update');
        updateButtons.forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('update_username').value = this.getAttribute('data-username');
                document.getElementById('update_name').value = this.getAttribute('data-name');
                // document.getElementById('update_password').value = this.getAttribute('data-password');
                document.getElementById('update_email').value = this.getAttribute('data-email');
                document.getElementById('update_role').value = this.getAttribute('data-role');
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const accountId = this.getAttribute('data-id');
                Swal.fire({
                    title: "Delete Account?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + accountId).submit();
                    }
                });
            });
        });
    });

</script>
