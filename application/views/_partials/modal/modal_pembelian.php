<!-- modal add pembelian  -->
<div class="modal fade" id="addPembelian" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPembelianLabel">Tambah Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="listAllBahan">
                <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih bahan yang akan dibeli</div>
                <div class="listBahan"></div>
                <!-- <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">First and last name</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control">
                </div> -->
            </form>
            <form class="user" id="formAddPembelian">
                <input type="hidden" name="id_toko" id="id_toko_pembelian">
                <div class="form-group">
                    <label for="tgl_pembelian_add" class="col-form-label">Tgl. Pembelian</label>
                    <input type="datetime-local" name="tgl_pembelian" class="form-control form-control-md" id="tgl_pembelian_add" required>
                </div>
                <div class="form-group">
                    <p><b>List Pembelian Bahan</b></p>
                    <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>masukkan jumlah bahan yang akan dibeli</div>
                    <div class="listBahanPembelian"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between" id="btnFormAddPembelian">
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-success btn-user" id="btnBahan"><i class="fa fa-arrow-left mr-1"></i> bahan</button>
                </span>
            </form>
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-user" id="btnAddPembelian">Simpan</button>
                </span>
            </form>
        </div>
        <div class="modal-footer" id="btnFormKirim">
            <form action="" class="user">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-user" id="btnBeli">Beli <i class="fa fa-arrow-right ml-1"></i></button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit pembelian -->
<div class="modal fade" id="editPembelian" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPembelianLabel">Edit Pembelian</h5>
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
                            <strong>Data Pembelian</strong>
                        </div>
                        <div class="card-body">
                            <form action="" class="user">
                                <input type="hidden" name="id_pembelian" id="id_pembelian_edit" readonly>
                                <div class="form-group">
                                    <label for="tgl_pembelian" class="col-form-label">Tgl. Pembelian</label>
                                    <input type="datetime-local" name="tgl_pembelian" class="form-control form-control-md required" id="tgl_pembelian_edit" value="">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card form-2">
                        <div class="card-header text-primary">
                            <strong>Data Bahan</strong>
                        </div>
                        <div class="card-body">

                            <!-- <label for=""><b>List Bahan</b></label> -->
                            <div id="editPembelianBahan"></div>
                        </div>
                    </div>

                    <div class="card form-3">
                        <div class="card-header text-primary">
                            <strong>Tambah Bahan</strong>
                        </div>
                        <div class="card-body">
                            <div id="editPembelianTambahList"></div>
                            <div id="editPembelianTambahBahan"></div>
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
                            <button type="button" class="btn btn-success btn-user" id="btnEditPembelian">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>

            <div class="footer-2">
                <div class="modal-footer">
                    <form action="" class="user">
                        <span>
                            <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success btn-user" id="btnEditPembelianBahan">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>
            
            <div class="footer-3">
                <div class="modal-footer">
                    <form action="" class="user">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-user" id="btnEditPembelianTambah"><i class="fa fa-plus mr-1"></i> Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal detail pembelian -->
<div class="modal fade" id="detailPembelian" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="detailPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailPembelianLabel">Detail Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-gray-900">
            <ul class="list-group mb-3">
                <div class="detailPembelianData"></div>
            </ul>

            <ul class="list-group">
                <li class="list-group-item list-group-item-success">List Bahan</li>
                <div class="detailPembelianListBahan"></div>
                
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