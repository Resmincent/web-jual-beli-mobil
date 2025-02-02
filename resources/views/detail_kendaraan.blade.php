@extends('layouts.landing')
@section('main-content')

<div class="container vehicle-detail-page">
    <div class="row">
        <!-- Left Column: Vehicle Details -->
        <div class="col-lg-8">
            <!-- Image Gallery -->
            <section class="vehicle-gallery card mb-4">
                <div class="main-image-container">
                    <img src="{{ Storage::url($vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="main-image" id="mainImage">
                    <div class="category-badge">
                        <i class="fas fa-{{ $vehicle->categories->name == 'Motor' ? 'motorcycle' : 'car' }}"></i>
                        {{ $vehicle->categories->name }}
                    </div>
                </div>
                <div class="image-thumbnails">
                    @foreach ($vehicle->images as $image)
                    <img src="{{ Storage::url($image->image) }}" alt="{{ $vehicle->name }}" class="thumbnail-image" onclick="changeMainImage('{{ Storage::url($image->image) }}')">
                    @endforeach
                </div>
            </section>

            <!-- Vehicle Information -->
            <section class="vehicle-info-section card">
                <div class="card-body">
                    <!-- Header -->
                    <header class="vehicle-header">
                        <h3>Detail</h3>
                    </header>

                    <!-- Key Specifications -->
                    <div class="specifications-grid">
                        @php
                        $specs = [
                        ['icon' => 'calendar-alt', 'label' => 'Tahun', 'value' => $vehicle->year],
                        ['icon' => 'tachometer-alt', 'label' => 'Kilometer', 'value' => $vehicle->mileage ],
                        ['icon' => 'cog', 'label' => 'Transmisi', 'value' => $vehicle->transmition],
                        ['icon' => $vehicle->category_id == 1 ? 'car-side' : 'motorcycle', 'label' => 'Model', 'value' => $vehicle->model],
                        ];
                        @endphp



                        @foreach($specs as $spec)
                        <div class="spec-item">
                            <div class="spec-icon">
                                <i class="fas fa-{{ $spec['icon'] }}"></i>
                            </div>
                            <div class="spec-content">
                                <span class="spec-label">{{ $spec['label'] }}</span>
                                <span class="spec-value">{{ $spec['value'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Description -->
                    <div class="vehicle-description">
                        <h3>Deskripsi</h3>
                        <div class="description-content">
                            {!! $vehicle->description !!}
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Column: Contact & Booking -->
        <div class="col-lg-4">
            <aside class="contact-booking-card card">
                <div class="card-body">
                    <h3 class="vehicle-title">{{ $vehicle->name }}</h3>
                    <div class="price-tag">
                        <span class="amount">{{ FormatRupiah($vehicle->price) }}</span>
                    </div>

                    <div class="booking-actions">
                        @if(auth()->check())
                        <a href="{{ $whatsappUrl }}" class="btn btn-primary btn-lg btn-block">
                            <i class="fab fa-whatsapp"></i> Pesan Sekarang
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block">
                            <i class="fab fa-whatsapp"></i> Pesan Sekarang
                        </a>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        function changeMainImage(imageUrl) {
            document.getElementById('mainImage').src = imageUrl;
        }

    </script>

</div>


@endsection
