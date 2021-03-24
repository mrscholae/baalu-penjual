<!-- modal add barang  -->
<div class="modal fade" id="addBarang" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addBarangLabel">Tambah Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formAddBarang">
                <div class="form-group">
                    <label for="tgl_rilis" class="col-form-label">Tgl. Rilis</label>
                    <input type="date" name="tgl_rilis" class="form-control form-control-sm" id="tgl_rilis_add" required>
                </div>
                <div class="form-group">
                    <label for="nama_barang" class="col-form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control form-control-sm" id="nama_barang_add" required>
                </div>
                <div class="form-group">
                    <label for="kode_barang" class="col-form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control form-control-sm" id="kode_barang_add" required>
                </div>
                <div class="form-group">
                    <label for="harga" class="col-form-label">Harga Barang</label>
                    <input type="text" name="harga" class="form-control form-control-sm rupiah" id="harga_add" required>
                </div>
                <div class="form-group">
                    <label for="bagi_hasil" class="col-form-label">Bagi Hasil</label>
                    <input type="text" name="bagi_hasil" class="form-control form-control-sm rupiah" id="bagi_hasil_add" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user" id="btnAddBarang">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit barang  -->
<div class="modal fade" id="editBarang" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editBarangLabel">Edit Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <input type="hidden" name="id_barang" id="id_barang_edit">
                <div class="form-group">
                    <label for="tgl_rilis" class="col-form-label">Tgl. Rilis</label>
                    <input type="date" name="tgl_rilis" class="form-control form-control-sm" id="tgl_rilis_edit" required>
                </div>
                <div class="form-group">
                    <label for="nama_barang" class="col-form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control form-control-sm" id="nama_barang_edit" required>
                </div>
                <div class="form-group">
                    <label for="kode_barang" class="col-form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control form-control-sm" id="kode_barang_edit" required>
                </div>
                <div class="form-group">
                    <label for="harga_edit" class="col-form-label">Harga Barang</label>
                    <input type="text" name="harga" class="form-control form-control-sm rupiah" id="harga_edit" required>
                </div>
                <div class="form-group">
                    <label for="bagi_hasil_edit" class="col-form-label">Bagi Hasil</label>
                    <input type="text" name="bagi_hasil" class="form-control form-control-sm rupiah" id="bagi_hasil_edit" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-user" id="btnEditBarang">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>