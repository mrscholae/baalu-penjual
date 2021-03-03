<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Other_model extends CI_Controller {

    
    // sidebar 
    public function sidebar(){
        $nip = $this->session->userdata('nip');

        // kbm pembinaan badal 
            $badal = 0;
            $kbm = $this->Main_model->get_all("kbm_pembinaan", ["MONTH(tgl)" => date('m'), "YEAR(tgl)" => date('Y')]);
            foreach ($kbm as $kbm) {
                $cek = $this->Main_model->get_one("kbm_badal_pembinaan", ["id_kbm" => $kbm['id_kbm'], "rekap" => 0]);
                if($cek) $badal++;
            }
        // kbm pembinaan badal 

        // sidebar
            $data['jml_wl'] = COUNT($this->Civitas_model->get_all_wl());
            $data['kpq'] = $this->Civitas_model->get_all_kpq();
            $data['program'] = $this->Civitas_model->get_all_program();
            $data['jml_inbox'] = COUNT($this->Civitas_model->get_all_inbox_off($nip));
            $data['jml_badal'] = COUNT($this->Civitas_model->get_all_jadwal_badal_kpq($nip)) + $badal;
            // $data['jml_badal'] = COUNT($this->Civitas_model->get_all_jadwal_badal_kpq($nip));
            $data['jml_kelas'] = COUNT($this->Civitas_model->get_all_jadwal_kpq($nip)) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif"]));
            // $data['jml_kelas'] = COUNT($this->Civitas_model->get_all_jadwal_kpq($nip));
            $data['jml'] = [
                "senin" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'senin')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "senin"])),
                "selasa" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'selasa')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "selasa"])),
                "rabu" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'rabu')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "rabu"])),
                "kamis" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'kamis')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "kamis"])),
                "jumat" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'jumat')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "jumat"])),
                "sabtu" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'sabtu')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "sabtu"])),
                "ahad" => COUNT($this->Civitas_model->get_jadwal_hari_kpq($nip, 'ahad')) + COUNT($this->Main_model->get_all("kelas_pembinaan", ["nip" => $nip, "status" => "aktif", "hari" => "ahad"]))
            ];
        // sidebar

        return $data;
    }
    // sidebar 

}

/* End of file Other_model.php */
