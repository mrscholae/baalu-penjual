<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pengambilan extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        // for if statement navbar fitur
        $data['navbar'] = "Menunggu Pengambilan";

        // for title and header 
        $data['title'] = "Menunggu Pengambilan";
        
        // for sidebar 
        $data['sidebar'] = "home";

        $this->load->view("pages/pengambilan/list-pengambilan", $data);
    }

}

/* End of file Pengambilan.php */
