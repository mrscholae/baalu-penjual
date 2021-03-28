<!-- modal add pelanggan  -->
<div class="modal fade" id="addPelanggan" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPelangganLabel">Tambah Pelanggan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formAddPelanggan">
                <div class="form-group">
                    <label for="tgl_bergabung" class="col-form-label">Tgl. Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control form-control-sm required" id="tgl_bergabung_add">
                </div>
                <div class="form-group">
                    <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control form-control-sm required" id="nama_pelanggan_add">
                </div>
                <!-- <div class="form-group">
                    <label for="t4_lahir" class="col-form-label">Tempat Lahir</label>
                    <input type="text" name="t4_lahir" class="form-control form-control-sm" id="t4_lahir_add">
                </div>
                <div class="form-group">
                    <label for="tgl_lahir" class="col-form-label">Tgl. Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control form-control-sm" id="tgl_lahir_add">
                </div> -->
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat Pelanggan</label>
                    <textarea name="alamat" class="form-control form-control-sm"></textarea>
                </div>
                <div class="form-group">
                    <label for="kecamatan" class="col-form-label">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan_add" class="form-control form-control-sm">
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan Lainnya</label>
                    <input type="text" name="kecamatan_lainnya" id="kecamatan_lainnya_add" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control form-control-sm" id="no_hp_add">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user btnSimpan">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit pelanggan  -->
<div class="modal fade" id="editPelanggan" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPelangganLabel">Edit Pelanggan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formEditPelanggan">
                <input type="hidden" name="id_pelanggan">
                <div class="form-group">
                    <label for="tgl_bergabung" class="col-form-label">Tgl. Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control form-control-sm required">
                </div>
                <div class="form-group">
                    <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control form-control-sm required">
                </div>
                <!-- <div class="form-group">
                    <label for="t4_lahir" class="col-form-label">Tempat Lahir</label>
                    <input type="text" name="t4_lahir" class="form-control form-control-sm" id="t4_lahir_add">
                </div>
                <div class="form-group">
                    <label for="tgl_lahir" class="col-form-label">Tgl. Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control form-control-sm" id="tgl_lahir_add">
                </div> -->
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat Pelanggan</label>
                    <textarea name="alamat" class="form-control form-control-sm"></textarea>
                </div>
                <div class="form-group">
                    <label for="kecamatan" class="col-form-label">Kecamatan</label>
                    <select name="kecamatan" class="form-control form-control-sm">
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan Lainnya</label>
                    <input type="text" name="kecamatan_lainnya" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control form-control-sm">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-user btnSimpan">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit pelanggan  -->
<div class="modal fade" id="rekapPembelian" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="rekapPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="rekapPembelianLabel">Rekap Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="listData mb-3"></div>
            <ul class="list-group text-gray-900">
                <div class="listItem"></div>
            </ul>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
            </form>
        </div>
        </div>
    </div>
</div>
