<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
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
        // for if statement navbar fitur
        $data['navbar'] = "Detail Toko";

        // for title and header 
        $data['title'] = "Warkop 51";
        
        // for sidebar 
        $data['sidebar'] = "toko";

        $this->load->view("pages/toko/detail-toko", $data);
    }

}

/* End of file Toko.php */
