<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {

    
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
        $data['navbar'] = "Bahan";

        // for title and header 
        $data['title'] = "List Bahan";
        
        // for sidebar 
        $data['sidebar'] = "bahan";

        // for modal 
        $data['modal'] = ["modal_bahan"];
        
        // for js 
        $data['js'] = [
            "modules/other.js", 
            "modules/bahan.js",
            "load_data/reload_bahan.js",
        ];

        $this->load->view("pages/bahan/list-bahan", $data);
    }

    // ajax 
        public function ajax_list_bahan(){
            $penjual = $this->_data_penjual();
            $bahan = $this->Main_model->get_all("bahan", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_bahan");
            foreach ($bahan as $i => $bahan) {
                $data[$i] = $bahan;
                $data[$i]['satuan'] = $bahan['satuan'];
                $data[$i]['harga_satuan'] = $this->Main_model->rupiah($bahan['harga_satuan']);
                $data[$i]['min_stok'] = $bahan['min_stok'] . " " . $bahan['satuan'];
                
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
                
                $data[$i]['stok'] = $qty;
            }

            echo json_encode($data);
        }
    // ajax 

    // add 
        public function add_bahan(){
            $penjual = $this->_data_penjual();

            $data = [
                "nama_bahan" => $this->input->post("nama_bahan"),
                "jenis" => $this->input->post("jenis"),
                "satuan" => $this->input->post("satuan"),
                "harga_satuan" => $this->Main_model->nominal($this->input->post("harga_satuan")),
                "min_stok" => $this->input->post("min_stok"),
                "id_penjual" => $penjual['id_penjual']
            ];

            $data = $this->Main_model->add_data("bahan", $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // add 
    
    // get 
        public function get_bahan(){
            $id_bahan = $this->input->post("id_bahan");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_one("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']]);
            echo json_encode($data);
        }

        public function get_all_bahan(){
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("bahan", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_bahan");
            echo json_encode($data);
        }

        public function get_all_bahan_produksi(){
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("bahan", ["id_penjual" => $penjual['id_penjual'], "jenis" => "Produksi", "hapus" => 0], "nama_bahan");
            echo json_encode($data);
        }
        
    // get 

    // edit 
        public function edit_bahan(){
            $penjual = $this->_data_penjual();
            $id_bahan = $this->input->post("id_bahan");
            
            $data = [
                "nama_bahan" => $this->input->post("nama_bahan"),
                "jenis" => $this->input->post("jenis"),
                "satuan" => $this->input->post("satuan"),
                "harga_satuan" => $this->Main_model->nominal($this->input->post("harga_satuan")),
                "min_stok" => $this->input->post("min_stok"),
            ];

            $data = $this->Main_model->edit_data("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']], $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // edit 

    // delete 
        public function hapus_bahan(){
            $id_bahan = $this->input->post("id_bahan");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
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

/* End of file Bahan.php */
