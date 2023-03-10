<?php
class Tiempo_model extends CI_Model{
    //todas estas consultas son de tablas de la bdd de tablero
	 public function getTiempos(){
        //tiempos de rentas activos 
	 	$this->db->select('*');
        $this->db->from('tiempo_renta'); 
        $this->db->where('estado',1);

        $result = $this->db->get();

        return $result->result();
	 }

     public function saveTiempos($nombre,$unidad,$total){
         $data = array(
                'nombre'              => $nombre,  
                'unidad_basica'       => $unidad,
                'total_trabajo'       => $total,
                'estado'              => 1,
            );
        $result=$this->db->insert('tiempo_renta',$data);
         return $result;
     }

      public function getTiempo($code){
        $this->db->select('*');
        $this->db->from('tiempo_renta');
        $this->db->where('id_tiempo',$code); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
     }

     public function updateTiempo($code,$nombre,$unidad,$total){
        $data = array(
                'nombre'              => $nombre,  
                'unidad_basica'       => $unidad,
                'total_trabajo'       => $total,
            );
          $this->db->where('id_tiempo', $code);
          $this->db->update('tiempo_renta', $data);
      return true;
     }

     public function deleteTiempo($code){
        $data = array(
            'estado'              => 0,
        );
        $this->db->where('id_tiempo', $code);
        $this->db->update('tiempo_renta', $data);
     }

     public function validarTiempoNombre($nombre){
        $this->db->select('count(*)as conteo');
        $this->db->from('tiempo_renta');
        $this->db->where('nombre',$nombre);
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
     }
	
}