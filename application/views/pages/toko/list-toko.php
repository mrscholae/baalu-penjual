<?php $this->load->view("_partials/header");?>
        
    <div class="col-12 col-md-4">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-store mr-1"></i>Kedai 51</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body text-gray-900">
                    <i class="fa fa-map-marker-alt mr-4"></i>Jl. Dg Ramang <br>
                    <i class="fa fa-truck mr-3"></i>10 pengiriman <br>
                    <div class="d-flex justify-content-center mt-1">
                        <a href="#addPengiriman" data-toggle="modal" class="btn btn-circle btn-success mr-1"><i class="fa fa-plus"></i></a>
                        <a href="#addProdukToko" data-toggle="modal" class="btn btn-circle btn-warning mr-1 addProdukToko"><i class="fas fa-cookie-bite"></i></a>
                        <a href="<?= base_url()?>toko/detail/idtoko" class="btn btn-circle btn-info"><i class="fa fa-info"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-4">
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-store mr-1"></i>Kedai 51</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample2">
                <div class="card-body text-gray-900">
                    <i class="fa fa-map-marker-alt mr-4"></i>Jl. Dg Ramang <br>
                    <i class="fa fa-truck mr-3"></i>10 pengiriman <br>
                    <div class="d-flex justify-content-center mt-1">
                        <a href="#addPengiriman" data-toggle="modal" data-toggle="modal" class="btn btn-circle btn-success mr-1"><i class="fa fa-plus"></i></a>
                        <a href="#addProdukToko" data-toggle="modal" class="btn btn-circle btn-warning mr-1 addProdukToko"><i class="fas fa-cookie-bite"></i></a>
                        <a href="<?= base_url()?>toko/detail/idtoko" class="btn btn-circle btn-info"><i class="fa fa-info"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view("_partials/modal");?>
<?php $this->load->view("_partials/footer");?>