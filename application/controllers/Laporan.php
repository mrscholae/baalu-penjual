<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();

        $this->load->model("Main_model");
        $this->load->model("Laporan_model");        
        
        if(!$this->session->userdata('username')){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fa fa-times-circle text-danger mr-1"></i> Maaf Anda harus login terlebih dahulu<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div');
			redirect(base_url("auth"));
		}
    }
    
    public function index()
    {        
        // for if statement navbar fitur
        $data['navbar'] = "Laporan";

        // for title and header 
        $data['title'] = "Laporan";

        // for sidebar 
        $data['sidebar'] = "laporan";

        $this->load->view("pages/laporan/form-laporan", $data);
    }

    public function print(){
        $laporan = $this->input->post("laporan");
        $tgl_awal = $this->input->post("tgl_awal");
        $tgl_akhir = $this->input->post("tgl_akhir");

        if($laporan == "Laporan Pengiriman"){
            
            $filename = "laporan_pengiriman_{$tgl_awal}_{$tgl_akhir}";
            
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
            
            $data = $this->Laporan_model->laporanPengiriman();
            
            $data['title'] = "Laporan Pengiriman " . date("d-M-y", strtotime($tgl_awal)) . " - " . date("d-M-y", strtotime($tgl_akhir));
            
            $this->load->view('pages/laporan/cetak-pengiriman', $data); 
        } elseif($laporan == "Laporan Penjualan"){
            
        }
    }

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }

}

/* End of file Laporan.php */
