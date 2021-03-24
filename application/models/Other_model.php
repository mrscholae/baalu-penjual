<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Other_model extends CI_Model {

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }

}

/* End of file Other_model.php */
