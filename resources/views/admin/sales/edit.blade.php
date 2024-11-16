@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Penjualan</h1>
        <a href="{{ route('sales.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i>Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h6>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Penjualan Kendaraan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sales.update', $sale) }}" method="POST" id="saleForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="vehicle_id" class="form-label font-weight-bold">Kendaraan <span class="text-danger">*</span></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-select form-control" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" data-price="{{ $vehicle->price }}" {{ $sale->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->name }} - {{ $vehicle->year }} ({{ $vehicle->brands->name }})
                                </option>
                                @endforeach
                            </select>
                            <div id="vehicleInfo" class="mt-2 small text-muted {{ $sale->vehicle ? '' : 'd-none' }}">
                                Harga Dasar: <span id="basePrice" class="font-weight-bold">
                                    {{ $sale->vehicle ? number_format($sale->vehicle->price, 0, ',', '.') : '' }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="sale_price" class="form-label font-weight-bold">Harga Penjualan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ $sale->sale_price }}" required>
                            </div>
                            <div id="priceWarning" class="small text-danger d-none">
                                Harga penjualan lebih rendah dari harga dasar!
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="buyer_name" class="form-label font-weight-bold">Nama Pembeli <span class="text-danger">*</span></label>
                            <input type="text" name="buyer_name" id="buyer_name" class="form-control" value="{{ $sale->buyer_name }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="sale_date" class="form-label font-weight-bold">Tanggal Penjualan <span class="text-danger">*</span></label>
                            <input type="date" name="sale_date" id="sale_date" class="form-control" value="{{ $sale->sale_date }}" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr class="mt-2 mb-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Update Penjualan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .gap-2 {
        gap: 0.5rem;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vehicleSelect = document.getElementById('vehicle_id');
        const salePrice = document.getElementById('sale_price');
        const vehicleInfo = document.getElementById('vehicleInfo');
        const basePrice = document.getElementById('basePrice');
        const priceWarning = document.getElementById('priceWarning');

        // Format number to currency
        function formatCurrency(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency'
                , currency: 'IDR'
                , minimumFractionDigits: 0
                , maximumFractionDigits: 0
            }).format(number);
        }

        // Show initial price warning if needed
        function checkInitialPrice() {
            const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
            const basePrice = selectedOption.dataset.price;

            if (basePrice && salePrice.value) {
                if (parseInt(salePrice.value) < parseInt(basePrice)) {
                    priceWarning.classList.remove('d-none');
                } else {
                    priceWarning.classList.add('d-none');
                }
            }
        }

        // Run initial price check
        checkInitialPrice();

        // Handle vehicle selection
        vehicleSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.dataset.price;

            if (price) {
                vehicleInfo.classList.remove('d-none');
                basePrice.textContent = formatCurrency(price);
            } else {
                vehicleInfo.classList.add('d-none');
            }

            checkInitialPrice();
        });

        // Check sale price against base price
        salePrice.addEventListener('input', function() {
            const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
            const basePrice = selectedOption.dataset.price;

            if (basePrice && this.value) {
                if (parseInt(this.value) < parseInt(basePrice)) {
                    priceWarning.classList.remove('d-none');
                } else {
                    priceWarning.classList.add('d-none');
                }
            }
        });

        // Form validation
        document.getElementById('saleForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });
    });

</script>
@endsection
