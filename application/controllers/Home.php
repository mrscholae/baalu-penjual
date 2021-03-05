<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    
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
        $penjual = $this->_data_penjual();
        
        // for if statement navbar fitur
        $data['navbar'] = "Home";

        // for title and header 
        $data['title'] = "Dashboard";

        // for sidebar 
        $data['sidebar'] = "home";

        $data['pengambilan'] = COUNT($this->Main_model->get_all("pengiriman", ["status" => "Proses", "hapus" => "0", "id_penjual" => $penjual['id_penjual']]));

        $this->load->view("pages/index", $data);
    }

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }

}

/* End of file Home.php */
