<?php 
class Cey_marche extends CI_Model
{
	
	protected $table = 'cey_marche';

	public function liste_processus($campid, $canal)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('parent_id', $campid)
						->where('canal', $canal)
						->where('flag', 1)
						->order_by('ordre')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_processus_first($campid, $canal)
	{
		$rq = $this->db->select('cey_marche_id')
						->from($this->table)
						->where('parent_id', $campid)
						->where('canal', $canal)
						->where('flag', 1)
						->order_by('ordre','asc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_processus_dern($campid, $canal)
	{
		$rq = $this->db->select('cey_marche_id, ordre')
						->from($this->table)
						->where('parent_id', $campid)
						->where('canal', $canal)
						->where('flag', 1)
						->order_by('ordre','desc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function get_processus_by_id($procid)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_marche_id', $procid)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function ajouter_processus($data)
	{
		
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
    	
	}

	public function editer_processus($data_set, $id) {
		return $this->db->where("cey_marche_id", $id)
						->update($this->table, $data_set);
	}
	
}