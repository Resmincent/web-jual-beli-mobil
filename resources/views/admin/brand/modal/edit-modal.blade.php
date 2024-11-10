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
                    <div class="form-group">
                        <label for="name-{{ $brand->id }}">Nama Brand</label>
                        <input type="text" class="form-control" id="name-{{ $brand->id }}" name="name" value="{{ $brand->name }}" required>
                    </div>
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
