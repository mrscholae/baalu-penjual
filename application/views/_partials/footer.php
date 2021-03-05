
                </div>
                <!-- end container fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; baalu 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url()?>assets/js/sb-admin-2.min.js"></script>

    <script src="<?= base_url()?>assets/js/modal.js"></script>
    
    <script>
        $("#<?= $sidebar?>").addClass("active");
    </script>
    <?php
        if($navbar == "Barang") $this->load->view("../../assets/js/ajax_barang");
        elseif($navbar == "Toko") $this->load->view("../../assets/js/ajax_toko");
        elseif($navbar == "Detail Toko") $this->load->view("../../assets/js/detail_toko");
        elseif($navbar == "Menunggu Pengambilan") $this->load->view("../../assets/js/ajax_pengambilan");
        
    ?>
</body>

</html>