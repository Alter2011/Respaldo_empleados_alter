<?php
class Anticipos_model extends CI_Model{

    function getContrato($code){
          $this->db->select('*');
          $this->db->from('contrato'); 
          $this->db->where('id_empleado',$code);
          $this->db->where('estado != 0');
          $this->db->where('estado != 4');
          $this->db->where('(estado = 1 or estado = 3)');
          $this->db->order_by('fecha_inicio','DESC');
          $this->db->limit(1); 

          $result = $this->db->get();
          return $result->result();
      }

    function techoAnticipo($tipo_anticipo){
          $this->db->select('*');
          $this->db->from('tipo_anticipo'); 
          $this->db->where('id_tipo_anticipo',$tipo_anticipo);

          $result = $this->db->get();
          return $result->result();
    }

    function saveAnticipo($code,$cantidad_anticipo,$tipo_anticipo,$contrato_autorizacion,$fecha_anticipo){
        $data = array(
              'id_contrato'             => $code,
              'monto_otorgado'          => $cantidad_anticipo,
              'fecha_otorgado'          => date('Y-m-d'),
              'fecha_aplicacion'        => $fecha_anticipo,
              'id_tipo_anticipo'        => $tipo_anticipo,
              'id_cont_autorizado'      => $contrato_autorizacion,
              'estado'                  => 1,
        );
        $result=$this->db->insert('anticipos',$data);
        return $result;
    }

    //CONSULTAS DE VER ANTICIPO
    function getAnticipos($orden,$id_empleado){
      $this->db->select('an.id_anticipos, em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia,ca.cargo, format(an.monto_otorgado,2) as cantidad, an.fecha_otorgado,an.fecha_aplicacion, ta.nombre_tipo, an.estado, an.id_cont_autorizado,an.fecha_aplicacion');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
      $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
      $this->db->join('anticipos an', 'an.id_contrato = co.id_contrato');
      $this->db->join('tipo_anticipo ta', 'ta.id_tipo_anticipo = an.id_tipo_anticipo');
      $this->db->where('em.id_empleado', $id_empleado);
      if($orden == 0 || $orden == 1){
        $this->db->where('an.estado', $orden);
      }
      $this->db->group_by('em.nombre');
      $this->db->group_by('em.apellido');
      $this->db->group_by('em.dui');
      $this->db->group_by('em.tel_personal');
      $this->db->group_by('ag.agencia');
      $this->db->group_by('ca.cargo');
      $this->db->group_by('an.monto_otorgado');
      $this->db->group_by('an.fecha_otorgado');
      $this->db->group_by('ta.nombre_tipo');
      $this->db->group_by('an.estado');
      $this->db->group_by('an.id_anticipos');
      $this->db->group_by('an.id_cont_autorizado');
      $this->db->group_by('an.fecha_aplicacion');

      $query = $this->db->get();
      return $query->result();
    }

    function verAutoAnticipo($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('anticipos an', 'an.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function cancelarAnticipos($code,$planilla){
      $data = array(
            'estado'                  => 0,
            'planilla'                => $planilla,
        );
        $this->db->where('id_anticipos', $code);
        $this->db->update('anticipos', $data);
        return true;
    }


    //MANTENIMIENTO DE TIPO DE ANTICIPOS
    function getTiposAnticipo($code=null){
        $this->db->select('id_tipo_anticipo, nombre_tipo, tipo, format(desde,2) as desde, format(hasta,2) as hasta, descripcion, fecha_creacion');
        $this->db->from('tipo_anticipo'); 
        $this->db->where('estado',1);
        if($code != null){
          $this->db->where('id_tipo_anticipo',$code);
        }

        $result = $this->db->get();
        return $result->result();
    }

    function countTiposAnticipo(){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('tipo_anticipo'); 
        $this->db->where('estado',1);
        $this->db->where('nombre_tipo','Anticipo Corriente');

        $result = $this->db->get();
        return $result->result();
    }

    function saveTiposAnticipo($nombre,$tipo,$descripcion,$desde,$hasta){
        $data = array(
              'nombre_tipo'             => $nombre,
              'tipo'                    => $tipo,
              'desde'                   => $desde,
              'hasta'                   => $hasta,
              'descripcion'             => $descripcion,
              'fecha_creacion'          => date('Y-m-d'),
              'estado'                  => 1,
        );
        $result=$this->db->insert('tipo_anticipo',$data);
        return $result;
    }

    function updateTiposAnticipo($code,$nombre,$tipo,$desde,$hasta,$descripcion){
         $data = array(
              'nombre_tipo'             => $nombre,
              'tipo'                    => $tipo,
              'desde'                   => $desde,
              'hasta'                   => $hasta,
              'descripcion'             => $descripcion,
              'fecha_actualizacion'     => date('Y-m-d'),
        );
        $this->db->where('id_tipo_anticipo', $code);
        $this->db->update('tipo_anticipo', $data);
        return true;
    }

    function deleteTiposAnticipo($code){
        $data = array(
            'estado'                  => 0,
        );
        $this->db->where('id_tipo_anticipo', $code);
        $this->db->update('tipo_anticipo', $data);
        return true;
    }
}