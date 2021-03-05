<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Main_model");
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', 'cek');
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

        $this->load->view("pages/barang/list-barang", $data);
    }

    // ajax 
        public function ajax_list_barang(){
            $penjual = $this->_data_penjual();
            $barang = $this->Main_model->get_all("barang", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($barang as $i => $barang) {
                $data[$i] = $barang;
                $data[$i]['tgl_rilis'] = date("d-M-Y", strtotime($barang['tgl_rilis']));
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

            $data = $this->Main_model->get_all("barang", ["id_penjual" => $penjual['id_penjual']], "nama_barang");
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


    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }
}

/* End of file Barang.php */
