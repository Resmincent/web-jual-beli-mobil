<div class="modal fade" id="deleteCategory-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryLabel-{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryLabel-{{ $category->id }}">Hapus Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kategori <strong>{{ $category->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
