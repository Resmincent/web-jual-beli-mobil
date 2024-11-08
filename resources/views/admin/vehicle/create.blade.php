@extends('layouts.admin')

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">{{ __('Tambah Kendaraan') }}</h1>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Judul</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Judul Artikel" value="{{ old('title') }}" required />
                                @error('title')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="year">Tahun</label>
                                        <input type="text" id="year" class="form-control @error('year') is-invalid @enderror" name="year" placeholder="2024" value="{{ old('year') }}" />
                                        @error('year')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="brand_id" class="form-label">Merek</label>
                                    <select class="form-select form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                                        <option value="" disabled selected>Pilih Merek</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="model">Model</label>
                                        <input type="text" id="model" class="form-control @error('model') is-invalid @enderror" name="model" placeholder="Aerox" value="{{ old('model') }}" />
                                        @error('model')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="price">Harga</label>
                                        <input type="number" id="price" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="1000000" value="{{ old('price') }}" required />
                                        @error('price')
                                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="mileage">Jarak Tempuh</label>
                                        <input type="text" id="mileage" class="form-control @error('mileage') is-invalid @enderror" name="mileage" placeholder="0-5.000 km" value="{{ old('mileage') }}" />
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
                                    <input name="category" class="form-check-input @error('category') is-invalid @enderror" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category') == $category->id ? 'checked' : '' }} required />
                                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                                @error('category')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="uploadHeader" class="form-label">Gambar Header*</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="uploadHeader" required />
                                <small class="text-danger">Max Size 5Mb, ext. png, jpg, jpeg</small>
                                @error('image')
                                <small class="invalid-feedback" role="alert">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                        <textarea class="form-control editor @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                        <small class="invalid-feedback" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <hr>
                    <div class="mb-3 float-end">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-danger">Batalkan</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
