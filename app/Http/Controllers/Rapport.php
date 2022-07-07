<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rapport extends MX_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->model('dbrapportpro');
		$this->load->library('form_validation');
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2016 05:00:00 GMT");
		date_default_timezone_set('America/New_York');
    }
	
	public function caisse_total()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "caisse_total";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	public function index()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "index";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	


	public function rapport_total_depense(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');

			$datas['depense_somme']=$this->dbrapportpro->search_spent_somm($this->input->post('d1'),$this->input->post('d2'));$datas['search']=$this->dbrapportpro->depense_interval($this->input->post('d1'),$this->input->post('d2'));

			$datas['somme']=$this->dbrapportpro->Sommebetw1($this->input->post('d1'),$this->input->post('d2'));
			$datas['contents'] = "global";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function search_caisse(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');

			$datas['search']=$this->dbrapportpro->selectbetwenVEN($this->input->post('d1'),$this->input->post('d2'));
			
			$datas['somme']=$this->dbrapportpro->Sommebetw1($this->input->post('d1'),$this->input->post('d2'));
			$datas['contents'] = "caisse_total";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	///-------------------------------- rapport caisse user -----------------
	
	public function caisse_user()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['user']=$this->dbrapportpro->Select_user();
			$data['contents'] = "caisse_user";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function search_caisse_user(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			// $datas['d1'] = $this->input->post('d1');
			// $datas['d2'] = $this->input->post('d2');
			// $datas['d3'] = $this->input->post('user');
			$datas['search']=$this->dbrapportpro->search_caisse_user($this->input->post('d1'),$this->input->post('d2'),$this->input->post('user'));
			$datas['user']=$this->dbrapportpro->Select_user();
			$datas['somme']=$this->dbrapportpro->search_caisse_user_somme($this->input->post('d1'),$this->input->post('d2'),$this->input->post('user'));
			$datas['contents'] = "caisse_user";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
//-------------------------------- Rpport Vente --------------------------------------------


	public function vente()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "vente";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	


	public function total_rentre(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$datas['contents'] = "total";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
		public function total_rentre_user(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$datas['user']=$this->dbrapportpro->Select_user();
			$datas['contents'] = "total_rentre_user";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function sum_total_rentre_byuser(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');
			
			
			$date1 = new DateTime($this->input->post('d1')); 
			$date2 = new DateTime($this->input->post('d1')); 
					
					
			$datas['Vent_somme']=$this->dbrapportpro->search_vente_somme_user($this->input->post('d1'),$this->input->post('d2'), $this->input->post('user'));
			$datas['caisse_somme']=$this->dbrapportpro->search_caisse_somm_user($this->input->post('d1'),$this->input->post('d2'), $this->input->post('user'));
			$datas['depense_somme']=$this->dbrapportpro->search_spent_somm_user($this->input->post('d1'),$this->input->post('d2'), $this->input->post('user'));
			$datas['contents'] = "total";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function sum_total_rentre(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');
			
			
			$date1 = new DateTime($this->input->post('d1')); 
			$date2 = new DateTime($this->input->post('d1')); 
					
					
			$datas['Vent_somme']=$this->dbrapportpro->search_vente_somme($this->input->post('d1'),$this->input->post('d2'));
			$datas['caisse_somme']=$this->dbrapportpro->search_caisse_somm($this->input->post('d1'),$this->input->post('d2'));
			$datas['depense_somme']=$this->dbrapportpro->search_spent_somm($this->input->post('d1'),$this->input->post('d2'));
			$datas['contents'] = "total";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function search_vente(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');

			$datas['search']=$this->dbrapportpro->search_vente($this->input->post('d1'),$this->input->post('d2'));
			
			$datas['somme']=$this->dbrapportpro->search_vente_somme($this->input->post('d1'),$this->input->post('d2'));
			$datas['Profit']=$this->dbrapportpro->search_vente_profit($this->input->post('d1'),$this->input->post('d2'));
			$datas['contents'] = "vente";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}	
	
	
		
	public function vente_user()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['user']=$this->dbrapportpro->Select_user();
			$data['contents'] = "vente_user";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
	public function search_vente_user(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$datas['search']=$this->dbrapportpro->search_vente_user($this->input->post('d1'),$this->input->post('d2'),$this->input->post('user'));
			$datas['user']=$this->dbrapportpro->Select_user();
			$datas['somme']=$this->dbrapportpro->search_vente_user_somme($this->input->post('d1'),$this->input->post('d2'),$this->input->post('user'));
			$datas['contents'] = "vente_user";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	//-----------------------Stock--------------------------
	
		public function rapport_global()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "global";
			$this->load->view('template/tmpadmin',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
		
	public function total(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];

			$datas['d1'] = $this->input->post('d1');
			$datas['d2'] = $this->input->post('d2');

			$datas['somme_caisse']=$this->dbrapportpro->Sommebetw1($this->input->post('d1'),$this->input->post('d2'));
			$date1 = new DateTime($this->input->post('d1'));
			$date2 = new DateTime($this->input->post('d2'));
			
			$datas['somme_vente']=$this->dbrapportpro->search_vente_somme($date1->format('m/d/Y'),$date2->format('m/d/Y'));
			$datas['contents'] = "global";

			$this->load->view('template/tmpadmin',$datas);
			}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
}