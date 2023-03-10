<?php
class Faltantes_model extends CI_Model{

   function getContratoFaltante($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('estado != 0');
        $this->db->order_by('id_contrato','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
    }

    function insertFaltante($code,$tipo_faltante,$cantidad_faltante,$fecha_actual,$fecha_faltante,$contrato_auto,$descripcion){
        $data = array(
            'id_contrato'            => $code,
            'tipo'                   => $tipo_faltante,
            'monto'                  => $cantidad_faltante,
            'quincenas'              => 1,
            'couta'                  => $cantidad_faltante,
            'fecha_ingresado'        => $fecha_actual,
            'fecha_aplicada'         => $fecha_faltante,
            'id_cont_autorizado'     => $contrato_auto,
            'descripcion'            => $descripcion,
            'estado'                 => 1,
        );

        $result=$this->db->insert('faltante',$data);
        return $result;
    }

    function listarFaltantes($orden = null,$activo = null,$codigo){
        $this->db->select('em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia, ca.cargo, fa.id_faltante, fa.tipo, format(fa.monto,2) as cantidad, fa.fecha_ingresado, fa.fecha_aplicada, fa.id_cont_autorizado, fa.descripcion, fa.estado');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
         $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
         $this->db->join('faltante fa', 'fa.id_contrato=co.id_contrato');    
         $this->db->where('co.id_empleado', $codigo);

         if($orden != null && $activo != null){
            $this->db->where('fa.tipo', $orden);
            $this->db->where('fa.estado', $activo);
         }else{
            if($orden != null){
                $this->db->where('fa.tipo', $orden);
                
            }else if($activo != null){
                $this->db->where('fa.estado', $activo);
             }
         }


        $query = $this->db->get();
        return $query->result();
    }

    function autorizacion($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('faltante fa', 'fa.id_cont_autorizado=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function cancelarFaltantes($code){
        $data = array(
          'estado'              => 0,
          'planilla'            => 2,
 
    );
    $this->db->where('id_faltante', $code);
    $this->db->update('faltante', $data);
    }

}