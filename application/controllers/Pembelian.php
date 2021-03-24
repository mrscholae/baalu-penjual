<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->model("Main_model");
    
        // Load Pagination library
        $this->load->library('pagination');
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Maaf Anda harus login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div');
			redirect(base_url("auth"));
		}
    }
    
    public function index(){
        // for if statement navbar fitur
        $data['navbar'] = "Pembelian";

        // for title and header 
        $data['title'] = "List Pembelian";
        
        // for sidebar 
        $data['sidebar'] = "pembelian";

        // for modal 
        $data['modal'] = ["modal_pembelian"];
        
        // javascript 
        $data['js'] = [
            "modules/other.js", 
            "modules/pembelian.js",
            "load_data/reload_pembelian.js",
        ];

        $this->load->view("pages/page", $data);
    }

    public function ajax_pembelian(){
        
        $penjual = $this->_data_penjual();
            
        $pembelian = $this->Main_model->get_all("pembelian", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "tgl_pembelian");

        $data['pembelian'] = [];
        foreach ($pembelian as $i => $pembelian) {
            $data['pembelian'][$i] = $pembelian;
            $data['pembelian'][$i]['tgl_pembelian'] = date("d-M-y", strtotime($pembelian['tgl_pembelian']));
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
        // $allcount = $this->Pembelian_model->getrecordCount();
        $allcount = COUNT($this->Main_model->get_all("pembelian", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "tgl_pembelian"));
    
        // Get records
        $record = $this->Main_model->get_all_limit("pembelian", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "tgl_pembelian", "DESC", $rowno, $rowperpage);

        $users_record = [];

        foreach ($record as $i => $record) {
            $users_record[$i] = $record;
            $users_record[$i]['tgl_pembelian'] = date("d-M-Y H:i", strtotime($record['tgl_pembelian']));
            $detail = $this->Main_model->get_all("detail_pembelian_bahan", ["id_pembelian" => $record['id_pembelian'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            
            $harga_total = 0;
            foreach ($detail as $detail) {
                $harga_total += $detail['harga_total'];
            }

            $users_record[$i]['harga_total'] = $this->Main_model->rupiah($harga_total);
        }
        // $users_record = $this->Pembelian_model->getData($rowno,$rowperpage);
     
        // Pagination Configuration
        $config['base_url'] = base_url().'pembelian/loadRecord';
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
    
    // add 
        public function add_pembelian(){
            $penjual = $this->_data_penjual();
                
            $data = [
                "tgl_pembelian" => $this->input->post("tgl_pembelian"),
                "id_penjual" => $penjual['id_penjual'],
            ];

            $id_pembelian = $this->Main_model->add_data("pembelian", $data);
            
            $id_bahan = $this->input->post("id_bahan");
            $qty = $this->input->post("qty");
            $harga_total = $this->input->post("harga_total");

            foreach ($id_bahan as $i => $id_bahan) {
                if($qty[$i] != 0) {
                    $bahan = $this->Main_model->get_one("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']]);
                    
                    $data = [
                        "id_pembelian" => $id_pembelian,
                        "id_bahan" => $id_bahan,
                        "nama_bahan" => $bahan['nama_bahan'],
                        "harga_total" => $this->Main_model->nominal($harga_total[$i]),
                        "qty" => $qty[$i],
                        "satuan" => $bahan['satuan'],
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("detail_pembelian_bahan", $data);
                }
            }

            echo json_encode("1");
        }

        public function add_bahan_pembelian(){
            $penjual = $this->_data_penjual();
            
            $id_pembelian = $this->input->post("id_pembelian");
                
            $id_bahan = $this->input->post("id_bahan");
            $qty = $this->input->post("qty");
            $harga_total = $this->input->post("harga_total");

            $success = 0;

            foreach ($id_bahan as $i => $id_bahan) {
                $bahan = $this->Main_model->get_one("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']]);
                if($qty[$i] != 0) {
                    $data = [
                        "id_pembelian" => $id_pembelian,
                        "id_bahan" => $id_bahan,
                        "nama_bahan" => $bahan['nama_bahan'],
                        "harga_total" => $this->Main_model->nominal($harga_total[$i]),
                        "qty" => $qty[$i],
                        "satuan" => $bahan['satuan'],
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("detail_pembelian_bahan", $data);

                    $success = 1;
                }
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // add 

    // get 
        public function get_detail_pembelian(){
            $penjual = $this->_data_penjual();
            $id_pembelian = $this->input->post("id_pembelian");

            $pembelian = $this->Main_model->get_one("pembelian", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['pembelian'] = $pembelian;
            $data['pembelian']['tgl_pembelian_format'] = date('Y-m-d', strtotime($pembelian['tgl_pembelian'])) . "T" . date('H:i', strtotime($pembelian['tgl_pembelian']));
            $data['pembelian']['tgl_pembelian'] = date("d-M-Y", strtotime($pembelian['tgl_pembelian']));

            $detail = $this->Main_model->get_all("detail_pembelian_bahan", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['detail_pembelian'] = [];
            $total = 0;

            foreach ($detail as $i => $detail) {
                $data['detail_pembelian'][$i] = $detail;
                $data['detail_pembelian'][$i]['harga_satuan'] = strval($detail['harga_total'] / $detail['qty']);
                $total += $detail['harga_total'];
            }

            $data['total'] = "".$total;

            echo json_encode($data);
        }

        // daftar seluruh bahan yang belum dijual di suatu toko
        public function get_all_bahan_belum_dikirim(){

            $penjual = $this->_data_penjual();
            $id_pembelian = $this->input->post("id_pembelian");

            // tampilkan seluruh bahan 
            $a = [];
            $b = [];
            $data = [];
            
            // peserta kelas 
            $y = $this->Main_model->get_all("detail_pembelian_bahan", ["id_pembelian" => $id_pembelian, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            foreach ($y as $i => $y) {
                $b[$i] = $y['id_bahan'];
            }

            // calon bahan toko
            $x = $this->Main_model->get_all("bahan", ["hapus" => "0", "id_penjual" => $penjual['id_penjual']], "nama_bahan");
            $i = 0;
            foreach ($x as $x) {
                if(!in_array($x['id_bahan'], $b)){
                    $data[$i] = $x;
                    $i++;
                }
            }

            echo json_encode($data);
        }
    // get 

    // edit 
        public function edit_pembelian(){
            $penjual = $this->_data_penjual();
            $id_pembelian = $this->input->post("id_pembelian");

            $data = [
                "tgl_pembelian" => $this->input->post("tgl_pembelian"),
            ];

            $data = $this->Main_model->edit_data("pembelian", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual']], $data);

            if($data) {
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function edit_bahan_pembelian(){
            
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id_detail");
            $qty = $this->input->post("qty");
            $harga_total = $this->input->post("harga_total");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = [
                    "qty" => $qty[$i],
                    "harga_total" => $this->Main_model->nominal($harga_total[$i]),
                ];

                $this->Main_model->edit_data("detail_pembelian_bahan", ["id" => $id, "id_penjual" => $penjual['id_penjual']], $data);
                $success = 1;
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // edit 

    // delete 
        public function hapus_pembelian(){
            $id_pembelian = $this->input->post("id_pembelian");
            $penjual = $this->_data_penjual();

            $this->Main_model->edit_data("detail_pembelian_bahan", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            $data = $this->Main_model->edit_data("pembelian", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_detail_pembelian(){
            $id = $this->input->post("id");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("detail_pembelian_bahan", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // delete 

}

/* End of file Pembelian.php */
