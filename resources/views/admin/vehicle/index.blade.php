@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Kendaraan') }}</h1>

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

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('vehicles.index') }}">
            <div class="row mb-4">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search vehicles...') }}" value="{{ request()->input('search') }}">
                </div>
                <div class="col-lg-2">
                    <input type="date" name="start_date" class="form-control form-control-sm" placeholder="Start Date" value="{{ request()->input('start_date') }}">
                </div>
                <div class="col-lg-2">
                    <input type="date" name="end_date" class="form-control form-control-sm" placeholder="End Date" value="{{ request()->input('end_date') }}">
                </div>
                <div class="col-lg-2 d-flex">
                    <button type="submit" class="btn btn-info btn-sm" style="width: 125px">{{ __('Search') }}</button>
                </div>
                <div class="col-lg-2 d-flex justify-content-end">
                    <a href="{{ route('vehicles.create') }}" class="btn btn-md btn-primary">
                        Tambah Kendaraan
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive table-responsive-sm">
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                        <th class="min-w-100px">Nama</th>
                        <th class="min-w-100px">Brand</th>
                        <th class="min-w-100px">Model</th>
                        <th class="min-w-100px">Tahun</th>
                        <th class="min-w-100px">Harga</th>
                        <th class="min-w-100px">Tanggal Dibuat</th>
                        <th class="min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->name }}</td>
                        <td>{{ $vehicle->brands->name }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ FormatRupiah($vehicle->price) }}</td>
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
