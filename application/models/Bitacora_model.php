<?php
class Bitacora_model extends CI_Model{
    public function controlSistema($id_contrato,$fecha,$hora,$accion,$estado){
      $data = array(
                'id_contrato'       => $id_contrato,  
                'fecha_ingreso'     => $fecha,  
                'hora'              => $hora,  
                'accion'            => $accion,  
                'estado'            => $estado,  
            );
      $result=$this->db->insert('control_sistema',$data);
      return $result;
    }

    public function controlContrato($id_empleado){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$id_empleado);
        $this->db->where('estado != 0');
        $this->db->where('estado != 4');
        $this->db->where('(estado = 1 or estado = 3)');
        $this->db->order_by('fecha_inicio','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
    }

    public function nombreDes($code){
        $this->db->select('*');
        $this->db->from('descuentos_ley');
        $this->db->where('id_descuentos',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarTrammo($code){
        $this->db->select('*');
        $this->db->from('renta');
        $this->db->where('id_renta',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarTiempo($code){
        $this->db->select('*');
        $this->db->from('tiempo_renta');
        $this->db->where('id_tiempo',$code); 

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarTasa($code){
        $this->db->select('*');
        $this->db->from('tasa');
        $this->db->where('id_tasa',$code); 

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarTipoInt($code){
        $this->db->select('*');
        $this->db->from('tipo_prestamo');
        $this->db->where('id_tipo_prestamo',$code); 

        $result = $this->db->get();
        return $result->result();
    }

    public function nombreEmp($empleado){
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where('id_empleado',$empleado); 

        $result = $this->db->get();
        return $result->result();
    }

    public function prestamosInterno($code){
        $this->db->select('em.nombre, em.apellido, ta.tasa, format(pr.monto_otorgado,2) as monto, format(pr.cuota,2) as cuota, pr.plazo_quincena, pr.id_tipo_prestamo');
        $this->db->from('prestamos_internos pr');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('tipo_prestamo tp', 'tp.id_tipo_prestamo=pr.id_tipo_prestamo');
        $this->db->join('tasa ta', 'ta.id_tasa=tp.id_tasa');
        $this->db->where('pr.id_prestamo', $code);

        $query = $this->db->get();
        return $query->result();
    }

    public function buscarTasas($code){
        $this->db->select('ta.tasa');
        $this->db->from('tasa ta');
        $this->db->join('tipo_prestamo tp', 'ta.id_tasa=tp.id_tasa'); 
        $this->db->where('tp.id_tipo_prestamo',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function nombreEmpl($empleado){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado'); 
        $this->db->where('co.id_contrato',$empleado);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarFaltante($code){
        $this->db->select('em.nombre, em.apellido, fa.tipo, format(fa.monto,2) as monto, fa.fecha_aplicada');
        $this->db->from('faltante fa');
        $this->db->join('contrato co', 'co.id_contrato=fa.id_contrato'); 
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado'); 
        $this->db->where('fa.id_faltante',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarNomEmp($empleado){
        $this->db->select('nombre, apellido');
        $this->db->from('empleados');
        $this->db->where('id_empleado',$empleado);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarPermiso($code){
        $this->db->select('*');
        $this->db->from('permisos_empleados');
        $this->db->where('id_permiso',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarDescuento($code){
        $this->db->select('*');
        $this->db->from('descuentos_horas');
        $this->db->where('id_descuento_horas',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarTipoAnt($code){
        $this->db->select('*');
        $this->db->from('tipo_anticipo'); 
        $this->db->where('id_tipo_anticipo',$code);

        $result = $this->db->get();
        return $result->result();
    }

    public function buscarAnticipo($code){
        $this->db->select('*');
        $this->db->from('anticipos'); 
        $this->db->where('id_anticipos',$code);

        $result = $this->db->get();
        return $result->result();
    }

}