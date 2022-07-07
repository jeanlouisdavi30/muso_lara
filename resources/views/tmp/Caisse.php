<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Caisse extends MX_Controller {

	function __construct()
	{
        parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->model('dbcaisse');
		$this->load->library('form_validation');
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 2016 05:00:00 GMT");
		date_default_timezone_set('America/New_York');
    }
	
	
	public function changedate(){
		
		$data = $this->dbcaisse->all_info_caisse();
			
			if(!empty($data)){ 
		
			foreach($data as $key){
				
				$date = $key->date_in;
				$date_tableau = explode('/', $date);
				
				
				$new_date = $date_tableau[2]."/".$date_tableau[0]."/".$date_tableau[1];
				//echo $new_date."</br>";
				$datas = array(
					'date_bn' => $new_date 
				);
						
				// update 
				//$this->dbcaisse->update_caise($key->id_caisse, $datas);

			}
			echo "good";
			
		}else{
			echo "vide";
		}
	}
	
	public function ft_payment_caisse_ver ($type_payment, $anne_payment, $frais_inscription, $cash, $id_etudiant, $id_session, $versement){
		$session_data = $this->session->userdata('login');
		$id_user = $session_data['UserId'];

			$frais_inscription = intval($frais_inscription);
	$cash = intval($cash);
	$somme_balance =$frais_inscription - $cash;
		$data = array(
			'type_payment' => $type_payment,
			'somme' =>$frais_inscription,
			'id_user' =>$id_user,
			'statut' =>"true",
			'date_bn'=>strftime("%Y/%m/%d"),
			'anne_payment' =>$anne_payment,
			'somme_depot' => $cash,
			'somme_balance' => $somme_balance,
			'id_etudiant' => $id_etudiant,
			'id_session' => $id_session,
			'versement'=>$versement
		);
		
		$this->dbcaisse->save_payment_caisse($data);
	}
	
	public function ft_payment_caisse ($type_payment, $anne_payment, $frais_inscription, $cash, $id_etudiant, $id_session){
		$session_data = $this->session->userdata('login');
		$id_user = $session_data['UserId'];

			$frais_inscription = intval($frais_inscription);
	$cash = intval($cash);
	$somme_balance =$frais_inscription - $cash;
		$data = array(
			'type_payment' => $type_payment,
			'somme' =>$frais_inscription,
			'id_user' =>$id_user,
			'statut' =>"true",
			'date_bn'=>strftime("%Y/%m/%d"),
			'anne_payment' =>$anne_payment,
			'somme_depot' => $cash,
			'somme_balance' => $somme_balance,
			'id_etudiant' => $id_etudiant,
			'id_session' => $id_session
		);
		
		$this->dbcaisse->save_payment_caisse($data);
	}
	
	
	public function ft_payment_caisse_ ($type_payment, $anne_payment, $frais_inscription, $somme_depot, $somme_balance, $id_etudiant, $id_session, $versement){
		$session_data = $this->session->userdata('login');
		$id_user = $session_data['UserId'];
		$data = array(
			'type_payment' => $type_payment,
			'somme' =>$frais_inscription,
			'id_user' =>$id_user,
			'statut' =>"true",
			'date_bn'=>strftime("%Y/%m/%d"),
			'anne_payment' =>$anne_payment,
			'somme_depot' => $somme_depot,
			'somme_balance' => $somme_balance,
			'id_etudiant' => $id_etudiant,
			'id_session' => $id_session,
			'versement'=>$versement
		);
		
		$this->dbcaisse->save_payment_caisse($data);
	}
	
	public function return_message($id, $message){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['date_entre'] = $this->date_return($id);
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['session']=$this->dbcaisse->all_session();
			$data['cours']=$this->dbcaisse->all_cours();
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			$data['contents'] = "payment";
			$data['statut'] = $message;
			$this->load->view('template/tmp',$data);
	}

	public function save_payment(){
		if($this->session->userdata('login')){
			
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['id'] = $session_data['UserId'];
			$rules = array(
			
				"type_payment"=>array(
					"field" => "type_payment",
					"label" => "type_payment",
					"rules" => "required"
				),
					"cash"=>array(
					"field" => "cash",
					"label" => "cash",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true)
			{
				$info_inscrit = $this->dbcaisse->info_inscrit($this->input->post("id_etudiant"));
				
				
				if(!empty($info_inscrit)){ foreach($info_inscrit as $key){
					
					if($this->input->post("type_payment") == "inscription"){
						
						$info_payment = $this->dbcaisse->info_payment($this->input->post("id_etudiant"),"inscription");
						if(!empty($info_payment)){

							foreach($info_payment as $inf){   
							
								if($inf->somme_balance == 0){
									
									$this->return_message($this->input->post("id_etudiant"), "L'inscription est déjà payé");
								}else{
									
									if($this->input->post("cash") <=  $inf->somme_balance ){
										
										$somme_depot = $this->input->post("cash");
										$somme_balance = $inf->somme_balance -  $this->input->post("cash");
										
										$this->ft_payment_caisse_(
											$this->input->post("type_payment"),
											"",										
											$key->frais_inscription,
											$somme_depot,
											$somme_balance,
											$this->input->post("id_etudiant"),
											$key->id_session,
											""
										);

		
										$this->return_message($this->input->post("id_etudiant"), "Save succesful");
									}else{
										
										$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
									}
						
								}
							
							}
						
						}else{
							
								if($this->input->post("cash") <=  $key->frais_inscription ){
						
									$this->ft_payment_caisse(
										$this->input->post("type_payment"), "",	$key->frais_inscription, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
									);
									$this->return_message($this->input->post("id_etudiant"), "Save succesful");
								}else{
									
									$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
								}
									
							
						}
					
					
					}elseif($this->input->post("type_payment") == "frais_entre"){
						
						$info_payment = $this->dbcaisse->info_payment($this->input->post("id_etudiant"),"frais_entre");
						
							if(!empty($info_payment)){

							foreach($info_payment as $inf){   
							
								if($inf->somme_balance == 0){
									
									$this->return_message($this->input->post("id_etudiant"), "Le frais entre est déjà payé");
								}else{
									
									if($this->input->post("cash") <=  $inf->somme_balance ){
										
										$somme_depot = $this->input->post("cash");
										$somme_balance = $inf->somme_balance -  $this->input->post("cash");
										
										$this->ft_payment_caisse_(
											$this->input->post("type_payment"), 
											"",	
											$key->frais_entre,
											$somme_depot,
											$somme_balance,
											$this->input->post("id_etudiant"),
											$key->id_session,
											""
										);

		
										$this->return_message($this->input->post("id_etudiant"), "Save succesful");
									}else{
										
										$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
									}
						
								}
							
							}
						
						}else{
							
								if($this->input->post("cash") <=  $key->frais_entre ){
						
									$this->ft_payment_caisse(
										$this->input->post("type_payment"), "",	$key->frais_entre, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
									);
									$this->return_message($this->input->post("id_etudiant"), "Save succesful");
								}else{
									
									$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
								}
									
							
						}
						
					}elseif($this->input->post("type_payment") == "frais_mensuels"){
						
						
					$info_payment_anne = $this->dbcaisse->info_payment_anne($this->input->post("id_etudiant"),"frais_mensuels",$this->input->post("date_pay"));
					
					if(!empty($info_payment_anne)){

							foreach($info_payment_anne as $inf){   
							
								if($inf->somme_balance == 0){
									$this->return_message($this->input->post("id_etudiant"), "Ce mois est déjà payé");
								}else{
									
									if($this->input->post("cash") <=  $inf->somme_balance ){
										
										$somme_depot = $this->input->post("cash");
										$somme_balance = $inf->somme_balance -  $this->input->post("cash");
										
										$this->ft_payment_caisse_(
											$this->input->post("type_payment"), 
											$this->input->post("date_pay"),	
											$key->frais_mensuels,
											$somme_depot,
											$somme_balance,
											$this->input->post("id_etudiant"),
											$key->id_session,
											""
										);
		
										$this->return_message($this->input->post("id_etudiant"), "Save succesful");
										
									}else{
										
										$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
									}
						
								}
							
							}
						
						}else{
							
								if($this->input->post("cash") <=  $key->frais_mensuels ){
						
									$this->ft_payment_caisse(
										$this->input->post("type_payment"), $this->input->post("date_pay"),	$key->frais_mensuels, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
									);
									$this->return_message($this->input->post("id_etudiant"), "Save succesful");
								}else{
									
									$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
								}
									
							
						}
						
					
					}elseif($this->input->post("type_payment") == "Fermeture du Dossier"){
						
							if($this->input->post("cash") ==  $key->f_dossier ){
					
								$this->ft_payment_caisse(
									$this->input->post("type_payment"),"",	$key->f_dossier, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
								);
								$this->return_message($this->input->post("id_etudiant"), "Fermeture du Dossier succesful");
							}else{
								
								$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
							}

					}elseif($this->input->post("type_payment") == "Overture du Dossier"){
						
						
						if($this->input->post("cash") ==  $key->o_dossier ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->o_dossier, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Ouverture du Dossier succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
							

					}					elseif($this->input->post("type_payment") == "Change of Program"){																		if($this->input->post("cash") ==  $key->changeProgram){											$this->ft_payment_caisse(								$this->input->post("type_payment"),"",	$key->changeProgram, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session							);							$this->return_message($this->input->post("id_etudiant"), "Change pro succesful");						}else{														$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");						}												}										elseif($this->input->post("type_payment") == "Document Translation"){																		if($this->input->post("cash") ==  $key->document_translation){											$this->ft_payment_caisse(								$this->input->post("type_payment"),"",	$key->document_translation, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session							);							$this->return_message($this->input->post("id_etudiant"), "Document Translation succesful");						}else{														$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");						}												}
					elseif($this->input->post("type_payment") == "Examen"){
						
						if($this->input->post("cash") ==  $key->examen ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->examen, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Examen save succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "certificat"){
						
						if($this->input->post("cash") ==  $key->certificat ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->certificat, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Certificat save succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "Balance Examen Later"){
						
						if($this->input->post("cash") ==  $key->balance_late_test ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->balance_late_test, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Balance Late Test save succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "Badge"){
						
						if($this->input->post("cash") ==  $key->badge ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->badge, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Badge save succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "Official Grade Transcript"){
						
						if($this->input->post("cash") ==  $key->official_grade_transcript ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->official_grade_transcript, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Official Grade Transcript save succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "Attestation"){
						
						if($this->input->post("cash") ==  $key->attestation ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->attestation, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Attestation succesful");
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "Changement d'Horaire"){
						
						
						if($this->input->post("cash") ==  $key->change_horaire ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->change_horaire, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Changement d'Horaire succesful");
							
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme: ".$key->change_horaire);
						}
						
						
					}
					
					elseif($this->input->post("type_payment") == "Placement Test"){
						
						
						if($this->input->post("cash") ==  $key->placement_test ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->placement_test, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Placement Test succesful");
							
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme: ".$key->change_horaire);
						}
						
						
					}elseif($this->input->post("type_payment") == "Examen Later"){
						
						
						if($this->input->post("cash") ==  $key->examen_late ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->examen_late, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), "Examen Later succesful");
							
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}
					elseif($this->input->post("type_payment") == "Reprise"){
						
						
						if($this->input->post("cash") ==  $key->reprise ){
				
							$this->ft_payment_caisse(
								$this->input->post("type_payment"),"",	$key->reprise, $this->input->post("cash"),$this->input->post("id_etudiant"),$key->id_session
							);
							$this->return_message($this->input->post("id_etudiant"), " Reprise succesful");
							
						}else{
							
							$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
						}
						
						
					}elseif($this->input->post("type_payment") == "frais_session"){
						
						$info_payment = $this->dbcaisse->info_payment_session($this->input->post("id_etudiant"),"frais_session", $this->input->post("versement"));

						if(!empty($info_payment)){

							foreach($info_payment as $inf){   
							
								if($inf->somme_balance == 0 ){
									
									$this->return_message($this->input->post("id_etudiant"), "La session est déjà payé");
									
								}else{
									
									if($this->input->post("cash") <=  $inf->somme_balance ){
										
										$somme_depot = $this->input->post("cash");
										$somme_balance = $inf->somme_balance -  $this->input->post("cash");
										
										$this->ft_payment_caisse_(
											$this->input->post("type_payment"), 
											"",	
											$key->frais_mensuels,
											$somme_depot,
											$somme_balance,
											$this->input->post("id_etudiant"),
											$key->id_session,
											$this->input->post("versement")
										);

		
										$this->return_message($this->input->post("id_etudiant"), "Save succesful");
									}else{
										
										$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
									}
						
								}
							
							}
						
						}else{
							
								if($this->input->post("cash") <=  $key->frais_mensuels ){
						
									$this->ft_payment_caisse_ver(
										$this->input->post("type_payment"), "",	$key->frais_mensuels, $this->input->post("cash"),$this->input->post("id_etudiant"), $key->id_session,$this->input->post("versement")
									);
									$this->return_message($this->input->post("id_etudiant"), "Save succesful lll");
								}else{
									
									$this->return_message($this->input->post("id_etudiant"), "Entre un montant exate avec la somme");
								}
									
							
						}
						
					}
				
				
				}

				
			}else{
				echo "info inscription vide";
			}
		}else{
			redirect('login', 'refresh');
		}
	}
	}
	
	public function search(){
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['contents'] = "search";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	public function date_return ($id){
		
			$data['info_payment'] = $this->dbcaisse->info_payment($id,"frais_mensuels");
			if(empty($data['info_payment'])){
				$info_is = $this->dbcaisse->info_inscrit($id);
				if(!empty($info_is)){
					foreach($info_is as $key){
						return $key->date_entre;
					}
				}
			}else{ foreach($data['info_payment'] as $py){
				
				if($py->somme_balance == 0){
				
					$date = date_create($py->anne_payment);
					$dates =date_add($date, date_interval_create_from_date_string("30 days"));
					return  date_format($dates,"Y-m-d");
					
				}else{
					
					return  $py->anne_payment;
				
				}
				
				
			}

				
			}
	}
	
	public function view_payment_id($id, $id_session){
		
		if($this->session->userdata('login')){
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['in_inscription_pay']=$this->dbcaisse->info_payment_etudiant($id,$id_session,"inscription");
			$data['in_entre_pay']=$this->dbcaisse->info_payment_etudiant($id,$id_session,"frais_entre");
			$data['all_pay']=$this->dbcaisse->all_payment_etudiant($id,$id_session,"frais_mensuels");
			$data['id_etudiant'] = $id;
			$data['contents'] = "gestion_payment";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
		
	}

	public function id($id){
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			$data['date_entre'] = $this->date_return($id);
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['session']=$this->dbcaisse->all_session();
			$data['cours']=$this->dbcaisse->all_cours();
			$data['contents'] = "payment";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	public function Idrecu(){
		
		$add = array(
			'name' =>'id',
		);
		$recuId = $this->dbcaisse->newcommance($add);
		$sess_array = array(
			'id' =>$recuId,
		);
		$this->session->set_userdata('recuId-P', $sess_array);
	}
	
	public function autre_paiement(){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['id'] = $session_data['UserId'];
			$data['contents'] = "autre_paiement";
			$data['paiement_recu'] = $this->dbcaisse->paiement_recu($data['id']);
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	public function autre_paiement_update(){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['id'] = $session_data['UserId'];
			
			$paiement_recu = $this->dbcaisse->paiement_recu($data['id']);
			
			if(!empty($paiement_recu)){ 
			
				foreach($paiement_recu as $k){
					
					$datas = array(
						'print' =>"true"
					);
			
					$this->dbcaisse->update_autre_paiement($k->id, $datas);
				}
				
			}
			
			$data['contents'] = "autre_paiement";
			$data['paiement_recu'] = $this->dbcaisse->paiement_recu($data['id']);
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
	public function print_recu_ap(){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['id'] = $session_data['UserId'];
			$data['contents'] = "print_recu";
			$data['paiement_recu'] = $this->dbcaisse->paiement_recu($data['id']);
			$this->load->view('print_recu',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
		public function del_autre_paiement($id){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['id'] = $session_data['UserId'];
			$this->dbcaisse->del_autre_paiement($id);
			$data['contents'] = "autre_paiement";
			$data['paiement_recu'] = $this->dbcaisse->paiement_recu($data['id']);
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
	public function save_payment_other(){
		
		if($this->session->userdata('login')){
			
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$session_P = $this->session->userdata('recuId-P');
			
			$data['id'] = $session_data['UserId'];
			$rules = array(
			
				"type_payment"=>array(
					"field" => "type_payment",
					"label" => "type_payment",
					"rules" => "required"
				),
					"name_student"=>array(
					"field" => "name_student",
					"label" => "name_student",
					"rules" => "required"
				),
					"montant"=>array(
					"field" => "montant",
					"label" => "montant",
					"rules" => "required"
				)
			);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() ==true)
			{
				$datas = array(
					'name_student' =>$this->input->post("name_student"),
					'type_payment' =>$this->input->post("type_payment"),
					'date_pay' =>$this->input->post("date_pay"),
					'montant' =>$this->input->post("montant"),
					'id_vendeur' =>$data['id'],
					'date_in' =>date("Y/m/d")
				);
		
				$this->dbcaisse->save_other_p($datas);
				$data['paiement_recu'] = $this->dbcaisse->paiement_recu($data['id']);
				$data['contents'] = "autre_paiement";
				$this->load->view('template/tmp',$data);
				
			}else{
				
				
				$data['contents'] = "autre_paiement";
				$this->load->view('template/tmp',$data);
				
			}
			
			
	}else{
			redirect('login', 'refresh');
		}
	}
	
	public function modifier($id){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			$data['date_entre'] = $this->date_return($id);
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['session']=$this->dbcaisse->all_session();
			$data['cours']=$this->dbcaisse->all_cours();
			$data['contents'] = "payment";
			$data['modifier'] = "modifier";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}

	public function delete_caisse(){
		
		if($this->session->userdata('login')){
			$session_data = $this->session->userdata('login');
			$data['username'] = $session_data['username'];
			$data['Fonction'] = $session_data['Fonction'];
			$id = $this->input->post("id_etudiant");
			$this->dbcaisse->delete_caisse($this->input->post("id_caisse"));
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			$data['date_entre'] = $this->date_return($id);
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['session']=$this->dbcaisse->all_session();
			$data['cours']=$this->dbcaisse->all_cours();
			$data['contents'] = "payment";
			$this->load->view('template/tmp',$data);
			
		}else{
			redirect('login', 'refresh');
		}
	}
	
	
	public function print_recu($id){
		if($this->session->userdata('login')){
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			if(!empty($data['payment_id_statut'])) { foreach($data['payment_id_statut'] as $key){
				
				$datas = array(
					'statut' =>"false"
				);
		
				$this->dbcaisse->update_caisse_statut($key->id_caisse, $datas);
				
			}
				
			}
			$data['payment_id_statut']=$this->dbcaisse->payment_id_statut($id);
			$data['date_entre'] = $this->date_return($id);
			$data['info_inscrit']=$this->dbcaisse->info_inscrit($id);
			$data['etudiant_id']=$this->dbcaisse->etudiant_id($id);
			$data['session']=$this->dbcaisse->all_session();
			$data['cours']=$this->dbcaisse->all_cours();
			$data['contents'] = "payment";
			$this->load->view('template/tmp',$data);
		}else{
			redirect('login', 'refresh');
		}
	}

}