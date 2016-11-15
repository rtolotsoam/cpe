<?php 
class Cey_operation extends CI_Model
{
	
	protected $table = 'cey_operation';

	public function liste_operation()
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

	public function liste_operation_by_id($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('cey_operation_id', $id)
						->order_by('ordre')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}

	public function liste_operation_by_traitement($id)
	{
		$rq = $this->db->select('*')
						->from($this->table)
						->where('traitement_id', $id)
						->where('flag', 1)
						->order_by('ordre')
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function getNomoperationById($id){
		$rq = $this->db->select('info_operation, traitement_id')
					   ->from($this->table)
					   ->where('cey_operation_id',$id)
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
						->where('traitement_id', $id)
						->where('flag', 1)
						->order_by('ordre', 'desc')
						->limit(1)
						->get();

		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function editer_op($data, $id) {
		return $this->db->where("cey_operation_id", $id)
						->update($this->table, $data);
	}


	public function editer_op_byprocid($data, $id) {
		return $this->db->where("process_id", $id)
						->update($this->table, $data);
	}



	public function ajouter_op($data)
	{
		
		$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    	
	}


	public function getoperationById($id){
		$rq = $this->db->select('traitement_id, info_operation')
					   ->from($this->table)
					   ->where('cey_operation_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}


	public function getoperationByprocessId($id){
		$rq = $this->db->select('traitement_id')
					   ->from($this->table)
					   ->where('process_id',$id)
					   ->get();
		if( $rq->num_rows > 0 ){
			return $rq->result();
		}
		return false;
	}
	
}