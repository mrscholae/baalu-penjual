<!-- modal add pengiriman  -->
<div class="modal fade" id="addPengiriman" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPengirimanLabel">Tambah Pengiriman</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" class="user">
                <div class="form-group">
                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" id="nama_toko_pengiriman" class="form-control form-control-md" readonly>
                </div>
            </form>
            <form class="user" id="listAllBarang">
                <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih barang yang akan dikirim</div>
                <div class="listBarang"></div>
                <!-- <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">First and last name</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control">
                </div> -->
            </form>
            <form class="user" id="formAddPengiriman">
                <input type="hidden" name="id_toko" id="id_toko_pengiriman">
                <div class="form-group">
                    <label for="tgl_pengiriman" class="col-form-label">Tgl. Pengiriman</label>
                    <input type="datetime-local" name="tgl_pengiriman" class="form-control form-control-md" id="tgl_pengiriman_add" required>
                </div>
                <div class="form-group">
                    <label for="tgl_pengambilan" class="col-form-label">Tgl. Pengambilan</label>
                    <input type="datetime-local" name="tgl_pengambilan" class="form-control form-control-md" id="tgl_pengambilan_add" required>
                </div>
                <div class="form-group">
                    <p><b>List Pengiriman Barang</b></p>
                    <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>masukkan jumlah barang yang akan dikirim</div>
                    <div class="listBarangPengiriman"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between" id="btnFormAddPengiriman">
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-success btn-user" id="btnBarang"><i class="fa fa-arrow-left mr-1"></i> barang</button>
                </span>
            </form>
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-user" id="btnAddPengiriman">Simpan</button>
                </span>
            </form>
        </div>
        <div class="modal-footer" id="btnFormKirim">
            <form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnKirim">Kirim <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit pengiriman -->
<div class="modal fade" id="editPengiriman" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPengirimanLabel">Edit Pengiriman</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class='nav-link active btn-form-1'><i class="fas fa-database"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class='nav-link btn-form-2'><i class="fas fa-edit"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class='nav-link btn-form-3'><i class="fas fa-plus"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body text-gray-900 cus-font">
                    
                    <div class="card form-1">
                        <div class="card-header text-primary">
                            <strong>Data Pengiriman</strong>
                        </div>
                        <div class="card-body">
                            <form action="" class="user">
                                <input type="hidden" name="id_pengiriman" id="id_pengiriman_edit" readonly>
                                <div class="form-group">
                                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                                    <input type="text" name="nama_toko" class="form-control form-control-md nama_toko_edit_pengiriman" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_pengiriman" class="col-form-label">Tgl. Pengiriman</label>
                                    <input type="datetime-local" name="tgl_pengiriman" class="form-control form-control-md" id="tgl_pengiriman_edit" value="2013-03-18T13:00" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_pengambilan" class="col-form-label">Tgl. Pengambilan</label>
                                    <input type="datetime-local" name="tgl_pengambilan" class="form-control form-control-md" id="tgl_pengambilan_edit" required>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card form-2">
                        <div class="card-header text-primary">
                            <strong>Data Barang</strong>
                        </div>
                        <div class="card-body">
                            
                            <form action="" class="user">
                                <div class="form-group">
                                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                                    <input type="text" name="nama_toko" class="form-control form-control-md nama_toko_edit_pengiriman" readonly>
                                </div>
                            </form>

                            <label for=""><b>List Barang</b></label>
                            <div id="editPengirimanBarang"></div>
                        </div>
                    </div>

                    <div class="card form-3">
                        <div class="card-header text-primary">
                            <strong>Tambah Barang</strong>
                        </div>
                        <div class="card-body">
                            <div id="editPengirimanTambahList"></div>
                            <div id="editPengirimanTambahBarang"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
            <div class="footer-1">
                <div class="modal-footer">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success btn-user" id="btnEditPengiriman">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>

            <div class="footer-2">
                <div class="modal-footer">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success btn-user" id="btnEditPengirimanBarang">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>
            
            <div class="footer-3">
                <div class="modal-footer">
                    <form action="" class="user">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-user" id="btnEditPengirimanTambah"><i class="fa fa-plus mr-1"></i> Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal add pengambilan -->
<div class="modal fade" id="addPengambilan" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addPengambilanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPengambilanLabel">Form Pengambilan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" class="user">
                <input type="hidden" name="id_pengiriman" id="id_pengiriman_pengambilan">
                <div class="form-group">
                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control form-control-md" id="nama_toko_pengambilan" readonly>
                </div>
                <div class="form-group">
                    <label for="tgl_pengiriman" class="col-form-label">Tgl. Pengiriman</label>
                    <input type="text" name="tgl_pengiriman" class="form-control form-control-md" id="tgl_pengiriman_pengambilan" readonly>
                </div>
                <div class="form-group">
                    <label for="tgl_pengambilan" class="col-form-label">Tgl. Pengambilan</label>
                    <input type="text" name="tgl_pengambilan" class="form-control form-control-md" id="tgl_pengambilan_pengambilan" readonly>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-store mr-1"></i>List Barang</h6>
                    </div>
                    <div class="card-body text-gray-900">
                        <div class="alert alert-info"><i class="fa fa-info-circle text-info"></i> inputkan sisa barang</div>
                        <div class="addPengambilanListBarang"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user" id="btnAddPengambilan">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal detail pengiriman -->
<div class="modal fade" id="detailPengiriman" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="detailPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailPengirimanLabel">Detail Pengiriman</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-gray-900">
            <ul class="list-group mb-3">
                <div class="detailPengirimanData"></div>
                <!-- <li class="list-group-item d-flex justify-content-between">
                    <span>Status</span>
                    <span id="detailPengirimanStatus"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tgl. Pengiriman</span>
                    <span id="detailPengirimanTglPengiriman"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tgl. Pengambilan</span>
                    <span id="detailPengirimanTglPengambilan"></span>
                </li> -->
            </ul>

            <ul class="list-group">
                <li class="list-group-item list-group-item-success">List Barang</li>
                <div class="detailPengirimanListBarang"></div>
                
            </ul>
        </div>
        <div class="modal-footer">
            <form class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
            </form>
        </div>
        </div>
    </div>
</div>