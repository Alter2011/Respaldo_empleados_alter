<?php
class PrestamosPersonales_model extends CI_Model{

  //MANTENIMIENTO DE PRESTAMOS PERSONALES
  function techoPrestamo($tipo_prestamo){
      $this->db->select('desde,hasta,porcentaje');
      $this->db->from('tipo_prestamos_personales'); 
      $this->db->where('id_prest_personales',$tipo_prestamo);

      $result = $this->db->get();
      return $result->result();
  }
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

  function anticipo(){
        $this->db->select('hasta');
        $this->db->from('tipo_anticipo'); 
        $this->db->where('estado',1);
        $this->db->where('nombre_tipo','Anticipo Corriente');

        $result = $this->db->get();
        return $result->result();
  }

  function insertPrestamos($data){
      $result=$this->db->insert('prestamos_personales',$data);
      return $result;
  }

  function refinanciamientoPrestamo($code_refi,$data){//modifica estado al dar refinanciamiento
        $this->db->where('id_prestamo_personal',$code_refi);
        $this->db->update('prestamos_personales',$data);
  }

  function datosPrestamo($code_refi){
    $this->db->select('*');
    $this->db->from('prestamos_personales');
    $this->db->where('id_prestamo_personal', $code_refi);
        
    $query = $this->db->get();
    return $query->result();
  }

    function datosPrestamoActual($code_refi){//agregar al de arriba
    $this->db->limit(1);
    $this->db->select('*');
    $this->db->from('amortizacion_personales ap');
    $this->db->join('prestamos_personales pp', 'pp.id_prestamo_personal=ap.id_prestamo_personal');
    $this->db->order_by('ap.fecha_abono','desc'); 
    $this->db->where('ap.id_prestamo_personal', $code_refi);
    $this->db->where('ap.estado', 1);

    $query = $this->db->get();
    return $query->result();
    
  }

  //MANTENIMIENTOS DE VER PRESTAMOS
  function verPrestamosInternos($id_empleado,$orden){
     $this->db->select('pr.id_prestamo_personal, em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia, ca.cargo, format(pr.monto_otorgado,2) as cantidad, pr.plazo_quincenas, pr.meses, format(pr.cuota,2) as couta , pr.fecha_solicitado, pr.fecha_otorgado, pr.id_prest_personales, tp.nombre_tipos, pr.id_cont_autorizado,pr.aprobado, pr.estado,pr.descripcion_prestamo,pr.descripcion_rechazo,pr.fecha_fin');
     $this->db->from('contrato co');
     $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
     $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
     $this->db->join('prestamos_personales pr', 'pr.id_contrato=co.id_contrato');
     $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
     $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
     $this->db->where('co.id_empleado', $id_empleado);
     if($orden == 0){
      $this->db->where('pr.estado', 0);
      $this->db->where('pr.aprobado', 1);

     }else if($orden == 1){
      $this->db->where('pr.estado', 1);
      $this->db->where('pr.aprobado', 1);

     }else if($orden == 2){
      $this->db->where('pr.aprobado', 0);

     }else if($orden == 3){
      $this->db->where('pr.aprobado', 2);

     }else if($orden == 4){
      $this->db->where('pr.estado', 2);
      $this->db->where('pr.aprobado', 1);

     }
     $this->db->group_by('pr.id_prestamo_personal');
     $this->db->group_by('em.nombre');
     $this->db->group_by('em.apellido');
     $this->db->group_by('em.dui');
     $this->db->group_by('em.tel_personal');
     $this->db->group_by('ag.agencia');
     $this->db->group_by('ca.cargo');
     $this->db->group_by('pr.monto_otorgado');
     $this->db->group_by('pr.plazo_quincenas');
     $this->db->group_by('pr.meses');
     $this->db->group_by('pr.cuota');
     $this->db->group_by('pr.fecha_solicitado');
     $this->db->group_by('pr.fecha_otorgado');
     $this->db->group_by('pr.id_prest_personales');
     $this->db->group_by('tp.nombre_tipos');
     $this->db->group_by('pr.id_cont_autorizado');
     $this->db->group_by('pr.aprobado');
     $this->db->group_by('pr.estado');
     $this->db->group_by('pr.descripcion_prestamo');
     $this->db->group_by('pr.descripcion_rechazo');
     $this->db->group_by('pr.fecha_fin');

     $query = $this->db->get();
     return $query->result();
  }


  function verAutorizacion($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('prestamos_personales pr', 'pr.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
  }

  function cancelar($code){
    $data = array(
          'fecha_fin'      => date('Y-m-d'),
          'estado'         => 0,
          'planilla'       => 2,
    );
        $this->db->where('id_prestamo_personal', $code);
        $this->db->update('prestamos_personales',$data);
        return true;
  }

    //METODO PARA NOTIFICAR SOLICITUD DE PRESTAMOS
    function notificaciones(){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('prestamos_personales'); 
        $this->db->where('aprobado',0);

        $result = $this->db->get();
        return $result->result();
    }

    //MANTENIMIENTO PARA SOLICITUDES DE PRESTAMOS PERSONALES
    function getSolicitudes($agencia){
        $this->db->select('pr.id_prestamo_personal, format(pr.monto_otorgado,2) as cantidad, em.nombre, em.apellido, ag.agencia, ca.cargo, pr.id_cont_autorizado');
        $this->db->from('prestamos_personales pr');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca ', 'ca.id_cargo=co.id_cargo');
        $this->db->where('pr.aprobado', 0);
        if($agencia != null){  
          $this->db->where('co.id_agencia', $agencia);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function aprobarPrestamo($code){
        $data = array(
            'fecha_otorgado' => date('Y-m-d'),
            'aprobado'       => 1,
        );
          $this->db->where('id_prestamo_personal', $code);
          $this->db->update('prestamos_personales',$data);
          return true;
    }

    function rechazarPrestamo($code,$justificacion){
        $data = array(
            'fecha_fin'             => date('Y-m-d'),
            'descripcion_rechazo'   => $justificacion,
            'aprobado'              => 2,
        );
        $this->db->where('id_prestamo_personal', $code);
        $this->db->update('prestamos_personales',$data);
        return true;
    }

    function verSolicitud($code){
        $this->db->select('pr.id_prestamo_personal, em.nombre, em.apellido, em.dui, em.tel_personal,ag.agencia,ca.cargo, format(pr.monto_otorgado,2) as cantidad, pr.plazo_quincenas, pr.meses, format(pr.cuota,2) as cuota, pr.fecha_solicitado, pr.id_prest_personales, pr.id_cont_autorizado,pr.descripcion_prestamo');
        $this->db->from('prestamos_personales pr');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca ', 'ca.id_cargo=co.id_cargo');
        $this->db->where('pr.id_prestamo_personal', $code);
        
        $query = $this->db->get();
        return $query->result();
    }

    function updatePrestamo($code,$data){
        $this->db->where('id_prestamo_personal', $code);
        $this->db->update('prestamos_personales',$data);
        return true;
    }

    //MANTENIMIENTO DE TIPO DE PRESTAMOS PERSONALES
    function getTiposPrestamos(){
        $this->db->select('*');
        $this->db->from('tipo_prestamos_personales'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function saveTipoPrestamos($nombre,$porcentaje,$desde,$hasta){
        $data = array(
              'nombre_tipos'             => $nombre,
              'porcentaje'               => $porcentaje,
              'desde'                    => $desde,
              'hasta'                    => $hasta,
              'fecha_creacion'           => date('Y-m-d'),
              'estado'                   => 1,
        );
        $result=$this->db->insert('tipo_prestamos_personales',$data);
        return $result;
    }

   function buscarTipo($code){
        $this->db->select('nombre_tipos, format(porcentaje*100,2) as porcentaje, format(desde,2) as desde, format(hasta,2) as hasta');
        $this->db->from('tipo_prestamos_personales'); 
        $this->db->where('estado',1);
        $this->db->where('id_prest_personales',$code);

        $result = $this->db->get();
        return $result->result();
   }

   function updateTipoPrestamos($code,$nombre,$porcentaje,$desde,$hasta){
        $data = array(
              'nombre_tipos'             => $nombre,
              'porcentaje'               => $porcentaje,
              'desde'                    => $desde,
              'hasta'                    => $hasta,
              'fecha_actualizacion'      => date('Y-m-d'),
        );
        $this->db->where('id_prest_personales', $code);
        $this->db->update('tipo_prestamos_personales',$data);
        return true;
   }

   function deleteTipoPrestamos($code){
      $data = array(
              'fecha_actualizacion'      => date('Y-m-d'),
              'estado'                   => 0,
        );
        $this->db->where('id_prest_personales', $code);
        $this->db->update('tipo_prestamos_personales',$data);
        return true;
   }


   function estadoCuentaPer($id_prestamo){
        $this->db->select('pr.id_prestamo_personal, em.nombre, em.apellido, ag.agencia, format(pr.monto_otorgado,2) as cantidad, format(pr.cuota,2) as couta, pr.fecha_otorgado, tp.nombre_tipos, tp.porcentaje, pr.plazo_quincenas, pr.descripcion_prestamo');
        $this->db->from('prestamos_personales pr');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
        $this->db->where('pr.id_prestamo_personal',$id_prestamo);

        $query = $this->db->get();
        return $query->result();
   }

   function pagosPrestamoPer($id_prestamo){
        $this->db->select('*');
        $this->db->from('amortizacion_personales'); 
        $this->db->where('id_prestamo_personal ',$id_prestamo); 
        $this->db->where('(estado = 1 or estado = 2)');
        $this->db->order_by('fecha_abono','ASC'); 

        $result = $this->db->get();
        return $result->result();
    }

    function amortizacionPersonal($code){
        $this->db->select('*');
        $this->db->from('amortizacion_personales'); 
        $this->db->where('id_prestamo_personal',$code); 
        $this->db->where('(estado = 1 or estado = 2)');
        $this->db->order_by('fecha_abono','DESC'); 
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
  }

  function prestamoPersonal($code){
        $this->db->select('pr.id_prestamo_personal, pr.monto_otorgado, pr.cuota, pr.plazo_quincenas, tp.porcentaje, pr.fecha_otorgado');
        $this->db->from('prestamos_personales pr');
        $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales'); 
        $this->db->where('pr.id_prestamo_personal ',$code);

        $result = $this->db->get();
        return $result->result(); 
  }

  function ingresar_desembolso($data){
    $result=$this->db->insert('desembolso_personal',$data);
    return $result;
  }

  function verDesembolso($id_prestamo_personal){
    $this->db->select('COUNT(*) as conteo');
    $this->db->from('desembolso_personal'); 
    $this->db->where('id_prestamo_per ',$id_prestamo_personal); 

    $result = $this->db->get();
    return $result->result();
  }

  function salida_reporte($primerDia,$ultimoDia){
    $this->db->select('emp.id_empresa, emp.nombre_empresa, ag.id_agencia, ag.agencia, em.nombre, em.apellido, ca.cargo, dp.fecha_desembolso, dp.tipo_desembolso, pr.monto_otorgado, pr.id_refinanciamiento, pr.fecha_otorgado, tp.porcentaje');
    $this->db->from('empleados em');
    $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
    $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
    $this->db->join('prestamos_personales pr', 'pr.id_contrato = co.id_contrato');
    $this->db->join('desembolso_personal dp', 'dp.id_prestamo_per=pr.id_prestamo_personal');
    $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
    $this->db->where('dp.estado',1);
    $this->db->where('dp.fecha_desembolso BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
       
    $query = $this->db->get();
    return $query->result();
  }
  function salida_SIGA($primerDia, $ultimoDia){
    $this->db->db_select('Operaciones');
    $this->db->select("de.*, solicitud.monto, solicitud.plazo, solicitud.tipo_solicitud, solicitud.id_cliente,cliente_empleado.id_empleado, cliente_empleado.id_agencia, agencias.agencia, solicitud.refinanciamiento,tablero.contrato.id_empresa, tablero.empresa.nombre_empresa,tablero.empresa.id_empresa, tablero.empleados.nombre,tablero.empleados.apellido, tablero.cargos.cargo");
    $this->db->from('desembolso_empleado de');
    $this->db->join('solicitud', 'solicitud.id_solicitud = de.id_solicitud');
    $this->db->join('cliente_empleado', 'solicitud.id_cliente = cliente_empleado.id_cliente');
    $this->db->join('agencias', 'agencias.id_agencia = cliente_empleado.id_agencia');
    $this->db->join('tablero.contrato', 'tablero.contrato.id_empleado = cliente_empleado.id_empleado');
    $this->db->join('tablero.empresa', 'tablero.empresa.id_empresa = tablero.contrato.id_empresa');
    $this->db->join('tablero.empleados', 'tablero.empleados.id_empleado = cliente_empleado.id_empleado');
    $this->db->join('tablero.cargos', 'tablero.cargos.id_cargo = tablero.contrato.id_cargo');
    $this->db->where('(tablero.contrato.estado = 1 or tablero.contrato.estado = 3)');
    $this->db->where('de.estado_desembolso = 1');
    $this->db->where('de.fecha_desembolso BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  function verificarBoveda($id_empresa){
    $this->db->select('emp.id_empresa, emp.nombre_empresa, ag.id_agencia, ag.agencia');
    $this->db->from('agencias ag'); 
    $this->db->join('empresa_agencia ea', 'ea.id_agencia=ag.id_agencia');
    $this->db->join('empresa emp', ' emp.id_empresa=ea.id_empresa');
    $this->db->where('emp.boveda', 1); 
    $this->db->where('ea.estado', 1); 
    $this->db->where('ea.id_agencia', $id_empresa); 

    $result = $this->db->get();
    return $result->result();
  }

  function buscarNoveda($id_agencia){
    $this->db->select('boveda');
    $this->db->from('empresa'); 
    $this->db->where('id_empresa', $id_empresa); 

    $result = $this->db->get();
    return $result->result();
  }

  function buscarEmpresas($estado=null){
    $this->db->select('*');
    $this->db->from('empresa'); 
    $this->db->where('estado ',1);
    if($estado!=null){
      $this->db->where('boveda ',1);
    } 

    $result = $this->db->get();
    return $result->result();
  }
  function buscarEmpresasSIGA(){
    $this->db->select("*");
    $this->db->from('empresa');
    $result = $this->db->get();
    return $result->result();
  }

  function dineroEmpresa($id_empresa,$primerDia,$ultimoDia){
    $this->db->select(' SUM(pr.monto_otorgado) as total');
    $this->db->from('contrato co');
    $this->db->join('prestamos_personales pr', 'pr.id_contrato=co.id_contrato');
    $this->db->join('desembolso_personal dp', 'dp.id_prestamo_per=pr.id_prestamo_personal');
    $this->db->where('co.id_empresa',$id_empresa);
    $this->db->where('dp.fecha_desembolso BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
       
    $query = $this->db->get();
    return $query->result();
  }

  function recibeNombre($recibe){
    $this->db->select('*');
    $this->db->from('empleados'); 
    $this->db->where('id_empleado ',$recibe); 
    $result = $this->db->get();
    return $result->result();
  }

  function empleadoEmpresa($empresa=null){
    $this->db->select('co.id_empleado, em.nombre, em.apellido, ag.agencia, emp.nombre_empresa');
    $this->db->from('contrato co');
    $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
    if($empresa != null){
      $this->db->where('co.id_empresa',$empresa);
    }
    $this->db->group_by('co.id_empleado, em.nombre, em.apellido, ag.agencia,emp.nombre_empresa');
    $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 0 or co.estado = 4)');
       
    $query = $this->db->get();
    return $query->result();
  }
    function ultimo_contrato($empleado=null){
      $this->db->select('co.id_empleado, em.nombre, em.apellido, ag.agencia, emp.nombre_empresa,emp.id_empresa');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      if($empleado != null){
        $this->db->where('em.id_empleado',$empleado);
        
      }
      //$this->db->group_by('co.id_empleado, em.nombre, em.apellido, ag.agencia,emp.nombre_empresa');
          $this->db->order_by('fecha_inicio','DESC');
          $this->db->limit(1);        
      $query = $this->db->get();
      return $query->result();
    }

  function prestamosActivos($id_empleado){
    $this->db->select('pr.*');
    $this->db->from('prestamos_personales pr');
    $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
    $this->db->where('co.id_empleado',$id_empleado);
    $this->db->where('pr.estado',1);
    $this->db->where('pr.aprobado',1);
    
    $query = $this->db->get();
    return $query->result();
  }

  function prestamosInactivos($id_empleado,$fecha_inicoQ1,$fecha_finQ2){
    $this->db->select('pr.*');
    $this->db->from('prestamos_personales pr');
    $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
    $this->db->where('co.id_empleado',$id_empleado);
    $this->db->where('pr.estado',0);
    $this->db->where('pr.fecha_fin BETWEEN"'.$fecha_inicoQ1.'" and "'.$fecha_finQ2.'"');
    
    $query = $this->db->get();
    return $query->result();
  }

  function buscarPago($id_empleado,$fecha_inico,$fecha_fin,$estado){
    $this->db->select('sum(ap.pago_total) as total');
    $this->db->from('amortizacion_personales ap');
    $this->db->join('prestamos_personales pr', 'pr.id_prestamo_personal=ap.id_prestamo_personal');
    $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
    $this->db->where('co.id_empleado',$id_empleado);
    $this->db->where('ap.fecha_abono BETWEEN"'.$fecha_inico.'" and "'.$fecha_fin.'"');
    if($estado == 1){
      $this->db->where('ap.estado',1);
    }else if($estado == 2){
      $this->db->where('ap.estado',2);
    }else if($estado == 3){
      $this->db->where('ap.estado',3);
    }else if($estado == 4){
      $this->db->where('ap.estado',4);
    }
    
    $query = $this->db->get();
    return $query->result();
  }

  function buscarBanco($empresa=null,$estado=null){
    $this->db->select('*');
    $this->db->from('bancos');
    $this->db->where('estado',1);
    if($estado == 1){
      $this->db->where('id_empresa',$empresa);
    }
    
    $query = $this->db->get();
    return $query->result();
  }

  function ingresarReintegro($data){
    $result=$this->db->insert('reintegro_prestamos_personales',$data);
    return $result;
  }

  function mostrarReintegro($fecha1,$fecha2){
    $this->db->select('ba.nombre_banco, ban.numero_cuenta, em.nombre_empresa, rp.*');
    $this->db->from('reintegro_prestamos_personales rp');
    $this->db->join('bancos ba', 'ba.id_banco=rp.id_banco');
    $this->db->join('bancos ban', 'ban.id_banco=rp.remesado');
    $this->db->join('empresa em', 'em.id_empresa=rp.id_empresa');
    $this->db->where('rp.estado',1);
    $this->db->where('rp.fecha BETWEEN"'.$fecha1.'" and "'.$fecha2.'"');

    $query = $this->db->get();
    return $query->result();
  }

  function deleteReintegro($code){
    $data = array(
      'estado'        => 0
    );

    $this->db->where('id_reintegro', $code);
    $this->db->update('reintegro_prestamos_personales', $data);
    return true;
  }

  function prestamosDatos($prestamo){
    $this->db->select('em.nombre, em.apellido, em.dui, co.id_empleado, co.id_agencia, ag.agencia, tp.porcentaje, pr.*');
    $this->db->from('prestamos_personales pr');
    $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
    $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
    $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->where('pr.id_prestamo_personal',$prestamo);
    
    $query = $this->db->get();
    return $query->result();
  }

  function empresasEmpleados($id_agencia){
    $this->db->select('ea.id_empresa, em.nombre_empresa, em.casa_matriz');
    $this->db->from('empresa_agencia ea');
    $this->db->join('empresa em', 'em.id_empresa=ea.id_empresa');
    $this->db->where('ea.estado',1);
    $this->db->where('ea.id_empresa != ',3);
    $this->db->where('ea.id_Agencia',$id_agencia);
    
    $query = $this->db->get();
    return $query->result();
  }

  function cantidadPrestamos($id_empleado,$fecha){
    $this->db->select('COUNT(*) as conteo');
    $this->db->from('prestamos_personales pr');
    $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
    $this->db->where('pr.aprobado',1);
    $this->db->where('co.id_empleado',$id_empleado);
    $this->db->where('pr.fecha_otorgado <=',$fecha);
    
    $query = $this->db->get();
    return $query->result();
  }

  function ultimo_pagos($id_prestamo_personal,$fecha_inicoQ2,$fecha_finQ2){
    $this->db->select('*');
    $this->db->from('amortizacion_personales');
    $this->db->where('id_prestamo_personal',$id_prestamo_personal);
    $this->db->where('estado = 1 and planilla = 1');
    $this->db->where('fecha_abono BETWEEN "'.$fecha_inicoQ2.'" and "'.$fecha_finQ2.'"');
    $this->db->order_by('fecha_ingreso','DESC'); 
    $this->db->limit(1);

    $query = $this->db->get();
    return $query->result();
  }

  function cancelar_pago($cancelar,$id_amortizacion_personal,$fecha_inicoQ2,$fecha_finQ2,$id_prestamo_personal){
    $this->db->where('id_amortizacion_personal != '.$id_amortizacion_personal.'  ');
    $this->db->where('id_prestamo_personal = '.$id_prestamo_personal.'  ');
    $this->db->where('fecha_abono BETWEEN "'.$fecha_inicoQ2.'" and "'.$fecha_finQ2.'"');
    $this->db->update('amortizacion_personales', $cancelar);
    return true;
  }

  public function pagos_empleados_siga($inicio,$fin)
  {
    //$this->db->db_select('Operaciones');
    $this->db->select('monto_ingresado,ce.id_empleado,fecha_pago,pe.estado,CONCAT(em.nombre," ",em.apellido) as empleado');
    $this->db->from('Operaciones.pagos_empleado pe');
    $this->db->join('Operaciones.cliente_empleado ce', 'ce.id_cliente=substr(credito,1,7)');
    $this->db->join('tablero.empleados em', 'em.id_empleado=ce.id_empleado');
    $this->db->where('pe.estado !=0');
    $this->db->where('substr(fecha_pago,1,10) BETWEEN "'.$inicio.'" and "'.$fin.'"');
    $this->db->order_by('fecha_pago','ASC'); 


    $query = $this->db->get();
    //$this->db->db_select('tablero');

    return $query->result();
  }

}