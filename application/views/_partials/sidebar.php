        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:void(0)">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-bread-slice"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="home">
                <a class="nav-link" href="<?= base_url()?>home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            
            <li class="nav-item" id="toko">
                <a class="nav-link" href="<?= base_url()?>toko">
                    <i class="fas fa-store"></i>
                    <span>Toko</span>
                </a>
            </li>

            <li class="nav-item" id="produk">
                <a class="nav-link" href="<?= base_url()?>produk">
                    <i class="fas fa-cookie-bite"></i>
                    <span>Produk</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->