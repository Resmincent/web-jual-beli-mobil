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
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">{{ $vehicle->name }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <!-- Image Carousel -->
                    <div class="col-12">
                        @if($vehicle->image && count($vehicle->getAllImages()) > 0)
                        <div id="vehicleImageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($vehicle->getAllImages() as $index => $image)
                                <button type="button" data-bs-target="#vehicleImageCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded">
                                @foreach($vehicle->getAllImages() as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Vehicle Image {{ $index + 1 }}" style="height: 400px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                            @if(count($vehicle->getAllImages()) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#vehicleImageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            @endif
                        </div>
                        <!-- Thumbnail Navigation -->
                        <div class="d-flex mt-2 overflow-auto">
                            @foreach($vehicle->getAllImages() as $index => $image)
                            <div class="me-2" style="min-width: 100px;">
                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail cursor-pointer" onclick="$('#vehicleImageCarousel').carousel({{ $index }})" alt="Thumbnail {{ $index + 1 }}" style="height: 60px; width: 100px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-warning text-center mb-0" role="alert">
                            <i class="fas fa-image me-2"></i> Gambar kendaraan belum tersedia.
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-industry"></i> Brand
                            </label>
                            <p class="mb-0">{{ $vehicle->brands->name }}</p>
                        </div>
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-car"></i> Model
                            </label>
                            <p class="mb-0">{{ $vehicle->model }}</p>
                        </div>
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-calendar-alt"></i> Tahun
                            </label>
                            <p class="mb-0">{{ $vehicle->year }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-tags"></i> Kategori
                            </label>
                            <p class="mb-0">{{ $vehicle->categories->name }}</p>
                        </div>
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-money-bill-wave"></i> Harga
                            </label>
                            <p class="mb-0">{{ formatRupiah($vehicle->price) }}</p>
                        </div>
                        <div class="info-group mb-3">
                            <label class="text-primary fw-bold mb-1">
                                <i class="fas fa-clock"></i> Tanggal Dibuat
                            </label>
                            <p class="mb-0">{{ $vehicle->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                @if($vehicle->description)
                <div class="mt-4">
                    <label class="text-primary fw-bold mb-2">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </label>
                    <div class="p-3 bg-light rounded">
                        {!! $vehicle->description !!}
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="col-lg-4">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Tambahan</h5>
            </div>
            <div class="card-body">
                <div class="info-group mb-3">
                    <label class="text-primary fw-bold mb-1">
                        <i class="fas fa-tachometer-alt"></i> Jarak Tempuh
                    </label>
                    <p class="mb-0">{{ $vehicle->mileage }}</p>
                </div>
                <div class="info-group mb-3">
                    <label class="text-primary fw-bold mb-1">
                        <i class="fas fa-cog"></i> Transmisi
                    </label>
                    <p class="mb-0">{{ $vehicle->transmition }}</p>
                </div>
                <div class="info-group">
                    <label class="text-primary fw-bold mb-1">
                        <i class="fas fa-clock"></i> Terakhir Diupdate
                    </label>
                    <p class="mb-0">{{ $vehicle->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .info-group label {
        font-size: 0.9rem;
    }

    .info-group p {
        font-size: 1rem;
    }

    .carousel-item img {
        transition: transform .5s ease-in-out;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        background: rgba(0, 0, 0, 0.2);
    }

    .carousel-indicators {
        margin-bottom: 0.5rem;
    }

</style>

<script>
    $(document).ready(function() {
        // Initialize Bootstrap carousel
        var carousel = new bootstrap.Carousel(document.getElementById('vehicleImageCarousel'), {
            interval: 5000
            , wrap: true
        });

        // Prevent image drag
        $('img').on('dragstart', function(event) {
            event.preventDefault();
        });
    });

</script>

@endsection
