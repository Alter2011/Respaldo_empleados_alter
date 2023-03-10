<?php
class Observacion_model extends CI_Model{

	 public function getObservacion(){
	 	$this->db->select('*');
        $this->db->from('codigo_observacion'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
	 }

	 public function seveObservacuiones($codigo,$observacion){
	 	 $data = array(
                'codigo'    		  => $codigo,  
                'observacion'         => $observacion,
                'fecha'               => date('Y-m-d'),
                'estado'              => 1,
            );
        $result=$this->db->insert('codigo_observacion',$data);
         return $result;
	 }

	 public function getCodigos($code){
	 	$this->db->select('*');
        $this->db->from('codigo_observacion'); 
        $this->db->where('estado',1);
        $this->db->where('id_observacion',$code);

        $result = $this->db->get();
        return $result->result();
	 }
	public function updateObservacuiones($code,$codigo,$observacion){
        $data = array(
                'codigo'              => $codigo,  
                'observacion'         => $observacion,
            );

        $this->db->where('id_observacion', $code);
        $this->db->update('codigo_observacion', $data);
       return true;
    }

    public function deleteObservaciones($code){
        $data = array(
                'estado'              => 0,
            );

        $this->db->where('id_observacion', $code);
        $this->db->update('codigo_observacion', $data);
       return true;
    }

    public function validarExistencia($codigo){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('codigo_observacion'); 
        $this->db->where('estado',1);
        $this->db->where('codigo',$codigo);

        $result = $this->db->get();
        return $result->result();
    }
}