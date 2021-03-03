<?php $this->load->view("_partials/header");?>
        
    <div class="col-12 col-md-4">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Marewo Bakery Cokelat</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Data Produk</div>
                        <a class="dropdown-item" href="#">Detail</a>
                        <a class="dropdown-item" href="#editProduk" data-toggle="modal">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Hapus</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <i class="fa fa-id-card mr-3"></i> MBC <br>
                <i class="fa fa-calendar-alt mr-3"></i> 21 Jan 2021
            </div>
        </div>
    </div>

    
    <div class="col-12 col-md-4">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Marewo Bakery Keju</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Data Produk</div>
                        <a class="dropdown-item" href="#">Detail</a>
                        <a class="dropdown-item" href="#editProduk" data-toggle="modal">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Hapus</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <i class="fa fa-id-card mr-3"></i> MBK <br>
                <i class="fa fa-calendar-alt mr-3"></i> 21 Jan 2021
            </div>
        </div>
    </div>

<?php $this->load->view("_partials/modal");?>
<?php $this->load->view("_partials/footer");?>