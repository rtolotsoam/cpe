<?php 
class Cey_action extends CI_Model
{
	
	protected $table = 'cey_action';

	public function liste_action()
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

	public function liste_action_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_action_id', $id)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_action_by_action($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('action_id', $id)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function liste_action_by_operation($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('operation_id', $id)
						->where('flag', 1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function getNomactionById($id){
		$rq = $this->db->select('info_action, operation_id')
					   ->from($this->table)
					   ->where('cey_action_id',$id)
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
						->where('operation_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'desc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	

	public function ajouter_act($data)
	{
		
		$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    	
	}


	public function editer_act($data, $id) {
		return $this->db->where("process_id", $id)
						->update($this->table, $data);
	}


	public function getactionById($id){
		$rq = $this->db->select('operation_id, ')
					   ->from($this->table)
					   ->where('process_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


}