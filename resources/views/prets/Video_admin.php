<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video_admin extends MX_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->model('dbsite');
		$this->load->library('form_validation');
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2016 05:00:00 GMT");
		date_default_timezone_set('America/New_York');
    }
	
	public function index()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			if($data['Fonction'] == "Admin"){
				$data['lister_video']=$this->dbsite->lister_video_admin();
			}else{
				$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
			}
			
			$data['contents'] = "video";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	

	    // Slugify a string
    function slugify($string)
    {
        // Get an instance of $this
        $CI =& get_instance(); 

        $CI->load->helper('text');
        $CI->load->helper('url');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("²", '2', $string);

        // Slugify and return the string
        return url_title(convert_accented_characters($string), 'dash', true);
    }
	
	
		public function save() 
	{
		if($this->session->userdata('login')){
			
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];

				
					
					$titre =  $this->input->post('titre');
					 
					// verifier if existe 
					
					$infos = $this->dbsite->info_($this->input->post('titre'));

					if(empty($infos)){
						
						$datas = array(
							'type_video'=>$this->input->post('type_video'),
							'date_post'=>strftime("%Y-%m-%d"),
							'id_user'=>$session_data['UserId'],
							'titre'=>$this->input->post('titre'),
							'lien'=>$this->input->post('lien')
						);
						$this->dbsite->add_video($datas);		
						$data['contents'] = "video";
						$data['info'] = " video Bien enregistre !!!";
						if($session_data['Fonction'] == "Admin"){
						$data['lister_video']=$this->dbsite->lister_video_admin();
						}else{
						$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
						}
						$this->load->view('template/tmpadmin',$data);
						
					}else{
						
						$data['contents'] = "video";
						$data['info'] = " video deja enregistre !!!";
												if($session_data['Fonction'] == "Admin"){
						$data['lister_video']=$this->dbsite->lister_video_admin();
						}else{
						$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
						}
						$this->load->view('template/tmpadmin',$data);
						
					}		

		
			
		
		}else{
			redirect('login', 'refresh');
		}
    }
	

		public function update_img() 
	{
		if($this->session->userdata('login')){
			$url = base_url();
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$config['upload_path'] = './public/images/upload/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite']     = TRUE;
			$config['max_size'] = 20000;
			$config['max_width'] = 20000;
			$config['max_height'] = 20000;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('profile_pic')) 
			{

				$data['info'] = $this->upload->display_errors();
										if($session_data['Fonction'] == "Admin"){
						$data['lister_video']=$this->dbsite->lister_video_admin();
						}else{
						$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
						}
				$data['contents'] = "video";
				$this->load->view('template/tmpadmin',$data);
			   
			} 
			else 
			{
				
				$data = array('image_metadata' => $this->upload->data());
				
				if(!empty($data)){
					
					$img1 =  $data['image_metadata']['file_name']; 
					$datas = array(
						'img' =>$url.'public/images/upload/'.$img1
					);

					$this->dbsite->update_video($this->input->post('id_video'), $datas);	
					
					$data['info'] = "  img update !!!";
					if($session_data['Fonction'] == "Admin"){
					$data['lister_video']=$this->dbsite->lister_video_admin();
					}else{
					$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
					}
					$data['contents'] = "video";
					$this->load->view('template/tmpadmin',$data);
									

				}

			}
		
		}else{
			redirect('login', 'refresh');
		}
    }
	

	
	public function id($id){
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "video";
			$data['video_id']=$this->dbsite->video_id($id);
			if($session_data['Fonction'] == "Admin"){
			$data['lister_video']=$this->dbsite->lister_video_admin();
			}else{
			$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
			}
			$this->load->view('template/tmpadmin',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	


	public function delete_video($id){
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "video";
			$this->dbsite->delete_video($id);
			if($session_data['Fonction'] == "Admin"){
			$data['lister_video']=$this->dbsite->lister_video_admin();
			}else{
			$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
			}
			$this->load->view('template/tmpadmin',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	

	
	
	public function update(){
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$rules = array(
				"titre"=>array(
					"field" => "titre",
					"label" => "titre",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true)
			{
				$video_id = $this->dbsite->video_id($this->input->post('id'));
				if(!empty($video_id)){
					foreach($video_id as $v){
						$lien_video = $v->lien;
					}	
				}
				if($this->input->post('lien') == ""){
					$lien = $lien_video;	
				}else{
					$lien = $this->input->post('lien');
				}
					
				$datas = array(
					'plateforme'=>$this->input->post('plateforme'),
					'type_video'=>$this->input->post('type_video'),
					'titre'=>$this->input->post('titre'),
					'slug'=>$this->slugify($this->input->post('titre')),
					'lien'=>$lien
				);

				$this->dbsite->update_video($this->input->post('id'), $datas);
				$data['info'] = " video update !!!";
				$data['video_id']=$this->dbsite->video_id($this->input->post('id'));
				if($session_data['Fonction'] == "Admin"){
				$data['lister_video']=$this->dbsite->lister_video_admin();
				}else{
				$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
				}

				$data['contents'] = "video";
				$this->load->view('template/tmpadmin',$data);


			}else{
				$data['info'] = " Texte Vide !!!";
				$data['video_id']=$this->dbsite->video_id($this->input->post('id'));
				if($session_data['Fonction'] == "Admin"){
				$data['lister_video']=$this->dbsite->lister_video_admin();
				}else{
				$data['lister_video']=$this->dbsite->lister_video($session_data['UserId']);
				}

				$data['contents'] = "video";
				$this->load->view('template/tmpadmin',$data);
			}
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
	

	public function share($slug){

			$data['contents'] = "slug";
			$data['slug']=$this->dbsite->slug($slug);
			$this->load->view('template/tmp',$data);
	
	}


}