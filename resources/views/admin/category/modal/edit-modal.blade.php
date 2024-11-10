<div class="modal fade" id="editCategory-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel-{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel-{{ $category->id }}">Edit Merek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name-{{ $category->id }}">Nama Kategori</label>
                        <input type="text" class="form-control" id="name-{{ $category->id }}" name="name" value="{{ $category->name }}" required>
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
