<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {

    
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
        $data['navbar'] = "Produksi";

        // for title and header 
        $data['title'] = "List Produksi";
        
        // for sidebar 
        $data['sidebar'] = "produksi";

        // for modal 
        $data['modal'] = ["modal_produksi"];
        
        // javascript 
        $data['js'] = [
            "modules/other.js", 
            "modules/produksi.js",
            "modal.js",
            "load_data/reload_produksi.js",
        ];

        $this->load->view("pages/page", $data);
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
        // $allcount = $this->Produksi_model->getrecordCount();
        $allcount = COUNT($this->Main_model->get_all("produksi", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "tgl_produksi"));
    
        // Get records
        $record = $this->Main_model->get_all_limit("produksi", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "tgl_produksi", "DESC", $rowno, $rowperpage);

        $users_record = [];

        foreach ($record as $i => $record) {
            $users_record[$i] = $record;
            $users_record[$i]['tgl_produksi'] = date("d-M-Y H:i", strtotime($record['tgl_produksi']));
            $detail = $this->Main_model->get_all("bahan_produksi", ["id_produksi" => $record['id_produksi'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            
            // if(!$detail){
            //     $data['']
            // }
            $harga_total = 0;
            foreach ($detail as $detail) {
                $harga_total += ($detail['harga_satuan'] * $detail['qty']);
            }

            $users_record[$i]['harga_total'] = $this->Main_model->rupiah($harga_total);

            $users_record[$i]['bahan_produksi'] = COUNT($this->Main_model->get_all("bahan_produksi", ["id_produksi" => $record['id_produksi'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]));
            if($record['tipe_produksi'] == "Produksi Barang")
                $users_record[$i]['produksi_barang'] = COUNT($this->Main_model->get_all("detail_produksi_barang", ["id_produksi" => $record['id_produksi'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]));
            elseif($record['tipe_produksi'] == "Produksi Bahan")
                $users_record[$i]['produksi_bahan'] = COUNT($this->Main_model->get_all("detail_produksi_bahan", ["id_produksi" => $record['id_produksi'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]));
        }
        // $users_record = $this->Produksi_model->getData($rowno,$rowperpage);
     
        // Pagination Configuration
        $config['base_url'] = base_url().'produksi/loadRecord';
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
        public function add_produksi(){
            $penjual = $this->_data_penjual();
                
            $data = [
                "tgl_produksi" => $this->input->post("tgl_produksi"),
                "tipe_produksi" => $this->input->post("tipe_produksi"),
                "id_penjual" => $penjual['id_penjual'],
            ];

            $id_produksi = $this->Main_model->add_data("produksi", $data);

            echo json_encode("1");
        }

        public function add_bahan_produksi(){
            $penjual = $this->_data_penjual();
            
            $id_produksi = $this->input->post("id_produksi");

            $id_bahan = $this->input->post("id_bahan");
            $qty = $this->input->post("qty");
            $harga_satuan = $this->input->post("harga_satuan");

            $success = 0;

            foreach ($id_bahan as $i => $id_bahan) {
                $bahan = $this->Main_model->get_one("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']]);
                if($qty[$i] != 0) {
                    $data = [
                        "id_produksi" => $id_produksi,
                        "id_bahan" => $id_bahan,
                        "nama_bahan" => $bahan['nama_bahan'],
                        "harga_satuan" => $this->Main_model->nominal($harga_satuan[$i]),
                        "qty" => $qty[$i],
                        "satuan" => $bahan['satuan'],
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("bahan_produksi", $data);

                    $success = 1;
                }
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function add_barang_produksi(){
            $penjual = $this->_data_penjual();
            
            $id_produksi = $this->input->post("id_produksi");

            $id_barang = $this->input->post("id_barang");
            $berhasil = $this->input->post("berhasil");
            $gagal = $this->input->post("gagal");

            $success = 0;

            foreach ($id_barang as $i => $id_barang) {
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual']]);
                if($berhasil[$i] != 0) {
                    $data = [
                        "id_produksi" => $id_produksi,
                        "id_barang" => $id_barang,
                        "nama_barang" => $barang['nama_barang'],
                        "berhasil" => $berhasil[$i],
                        "gagal" => $gagal[$i],
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("detail_produksi_barang", $data);

                    $success = 1;
                }
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function add_produksi_bahan(){
            $penjual = $this->_data_penjual();
            
            $id_produksi = $this->input->post("id_produksi");

            $id_bahan = $this->input->post("id_bahan");
            $qty = $this->input->post("qty");

            $success = 0;

            foreach ($id_bahan as $i => $id_bahan) {
                $bahan = $this->Main_model->get_one("bahan", ["id_bahan" => $id_bahan, "id_penjual" => $penjual['id_penjual']]);
                if($qty[$i] != 0) {
                    $data = [
                        "id_produksi" => $id_produksi,
                        "id_bahan" => $id_bahan,
                        "nama_bahan" => $bahan['nama_bahan'],
                        "qty" => $qty[$i],
                        "satuan" => $bahan['satuan'],
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("detail_produksi_bahan", $data);

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
        public function get_detail_produksi(){
            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            $produksi = $this->Main_model->get_one("produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['produksi'] = $produksi;
            // $data['produksi']['tgl_produksi_format'] = date('Y-m-d', strtotime($produksi['tgl_produksi'])) . "T" . date('H:i', strtotime($produksi['tgl_produksi']));
            $data['produksi']['tgl_produksi'] = date("d-M-Y H:i", strtotime($produksi['tgl_produksi']));

            // produksi barang 
            $detail = $this->Main_model->get_all("detail_produksi_barang", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['produksi_barang'] = [];

            foreach ($detail as $i => $detail) {
                $data['produksi_barang'][$i] = $detail;
                $data['produksi_barang'][$i]['total'] = $detail['berhasil'] + $detail['gagal'];
            }

            // produksi bahan 
            $detail = $this->Main_model->get_all("detail_produksi_bahan", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['produksi_bahan'] = [];

            foreach ($detail as $i => $detail) {
                $data['produksi_bahan'][$i] = $detail;
            }

            // bahan produksi  
            $detail = $this->Main_model->get_all("bahan_produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['bahan_produksi'] = [];

            $total = 0;
            foreach ($detail as $i => $detail) {
                $data['bahan_produksi'][$i] = $detail;
                $data['bahan_produksi'][$i]['harga_total'] = strval($detail['harga_satuan'] * $detail['qty']);
                $total += ($detail['qty'] * $detail['harga_satuan']);
            }

            $data['total'] = "".$total;

            echo json_encode($data);
        }

        // daftar seluruh barang yang belum dijual di suatu toko
        public function get_all_barang_belum_dikirim(){

            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            // tampilkan seluruh barang 
            $a = [];
            $b = [];
            $data = [];
            
            // peserta kelas 
            $y = $this->Main_model->get_all("detail_produksi_barang", ["id_produksi" => $id_produksi, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            foreach ($y as $i => $y) {
                $b[$i] = $y['id_barang'];
            }

            // calon barang toko
            $x = $this->Main_model->get_all("barang", ["hapus" => "0", "id_penjual" => $penjual['id_penjual']], "nama_barang");
            $i = 0;
            foreach ($x as $x) {
                if(!in_array($x['id_barang'], $b)){
                    $data[$i] = $x;
                    $i++;
                }
            }

            echo json_encode($data);
        }

        public function get_produksi(){
            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            $data = $this->Main_model->get_one("produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual']]);
            $data['tgl_produksi_format'] = date('Y-m-d', strtotime($data['tgl_produksi'])) . "T" . date('H:i', strtotime($data['tgl_produksi']));

            echo json_encode($data);
        }

        // bahan yang digunakan pada produksi 
        public function get_bahan_produksi(){
            $id_produksi = $this->input->post("id_produksi");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("bahan_produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            echo json_encode($data);
        }

        // bahan yang tidak digunakan pada produksi
        public function get_not_bahan_produksi(){

            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            // tampilkan seluruh bahan 
            $a = [];
            $b = [];
            $data = [];
            
            // bahan produksi 
            $y = $this->Main_model->get_all("bahan_produksi", ["id_produksi" => $id_produksi, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            foreach ($y as $i => $y) {
                $b[$i] = $y['id_bahan'];
            }

            // calon bahan produksi
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

        // barang yang digunakan pada produksi 
        public function get_barang_produksi(){
            $id_produksi = $this->input->post("id_produksi");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("detail_produksi_barang", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            echo json_encode($data);
        }

        // barang yang tidak digunakan pada produksi
        public function get_not_barang_produksi(){

            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            // tampilkan seluruh barang 
            $a = [];
            $b = [];
            $data = [];
            
            // barang produksi 
            $y = $this->Main_model->get_all("detail_produksi_barang", ["id_produksi" => $id_produksi, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            foreach ($y as $i => $y) {
                $b[$i] = $y['id_barang'];
            }

            // calon barang produksi
            $x = $this->Main_model->get_all("barang", ["hapus" => "0", "id_penjual" => $penjual['id_penjual']], "nama_barang");
            $i = 0;
            foreach ($x as $x) {
                if(!in_array($x['id_barang'], $b)){
                    $data[$i] = $x;
                    $i++;
                }
            }

            echo json_encode($data);
        }

        // bahan yang dihasilkan pada produksi 
        public function get_produksi_bahan(){
            $id_produksi = $this->input->post("id_produksi");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_all("detail_produksi_bahan", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            echo json_encode($data);
        }

        // bahan yang tidak dihasilkan pada produksi
        public function get_not_produksi_bahan(){

            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            // tampilkan seluruh bahan 
            $a = [];
            $b = [];
            $data = [];
            
            // produksi bahan 
            $y = $this->Main_model->get_all("detail_produksi_bahan", ["id_produksi" => $id_produksi, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            foreach ($y as $i => $y) {
                $b[$i] = $y['id_bahan'];
            }

            // calon barang produksi
            $x = $this->Main_model->get_all("bahan", ["hapus" => "0", "id_penjual" => $penjual['id_penjual'], "jenis" => "Produksi"], "nama_bahan");
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
        public function edit_produksi(){
            $penjual = $this->_data_penjual();
            $id_produksi = $this->input->post("id_produksi");

            $data = [
                "tgl_produksi" => $this->input->post("tgl_produksi"),
            ];

            $data = $this->Main_model->edit_data("produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual']], $data);

            if($data) {
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function edit_barang_produksi(){
            
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id_detail");
            $berhasil = $this->input->post("berhasil");
            $gagal = $this->input->post("gagal");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = [
                    "berhasil" => $berhasil[$i],
                    "gagal" => $gagal[$i],
                ];

                $this->Main_model->edit_data("detail_produksi_barang", ["id" => $id, "id_penjual" => $penjual['id_penjual']], $data);
                $success = 1;
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
        
        public function edit_bahan_produksi(){
            
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id_detail");
            $qty = $this->input->post("qty");
            $harga_satuan = $this->input->post("harga_satuan");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = [
                    "qty" => $qty[$i],
                    "harga_satuan" => $this->Main_model->nominal($harga_satuan[$i]),
                ];

                $this->Main_model->edit_data("bahan_produksi", ["id" => $id, "id_penjual" => $penjual['id_penjual']], $data);
                $success = 1;
            }

            if($success == 1){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function edit_produksi_bahan(){
            
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id_detail");
            $qty = $this->input->post("qty");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = [
                    "qty" => $qty[$i],
                ];

                $this->Main_model->edit_data("detail_produksi_bahan", ["id" => $id, "id_penjual" => $penjual['id_penjual']], $data);
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
        public function hapus_produksi(){
            $id_produksi = $this->input->post("id_produksi");
            $penjual = $this->_data_penjual();

            $this->Main_model->edit_data("bahan_produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            $this->Main_model->edit_data("detail_produksi_barang", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            $data = $this->Main_model->edit_data("produksi", ["id_produksi" => $id_produksi, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_bahan_produksi(){
            $id = $this->input->post("id");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("bahan_produksi", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_produksi_barang(){
            $id = $this->input->post("id");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("detail_produksi_barang", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_produksi_bahan(){
            $id = $this->input->post("id");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("detail_produksi_bahan", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
    // delete 

}

/* End of file Produksi.php */
