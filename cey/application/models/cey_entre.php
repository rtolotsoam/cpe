<?php 

// REPRESENTATION DE LA TABLE (fte_user)
class Cey_entre extends CI_Model
{
	
	protected $table = 'cey_entre';

	// TRAITEMENT DE L'AUTHENTIFICATION
	public function liste_entre()
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('flag', 1)
						->order_by('cey_entre_id', 'asc')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function getNomEntreById($id){
		$rq = $this->db->select('libelle')
					   ->from($this->table)
					   ->where('cey_entre_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	
}