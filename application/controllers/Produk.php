<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        // for if statement navbar fitur
        $data['navbar'] = "Produk";

        // for title and header 
        $data['title'] = "List Produk";
        
        // for sidebar 
        $data['sidebar'] = "produk";

        $this->load->view("pages/produk/list-produk", $data);
    }

}

/* End of file Produk.php */
