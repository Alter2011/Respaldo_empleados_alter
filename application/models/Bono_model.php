<?php
class Bono_model extends CI_Model{

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

  function saveBonos($cantidad_bono,$fecha,$fecha_bono,$observacion_bono,$contrato,$contrato_autorizacion,$bono_estado){

    $data = array(
                'cantidad'            => $cantidad_bono,  
                'fecha_ingreso'       => $fecha,
                'fecha_aplicacion'    => $fecha_bono,
                'observación'         => $observacion_bono,
                'id_contrato'         => $contrato,
                'id_cont_autorizado'  => $contrato_autorizacion,
                'estado'              => $bono_estado,
            );
        $result=$this->db->insert('bonos',$data);
         return $result;
  }

  function verBonos($id_empleado){
     $this->db->select('bo.id_bono, em.nombre, em.apellido, em.dui, ag.agencia, ca.cargo, pl.nombrePlaza, format(bo.cantidad,2) as cantidad, bo.fecha_ingreso, bo.observación,bo.id_cont_autorizado,bo.fecha_aplicacion,bo.id_contrato,bo.estado');
     $this->db->from('empleados  em');
     $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
     $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
     $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
     $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');
     $this->db->join('plaza pl', 'co.id_plaza=pl.id_plaza');
     $this->db->where('co.id_empleado', $id_empleado);
     $this->db->where('bo.estado', 2);                              //solamente gratificaciones
     $this->db->group_by('em.nombre');
     $this->db->group_by('em.apellido');
     $this->db->group_by('em.dui');
     $this->db->group_by('ag.agencia');
     $this->db->group_by('ca.cargo');
     $this->db->group_by('bo.cantidad');
     $this->db->group_by('bo.fecha_ingreso');
     $this->db->group_by('bo.observación');
     $this->db->group_by('pl.nombrePlaza');
     $this->db->group_by('bo.id_cont_autorizado');
     $this->db->group_by('bo.fecha_aplicacion');
     $this->db->group_by('bo.id_contrato');
     $this->db->group_by('bo.id_bono');

     $query = $this->db->get();
     return $query->result();
  }

  function verAutorBono($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('bonos bo', 'bo.id_cont_autorizado=co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function empleadosBonos($code){
        $this->db->select('co.id_contrato,co.id_empleado, em.nombre, em.apellido, em.dui, ca.cargo');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
        $this->db->where('co.id_agencia', $code);
        $this->db->where('em.activo', 1);
        $this->db->where('(co.estado = 1 or co.estado = 3)');
         

        $query = $this->db->get();
        return $query->result();
    }

      // metodo para obtener el bono 
    function bonosEmpleados($id_empleado,$primerDia,$ultimoDia){
        $this->db->select('format(sum(bo.cantidad),2) as cantidad');
        $this->db->from('contrato co');
        $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');     
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('bo.estado', 1);
        $this->db->where('bo.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     

        $query = $this->db->get();
        return $query->result();
    }
      // metodo para obtener la gratificacion
    function bonosEmpleadosGratificacion($id_empleado,$primerDia,$ultimoDia){
        $this->db->select('format(sum(bo.cantidad),2) as cantidad');
        $this->db->from('contrato co');
        $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');     
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('bo.estado', 2);
        $this->db->where('bo.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     

        $query = $this->db->get();
        return $query->result();
    }

      function bonos_mes_quincena($primerDia,$ultimoDia,$id_contrato){
        $this->db->select('em.nombre, em.apellido, em.dui, ag.agencia, ca.cargo, pl.nombrePlaza, format(bo.cantidad,2) as cantidad, bo.fecha_ingreso, bo.observación,bo.id_cont_autorizado,bo.fecha_aplicacion');
        $this->db->from('empleados  em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
        $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');
        $this->db->join('plaza pl', 'co.id_plaza=pl.id_plaza');
        $this->db->where('bo.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');
        $this->db->order_by('bo.fecha_aplicacion','ASC');
        $this->db->where('co.id_contrato', $id_contrato);
    
        $result = $this->db->get();
        return $result->result();
      }

      function cancelarBonos($code){
        $data = array(
          'estado'              => 0,
          'planilla'            => 2,
 
        );
        $this->db->where('id_bono', $code);
        $this->db->update('bonos', $data);
      }

      function bonosTotal($primerDia,$ultimoDia){
            $this->db->select('ag.agencia, co.id_empleado, em.nombre, em.apellido, em.dui, ca.cargo, format(SUM(bo.cantidad),2) as cantidad');
            $this->db->from('empleados  em');
            $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
            $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
            $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');
            $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
            $this->db->where('bo.estado', 2);
            $this->db->where('bo.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     
            $this->db->group_by('em.nombre');
            $this->db->group_by('em.apellido');
            $this->db->group_by('em.dui');
            $this->db->group_by('ca.cargo');
            $this->db->group_by('co.id_empleado');
            $this->db->group_by('ag.agencia');

            $query = $this->db->get();
            return $query->result();
      }

      function bonosQuincena($primerDia,$ultimoDia,$code){
            $this->db->select('bo.id_bono, bo.id_cont_autorizado, format(bo.cantidad,2) as cantidad');
            $this->db->from('contrato co');
            $this->db->join('bonos bo', 'bo.id_contrato=co.id_contrato');
            $this->db->where('bo.estado', 2);
            $this->db->where('co.id_empleado', $code);
            $this->db->where('bo.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');

            $query = $this->db->get();
            return $query->result();
      }
        public function pagos_recuperacion_fox($agencia,$fecha)
        {
            $this->db->db_select('basefox');

            $query = $this->db->query('SELECT sum(valor*0.10) as bono, count(valor) as numero_pagos,numcaja as id_caja,agencias.id_agencia FROM resumen_movpres_'.$agencia.' rm INNER join agencias on agencias.id_agencia=rm.agencia INNER join resumen_salpres_'.$agencia.' rs on rs.codigopre=rm.codigopre WHERE `fecha` LIKE "'.$fecha.'%" and vencimien <= "2020-12-31" and rm.estado=1 and rm.tipo=2 GROUP by numcaja,agencias.id_agencia');

            $resultado=$query->result();
            $this->db->db_select('tablero');
            return $resultado;
        }
        public function pagos_recuperacion_fox2($agencia,$fecha)
        {
            $this->db->db_select('basefox');

            $query = $this->db->query('SELECT sum(valor*0.10) as bono, count(valor) as numero_pagos,numcaja as id_caja,agencias.agencia FROM resumen_movpres_'.$agencia.' rm INNER join agencias on agencias.id_agencia=rm.agencia INNER join resumen_salpres_'.$agencia.' rs on rs.codigopre=rm.codigopre WHERE `fecha` LIKE "'.$fecha.'%" and vencimien <= "2020-12-31" and rm.estado=1 and rm.tipo=2 GROUP by numcaja,rm.agencia');

            $resultado=$query->result();
            $this->db->db_select('tablero');
            return $resultado;
        }
        function agencias_listar($admin=null){
            $this ->db->select('id_agencia, agencia');
            $this->db->from('agencias');
            if($admin==0){
                $this->db->where('id_agencia != "00" and id_agencia != "02" and id_agencia != "24"' );
            }

            $query = $this->db->get();
            return $query->result();
        }
        public function get_caja($id_caja){
          $this->db->db_select('Operaciones');
          $this->db->select('*');
          $this->db->from('cajas');
          $this->db->where("id_caja", $id_caja);
           
          $result = $this->db->get();
          $this->db->db_select('tablero');

            return $result->result();
            
        }

       /*  public function get_empleado($id_empleado){
          $this->db->db_select('Operaciones');
          $this->db->select('concat(empleados.nombre, empleados.apellido) as nombre_empleado');
          $this->db->from('empleados');
          $this->db->where("id_empleado", $id_empleado);
           
          $result = $this->db->get();
          $this->db->db_select('tablero');

            return $result->result();
            
        }*/

        public function get_empleado($id_empleado){
          $this->db->select('concat(nombre, " ", apellido) as nombre_empleado');
          $this->db->from('empleados');
          $this->db->where("id_empleado", $id_empleado);
           
          $result = $this->db->get();

            return $result->result();
            
        }

        //PROXIMO SUBIR

         public function pagos_recupera_fox($agencia,$fecha)
        {
            $this->db->db_select('basefox');

            $query = $this->db->query('SELECT valor as pago,numcaja as id_caja,agencias.id_agencia, comprobant, concat(rma.nombre, " ", rma.apellido) as nombre_cliente FROM resumen_movpres_'.$agencia.' rm INNER join agencias on agencias.id_agencia=rm.agencia INNER join resumen_salpres_'.$agencia.' rs on rs.codigopre=rm.codigopre INNER join resumen_maeasoc_'.$agencia.' rma on SUBSTR(rs.codigopre, 1,7) = rma.codigo WHERE `fecha` LIKE "'.$fecha.'%" and rs.vencimien <= "2020-12-31" and rm.estado=1 and rm.tipo=2');

            $resultado=$query->result();
            $this->db->db_select('tablero');
            return $resultado;
        }

  public function recuperacion_fox($agencia,$fecha){
    $this->db->db_select('basefox');

    $query = $this->db->query('SELECT valor*0.10 as bono, numcaja as id_caja,agencias.id_agencia FROM resumen_movpres_'.$agencia.' rm INNER join agencias on agencias.id_agencia=rm.agencia INNER join resumen_salpres_'.$agencia.' rs on rs.codigopre=rm.codigopre WHERE `fecha` LIKE "'.$fecha.'%" and vencimien <= "2020-12-31" and rm.estado=1 and rm.tipo=2 GROUP by numcaja,agencias.id_agencia');

    $resultado=$query->result();
    $this->db->db_select('tablero');
    return $resultado;
  }      
      
}