
<?php
class Tasa_model extends CI_Model{

//Mantenimiento de los descuentos
	 function getTasa(){
	 	    $this->db->select('*');
        $this->db->from('tasa'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
	 }

   function primaVacacion($tasa=null){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('tasa'); 
        $this->db->where('estado',1);
        if($tasa != null){
          $this->db->where('nombre',$tasa);

        }else{

          $this->db->where('nombre','Prima de Vacaciones');
        }

        $result = $this->db->get();
        return $result->result();
   }

   function saveTasas($nombre,$tipo,$tasa,$decripcion){
    $data = array(
          'nombre'              => $nombre,
          'tasa'                => $tasa, 
          'fecha'               => date('Y-m-d'), 
          'descripcion'         => $decripcion,
          'tipo_tasa'           => $tipo,
          'estado'              => 1,
    );
        $result=$this->db->insert('tasa',$data);
         return $result;
   }

   function updateTasas($code,$data){
    
    $this->db->where('id_tasa', $code);
    $this->db->update('tasa', $data);
   }

   function llenarTasa($code){
        $this->db->select('id_tasa, nombre, format(tasa*100,2) as tasa, descripcion, tipo_tasa');
        $this->db->from('tasa');
        $this->db->where('id_tasa',$code); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
   }

   function deleteTasas($code){
    $data = array(
          'estado'              => 0
 
    );
    $this->db->where('id_tasa', $code);
    $this->db->update('tasa', $data);
   }
}