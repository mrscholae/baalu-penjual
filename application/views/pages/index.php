<?php $this->load->view("_partials/header");?>
        <div class="row">
            <?php if($stok_bahan) :?>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Stok Kekurangan</div>
                                    <?php foreach ($stok_bahan as $i => $data) :?>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?= $i+1?>. <?= $data['nama_bahan']?> (<?= $data['stok']." ".$data['satuan']?>)</div>
                                    <?php endforeach;?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Menunggu Pengambilan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pengambilan?></div><br>
                                <form class="user">
                                    <a href="<?= base_url()?>pengambilan" class="btn btn-primary btn-user">
                                        detail <i class="fa fa-arrow-right ml-1"></i>
                                    </a>
                                </form>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php $this->load->view("_partials/modal");?>
<?php $this->load->view("_partials/footer");?>