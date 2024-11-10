@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800">{{ __('Detail Kendaraan') }}</h1>
    <a href="{{ route('vehicles.index') }}" class="btn btn-primary shadow-sm" style="display: inline-flex; align-items: center;">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Vehicle Details -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-lg border-0 rounded-lg" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                <h4>{{ $vehicle->name }}</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-industry text-primary"></i> <strong>Brand:</strong> {{ $vehicle->brands->name }}
                    </li>
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-car text-primary"></i> <strong>Model:</strong> {{ $vehicle->model }}
                    </li>
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-calendar-alt text-primary"></i> <strong>Tahun:</strong> {{ $vehicle->year }}
                    </li>
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-tags text-primary"></i> <strong>Kategori:</strong> {{ $vehicle->categories->name }}
                    </li>
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-money-bill-wave text-primary"></i> <strong>Harga:</strong> {{ formatRupiah($vehicle->price) }}
                    </li>
                    <li class="list-group-item" style="font-size: 16px; font-weight: 500;">
                        <i class="fas fa-clock text-primary"></i> <strong>Tanggal Dibuat:</strong> {{ $vehicle->created_at->format('d M Y') }}
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-outline-warning btn-sm mx-1" style="color: #ffc107; transition: color 0.3s ease, background-color 0.3s ease;" onmouseover="this.style.color='white'; this.style.backgroundColor='#ffc107';" onmouseout="this.style.color='#ffc107'; this.style.backgroundColor='';">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm mx-1" style="color: #dc3545; transition: color 0.3s ease, background-color 0.3s ease;" onmouseover="this.style.color='white'; this.style.backgroundColor='#dc3545';" onmouseout="this.style.color='#dc3545'; this.style.backgroundColor='';">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Vehicle Image -->
    <div class="col-lg-4 mb-4">
        @if($vehicle->image)
        <div class="card shadow-lg border-0 rounded-lg" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
            <img src="{{ Storage::url($vehicle->image) }}" class="img-fluid rounded-top" alt="{{ $vehicle->name }}" style="max-height: 350px; object-fit: cover; width: 100%; object-position: center;">
            <div class="card-footer text-center text-muted">Gambar Kendaraan</div>
        </div>
        @else
        <div class="alert alert-warning text-center" role="alert" style="font-size: 16px;">
            Gambar kendaraan belum tersedia.
        </div>
        @endif
    </div>
</div>
@endsection
