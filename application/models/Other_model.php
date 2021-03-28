<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Other_model extends CI_Model {

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }

    function sortArray(){
        $funcArgument = func_get_args();
        $content = array_shift($funcArgument);

        foreach ($funcArgument as $n => $field) {

            if (is_string($field)) {
                $tmp = array();
                foreach ($content as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $funcArgument[$n] = $tmp;
            }

        }

        $funcArgument[] = & $content;
        call_user_func_array('array_multisort', $funcArgument);
        return array_pop($funcArgument);
    }

    function stokBarang($id_barang){
        $penjual = $this->_data_penjual();

        $qty = 0;
        $produksi = $this->Main_model->get_all("detail_produksi_barang", ["id_barang" => $id_barang, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
        foreach ($produksi as $produksi) {
            $qty += $produksi['berhasil'];
        }
        
        $pengiriman = $this->Main_model->get_all("detail_pengiriman", ["id_barang" => $id_barang, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
        foreach ($pengiriman as $pengiriman) {
            $qty -= $pengiriman['kirim'];
        }


        // pembelian pelanggan 
        $pembelian = $this->Main_model->get_all("detail_pembelian_pelanggan", ["id_barang" => $id_barang, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
        foreach ($pembelian as $pembelian) {
            $qty -= $pembelian['qty'];
        }

        return $qty;
    }
}

/* End of file Other_model.php */
