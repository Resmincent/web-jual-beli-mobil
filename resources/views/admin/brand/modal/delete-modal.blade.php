<div class="modal fade" id="deleteBrand-{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteBrandLabel-{{ $brand->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBrandLabel-{{ $brand->id }}">Hapus Merek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus merek <strong>{{ $brand->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
