<?php 
require_once   './vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
	class Administrator extends CI_Controller{

		

		public function view($page = 'index'){
			if($this->session->userdata('login')) {
    			redirect('administrator/dashboard');
   			}

			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			//$this->load->view('administrator/header');
			//$this->load->view('administrator/index');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function home($page = 'home'){
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function dashboard($page = 'dashboard'){
		   if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
		   $data['title'] = ucfirst($page);
		   $this->load->view('administrator/header-script');
		   $this->load->view('administrator/header');
		   $this->load->view('administrator/header-bottom');
		   $this->load->view('administrator/'.$page, $data);
		   $this->load->view('administrator/footer');
		}

	 

	  // Log in Admin
		public function adminLogin(){
			$data['title'] = 'Admin Login';

			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				//$data['title'] = ucfirst($page);
				$this->load->view('administrator/header-script');
				//$this->load->view('administrator/header');
				//$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/index', $data);
				$this->load->view('administrator/footer');
			}else{
				// get email and Encrypt Password
				$email = $this->input->post('email');
				$encrypt_password = md5($this->input->post('password'));

				$user_id = $this->Administrator_Model->adminLogin($email, $encrypt_password);
				$sitelogo = $this->Administrator_Model->update_siteconfiguration(1);

				if ($user_id && $user_id->role_id == 1) {
					//Create Session
					$user_data = array(
								'user_id' => $user_id->id,
				 				'username' => $user_id->username,
				 				'email' => $user_id->email,
				 				'login' => true,
				 				'role' => $user_id->role_id,
				 				'image' => $user_id->image,
				 				'site_logo' => $sitelogo['logo_img']
				 	);

				 	$this->session->set_userdata($user_data);

					//Set Message
					$this->session->set_flashdata('success', 'Welcome to administrator Dashboard.');
					redirect('administrator/dashboard');
				}else{
					$this->session->set_flashdata('danger', 'Login Credential in invalid!');
					redirect('administrator/index');
				}
				
			}
		}

				// log admin out
		public function logout(){
			// unset user data
			$this->session->unset_userdata('login');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('role_id');
			$this->session->unset_userdata('email');
			$this->session->unset_userdata('image');
			$this->session->unset_userdata('site_logo');

			//Set Message
			$this->session->set_flashdata('success', 'You are logged out.');
			redirect(base_url().'administrator/index');
		}

		public function forget_password($page = 'forget-password'){
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
				show_404();
			}
			$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			//$this->load->view('administrator/header');
			//$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/'.$page, $data);
			$this->load->view('administrator/footer');
		}

		public function add_user($page = 'add-user')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Create User';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/users';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$post_image = 'noimage.jpg';
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}
				$password = md5('Test@123');
				$this->Administrator_Model->add_user($post_image,$password);

				//Set Message
				$this->session->set_flashdata('success', 'User has been created Successfull.');
				redirect('administrator/users');
			}
			
		}

		public function add_recipients($page = 'add-recipients')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Create Recipients';
			//$data['add-user'] = $this->Administrator_Model->get_categories();
			$this->form_validation->set_rules('recipient_name', 'Recipient Name', 'required');
			$this->form_validation->set_rules('identifier_number', 'Identifier Number', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email_address', 'Email', 'required|callback_check_email_exists');
			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{	
				$this->Administrator_Model->add_recipients();
				//Set Message
				$this->session->set_flashdata('success', 'Recipients has been created Successfull.');
				redirect('administrator/recipients');
			}
			
		}
		// Check user name exists
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is already taken, Please choose a different one.');

			if ($this->User_Model->check_username_exists($username)) {
				return true;
			}else{
				return false;
			}
		}


		// Check Email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'This email is already registered.');

			if ($this->User_Model->check_email_exists($email)) {
				return true;
			}else{
				return false;
			}
		}

		public function users($offset = 0)
		{
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/users/';
			$config['total_rows'] = $this->db->count_all('users');
			$config['per_page'] = 3;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'Latest Users';

			$data['users'] = $this->Administrator_Model->get_users(FALSE, $config['per_page'], $offset);

			 	$this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/users', $data);
		  		$this->load->view('administrator/footer');
		}

		public function recipients($offset = 0)
		{
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/recipients/';
			$config['total_rows'] = $this->db->count_all('recipients');
			$config['per_page'] = 100;
			$config['uri_segment'] = 2;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'Latest Recipients';

			$data['recipients'] = $this->Administrator_Model->get_recipients(FALSE, $config['per_page'], $offset);

			 	$this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/recipients', $data);
		  		$this->load->view('administrator/footer');
		}

		public function delete($id)
		{
			$table = base64_decode($this->input->get('table'));
			//$table = $this->input->post('table');
			$this->Administrator_Model->delete($id,$table);       
			$this->session->set_flashdata('success', 'Data has been deleted Successfully.');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		
		public function update_user($id = NULL)
		{
			$data['user'] = $this->Administrator_Model->get_user($id);
			
			if (empty($data['user'])) {
				show_404();
			}
			$data['title'] = 'Update User';

			$this->load->view('administrator/header-script');
	 	 	 $this->load->view('administrator/header');
	  		 $this->load->view('administrator/header-bottom');
	   		 $this->load->view('administrator/update-user', $data);
	  		$this->load->view('administrator/footer');
		}

		public function update_user_data($page = 'update-user')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Update User';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{
				//Upload Image
				
				$config['upload_path'] = './assets/images/users';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$id = $this->input->post('id');
					$data['img'] = $this->Administrator_Model->get_user($id);
					$errors =  array('error' => $this->upload->display_errors());
					$post_image = $data['img']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_user_data($post_image);

				//Set Message
				$this->session->set_flashdata('success', 'User has been Updated Successfull.');
				redirect('administrator/users');
			}
			
		}

		// blogs functions start
		public function add_upsi($page = 'add-upsi')
		{
			if (!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Upload UPSI';
			if (!$this->input->post()) {
				$this->load->view('administrator/header-script');
				$this->load->view('administrator/header');
				$this->load->view('administrator/header-bottom');
				$this->load->view('administrator/' . $page, $data);
				$this->load->view('administrator/footer');
			} else {

			$file = $_FILES['userfile']['tmp_name'];
			$spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
			$columnIndex = 'O'; // Specify the column containing email IDs
    		// Specify the starting row (excluding header)
			$startRow = 2;

			foreach ($worksheet->getRowIterator($startRow) as $row) {
				// Extract data from cells
				$natureOfUPSI = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
				$purpose = "`" . $worksheet->getCell('C' . $row->getRowIndex())->getValue() . "`";
				$dateOfSharing = $worksheet->getCell('D' . $row->getRowIndex())->getValue();
				$periodOfUPSIFrom = $worksheet->getCell('E' . $row->getRowIndex())->getValue();
				$periodOfUPSITo = $worksheet->getCell('F' . $row->getRowIndex())->getValue();
				$currentStatus = $worksheet->getCell('I' . $row->getRowIndex())->getValue();
				$createdBy = $worksheet->getCell('J' . $row->getRowIndex())->getValue();
				//$mailDate = $worksheet->getCell('K' . $row->getRowIndex())->getValue();
				$mailTime = $worksheet->getCell('L' . $row->getRowIndex())->getValue();
				$acquisitionDate = $worksheet->getCell('M' . $row->getRowIndex())->getValue();
				$upsiSourceemail = $worksheet->getCell('N' . $row->getRowIndex())->getValue();
				//$systemEntryDate = $worksheet->getCell('G' . $row->getRowIndex())->getValue();
				$systemEntryTime = $worksheet->getCell('H' . $row->getRowIndex())->getValue();
				$recipients = $worksheet->getCell('O' . $row->getRowIndex())->getValue();

				$dateOfSharing = ($dateOfSharing - 25569) * 86400;
    			$dateOfSharing = gmdate("d-m-Y", $dateOfSharing);
				$periodOfUPSIFrom = gmdate("d-m-Y", ($periodOfUPSIFrom - 25569) * 86400);
				$periodOfUPSITo = gmdate("d-m-Y", ($periodOfUPSITo - 25569) * 86400);
				$acquisitionDate = gmdate("d-m-Y", ($acquisitionDate - 25569) * 86400);
				$roundedSystemEntryTime = round($systemEntryTime * 86400);
    			$systemEntryTime = gmdate("H:i:s", $roundedSystemEntryTime);

				$roundedMailTime = round($mailTime * 86400);
				$mailTime = gmdate("H:i:s", $roundedMailTime);
				// Create an array with the extracted values
				$insert_data = array(
					'nature_of_upsi' => $natureOfUPSI,
					'purpose' => $purpose,
					'date_of_sharing' => $dateOfSharing,
					'period_of_upsi_from' => $periodOfUPSIFrom,
					'period_of_upsi_to' => $periodOfUPSITo,
					'current_status' => $currentStatus,
				    'created_by' => $createdBy,
					'mail_date' => $dateOfSharing,
					'mail_time' => $mailTime,
					'system_entry_date' => $dateOfSharing,
					'system_entry_time' => $systemEntryTime,
					'date_of_acquisition' => $acquisitionDate,
					'upsi_received_from' => $upsiSourceemail,
					'recipients' => $recipients,
				);
				
				$this->Administrator_Model->create_upsi_data($insert_data);

				// Config for file upload
				// $config['upload_path'] = './assets/userfile/';
				// $config['allowed_types'] = 'csv|xls|xlsx';
				// $this->load->library('upload', $config);

				// if (!$this->upload->do_upload('userfile')) {
				// 	$error = array('error' => $this->upload->display_errors('<p>', '</p>'));
				// 	$this->load->view('upload_form', $error); // Adjust the view name as needed
				// } else {
				// 	$data = array('upload_data' => $this->upload->data());
				// 	$file_path = base_url('assets/userfile/') . $data['upload_data']['file_name'];
				
			}
			
			$this->session->set_flashdata('post_created', 'Your post has been created.');		
			redirect('administrator/upsi/list-upsi');
		}
	}		

		public function edit_upsi($id) {


        $data['upsi'] = $this->Administrator_Model->get_upsi_by_id($id);
		$data['recipients'] = $this->Administrator_Model->get_recipients(FALSE, $config['per_page'] = 500, $offset = 0);
		
		//print_r($data['recipients']);die;
		$data['title'] = 'UPSI Edit';
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/upsi-edit', $data);
		$this->load->view('administrator/footer');
        }

		public function list_upsi($offset = 0){
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/upsi/list-upsi/';
			$config['total_rows'] = $this->db->count_all('upsi_sharing');
			$config['per_page'] = 1000;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'List of UPSI';

			$data['upsi'] = $this->Administrator_Model->listupsi(FALSE, $config['per_page'], $offset);

			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/list-upsi', $data);
			$this->load->view('administrator/footer');
		}

		public function upsi_sharing($offset = 0){
			$config['base_url'] = base_url(). 'administrator/upsi/list-upsi/';
			$config['total_rows'] = $this->db->count_all('upsi_sharing');
			$config['per_page'] = 1000;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			$data['recipients'] = $this->Administrator_Model->get_recipients(FALSE, $config['per_page'], $offset);
			$data['upsi'] = $this->Administrator_Model->listupsi(FALSE, $config['per_page'], $offset);

			$data['title'] = 'UPSI Sharing';
			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/upsi-sharing', $data);
			$this->load->view('administrator/footer');
		}

		public function update_upsi($upsi_id) {
    if(!$this->session->userdata('login')) {
        redirect('administrator/index');
    }
    if($this->input->post()) {
        $upsi_data = array(
            'nature_of_upsi' => $this->input->post('nature_of_upsi'),
            'purpose' => $this->input->post('purpose'),
            'date_of_sharing' => $this->input->post('date_of_sharing'),
            'mail_time' => $this->input->post('mail_time'),
            'created_by' => $this->input->post('created_by'),
            'period_of_upsi_from' => $this->input->post('period_of_upsi_from'),
            'period_of_upsi_to' => $this->input->post('period_of_upsi_to'),
            'system_entry_date' => $this->input->post('system_entry_date'),
            'system_entry_time' => $this->input->post('system_entry_time'),
            'recipients' => implode(',', $this->input->post('recipients')) // Combine recipients into a comma-separated string
        );
        $this->Administrator_Model->update_upsi($upsi_id, $upsi_data);

        $this->session->set_flashdata('upsi_updated', 'UPSI details updated successfully.');

        redirect('administrator/upsi/list-upsi');
    } else {
        redirect('administrator/upsi/edit_upsi/'.$upsi_id);
    }
}


	public function edit_recipients($recipient_id) {
		$offset = 0; 
		$config['per_page'] = 1000;
		$config['uri_segment'] = 3;
		$data['recipient'] = $this->Administrator_Model->get_recipients(FALSE, $config['per_page'], $offset);

		$data['title'] = 'Edit Recipient';
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/recipient-edit', $data);
		$this->load->view('administrator/footer');
    }

	public function update_recipient($recipient_id) {	

		
	$data = array(
		'recipient_name' => $this->input->post('recipient_name'),
		'capacity' => $this->input->post('capacity'),
		'identifier_number' => $this->input->post('identifier_number'),
		'email_address' => $this->input->post('email_address'),
		'entity_type' => $this->input->post('entity_type'),
		'organisation' => $this->input->post('organisation')
	);
		$this->Administrator_Model->update_recipient($recipient_id, $data);
		redirect('administrator/recipients');
	}

	 public function delete_recipient($recipient_id) {
        $this->Administrator_Model->delete($recipient_id,"recipients");
        redirect('administrator/recipients');
    }


























		
		public function update_blog($blog_id = false){
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Edit Blog';

			$data['categories'] = $this->Post_Model->get_categories();
			$data['post'] = $this->Administrator_Model->listblogs($blog_id);

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('body', 'Body', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('administrator/header-script');
			   	$this->load->view('administrator/header');
			   	$this->load->view('administrator/header-bottom');
			   	$this->load->view('administrator/update-blog', $data);
			   	$this->load->view('administrator/footer');	
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/posts';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$data['postimg'] = $this->Administrator_Model->listblogs($this->input->post('id'));
					$post_image = $data['postimg']['post_image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_blog_data($post_image);

			    //Set Message
			    $this->session->set_flashdata('success', 'Blog has been Updated Successfully.');
			    redirect('administrator/blogs/list-blog');
			}
		}

		public function list_blog_comments()
		{
			$data['listBlogComments'] = $this->Administrator_Model->list_blog_comments();

			$data['title'] = 'Blog Comments';

			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/blog-comments', $data);
	  		$this->load->view('administrator/footer');
		}

		public function view_blog_comments($id = NULL)
		{

			$data['viewBlogComments'] = $this->Administrator_Model->view_blog_comments($id);
			$data['title'] = 'View blog Comments';

			$this->load->view('administrator/header-script');
	 	 	 $this->load->view('administrator/header');
	  		 $this->load->view('administrator/header-bottom');
	   		 $this->load->view('administrator/view-blog-comment', $data);
	  		$this->load->view('administrator/footer');
		}


		//Site configuration
		public function get_siteconfiguration($page = 'site-configuration')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    	show_404();
		   	}

			$data['siteconfiguration'] = $this->Administrator_Model->get_siteconfiguration();

			$data['title'] = 'Site Configuration';

			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/update-site-configuration', $data);
	  		$this->load->view('administrator/footer');
		}

		public function update_siteconfiguration($id = NULL)
		{
			$data['siteconfiguration'] = $this->Administrator_Model->update_siteconfiguration($id);
			$data['title'] = 'Update Configuration';

			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/update-site-configuration', $data);
	  		$this->load->view('administrator/footer');
		}


		public function update_siteconfiguration_data($page = 'update-site-configuration')
		{

			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}
			$data['title'] = 'Update Configuration';

			$this->form_validation->set_rules('site_title', 'Site Title', 'required');
			$this->form_validation->set_rules('site_name', 'Site Name', 'required');
			
			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{

				//Upload Image
				$config['upload_path'] = './assets/images';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$data['logo_imgs'] = $this->Administrator_Model->update_siteconfiguration($this->input->post('id'));
					$post_image = $data['logo_imgs']['logo_img'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}
				
				 $this->Administrator_Model->update_siteconfiguration_data($post_image);
				//Set Message
				$this->session->set_flashdata('success', 'site configuration Details has been Updated Successfull.');
				redirect('administrator/site-configuration/update/1');
			}
		}



		// pages content details start
		public function get_pagecontents($page = 'page-contents')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    	show_404();
		   	}

			$data['pagecontents'] = $this->Administrator_Model->get_pagecontents();

			$data['title'] = 'List pages contents';

			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/'.$page, $data);
	  		$this->load->view('administrator/footer');
		}

		public function update_pagecontents($id = NULL)
		{
			$data['pagecontents'] = $this->Administrator_Model->update_pagecontents($id);
			
			$data['title'] = 'Update page contents';

			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/update-page-contents', $data);
	  		$this->load->view('administrator/footer');
		}


		public function update_pagecontents_data($page = 'update-page-contents')
		{

			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}
			$data['title'] = 'Update Page contents Details';

			$this->form_validation->set_rules('page_name', 'Page Name', 'required');
			$this->form_validation->set_rules('content', 'Page Content', 'required');
			
			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{
				
				 $this->Administrator_Model->update_pagecontents_data();
				//Set Message
				$this->session->set_flashdata('success', 'Page Contents Details has been Updated Successfull.');
				redirect('administrator/page-contents');
			}
		}


		// galleries 
		public function galleries()
		{
			$data['title'] = 'Add Galleries';
			$this->load->view('administrator/header-script');
	 	 	$this->load->view('administrator/header');
	  		$this->load->view('administrator/header-bottom');
	   		$this->load->view('administrator/add-galleries', $data);
	  		$this->load->view('administrator/footer');
		}
			
			
		public function add_team($page = 'add-team')
		{
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Add Blog';

			$this->form_validation->set_rules('name', 'Team Name', 'required');
			$this->form_validation->set_rules('designation', 'Designation', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('administrator/header-script');
			   	$this->load->view('administrator/header');
			   	$this->load->view('administrator/header-bottom');
			   	$this->load->view('administrator/'.$page, $data);
			   	$this->load->view('administrator/footer');	
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/teams';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$team_image = 'noimage.png';
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$team_image = $_FILES['userfile']['name'];
				}
				$this->Administrator_Model->create_team($team_image);

				//Set Message
				$this->session->set_flashdata('success', 'Your team has been created.');
				redirect('administrator/team/list');
			}
			
		}

		public function list_team($offset = 0){
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/team/';
			$config['total_rows'] = $this->db->count_all('teams');
			$config['per_page'] = 3;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'List of Teams';

			$data['teams'] = $this->Administrator_Model->listteams(FALSE, $config['per_page'], $offset);

			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/list-teams', $data);
			$this->load->view('administrator/footer');
		}

		public function update_team($teamId){
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Edit Team';

			$data['team'] = $this->Administrator_Model->listteams($teamId);

			$this->form_validation->set_rules('name', 'Team Name', 'required');
			$this->form_validation->set_rules('designation', 'Designation', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('administrator/header-script');
			   	$this->load->view('administrator/header');
			   	$this->load->view('administrator/header-bottom');
			   	$this->load->view('administrator/update-team', $data);
			   	$this->load->view('administrator/footer');	
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/teams';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$data['teamimg'] = $this->Administrator_Model->listteams($this->input->post('id'));
					$post_image = $data['teamimg']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_team_data($post_image);

			    //Set Message
			    $this->session->set_flashdata('success', 'Team has been Updated Successfully.');
			    redirect('administrator/team/list');
			}
		}

		public function add_testimonial($page = 'add-testimonial')
		{
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Add Testimonial';

			$this->form_validation->set_rules('name', 'Testimonial Name', 'required');
			$this->form_validation->set_rules('domain', 'Domain', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('administrator/header-script');
			   	$this->load->view('administrator/header');
			   	$this->load->view('administrator/header-bottom');
			   	$this->load->view('administrator/'.$page, $data);
			   	$this->load->view('administrator/footer');	
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/testimonials';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$uploaded_image = 'noimage.png';
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$uploaded_image = $_FILES['userfile']['name'];
				}
				$this->Administrator_Model->create_testimonial($uploaded_image);

				//Set Message
				$this->session->set_flashdata('success', 'Testimonial has been created.');
				redirect('administrator/testimonials/list');
			}
			
		}

		public function list_testimonial($offset = 0){
			// Pagination Config
			$config['base_url'] = base_url(). 'administrator/team/';
			$config['total_rows'] = $this->db->count_all('teams');
			$config['per_page'] = 3;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'paginate-link');

			// Init Pagination
			$this->pagination->initialize($config);

			$data['title'] = 'List of Testimonials';

			$data['testimonials'] = $this->Administrator_Model->listtestimonial(FALSE, $config['per_page'], $offset);

			$this->load->view('administrator/header-script');
			$this->load->view('administrator/header');
			$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/list-testimonials', $data);
			$this->load->view('administrator/footer');
		}

		public function update_testimonial($id){
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Edit Testimonial';

			$data['testimonial'] = $this->Administrator_Model->listtestimonial($id);

			$this->form_validation->set_rules('name', 'Testimonial Name', 'required');
			$this->form_validation->set_rules('domain', 'Domain', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('administrator/header-script');
			   	$this->load->view('administrator/header');
			   	$this->load->view('administrator/header-bottom');
			   	$this->load->view('administrator/edit-testimonial', $data);
			   	$this->load->view('administrator/footer');	
			}else{
				//Upload Image
				$config['upload_path'] = './assets/images/testimonials';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors =  array('error' => $this->upload->display_errors());
					$data['img'] = $this->Administrator_Model->listtestimonial($this->input->post('id'));
					$uploaded_image = $data['img']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$uploaded_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_testimonial_data($uploaded_image);
			    //Set Message
			    $this->session->set_flashdata('success', 'Testimonial Updated Successfully.');
			    redirect('administrator/testimonials/list');
			}
		}

		public function get_admin_data()
		{
			$data['changePassword'] = $this->Administrator_Model->get_admin_data();
			$data['title'] = 'Change Password';

			$this->load->view('administrator/header-script');
	 	 	 $this->load->view('administrator/header');
	  		 $this->load->view('administrator/header-bottom');
	   		 $this->load->view('administrator/change-password', $data);
	  		$this->load->view('administrator/footer');
		}

		public function change_password($page = 'change-password')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Change password';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_match_old_password');
			$this->form_validation->set_rules('new_password', 'New Password Field', 'required');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'matches[new_password]');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{


				$this->Administrator_Model->change_password($this->input->post('new_password'));

				//Set Message
				$this->session->set_flashdata('success', 'Password Has Been Changed Successfull.');
				redirect('administrator/change-password');
			}
			
		}
		// Check user name exists
		public function match_old_password($old_password){
			
			$this->form_validation->set_message('match_old_password', 'Current Password Does not matched, Please Try Again.');
			$password = md5($old_password);
			$que = $this->Administrator_Model->match_old_password($password);
			if ($que) {
				return true; 
			}else{
				return false;
			}
		}

		public function update_admin_profile()
		{
			$data['user'] = $this->Administrator_Model->get_admin_data();
			$data['title'] = 'Update Profile';

			$this->load->view('administrator/header-script');
	 	 	 $this->load->view('administrator/header');
	  		 $this->load->view('administrator/header-bottom');
	   		 $this->load->view('administrator/update-profile', $data);
	  		$this->load->view('administrator/footer');
		}

		public function update_admin_profile_data($page = 'update-profile')
		{
			if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
		    show_404();
		   }
			// Check login
			if(!$this->session->userdata('login')) {
				redirect('administrator/index');
			}

			$data['title'] = 'Update Profile';

			//$data['add-user'] = $this->Administrator_Model->get_categories();

			$this->form_validation->set_rules('name', 'Name', 'required');

			if($this->form_validation->run() === FALSE){
				 $this->load->view('administrator/header-script');
		 	 	 $this->load->view('administrator/header');
		  		 $this->load->view('administrator/header-bottom');
		   		 $this->load->view('administrator/'.$page, $data);
		  		 $this->load->view('administrator/footer');
			}else{
				//Upload Image
				
				$config['upload_path'] = './assets/images/users';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$id = $this->input->post('id');
					$data['img'] = $this->Administrator_Model->get_user($id);
					$errors =  array('error' => $this->upload->display_errors());
					$post_image = $data['img']['image'];
				}else{
					$data =  array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}

				$this->Administrator_Model->update_user_data($post_image);

				//Set Message
				$this->session->set_flashdata('success', 'User has been Updated Successfull.');
				redirect('administrator/update-profile');
			}
			
		}


		//forget password functions start
		public function forget_password_mail(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');

            //check if email is in the database
        $this->load->model('Administrator_Model');
        if($this->Administrator_Model->email_exists()){
            //$them_pass is the varible to be sent to the user's email
            $temp_pass = md5(uniqid());
            //send email with #temp_pass as a link
            $this->load->library('email', array('mailtype'=>'html'));
            $this->email->from('admin1234567@gmail.com', "Site");
            $this->email->to($this->input->post('email'));
            $this->email->subject("Reset your Password");

            $message = "<p>This email has been sent as a request to reset our password</p>";
            $message .= "<p><a href='".base_url()."administrator/reset-password/$temp_pass'>Click here </a>if you want to reset your password,
                        if not, then ignore</p>";
            $this->email->message($message);

            if($this->email->send()){
                $this->load->model('Administrator_Model');
                if($this->Administrator_Model->temp_reset_password($temp_pass)){
                    echo "check your email for instructions, thank you";
                }
            }
            else{
                echo "email was not sent, please contact your administrator";
            }

        }else{
            echo "your email is not in our database";
        }
}
public function reset_password($temp_pass){
    $this->load->model('Administrator_Model');
    if($this->Administrator_Model->is_temp_pass_valid($temp_pass)){

        $this->load->view('reset-password');
       //once the user clicks submit $temp_pass is gone so therefore I can't catch the new password and   //associated with the user...

    }else{
        echo "the key is not valid";    
    }

}
public function update_password(){
    $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
            if($this->form_validation->run()){
            echo "passwords match";
            }else{
            echo "passwords do not match";  
            }
}


		
	}
	