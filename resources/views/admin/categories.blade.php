@extends('layout.app')
    @section('content')
        <div class="container">
            <div>
                <button type="button" id="category-add-btn" data-bs-toggle="modal" data-bs-target="#category-add-modal" class="user-add-btn btn bg-success text-white border-0">
                    Add Category
                </button>

                <div class="modal" id="category-add-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="post" action="{{route('categories.add')}}" >
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <label for="category_name">Name</label>
                                    <input id="category_name" class="block mt-1 w-full" type="text" name="name" required autocomplete="name" />
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <table id="category-table" class="table table-striped border">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </thead>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>

                    <td>
                        <div class="d-flex gap-2">

                            <div>
                                <button type="button" id="{{$category->id}}-edit-btn" data-bs-toggle="modal" data-bs-target="#{{$category->id}}-edit-modal" class="user-edit-btn text-white bg-success border-0">
                                    Edit
                                </button>
                                <div class="modal" id="{{$category->id}}-edit-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="post" action="/dashboard/categories/update/{{$category->id}}" >
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <label for="category_name">Name</label>
                                                    <input id="category_name" value="{{$category->name}}" class="block mt-1 w-full" type="text" name="name" required autocomplete="category_name" />
                                                </div>

                                                <div>
                                                    <label for="category_slug">Slug</label>
                                                    <input id="category_slug" value="{{$category->slug}}" class="block mt-1 w-full" type="text" name="slug" required autocomplete="category_slug" />
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
                                <button type="button" id="{{$category->id}}-delete-btn" data-bs-toggle="modal" data-bs-target="#{{$category->id}}-delete-modal" class="user-edit-btn bg-danger text-white border-0">
                                    Delete
                                </button>
                                <div class="modal" id="{{$category->id}}-delete-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="get" action="/dashboard/categories/delete/{{$category->id}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title ">Delete Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>
                                                    Are you sure you want to delete this category?
                                                </h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
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
            const dataTable = new simpleDatatables.DataTable("#category-table", {
                searchable:true
            })
        </script>
    @endsection