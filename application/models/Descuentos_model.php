<?php
class Descuentos_model extends CI_Model{
//todas estas consultas son de tablas de la bdd de tablero
//Mantenimiento de los descuentos
	 function getDescuentos(){
    //se traen los datos de ya preparados para mostrar en la vista
	 	    $this->db->select('id_descuentos, nombre_descuento, format(porcentaje*100,2) as porcentaje, format(techo,2) as techo, techo as techo2,porcentaje as porcentaje2, aplica');
        $this->db->from('descuentos_ley'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
	 }

	 public function saveDescuentos($nombreDes,$porcentaje,$techo,$aplica){

        $data = array(
                'nombre_descuento'    => $nombreDes,  
                'porcentaje'          => $porcentaje,
                'techo'               => $techo,
                'aplica'              => $aplica,
                'estado'              => 1,
            );
        $result=$this->db->insert('descuentos_ley',$data);
         return $result;
        
     	}

     	 public function getDescuento($code){
     	 	$this->db->select('id_descuentos, nombre_descuento,format(porcentaje*100,2) as porcentaje,format(techo,2) as techo,aplica');
        	$this->db->from('descuentos_ley');
        	$this->db->where('id_descuentos',$code); 
        	$this->db->where('estado',1);
     	 	$result = $this->db->get();
        	return $result->result();
     	 }

     	 public function updateDescuentos($code,$nombreDescuento,$porcentaje,$techo,$aplica){
         $data = array(
                'nombre_descuento'    => $nombreDescuento, 
                'porcentaje'          => $porcentaje, 
                'techo'               => $techo,
                'aplica'              => $aplica, 
            );
          $this->db->where('id_descuentos', $code);
          $this->db->update('descuentos_ley', $data);
      return true;
    }

    public function deleteDescuento($code){
        $data = array(
                'estado'    => 0, 
            );
          $this->db->where('id_descuentos', $code);
          $this->db->update('descuentos_ley', $data);
      return true;
    }
  //Fin mantenimientos para los descuentos

    //PROXIMO SUBIR 03012020

      function lista_descuentos($empresa_int,$agencia_int){
      $this->db->select('co.id_empleado, em.nombre, em.apellido, ag.agencia, emp.nombre_empresa, em.dui');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
 
      $this->db->where('(co.estado = 0 or co.estado = 4)');
      if($empresa_int != 'todas'){
        $this->db->where('co.id_empresa', $empresa_int);
      }
      if($agencia_int != 'todas' && $agencia_int != null){
        $this->db->where('co.id_agencia', $agencia_int);
      }
      $this->db->group_by('em.nombre');
      $this->db->group_by('em.apellido');
      $this->db->group_by('ag.agencia');
      $this->db->group_by('emp.nombre_empresa');
      $this->db->group_by('em.dui');
      $this->db->group_by('co.id_empleado');

      $result = $this->db->get();
      return $result->result();
  }

  //FIN PROXIMO SUBIR

}