<?php
class Comisiones_model extends CI_Model{

  function validacion_mes($mes){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
    $this->db->select('count(*) as conteo');
    $this->db->from('comisiones');
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }//Fin validacion_mes

  function empleados($agencia){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
    $this->db->select('co.id_contrato, em.nombre, em.apellido, ag.agencia, ca.cargo, ca.rol');
    $this->db->from('contrato co');
    $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
    $this->db->where('ca.rol != 0');
    $this->db->where('ca.rol != 4');
    $this->db->where('(co.estado = 1 or co.estado = 3)');
    $this->db->where('ag.id_agencia',$agencia);

    $result = $this->db->get();
    return $result->result();
  }//Fin empleados

   function empleadosLogin($agencia){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
    $this->db->select('lo.usuarioP,co.id_contrato, em.nombre, em.apellido, ag.agencia, ca.cargo, ca.rol');
    $this->db->from('contrato co');
    $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
    $this->db->join('login lo', 'lo.id_empleado=em.id_empleado');
    $this->db->where('ca.rol != 0');
    $this->db->where('(co.estado = 1 or co.estado = 3)');
    $this->db->where('ag.agencia',$agencia);

    $result = $this->db->get();
    return $result->result();
  }//Fin empleadosLogin

  function coordinadores($nombre, $apellido){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
    $this->db->select('co.id_contrato, em.nombre, em.apellido, ag.agencia, ca.cargo, ca.rol');
    $this->db->from('contrato co');
    $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
    $this->db->where('ca.rol',2);
    $this->db->where('(co.estado = 1 or co.estado = 3)');
    $this->db->like('em.nombre',$nombre);
    $this->db->like('em.apellido',$apellido);

    $result = $this->db->get();
    return $result->result();
  }//Fin coordinadores

  function insertComision($bono,$contrato,$mes,$fecha){
    //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
     $data = array(
                'cantidad'            => $bono,  
                'id_contrato'         => $contrato,
                'mes'                 => $mes,
                'fecha'               => $fecha,
                'estado'              => 0,
            );
        $result=$this->db->insert('comisiones',$data);
        return $result;
  }//Fin InsertComision

  function getComisiones($agencia,$cargo,$fecha){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
    $this->db->select('cm.id_comisiones,em.id_empleado,cm.id_contrato, em.nombre, em.apellido, ag.agencia, format(cm.cantidad,2) as cantidad, cm.estado, cm.mes, ca.cargo, ag.agencia');
    $this->db->from('contrato co');
    $this->db->join('comisiones cm', 'co.id_contrato=cm.id_contrato');
    $this->db->join('empleados em', 'co.id_empleado = em.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
    $this->db->where('cm.mes',$fecha);

    if($agencia != null){
      $this->db->where('ag.id_agencia',$agencia);
    }
    if($cargo != null){
       $this->db->where('ca.rol',$cargo);
    }
    
    $result = $this->db->get();
    return $result->result();
  }//Fin getComision

  function aprobar($mes){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');
     $data = array(
                'estado'               => 1,
                'fecha_aprobacion'     => date('Y-m-d'),
            );

        $this->db->where('mes', $mes);
        $this->db->update('comisiones', $data);
       return true;
  }//Fin aprobar

  function empledos($agencia){
      //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
      $this->db->select('co.id_contrato, em.nombre, em.apellido');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
      $this->db->where('ca.rol != 0');
      $this->db->where('co.estado = 1');
      $this->db->where('co.id_agencia',$agencia);

      $result = $this->db->get();
      return $result->result();

  }//Fin empleados

  function allEmpledos($agencia){
      //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
      $this->db->select('co.id_contrato, em.nombre, em.apellido');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
      $this->db->where('(co.estado = 1 or co.estado = 3)');
      $this->db->where('co.id_agencia',$agencia);

      $result = $this->db->get();
      return $result->result();
  }

  function cambiarBono($code,$cantidad,$contrato_empleado,$fecha){
      //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
      $data = array(
                'cantidad'            => $cantidad,  
                'id_contrato'         => $contrato_empleado,
                'fecha'               => $fecha,
            );

      $this->db->where('id_comisiones', $code);
      $this->db->update('comisiones', $data);
      return true;
  }//Fin cambiarBono

  function llenarComisiones($code){
      //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
      $this->db->select('cm.id_contrato,em.nombre,em.apellido,format(cm.cantidad,2) as cantidad,ag.id_agencia');
      $this->db->from('contrato co');
      $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
      $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
      $this->db->join('comisiones cm', 'cm.id_contrato=co.id_contrato');
      $this->db->where('cm.id_comisiones',$code);

      $result = $this->db->get();
      return $result->result();
  }

  function deleteBonos($code){
    //$this->db->db_select('prueba_planilla');
    $this->db->db_select('tablero');

    $this->db->where('id_comisiones', $code);
    $this->db->delete('comisiones');
    return true;
  }

  //AQUI SOLO HAY CONSULTAS DE LA BASE DE DATSOS PRODUCTOS
  //Trae a los montos de las carteras y las moras de lq base Produccion
  function ReporteBonos($fechaInicio,$fechaFinal){

    $this->db->db_select('Produccion');
    
  
             $query = $this->db->query('select id_agencia,agencia,(select nombre FROM generales as gene where gene.sucursal=generales.sucursal ORDER BY gene.fecha DESC limit 1) as nombre,generales.sucursal,(select sum(monto_colocado) from colocado where substr(colocado.prospecto,1,5) =generales.sucursal and colocado.fecha>="'.$fechaInicio.'" and colocado.fecha<="'.$fechaFinal.'") AS nuevos,generales.sucursal as car,AVG(generales.cartera) as cartera2,(AVG((mora/generales.cartera)*100)) AS mora FROM `generales` inner join carteras on generales.sucursal = carteras.id_cartera 
                WHERE generales.fecha >= "'.$fechaInicio.'" and generales.fecha <= "'.$fechaFinal.'" and generales.grupo = 01 
                GROUP by agencia,sucursal
                ORDER BY generales.sucursal');

 
       if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return "Todos ingresaron";
        }
    }//fin ReporteBonos

     function n_coord(){//Saca el numero de coordinadores
            $this->db->db_select('Produccion');
            $this->db->where('id_rol', 2);
            $this->db->order_by('id_usuarios, nombre');
            $hasil=$this->db->get('usuarios');
            return $hasil->result();
        }

    function n_agencias($coord,$filto=null){//Saca el numero de coordinadores
            $this->db->db_select('Produccion');

            $this->db->select('usuarios.id_usuarios,usuarios.nombre,usuarios.apellido,usuarios.correo,usuarios.celular,agencias.id_agencia, agencias.agencia,LPAD(permisos.id_cartera,2,0) as id_cartera');
            $this->db->from('permisos');
            $this->db->join('usuarios', 'permisos.id_usuarios = usuarios.id_usuarios');
            $this->db->join('agencias', 'usuarios.id_agencia = agencias.id_agencia');
            $this->db->where('permisos.id_cartera in (select id_cartera from permisos where id_usuarios="'.$coord.'") and permisos.id_usuarios!="'.$coord.'"');
            if ($filto!=null) {
             
              $this->db->like('id_cartera',$filto,'after'); //hace un $id%, pone el simbolo luego de la variable
          }
          $query = $this->db->get();
          return $query->result();
      }

    function carteras($cartera){
          $this->db->db_select('Producc ion');

          $this->db->select('us.id_usuarios');
          $this->db->from('usuarios us');
          $this->db->join('permisos pe', 'pe.id_usuarios = us.id_usuarios');
          $this->db->where('pe.id_cartera',$cartera);
          $this->db->where('us.id_rol = 4');

          $result = $this->db->get();
          return $result->result();
    }

    function empleados_especiales($agencia){
      //$this->db->db_select('prueba_planilla');
      $this->db->db_select('tablero');
      $this->db->select('contrato.id_contrato, concat(empleados.nombre," ",empleados.apellido) as nombre, contrato.estado, asignar_agencias.id_agencia, cargos.rol');
      $this->db->from('contrato');
      $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado ');
      $this->db->join('login', 'login.id_empleado=empleados.id_empleado');
      $this->db->join('asignar_agencias', 'asignar_agencias.codigo=login.codigo ');
      $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');

      $this->db->where('asignar_agencias.estado = 2 and (contrato.estado = 1 or contrato.estado = 3)');
      $this->db->where('asignar_agencias.id_agencia',$agencia);

      $result = $this->db->get();
      return $result->result();
  }

  
}