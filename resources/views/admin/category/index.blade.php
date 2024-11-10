@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Kategori') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert" id="autoDismissAlert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert" id="autoDismissError">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-lg-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <form method="GET" action="{{ route('categories.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="{{ __('Cari Merek...') }}" value="{{ request()->input('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm">{{ __('Cari') }}</button>
                        </form>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary w-100" data-toggle="modal" data-target="#tambahCategory">
                            Tambah Kategori
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                                <th class="min-w-100px">Kategori</th>
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editCategory-{{ $category->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteCategory-{{ $category->id }}">Hapus</button>
                                </td>
                            </tr>
                            @include('admin.category.modal.edit-modal', ['category' => $category])
                            @include('admin.category.modal.create-modal', ['category' => $category])
                            @include('admin.category.modal.delete-modal', ['category' => $category])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination justify-content-center mb-10">
                {{ $categories->appends(['search' => request()->input('search')])->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Brand -->

@endsection
