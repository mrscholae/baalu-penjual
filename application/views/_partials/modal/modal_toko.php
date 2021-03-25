<!-- modal add toko  -->
<div class="modal fade" id="addToko" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addTokoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addTokoLabel">Tambah Toko</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formAddToko">
                <div class="form-group">
                    <label for="tgl_bergabung" class="col-form-label">Tgl. Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control form-control-sm required" id="tgl_bergabung_add">
                </div>
                <div class="form-group">
                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control form-control-sm required" id="nama_toko_add">
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat Toko</label>
                    <textarea name="alamat" id="alamat_add" class="form-control form-control-sm required"></textarea>
                </div>
                <div class="form-group">
                    <label for="kecamatan" class="col-form-label">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan_add" class="form-control form-control-sm required">
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan Lainnya</label>
                    <input type="text" name="kecamatan_lainnya" id="kecamatan_lainnya_add" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="jam_buka_add">Jam Buka</label>
                    <input type="time" name="jam_buka" id="jam_buka_add" class="form-control form-control-sm required">
                </div>
                <div class="form-group">
                    <label for="jam_tutup_add">Jam Tutup</label>
                    <input type="time" name="jam_tutup" id="jam_tutup_add" class="form-control form-control-sm required">
                </div>
                <div class="form-group">
                    <label for="pj" class="col-form-label">Penanggung Jawab</label>
                    <input type="text" name="pj" class="form-control form-control-sm required" id="pj_add">
                </div>
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control form-control-sm required" id="no_hp_add">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user" id="btnAddToko">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit toko  -->
<div class="modal fade" id="editToko" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editTokoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editTokoLabel">Edit Toko</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="formEditToko">
                <input type="hidden" name="id_toko" id="id_toko_edit">
                <div class="form-group">
                    <label for="tgl_bergabung" class="col-form-label">Tgl. Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control form-control-sm required" id="tgl_bergabung_edit">
                </div>
                <div class="form-group">
                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control form-control-sm required" id="nama_toko_edit">
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat Toko</label>
                    <textarea name="alamat" id="alamat_edit" class="form-control form-control-sm required"></textarea>
                </div>
                <div class="form-group">
                    <label for="kecamatan" class="col-form-label">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan_edit" class="form-control form-control-sm required">
                    </select>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan Lainnya</label>
                    <input type="text" name="kecamatan_lainnya" id="kecamatan_lainnya_edit" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="jam_buka_edit">Jam Buka</label>
                    <input type="time" name="jam_buka" id="jam_buka_edit" class="form-control form-control-sm required">
                </div>
                <div class="form-group">
                    <label for="jam_tutup_edit">Jam Tutup</label>
                    <input type="time" name="jam_tutup" id="jam_tutup_edit" class="form-control form-control-sm required">
                </div>
                <div class="form-group">
                    <label for="pj" class="col-form-label">Penanggung Jawab</label>
                    <input type="text" name="pj" class="form-control form-control-sm required" id="pj_edit">
                </div>
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control form-control-sm required" id="no_hp_edit">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-user" id="btnEditToko">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit toko  -->
<div class="modal fade" id="rekapPenjualan" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="rekapPenjualanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="rekapPenjualanLabel">Rekap Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="dataToko mb-3"></div>
            <ul class="list-group text-gray-900">
                <div class="dataPenjualan"></div>
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
