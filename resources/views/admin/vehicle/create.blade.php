@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Create New Vehicle</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{--
    <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Vehicle Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="brand" class="form-label">Brand</label>
        <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Additional Images</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple>
        <small class="form-text text-muted">You can upload multiple images.</small>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="" disabled selected>Select a category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select class="form-select" id="brand_id" name="brand_id" required>
            <option value="" disabled selected>Select a brand</option>
            @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create Vehicle</button>
    </form> --}}


</div>
@endsection
