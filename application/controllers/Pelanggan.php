<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Main_model");
        $this->load->model("Other_model");
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Maaf Anda harus login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div');
			redirect(base_url("auth"));
		}
    }
    
    public function index(){
        // for if statement navbar fitur
        $data['navbar'] = "Pelanggan";

        // for title and header 
        $data['title'] = "List Pelanggan";
        
        // for sidebar 
        $data['sidebar'] = "pelanggan";

        // for modal 
        $data['modal'] = ["modal_pelanggan", "modal_pembelian_pelanggan"];

        // javascript 
        $data['js'] = [
            "modules/other.js", 
            "modules/pelanggan.js", 
            "modules/pembelian_pelanggan.js",
            "load_data/reload_pelanggan.js",
        ];
        
        $this->load->view("pages/pelanggan/list-pelanggan", $data);
    }

    public function detail($id){
        $penjual = $this->_data_penjual();
        $pelanggan = $this->Main_model->get_one("pelanggan", ["md5(id_pelanggan)" => $id, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
        
        if($pelanggan) {
            // for if statement navbar fitur
            $data['navbar'] = "Detail Pelanggan";
    
            // for title and header 
            $data['title'] = $pelanggan['nama_pelanggan'];
            
            // for sidebar 
            $data['sidebar'] = "pelanggan";

            // id pelanggan untuk memanggil ajax 
            $data['id_pelanggan'] = md5($pelanggan['id_pelanggan']);

            // for modal 
            $data['modal'] = ["modal_pelanggan", "modal_pembelian_pelanggan"];

            // javascript 
            $data['js'] = [
                "modules/other.js", 
                "modules/pelanggan.js", 
                "modules/pembelian_pelanggan.js",
                "load_data/reload_detail_pelanggan.js",
            ];
    
            $this->load->view("pages/pelanggan/detail-pelanggan", $data);
        } else {
            redirect(base_url("pelanggan"));
        }
    }
    
    // ajax 
        public function ajax_list_pelanggan(){
            $penjual = $this->_data_penjual();

            if($this->input->post("nama")) {
                $nama = $this->input->post("nama");
                $pelanggan = $this->Main_model->get_all_like("pelanggan", "nama_pelanggan", "$nama", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_pelanggan");
            } else {
                $pelanggan = $this->Main_model->get_all("pelanggan", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_pelanggan");
                // get_all_like($table, $col, $like, $where, $orderby = "", $urut = "ASC"){
            }

            foreach ($pelanggan as $i => $pelanggan) {
                $data[$i] = $pelanggan;
                $data[$i]['link_pelanggan'] = md5($pelanggan['id_pelanggan']);
                $pembelian = COUNT($this->Main_model->get_all("pembelian_pelanggan", ["id_pelanggan" => $pelanggan['id_pelanggan'], "hapus" => 0, "id_penjual" => $penjual['id_penjual']]));
                $data[$i]['pembelian'] = $pembelian;
            }

            echo json_encode($data);
        }
        
        public function ajax_pelanggan($id_pelanggan){
            $penjual = $this->_data_penjual();
            
            $pelanggan = $this->Main_model->get_one("pelanggan", ["md5(id_pelanggan)" => $id_pelanggan, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $pembelian = $this->Main_model->get_all("pembelian_pelanggan", ["id_pelanggan" => $pelanggan['id_pelanggan'], "hapus" => 0], "id_pembelian", "DESC");
            
            $data['pelanggan'] = $pelanggan;
            $data['pelanggan']['tgl_bergabung'] = date("d-M-y", strtotime($pelanggan['tgl_bergabung']));
            $data['pelanggan']['pembelian'] = COUNT($pembelian);

            $data['pembelian'] = [];
            foreach ($pembelian as $i => $pembelian) {
                $data['pembelian'][$i] = $pembelian;
                $data['pembelian'][$i]['tgl_pembelian'] = date("d-M-y H:i", strtotime($pembelian['tgl_pembelian']));

                $detail_pembelian = $this->Main_model->get_all("detail_pembelian_pelanggan", ["id_pembelian" => $pembelian['id_pembelian'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
                
                $total = 0;
                foreach ($detail_pembelian as $detail) {
                    $total += ($detail['qty']) * ($detail['harga']);
                }

                $data['pembelian'][$i]['total'] = $this->Main_model->rupiah($total);
            }


            echo json_encode($data);
        }
    // ajax 

    // add 
        // pakai 
        public function add_pelanggan(){
            $penjual = $this->_data_penjual();

            $kecamatan = $this->input->post('kecamatan');

            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_pelanggan" => $this->input->post("nama_pelanggan"),
                "alamat" => $this->input->post("alamat"),
                "no_hp" => $this->input->post("no_hp"),
                "kecamatan" => $kecamatan,
                "id_penjual" => $penjual['id_penjual'],
            ];

            $data = $this->Main_model->add_data("pelanggan", $data);
            if($data){

                // cek kecamatan jika tidak ada inputkan
                $cek_kecamatan = $this->Main_model->get_one("kecamatan", ["kecamatan" => $kecamatan, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
                if(!$cek_kecamatan){
                    $this->Main_model->add_data("kecamatan", ["kecamatan" => $kecamatan, "id_penjual" => $penjual['id_penjual']]);
                }

                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        // pakai 
        public function add_pembelian(){
            $penjual = $this->_data_penjual();
            $id_pelanggan = $this->input->post("id_pelanggan");

            $pelanggan = $this->Main_model->get_one("pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual']]);

            if($pelanggan){
                
                $data = [
                    "id_pelanggan" => $id_pelanggan,
                    "nama_pelanggan" => $pelanggan['nama_pelanggan'],
                    "no_hp" => $pelanggan['no_hp'],
                    "alamat" => $pelanggan['alamat'],
                    "kecamatan" => $pelanggan['kecamatan'],
                    "tgl_pembelian" => $this->input->post("tgl_pembelian"),
                    "id_penjual" => $penjual['id_penjual'],
                ];

                $id_pembelian = $this->Main_model->add_data("pembelian_pelanggan", $data);
                
                $id_barang = $this->input->post("id_barang");
                $qty = $this->input->post("qty");
                $harga = $this->input->post("harga");

                foreach ($id_barang as $i => $id_barang) {
                    $barang = $this->Main_model->get_one('barang', ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
                    if($qty[$i] != 0) {
                        $data = [
                            "id_pembelian" => $id_pembelian,
                            "id_barang" => $id_barang,
                            "nama_barang" => $barang['nama_barang'],
                            "qty" => $qty[$i],
                            "harga" => $this->Main_model->nominal($harga[$i]),
                            "id_penjual" => $penjual['id_penjual']
                        ];
    
                        $this->Main_model->add_data("detail_pembelian_pelanggan", $data);
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
            $harga = $this->input->post("harga");
            $bh = $this->input->post("bh");

            $success = 0;

            foreach ($id_barang as $i => $id_barang) {
                $barang = $this->Main_model->get_one('barang', ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
                if($qty[$i] != 0) {
                    $data = [
                        "id_pengiriman" => $id_pengiriman,
                        "id_barang" => $id_barang,
                        "nama_barang" => $barang['nama_barang'],
                        "kirim" => $qty[$i],
                        "harga" => $this->Main_model->nominal($harga[$i]),
                        "bagi_hasil" => $this->Main_model->nominal($bh[$i]),
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
        // pakai 
        public function get_pelanggan(){
            $id_pelanggan = $this->input->post("id_pelanggan");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->get_one("pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual']]);
            echo json_encode($data);
        }

        public function get_detail_pembelian(){
            $penjual = $this->_data_penjual();
            $id_pembelian = $this->input->post("id_pembelian");

            $pembelian = $this->Main_model->get_one("pembelian_pelanggan", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual']]);
            $data['pembelian'] = $pembelian;
            $data['pembelian']['tgl_pembelian_format'] = date('Y-m-d', strtotime($pembelian['tgl_pembelian'])) . "T" . date('H:i', strtotime($pembelian['tgl_pembelian']));
            $data['pembelian']['tgl_pembelian'] = date("d-M-y H:i", strtotime($pembelian['tgl_pembelian']));
            $detail_pembelian = $this->Main_model->get_all("detail_pembelian_pelanggan", ["id_pembelian" => $id_pembelian, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            $data['detail_pembelian'] = [];

            $total = 0;
            foreach ($detail_pembelian as $i => $detail) {
                $data['detail_pembelian'][$i] = $detail;
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $detail['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['detail_pembelian'][$i]['kode_barang'] = $barang['kode_barang'];
                $data['detail_pembelian'][$i]['nama_barang'] = $barang['nama_barang'];
                $data['detail_pembelian'][$i]['stok'] = $this->Other_model->stokBarang($detail['id_barang']);
                $total += $detail['qty'] * $detail['harga'];
            }

            $data['pembelian']['total'] = $this->Main_model->rupiah($total);

            echo json_encode($data);
        }

        // barang yang dijual di suatu pelanggan 
        public function get_barang_pelanggan(){
            $penjual = $this->_data_penjual();
            $id_pelanggan = $this->input->post("id_pelanggan");

            $data = [];
            $barang_pelanggan = $this->Main_model->get_all("barang_pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            foreach ($barang_pelanggan as $i => $barang_pelanggan) {
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $barang_pelanggan['id_barang']]);
                $data[$i] = $barang;
                $data[$i]['id'] = $barang_pelanggan['id'];
            }
            
            $columns = array_column($data, 'nama_barang');
            array_multisort($columns, SORT_ASC, $data);
            echo json_encode($data);
        }

        // daftar seluruh barang yang belum dijual di suatu pelanggan
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

            // calon barang pelanggan
            $x = $this->Main_model->get_all("barang", ["hapus" => "0", "id_penjual" => $penjual['id_penjual']], "nama_barang");
            $i = 0;
            foreach ($x as $x) {
                if(!in_array($x['id_barang'], $b)){
                    $data[$i] = $x;
                    $data[$i]['stok'] = $this->Other_model->stokBarang($x['id_barang']);
                    $i++;
                }
            }

            echo json_encode($data);
        }

        // list kecamatan untuk data pelanggan 
        public function get_all_kecamatan(){

            $penjual = $this->_data_penjual();
            $data = $this->Main_model->get_all("kecamatan", ["hapus" => 0, "id_penjual" => $penjual['id_penjual']], "kecamatan");
            echo json_encode($data);

        }

        // rekap pembelian pelanggan 
        public function get_rekap_pembelian(){
            $penjual = $this->_data_penjual();
            $id_pelanggan = $this->input->post("id_pelanggan");

            $barang = $this->Main_model->select_get_all_join_table_group("SUM(qty) as total_qty, id_barang", "pembelian_pelanggan", "detail_pembelian_pelanggan", "id_pembelian", ["id_pelanggan" => $id_pelanggan, "pembelian_pelanggan.id_penjual" => $penjual['id_penjual']], "id_barang");

            $data['barang'] = [];
            foreach ($barang as $i => $barang) {
                $detail_barang = $this->Main_model->get_one("barang", ["id_barang" => $barang['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['barang'][$i] = $barang;
                $data['barang'][$i]['nama_barang'] = $detail_barang['nama_barang'];
            }

            $data['barang'] = $this->Other_model->sortArray($data['barang'], 'total_qty', SORT_DESC);

            $data['pelanggan'] = $this->Main_model->get_one("pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['pelanggan']['pembelian'] = COUNT($this->Main_model->get_all("pembelian_pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]));

            echo json_encode($data);
        }

        public function get_prioritas(){
            $id_pelanggan = $this->input->post("id_pelanggan");
            $penjual = $this->Other_model->_data_penjual();

            $data = $this->Main_model->get_one("prioritas_pelanggan", ["id_pelanggan" => $id_pelanggan, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);

            echo json_encode($data);
        }
    // get 

    // edit 
        // pakai 
        public function edit_pelanggan(){
            $penjual = $this->_data_penjual();
            $id_pelanggan = $this->input->post("id_pelanggan");
            $kecamatan = $this->input->post('kecamatan');
            
            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_pelanggan" => $this->input->post("nama_pelanggan"),
                "alamat" => $this->input->post("alamat"),
                "no_hp" => $this->input->post("no_hp"),
                "kecamatan" => $kecamatan,
                "id_penjual" => $penjual['id_penjual'],
            ];

            $data = $this->Main_model->edit_data("pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual']], $data);

            if($data){

                // cek kecamatan jika tidak ada inputkan
                $cek_kecamatan = $this->Main_model->get_one("kecamatan", ["kecamatan" => $kecamatan, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
                if(!$cek_kecamatan){
                    $this->Main_model->add_data("kecamatan", ["kecamatan" => $kecamatan, "id_penjual" => $penjual['id_penjual']]);
                }

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
            $harga = $this->input->post("harga");
            $bh = $this->input->post("bh");
            $success = 0;

            foreach ($id as $i => $id) {
                $data = [
                    "kirim" => $qty[$i],
                    "harga" => $this->Main_model->nominal($harga[$i]),
                    "bagi_hasil" => $this->Main_model->nominal($bh[$i]),
                ];

                $this->Main_model->edit_data("detail_pengiriman", ["id" => $id, "id_penjual" => $penjual['id_penjual']], $data);
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
        // pakai 
        public function hapus_pelanggan(){
            $id_pelanggan = $this->input->post("id_pelanggan");
            $penjual = $this->_data_penjual();

            $data = $this->Main_model->edit_data("pelanggan", ["id_pelanggan" => $id_pelanggan, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
            if($data){
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }

        public function delete_barang_pelanggan(){
            $penjual = $this->_data_penjual();
            $id = $this->input->post("id");
            
            $data = $this->Main_model->edit_data("barang_pelanggan", ["id" => $id, "id_penjual" => $penjual['id_penjual']], ["hapus" => 1]);
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

/* End of file Pelanggan.php */
