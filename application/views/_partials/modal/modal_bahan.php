<!-- modal add bahan  -->
<div class="modal fade" id="addBahan" tabindex="-1" data-backdrop="static" data-backdrop="static" role="dialog" aria-labelledby="addBahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addBahanLabel">Tambah Bahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formAddBahan">
                <div class="form-group">
                    <label for="nama_bahan_add" class="col-form-label">Nama Bahan</label>
                    <input type="text" name="nama_bahan" class="form-control form-control-sm required" id="nama_bahan_add">
                </div>
                <div class="form-group">
                    <label for="jenis_add">Jenis Bahan</label>
                    <select name="jenis" id="jenis_add" class="form-control form-control-sm required">
                        <option value="">Pilih Jenis Bahan</option>
                        <option value="Beli">Beli</option>
                        <option value="Produksi">Produksi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="satuan_add" class="col-form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control form-control-sm required" id="satuan_add">
                </div>
                <div class="form-group">
                    <label for="harga_satuan_add" class="col-form-label">Harga Satuan</label>
                    <input type="text" name="harga_satuan" class="form-control form-control-sm required rupiah" id="harga_satuan_add">
                </div>
                <div class="form-group">
                    <label for="min_stok_add" class="col-form-label">Stok Minimal</label>
                    <input type="number" step="any" name="min_stok" class="form-control form-control-sm required" id="min_stok_add">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user" id="btnAddBahan">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit bahan  -->
<div class="modal fade" id="editBahan" tabindex="-1" data-backdrop="static" data-backdrop="static" role="dialog" aria-labelledby="editBahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editBahanLabel">Edit Bahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formEditBahan">
                <input type="hidden" name="id_bahan" id="id_bahan_edit">
                <div class="form-group">
                    <label for="nama_bahan_edit" class="col-form-label">Nama Bahan</label>
                    <input type="text" name="nama_bahan" class="form-control form-control-sm required" id="nama_bahan_edit">
                </div>
                <div class="form-group">
                    <label for="jenis_edit">Jenis Bahan</label>
                    <select name="jenis" id="jenis_edit" class="form-control form-control-sm required">
                        <option value="">Pilih Jenis Bahan</option>
                        <option value="Beli">Beli</option>
                        <option value="Produksi">Produksi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="satuan_edit" class="col-form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control form-control-sm required" id="satuan_edit">
                </div>
                <div class="form-group">
                    <label for="harga_satuan_edit" class="col-form-label">Harga Satuan</label>
                    <input type="text" name="harga_satuan" class="form-control form-control-sm required rupiah" id="harga_satuan_edit">
                </div>
                <div class="form-group">
                    <label for="min_stok_edit" class="col-form-label">Stok Minimal</label>
                    <input type="number" step="any" name="min_stok" class="form-control form-control-sm required" id="min_stok_edit">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-user" id="btnEditBahan">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>