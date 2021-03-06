<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {

    
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
        $data['navbar'] = "Toko";

        // for title and header 
        $data['title'] = "List Toko";
        
        // for sidebar 
        $data['sidebar'] = "toko";

        $this->load->view("pages/toko/list-toko", $data);
    }

    public function detail($id)
    {
        $penjual = $this->_data_penjual();
        $toko = $this->Main_model->get_one("toko", ["md5(id_toko)" => $id, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
        
        if($toko) {
            // for if statement navbar fitur
            $data['navbar'] = "Detail Toko";
    
            // for title and header 
            $data['title'] = $toko['nama_toko'];
            
            // for sidebar 
            $data['sidebar'] = "toko";

            // id toko untuk memanggil ajax 
            $data['id_toko'] = md5($toko['id_toko']);
    
            $this->load->view("pages/toko/detail-toko", $data);
        } else {
            redirect(base_url("toko"));
        }
    }
    
    // ajax 
        public function ajax_list_toko(){
            $penjual = $this->_data_penjual();
            $toko = $this->Main_model->get_all("toko", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($toko as $i => $toko) {
                $data[$i] = $toko;
                $data[$i]['link_toko'] = md5($toko['id_toko']);
                $pengiriman = COUNT($this->Main_model->get_all("pengiriman", ["id_toko" => $toko['id_toko'], "hapus" => 0]));
                $data[$i]['pengiriman'] = $pengiriman;
            }

            echo json_encode($data);
        }

        
        public function ajax_toko($id_toko){
            $penjual = $this->_data_penjual();
            
            $toko = $this->Main_model->get_one("toko", ["md5(id_toko)" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $pengiriman = $this->Main_model->get_all("pengiriman", ["id_toko" => $toko['id_toko'], "hapus" => 0]);
            
            $data['toko'] = $toko;
            $data['toko']['tgl_bergabung'] = date("d-M-y", strtotime($toko['tgl_bergabung']));
            $data['toko']['pengiriman'] = COUNT($pengiriman);

            $data['pengiriman'] = [];
            foreach ($pengiriman as $i => $pengiriman) {
                $data['pengiriman'][$i] = $pengiriman;
                $data['pengiriman'][$i]['tgl_pengiriman'] = date("d-M-y", strtotime($pengiriman['tgl_pengiriman']));
                $data['pengiriman'][$i]['tgl_pengambilan'] = date("d-M-y", strtotime($pengiriman['tgl_pengambilan']));
            }


            echo json_encode($data);
        }
    // ajax 

    // add 
        public function add_toko(){
            $penjual = $this->_data_penjual();

            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_toko" => $this->input->post("nama_toko"),
                "alamat" => $this->input->post("alamat"),
                "pj" => $this->input->post("pj"),
                "no_hp" => $this->input->post("no_hp"),
                "id_penjual" => $penjual['id_penjual']
            ];

            $data = $this->Main_model->add_data("toko", $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function add_barang_toko(){
            $penjual = $this->_data_penjual();

            $data = [
                "id_barang" => $this->input->post("id_barang"),
                "id_toko" => $this->input->post("id_toko"),
                "id_penjual" => $penjual['id_penjual']
            ];

            $data = $this->Main_model->add_data("barang_toko", $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function add_pengiriman(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");

            $toko = $this->Main_model->get_one("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual']]);

            if($toko){
                
                $data = [
                    "id_toko" => $id_toko,
                    "nama_toko" => $toko['nama_toko'],
                    "pj" => $toko['pj'],
                    "no_hp" => $toko['no_hp'],
                    "alamat" => $toko['alamat'],
                    "tgl_pengiriman" => $this->input->post("tgl_pengiriman"),
                    "tgl_pengambilan" => $this->input->post("tgl_pengambilan"),
                    "status" => "Proses",
                    "id_penjual" => $penjual['id_penjual'],
                ];

                $id_pengiriman = $this->Main_model->add_data("pengiriman", $data);
                
                $id_barang = $this->input->post("id_barang");
                $qty = $this->input->post("qty");

                foreach ($id_barang as $i => $id_barang) {
                    if($qty[$i] != 0) {
                        $data = [
                            "id_pengiriman" => $id_pengiriman,
                            "id_barang" => $id_barang,
                            "kirim" => $qty[$i],
                            "kembali" => "0",
                            "id_penjual" => $penjual['id_penjual']
                        ];
    
                        $this->Main_model->add_data("detail_pengiriman", $data);
                    }
                }

                echo json_encode("1");

            } else {
                echo json_encode("0");
            }
        }

        public function add_pengambilan(){
            $penjual = $this->_data_penjual();
            $id_pengiriman = $this->input->post("id_pengiriman");

            $pengiriman = $this->Main_model->get_one("pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']]);
            if($pengiriman){
                
                $this->Main_model->edit_data("pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']], ["status" => "Selesai"]);

                $id_detail = $this->input->post("id_detail");
                $qty = $this->input->post("qty");

                foreach ($id_detail as $i => $id_detail) {
                    $this->Main_model->edit_data("detail_pengiriman", ["id" => $id_detail, "id_penjual" => $penjual['id_penjual']], ["kembali" => $qty[$i]]);
                }

                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function add_barang_pengiriman(){
            $penjual = $this->_data_penjual();
            
            $id_pengiriman = $this->input->post("id_pengiriman");
                
            $id_barang = $this->input->post("id_barang");
            $qty = $this->input->post("qty");

            $success = 0;

            foreach ($id_barang as $i => $id_barang) {
                if($qty[$i] != 0) {
                    $data = [
                        "id_pengiriman" => $id_pengiriman,
                        "id_barang" => $id_barang,
                        "kirim" => $qty[$i],
                        "kembali" => "0",
                        "id_penjual" => $penjual['id_penjual']
                    ];

                    $this->Main_model->add_data("detail_pengiriman", $data);

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
        public function get_toko(){
            $id_toko = $this->input->post("id_toko");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_one("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual']]);
            echo json_encode($data);
        }

        public function get_detail_pengiriman(){
            $penjual = $this->_data_penjual();
            $id_pengiriman = $this->input->post("id_pengiriman");

            $pengiriman = $this->Main_model->get_one("pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']]);
            $data['pengiriman'] = $pengiriman;
            $data['pengiriman']['tgl_pengiriman_format'] = $pengiriman['tgl_pengiriman'];
            $data['pengiriman']['tgl_pengambilan_format'] = $pengiriman['tgl_pengambilan'];
            $data['pengiriman']['tgl_pengiriman'] = date("d-M-y", strtotime($pengiriman['tgl_pengiriman']));
            $data['pengiriman']['tgl_pengambilan'] = date("d-M-y", strtotime($pengiriman['tgl_pengambilan']));
            $detail_pengiriman = $this->Main_model->get_all("detail_pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            $data['detail_pengiriman'] = [];

            foreach ($detail_pengiriman as $i => $detail) {
                $data['detail_pengiriman'][$i] = $detail;
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $detail['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['detail_pengiriman'][$i]['kode_barang'] = $barang['kode_barang'];
                $data['detail_pengiriman'][$i]['nama_barang'] = $barang['nama_barang'];
            }

            echo json_encode($data);
        }

        // barang yang dijual di suatu toko 
        public function get_barang_toko(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");

            $data = [];
            $barang_toko = $this->Main_model->get_all("barang_toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($barang_toko as $i => $barang_toko) {
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $barang_toko['id_barang']]);
                $data[$i] = $barang;
                $data[$i]['id'] = $barang_toko['id'];
            }
            
            $columns = array_column($data, 'nama_barang');
            array_multisort($columns, SORT_ASC, $data);
            echo json_encode($data);
        }

        // daftar seluruh barang yang belum dijual di suatu toko
        public function get_all_barang_belum_dikirim(){

            $penjual = $this->_data_penjual();
            $id_pengiriman = $this->input->post("id_pengiriman");

            // tampilkan seluruh barang 
            $a = [];
            $b = [];
            $data = [];
            
            // peserta kelas 
            $y = $this->Main_model->get_all("detail_pengiriman", ["id_pengiriman" => $id_pengiriman, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
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
    // get 

    // edit 
        public function edit_toko(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");
            
            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_toko" => $this->input->post("nama_toko"),
                "alamat" => $this->input->post("alamat"),
                "pj" => $this->input->post("pj"),
                "no_hp" => $this->input->post("no_hp"),
            ];

            $data = $this->Main_model->edit_data("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual']], $data);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function edit_pengiriman(){
            $penjual = $this->_data_penjual();
            $id_pengiriman = $this->input->post("id_pengiriman");

            $data = [
                "tgl_pengiriman" => $this->input->post("tgl_pengiriman"),
                "tgl_pengambilan" => $this->input->post("tgl_pengambilan"),
            ];

            $data = $this->Main_model->edit_data("pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']], $data);

            if($data) {
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function edit_barang_pengiriman(){
            
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id_detail");
            $qty = $this->input->post("qty");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = $this->Main_model->edit_data("detail_pengiriman", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["kirim" => $qty[$i]]);
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
        public function hapus_toko(){
            $id_toko = $this->input->post("id_toko");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_barang_toko(){
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id");
            
            $data = $this->Main_model->edit_data("barang_toko", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

         
        public function hapus_pengiriman(){
            $id_pengiriman = $this->input->post("id_pengiriman");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                $this->Main_model->edit_data("detail_pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_detail_pengiriman(){
            $id = $this->input->post("id");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("detail_pengiriman", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            
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

/* End of file Toko.php */
