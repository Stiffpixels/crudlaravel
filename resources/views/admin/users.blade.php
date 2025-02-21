@extends('layout.app')
    @section('content')
        <div class="container">
            <div>
                <button type="button" id="user-add-btn" data-bs-toggle="modal" data-bs-target="#user-add-modal" class="user-add-btn btn bg-success text-white border-0">
                    Add User
                </button>

                <div class="modal" id="user-add-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="post" action="{{route('users.add')}}" >
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <label for="username">Username</label>
                                    <input id="username" class="block mt-1 w-full" type="text" name="username" required autocomplete="username" />
                                </div>

                                <div>
                                    <label for="email" >Email</label>
                                    <input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="email" />
                                </div>

                                <div>
                                    <label for="password" >Password</label>
                                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="password" />
                                </div>

                                <div>
                                    <label for="password_confirmation" >Confirm Password</label>
                                    <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="password_confirmation" />
                                </div>

                                <div>
                                    <label for="role">Role</label>
                                    <select class="form-select" name="role" id="edit-role" aria-label="Role">
                                            <option value="user" selected>user</option>
                                            <option value="admin">admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <table id="user-table" class="table table-striped border">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </thead>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>

                    <td>
                        <div class="d-flex gap-2">

                            <div>
                                <button type="button" id="{{$user->id}}-edit-btn" data-bs-toggle="modal" data-bs-target="#{{$user->id}}-edit-modal" class="user-edit-btn text-white bg-success border-0">
                                    Edit
                                </button>
                                <div class="modal" id="{{$user->id}}-edit-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="post" action="/dashboard/users/update/{{$user->id}}" >
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <label for="username">Username</label>
                                                    <input id="username" value="{{$user->username}}" class="block mt-1 w-full" type="username" name="username" required autocomplete="username" />
                                                </div>
                                                <div>
                                                    <label for="email" >Email</label>
                                                    <input id="email" value="{{$user->email}}" class="block mt-1 w-full" type="email" name="email" required autocomplete="email" />
                                                </div>
                                                <div>
                                                    <label for="role">Role</label>
                                                    <select class="form-select" name="role" id="edit-role" aria-label="Role">
                                                        <option value="{{$user->role}}" selected>{{$user->role}}</option>
                                                        @if ($user->role==="user")
                                                            <option value="admin">admin</option>
                                                        @else
                                                            <option value="user">user</option>
                                                        @endif
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="button" id="{{$user->id}}-delete-btn" data-bs-toggle="modal" data-bs-target="#{{$user->id}}-delete-modal" class="user-edit-btn bg-danger text-white border-0">
                                    Delete
                                </button>
                                <div class="modal" id="{{$user->id}}-delete-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="get" action="/dashboard/users/delete/{{$user->id}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title btn btn-success">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>
                                                    Are you sure you want to delete this user?
                                                </h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endsection

    @section('scripts')
        <script>
            const dataTable = new simpleDatatables.DataTable("#user-table")

            function getUserEditModal (id, username, email, role){
                return `
                <div class="modal" id="${id}-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="PUT" action="/user/${id}" >
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <label for="username">Username</label>
                                    <input id="username" class="block mt-1 w-full" type="username" name="username" required autocomplete="username" />
                                </div>
                                <div>
                                    <label for="email" >Email</label>
                                    <input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="email" />
                                </div>
                                <div>
                                    <label for="role">Role</label>
                                    <input id="role" class="block mt-1 w-full" type="role" name="role" required autocomplete="role" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                `
            }
        </script>
    @endsection