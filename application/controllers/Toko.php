<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {

    
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
    
    public function index()
    {
        // for if statement navbar fitur
        $data['navbar'] = "Toko";

        // for title and header 
        $data['title'] = "List Toko";
        
        // for sidebar 
        $data['sidebar'] = "toko";

        // for modal 
        $data['modal'] = ["modal_toko", "modal_pengiriman"];

        // javascript 
        $data['js'] = [
            "modules/other.js", 
            "modules/toko.js", 
            "modules/pengiriman.js",
            "load_data/reload_toko.js",
        ];
        
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

            // for modal 
            $data['modal'] = ["modal_toko", "modal_pengiriman"];

            // javascript 
            $data['js'] = [
                "modules/other.js", 
                "modules/toko.js", 
                "modules/pengiriman.js",
                "load_data/reload_detail_toko.js",
            ];
    
            $this->load->view("pages/toko/detail-toko", $data);
        } else {
            redirect(base_url("toko"));
        }
    }
    
    // ajax 
        public function ajax_list_toko(){
            $penjual = $this->_data_penjual();

            if($this->input->post("nama")) {
                $nama = $this->input->post("nama");
                $toko = $this->Main_model->get_all_like("toko", "nama_toko", "$nama", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_toko");
            } else {
                $toko = $this->Main_model->get_all("toko", ["id_penjual" => $penjual['id_penjual'], "hapus" => 0], "nama_toko");
                // get_all_like($table, $col, $like, $where, $orderby = "", $urut = "ASC"){
            }

            foreach ($toko as $i => $toko) {
                $data[$i] = $toko;
                $data[$i]['link_toko'] = md5($toko['id_toko']);
                $pengiriman = COUNT($this->Main_model->get_all("pengiriman", ["id_toko" => $toko['id_toko'], "hapus" => 0, "id_penjual" => $penjual['id_penjual']]));
                $data[$i]['pengiriman'] = $pengiriman;
                $data[$i]['prioritas'] = $this->Main_model->get_one("prioritas_toko", ["id_toko" => $toko['id_toko'], "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);
            }

            echo json_encode($data);
        }
        
        public function ajax_toko($id_toko){
            $penjual = $this->_data_penjual();
            
            $toko = $this->Main_model->get_one("toko", ["md5(id_toko)" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $pengiriman = $this->Main_model->get_all("pengiriman", ["id_toko" => $toko['id_toko'], "hapus" => 0], "id_pengiriman", "DESC");
            
            $data['toko'] = $toko;
            $data['toko']['tgl_bergabung'] = date("d-M-y", strtotime($toko['tgl_bergabung']));
            $data['toko']['pengiriman'] = COUNT($pengiriman);

            $data['pengiriman'] = [];
            foreach ($pengiriman as $i => $pengiriman) {
                $data['pengiriman'][$i] = $pengiriman;
                $data['pengiriman'][$i]['tgl_pengiriman'] = date("d-M-y H:i", strtotime($pengiriman['tgl_pengiriman']));
                $data['pengiriman'][$i]['tgl_pengambilan'] = date("d-M-y H:i", strtotime($pengiriman['tgl_pengambilan']));

                $detail_pengiriman = $this->Main_model->get_all("detail_pengiriman", ["id_pengiriman" => $pengiriman['id_pengiriman'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
                
                $total = 0;
                foreach ($detail_pengiriman as $detail) {
                    $total += ($detail['kirim'] - $detail['kembali']) * ($detail['harga'] - $detail['bagi_hasil']);
                }

                $data['pengiriman'][$i]['total'] = $this->Main_model->rupiah($total);
            }


            echo json_encode($data);
        }
    // ajax 

    // add 
        public function add_toko(){
            $penjual = $this->_data_penjual();

            $kecamatan = $this->input->post('kecamatan');

            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_toko" => $this->input->post("nama_toko"),
                "alamat" => $this->input->post("alamat"),
                "pj" => $this->input->post("pj"),
                "no_hp" => $this->input->post("no_hp"),
                "jam_operasional" => $this->input->post("jam_operasional"),
                "id_penjual" => $penjual['id_penjual'],
                "kecamatan" => $kecamatan,
            ];

            $data = $this->Main_model->add_data("toko", $data);
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
                    "kecamatan" => $toko['kecamatan'],
                    "jam_operasional" => $toko['jam_operasional'],
                    "tgl_pengiriman" => $this->input->post("tgl_pengiriman"),
                    "tgl_pengambilan" => $this->input->post("tgl_pengambilan"),
                    "status" => "Proses",
                    "id_penjual" => $penjual['id_penjual'],
                ];

                $id_pengiriman = $this->Main_model->add_data("pengiriman", $data);
                
                $id_barang = $this->input->post("id_barang");
                $qty = $this->input->post("qty");
                $harga = $this->input->post("harga");
                $bh = $this->input->post("bh");

                foreach ($id_barang as $i => $id_barang) {
                    $barang = $this->Main_model->get_one('barang', ["id_barang" => $id_barang, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
                    if($qty[$i] != 0) {
                        $data = [
                            "id_pengiriman" => $id_pengiriman,
                            "id_barang" => $id_barang,
                            "nama_barang" => $barang['nama_barang'],
                            "kirim" => $qty[$i],
                            "kembali" => "0",
                            "harga" => $this->Main_model->nominal($harga[$i]),
                            "bagi_hasil" => $this->Main_model->nominal($bh[$i]),
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

        public function add_prioritas(){
            $penjual = $this->Other_model->_data_penjual();

            $id_toko = $this->input->post("id_toko");
            
            $jarak = 0;
            $pelayanan = 0;
            $repeat_order = 0;
            $retur = 0;
            $pengunjung = 0;
            $min_order = 0;

            if($this->input->post("prioritas")){
                $prioritas = $this->input->post("prioritas");
    
                foreach ($prioritas as $prioritas) {
                    if($prioritas == "jarak") $jarak = 1;
                    elseif($prioritas == "pelayanan") $pelayanan = 1;
                    elseif($prioritas == "retur") $retur = 1;
                    elseif($prioritas == "pengunjung") $pengunjung = 1;
                    elseif($prioritas == "min_order") $min_order = 1;
                    elseif($prioritas == "repeat_order") $repeat_order = 1;
                }
            }

            $this->Main_model->edit_data("prioritas_toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0], ["hapus" => 1]);

            $data = [
                "id_toko" => $id_toko,
                "jarak" => $jarak,
                "pelayanan" => $pelayanan,
                "repeat_order" => $repeat_order,
                "retur" => $retur,
                "pengunjung" => $pengunjung,
                "min_order" => $min_order,
                "id_penjual" => $penjual['id_penjual'],
            ];

            $cek = $this->Main_model->add_data("prioritas_toko", $data);

            if($cek){
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
            $data['pengiriman']['tgl_pengiriman_format'] = date('Y-m-d', strtotime($pengiriman['tgl_pengiriman'])) . "T" . date('H:i', strtotime($pengiriman['tgl_pengiriman']));
            $data['pengiriman']['tgl_pengambilan_format'] = date('Y-m-d', strtotime($pengiriman['tgl_pengambilan'])) . "T" . date('H:i', strtotime($pengiriman['tgl_pengambilan']));
            $data['pengiriman']['tgl_pengiriman'] = date("d-M-y H:i", strtotime($pengiriman['tgl_pengiriman']));
            $data['pengiriman']['tgl_pengambilan'] = date("d-M-y H:i", strtotime($pengiriman['tgl_pengambilan']));
            $detail_pengiriman = $this->Main_model->get_all("detail_pengiriman", ["id_pengiriman" => $id_pengiriman, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            $data['detail_pengiriman'] = [];

            foreach ($detail_pengiriman as $i => $detail) {
                $data['detail_pengiriman'][$i] = $detail;
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $detail['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['detail_pengiriman'][$i]['kode_barang'] = $barang['kode_barang'];
                $data['detail_pengiriman'][$i]['nama_barang'] = $barang['nama_barang'];
                $data['detail_pengiriman'][$i]['stok'] = $this->Other_model->stokBarang($detail['id_barang']);
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
                    $data[$i]['stok'] = $this->Other_model->stokBarang($x['id_barang']);
                    $i++;
                }
            }

            echo json_encode($data);
        }

        // list kecamatan untuk data toko 
        public function get_all_kecamatan(){

            $penjual = $this->_data_penjual();
            $data = $this->Main_model->get_all("kecamatan", ["hapus" => 0, "id_penjual" => $penjual['id_penjual']], "kecamatan");
            echo json_encode($data);

        }

        // pengiriman terakhir 
        public function get_pengiriman_terakhir(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");

            $pengiriman = $this->Main_model->get_one("pengiriman", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0], "id_pengiriman", "DESC");
            $barang = $this->Main_model->get_all("detail_pengiriman", ["id_pengiriman" => $pengiriman['id_pengiriman'], "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);

            $data['barang'] = [];

            foreach ($barang as $i => $detail) {
                $data['barang'][$i] = $detail;
                $barang = $this->Main_model->get_one("barang", ["id_barang" => $detail['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['barang'][$i]['kode_barang'] = $barang['kode_barang'];
                $data['barang'][$i]['nama_barang'] = $barang['nama_barang'];
                $data['barang'][$i]['stok'] = $this->Other_model->stokBarang($barang['id_barang']);
            }

            echo json_encode($data);
        }

        // rekap penjualan toko 
        public function get_rekap_penjualan(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");

            $barang = $this->Main_model->select_get_all_join_table_group("SUM(kirim) as total_kirim, SUM(kembali) as total_retur, id_barang", "pengiriman", "detail_pengiriman", "id_pengiriman", ["id_toko" => $id_toko, "status" => "Selesai", "pengiriman.id_penjual" => $penjual['id_penjual']], "id_barang");

            $data['barang'] = [];
            foreach ($barang as $i => $barang) {
                $detail_barang = $this->Main_model->get_one("barang", ["id_barang" => $barang['id_barang'], "id_penjual" => $penjual['id_penjual']]);
                $data['barang'][$i] = $barang;
                $data['barang'][$i]['nama_barang'] = $detail_barang['nama_barang'];
            }

            $data['barang'] = $this->Other_model->sortArray($data['barang'], 'total_kirim', SORT_DESC);

            $data['toko'] = $this->Main_model->get_one("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0]);
            $data['toko']['pengiriman'] = COUNT($this->Main_model->get_all("pengiriman", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual'], "hapus" => 0, "status" => "Selesai"]));

            echo json_encode($data);
        }

        public function get_prioritas(){
            $id_toko = $this->input->post("id_toko");
            $penjual = $this->Other_model->_data_penjual();

            $data = $this->Main_model->get_one("prioritas_toko", ["id_toko" => $id_toko, "hapus" => 0, "id_penjual" => $penjual['id_penjual']]);

            echo json_encode($data);
        }
    // get 

    // edit 
        public function edit_toko(){
            $penjual = $this->_data_penjual();
            $id_toko = $this->input->post("id_toko");
            $kecamatan = $this->input->post('kecamatan');
            
            $data = [
                "tgl_bergabung" => $this->input->post("tgl_bergabung"),
                "nama_toko" => $this->input->post("nama_toko"),
                "alamat" => $this->input->post("alamat"),
                "jam_operasional" => $this->input->post("jam_operasional"),
                "pj" => $this->input->post("pj"),
                "no_hp" => $this->input->post("no_hp"),
                "kecamatan" => $kecamatan,
            ];

            $data = $this->Main_model->edit_data("toko", ["id_toko" => $id_toko, "id_penjual" => $penjual['id_penjual']], $data);

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
