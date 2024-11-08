@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Kendaraan') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-lg-6">
                <form method="GET" action="{{ route('vehicles.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="{{ __('Search vehicles...') }}" value="{{ request()->input('search') }}">
                    <button type="submit" class="btn btn-primary btn-sm">{{ __('Search') }}</button>
                </form>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                <a href="{{ route('vehicles.create') }}" class="btn btn-md btn-primary">
                    Tambah Kendaraan
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3">
                <label for="startDate">Start Date</label>
                <div class="form-group">
                    <input type="date" name="start_date" class="form-control form-control-sm" id="startDate" value="{{ request()->input('start_date') }}">
                </div>
            </div>
            <div class="col-lg-3">
                <label for="endDate">End Date</label>
                <div class="form-group">
                    <input type="date" name="end_date" class="form-control form-control-sm" id="endDate" placeholder="End Date" value="{{ request()->input('end_date') }}">
                </div>
            </div>
        </div>

        <div class="table-responsive table-responsive-sm">
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                        <th class="min-w-100px">Nama</th>
                        <th class="min-w-100px">Brand</th>
                        <th class="min-w-100px">Model</th>
                        <th class="min-w-100px">Kategori</th>
                        <th class="min-w-100px">Tahun</th>
                        <th class="min-w-100px">Harga</th>
                        <th class="min-w-100px">Tanggal Dibuat</th>
                        <th class="min-w-100px">Aksi</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->title }}</td>
                        <td>{{ $vehicle->brand->name }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->category->name }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ number_format($vehicle->price, 0, ',', '.') }}</td>
                        <td>{{ $vehicle->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination justify-content-center mb-10">
        {{ $vehicles->appends(['search' => request()->input('search'), 'start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')])->links() }}
    </div>

</div>
@endsection
