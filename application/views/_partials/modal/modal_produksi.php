<!-- modal add produksi  -->
<div class="modal fade" id="addProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProduksiLabel">Tambah Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formAddProduksi">
                <div class="form-group">
                    <label for="tipe_produksi_add">Tipe Produksi</label>
                    <select name="tipe_produksi" id="tipe_produksi_add" class="form-control form-control-sm required">
                        <option value="">Pilih Tipe Produksi</option>
                        <option value="Produksi Bahan">Produksi Bahan</option>
                        <option value="Produksi Barang">Produksi Barang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tgl_produksi" class="col-form-label">Tgl. Produksi</label>
                    <input type="datetime-local" name="tgl_produksi" class="form-control form-control-md required" id="tgl_produksi_add" value="">
                </div>
            </form>
        </div>
        <div class="modal-footer" id="btnFormAddProduksi">
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-user" id="btnAddProduksi">Simpan</button>
                </span>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit produksi  -->
<div class="modal fade" id="editProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProduksiLabel">Edit Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- <form id="formAddProduksi"> -->
                <input type="hidden" name="id_produksi">
                <div class="form-group">
                    <label for="tgl_produksi_edit" class="col-form-label">Tgl. Produksi</label>
                    <input type="datetime-local" name="tgl_produksi" class="form-control form-control-md required" id="tgl_produksi_edit" value="">
                </div>
            <!-- </form> -->
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <span>
                    <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-user btnSimpan">Simpan</button>
                </span>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal tambah bahan produksi  -->
<div class="modal fade" id="addBahanProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addBahanProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addBahanProduksiLabel">Penggunaan Bahan Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="listAllBahan">
                <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih bahan yang akan digunakan untuk produksi</div>
                <div class="listBahan"></div>
            </form>
            <form class="user" id="formAddBahanProduksi">
                <input type="hidden" name="id_produksi" id="id_bahan_produksi">
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>masukkan jumlah bahan yang akan digunakan</div>
                    <div class="listBahanPenggunaan"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer" id="footerAddBahanProduksi">
        </div>
        </div>
    </div>
</div>

<!-- modal tambah barang hasil produksi  -->
<div class="modal fade" id="addProduksiBarang" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addProduksiBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProduksiBarangLabel">Hasil Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user" id="listAllBarang">
                <!-- <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>pilih barang yang diproduksi</div> -->
                <div class="listAllBarang"></div>
            </form>
            <form class="user" id="formAddProduksiBarang">
                <input type="hidden" name="id_produksi" id="id_produksi_barang">
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>masukkan jumlah barang yang diproduksi</div>
                    <div class="listProduksiBarang"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer" id="footerAddProduksiBarang">
        </div>
        </div>
    </div>
</div>

<!-- modal tambah barang hasil produksi  -->
<div class="modal fade" id="addProduksiBahan" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="addProduksiBahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProduksiBahanLabel">Hasil Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <div class="listItem"></div>
            </form>
            <form class="user formItem">
                <input type="hidden" name="id_produksi" class="id_produksi">
                <div class="form-group">
                    <div class="alert alert-info"><i class="fa fa-info-circle text-info mr-1"></i>masukkan jumlah bahan yang diproduksi</div>
                    <div class="listItemGenerate"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
</div>

<!-- modal detail produksi -->
<div class="modal fade" id="detailProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="detailProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailProduksiLabel">Detail Produksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-gray-900">
            <ul class="list-group mb-3">
                <div class="detailProduksiData"></div>
            </ul>

            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-success">List Bahan Produksi</li>
                <div class="detailProduksiListBahan"></div>
            </ul>
            
            <ul class="list-group">
                <div class="detailProduksiListBarang"></div>
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

<!-- modal edit bahan produksi -->
<div class="modal fade" id="editBahanProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editBahanProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBahanProduksiLabel">Edit Bahan Produksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class='nav-link active btn-form-1'><i class="fas fa-edit"></i></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" class='nav-link btn-form-2'><i class="fas fa-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body text-gray-900 cus-font">

                        <input type="hidden" name="id_produksi">

                        <div class="card form-1">
                            <div class="card-header text-primary">
                                <strong>Data Bahan</strong>
                            </div>
                            <div class="card-body">
                                <div class="listItem"></div>
                            </div>
                        </div>

                        <div class="card form-2">
                            <div class="card-header text-primary">
                                <strong>Tambah Bahan</strong>
                            </div>
                            <div class="card-body">
                                <div class="listItem2"></div>
                                <div class="listItem3"></div>
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
                            <button type="button" class="btn btn-success btn-user btnSimpan1">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>
            
            <div class="footer-2">
                <div class="modal-footer">
                    <form action="" class="user">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal edit barang produksi -->
<div class="modal fade" id="editBarangProduksi" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="editBarangProduksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangProduksiLabel">Edit Barang Produksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="javascript:void(0)" class='nav-link active btn-form-1'><i class="fas fa-edit"></i></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" class='nav-link btn-form-2'><i class="fas fa-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body text-gray-900 cus-font">

                        <input type="hidden" name="id_produksi">

                        <div class="card form-1">
                            <div class="card-header text-primary">
                                <strong>Data Barang</strong>
                            </div>
                            <div class="card-body">
                                <div class="listItem"></div>
                            </div>
                        </div>

                        <div class="card form-2">
                            <div class="card-header text-primary">
                                <strong>Tambah Barang</strong>
                            </div>
                            <div class="card-body">
                                <div class="listItem2"></div>
                                <div class="listItem3"></div>
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
                            <button type="button" class="btn btn-success btn-user btnSimpan1">Simpan</button>
                        </span>
                    </form>
                </div>
            </div>
            
            <div class="footer-2">
                <div class="modal-footer">
                    <form action="" class="user">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success btn-user btnNext">next <i class="fa fa-arrow-right ml-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>