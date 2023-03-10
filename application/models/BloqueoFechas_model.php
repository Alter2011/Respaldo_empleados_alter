<?php
class BloqueoFechas_model extends CI_Model{

//Mantenimiento de los descuentos
   function getBloqueos(){
        $this->db->select('bl.id_bloqueo, pe.nombre, bl.dia_inicio, bl.dia_fin, bl.continuo');
        $this->db->from('permisos pe');
        $this->db->join('bloquedo_fechas bl', 'bl.id_permiso=pe.id_permiso'); 
        $this->db->where('bl.estado',1);

        $result = $this->db->get();
        return $result->result();
   }

   function getAllPermisos(){
      $this->db->select('permisos.id_permiso, permisos.nombre');
      $this->db->from('permisos');
      $query = $this->db->get();

      if ($query->num_rows() >= 1) {
        return $query->result();
      } else {
        return false;
     }
   }

   function InsertBloque($fecha_inicio,$fecha_fin,$forma,$permisos){
      $data = array(
          'dia_inicio'          => $fecha_inicio,
          'dia_fin'             => $fecha_fin, 
          'continuo'            => $forma, 
          'id_permiso'          => $permisos, 
          ' estado'             => 1, 
      );
        $result=$this->db->insert('bloquedo_fechas',$data);
         return $result;
   }

}