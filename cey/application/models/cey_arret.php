<?php 
class Cey_arret extends CI_Model
{
	
	protected $table = 'cey_arret';

	public function liste_action($procid)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('marche_id', $procid)
						->where('flag', 1)
						->order_by('cey_arret_id', 'asc')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function ajouter_action($data_action) {
		return $this->db->insert($this->table, $data_action);
	}

	public function editer_action($id, $data) {
		return $this->db->where("cey_arret_id", $id)
						->update($this->table, $data);
	}
		
}