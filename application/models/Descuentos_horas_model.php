<?php 

class Descuentos_horas_model extends CI_Model{

    public function crear_descuentos_horas($data){
       $this->db->db_select('tablero');
        //$this->db->db_select('prueba');
        $result=$this->db->insert('descuentos_horas',$data);
        return $result;
    }

    public function get_descuentos_horas($id_empleado,$desde,$hasta){
       $this->db->db_select('tablero');
        //$this->db->db_select('prueba');
        $this->db->select('*');
        $this->db->from('descuentos_horas');
        $this->db->join('contrato', 'contrato.id_contrato = descuentos_horas.id_contrato');
        $this->db->where('descuentos_horas.fecha BETWEEN"'.$desde.'" and "'.$hasta.'"');   
        $this->db->where("contrato.id_empleado",$id_empleado);//$this->db->where("contrato.id_empleado",$id_empleado);
        $this->db->where('(descuentos_horas.cancelado=0 or descuentos_horas.cancelado=1)');

        
        $result = $this->db->get();
        return $result->result();
    }

    public function septimo_existente($id_empleado,$desde,$hasta){
       $this->db->db_select('tablero');
        //$this->db->db_select('prueba');
        $this->db->select('*');
        $this->db->from('descuentos_horas');
        $this->db->join('contrato', 'contrato.id_contrato = descuentos_horas.id_contrato');
        $this->db->where('descuentos_horas.fecha BETWEEN"'.$desde.'" and "'.$hasta.'"');
        $this->db->where('descuentos_horas.estado2=4');   
        $this->db->where("contrato.id_empleado",$id_empleado);
        $this->db->where('(descuentos_horas.cancelado=0 or descuentos_horas.cancelado=1)');
        //$this->db->where("contrato.id_empleado",$id_empleado);
        
        $result = $this->db->get();
        return $result->result();
    }

   public function descuentos_horas_datos($id_empleado,$dia=null,$fechaInicio=null,$fechaFin=null){
   $this->db->db_select('tablero');
    //$this->db->db_select('prueba');
     $this->db->select('descuentos_horas.id_descuento_horas,empleados.nombre,empleados.apellido,empleados.dui,agencias.agencia,cargos.cargo,plaza.nombrePlaza,categoria_cargo.Sbase,descuentos_horas.cantidad_horas,,descuentos_horas.cantidad_min,descuentos_horas.a_descontar,descuentos_horas.fecha,descuentos_horas.mes,descuentos_horas.estado,descuentos_horas.id_descuento_horas,descuentos_horas.estado2,descuentos_horas.cancelado,descuentos_horas.descripcion,descuentos_horas.id_emp_ingreso');
     $this->db->from('empleados');
     $this->db->join('contrato', 'empleados.id_empleado = contrato.id_empleado');
     $this->db->join('agencias', 'agencias.id_agencia = contrato.id_agencia');
     $this->db->join('cargos', 'cargos.id_cargo = contrato.id_cargo');
     $this->db->join('plaza', 'contrato.id_plaza=plaza.id_plaza');
     $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
     $this->db->join('descuentos_horas ', 'descuentos_horas.id_contrato = contrato.id_contrato');
     $this->db->where('contrato.id_empleado', $id_empleado);
     $this->db->where('(descuentos_horas.cancelado=0 or descuentos_horas.cancelado=1)');
     if ($fechaInicio!=null) {
        $this->db->where('descuentos_horas.fecha BETWEEN"'.$fechaInicio.'" and "'.$fechaFin.'"');  
     }
     if ($dia==null) {
        $this->db->where('descuentos_horas.estado2!=3');//para q o se muestre dias laborados
     }else{
        $this->db->where('descuentos_horas.estado2=3');//para q traiga solo diasTrabajados
        $this->db->order_by('descuentos_horas.fecha','ASC');
     }
 
     $query = $this->db->get();
     return $query->result();
  }

    public function llamar_asuetos($id_agencia){
        $this->db->db_select('Operaciones');
        $this->db->select('*');
        $this->db->from('asuetos');
        $this->db->where("estado = 1");
        $this->db->where("id_agencia",$id_agencia);
             
        $result = $this->db->get();
        return $result->result();
        $this->db->db_select('tablero');
    }

    function delete_descuento($code){
        $data = array( 
            'cancelado' => 2,
        );
        $this->db->where('id_descuento_horas', $code);
        $this->db->update('descuentos_horas', $data);
        return true;
    }

    function llamar_descHora($code){
      $this->db->db_select('tablero');
       //$this->db->db_select('prueba');
        $this->db->select('descuentos_horas.id_permiso,contrato.id_empleado');
        $this->db->from('descuentos_horas');
        $this->db->join('contrato', 'contrato.id_contrato = descuentos_horas.id_contrato');
        $this->db->where('descuentos_horas.id_descuento_horas', $code);
        $query = $this->db->get();
        return $query->result();
    }

        /*funciones para eliminar el descuento de horas cuando sea sin goce de sueldo*/
    function datosHoraDes($code){
       $this->db->db_select('tablero');
        //$this->db->db_select('prueba');
        $this->db->select('*');
        $this->db->from('descuentos_horas');
        $this->db->where('(descuentos_horas.cancelado=0 or descuentos_horas.cancelado=1)');
        $this->db->where('descuentos_horas.id_permiso', $code);
        $query = $this->db->get();
        return $query->result();
    }

    function registroDias($id_empleado,$desde,$hasta){
       $this->db->db_select('tablero');
        //$this->db->db_select('prueba');
        $this->db->select('*');
        $this->db->from('descuentos_horas');
        $this->db->join('contrato', 'contrato.id_contrato = descuentos_horas.id_contrato');
        $this->db->where('descuentos_horas.fecha BETWEEN"'.$desde.'" and "'.$hasta.'"');
        $this->db->where('descuentos_horas.estado2=3');   
        $this->db->where("contrato.id_empleado",$id_empleado);
        $this->db->where('(descuentos_horas.cancelado=0 or descuentos_horas.cancelado=1)');
        //$this->db->where("contrato.id_empleado",$id_empleado);
        
        $result = $this->db->get();
        return $result->result();
    }   

}

 ?>