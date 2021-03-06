<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pengambilan extends CI_Controller {

    
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
        $data['navbar'] = "Menunggu Pengambilan";

        // for title and header 
        $data['title'] = "Menunggu Pengambilan";
        
        // for sidebar 
        $data['sidebar'] = "home";

        $this->load->view("pages/pengambilan/list-pengambilan", $data);
    }

    public function ajax_pengambilan(){
        
        $penjual = $this->_data_penjual();
            
        $pengiriman = $this->Main_model->get_all("pengiriman", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0, "status" => "Proses"], "tgl_pengambilan");

        $data['pengiriman'] = [];
        foreach ($pengiriman as $i => $pengiriman) {
            $data['pengiriman'][$i] = $pengiriman;
            $data['pengiriman'][$i]['tgl_pengiriman'] = date("d-M-y", strtotime($pengiriman['tgl_pengiriman']));
            $data['pengiriman'][$i]['tgl_pengambilan'] = date("d-M-y", strtotime($pengiriman['tgl_pengambilan']));
        }

        echo json_encode($data);
    }

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }
}

/* End of file Pengambilan.php */
