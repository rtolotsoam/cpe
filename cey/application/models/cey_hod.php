<?php 

// REPRESENTATION DE LA TABLE (fte_user)
class Cey_hod extends CI_Model
{
	
	protected $table = 'cey_hod';

	// TRAITEMENT DE L'AUTHENTIFICATION
	public function liste_hod_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_hod_id', $id)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	
}