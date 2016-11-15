<?php 
class cey_categorie extends CI_Model
{
	
	protected $table = 'cey_categorie';

	public function liste_categories_by_entre($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('entre_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'asc')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_categories_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_categorie_id', $id)
						->order_by('ordre', 'asc')
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_categories_by_niveau($niveau)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('niveau', $niveau)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	
	public function getNomcategorieById($id){
		$rq = $this->db->select('info_categorie, entre_id')
					   ->from($this->table)
					   ->where('cey_categorie_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_categories_by_parent($parent)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('parent_id', $parent)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function ordre_dern($id)
	{
		$rq = $this->db->select('ordre')
						->from($this->table)
						->where('entre_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'desc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function ajouter_cat($data)
	{
		
		$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    	
	}


	public function editer_cat($data, $id) {
		return $this->db->where("cey_categorie_id", $id)
						->update($this->table, $data);
	}
		
}