@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Merek Kendaraan') }}</h1>

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
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <form method="GET" action="{{ route('brands.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="{{ __('Cari Merek...') }}" value="{{ request()->input('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm">{{ __('Cari') }}</button>
                        </form>
                    </div>
                    <div class="col-lg-2 d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary w-100" data-toggle="modal" data-target="#tambahBrand">
                            Tambah Merek
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                                <th class="min-w-100px">Cover</th>
                                <th class="min-w-100px">Brand</th>
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($brands as $brand)
                            <tr>
                                <td>
                                    <img src="{{ Storage::url($brand->cover) }}" alt="{{ $brand->name }}" width="80">
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editBrand-{{ $brand->id }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteBrand-{{ $brand->id }}">Hapus</button>
                                </td>
                            </tr>
                            @include('admin.brand.modal.edit-modal', ['brand' => $brand])
                            @include('admin.brand.modal.delete-modal', ['brand' => $brand])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination justify-content-center mb-10">
                {{ $brands->appends(['search' => request()->input('search')])->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahBrand" tabindex="-1" role="dialog" aria-labelledby="tambahBrandLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBrandLabel">Tambah Merek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Brand</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="form-label d-block">Kategori</label>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input name="category_id" class="form-check-input @error('category_id') is-invalid @enderror" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category_id') == $category->id ? 'checked' : '' }} required>
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="cover">Cover</label>
                        <input type="file" class="form-control" id="cover" name="cover" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
