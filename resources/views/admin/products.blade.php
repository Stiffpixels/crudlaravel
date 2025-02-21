@extends('layout.app')
    @section('content')
        <div class="container">
            <div>
                <div class="flex justify-between gap-4 items-center">
                    <button type="button" id="product-add-btn" data-bs-toggle="modal" data-bs-target="#product-add-modal" class="user-add-btn btn bg-success text-white border-0">
                        Add product
                    </button>

                    <form>
                        @csrf 
                        <input type="text" name="q" id="product-search" placeholder="Search">
                    </form>
                </div>

                <div class="modal" id="product-add-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <form class="modal-content" method="post" action="{{route('products.add')}}" >
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <label for="product_name">Name</label>
                                    <input id="product_name" class="block mt-1 w-full" type="text" name="name" required autocomplete="category_name" />
                                </div>

                                <div style="max-height:200px;overflow-y:auto;">
                                    <label for="product_category">Category</label>
                                    <select class="form-select" name="category" id="edit-role" aria-label="Role">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <div class="form-floating mt-4">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description"></textarea>
                                        <label for="description" >Description</label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add product</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <table id="product-table" class="table table-striped border">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </thead>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->slug}}</td>

                    <td>
                        <div class="d-flex gap-2">

                            <div>
                                <button type="button" id="{{$product->id}}-edit-btn" data-bs-toggle="modal" data-bs-target="#{{$product->id}}-edit-modal" class="user-edit-btn text-white bg-success border-0">
                                    Edit
                                </button>
                                <div class="modal" id="{{$product->id}}-edit-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="post" action="/dashboard/products/update/{{$product->id}}" >
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <label for="product_name">Name</label>
                                                    <input id="product_name" value="{{$product->name}}" class="block mt-1 w-full" type="text" name="name" required autocomplete="product_name" />
                                                </div>

                                                <div>
                                                    <label for="product_slug">Slug</label>
                                                    <input id="product_slug" value="{{$product->slug}}" class="block mt-1 w-full" type="text" name="slug" required autocomplete="product_slug" />
                                                </div>

                                                <div>
                                                    <label for="product_desc">description</label>
                                                    <input id="product_desc" value="{{$product->description}}" class="block mt-1 w-full" type="text" name="description" required autocomplete="product_desc" />
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
                                <button type="button" id="{{$product->id}}-delete-btn" data-bs-toggle="modal" data-bs-target="#{{$product->id}}-delete-modal" class="user-edit-btn bg-danger text-white border-0">
                                    Delete
                                </button>
                                <div class="modal" id="{{$product->id}}-delete-modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" method="get" action="/dashboard/products/delete/{{$product->id}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>
                                                    Are you sure you want to delete this product?
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

            {{$products->links()}}
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

    @section('css')
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style>
            .datatable-top, .datatable-bottom{
            display:none;
            }
        </style>
    @endsection
    @section('scripts')
        <script>
            const dataTable = new simpleDatatables.DataTable("#product-table")
            const productSearch = document.querySelector("#product-search")

            productSearch.addEventListener("input", searchDebouncer())

            function searchDebouncer(){
                let timerId;
                return function debouncerThenFetch(e){
                    clearTimeout(timerId);
                    timerId = setTimeout(()=>{
                        console.log(e.target.value)
                        location.replace("{{route('products')}}?q=" + e.target.value)
                    },1000)
                }
            }

        </script>
    @endsection