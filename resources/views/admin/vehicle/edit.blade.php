@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">{{ __('Edit Kendaraan') }}</h1>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput1" class="form-label">Judul</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Judul Artikel" value="{{ old('name', $vehicle->name) }}" required />
                                        @error('name')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label for="transmisi" class="form-label">Transmisi</label>
                                        <input type="text" name="transmition" class="form-control @error('transmition') is-invalid @enderror" id="transmisi" placeholder="Transmisi" value="{{ old('transmition', $vehicle->transmition) }}" required />
                                        @error('transmition')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="year">Tahun</label>
                                        <input type="text" id="year" class="form-control @error('year') is-invalid @enderror" name="year" placeholder="2024" value="{{ old('year', $vehicle->year) }}" />
                                        @error('year')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="brand_id" class="form-label">Merek</label>
                                    <select class="form-select form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                                        <option value="" disabled>Pilih Merek</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $vehicle->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="model">Model</label>
                                        <input type="text" id="model" class="form-control @error('model') is-invalid @enderror" name="model" placeholder="Aerox" value="{{ old('model', $vehicle->model) }}" />
                                        @error('model')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="price">Harga</label>
                                        <input type="number" id="price" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="1000000" value="{{ old('price', $vehicle->price) }}" required />
                                        @error('price')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="mileage">Jarak Tempuh</label>
                                        <input type="text" id="mileage" class="form-control @error('mileage') is-invalid @enderror" name="mileage" placeholder="0-5.000 km" value="{{ old('mileage', $vehicle->mileage) }}" />
                                        @error('mileage')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-md mb-3">
                                <label class="form-label d-block">Kategori</label>
                                @foreach($categories as $category)
                                <div class="form-check mt-2">
                                    <input name="category_id" class="form-check-input @error('category_id') is-invalid @enderror" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category_id', $vehicle->category_id) == $category->id ? 'checked' : '' }} required />
                                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                                @error('category_id')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail Kendaraan</label>
                                @if($vehicle->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($vehicle->thumbnail) }}" alt="Current Thumbnail" class="img-thumbnail" style="max-height: 200px; width: 100%; object-fit: cover;">
                                </div>
                                @endif
                                <input type="file" name="thumbnail" class="border-hover-success form-control" id="thumbnail">
                                <small class="text-danger">Max Size 2MB, ext. png, jpg, jpeg</small>
                                <small class="d-block">Kosongkan jika tidak ingin mengubah thumbnail</small>
                            </div>
                            <div id="thumbnailPreview" class="row mt-3"></div>

                            <div class="mb-3">
                                <label for="vehicle_images" class="form-label">Gambar Kendaraan (Multiple)</label>
                                @if($vehicle->images->count() > 0)
                                <div class="row mb-5">
                                    @foreach($vehicle->images as $image)
                                    <div class="col-md-6 mb-2">
                                        <div class="image-container position-relative">
                                            <img src="{{ Storage::url($image->image) }}" alt="Vehicle Image" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                            <div class="checkbox-wrapper position-absolute" style="top: 5px; right: 5px; z-index: 10;">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="form-check-input bg-danger border-danger" id="delete_image_{{ $image->id }}" style="width: 20px; height: 20px;">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <small class="d-block mb-2 mt-2">Centang checkbox untuk menghapus gambar</small>
                                @endif
                                <input type="file" name="vehicle_images[]" class="border-hover-success form-control" id="vehicle_images" multiple>
                                <small class="text-danger">Max Size 2MB per file, ext. png, jpg, jpeg</small>
                            </div>
                            <div id="imagePreview" class="row mt-3"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                        <textarea class="form-control editor @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="5">{{ old('description', $vehicle->description) }}</textarea>
                        @error('description')
                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <hr>
                    <div class="mb-3 float-end">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-danger">Batalkan</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .image-container {
        display: block;
        position: relative;
    }

    .checkbox-wrapper {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 2px;
        border-radius: 4px;
    }

    .form-check-input:checked {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

</style>

<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('.editor')).catch(error => {
        console.error(error);
    });

    // Thumbnail preview
    document.getElementById('thumbnail').addEventListener('change', function(event) {
        const thumbnailPreview = document.getElementById('thumbnailPreview');
        thumbnailPreview.innerHTML = '';

        if (event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-12 mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="height: 200px; object-fit: cover;">
                `;
                thumbnailPreview.appendChild(div);
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    // Multiple images preview
    document.getElementById('vehicle_images').addEventListener('change', function(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        Array.from(event.target.files).forEach(file => {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'col-md-6 mb-2';
                    div.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="this.parentElement.parentElement.remove()">×</button>
                        </div>
                    `;
                    imagePreview.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        });
    });

</script>
@endsection
