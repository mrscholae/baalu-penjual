<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Main_model");
        $this->load->model("Other_model");
    }

    public function alert_stok_bahan(){
        $penjual = $this->Other_model->_data_penjual();

        $data = [];

        $bahan = $this->Main_model->get_all("bahan", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_bahan");
        
        $i = 0;
        foreach ($bahan as $bahan) {
            
            
            $qty = 0;
            // pembelian bahan 
            $stok = $this->Main_model->get_all("detail_pembelian_bahan", ["id_bahan" => $bahan['id_bahan'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($stok as $stok) {
                $qty += $stok['qty'];
            }

            // produksi bahan 
            $stok = $this->Main_model->get_all("detail_produksi_bahan", ["id_bahan" => $bahan['id_bahan'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($stok as $stok) {
                $qty += $stok['qty'];
            }

            // penggunaan bahan 
            $stok = $this->Main_model->get_all("bahan_produksi", ["id_bahan" => $bahan['id_bahan'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($stok as $stok) {
                $qty -= $stok['qty'];
            }
            
            if($qty < $bahan['min_stok']){
                $data[$i] = $bahan;
                $data[$i]['stok'] = $qty;

                $i++;
            }
        }

        return $data;
    }

}

/* End of file Home_model.php */
