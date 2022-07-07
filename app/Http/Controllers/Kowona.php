<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kowona extends MX_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->helper('form');
		$this->load->model('dbsite');
		$this->load->helper('url');
		$this->load->library('form_validation');
				$this->load->library('email');
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2016 05:00:00 GMT");
		date_default_timezone_set('America/New_York');
    }
	
		
		public function formulaire() 
	{
		
		$data['contents'] = "Kowona_vide";
		$data['titre'] = "VAKSINEN KONT KOWONA";		
		$this->load->view('template/tmp',$data);
	}
	
		public function save() 
	{
	
			
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$config['upload_path'] = './public/music/';
			$config['allowed_types'] = 'avi|mpeg|mp3|mp4|3gp|wmv|ogg'; 
			
			$config['overwrite']     = TRUE;
			$config['max_size'] = 40000000; 
            $config['remove_spaces'] = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) 
			{
				$data['info'] = $this->upload->display_errors();
				$data['contents'] = "Kowona_vide";
				$data['titre'] = "VAKSINEN KONT KOWONA";		
				$this->load->view('template/tmp',$data);
			   
			} 
			else 
				
			{
				$data = array('image_metadata' => $this->upload->data());
				
				$music_name =  $data['image_metadata']['file_name']; 
				$url = 'https://eegale.com/public/music/'.$music_name;
				
				
				$datas = array(
					'siyati' => $this->input->post('siyati'),
					'non' => $this->input->post('non'),
					'non_atis' => $this->input->post('non_atis'),
					'ddn' => $this->input->post('ddn'),
					'email' => $this->input->post('email'),
					'telf' => $this->input->post('telf'),
					'kategori' => $this->input->post('kategori'),
					'music_url' => $url,
				);

				$this->dbsite->save($datas);
				
								$data['contents'] = "Kowona_vide";
				$data['titre'] = "VAKSINEN KONT KOWONA";		
				$this->load->view('template/tmp',$data);
				
			}

    }
	
	
	public function send_mail($id, $id_examen , $code){
		
			$data['info_inscrit']=$this->dbniveau->info_inscrit($id);
			$data['etudiant_id']=$this->dbniveau->etudiant_id($id);
			
			if(!empty($data['info_inscrit'])){ foreach($data['info_inscrit'] as $key){ $id_session = $key->id_session;}
				$id_niveau = $this->id_niveau_etudiant_($id,$id_session);
			}
			$info_exa = $this->dbniveau->id_examen($id_examen);
			
			if(!empty($info_exa)){ 
				foreach($info_exa as $if){
					$examen = $if->type;
					$matier = $if->matier;
				}
			}
			$info_email = $this->dbniveau->info_email($examen, $id_niveau, $id_session, $id);
			
			if(empty($info_email)){
				
				// save dossier etudiant
				$data_save = array(
					'examen'=>$examen,
					'id_niveau' =>$id_niveau,
					'matier' =>$matier,
					'id_session' => $id_session,
					'id_etudiant' => $id
				);

				$id_examen_ev = $this->dbniveau->save_examen_mail($data_save);
					
				$data['etudiant_id']=$this->dbniveau->etudiant_id($id);
				if(!empty($data['etudiant_id'])){foreach($data['etudiant_id'] as $k){$email = $k->email;}}
				
				$url = $id."/".$id."-".$code."/".$id_niveau."/".$id_session."/".$examen."/".$id_examen_ev."/".$matier;
				$lien = $this->encrypt->encode($url);
				$mesaj = "http://localhost/ces/examen/online/".$lien;
			
				// Configure email library
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'ssl://smtp.googlemail.com';
				$config['smtp_port'] = 587;
				$config['smtp_user'] = 'caribbean@bozohaiti.website';
				$config['smtp_pass'] = 'pj.one509';
				$config['mailtype'] = 'html';
				$config['charset'] = 'iso-8859-1';

				// Load email library and passing configured values to email library
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");

				// Sender email address
				$this->email->from('caribbean@bozohaiti.website', 'Caribbean english School');
				// Receiver email address
				$this->email->to($email);
				// Subject of email
				$this->email->subject('Test online');
				// Message in email
				//$body = $this->load->view('email.php',$data,TRUE);
				

				$this->email->message($mesaj);


				if($this->email->send()){
					
					return " Email send  !!! ";
					
				}else{
					
					return " Error  !!! ";
				}
				
				
				
			}else{
				return " Test already sent  !!! ";
			}
	}
	
	
	
	public function index()
    {
		$data['contents'] = "kowona_campagne";
		$data['titre'] = "VAKSINEN KONT KOWONA";		
		$this->load->view('template/tmp_kowona',$data);

	}
	
	
	
			public function groupe_cibles()
    {
		$data['contents'] = "groupe_cibles";
		$this->load->view('template/tmp_kowona',$data);

	}
	
		public function objectif()
    {
		$data['contents'] = "objectif";
		$this->load->view('template/tmp_kowona',$data);

	}
	
	
		public function form()
    {
		$data['contents'] = "Kowona_vide";
		//$data['contents'] = "Kowona_vide";
		$data['titre'] = "VAKSINEN KONT KOWONA";		
		//$this->load->view('template/tmp',$data);

	}
	
		public function terme()
    {
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="test.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
     @readfile('https://eegale.com/public/Kondisyon-patisipasyon.pdf');
	 
		// $data['contents'] = "terme";		
		// $this->load->view('template/tmp',$data);

	}

}