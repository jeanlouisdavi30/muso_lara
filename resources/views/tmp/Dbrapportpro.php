<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Dbrapportpro extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
		public function depense_interval($d1,$d2)	{		$this -> db -> select('*');		$this -> db -> where ('dateInter >=',$d1);		$this -> db -> where ('dateInter <=',$d2);		$query = $this -> db -> get('depense');		if($query -> num_rows() > 0)		{			return $query->result();		}		else		{			return false;		}	}
	//---------------------caisse--------------------------
	
		public function selectbetwenVEN($d1,$d2)
	{
		$this -> db -> select('*');
		$this -> db -> where ('date_bn >=',$d1);
		$this -> db -> where ('date_bn <=',$d2);
		//$this -> db -> where ('del','0');
		$query = $this -> db -> get('caisse');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	

	public function Sommebetw1($d1 ,$d2)
	{

		$this->db->select_sum('somme_depot');
		$this -> db -> where ('date_bn >=',$d1);
		$this -> db -> where ('date_bn <=',$d2);
		$this -> db -> where ('del','0');
		$query = $this->db->get('caisse');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
///-----------------Fin Caisse ------------------------------------	
	
		public function Select_user()
	{

		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('personne','personne.Id = users.idPersonne');
		$this -> db -> where ('Fonction ','caisse');
		$query = $this->db->get();

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	///------------------------------CAISSE USER ------------------------
	
	
			public function search_caisse_user($d1,$d2, $user)
	{
		$this -> db -> select('*');
		$this -> db -> where ('date_bn >=',$d1);
		$this -> db -> where ('date_bn <=',$d2);
		$this -> db -> where ('id_user',$user);
		$this -> db -> where ('del','0');
		$query = $this -> db -> get('caisse');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	

	public function search_caisse_user_somme($d1 ,$d2, $user)
	{

		$this->db->select_sum('somme_depot');
		$this -> db -> where ('date_bn >=',$d1);
		$this -> db -> where ('date_bn <=',$d2);
		$this -> db -> where ('id_user',$user);
		$this -> db -> where ('del','0');
		$query = $this->db->get('caisse');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
	
		///------------------------------Vente ------------------------
	
	
			public function search_vente($d1,$d2)
	{
		$this -> db -> select('*');
		$this -> db -> where ('datesale >=',$d1);
		$this -> db -> where ('datesale <=',$d2);
		$query = $this -> db -> get('sale');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
	public function search_vente_somme($d1 ,$d2)
	{

		$this->db->select_sum('somme');
		$this -> db -> where ('datesale >=',$d1);
		$this -> db -> where ('datesale <=',$d2);
		$query = $this->db->get('sale');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
		public function search_caisse_somm($d1 ,$d2)
	{

		$this->db->select_sum('somme_depot');
		$this -> db -> where ('date_bn >=',$d1);
		$this -> db -> where ('date_bn <=',$d2);
		$query = $this->db->get('caisse');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
			public function search_spent_somm($d1 ,$d2)
	{

		$this->db->select_sum('cash');
		$this -> db -> where ('dateInter >=',$d1);
		$this -> db -> where ('dateInter <=',$d2);
		$query = $this->db->get('depense');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
	public function search_vente_profit($d1 ,$d2)
	{

		$this->db->select_sum('Profit');
		$this -> db -> where ('datesale >=',$d1);
		$this -> db -> where ('datesale <=',$d2);
		$query = $this->db->get('sale');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
	
		public function search_vente_user($d1 ,$d2, $user)
	{

		$this->db->select('*');
		$this -> db -> where ('datesale >=',$d1);
		$this -> db -> where ('datesale <=',$d2);
		$this -> db -> where ('iduser',$user);
		$query = $this->db->get('sale');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
		public function search_vente_user_somme($d1 ,$d2, $user)
	{

		$this->db->select_sum('somme');
		$this -> db -> where ('datesale >=',$d1);
		$this -> db -> where ('datesale <=',$d2);
		$this -> db -> where ('iduser',$user);
		$query = $this->db->get('sale');

		if($query -> num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	
}
?>