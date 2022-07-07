<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends MX_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->model('dbcashier');
		$this->load->helper('url');
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2016 05:00:00 GMT");
		date_default_timezone_set('America/Los_Angeles');
    }					public function changedate(){				$data = $this->dbcaisse->all_info_sale();						if(!empty($data)){ 					foreach($data as $key){								$date = $key->date_in;				$date_tableau = explode('/', $date);												$new_date = $date_tableau[2]."/".$date_tableau[0]."/".$date_tableau[1];				//echo $new_date."</br>";				$datas = array(					'date_bn' => $new_date 				);										// update 				//$this->dbcaisse->update_caise($key->id_caisse, $datas);			}			echo "good";					}else{			echo "vide";		}	}	
	public function select(){
		if($this->session->userdata('login')) {
			redirect($this->input->post('name'), 'refresh');
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	
		public function balance(){
		if($session_data = $this->session->userdata('login')) {
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$data['contents'] = "balance";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
		public function list_produit(){
	if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['client']=$this->dbcashier->Selectclientid($this->uri->segment(3));
			$data['recuid']=$this->dbcashier->Selectrecuid($this->uri->segment(3));
			$data['Sm_recuid']=$this->dbcashier->Sommrec($this->uri->segment(3));
			$data['balance']=$this->dbcashier->SommBalance($this->uri->segment(3));
			$data['contents'] = "list_produit";
			$this->load->view('template/tmp',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}	
	}
	
		public function payer_balance($id){
		
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$cashId = $this->dbcashier->SelectCashId($id);
			if(!empty($cashId)){
				foreach($cashId as $key){
					if($key->balance != 0){
						$sess_array = array(
						'cash'=>$key->balance + $key->cash,
						'balance'=>0
						);
						$this->dbcashier->update_cash($id, $sess_array);
					}
				}
			}
			
			
			$data['client']=$this->dbcashier->Selectclientid($this->uri->segment(3));
			$data['recuid']=$this->dbcashier->Selectrecuid($this->uri->segment(3));
			$data['Sm_recuid']=$this->dbcashier->Sommrec($this->uri->segment(3));
			$data['balance']=$this->dbcashier->SommBalance($this->uri->segment(3));
			$data['contents'] = "list_produit";
			$this->load->view('template/tmp',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}	
	}
	
	public function vente_client($id){
		
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$data['cashclients']=  $this->dbcashier->SelectCashIdclient($id);
		
			$data['contents'] = "cashclients";
			$this->load->view('template/tmp',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}	
	}
	
//-------------------Client depot -------------------------------	
	public function client(){
		if($session_data = $this->session->userdata('login')) {
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$data['contents'] = "clients";
			$this->load->view('template/tmpclient',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	public function view_client(){
		
		if($session_data = $this->session->userdata('login')) {
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['etudiant']=$this->dbcashier->Select_etudiant();
			$data['contents'] = "view_client";
			$this->load->view('template/tmpclient',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	public function sale_idclient(){
		if($session_data = $this->session->userdata('login')) {
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$data['sale_client']=$this->dbcashier->Sale_view_clients($this->input->post('id'));
			$data['contents'] = "sale_client";
			$this->load->view('template/tmpclient',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	public function add_client(){
		if($session_data = $this->session->userdata('login')) {
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			
			$data['contents'] = "add_client";
			$this->load->view('template/tmpclient',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
		public function numero_is_taken($input){
			
		$query = "Select * FROM client_depot where Numero =?";
		$arg   = array($input);
		$exec  = $this->db->query($query, $arg) or die(mysql_error());

		if($exec->num_rows() > 0){
			$this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');

			return False;
		}else{
			return true;
		}
	}
	
		public function regist_client(){
		if($session_data = $this->session->userdata('login')){
$session_recuid = $this->session->userdata('recuId');
			$rules = array(
				"name"=>array(
					"field" => "name",
					"label" => "name",
					"rules" => "required"
				),

				"Address"=>array(
					"field" => "Address",
					"label" => "Address"
				),
				"numero"=>array(
					"field" => "numero",
					"label" => "numero",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true){

				$numero = $this->dbcashier->get_numero($this->input->post('numero'));
				if(empty($numero)){
					$data1 = array(
						'Name' => $this->input->post('name'),
						'Addres'=>$this->input->post("Address"),
						'Numero'=>$this->input->post("numero")
					);
					$id=$this->dbcashier->Addclient($data1);
					redirect('Cashier', 'refresh');
				}else{
					
					$data['error'] = "Numero client existe deja";
					$data['contents'] = "add_client";
				$this->load->view('template/tmpclient',$data);
					
				}

				
				


			}else{
				$data['contents'] = "add_client";
				$this->load->view('template/tmpclient',$data);
			}
		}

	}
	public function vent_idclient (){
		if($session_data = $this->session->userdata('login')){
				$session_recuid = $this->session->userdata('recuId');
				$data['contents'] = "sal_depot";
				$data['sale_client']=$this->dbcashier->Sale_view_client($this->input->post('id'));
				$data['product']=$this->dbcashier->Selectprodui($session_data['UserId']);
				$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
				$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
				$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
				$this->load->view('template/tmpclient',$data);
		}else{
			redirect('login', 'refresh');
		}
	}	
	public function update_sal_cleint(){
		if($this->session->userdata('login')){
				$session_recuid = $this->session->userdata('recuId');
					$sal = $this->dbcashier->Sale_view_client_id($this->input->post('id'));
					$depot = $this->input->post('depot');
					if(!empty($sal)){
						foreach ($sal as $key){
							if($key->depot >= $depot){
	
								$datam = array(
								'qty_pri' =>$key->qty_pri + $depot,
								'depot'=>$key->depot - $depot
								);
								$this->dbcashier->update_sal($key->id,$datam);
								
								$datasale['product']=$this->dbcashier->Selectrecusale_depot($key->idrecu);
								$datasale['recuprix']=$this->dbcashier->Selectsalerecucash($key->idrecu);
								$datasale['sommesale']=$this->dbcashier->Sommesale($key->idrecu);
								$datasale['sommearticle']=$this->dbcashier->sommearticle($key->idrecu);
								$dat=$this->dbcashier->Sommesale($this->input->post('idrecu'));
								$this->load->view('recu_depot',$datasale);
							
							}else{
								
								$datasale['sale_client']=$this->dbcashier->Sale_view_client($key->id);
								$datasale['product']=$this->dbcashier->Selectrecusale_depot($key->idrecu);
								$datasale['recuprix']=$this->dbcashier->Selectsalerecucash($key->idrecu);
								$datasale['sommesale']=$this->dbcashier->Sommesale($key->idrecu);
								$datasale['sommearticle']=$this->dbcashier->sommearticle($key->idrecu);
								$dat=$this->dbcashier->Sommesale($this->input->post('idrecu'));
								$datasale['contents'] = "sal_depot";
								$datasale['erreur'] = "verification..! trop de quantite ";
								$this->load->view('template/tmpclient',$datasale);
							}
						}
						
					}else{
						echo "vide";
					}

		}else{
			redirect('login', 'refresh');
		}
	}
	public function savesale_depot(){
		if($this->session->userdata('login')) {	
		$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$session_data = $this->session->userdata('login');
			$recuId_depot = $this->session->userdata('recuId_depot');
			$data=$this->dbcashier->SelectprouctID($this->input->post('product'));
				if(!empty($data)){
					//--------------------qty
					foreach($data AS $key){		
					if($key->Qty >= $this->input->post('qty')){
					$qty_depot = $this->input->post('qty');	
					$depot_dep = $this->input->post('depot');
					if($qty_depot == $depot_dep or $qty_depot < $depot_dep){
						
					$data['somme']=$this->dbcashier->Sommesale($recuId_depot['id']);
					$data['sale']=$this->dbcashier->Selectsale_depot($recuId_depot['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($recuId_depot['id']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($recuId_depot['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($recuId_depot['id']);
					$data['ereur'] = "le quantite Stocke doit être inférieure ";
					$data['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$data);	
					}else{
					$datas = array(
					'idrecu' =>$recuId_depot['id'],
					'NomProduit' => $key->NomProduit,
					'Description' => $key->Description,
					'PrixVent' => $key->PrixVent,
					'idproduc' => $key->IdProduit,
					'Qty'=>$this->input->post('qty'),
					'somme'=>$key->PrixVent * $this->input->post('qty'),
					'iduser'=>$session_data['UserId'],
					'datesale'=>$date=(strftime("%m/%d/%Y")),
					);

					$sommeqty=$this->dbcashier->sommeqyt($key->Qty, $this->input->post('qty'));
					$datam = array(
					'Qty' =>$sommeqty
					);
					$this->dbcashier->updatepro($key->IdProduit,$datam);
					$data['id']=$recuId_depot['id'];
					//------------------vente enregistre------------------
					$idsale = $this->dbcashier->Addsale($datas);
					
					$data_depot = array(
					'idrecu' =>$recuId_depot['id'],
					'NomProduit' => $key->NomProduit,
					'Description' => $key->Description,
					'PrixVent' => $key->PrixVent,
					'idproduc' => $key->IdProduit,
					'Qty'=>$this->input->post('qty'),
					'qty_pri'=>$this->input->post('qty') - $this->input->post('depot'),
					'depot'=>$this->input->post('depot'),
					'somme'=>$key->PrixVent * $this->input->post('qty'),
					'iduser'=>$session_data['UserId'],
					'datesale'=>$date=(strftime("%m/%d/%Y")),
					'idclient'=>$recuId_depot['idclient'],
					'idsale'=>$idsale
					);
					$this->dbcashier->Addsale_depot($data_depot);
					
					$data['somme']=$this->dbcashier->Sommesale($recuId_depot['id']);
					$data['sale']=$this->dbcashier->Selectsale_depot($recuId_depot['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($recuId_depot['id']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($recuId_depot['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($recuId_depot['id']);
					$data['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$data);
					}	

					}else{
											
					$data['somme']=$this->dbcashier->Sommesale($recuId_depot['id']);
					$data['sale']=$this->dbcashier->Selectsale_depot($recuId_depot['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($recuId_depot['id']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($recuId_depot['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($recuId_depot['id']);
					$data['ereur'] = "vous n'avez pass assez de quantite";
					$data['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$data);
					}
					}

				}else{
					echo "vide";
				}

		
		}else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}

	//------------------------delete sale depot-------------
	
	
		public function delsale_depot(){
		if($this->session->userdata('login')){
			$session_recuid = $this->session->userdata('recuId_depot');
			$session_data = $this->session->userdata('login');
			$rules = array(
				"id"=>array(
					"field" => "id",
					"label" => "id",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true)
			{
				$datasale=$this->dbcashier->Selectsaleid($this->input->post('idsale'));
				if(!empty($datasale)){
					foreach($datasale AS $key){

						$this->dbcashier->delete_sale($key->id);
						$pro=$this->dbcashier->SelectprouctID($key->idproduc);
						foreach($pro AS $keyy){
							$data1 = array(
								'Qty'=>$quantite=$this->dbcashier->som($keyy->Qty, $key->Qty),
							);
						}
						$this->dbcashier->update_produi($key->idproduc,$data1);
						
						$this->dbcashier->delete_sale_depot($this->input->post('id'));
						$datasale['id']=$key->idrecu;
						$datasale['sale']=$this->dbcashier->Selectsale_depot($session_recuid['id']);
						$datasale['product']=$this->dbcashier->Selectprodui();
						$datasale['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
						$datasale['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
						$datasale['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
						$datasale['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$datasale);
					}
				}else{
								$datasale['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$datasale);
				}

			}else{
								$datasale['contents'] = "cashier_depot";
					$this->load->view('template/tmpclient',$datasale);
			}
		}else{
			redirect('login', 'refresh');
		}
	}
		public function addcashh_depot(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data = array(
				'idrecu' => $this->input->post('idrecu'),
				'somme' => $this->input->post('somme'),
				'cash' => $this->input->post('cash'),
				'iduser' =>$session_data['username'],
				'cashback' =>$this->input->post('cash') - $this->input->post('somme')
			);
			$this->dbcashier->Addcash($data);
			$datasale['product']=$this->dbcashier->Selectrecusale_depot($this->input->post('idrecu'));
			$datasale['recuprix']=$this->dbcashier->Selectsalerecucash($this->input->post('idrecu'));
			$datasale['sommesale']=$this->dbcashier->Sommesale($this->input->post('idrecu'));
			$datasale['sommearticle']=$this->dbcashier->sommearticle($this->input->post('idrecu'));
			$dat=$this->dbcashier->Sommesale($this->input->post('idrecu'));
			$this->load->view('recu_depot',$datasale);
		}else{
		}

	}
//-----------------------------fin----------------------------	
	public function index()
    {
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$session_recuid = $this->session->userdata('recuId');
			$data['id']=$session_recuid['id'];
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['sale']=$this->dbcashier->Selectsale($data['id']);
			$data['etudiant']=$this->dbcashier->Select_etudiant();
			$data['product']=$this->dbcashier->Selectprodui();
			$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
			$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
			$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
			$data['contents'] = "cashier";
			$this->load->view('template/tmp',$data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}

	public function Idrecu(){
		$add = array(
			'name' =>'id',
		);
		$recuId = $this->dbcashier->newcommance($add);
		$sess_array = array(
			'id' =>$recuId,
		);
		$this->session->set_userdata('recuId', $sess_array);
		redirect('Cashier', 'refresh');
	}
//----------------------------sale------------------------------
	public function savesale(){
		if($this->session->userdata('login'))
		{
			$session_data = $this->session->userdata('login');
			$session_recuid = $this->session->userdata('recuId');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$session_data = $this->session->userdata('login');
			$session_idrecu = $this->session->userdata('recuId');
			$data=$this->dbcashier->SelectprouctID($this->input->post('product'));
				if(!empty($data)){
					//--------------------qty
					foreach($data AS $key){		
					if($key->Qty >= $this->input->post('qty')){
					$datas = array(
					'idrecu' =>$session_idrecu['id'],
					'NomProduit' => $key->NomProduit,
					'Description' => $key->Description,
					'PrixAchat' => $key->PrixAchat,
					'PrixVent' => $key->PrixVent,
					'idproduc' => $key->IdProduit,
					'Qty'=>$this->input->post('qty'),
					'somme'=>$key->PrixVent * $this->input->post('qty'),
					
					'iduser'=>$session_data['UserId'],
					'datesale'=>$date=(strftime("%m/%d/%Y")),
					'Profit'=>$key->Profit * $this->input->post('qty')
					);

					$sommeqty=$this->dbcashier->sommeqyt($key->Qty, $this->input->post('qty'));
					$datam = array(
					'Qty' =>$sommeqty
					);
					$this->dbcashier->updatepro($key->IdProduit,$datam);
										$data['id']=$session_idrecu['id'];
					$this->dbcashier->Addsale($datas);
					$data['somme']=$this->dbcashier->Sommesale($session_idrecu['id']);
					$data['sale']=$this->dbcashier->Selectsale($session_idrecu['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($session_data['UserId']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
					$data['etudiant']=$this->dbcashier->Select_etudiant();
					$data['contents'] = "cashier";
					$this->load->view('template/tmp',$data);
					}else{
											
					$data['somme']=$this->dbcashier->Sommesale($session_idrecu['id']);
					$data['sale']=$this->dbcashier->Selectsale($session_idrecu['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($session_data['UserId']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
					$data['etudiant']=$this->dbcashier->Select_etudiant();
					$data['contents'] = "cashier";
					$data['ereur'] = "vous n'avez pass assez de quantite";
					$this->load->view('template/tmp',$data);
					}
					}

				}else{
			
										$data['somme']=$this->dbcashier->Sommesale($session_idrecu['id']);
					$data['sale']=$this->dbcashier->Selectsale($session_idrecu['id']);		
					$data['product']=$this->dbcashier->Selectprodui();
					$data['SmSale']=$this->dbcashier->SommSaleday($session_data['UserId']); 
					$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
					$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
					$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
					$data['etudiant']=$this->dbcashier->Select_etudiant();
					$data['contents'] = "cashier";
					$data['ereur'] = "empty";
					$this->load->view('template/tmp',$data);
					
				}

		
		}else{
			redirect('login', 'refresh');

		}
	}
	public function recu(){
		if($this->session->userdata('login')){
			$data['somme']=$this->dbcashier->Sommesale($this->input->post('id'));
			$data['id']=$this->input->post('id');
			$data['contents'] = "addcash";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	public function addcashh(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$data['id'] = $session_data['UserId'];
			$somme = $this->input->post('somme');
			$Discount = $this->input->post('Discount');
			$res = $somme;
			$Resul = $res / 100 ;
			$Resulta = $somme - $Resul ;
			$client = $this->input->post('client');
			
			$cashId = $this->dbcashier->cash_Idrec($this->input->post('idrecu'));
			if(!empty($cashId)){
				foreach($cashId as $key){
					$idclient = $key->idclient;
				}
			}
			$c = $this->input->post('client');
				if(!empty($c)){
				
					if($this->input->post('cash') >= $this->input->post('somme') ){
						
						$cash_Idrec = $this->dbcashier->cash_Idrec($this->input->post('idrecu'));
						if(empty($cash_Idrec)){
							
								$data = array(
								'idrecu' => $this->input->post('idrecu'),
								'idclient' => $this->input->post('client'),
								'somme' =>$this->input->post('somme'),
								'cash' => $this->input->post('cash'),
								'iduser' =>$session_data['UserId'],
								'Date'=>$date=(strftime("%m/%d/%Y")),
								'Discount' =>$this->input->post('Discount'),
								'balance' => $this->dbcashier->sommeqyt($this->input->post('somme'), $this->input->post('cash'))
							);
							$this->dbcashier->Addcash($data);
						}
						
						
						//$datasale['client']=$this->dbcashier->Selectcliendepot($this->input->post('client'));
						$datasale['Discount']=$Discount;
						$datasale['somme']=$this->input->post('somme');
						$datasale['product']=$this->dbcashier->Selectrecusale($this->input->post('idrecu'));
						$datasale['recuprix']=$this->dbcashier->Selectsalerecucash($this->input->post('idrecu'));
						$datasale['sommesale']=$this->dbcashier->Sommesale($this->input->post('idrecu'));
						$datasale['sommearticle']=$this->dbcashier->sommearticle($this->input->post('idrecu'));
						$datasale['etudiant']=$this->dbcashier->Select_etudiant();
						$datasale['etudiant_id']=$this->dbcashier->etudiant_id($this->input->post('client'));
						$dat=$this->dbcashier->Sommesale($this->input->post('idrecu'));
						$this->load->view('recu',$datasale);
					}else{
							$data['id']=$this->input->post('idrecu');
							$data['somme']=$this->dbcashier->Sommesale($this->input->post('idrecu'));
							$data['sale']=$this->dbcashier->Selectsale($this->input->post('idrecu'));		
							$data['product']=$this->dbcashier->Selectprodui();
							$data['SmSale']=$this->dbcashier->SommSaleday($this->input->post('idrecu')); 
							$data['sommesale']=$this->dbcashier->Sommesaleday($this->input->post('idrecu'));
							$data['sommerecu']=$this->dbcashier->Sommesalerecu($this->input->post('idrecu'));
							$data['sommearticle']=$this->dbcashier->sommearticle($this->input->post('idrecu'));
							$data['contents'] = "cashier";
							$data['etudiant']=$this->dbcashier->Select_etudiant();
							$data['ereur'] = "Entre un montant exact qui égale avec la somme ";
							$this->load->view('template/tmp',$data);
					}
					
					
					
			}else{
											$data['id']=$this->input->post('idrecu');
							$data['somme']=$this->dbcashier->Sommesale($this->input->post('idrecu'));
							$data['sale']=$this->dbcashier->Selectsale($this->input->post('idrecu'));		
							$data['product']=$this->dbcashier->Selectprodui();
							$data['SmSale']=$this->dbcashier->SommSaleday($this->input->post('idrecu')); 
							$data['sommesale']=$this->dbcashier->Sommesaleday($this->input->post('idrecu'));
							$data['sommerecu']=$this->dbcashier->Sommesalerecu($this->input->post('idrecu'));
							$data['sommearticle']=$this->dbcashier->sommearticle($this->input->post('idrecu'));
							$data['contents'] = "cashier";
							$data['etudiant']=$this->dbcashier->Select_etudiant();
							$data['ereur'] = "Selectionner un Client";
							$this->load->view('template/tmp',$data);
				
			}		
		
		}else{
		}

	}
	
	
		public function imei(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$session_idrecu = $this->session->userdata('recuId');
			$session_recuid = $this->session->userdata('recuId');
			$somme = $this->input->post('somme');
			$data['id']=$session_idrecu['id'];
		
		
			$data1 = array(
					
						'imei'=>$this->input->post('imei')
					);
				
					$this->dbcashier->update_produi_imei($this->input->post('id'),$data1);
					
					
			$data['somme']=$this->dbcashier->Sommesale($session_idrecu['id']);
			$data['sale']=$this->dbcashier->Selectsale($session_idrecu['id']);		
			$data['product']=$this->dbcashier->Selectprodui();
			$data['etudiant']=$this->dbcashier->Select_etudiant();
			$data['SmSale']=$this->dbcashier->SommSaleday($session_data['UserId']); 
			$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
			$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
			$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
			$data['contents'] = "cashier";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}

	}
	
	
	
//------------------------------Discount ----------------------------	
	public function discount(){
		if($this->session->userdata('login')) {
			$session_data = $this->session->userdata('login');
			$session_idrecu = $this->session->userdata('recuId');
			$session_recuid = $this->session->userdata('recuId');
			$somme = $this->input->post('somme');
			$data['id']=$session_idrecu['id'];
		
		
			$Selectsaleid =$this->dbcashier->Selectsaleid($this->input->post('id'));
		
			if(!empty($Selectsaleid)){
				
				foreach($Selectsaleid as $key){
				    
				
					$qty = $key->Qty;
					$Discount = $this->input->post('Discount');

					$prixtotal  = $key->PrixVent - $Discount;
					$Resul = $prixtotal * $qty;
					$data1 = array(
						'somme'=>$Resul,
						'discount'=>$this->input->post('Discount')
					);
				
					$this->dbcashier->update_produi_sal($this->input->post('id'),$data1);
					$data['Discount'] = $Resul;
					$data['Discountform'] = $this->input->post('Discount');
				}
			}
			
			/**
			if(!empty($sommerecu)){
				foreach($sommerecu as $key){
					$somme = $key->somme;
					$Discount = $this->input->post('Discount');
					$res = $somme * $Discount;
					$Resul = $res / 100 ;
					$Resulta = $somme - $Resul ;
					$data['Discount'] = $Resulta;
					$data['Discountform'] = $this->input->post('Discount');
				}
			}
			**/
			$data['somme']=$this->dbcashier->Sommesale($session_idrecu['id']);
			$data['sale']=$this->dbcashier->Selectsale($session_idrecu['id']);		
			$data['product']=$this->dbcashier->Selectprodui();
			$data['etudiant']=$this->dbcashier->Select_etudiant();
			$data['SmSale']=$this->dbcashier->SommSaleday($session_data['UserId']); 
			$data['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
			$data['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
			$data['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
			$data['contents'] = "cashier";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}

	}
//----------------------Fin ---------------------------------------------	
	public function delsale(){
		if($this->session->userdata('login')){
			$session_recuid = $this->session->userdata('recuId');
			$session_data = $this->session->userdata('login');
			$rules = array(
				"id"=>array(
					"field" => "id",
					"label" => "id",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true)
			{
				$datasale=$this->dbcashier->Selectsaleid($this->input->post('id'));
				if(!empty($datasale)){
					foreach($datasale AS $key){

						$this->dbcashier->delete_sale($key->id);
						$pro=$this->dbcashier->SelectprouctID($key->idproduc);
						foreach($pro AS $keyy){
							$data1 = array(
								'Qty'=>$quantite=$this->dbcashier->som($keyy->Qty, $key->Qty),
							);
						}
						$this->dbcashier->update_produi($key->idproduc,$data1);

						$datasale['id']=$key->idrecu;
						$datasale['contents'] = "cashier";
						$datasale['sale']=$this->dbcashier->Selectsale($session_recuid['id']);
						$datasale['product']=$this->dbcashier->Selectprodui();
						$datasale['sommesale']=$this->dbcashier->Sommesaleday($session_data['UserId']);
						$datasale['sommerecu']=$this->dbcashier->Sommesalerecu($session_recuid['id']);
						$datasale['sommearticle']=$this->dbcashier->sommearticle($session_recuid['id']);
						$datasale['etudiant']=$this->dbcashier->Select_etudiant();
						$this->load->view('template/tmp',$datasale);
					}
				}else{
					$datasale['contents'] = "cashier";
					$this->load->view('template/tmp',$datasale);
				}

			}else{
				$data['contents'] = "cashier";
				$this->load->view('template/tmp');
			}
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
	 
	
		public function delete_client($id){
		if($this->session->userdata('login')){
				$this->dbcashier->delete_cl($id);
				$data['etudiant']=$this->dbcashier->Select_etudiant();
				$data['contents'] = "view_client";
				$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	public function logout() {
        $this->session->unset_userdata('login');
        session_destroy();
        redirect('login', 'refresh');
    }
		
}