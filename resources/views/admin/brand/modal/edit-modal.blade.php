<div class="modal fade" id="editBrand-{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="editBrandLabel-{{ $brand->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandLabel-{{ $brand->id }}">Edit Merek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nama Brand -->
                    <div class="form-group">
                        <label for="name-{{ $brand->id }}">Nama Brand</label>
                        <input type="text" class="form-control" id="name-{{ $brand->id }}" name="name" value="{{ $brand->name }}" required>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="category_id" class="form-label d-block">Kategori</label>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input name="category_id" class="form-check-input @error('category_id') is-invalid @enderror" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category_id', $brand->category_id) == $category->id ? 'checked' : '' }} required>
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Cover -->
                    <div class="form-group">
                        <label for="cover-{{ $brand->id }}">Cover</label>
                        <input type="file" class="form-control" id="cover-{{ $brand->id }}" name="cover">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah cover.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
