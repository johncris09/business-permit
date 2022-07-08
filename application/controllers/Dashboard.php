<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();   
    }

    public function index()
	{ 
        $data['page_title'] = "Business Permit"; 
        $data['sp_no'] =  $this->get_latest_sp_no();  
		$this->load->view('admin/dashboard', $data);  
		
	} 

    function get_latest_sp_no()
    {  
        $sp_no =  $this->business_permit_model->get_latest_sp_no(); 
        return $sp_no + 1;
    }
}
         