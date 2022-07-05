<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Business_permit extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();  
        
    } 

	public function get_all_business_permit()
	{ 
		$business_permit = $this->business_permit_model->get_all_business_permit(); 

		if( $business_permit->num_rows() ){
			foreach( $business_permit->result_array()  as $row ){   
				$data['data'][] = $row;  
			}  
		}else{
			$data['data'] = array();
		}  
		
		echo json_encode($data);
	}

    
    public function insert()
    {
        $data = array(
			'sp_no' => $this->input->post('sp_no') ,
			'classification' => $this->input->post('classification') ,
			'business' => trim($this->input->post('business')),
			'owner' => trim($this->input->post('owner')),
			'address' =>   $this->input->post('address'),
		);  
        
		$insert = $this->business_permit_model->insert($data);
		if($insert){

			$data = array(
				'response' => true,
				'message'  => 'Data Inserted Successfully!',
			);
  
		}else{ 
			$data = array(
				'response' => false,
				'message'  => 'Something went wrong.',
			);
		} 
 
		
        echo json_encode($data);
    }
 
	public function get_business_permit($id)
	{ 

		$data = array(
			"id" => $id,
		); 
		$data = $this->business_permit_model->get_business_permit($data); 

		echo json_encode($data);
	}

	
	public function view($id)
	{ 

		$data = array(
			"id" => $id,
		); 
		$data['info'] = $this->business_permit_model->get_business_permit($data);
        $data['page_title'] = "Business Permit"; 
		$this->load->view('admin/print_preview', $data);   
	}
	
	public function update($id)
	{ 
 
		
		$data = array(
			'id' => $id,
			'classification' => $this->input->post('classification') ,
			'business' => trim($this->input->post('business')),
			'owner' => trim($this->input->post('owner')),
			'address' =>   $this->input->post('address'),
		);  
        
		$update = $this->business_permit_model->update($data);
		if($update){

			$data = array(
				'response' => true,
				'message'  => 'Data Updated Successfully!',
			);
  
		}else{ 
			$data = array(
				'response' => false,
				'message'  => 'Something went wrong.',
			);
		} 



		echo json_encode($data);
	}
	 


	public function delete($id)
	{  
		$delete = $this->business_permit_model->delete($id);

		if($delete){  
			$data = array(
				'response' => true,
				'message'  => 'Data Deleted Successfully!',
			);
		}else{
			$data = array(
				'response' => false,
			);
		}

		echo json_encode($data);
	}

	function get_latest_sp_no()
    {
        $sp_no =  $this->business_permit_model->get_latest_sp_no(); 
		echo json_encode($sp_no + 1);
    }


		
}
         