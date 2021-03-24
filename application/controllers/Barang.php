<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Main_model");
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Maaf Anda harus login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div');
			redirect(base_url("auth"));
		}
    }
    
    public function index()
    {
        // for if statement navbar fitur
        $data['navbar'] = "Barang";

        // for title and header 
        $data['title'] = "List Barang";
        
        // for sidebar 
        $data['sidebar'] = "barang";

        // for modal 
        $data['modal'] = ["modal_barang"];
        
        // for js 
        $data['js'] = [
            "modules/other.js", 
            "modules/barang.js",
            "load_data/reload_barang.js",
        ];

        $this->load->view("pages/barang/list-barang", $data);
    }

    // ajax 
        public function ajax_list_barang(){
            $penjual = $this->_data_penjual();
            $barang = $this->Main_model->get_all("barang", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($barang as $i => $barang) {
                $data[$i] = $barang;
                $data[$i]['tgl_rilis'] = date("d-M-Y", strtotime($barang['tgl_rilis']));
                $data[$i]['harga'] = $this->Main_model->rupiah($barang['harga']);
                $data[$i]['bagi_hasil'] = $this->Main_model->rupiah($barang['bagi_hasil']);

                $qty = 0;
                $produksi = $this->Main_model->get_all("detail_produksi_barang", ["id_barang" => $barang['id_barang'], "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
                foreach ($produksi as $produksi) {
                    $qty += ($produksi['berhasil'] + $produksi['gagal']);
                }
                
                $pengiriman = $this->Main_model->get_all("detail_pengiriman", ["id_barang" => $barang['id_barang'], "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
                foreach ($pengiriman as $pengiriman) {
                    $qty -= $pengiriman['kirim'];
                }

                $data[$i]['stok'] = $qty;
            }

            echo json_encode($data);
        }
    // ajax 

    // add 
        public function add_barang(){
            $penjual = $this->_data_penjual();

            $data = [
                "nama_barang" => $this->input->post("nama_barang"),
                "kode_barang" => $this->input->post("kode_barang"),
                "tgl_rilis" => $this->input->post("tgl_rilis"),
                "harga" => $this->Main_model->nominal($this->input->post("harga")),
                "bagi_hasil" => $this->Main_model->nominal($this->input->post("bagi_hasil")),
                "id_penjual" => $penjual['id_penjual']
            ];

            $data = $this->Main_model->add_data("barang", $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // add 
    
    // get 
        public function get_barang(){
            $id_barang = $this->input->post("id_barang");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_one("barang", ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual']]);
            echo json_encode($data);
        }

        public function get_all_barang(){
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("barang", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_barang");
            echo json_encode($data);
        }
    // get 

    // edit 
        public function edit_barang(){
            $penjual = $this->_data_penjual();
            $id_barang = $this->input->post("id_barang");
            
            $data = [
                "id_barang" => $this->input->post("id_barang"),
                "nama_barang" => $this->input->post("nama_barang"),
                "kode_barang" => $this->input->post("kode_barang"),
                "harga" => $this->Main_model->nominal($this->input->post("harga")),
                "bagi_hasil" => $this->Main_model->nominal($this->input->post("bagi_hasil")),
                "tgl_rilis" => $this->input->post("tgl_rilis"),
            ];

            $data = $this->Main_model->edit_data("barang", ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual']], $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // edit 

    // delete 
        public function hapus_barang(){
            $id_barang = $this->input->post("id_barang");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("barang", ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // delete 

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }
}

/* End of file Barang.php */
