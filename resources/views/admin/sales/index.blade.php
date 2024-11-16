@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Penjualan') }}</h1>

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
        <!-- Form Filter -->
        <form method="GET" action="{{ route('sales.index') }}">
            <div class="row mb-4">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Cari Nama Pembeli/Kendaraan...') }}" value="{{ request()->input('search') }}">
                </div>
                <div class="col-lg-2">
                    <input type="date" name="start_date" class="form-control form-control-sm" placeholder="Tanggal Awal" value="{{ request()->input('start_date') }}">
                </div>
                <div class="col-lg-2">
                    <input type="date" name="end_date" class="form-control form-control-sm" placeholder="Tanggal Akhir" value="{{ request()->input('end_date') }}">
                </div>
                <div class="col-lg-2 d-flex">
                    <button type="submit" class="btn btn-info btn-sm" style="width: 125px">{{ __('Cari') }}</button>
                </div>
                <div class="col-lg-2 d-flex justify-content-end">
                    <a href="{{ route('sales.create') }}" class="btn btn-md btn-primary">
                        Tambah Data
                    </a>
                </div>
            </div>
        </form>

        <div class="row m-2">
            <a href="{{ route('sales.export') }}" class="d-none d-sm-inline-block btn btn-md btn-success shadow-sm">
                <i class="fas fa-file-excel fa-md text-white-50 mr-2"></i>Export ke Excel
            </a>
        </div>

        <!-- Tabel Penjualan -->
        <div class="table-responsive table-responsive-sm">
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                        <th class="min-w-100px">Kendaraan</th>
                        <th class="min-w-100px">Pembeli</th>
                        <th class="min-w-100px">Harga Penjualan</th>
                        <th class="min-w-100px">Tanggal Penjualan</th>
                        <th class="min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($sales as $sale)
                    <tr>
                        <td>{{ $sale->vehicle->name ?? 'Tidak ada data' }}</td>
                        <td>{{ $sale->buyer_name }}</td>
                        <td>{{ formatRupiah($sale->sale_price, 0, ',', '.') }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination justify-content-center mb-10">
        {{ $sales->appends(['search' => request()->input('search'), 'start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')])->links() }}
    </div>
</div>
@endsection
