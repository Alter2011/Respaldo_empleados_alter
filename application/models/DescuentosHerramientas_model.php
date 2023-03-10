
<?php
class DescuentosHerramientas_model extends CI_Model{

    function saveDescuentos($code,$tipo_descuento,$autorizacion,$cantidad_descuento,$couta,$quincenas,$pedido,$descripcion){
        $data = array(
            'id_contrato'         => $code,
            'id_tipo_descuento'   => $tipo_descuento,
            'id_cont_autorizado'  => $autorizacion,
            'cantidad'            => $cantidad_descuento,
            'saldo'               => $cantidad_descuento,
            'couta'               => $couta,
            'quincenas'           => $quincenas,
            'quincenas_res'       => 0,
            'pedido'              => $pedido,
            'descripcion'         => $descripcion,
            'fecha_ingreso'       => date('Y-m-d'), 
            'estado'              => 1,
        );
        $result=$this->db->insert('descuento_herramienta',$data);
         return $result;
    }

    function getContratoDescuento($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('estado != 0');
        $this->db->order_by('id_contrato','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
  }

    function listarDescuentos($orden,$id_empleado){
         $this->db->select('dh.id_descuento_herramienta, em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia, ca.cargo, format(dh.cantidad,2) as cantidad, format(dh.couta,2) as couta, dh.quincenas, dh.pedido, dh.descripcion, dh.fecha_ingreso,dh.id_cont_autorizado, td.nombre_tipo, dh.estado');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
         $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
         $this->db->join('descuento_herramienta dh', 'dh.id_contrato=co.id_contrato');         
         $this->db->join('tipo_descuento td', 'td.id_tipo_descuento=dh.id_tipo_descuento');         
         $this->db->where('co.id_empleado', $id_empleado);

         if($orden == 0 || $orden == 1){
            $this->db->where('dh.estado', $orden);
         }
         
        $query = $this->db->get();
        return $query->result();
    }

    function verAutorizacionDes($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('descuento_herramienta dh', 'dh.id_cont_autorizado=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function cancelarDescuentos($code){
         $data = array( 
              'estado'         => 0,
              'planilla'      => 2,
        );
        $this->db->where('id_descuento_herramienta', $code);
        $this->db->update('descuento_herramienta', $data);
    }

    function get_descuento($code){
        $this->db->select('saldo_actual');
        $this->db->from('pagos_descuento_herramienta'); 
        $this->db->where('id_descuento_herramienta',$code); 
        $this->db->where('(estado = 1 or estado = 2)'); 
        $this->db->order_by('saldo_actual','ASC'); 
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
    }

    function get_datos_descuento($code){
        $this->db->select('cantidad as saldo_actual');
        $this->db->from('descuento_herramienta'); 
        $this->db->where('id_descuento_herramienta',$code); 

        $result = $this->db->get();
        return $result->result();
    }

    function insert_abono($data){
        $result=$this->db->insert('pagos_descuento_herramienta',$data);
        return $result;
    }

    function cancelar_des($data,$code_abono){
        $this->db->where('id_descuento_herramienta', $code_abono);
        $this->db->update('descuento_herramienta',$data);
        return true;
    }

//MANTENIMIENTO PARA TIPOS DE DESCUENTOS
   function getTipoDescuento(){
        $this->db->select('*');
        $this->db->from('tipo_descuento'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
   }

   function savTipoDes($nombre,$descripcion){
      $data = array(
          'nombre_tipo'         => $nombre,
          'fecha_creacion'      => date('Y-m-d'), 
          'descripcion'         => $descripcion,
          'estado'              => 1,
    );
        $result=$this->db->insert('tipo_descuento',$data);
         return $result;
   }

   function updateTipoDes($code,$nombre,$descripcion){
      $data = array(
            'nombre_tipo'         => $nombre,
            'fecha_modificacion'  => date('Y-m-d'), 
            'descripcion'         => $descripcion,
      );
      $this->db->where('id_tipo_descuento', $code);
      $this->db->update('tipo_descuento', $data);
   }

   function deleteTipoDes($code){
        $data = array( 
            'estado'         => 0,
      );
      $this->db->where('id_descuento_herramienta', $code);
      $this->db->update('tipo_descuento', $data);
   }

   function estadoDescuento($id){
        $this->db->select('dh.id_descuento_herramienta, em.nombre, em.apellido, ag.agencia, format(dh.couta,2) as couta, dh.cantidad, dh.fecha_ingreso, dh.quincenas');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
        $this->db->join('descuento_herramienta dh', 'dh.id_contrato=co.id_contrato');
        $this->db->where('dh.id_descuento_herramienta',$id);

        $query = $this->db->get();
        return $query->result();
   }

   function pagosDescuento($id){
        $this->db->select('*');
        $this->db->from('pagos_descuento_herramienta'); 
        $this->db->where('id_descuento_herramienta ',$id); 
        $this->db->order_by('fecha_ingreso','ASC'); 

        $result = $this->db->get();
        return $result->result();
    }

    //PROXIMO SUBIR FEBRERO 2022

     function empleados($agencia=null){
    $this->db->select('co.id_empleado, em.nombre, em.apellido, ag.agencia');
    $this->db->from('contrato co');
    $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    //$this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');

    if($agencia != null){
      $this->db->where('ag.id_agencia',$agencia);
    }
    $this->db->group_by('co.id_empleado, em.nombre, em.apellido, ag.agencia');
    $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 0 or co.estado = 4)');
       
    $query = $this->db->get();
    return $query->result();
  }

    function get_descuentos($agencia=null,$fecha_ini, $fecha_fin, $empresa=null){
    $this->db->select('pagos_descuento_herramienta.pago, pagos_descuento_herramienta.id_descuento_herramienta, ti.nombre_tipo, concat(em.nombre," ",em.apellido) as nombre, ag.agencia');
    $this->db->from('pagos_descuento_herramienta');
    $this->db->join('descuento_herramienta de', 'de.id_descuento_herramienta=pagos_descuento_herramienta.id_descuento_herramienta');
    $this->db->join('tipo_descuento ti', 'ti.id_tipo_descuento=de.id_tipo_descuento');
    $this->db->join('contrato co', 'co.id_contrato=de.id_contrato');
    $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
    $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');

    //$this->db->where('co.id_empleado',$id_empleado);
    $this->db->where('pagos_descuento_herramienta.fecha_ingreso BETWEEN"'.$fecha_ini.'" and "'.$fecha_fin.'"');
    $this->db->where('pagos_descuento_herramienta.estado',1);
    $this->db->where('pagos_descuento_herramienta.planilla',1);

    if($agencia != null && $agencia != 'todas'){
    $this->db->where('co.id_agencia', $agencia);
    }

    if($empresa != null && $empresa != 'todo'){
    $this->db->where('co.id_empresa', $empresa);

    }

    
    $query = $this->db->get();
    return $query->result();
  }

  function fecha_ult(){
    $this->db->select('fecha_ingreso');
    $this->db->from('pagos_descuento_herramienta');

    $this->db->order_by('fecha_ingreso','DESC'); 
    $this->db->where('(estado = 1 or planilla = 1)');
    $this->db->limit(1); 

       
    $query = $this->db->get();
    return $query->result();
  }






    //FIN PROXIMO SUBIR
}