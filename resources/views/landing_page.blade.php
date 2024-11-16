@extends('layouts.landing')
@section('main-content')
<div class="container my-5">
    {{-- Hero Section --}}
    <div class="hero-section text-center mb-5 p-5 bg-gradient">
        <h1 class="display-4 text-white mb-3">Temukan Kendaraan Impian Anda</h1>
        <p class="lead text-white-50">Koleksi lengkap mobil dan motor berkualitas dengan harga terbaik</p>
    </div>

    {{-- Semua Kendaraan --}}
    <div id="semua" class="section-wrapper">
        <div class="section-header">
            <h2 class="section-title">Semua Kendaraan</h2>
            <p class="section-subtitle text-center mb-4">Pilihan lengkap kendaraan untuk setiap kebutuhan Anda</p>
        </div>
        <div class="row g-4">
            @forelse ($vehicles as $v)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('order', $v->id) }}" class="text-decoration-none">
                    <div class="vehicle-card">
                        <div class="card-badge">
                            @if($v->categories->name == "Motor")
                            <span class="badge bg-info"><i class="fas fa-motorcycle"></i> Motor</span>
                            @else
                            <span class="badge bg-primary"><i class="fas fa-car"></i> Mobil</span>
                            @endif
                        </div>
                        <div class="card-img-wrapper">
                            <img src="{{ Storage::url($v->thumbnail) }}" alt="{{ $v->name }}">
                        </div>
                        <div class="card-content">
                            <h3 class="vehicle-name">{{ $v->name }}</h3>
                            <div class="vehicle-specs">
                                <span><i class="fas fa-calendar-alt"></i> {{ $v->year }}</span>
                                <span><i class="fas fa-tachometer-alt"></i> {{ $v->mileage }}</span>
                                <span><i class="fas fa-cog"></i> {{ $v->transmition }}</span>
                            </div>
                            <div class="price-tag">
                                {{ FormatRupiah($v->price) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-center ">Tidak ada kendaraan tersedia saat ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Section Mobil --}}
    <div id="mobil" class="section-wrapper mt-5">
        <div class="section-header">
            <h2 class="section-title">Mobil</h2>
            <p class="section-subtitle text-center mb-4">Koleksi mobil terbaik untuk kenyamanan berkendara Anda</p>
        </div>
        <div class="row g-4">
            @forelse ($cars as $v)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('order', $v->id) }}" class="text-decoration-none">
                    <div class="vehicle-card">
                        <div class="card-badge">
                            <span class="badge bg-primary"><i class="fas fa-car"></i> Mobil</span>
                        </div>
                        <div class="card-img-wrapper">
                            <img src="{{ Storage::url($v->thumbnail) }}" alt="{{ $v->name }}">
                        </div>
                        <div class="card-content">
                            <h3 class="vehicle-name">{{ $v->name }}</h3>
                            <div class="vehicle-specs">
                                <span><i class="fas fa-calendar-alt"></i> {{ $v->year }}</span>
                                <span><i class="fas fa-tachometer-alt"></i> {{ $v->mileage }}</span>
                                <span><i class="fas fa-cog"></i> {{ $v->transmition }}</span>
                            </div>
                            <div class="price-tag">
                                {{ FormatRupiah($v->price) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-center">Tidak ada mobil tersedia saat ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Section Motor --}}
    <div id="motor" class="section-wrapper mt-5">
        <div class="section-header">
            <h2 class="section-title">Motor</h2>
            <p class="section-subtitle text-center mb-4">Pilihan motor berkualitas untuk mobilitas yang lebih gesit</p>
        </div>
        <div class="row g-4">
            @forelse ($motorcycles as $v)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('order', $v->id) }}" class="text-decoration-none">
                    <div class="vehicle-card">
                        <div class="card-badge">
                            <span class="badge bg-info"><i class="fas fa-motorcycle"></i> Motor</span>
                        </div>
                        <div class="card-img-wrapper">
                            <img src="{{ Storage::url($v->thumbnail) }}" alt="{{ $v->name }}">
                        </div>
                        <div class="card-content">
                            <h3 class="vehicle-name">{{ $v->name }}</h3>
                            <div class="vehicle-specs">
                                <span><i class="fas fa-calendar-alt"></i> {{ $v->year }}</span>
                                <span><i class="fas fa-tachometer-alt"></i> {{ $v->mileage }}</span>
                                <span><i class="fas fa-cog"></i> {{ $v->transmition }}</span>
                            </div>
                            <div class="price-tag">
                                {{ FormatRupiah($v->price) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-center">Tidak ada motor tersedia saat ini.</p>
            @endforelse
        </div>
    </div>
</div>


<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #0062cc 0%, #1e88e5 100%);
        border-radius: 15px;
        margin-bottom: 3rem;
    }

    /* Navigation Pills */
    .vehicle-nav {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .nav-pills .nav-link {
        color: #495057;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background: #007bff;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.3);
    }

    /* Section Styles */
    .section-wrapper {
        padding: 2rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #007bff, #00c6ff);
        border-radius: 2px;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
    }

    /* Vehicle Card Styles */
    .vehicle-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        height: 400px;
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
    }

    .card-img-wrapper {
        position: relative;
        padding-top: 75%;
        overflow: hidden;
    }

    .card-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .vehicle-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }

    .card-content {
        padding: 1.5rem;
    }

    .vehicle-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        height: 70px;
    }

    .vehicle-specs {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 9px;
        color: #6c757d;
    }

    .vehicle-specs span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .price-tag {
        font-size: 1.3rem;
        font-weight: 700;
        color: #007bff;
        text-align: right;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }

        .vehicle-specs {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

</style>
@endsection
