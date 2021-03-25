<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Other_model extends CI_Model {

    function _data_penjual(){
        $username = $this->session->userdata('username');
        $data = $this->Main_model->get_one("penjual", ["username" => $username]);

        return $data;
    }

    function sortArray(){
        $funcArgument = func_get_args();
        $content = array_shift($funcArgument);

        foreach ($funcArgument as $n => $field) {

            if (is_string($field)) {
                $tmp = array();
                foreach ($content as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $funcArgument[$n] = $tmp;
            }

        }

        $funcArgument[] = & $content;
        call_user_func_array('array_multisort', $funcArgument);
        return array_pop($funcArgument);
    }

}

/* End of file Other_model.php */
