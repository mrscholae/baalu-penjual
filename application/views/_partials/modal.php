<!-- modal add store  -->
<div class="modal fade" id="addStore" tabindex="-1" role="dialog" aria-labelledby="addStoreLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addStoreLabel">Tambah Toko</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <div class="form-group">
                    <label for="tgl_bergabung" class="col-form-label">Tgl. Bergabung</label>
                    <input type="date" name="tgl_bergabung" class="form-control form-control-user" id="tgl_bergabung">
                </div>
                <div class="form-group">
                    <label for="nama_toko" class="col-form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control form-control-user" id="nama_toko">
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat Toko</label>
                    <textarea name="alamat" id="alamat" class="form-control form-control-user"></textarea>
                </div>
                <div class="form-group">
                    <label for="pj" class="col-form-label">Penanggung Jawab</label>
                    <input type="text" name="pj" class="form-control form-control-user" id="pj">
                </div>
                <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. Handphone</label>
                    <input type="text" name="no_hp" class="form-control form-control-user" id="no_hp">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal add produk  -->
<div class="modal fade" id="addProduk" tabindex="-1" role="dialog" aria-labelledby="addProdukLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProdukLabel">Tambah Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <div class="form-group">
                    <label for="nama_produk" class="col-form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control form-control-user" id="nama_produk">
                </div>
                <div class="form-group">
                    <label for="kd_produk" class="col-form-label">Kode Produk</label>
                    <input type="text" name="kd_produk" class="form-control form-control-user" id="kd_produk">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit produk  -->
<div class="modal fade" id="editProduk" tabindex="-1" role="dialog" aria-labelledby="editProdukLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProdukLabel">Edit Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <div class="form-group">
                    <label for="nama_produk" class="col-form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control form-control-user" id="nama_produk" value="Marewo Bakery Cokelat">
                </div>
                <div class="form-group">
                    <label for="kd_produk" class="col-form-label">Kode Produk</label>
                    <input type="text" name="kd_produk" class="form-control form-control-user" id="kd_produk" value="MBK">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal add pengiriman  -->
<div class="modal fade" id="addPengiriman" tabindex="-1" role="dialog" aria-labelledby="addPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPengirimanLabel">Tambah Pengiriman</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="user">
                <div class="form-group">
                    <label for="tgl_pengiriman" class="col-form-label">Tgl. Pengiriman</label>
                    <input type="date" name="tgl_pengiriman" class="form-control form-control-user" id="tgl_pengiriman" value="<?= date('Y-m-d')?>">
                </div>
                <div class="form-group">
                    <label for="tgl_pengambilan" class="col-form-label">Tgl. Pengambilan</label>
                    <input type="date" name="tgl_pengambilan" class="form-control form-control-user" id="tgl_pengambilan">
                </div>
                <div class="form-group">
                    <p><b>List Pengiriman</b></p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">MBK</span>
                        </div>
                        <input type="number" class="form-control" aria-label="Text input with checkbox">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">MBC</span>
                        </div>
                        <input type="number" class="form-control" aria-label="Text input with checkbox">
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form action="" class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal add produk toko -->
<div class="modal fade" id="addProdukToko" tabindex="-1" role="dialog" aria-labelledby="addProdukTokoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProdukTokoLabel">Tambah Produk Toko</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class='nav-link active btn-form-1'><i class="fas fa-cookie-bite"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class='nav-link btn-form-2'><i class="fas fa-list"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body cus-font">
                    
                    <div class="card form-1">
                        <div class="card-header text-primary">
                            <strong>Data Produk Toko</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group d-flex justify-content-between">
                                <span>1. Marewo Bakery Cokelat</span>
                                <span><i class="fa fa-minus-circle text-danger"></i></span>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <span>2. Marewo Bakery Keju</span>
                                <span><i class="fa fa-minus-circle text-danger"></i></span>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <span>3. Marewo Bakery Abon</span>
                                <span><i class="fa fa-minus-circle text-danger"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card form-2">
                        <div class="card-header text-primary">
                            <strong>Data Produk</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group d-flex justify-content-between">
                                <span>1. Marewo Bakery Cokelat</span>
                                <span><i class="fa fa-plus-circle text-success"></i></span>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <span>2. Marewo Bakery Keju</span>
                                <span><i class="fa fa-plus-circle text-success"></i></span>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <span>3. Marewo Bakery Abon</span>
                                <span><i class="fa fa-plus-circle text-success"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <form class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal add pengambilan -->
<div class="modal fade" id="addPengambilan" tabindex="-1" role="dialog" aria-labelledby="addPengambilanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPengambilanLabel">Warkop 51</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" class="user">
                <div class="form-group">
                    <label for="tgl_pengiriman" class="col-form-label">Tgl. Pengiriman</label>
                    <input type="date" name="tgl_pengiriman" class="form-control form-control-user" id="tgl_pengiriman" value="<?= date('Y-m-d')?>" readonly>
                </div>
                <div class="form-group">
                    <label for="tgl_pengambilan" class="col-form-label">Tgl. Pengambilan</label>
                    <input type="date" name="tgl_pengambilan" class="form-control form-control-user" id="tgl_pengambilan" readonly>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-store mr-1"></i>List Produk</h6>
                    </div>
                    <div class="card-body text-gray-900">
                        <div class="alert alert-info"><i class="fa fa-info-circle text-info"></i> inputkan sisa produk</div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">1. MBK (10)</span>
                            </div>
                            <input type="number" class="form-control form-control-user" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">2. MBC (20)</span>
                            </div>
                            <input type="number" class="form-control form-control-user" aria-label="Amount (to the nearest dollar)">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <form class="user">
                <button type="button" class="btn btn-secondary btn-user" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-user">Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>


<!-- modal detail pengiriman -->
<div class="modal fade" id="modalDetailPengiriman" tabindex="-1" role="dialog" aria-labelledby="modalDetailPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalDetailPengirimanLabel">Warkop 51</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Status</span>
                    <span>Berhasil</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tgl. Pengiriman</span>
                    <span>12 Jan 2021</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Tgl. Pengambilan</span>
                    <span>14 Jan 2021</span>
                </li>
            </ul>

            <ul class="list-group">
                <li class="list-group-item list-group-item-success">List Produk</li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>1. MBK</span>
                    <span>
                        <i class="fa fa-truck mr-3"></i>10<br>
                    </span>
                    <span>
                        <i class="fa fa-truck-pickup mr-3"></i>3<br>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>2. MBC</span>
                    <span>
                        <i class="fa fa-truck mr-3"></i>10<br>
                    </span>
                    <span>
                        <i class="fa fa-truck-pickup mr-3"></i>0<br>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>3. MBA</span>
                    <span>
                        <i class="fa fa-truck mr-3"></i>10<br>
                    </span>
                    <span>
                        <i class="fa fa-truck-pickup mr-3"></i>2<br>
                    </span>
                </li>
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