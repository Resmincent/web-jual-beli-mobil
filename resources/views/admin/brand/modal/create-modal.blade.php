<div class="modal fade" id="tambahBrand" tabindex="-1" role="dialog" aria-labelledby="tambahBrandLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBrandLabel">Tambah Merek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nama Brand -->
                    <div class="form-group">
                        <label for="name">Nama Brand</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="category_id" class="form-label d-block">Kategori</label>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input name="category_id" class="form-check-input @error('category_id') is-invalid @enderror" type="radio" value="{{ $category->id }}" id="category{{ $category->id }}" {{ old('category_id') == $category->id ? 'checked' : '' }} required>
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Cover -->
                    <div class="form-group">
                        <label for="cover">Cover</label>
                        <input type="file" class="form-control" id="cover" name="cover" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
