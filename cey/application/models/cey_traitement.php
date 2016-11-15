<?php 
class Cey_traitement extends CI_Model
{
	
	protected $table = 'cey_traitement';

	public function liste_traitement()
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_traitement_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_traitement_id', $id)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_traitement_by_categorieid($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('categorie_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'asc')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function getNomtraitementById($id){
		$rq = $this->db->select('info_traitement, categorie_id')
					   ->from($this->table)
					   ->where('cey_traitement_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function countTtraitement(){
		
		$rq =$this->db->select('count(*)')
					  ->from($this->table)
					  ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_traitement_by_categorie($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('categorie_id', $id)
						->order_by('ordre')
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_traitement_admin()
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_js($tratid)
	{
		$rq = $this->db->select('*')
						->from("cey_traitement_fonction")
						->where('traitement_id', $tratid)
						->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function ajouter_traitement($data)
	{
		
		$this->db->insert($this->table,$data);
    	return $this->db->insert_id();
    	
	}	

	public function liste_source()
	{
		$rq = $this->db->select('source_info')
					->from($this->table)
					->group_by('source_info')
					->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function supprimer_traitement($id, $data){
		return $this->db->where('cey_traitement_id', $id)
				->update($this->table, $data); 	

	}

	public function modifier_traitement($id, $data){
		return $this->db->where('cey_traitement_id', $id)
				->update($this->table, $data); 	

	}


	public function ordre_dern($id)
	{
		$rq = $this->db->select('ordre')
						->from($this->table)
						->where('categorie_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'desc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function ajouter_trait($data)
	{
		
		$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    	
	}


	public function editer_trait($data, $id) {
		return $this->db->where("cey_traitement_id", $id)
						->update($this->table, $data);
	}


	public function editer_trait_ByprocessId($data, $id) {
		return $this->db->where("process_id", $id)
						->update($this->table, $data);
	}


	public function gettraitementById($id){
		$rq = $this->db->select('categorie_id')
					   ->from($this->table)
					   ->where('cey_traitement_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function gettraitementById_process($id){
		$rq = $this->db->select('categorie_id')
					   ->from($this->table)
					   ->where('process_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	
}