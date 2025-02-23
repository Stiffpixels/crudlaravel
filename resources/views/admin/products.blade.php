@extends('layout.app')

@section('content')
<div class="container">
    <div class="my-2">
        <button type="button" id="product-add-btn" data-bs-toggle="modal" data-bs-target="#product-add-modal"
            class="user-add-btn btn bg-success text-white border-0">
            Add product
        </button>
    </div>
    <table class="table table-bordered" id="table" style="width:100%;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<div class="modal edit-modal" id="edit-modal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-floating mb-3">
                    <input class="form-control" id="edit-name" type="text" placeholder="name" name="name" />
                    <label for="edit-name">Name: </label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control" id="edit-slug" type="text" placeholder="slug" name="slug" />
                    <label for="edit-slug">Slug: </label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="product-add-modal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="{{route('products.add')}}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div>
                    <label for="product_name">Name</label>
                    <input id="product_name" class="block mt-1 w-full" type="text" name="name" required
                        autocomplete="category_name" />
                </div>

                <div style="max-height:200px;overflow:auto;">
                    <label for="product_category">Category</label>
                    <select class="form-select" name="category" id="edit-role" aria-label="Role">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div class="form-floating mt-4">
                        <textarea class="form-control" placeholder="Leave a comment here" id="description"
                            name="description"></textarea>
                        <label for="description">Description</label>
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

<div class="modal" id="delete-modal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="get" action="">
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

@if (session('success'))
    <div class="position-fixed bottom-0 end-0 p-3">
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-success">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
<div class="toast-container">
    @foreach ($errors->all() as $error)
    <div class="position-fixed bottom-0 end-0 p-3">
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-danger">Error</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ $error }}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>

    DataTable.ext.errMode = 'throw';
    new DataTable('#table', {
        serverSide: true,
        responsive: true,
        processing: true,
        ajax: {
            url: '{{ route('products.datatable') }}',
            error: () => location.replace("/login")
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {
                data: null, render: function (data) {
                    return (`
                        <button type="button" class="btn btn-success edit-btn" onclick="${getEditHandleFunctionString(data.id, data.name, data.slug)}" >Edit</button>
                        <button type="button" class="btn btn-danger delete-btn" onclick="${`handleDeleteButtonClick('${data.id}')`}" >Delete</button>
                    `)
                },
                targets: -1,
                orderable: false,
            }
        ],
    });

    function handleEditButtonClick(id, name, slug) {
        const modalEl = document.getElementById("edit-modal")

        const form = modalEl.querySelector("form")
        const nameField = form.querySelector("#edit-name")
        const slugField = form.querySelector("#edit-slug")

        form.action = "{{route('products')}}/update/" + id
        nameField.value = name
        slugField.value = slug

        const modal = new bootstrap.Modal(modalEl)
        modal.show()
    }

    function handleDeleteButtonClick(id) {
        const modalEl = document.getElementById("delete-modal")

        const form = modalEl.querySelector("form")
        form.action = "{{route('products')}}/delete/" + id

        const modal = new bootstrap.Modal(modalEl)
        modal.show()
    }

    function getEditHandleFunctionString(id, name, slug) {
        const editString = `handleEditButtonClick('${id}','${name}', '${slug}')`
        return editString;
    }

    document.querySelector("#table")?.addEventListener('dt-error.dt', () => {
        location.replace("/login");
    });

</script>
@endsection
