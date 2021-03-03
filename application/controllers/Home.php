<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index()
    {
        // for if statement navbar fitur
        $data['navbar'] = "Home";

        // for title and header 
        $data['title'] = "Dashboard";

        // for sidebar 
        $data['sidebar'] = "home";

        $this->load->view("pages/index", $data);
    }

}

/* End of file Home.php */
