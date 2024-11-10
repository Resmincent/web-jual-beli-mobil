@extends('layouts.admin')

@section('main-content')

<h1 class="h3 mb-4 text-gray-800">{{ __('Edit Kendaraan') }}</h1>

<div class="row">
    <!-- Form controls -->
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
                                        <label for="name" class="form-label">Judul</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Judul Kendaraan" value="{{ old('name', $vehicle->name) }}" required />
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label for="transmition" class="form-label">Transmisi</label>
                                        <input type="text" name="transmition" class="form-control" id="transmition" placeholder="Transmisi" value="{{ old('transmition', $vehicle->transmition) }}" required />
                                        @error('transmition')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="year">Tahun</label>
                                        <input type="text" id="year" class="form-control" name="year" placeholder="2024" value="{{ old('year', $vehicle->year) }}">
                                        @error('year')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="brand_id" class="form-label">Merek</label>
                                    <select class="form-select form-control" id="brand_id" name="brand_id" required>
                                        <option value="" disabled>Pilih Merek</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $vehicle->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="model">Model</label>
                                        <input type="text" id="model" class="form-control" name="model" placeholder="Aerox" value="{{ old('model', $vehicle->model) }}">
                                        @error('model')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="price">Harga</label>
                                        <input type="number" id="price" class="form-control" name="price" placeholder="1000000" value="{{ old('price', $vehicle->price) }}" required>
                                        @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="mileage">Jarak Tempuh</label>
                                        <input type="text" id="mileage" class="form-control" name="mileage" placeholder="0-5.000 km" value="{{ old('mileage', $vehicle->mileage) }}">
                                        @error('mileage')
                                        <div class="text-danger">{{ $message }}</div>
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
                                    <input name="category_id" class="form-check-input" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category_id', $vehicle->category_id) == $category->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="uploadHeader" class="form-label">Gambar Header</label>
                                @if($vehicle->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($vehicle->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                                @endif
                                <input type="file" name="image" class="form-control" id="uploadHeader" />
                                <small class="text-danger">Max Size 5Mb, ext. png, jpg, jpeg</small>
                                <small class="d-block">Kosongkan jika tidak ingin mengubah gambar</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control editor" name="description" id="description">{{ old('description', $vehicle->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
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

    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script type="text/javascript">
        ClassicEditor.create(document.querySelector('.editor')).then(editor => {
            console.log(editor);
        })

    </script>
</div>
@endsection
