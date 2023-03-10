<?php
class Prestamo_model extends CI_Model{
    //todas estas consultas son de tablas de la bdd de tablero
    function agencias_listas($admin=null){
        //lista de agencias 
        $this->db->select('id_agencia, agencia');
        $this->db->from('agencias');
        $this->db->order_by('agencia','ASC');
         $this->db->where('id_agencia !=', 24);
        $result = $this ->db->get();
        return $result->result();
    }

    function agencias_listar($admin=null){
        $this ->db->select('id_agencia, agencia');
        $this->db->from('agencias');
        if($admin==0){
            $this->db->where('id_agencia !=', 00);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function empleadosList($code){
         $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
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

    function empleadosvaca($code){
      $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
         $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
         $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
         $this->db->where('co.id_agencia', $code);
         $this->db->where('em.activo', 1);
         $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 9)');
        $query = $this->db->get();
        return $query->result();
    }

     function tipoList(){
        $this->db->select('id_tipo_prestamo, nombre_prestamo');
        $this->db->from('tipo_prestamo'); 
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function getContrato($code){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$code);
        $this->db->where('estado != 0');
        $this->db->where('estado != 4');
        $this->db->where('estado = 1');
        $this->db->order_by('fecha_inicio','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
    }

//Se obtiene la tasa para saber la cuota de prestamos
    function getTasa($tipo_prestamo){
        $this->db->select('ta.tasa');
        $this->db->from('tasa ta');
        $this->db->join('tipo_prestamo tp', 'ta.id_tasa=tp.id_tasa'); 
        $this->db->where('tp.id_tipo_prestamo',$tipo_prestamo);

        $result = $this->db->get();
        return $result->result();
    }

    function savePrestamos($data){
        $result=$this->db->insert('prestamos_internos',$data);
        return $result;
    }

    function verPrestamos($codigo,$orden){
         $this->db->select('pr.id_prestamo,em.nombre, em.apellido, em.dui, em.tel_personal, ag.agencia, format(pr.monto_otorgado,2) as cantidad, format(pr.monto_pagar,2) as monto_pagar,format(pr.cuota,2) as couta, pr.fecha_otorgado, tp.nombre_prestamo, pr.estado, pr.aprobado, pr.plazo_quincena as tiempo, pr.nombre_plazo, pr.id_cont_autorizado,ca.cargo, pr.descripcion_rechazo, pr.fecha_solicitado,pr.descripcion_prestamo');
         $this->db->from('empleados em');
         $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
         $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
         $this->db->join('prestamos_internos pr', 'pr.id_contrato = co.id_contrato');
         $this->db->join('tipo_prestamo tp', 'tp.id_tipo_prestamo = pr.id_tipo_prestamo');
         $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');                  
         $this->db->where('em.id_empleado', $codigo);
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
         $this->db->group_by('em.nombre');
         $this->db->group_by('em.apellido');
         $this->db->group_by('em.dui');
         $this->db->group_by('em.tel_personal');
         $this->db->group_by('ag.agencia');
         $this->db->group_by('pr.monto_otorgado');
         $this->db->group_by('pr.fecha_otorgado');
         $this->db->group_by('tp.nombre_prestamo');
         $this->db->group_by('pr.estado');
         $this->db->group_by('pr.plazo_quincena');
         $this->db->group_by('pr.nombre_plazo');
         $this->db->group_by('pr.cuota');
         $this->db->group_by('pr.monto_pagar');
         $this->db->group_by('pr.id_prestamo');
         $this->db->group_by('pr.id_cont_autorizado');

        $query = $this->db->get();
        return $query->result();
    }

    function verAutorizacion($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('prestamos_internos pr', 'pr.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

    function cancelarPrestamos($code){
        $data = array(
                'fecha_fin'      => date('Y-m-d'),
                'estado'         => 0,
            );
      $this->db->where('id_prestamo', $code);
      $this->db->update('prestamos_internos',$data);
      return true;
    }
    //ESTADO DE CUENTA DE LOS PRESTAMOS INTERNOS
    function estadoCuenta($id_prestamo){
        $this->db->select('pr.id_prestamo,em.nombre, em.apellido, ag.agencia, format(pr.monto_otorgado,2) as cantidad, format(pr.monto_pagar,2) as monto_pagar,format(pr.cuota,2) as couta, pr.fecha_otorgado, tp.nombre_prestamo, pr.plazo_quincena as tiempo, pr.descripcion_prestamo, ta.tasa');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
        $this->db->join('prestamos_internos pr', 'pr.id_contrato = co.id_contrato');
        $this->db->join('tipo_prestamo tp', 'tp.id_tipo_prestamo = pr.id_tipo_prestamo');
        $this->db->join('tasa ta', 'ta.id_tasa=tp.id_tasa');
        $this->db->where('pr.id_prestamo',$id_prestamo);

        $query = $this->db->get();
        return $query->result();
    }

    function pagosPrestamo($id_prestamo){
        $this->db->select('*');
        $this->db->from('amortizacion_internos'); 
        $this->db->where('id_prestamo_interno',$id_prestamo); 
        $this->db->where('estado',1);
        $this->db->order_by('fecha_abono','ASC'); 

        $result = $this->db->get();
        return $result->result();
    }

//Mantenimientos para los tipos de prestamos
    public function tipoPrestamoList(){
        $this->db->select('tipo_prestamo.id_tipo_prestamo, tipo_prestamo.nombre_prestamo, tasa.nombre');
        $this->db->from('tipo_prestamo'); 
        $this->db->join('tasa', 'tasa.id_tasa = tipo_prestamo.id_tasa');
        $this->db->where('tipo_prestamo.estado',1);

        $result = $this->db->get();
        return $result->result();
    }

    function getTasas(){
        //datos necesarios para sabar que tasa es del prestamo
        $this->db->select('id_tasa, nombre');
        $this->db->from('tasa'); 
        $this->db->where('estado',1);
        $this->db->where('tipo_tasa',1);

        $result = $this->db->get();
        return $result->result();
    }

  public function saveTipos($nombre_prestamo,$fecha,$tasa){

        $data = array(
                'nombre_prestamo'     => $nombre_prestamo,  
                'fechas'              => $fecha,
                'id_tasa'             => $tasa,
                'estado'              => 1,
            );
        $result=$this->db->insert('tipo_prestamo',$data);
         return $result;
  }

  public function updateTipos($code,$nombre_prestamo,$fecha,$tasa){
     $data = array(
                'nombre_prestamo'     => $nombre_prestamo,
                'fechas'              => $fecha,
                'id_tasa'             => $tasa,  
            );
     $this->db->where('id_tipo_prestamo', $code);
     $this->db->update('tipo_prestamo',$data);
         return true;
  }

  public function deleteTipos($code){
      $data = array(
                'estado'              => 0,
            );
      $this->db->where('id_tipo_prestamo', $code);
      $this->db->update('tipo_prestamo',$data);
      return true;
  }

  public function validarExistTipo($nombre_prestamo){
        $this->db->select('count(*)as conteo');
        $this->db->from('tipo_prestamo');
        $this->db->where('nombre_prestamo',$nombre_prestamo);
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
  }

  function editTipos($code){
    $this->db->select('*');
    $this->db->from('tipo_prestamo');
    $this->db->where('id_tipo_prestamo',$code); 
    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }
  //Fin para el mantenimeinto de Tipos de prestamos

  //SOLICITUD DE PRESTAMOS INTERNOS
  function getSolicitudInterno($agencia){
    $this->db->select('pr.id_prestamo, format(pr.monto_otorgado,2) as cantidad, em.nombre, em.apellido, ag.agencia, ca.cargo, pr.id_cont_autorizado');
        $this->db->from('prestamos_internos pr');
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

  function verAutorizacionInter($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('prestamos_internos pr', 'pr.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
  }

  function aprobarInternos($code){
        $data = array(
            'fecha_otorgado' => date('Y-m-d'),
            'aprobado'       => 1,
        );
          $this->db->where('id_prestamo', $code);
          $this->db->update('prestamos_internos',$data);
          return true;
  }


 function rechazarInterno($code,$justificacion){
    $data = array(
            'fecha_fin'             => date('Y-m-d'),
            'descripcion_rechazo'   => $justificacion,
            'aprobado'              => 2,
        );
        $this->db->where('id_prestamo', $code);
        $this->db->update('prestamos_internos',$data);
        return true;
 }

 function verInterno($code){
        $this->db->select('pr.id_prestamo, em.nombre, em.apellido, em.dui, em.tel_personal,ag.agencia,ca.cargo, format(pr.monto_otorgado,2) as cantidad, pr.plazo_quincena, pr.nombre_plazo, format(pr.cuota,2) as cuota, pr.fecha_solicitado, pr.id_tipo_prestamo, pr.id_cont_autorizado,pr.descripcion_prestamo');
        $this->db->from('prestamos_internos pr');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('cargos ca ', 'ca.id_cargo=co.id_cargo');
        $this->db->where('pr.id_prestamo', $code);
        
        $query = $this->db->get();
        return $query->result();
    }

 function updateInternos($code,$data){
        $this->db->where('id_prestamo', $code);
        $this->db->update('prestamos_internos',$data);
        return true;
    }
    function updatePersonales($code,$data){
        $this->db->where('id_prestamo_personal', $code);
        $this->db->update('prestamos_personales',$data);
        return true;
    }
    function updateOrdenDesc($code,$data){
        $this->db->where('id_orden_descuento', $code);
        $this->db->update('orden_descuentos',$data);
        return true;
    }

  function notificacionesInter(){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('prestamos_internos'); 
        $this->db->where('aprobado',0);

        $result = $this->db->get();
        return $result->result();
  }

  //AQUI SE RALIZARAN LOS PAGOS QUE NO SE DESCUENTEN DE PLANILLA
  function amortizacionInterno($code){
        $this->db->select('*');
        $this->db->from('amortizacion_internos'); 
        $this->db->where('id_prestamo_interno',$code); 
        $this->db->where('estado',1);
        $this->db->order_by('fecha_abono','DESC');
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
  }

  function prestamoInterno($code){
        $this->db->select('pi.id_prestamo,pi.monto_otorgado, pi.cuota, pi.monto_pagar, pi.plazo_quincena, ta.tasa, pi.fecha_otorgado');
        $this->db->from('prestamos_internos pi');
        $this->db->join('tipo_prestamo tp', 'tp.id_tipo_prestamo=pi.id_tipo_prestamo'); 
        $this->db->join('tasa ta', 'ta.id_tasa=tp.id_tasa'); 
        $this->db->where('pi.id_prestamo ',$code);

        $result = $this->db->get();
        return $result->result(); 
  }

  function reporte_prest_interno($code){
        $this->db->select('empleados.nombre,empleados.apellido,empleados.dui,empleados.direccion1,empresa.nombre_empresa,prestamos_internos.monto_otorgado,prestamos_internos.monto_pagar,prestamos_internos.plazo_quincena,prestamos_internos.nombre_plazo,prestamos_internos.cuota,empresa.nombre_empresa,agencias.agencia,agencias.direccion,agencias.tel,cargos.cargo,prestamos_internos.id_cont_autorizado,prestamos_internos.fecha_fin,tasa.nombre as nombre_tasa,tasa.tasa');
        $this->db->from('prestamos_internos');
        $this->db->join('contrato', 'contrato.id_contrato=prestamos_internos.id_contrato'); 
        $this->db->join('empleados', 'contrato.id_empleado=empleados.id_empleado'); 
        $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa'); 
        $this->db->join('agencias', 'contrato.id_agencia=agencias.id_agencia'); 
        $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo'); 
        $this->db->join('tipo_prestamo', 'tipo_prestamo.id_tipo_prestamo=prestamos_internos.id_tipo_prestamo'); 
        $this->db->join('tasa', 'tasa.id_tasa=tipo_prestamo.id_tasa'); 
        $this->db->where('prestamos_internos.id_prestamo',$code);

        $result = $this->db->get();
        return $result->result(); 
        //select empleados.nombre,empleados.apellido,prestamos_internos.monto_otorgado,prestamos_internos.monto_pagar,prestamos_internos.plazo_quincena,prestamos_internos.nombre_plazo,prestamos_internos.cuota,empresa.nombre_empresa,agencias.agencia,cargos.cargo,prestamos_internos.id_cont_autorizado from prestamos_internos inner join contrato on ontrato.id_contrato=prestamos_internos.id_contrato inner JOIN empleados on contrato.id_empleado=empleados.id_empleado inner join empresa on empresa.id_empresa=contrato.id_empresa inner join agencias on contrato.id_agencia=agencias.id_agencia INNER join cargos on cargos.id_cargo=contrato.id_cargo where prestamos_internos.id_prestamo=4
  }
  //listado de prestamo
    function prestamoIn($empresa,$agencias,$estado_int){
      $this->db->select('em.id_empleado,pi.id_prestamo,em.nombre, em.apellido, ca.cargo, ag.agencia, pi.cuota, pi.monto_pagar, pi.monto_otorgado, pi.fecha_otorgado,pi.aprobado, pi.estado, pi.plazo_quincena ');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('prestamos_internos pi', 'pi.id_contrato=co.id_contrato');
      $this->db->where('((pi.aprobado = 1 and pi.estado = 1) OR (pi.aprobado = 1 and pi.estado = 2))');
      

      if($empresa != 'todo'){
        $this->db->where('co.id_empresa', $empresa);

      }
      if($agencias != 'todas'){
        $this->db->where('co.id_agencia', $agencias);

      }

      if($estado_int == 'todos'){
        $this->db->where('((pi.aprobado = 1 and pi.estado = 1) OR (pi.aprobado = 1 and pi.estado = 2))');
      }else if($estado_int == 1){
        $this->db->where('pi.aprobado', 1);
        $this->db->where('pi.estado', 1);
      }else if($estado_int == 2){
        $this->db->where('pi.aprobado', 1);
        $this->db->where('pi.estado', 2);
      }
      
          
      $query = $this->db->get();
      return $query->result();
  }
function prestamoPe($empresa,$agencias,$estado_per){
      $this->db->select('em.id_empleado,pe.id_prestamo_personal,em.nombre, em.apellido, ca.cargo, ag.agencia, pe.cuota, pe.monto_otorgado, pe.fecha_otorgado,pe.aprobado, pe.estado, pe.plazo_quincenas ');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('prestamos_personales pe', 'pe.id_contrato=co.id_contrato');
      //$this->db->where('((pe.aprobado = 1 and pe.estado = 1) OR (pe.aprobado = 1 and pe.estado = 2))');
      

      if($empresa != 'todo'){
        $this->db->where('co.id_empresa', $empresa);

      }
      if($agencias != 'todas'){
        $this->db->where('co.id_agencia', $agencias);

      }
      if($estado_per == 'todos'){
        $this->db->where('((pe.aprobado = 1 and pe.estado = 1) OR (pe.aprobado = 1 and pe.estado = 2))');
      }else if($estado_per == 1){
        $this->db->where('pe.aprobado', 1);
        $this->db->where('pe.estado', 1);
      }else if($estado_per == 2){
        $this->db->where('pe.aprobado', 1);
        $this->db->where('pe.estado', 2);
      }

          
      $query = $this->db->get();
      return $query->result();
  }
  function ordenDesc($empresa,$agencias,$estado_or){
      $this->db->select('od.id_orden_descuento,em.nombre, em.apellido, ca.cargo, ag.agencia, od.cuota, od.monto_total, od.fecha_inicio, od.estado ');
      $this->db->from('contrato co');
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('orden_descuentos od', 'od.id_contrato=co.id_contrato');

      if($empresa != 'todo'){
        $this->db->where('co.id_empresa', $empresa);

      }
      if($agencias != 'todas'){
        $this->db->where('co.id_agencia', $agencias);

      }
      if($estado_or == 'todos'){
        $this->db->where('(od.estado = 1 OR  od.estado = 3)');
      }else if($estado_or == 1){
        $this->db->where('(od.estado = 1)');
      }else if($estado_or == 2){
        $this->db->where('(od.estado = 3)');
      }

          
      $query = $this->db->get();
      return $query->result();
  }

  function contrato_ultimo($id_empleado){
    $this->db->select('*');
    $this->db->from('contrato');
    $this->db->where('id_empleado',$id_empleado);
    $this->db->order_by('fecha_inicio','desc');
    $this->db->limit(1);

    $query = $this->db->get();
    return $query->result();
  }

  function listaEmpresa(){
    //empresas activas de la bdd
      $this->db->select('*');
      $this->db->from('empresa'); 
      $this->db->where('estado',1); 

      $result = $this->db->get();
      return $result->result();
  }

  function lista_personales($empresa_per,$agencia_per){
    //lista de empleados que ya no estan activos de sistema y tuvieron prestamo personal
    //esto se usaba antes de pasar todo a SIGA
      $this->db->select('co.id_empleado, em.nombre, em.apellido, em.dui, ag.agencia, emp.nombre_empresa');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      $this->db->join('prestamos_personales pr', 'pr.id_contrato=co.id_contrato');
      $this->db->where('(co.estado = 0 or co.estado = 4)');
      if($empresa_per != 'todas'){
        $this->db->where('co.id_empresa', $empresa_per);
      }
      if($agencia_per != 'todas' && $agencia_per != null){
        $this->db->where('co.id_agencia', $agencia_per);
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

  function lista_intreno($empresa_int,$agencia_int){
    //lista de empleados que ya no estan activos de sistema y tuvieron prestamo interno
    //esto se usaba antes de pasar todo a SIGA
      $this->db->select('co.id_empleado, em.nombre, em.apellido, ag.agencia, emp.nombre_empresa, em.dui');
      $this->db->from('empleados em');
      $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      $this->db->join('prestamos_internos pr', 'pr.id_contrato=co.id_contrato');
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

}