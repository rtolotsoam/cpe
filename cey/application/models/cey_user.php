<?php 

// REPRESENTATION DE LA TABLE (fte_user)
class Cey_user extends CI_Model
{
	
	protected $table = 'cey_user';

	// TRAITEMENT DE L'AUTHENTIFICATION
	public function verifier_login($mle, $pass)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('matricule', $mle)
						->where('pass', $pass)
						->where('statut', 1)
						->where('flag', 1)
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_utilisateur()
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

	public function liste_utilisateur_ById($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_user_id', $id)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	
	public function ajouter_user($data_user) {
		return $this->db->insert($this->table, $data_user);
	}


	
	public function editer_user($id, $data) {
		return $this->db->where("cey_user_id", $id)
						->update($this->table, $data);
	}
	
}