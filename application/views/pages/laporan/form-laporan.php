<?php $this->load->view("_partials/header");?>
    
    <div class="row" id="dataAjax">
        
        <div class="col-12 col-md-6">
            <form action="<?= base_url()?>laporan/print" method="POST">
                
                <div class="form-group">
                    <label for="laporan">Laporan</label>
                    <select name="laporan" id="laporan" class="form-control form-control-md">
                        <option value="">Pilih Laporan</option>
                        <option value="Laporan Penjualan">Laporan Penjualan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tgl_awal">Tgl. Awal</label>
                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control form-control-md">
                </div>

                
                <div class="form-group">
                    <label for="tgl_akhir">Tgl. Akhir</label>
                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control form-control-md">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">cetak</button>
                </div>

            </form>
        </div>

    </div>

<?php $this->load->view("_partials/footer");?>