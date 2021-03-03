<?php $this->load->view("_partials/header");?>
        
    <div class="col-12">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-store mr-1"></i>Data Toko</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Data Toko</div>
                        <a class="dropdown-item" href="#">Edit</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body text-gray-900">
                <i class="fa fa-store mr-3"></i>Warkop 51 <br>
                <i class="fa fa-user-circle mr-3"></i>Dg. Ramma <br>
                <i class="fa fa-phone mr-3"></i>08123xxx <br>
                <i class="fa fa-map-marker-alt mr-3"></i>Jl. Dg Ramang <br>
            </div>
        </div>
    </div>


    <div class="col-12 mb-4">
        <h5 class="mb-0 text-gray-800">List Pengiriman</h5>
    </div>
                
    <div class="col-12 col-md-4">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="list-group-item-success card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-check-circle text-success mr-1"></i>Berhasil</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Pengiriman</div>
                        <a class="dropdown-item" href="#modalDetailPengiriman" data-toggle="modal">Detail</a>
                        <a class="dropdown-item" href="#">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Hapus</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body text-gray-900">
                <i class="fa fa-map-marker-alt mr-4"></i>Jl. Dg Ramang <br>
                <i class="fa fa-truck mr-3"></i>10 Jan 2021<br>
                <i class="fa fa-truck-pickup mr-3"></i>12 Jan 2021<br>
            </div>
        </div>
    </div>

    
    <div class="col-12 col-md-4">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="list-group-item-warning card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-exclamation-circle text-warning mr-1"></i>Proses</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Pengiriman</div>
                        <a class="dropdown-item" href="#modalDetailPengiriman" data-toggle="modal">Detail</a>
                        <a class="dropdown-item" href="#">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Hapus</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body text-gray-900">
                <i class="fa fa-map-marker-alt mr-4"></i>Jl. Dg Ramang <br>
                <i class="fa fa-truck mr-3"></i>10 Jan 2021<br>
                <i class="fa fa-truck-pickup mr-3"></i>12 Jan 2021<br>
            </div>
        </div>
    </div>
    

<?php $this->load->view("_partials/modal");?>
<?php $this->load->view("_partials/footer");?>