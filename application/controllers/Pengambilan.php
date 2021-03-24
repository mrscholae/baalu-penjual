<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pengambilan extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->model("Main_model");
    
        // Load Pagination library
        $this->load->library('pagination');
    
        // Load model
        $this->load->model('Pengambilan_model');
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Maaf Anda harus login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div');
			redirect(base_url("auth"));
		}
    }
    
    public function index(){
        // for if statement navbar fitur
        $data['navbar'] = "Menunggu Pengambilan";

        // for title and header 
        $data['title'] = "Menunggu Pengambilan";
        
        // for sidebar 
        $data['sidebar'] = "home";

        // for modal 
        $data['modal'] = ["modal_pengiriman"];
        
        // javascript 
        $data['js'] = [
            "modules/other.js", 
            // "modules/pengiriman.js",
            "load_data/reload_pengambilan.js",
        ];

        $this->load->view("pages/pengambilan/list-pengambilan", $data);
    }

    public function indexes(){
        $this->load->view('pages/pengambilan/index');
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

    public function loadRecord($rowno=0){

        $penjual = $this->_data_penjual();

        // Row per page
        $rowperpage = 6;
    
        // Row position
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
     
        // All records count
        // $allcount = $this->Pengambilan_model->getrecordCount();
        $allcount = COUNT($this->Main_model->get_all("pengiriman", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0, "status" => "Proses"], "tgl_pengambilan"));
    
        // Get records
        $record = $this->Main_model->get_all_limit("pengiriman", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0, "status" => "Proses"], "tgl_pengambilan", "ASC", $rowno, $rowperpage);
        $users_record = [];

        foreach ($record as $i => $record) {
            $users_record[$i] = $record;
            $users_record[$i]['tgl_pengiriman'] = date("d-M-y H:i", strtotime($record['tgl_pengiriman']));
            $users_record[$i]['tgl_pengambilan'] = date("d-M-y H:i", strtotime($record['tgl_pengambilan']));
        }
        // $users_record = $this->Pengambilan_model->getData($rowno,$rowperpage);
     
        // Pagination Configuration
        $config['base_url'] = base_url().'pengambilan/loadRecord';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;

        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = '>>';
        $config['prev_link']        = '<<';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination pagination-md justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
    
        // Initialize
        $this->pagination->initialize($config);
    
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        $data['total_rows'] = $allcount;
        $data['total_rows_perpage'] = COUNT($users_record);
    
        echo json_encode($data);
     
    }
}

/* End of file Pengambilan.php */
