<?php 

// REPRESENTATION DE LA TABLE (Cey_reference_process)
class Cey_reference_process extends CI_Model
{
	
	protected $table = 'cey_reference_process';

	// TRAITEMENT REFERENCE PROCESS
	public function liste_reference($canal, $entre)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where($canal)
						->where('entre_id', $entre)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_reference_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('process_id', $id)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function editer_reference_process($date, $id) {
		return $this->db->where("process_id", $id)
						->update($this->table, $date);
	}


	public function editer_process($data, $id) {
		return $this->db->where("cey_reference_process_id", $id)
						->update($this->table, $data);
	}


	public function ajouter_ref_proc($data)
	{
		
		$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    	
	}


	
}