
<?php
class Vacacion_model extends CI_Model{
  //NO12082023 funcion para verificar si tiene vacacion
  public function verificar_vacacion($id_contrato, $anio, $diaUno,$diaUltimo){
    $this->db->select("*");
    $this->db->from("vacaciones");
    $this->db->where("id_contrato", $id_contrato);
    $this->db->where('estado', 1);
    $this->db->where('vacaciones.fecha_aplicacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
    $result = $this->db->get();
    return $result->result();

  }
//NO18052023 function para traer todos los empleados
public function get_all_empleado_by_agencia($id_agencia = null, $id_empresa = null){
  $this->db->select('contrato.*, empleados.*, agencias.agencia');
  $this->db->from('contrato');
  $this->db->join('empleados', 'contrato.id_empleado = empleados.id_empleado');
  $this->db->join('agencias', 'contrato.id_agencia = agencias.id_agencia');
  if($id_agencia != null){
  $this->db->where('contrato.id_agencia', $id_agencia);
  }
  if($id_empresa != null){
  $this->db->where('contrato.id_empresa', $id_empresa);
  }
  $this->db->where('contrato.estado = 1 or contrato.estado = 3');

  $result = $this->db->get();
  return $result->result();
}


//Mantenimiento para el pago de vacaciones()
   function getFechasContrato(){
      $this->db->select('id_contrato,fecha_inicio');
      $this->db->from('contrato'); 
      $this->db->where('estado',1);

      $result = $this->db->get();
      return $result->result();
   }

   //Se traen todos los empleados activos
   function getAllEmpleados(){
       $result = $this->db->query('SELECT co.* FROM empleados em INNER JOIN contrato co on co.id_empleado=em.id_empleado INNER JOIN agencias ag on ag.id_agencia=co.id_agencia INNER JOIN categoria_cargo cc on cc.id_categoria=co.id_categoria where em.activo = 1 and (co.estado = 1 or co.estado = 3 or co.estado = 9) and ((em.afp IS NOT NULL and em.afp != "") OR (em.ipsfa IS NOT NULL and em.ipsfa != "")) and (em.isss != "" and em.isss IS NOT NULL)');

    return $result->result();
   }

  //Se verifica cuantos contratos tienen cada uno
   function getCountContratos($empleados){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado', $empleados);

      $result = $this->db->get();
      return $result->result();
   }

  //Se traen todos los contratos de ruptura laboral
   function contratosVencidos($empleados){
      $this->db->select('*');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado', $empleados);
      $this->db->where('(estado = 0 or estado = 4)');
      $this->db->order_by('id_contrato ', "DESC");

      $result = $this->db->get();
      return $result->result();
   }

   //Se trae el contrato siguiente de la ruptura laboral
   function contratoSiguiente($empleados,$contrato){
      $this->db->select('*');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado', $empleados);
      $this->db->where('id_contrato >', $contrato);
      $this->db->limit(1);

      $result = $this->db->get();
      return $result->result();
   }

   //Si no tiene ruptura laboral se trae el ultimo registros
   //Este metodo tambien sirve para traer el contrato actual
   function ultimoContrato($empleados){
      $this->db->select('*');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado', $empleados);
      $this->db->order_by('id_contrato ', "asc");
      $this->db->limit(1);

      $result = $this->db->get();
      return $result->result();
   }

    function actual($empleados){
      $this->db->select('*');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado', $empleados);
      $this->db->order_by('id_contrato ', "DESC");
      $this->db->limit(1);

      $result = $this->db->get();
      return $result->result();
   }


   //Se trae el sueldo de las acategoria de los cargos
   function sueldoBase($categoria){
      $this->db->select('*');
      $this->db->from('categoria_cargo'); 
      $this->db->where('id_categoria', $categoria);

      $result = $this->db->get();
      return $result->result();
   }

   function primaVacaciones(){
      $this->db->select('*');
      $this->db->from('tasa'); 
      $this->db->where('estado', 1);
      $this->db->where('tipo_tasa', 4);

      $result = $this->db->get();
      return $result->result();
   }


   function registroComision($empleado){
        $this->db->select('comisiones.cantidad, contrato.id_contrato');
        $this->db->from('contrato');
        $this->db->join('comisiones', 'comisiones.id_contrato = contrato.id_contrato');
        $this->db->where('contrato.id_empleado', $empleado); 
        $this->db->where('comisiones.fecha >= date_sub(curdate(), interval 6 month)'); 
        $this->db->order_by('comisiones.id_comisiones ', "DESC");

        $result = $this->db->get();
        return $result->result();
   }

   function descuentoEmpleado($contrato){
          $this->db->select('empleados.nombre, empleados.afp, empleados.ipsfa, empleados.isss');
          $this->db->from('empleados');
          $this->db->join('contrato', 'empleados.id_empleado=contrato.id_empleado');
          $this->db->where('contrato.id_contrato', $contrato); 

          $result = $this->db->get();
          return $result->result();
   }

   function descuentos(){
        $this->db->select('*');
        $this->db->from('descuentos_ley'); 
        $this->db->where('estado', 1);
        $this->db->where('aplica', 'Empleado');

        $result = $this->db->get();
        return $result->result();
   }

   function renta(){
        $this->db->select('renta.desde, renta.hasta, renta.porcentaje,renta.cuota, renta.sobre');
        $this->db->from('renta');
        $this->db->join('tiempo_renta', 'tiempo_renta.id_tiempo=renta.id_tiempo');
        $this->db->where('renta.estado', 1); 
        $this->db->where('tiempo_renta.nombre', 'Quincena'); 

        $result = $this->db->get();
        return $result->result();
   }

   function saveVacaciones($contratoActual,$fecha_actual,$fechaAplicacion,$fechaApli){
        $data = array(
                'id_contrato'         => $contratoActual,  
                'fecha_ingreso'       => $fecha_actual,  
                'fecha_aplicacion'    => $fechaAplicacion,  
                'fecha_cumple'        => $fechaApli,  
                'aprobado'            => 0,  
                'estado'              => 1,
            );
        $result=$this->db->insert('vacaciones',$data);
         return $result;
   }


   function validarIngresos($empleado){
        
        $this->db->select('va.id_contrato,va.cantidad_apagar,va.fecha_ingreso');
        $this->db->from('vacaciones va');
        $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->where('co.id_empleado', $empleado); 
        $this->db->where('(va.estado = 1 or va.estado = 2)'); 
        $this->db->order_by('va.id_vacacion ', "DESC");

        $result = $this->db->get();
        return $result->result();

   }

  function countVacaciones($agencia,$user){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('vacaciones va');
        $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
        $this->db->where('va.estado', 1); 
        $this->db->where('va.aprobado', 0); 
        /*if($user != 'admin' && $user != 'Recursos humanos'){
          $this->db->where('co.id_agencia', $agencia); 
        } */

        $result = $this->db->get();
        return $result->result();
  }

  function getAprobacionVaca($agencia=null,$diaUno=null,$diaUltimo=null){
    //se buscan la vacaciones que se ingresaron pero que no han sido aprobadas
        $this->db->select('co.id_empleado, va.id_vacacion, em.nombre, em.apellido, format(va.cantidad_apagar,2) as cantidad, ag.agencia, ca.cargo, pl.nombrePlaza, va.fecha_aplicacion, va.fecha_cumple');
        $this->db->from('contrato co');
        $this->db->join('vacaciones va', 'co.id_contrato=va.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('plaza pl ', 'pl.id_plaza=co.id_plaza');
        $this->db->where('va.aprobado', 0);
        $this->db->where('va.estado', 1);

        if($agencia != null){
          $this->db->where('ag.id_agencia', $agencia);
        }
        
        if($diaUno != null && $diaUltimo != null){
          $this->db->where('va.fecha_aplicacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
        }

        $query = $this->db->get();
        return $query->result();
  }

  function aprobarVacaciones($code){
    //se aprueban las vacaciones
        $data = array(
            'fecha_aprobado' => date('Y-m-d'),
            'aprobado'       => 1,
        );
          $this->db->where('id_vacacion', $code);
          $this->db->update('vacaciones',$data);
          return true;
  }

  function deleteVacacion($code){
    //se eliminan las vacaciones
    //no se borra el registro solo se modifica el estado
        $data = array(
            'fecha_eliminado' => date('Y-m-d'),
            'estado'          => 0,
        );
          $this->db->where('id_vacacion', $code);
          $this->db->update('vacaciones',$data);
          return true;
  }

  function listarVacacion($orden,$id_empleado){
          $this->db->select('em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia, ca.cargo, pl.nombrePlaza, va.fecha_aprobado, va.fecha_eliminado, va.aprobado, va.estado, va.id_vacacion, va.fecha_aplicacion');
          $this->db->from('empleados em');
          $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
          $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
          $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
          $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');
          $this->db->join('vacaciones va', 'va.id_contrato=co.id_contrato');
          $this->db->where('co.id_empleado', $id_empleado);

          if($orden == 0){
            $this->db->where('va.aprobado', 0);
            $this->db->where('va.estado', 0);
          }
          if($orden == 1){
            $this->db->where('((va.aprobado = 1 and va.estado = 1) or (va.aprobado = 1 and va.estado = 2))');
          }
          
          $query = $this->db->get();
          return $query->result();
  }

  function getContrato($code){
        $this->db->select('co.*');
        $this->db->from('contrato co');
        $this->db->join('vacaciones va', 'va.id_contrato=co.id_contrato');
        $this->db->where('va.id_vacacion', $code); 

        $result = $this->db->get();
        return $result->result();
  }

  function getVacacion($code){
        $this->db->select('*');
        $this->db->from('vacaciones');
        $this->db->where('id_vacacion', $code); 

        $result = $this->db->get();
        return $result->result();
  }

  function updateVacacion($code,$data){
        $this->db->where('id_vacacion', $code);
        $this->db->update('vacaciones',$data);
        return true;
  }

  function validarEntradas($code){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('vacaciones'); 
        $this->db->where('ingresado', 0);
        $this->db->where('estado', 1);
        $this->db->where('id_vacacion', $code);

        $result = $this->db->get();
        return $result->result();
  }

  function empresas(){
        $this->db->select('*');
        $this->db->from('empresa'); 
        $this->db->where('estado', 1);

        $result = $this->db->get();
        return $result->result();
  }

  function reporteVacacion($empresa,$agencias,$primerDia,$ultimoDia){
    //reporte de vacaciones que usa contabilidad
      $this->db->select('em.nombre, em.apellido, em.dui, ca.cargo, ag.agencia, va.cantidad_apagar, va.afp_ipsfa, va.isss, va.isr');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('vacaciones va', 'va.id_contrato=co.id_contrato');
      $this->db->where('va.aprobado', 1);
      if($empresa != 'todo'){
        $this->db->where('co.id_empresa', $empresa);

      }
      if($agencias != 'todas'){
        $this->db->where('co.id_agencia', $agencias);

      }
      if($primerDia != null && $ultimoDia != null){
        $this->db->where('va.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
      }
          
      $query = $this->db->get();
      return $query->result();
  }

  function llamar_vacacion($code){
    //datos de la vacacion que se quiere verificar
     $this->db->select('emp.id_empleado,emp.nombre,emp.apellido,emp.dui,emp.nit,age.agencia,co.fecha_inicio,vac.id_vacacion,vac.id_contrato,vac.cantidad_apagar,vac.afp_ipsfa,vac.isss,vac.isr,vac.prima ,vac.comision,vac.prestamo_interno,vac.bono,vac.anticipos,vac.prestamos_personal,vac.orden_descuento,vac.fecha_ingreso,vac.fecha_aprobado,vac.fecha_eliminado,vac.fecha_aplicacion,vac.fecha_cumple,empre.nombre_empresa,empre.id_empresa,age.direccion,age.tel,emp.afp,emp.ipsfa');
    $this->db->from('vacaciones vac');
    $this->db->join('contrato co', 'co.id_contrato=vac.id_contrato');
     $this->db->join('empresa empre', 'empre.id_empresa=co.id_empresa');
    $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
    $this->db->join('agencias age', ' age.id_agencia=co.id_agencia');
    $this->db->where('vac.id_vacacion', $code);
    $result = $this->db->get();
    return $result->result();
  /*
  SELECT empleados.nombre,empleados.apellido,empleados.dui,empleados.nit,agencias.agencia,vacaciones.id_vacacion,vacaciones.id_contrato,
vacaciones.cantidad_apagar,vacaciones.afp_ipsfa,vacaciones.isss,vacaciones.isr,vacaciones.prima 
,vacaciones.comision,vacaciones.prestamo_interno,vacaciones.bono,vacaciones.anticipos,vacaciones.prestamos_personal,
vacaciones.orden_descuento,vacaciones.fecha_ingreso,vacaciones.fecha_aprobado,vacaciones.fecha_eliminado,vacaciones.fecha_aplicacion,vacaciones.fecha_cumple FROM `vacaciones` inner join contrato on contrato.id_contrato=vacaciones.id_contrato inner JOIN empleados on empleados.id_empleado=contrato.id_empleado inner join agencias on agencias.id_agencia=contrato.id_agencia
where vacaciones.id_vacacion=211
  */
  }


//CONTROL DE VACACIONES 
  function ultimaVacacion($code){
    //se buscan las ultimas vacaciones
      $this->db->select('va.*');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('va.aprobado', 1);
      $this->db->where('va.estado', 1);
      $this->db->where('co.id_empleado', $code);
      $this->db->order_by('va.id_vacacion','DESC');
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->result();
  }

  function getContratoVaca($code){
    //contrato actual del empleado
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

  function ingresoDias($id_vacacion, $fecha_actual, $fecha, $horas, $minutos, $contratoAuto,$tipo){
    //ingreso de los dias de vacaciones
      $data = array(
                'id_vacacion'         => $id_vacacion,   
                'fecha_ingreso'       => $fecha_actual,   
                'fechas_vacacion'     => $fecha,   
                'horas'               => $horas,   
                'minutos'             => $minutos,   
                'id_auto'             => $contratoAuto,   
                'estado'              => $tipo,
            );
      $result=$this->db->insert('control_vacacion',$data);
      return $result;
  }

  function conteoDias($id_vacacion){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('control_vacacion');
      $this->db->where('id_vacacion', $id_vacacion);

      $query = $this->db->get();
      return $query->result();
  }

  function oldVacacion($code){
      $this->db->select('va.*');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('va.aprobado', 1);
      $this->db->where('co.id_empleado', $code);
      $this->db->order_by('va.id_vacacion','DESC');
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->result();
  }

  function regitrosMes($code,$codeVaca=null,$diaUno=null,$ultimoDia=null){
      $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos, cv.fechas_vacacion');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      if($codeVaca != null){
        $this->db->where('va.id_vacacion', $codeVaca);
      }
      if($diaUno != null && $ultimoDia != null){
        $this->db->where('cv.fechas_vacacion BETWEEN"'.$diaUno.'" and "'.$ultimoDia.'"');
      }
      $this->db->group_by('cv.fechas_vacacion');

      $query = $this->db->get();
      return $query->result();
  }

  function verificacionVaca($code){
    //se trae el id  de la vacacion que esta activa
     $this->db->select('va.id_vacacion');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('va.estado', 1);
      $this->db->where('va.aprobado', 1);
      $this->db->order_by('va.fecha_aplicacion','DESC');

      $query = $this->db->get();
      return $query->result();
  }

  function registroDiasva($fecha, $code){
    //funcion para traer la cantidad de horas y minutos del dia
      $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos,cv.fechas_vacacion');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('cv.fechas_vacacion', $fecha);
      $this->db->where('va.estado', 1);
      
      $this->db->group_by('cv.fechas_vacacion');

      $query = $this->db->get();
      return $query->result();
  }

  function conteoVacacion($code){
    //funcion para traer la cantidad de horas y minutos
      $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('va.estado', 1);
      $this->db->order_by('va.fecha_aplicacion','DESC');

      $query = $this->db->get();
      return $query->result();
  }


  function todoTiempo($id_vacacion){
    //suma de horas y minutos de las vacaciones
      $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->where('va.id_vacacion', $id_vacacion);

      $query = $this->db->get();
      return $query->result();
  }

  function buscarDomingo($id_vacacion){
      //registros de los dias ingresados
      $this->db->select('cv.*');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->where('va.id_vacacion', $id_vacacion);

      $query = $this->db->get();
      return $query->result();
  }

  function cancelVacaciones($id_vacacion){
    //si tienen en estado dos la vacacion que se cancelan 
    //es porque ya cumplio los dias de vacacion
    $data = array(
      'estado'          => 2,
    );
    $this->db->where('id_vacacion', $id_vacacion);
    $this->db->update('vacaciones',$data);
    return true;
  }

  function datosPersonal($id){
    //datos de un empleado
      $this->db->select('ag.agencia, em.nombre, em.apellido, ca.cargo, pl.nombrePlaza');
      $this->db->from('agencias ag');
      $this->db->join('contrato co', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');

      $this->db->where('em.id_empleado', $id);
      
      //$this->db->where('(co.estado = 1 or co.estado = 3)');

      $query = $this->db->get();
      return $query->result();
  }

  function diasVacacion($id,$fecha){
      $this->db->select('cv.id_control, cv.id_vacacion, cv.fecha_ingreso, cv.fechas_vacacion, cv.horas, cv.minutos, cv.id_auto, cv.tipo, cv.estado');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('cv.fechas_vacacion', $fecha);
      $this->db->where('co.id_empleado', $id);
      //$this->db->where('(co.estado = 1 or co.estado = 3)');

      $query = $this->db->get();
      return $query->result();
  }

  function autoDias($id_auto,$fecha){
      //nombre de la persona que autorizo el registro de vacacion
      $this->db->select('em. nombre, em.apellido');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
      $this->db->join('control_vacacion cv', 'cv.id_auto=co.id_contrato');
      $this->db->where('co.id_contrato', $id_auto);
      $this->db->where('cv.fechas_vacacion', $fecha);
        
      $query = $this->db->get();
      return $query->result();
  }

  function verificacionVacacion($code_vacacion){
      $this->db->select('estado');
      $this->db->from('vacaciones');
      $this->db->where('id_vacacion', $code_vacacion);
        
      $query = $this->db->get();
      return $query->result();
  }

  function activarVacacion($code_vacacion){
      $data = array(
        'estado'          => 1,
      );
      $this->db->where('id_vacacion', $code_vacacion);
      $this->db->update('vacaciones',$data);
      return true;
  }

  function eliminarTiempo($code){
    $this->db->where('id_control', $code);
    $this->db->delete('control_vacacion');
    return true;
  }

  //APARTADO DE VACACIONES ANTICIPADAS 
  function anticipadasEmpleados($code, $diaUno, $ultimoDia){
      $this->db->select('SUM(an.horas) as horas, SUM(an.minutos) as minutos, an.fechas_vacacion');
      $this->db->from('vacacion_anticipada an');
      $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('an.estado', 1);
      $this->db->where('an.fechas_vacacion BETWEEN"'.$diaUno.'" and "'.$ultimoDia.'"');
      $this->db->group_by('an.fechas_vacacion');
      $this->db->order_by('an.fechas_vacacion ', "ASC");

      $query = $this->db->get();
      return $query->result();
  }

  function tiempoRestantes($code,$fecha_vacacion){
      $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('cv.fechas_vacacion', $fecha_vacacion);

      $query = $this->db->get();
      return $query->result();
  }

  function conteoVacacionAnt($code){
    //suma de las horas y minutos de las vacaciones anticipadas
      $this->db->select('SUM(va.horas) as horas, SUM(va.minutos) as minutos');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('va.estado', 1);

      $query = $this->db->get();
      return $query->result();
  }

  function registroDiasAnt($fecha, $code){
      $this->db->select('SUM(va.horas) as horas, SUM(va.minutos) as minutos,va.fechas_vacacion');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('va.fechas_vacacion', $fecha);
      $this->db->where('va.estado', 1);
      
      $this->db->group_by('va.fechas_vacacion');

      $query = $this->db->get();
      return $query->result();
  }

  function ingresoDiasAnt($id_contrato, $fecha, $horas, $minutos, $contratoAuto){
      $data = array(
                'id_contrato'         => $id_contrato,   
                'fecha_ingreso'       => date('Y-m-d'),   
                'fechas_vacacion'      => $fecha,   
                'horas'               => $horas,   
                'minutos'             => $minutos,   
                'id_auto'             => $contratoAuto,   
                'estado'              => 1,
            );
      $result=$this->db->insert('vacacion_anticipada',$data);
      return $result;
  }

  function buscarDomingoAnt($code){
      $this->db->select('va.*');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('va.estado', 1);

      $query = $this->db->get();
      return $query->result();
  }

  function diasVacacionAnt($id,$fecha){
      $this->db->select('va.*');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $id);
      $this->db->where('va.fechas_vacacion', $fecha);
      $this->db->where('va.estado', 1);

      $query = $this->db->get();
      return $query->result();
  }

  function autoDiasAnt($id_auto,$fecha){
    //datos del autorizante de vacacion anticipada
      $this->db->select('em. nombre, em.apellido');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
      $this->db->join('vacacion_anticipada va', 'co.id_contrato=va.id_auto');
      $this->db->where('co.id_contrato', $id_auto);
      $this->db->where('va.fechas_vacacion', $fecha);
        
      $query = $this->db->get();
      return $query->result();
  }

  function aliminarAnticipada($code){
    //metodo para eliminar los datos de las vacaciones anticipadas
    //OJO este metodo si borra los datos
    $this->db->where('id_anticipada', $code);
    $this->db->delete('vacacion_anticipada');
    return true;
  }

  function allAnticipadas($empleado){
      $this->db->select('vacacion_anticipada.*');
      $this->db->from('vacacion_anticipada');
      $this->db->join('contrato co', 'co.id_contrato=vacacion_anticipada.id_contrato');
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('vacacion_anticipada.estado', 1);
        
      $query = $this->db->get();
      return $query->result();
  }

  function cancelarVacacionAnt($id_anticipada){
    //se cancelan las vacaciones anticipadas de la tabla vacacion_anticipada
      $data = array(
        'estado'          => 2,
      );
      $this->db->where('id_anticipada', $id_anticipada);
      $this->db->update('vacacion_anticipada',$data);
      return true;
  }

  //APARTADO PARA LOS DIAS QUE SON ASUETO
  function agencia($code){
      $this->db->select('co.id_agencia');
      $this->db->from('agencias ag');
      $this->db->join('contrato co', 'co.id_agencia=ag.id_agencia');
      $this->db->where('co.id_empleado', $code);
      $this->db->where('(co.estado = 1 or co.estado = 3)');
        
      $query = $this->db->get();
      return $query->result();
  }

  function asuetosAgencia($id_agencia,$primerDia,$ultimoDia){
    $this->db->db_select('Operaciones');

      $this->db->select('*');
      $this->db->from('asuetos');
      $this->db->where('id_agencia', $id_agencia);
      $this->db->where('((fecha_inicio BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'") or (fecha_fin BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"))');
      $this->db->where('estado', 1);
      $this->db->order_by('fecha_inicio ', "ASC");
        
      $query = $this->db->get();
      $this->db->db_select('tablero');
      return $query->result();

  }

  //APARTADO PARA EL REPORTE DE CONTROL DE VACACIONES
  function controlVacacion($id_vacacion){
      $this->db->select('ag.agencia, em.nombre, em.apellido, SUM(cv.horas) as horas, SUM(cv.minutos) as minutos, co.id_empleado');
      $this->db->from('control_vacacion cv');

      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->join('agencias ag','ag.id_agencia=co.id_agencia');
      $this->db->join('empleados em','em.id_empleado=co.id_empleado');
      $this->db->where('cv.tipo = 1');
      
      
       $this->db->where('va.id_vacacion',$id_vacacion);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
      $this->db->group_by('co.id_empleado');
      $this->db->group_by('ag.agencia');
      $this->db->group_by('em.nombre');
      $this->db->group_by('em.apellido');
  
        
      $query = $this->db->get();
      return $query->result();
  }

  //APARTADO PARA EL REPORTE DE CONTROL DE VACACIONES
  /*function controlVacacion2($diaUno,$diaUltimo,$empresa,$agencia){
      $this->db->select('if(cv.horas != "8", SUM(cv.horas), 0) as horas, SUM(cv.minutos) as minutos');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
   
      $this->db->where('cv.tipo = 1');
      $this->db->where('cv.fechas_vacacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');
      if($empresa != 'todo'){
        $this->db->where('co.id_empresa',$empresa);
      }

       if($agencia != 'todas'){
        $this->db->where('co.id_agencia',$agencia);
      }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
      $this->db->group_by('cv.horas');
      $this->db->order_by('cv.horas ', "ASC");
        
      $query = $this->db->get();
      return $query->result();
  }*/

  function controlAnticipaada($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon =null, $id_empleado =null){
      $this->db->select('ag.agencia, em.nombre, em.apellido, SUM(va.horas) as horas, SUM(va.minutos) as minutos, co.id_empleado');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->where('va.fechas_vacacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
      if($empresa != 'todo' && $empresa != null){
        $this->db->where('co.id_empresa',$empresa);
      }

      if($agencia != 'todas' && $agencia != null){
        $this->db->where('co.id_agencia',$agencia);
      }

      if($ag_admon != null){
        $this->db->where('ag.id_agencia != 00');
      }
      if($id_empleado != null){
        $this->db->where('em.id_empleado', $id_empleado);
      }

      $this->db->where('va.estado = 1');

      $this->db->group_by('co.id_empleado');
      $this->db->group_by('ag.agencia');
      $this->db->group_by('em.nombre');
      $this->db->group_by('em.apellido');
        
      $query = $this->db->get();
      return $query->result();
  }
  //NO28042023 vacaciones actualziar
  function actualizar_vacacion($id_vacacion){
    $this->db->set('aprobado', 1);
    $this->db->set('fecha_aprobado', date("Y-m-d"));
    $this->db->where('id_vacacion', $id_vacacion);
    $this->db->update('vacaciones');
    return null;
  }
    //NO28042023 vacaciones cancelar
    function cancelar_vacacion($id_vacacion){
      $this->db->set('aprobado', 0);
      $this->db->set('estado', 0);
      $this->db->where('id_vacacion', $id_vacacion);
      $this->db->update('vacaciones');
      return null;
    }

      //NO18052023 modificacion para traer la vacacion de 1 empleado
      // WM01062023 se modifico el primer where para que regrese datos con aprobado 0 y estado 1
      function vacacionAnio($diaUno,$diaUltimo,$empresa,$agencia, $ag_admon, $id_empleado = null){
        $this->db->select('va.id_vacacion, ag.agencia, em.nombre, em.apellido, va.fecha_aplicacion, co.id_empleado, va.aprobado, va.id_vacacion');
        $this->db->from('vacaciones va');
        $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->where('((va.aprobado = 1 and va.estado = 1) or (va.aprobado = 1 and va.estado = 2) or (va.aprobado = 1 and va.estado = 1))');
        $this->db->where('va.fecha_aplicacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
        if($empresa != 'todo' && $empresa != null){
          $this->db->where('co.id_empresa',$empresa);
        }
  
        if($agencia != 'todas' && $agencia != null){
          $this->db->where('co.id_agencia',$agencia);
        }
  
        if($ag_admon != null){
          $this->db->where('ag.id_agencia != 00');
        }
        if($id_empleado != null){
          $this->db->where('em.id_empleado', $id_empleado);
        }
          
        $query = $this->db->get();
        return $query->result();
        }
  

  function vacaAnterior($diaUno,$diaUltimo,$code){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado',$code);
      $this->db->where('((va.aprobado = 1 and va.estado = 1) or (va.aprobado = 1 and va.estado = 2))');
      $this->db->where('va.fecha_aplicacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');

        
      $query = $this->db->get();
      return $query->result();
  }

  function vacacionAnterior($diaUno,$diaUltimo,$code){
     $this->db->select('SUM(cv.horas) as horas, SUM(cv.minutos) as minutos');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->join('agencias ag','ag.id_agencia=co.id_agencia');
      $this->db->join('empleados em','em.id_empleado=co.id_empleado');
      $this->db->where('co.id_empleado',$code);
      $this->db->where('cv.tipo = 1');
      $this->db->where('cv.fechas_vacacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');
        
      $query = $this->db->get();
      return $query->result();
  }

  function allVacacion($id){
      //se buscan los registros de una vacacion
      $this->db->select('cv.id_control, cv.id_vacacion, cv.fecha_ingreso, cv.fechas_vacacion, cv.horas, cv.minutos, cv.id_auto, cv.tipo, cv.estado');
      $this->db->from('control_vacacion cv');
      $this->db->join('vacaciones va', 'va.id_vacacion=cv.id_vacacion');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');

      //$this->db->where('co.id_empleado', $id);
      $this->db->where('va.id_vacacion', $id);


      //$this->db->where('( .estado = 1 or co.estado = 3)');
      //$this->db->where('cv.fechas_vacacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');

      $query = $this->db->get();
      return $query->result();
  }

  function allVacacionAnt($id,$diaUno,$diaUltimo){
      $this->db->select('va.*');
      $this->db->from('vacacion_anticipada va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $id);
      $this->db->where('va.estado', 1);
      $this->db->where('va.fechas_vacacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');

      $query = $this->db->get();
      return $query->result();
  }

  function verDia($id_vacacion,$nextDate){
      //consulta para validar si la fecha ya esta ingresada
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('control_vacacion');
      $this->db->where('id_vacacion', $id_vacacion);
      $this->db->where('fechas_vacacion', $nextDate);
      
      $query = $this->db->get();
      return $query->result();
  }

  function buscarVacionEm($id_empleado,$fechaAplicar){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('va.fecha_aplicacion', $fechaAplicar);
     

      $query = $this->db->get();
      return $query->result();
  }

  function buscarnombre($code){
      $this->db->select('em.nombre, em.apellido, co.id_contrato, co.fecha_inicio');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
      $this->db->where('co.id_empleado', $code);
      $this->db->order_by('co.id_contrato ', "DESC");
      $this->db->limit(1);

      $query = $this->db->get();
      return $query->result();
  }

  function contratoMenor($id_empleado,$id_contrato){
      $this->db->select('*');
      $this->db->from('contrato'); 
      $this->db->where('id_empleado',$id_empleado);
      $this->db->where('id_contrato < ',$id_contrato);
      $this->db->order_by('id_contrato','DESC');

      $result = $this->db->get();
      return $result->result();
  }

  function verificar_dia($fecha,$code){
      $this->db->select('control_vacacion.*');
      $this->db->from('control_vacacion');
      $this->db->join('vacaciones', 'control_vacacion.id_vacacion=vacaciones.id_vacacion');
      $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');

      $this->db->where('contrato.id_empleado', $code);
      $this->db->where('control_vacacion.fechas_vacacion', $fecha);

      $query = $this->db->get();
      return $query->result();
  }

  function buscar_vaca($id_empleado, $diaUno, $diaUltimo){
    //se busca las vacaciones del empleado en el año
      $this->db->select('*');
      $this->db->from('vacaciones');

      $this->db->join('contrato co', 'co.id_contrato=vacaciones.id_contrato');

      $this->db->where('vacaciones.aprobado = 1');
      $this->db->where('vacaciones.fecha_aplicacion BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
      $this->db->where('(vacaciones.estado = 1 or vacaciones.estado = 2)');

      $this->db->where('co.id_empleado', $id_empleado);


      $query = $this->db->get();
      return $query->result();
  }

  function agenciasEmpresa($id, $ag_admon){
    $this->db->select('ag.id_agencia,ag.agencia');
    $this->db->from('agencias ag');
    $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
    $this->db->where('ea.id_empresa',$id);
    $this->db->where('ea.estado',1);

    if($ag_admon == null){
      $this->db->where('ag.id_agencia != 00');
    }

    $this->db->group_by('ag.id_agencia');
    $this->db->group_by('ag.agencia');
    $this->db->order_by('ag.agencia','ASC');

    $query = $this->db->get();
    return $query->result();
  }

  //APARTADO PARA NUEVAS VACACIONES //NO28042023
  function get_all_empleado($agencia, $id_empleado = null){
    $this->db->select('em.id_empleado, co.id_contrato, concat(em.nombre," ",em.apellido) as empleado,em.afp,em.ipsfa,em.isss,co.fecha_inicio,ag.id_agencia, ag.agencia,empresa.nombre_empresa,cc.Sbase');
    $this->db->from('empleados em');

    $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
    $this->db->join('empresa', 'empresa.id_empresa=co.id_empresa');

    if($agencia == null){
      $this->db->where('co.id_agencia != "00"');
    }else if($agencia == 2){
      $this->db->where('co.id_agencia = "00"');
    }

    $this->db->where('em.activo = 1 and (co.estado = 1 or co.estado = 3 or co.estado = 9) and ((em.afp IS NOT NULL and em.afp != "") OR (em.ipsfa IS NOT NULL and em.ipsfa != "")) and (em.isss != "" and em.isss IS NOT NULL)');
    if($id_empleado != null){
    $this->db->where('em.id_empleado', $id_empleado);
    }
    $this->db->order_by('ag.agencia','ASC');

    $query = $this->db->get();
    return $query->result();
  }

  function comision_empleados($mes,$empleado){
    $this->db->select('SUM(bonificacion.bono) as cantidad, contrato.id_empleado, bonificacion.mes');
    $this->db->from('contrato');

    $this->db->join('bonificacion', 'bonificacion.id_contrato=contrato.id_contrato ');

    $this->db->where('bonificacion.mes >=',$mes);
    $this->db->where('contrato.id_empleado',$empleado);
    $this->db->group_by('contrato.id_contrato');
    $this->db->group_by('bonificacion.mes');

    $query = $this->db->get();
    return $query->result();
  }

  function verifica_asuetos($agencia,$dia,$anio){
    //se traen los asuetos correspondientes del dia que se busca
    $this->db->db_select('Operaciones');

    $this->db->select('*');
    $this->db->from('asuetos'); 

    $this->db->where('("'.$dia.'" >= concat('.$anio.',"-",substr(fecha_inicio,6,5)) and "'.$dia.'" <= concat('.$anio.',"-",substr(fecha_fin,6,5)) and estado = 1 and id_agencia = "'.$agencia.'")');
    $this->db->or_where('("'.$dia.'" >= fecha_inicio and "'.$dia.'" <= fecha_fin and estado = 2 and id_agencia = "'.$agencia.'")');
    //$this->db->where('nacional = 1');
    //$this->db->where('estado = 1');
    //$this->db->where('id_agencia',$agencia);

    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  function verifica_vacacion($id_empleado,$fecha){
    $this->db->select('vacaciones.*');
    $this->db->from('vacaciones'); 
    $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');

    $this->db->where('vacaciones.fecha_aplicacion', $fecha);
    $this->db->where('contrato.id_empleado', $id_empleado);
    $this->db->where('(vacaciones.aprobado = 1 or vacaciones.aprobado = 2)');
    $this->db->where('(vacaciones.estado = 1 or vacaciones.estado = 2)');

    $result = $this->db->get();
    return $result->result();
  }

  function get_vacacion_activa($id_empleado){
    $this->db->select('vacaciones.*');
    $this->db->from('vacaciones'); 
    $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');

    $this->db->where('contrato.id_empleado', $id_empleado);
    $this->db->where('(vacaciones.aprobado = 1 or vacaciones.aprobado = 2)');
    $this->db->where('vacaciones.estado = 1');

    $result = $this->db->get();
    return $result->result();
  }

  function save_vacacion($data){
    //$result=$this->db->insert('vacaciones',$data);
    //return $result;
    $this->db->insert('vacaciones',$data);
    $id = $this->db->insert_id();
    return $id;
  }

  //WM23032023 se agrego el campo id_contrato para utilizar en funciones
  function vacaciones_aprobadas($empleado,$fecha_inicio,$fecha_fin){
    $this->db->select('"1" as guardado,agencias.agencia, empresa.nombre_empresa, concat(empleados.nombre," ",empleados.apellido) as empleado, vacaciones.fecha_aplicacion as fecha_aplicar, DATE_ADD(vacaciones.fecha_aplicacion, INTERVAL 14 DAY) as fecha_final, (vacaciones.cantidad_apagar-vacaciones.prima) as sueldo_quin, vacaciones.comision as comisiones, vacaciones.prima, vacaciones.cantidad_apagar as total_pagar, vacaciones.isss, vacaciones.afp_ipsfa as afp, vacaciones.isr as renta, vacaciones.prestamo_interno as interno, vacaciones.prestamos_personal as personal, vacaciones.orden_descuento, vacaciones.anticipos, (vacaciones.cantidad_apagar-vacaciones.afp_ipsfa-vacaciones.isss-vacaciones.isr-vacaciones.prestamo_interno-vacaciones.prestamos_personal-vacaciones.anticipos-vacaciones.orden_descuento) as a_pagar, vacaciones.id_contrato');
    $this->db->from('vacaciones'); 
    $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');
    $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
    $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
    $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');

    $this->db->where('vacaciones.fecha_aplicacion >=', $fecha_inicio);
    $this->db->where('vacaciones.fecha_aplicacion <=', $fecha_fin);
    $this->db->where('contrato.id_empleado', $empleado);
    $this->db->where('vacaciones.aprobado = 1 and (vacaciones.estado = 1 or vacaciones.estado = 2) and vacaciones.ingresado = 1');

    $this->db->order_by('agencias.agencia','ASC');

    $result = $this->db->get();
    return $result->result();
  }

  // WM23032023 funcion para revertir vacaciones
  function revertir_vacaciones($id_contrato, $fecha_aplicacion){
    $this->db->set('estado', 0);
    $this->db->set('aprobado', 0);
    $this->db->where('id_contrato', $id_contrato);
    $this->db->where('fecha_aplicacion', $fecha_aplicacion);
    
    $result=$this->db->update('vacaciones');
    return $result;
  }

  // WM23032023 funcion para revertir los pagos de cuota de herramienta
  function revertir_pago_herramienta_vacaciones($id_contrato){
   $this->db->query("UPDATE pagos_descuento_herramienta as pdh 
      JOIN descuento_herramienta as dh on dh.id_descuento_herramienta = pdh.id_descuento_herramienta
      SET pdh.estado = 0, pdh.planilla = 0
      WHERE dh.id_contrato = ".$id_contrato."
      ORDER BY pdh.estado DESC
      LIMIT 1");
   
    return null;
  }

  // WM23032023 funcion para traer el id_empleado
  function empleado_id($id_contrato){
    $this->db->select('emp.id_empleado');
    $this->db->from('empleados as emp');
    $this->db->join('contrato as con','con.id_empleado=emp.id_empleado');
    $this->db->where('con.id_contrato',$id_contrato);

    $result= $this->db->get();
    return $result->result();
  }

  // WM23032023 funcion para revertir el pago ejectutado en las vacaciones
  function revertir_pago_siga($id_empleado){
    $this->db->db_select('Operaciones');
    $this->db->query("
    UPDATE pagos_empleado AS pag_emp
    JOIN credito_empleado AS cre_emp ON cre_emp.codigo=pag_emp.credito
    JOIN cliente_empleado AS cli_emp ON cli_emp.id_cliente=cre_emp.id_cliente
    SET pag_emp.estado = '0'
    WHERE cli_emp.id_empleado = ".$id_empleado."
    ORDER BY pag_emp.estado DESC
    LIMIT 1; ");

    $this->db->db_select('tablero');

    return null;
  }

}