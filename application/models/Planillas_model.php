<?php
class Planillas_model extends CI_Model{

  function empresas_lista(){
    $this->db->select('*');
    $this->db->from('empresa'); 
    $this->db->where('estado',1); 

    $result = $this->db->get();
    return $result->result();
  }

  function agenciasEmpresa($id){
    $this->db->select('ag.id_agencia,ag.agencia');
        $this->db->from('agencias ag');
        $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
        $this->db->where('ea.id_empresa',$id);
        $this->db->where('ea.estado',1);
        $this->db->group_by('ag.id_agencia');
        $this->db->group_by('ag.agencia');
        $this->db->order_by('ag.agencia','ASC');

        $query = $this->db->get();
        return $query->result();
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

  function ultimo($code){
    $this->db->select('*');
    $this->db->from('contrato'); 
    $this->db->where('id_empleado',$code);
    $this->db->order_by('id_contrato','ASC');
    $this->db->limit(1); 

    $result = $this->db->get();
    return $result->result();
  }

  /*$result = $this->db->query('SELECT co.id_contrato, em.id_empleado,em.nombre,em.afp,em.ipsfa,em.isss,cc.Sbase,co.fecha_inicio
     FROM empleados em INNER JOIN contrato co on co.id_empleado=em.id_empleado INNER JOIN agencias ag on ag.id_agencia=co.id_agencia INNER JOIN categoria_cargo cc on cc.id_categoria=co.id_categoria 
     where em.activo = 1 and (co.estado = 1 or co.estado = 3) and co.fecha_inicio <= "'.$ultimoDia.'" and co.id_agencia = '.$agencia_planilla.' and co.id_empresa = '.$empresa.' and ((em.afp IS NOT NULL and em.afp != "") OR (em.ipsfa IS NOT NULL and em.ipsfa != "")) and (em.isss != "" and em.isss IS NOT NULL)');*/

  //se traen los empleados vigentes de una agencia con todos los datos necesarios 
  function empleadosPlanilla($agencia_planilla,$ultimoDia,$empresa){
    $result = $this->db->query('SELECT co.id_contrato, em.id_empleado,em.nombre,em.afp,em.ipsfa,em.isss,cc.Sbase,co.fecha_inicio
     FROM empleados em INNER JOIN contrato co on co.id_empleado=em.id_empleado INNER JOIN agencias ag on ag.id_agencia=co.id_agencia INNER JOIN categoria_cargo cc on cc.id_categoria=co.id_categoria 
     where em.activo = 1 and (co.estado = 1 or co.estado = 3) and co.id_agencia = '.$agencia_planilla.' and co.id_empresa = '.$empresa.' and ((em.afp IS NOT NULL and em.afp != "") OR (em.ipsfa IS NOT NULL and em.ipsfa != "")) and (em.isss != "" and em.isss IS NOT NULL)');

    return $result->result();
  }

  //se trae los descuentos necesarios
  function descuentoLey(){
    $this->db->select('*');
    $this->db->from('descuentos_ley'); 
    $this->db->where('estado', 1);
    $this->db->where('aplica', 'Empleado');

    $result = $this->db->get();
    return $result->result();
  }

  //se trae los tramos de la renta que estan en quincena
  function rentaPlanilla(){
    $this->db->select('renta.desde, renta.hasta, renta.porcentaje,renta.cuota,renta.sobre');
    $this->db->from('renta');
    $this->db->join('tiempo_renta', 'tiempo_renta.id_tiempo=renta.id_tiempo');
    $this->db->where('renta.estado', 1); 
    $this->db->where('tiempo_renta.nombre', 'Quincena'); 

    $result = $this->db->get();
    return $result->result();
  }

  function prestamosInternos($empleado,$ultimoDia){
      $this->db->select('pi.id_prestamo, pi.plazo_quincena, pi.monto_otorgado,pi.monto_pagar,pi.cuota, ta.tasa, pi.fecha_otorgado,pi.estado');
      $this->db->from('prestamos_internos pi');
      $this->db->join('contrato co', 'co.id_contrato=pi.id_contrato');
      $this->db->join('tipo_prestamo tp', 'pi.id_tipo_prestamo=tp.id_tipo_prestamo');
      $this->db->join('tasa ta', ' ta.id_tasa=tp.id_tasa');
      $this->db->where('(pi.estado = 1 or pi.estado = 2)'); 
      $this->db->where('pi.aprobado', 1); 
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('pi.fecha_otorgado <= ', $ultimoDia);


    $result = $this->db->get();           
    return $result->result();
  }

  function verificaInternos($id_prestamo,$ultimoDia){
      $this->db->select('*');
      $this->db->from('amortizacion_internos');
      $this->db->where('(estado = 1 or estado = 2)'); 
      $this->db->where('id_prestamo_interno', $id_prestamo);
      $this->db->where('fecha_abono <=', $ultimoDia);
      $this->db->order_by('saldo_actual','ASC'); 

      $result = $this->db->get();
      return $result->result();
  }

  function saveAmortizacionInter($data){
      $result=$this->db->insert('amortizacion_internos',$data);
      return $result;
  }

  function cancelarInterno($id_prestamo,$planilla){
        $data = array(
            'fecha_fin'      => date('Y-m-d'),
            'estado'         => 0,
            'planilla'       => $planilla,
        );
          $this->db->where('id_prestamo', $id_prestamo);
          $this->db->update('prestamos_internos',$data);
          return true;
  }

  function prestamosPersonales($empleado,$ultimoDia){
      $this->db->select('pr.id_prestamo_personal, pr.monto_otorgado, pr.plazo_quincenas, pr.cuota, tp.porcentaje, pr.fecha_otorgado,pr.estado');
      $this->db->from('prestamos_personales pr');
      $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
      $this->db->join('tipo_prestamos_personales tp', ' tp.id_prest_personales=pr.id_prest_personales');
      $this->db->where('((pr.estado = 1 and pr.aprobado = 1) or (pr.estado = 2 and pr.aprobado = 1))'); 
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('pr.fecha_otorgado <=', $ultimoDia);

      $result = $this->db->get();
      return $result->result();
  }

  function verificaPersonales($id_prestamo_personal,$ultimoDia){
      $this->db->select('*');
      $this->db->from('amortizacion_personales');
      $this->db->where('(estado = 1 or estado = 2)'); 
      $this->db->where('id_prestamo_personal', $id_prestamo_personal);
      $this->db->where('fecha_abono <=', $ultimoDia);
      $this->db->order_by('fecha_abono','DESC'); 

      $result = $this->db->get();
      return $result->result();
  }

  function saveAmortizacionPerso($data){
    $result=$this->db->insert('amortizacion_personales',$data);
    return $result;
  }

  function cancelarPersonal($id_prestamo_personal,$planilla){
    $data = array(
          'fecha_fin'      => date('Y-m-d'),
          'estado'         => 0,
          'planilla'       => $planilla,
    );
    $this->db->where('id_prestamo_personal', $id_prestamo_personal);
    $this->db->update('prestamos_personales',$data);
    return true;
  }

  function viaticosActuales($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('vi.*');
      $this->db->from('viaticos vi');
      $this->db->join('contrato co', 'co.id_contrato=vi.id_contrato');
      $this->db->where('vi.estado', 1);    
      $this->db->where('vi.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');   
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function viaticosVigentes($primerDia,$id_empleado){
      $this->db->select('vi.*');
      $this->db->from('viaticos vi');
      $this->db->join('contrato co', 'co.id_contrato=vi.id_contrato');
      $this->db->where('vi.estado', 1);    
      $this->db->where('vi.fecha_aplicacion <',$primerDia);   
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function restaQuincena($id_viaticos){

    $this->db->query('UPDATE viaticos set quincenas_restante = quincenas_restante - 1 WHERE id_viaticos = '.$id_viaticos);
    return true;
  }

  function cancelarViatico($id_viaticos,$planilla,$ultimoDia){
    $data = array(
          'estado'         => 0,
          'fecha_fin'      => $ultimoDia,
          'planilla'       => $planilla,
    );
    $this->db->where('id_viaticos', $id_viaticos);
    $this->db->update('viaticos',$data);
    return true;
  }

  //NO10012023 se modifico bonos para que traiga las gratificaciones
  function bonoActual($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('bonos.id_bono,bonos.cantidad');
      $this->db->from('bonos');
      $this->db->join('contrato', 'bonos.id_contrato=contrato.id_contrato');
      $this->db->where('bonos.estado', 2);    
      $this->db->where('bonos.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('contrato.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarBono($id_bono,$planilla){
    $data = array(
          'estado'         => 0,
          'planilla'       => $planilla,
    );
    $this->db->where('id_bono', $id_bono);
    $this->db->update('bonos',$data);
    return true;
  }

  function comision($id_empleado,$fecha){
      $this->db->select('cm.*');
      $this->db->from('comisiones cm');
      $this->db->join('contrato co', 'co.id_contrato=cm.id_contrato');
      $this->db->where('cm.estado', 1);         
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('cm.mes', $fecha);

      $result = $this->db->get();
      return $result->result();
  }

  function sum_comision($id_empleado,$mes,$num_quincena){
      $this->db->select('SUM(bonificacion.bono) as bono');
      $this->db->from('bonificacion');
      $this->db->join('contrato', 'contrato.id_contrato=bonificacion.id_contrato');
      $this->db->where('contrato.id_empleado', $id_empleado);
      $this->db->where('bonificacion.mes', $mes);
      $this->db->where('bonificacion.quincena', $num_quincena);
      $this->db->where('bonificacion.estado_control ', 1);         

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarComision($id_comisiones,$ultimoDia){
    $data = array(
          'estado'         => 2,
          'planilla'       => 1,
          'fecha_fin'      => $ultimoDia,
    );
    $this->db->where('id_comisiones', $id_comisiones);
    $this->db->update('comisiones',$data);
    return true;
  }

    //obtener los tipos de bonos/comisiones para la boleta 
  function tipo_comisiones_boleta($id_empleado,$mes,$num_quincena){
    $this->db->select('bo.bono, bo.estado');
    $this->db->from('bonificacion bo');
    $this->db->join('contrato co', 'co.id_contrato=bo.id_contrato');
    $this->db->where('co.id_empleado', $id_empleado);
    $this->db->where('bo.mes', $mes);
    $this->db->where('bo.quincena', $num_quincena);
    $this->db->where('bo.estado_control ', 1); 

     $result = $this->db->get();
      return $result->result();

   }

  function anticiposActuales($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('an.id_anticipos, an.monto_otorgado');
      $this->db->from('anticipos an');
      $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
      $this->db->where('an.estado', 1);    
      $this->db->where('an.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarAnticipo($id_anticipos,$planilla){
    $data = array(
          'estado'         => 0,
          'planilla'       => $planilla,
    );
    $this->db->where('id_anticipos', $id_anticipos);
    $this->db->update('anticipos',$data);
    return true;
  }

  function vacacionesQuincena($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('va.*');
      $this->db->from('vacaciones va');
      $this->db->join('contrato co', 'co.id_contrato=va.id_contrato');
      $this->db->where('va.estado', 1);    
      $this->db->where('va.aprobado', 1);    
      $this->db->where('va.fecha_aprobado BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarVacaciones($id_vacacion,$fecha_actual){
    $data = array(
          'fecha_eliminado' => $fecha_actual,
          'estado'          => 0,
    );
    $this->db->where('id_vacacion', $id_vacacion);
    $this->db->update('vacaciones',$data);
    return true;
  }

  function horasExtras($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('he.*');
      $this->db->from('horas_extras he');
      $this->db->join('contrato co', 'co.id_contrato=he.id_contrato');
      $this->db->where('he.cancelado', 0);        
      $this->db->where('he.fecha BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarHorasExtras($id_horas){
    $data = array(
          'cancelado'          => 1,
    );
    $this->db->where('id_horas', $id_horas);
    $this->db->update('horas_extras',$data);
    return true;
  }

  function horasDescuento($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('dh.id_descuento_horas,dh.cantidad_horas,dh.cantidad_min,dh.a_descontar');
      $this->db->from('descuentos_horas dh');
      $this->db->join('contrato co', 'co.id_contrato=dh.id_contrato');
      $this->db->where('dh.cancelado', 0);
      $this->db->where('dh.estado2 != 3 and dh.estado2 != 5');        
      $this->db->where('dh.fecha BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function horasPermiso($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('dh.id_descuento_horas,dh.cantidad_horas,dh.cantidad_min,dh.a_descontar');
      $this->db->from('descuentos_horas dh');
      $this->db->join('contrato co', 'co.id_contrato=dh.id_contrato');
      $this->db->where('dh.cancelado', 0);        
      $this->db->where('dh.estado2', 5);        
      $this->db->where('dh.fecha BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');     
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function descuentoHerramienta($id_empleado,$ultimoDia){
      $this->db->select('de.id_descuento_herramienta,de.couta,de.cantidad,de.cantidad,');
      $this->db->from('descuento_herramienta de');
      $this->db->join('contrato co', 'co.id_contrato=de.id_contrato');
      $this->db->where('de.estado', 1);            
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('de.fecha_ingreso <= "'.$ultimoDia.'"');            

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarHorasDesc($id_descuento_horas){
    $data = array(
          'cancelado'          => 1,
    );
    $this->db->where('id_descuento_horas', $id_descuento_horas);
    $this->db->update('descuentos_horas',$data);
    return true;
  }

  function verPlanilla($id_agencia=null, $primerDia, $ultimoDia, $empresa,$estado=null){
      $this->db->select('ep.nombre_empresa,ep.id_empresa, em.nombre, em.apellido, ag.agencia, pl.*, ');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');
      $this->db->join('empleados em', 'co.id_empleado=em.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');   
      $this->db->join('empresa ep', 'ep.id_empresa=co.id_empresa');   
      $this->db->where('pl.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');
      if($estado==null){
        $this->db->where('pl.estado = 1');
      }else{
        $this->db->where('pl.estado = 2');
      }     
      $this->db->where('co.id_agencia', $id_agencia);
      $this->db->where('co.id_empresa', $empresa);
      $this->db->order_by('em.nombre','asc');
      //$this->db->where('((pl.isss > 0 and pl.afp_ipsfa > 0) or pl.viaticos > 0)');
      //$this->db->where('pl.afp_ipsfa >', 0);

      $result = $this->db->get();
      return $result->result();
  }

  function ordenesDescuento($id_empleado,$ultimoDia){
      $this->db->select('od.id_orden_descuento, od.monto_total, od.cuota');
      $this->db->from('orden_descuentos od');
      $this->db->join('contrato co', 'co.id_contrato=od.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);         
      $this->db->where('od.estado', 1);
      $this->db->where('od. fecha_inicio <= "'.$ultimoDia.'"');

      $result = $this->db->get();
      return $result->result();
  }
  function verificaOrden($id_orden_descuento){
      $this->db->select('*');
      $this->db->from('orden_descuento_abono'); 
      $this->db->where('id_orden_descuento', $id_orden_descuento);
      $this->db->order_by('id_orden_abono','DESC'); 

      $result = $this->db->get();
      return $result->result();
  }

  function saveOrdenDes($data){
      $result=$this->db->insert('orden_descuento_abono',$data);
      return $result;
  }

  function cancelarOrden($id_orden_descuento,$fecha_actual,$planilla){
    $data = array(
          'fecha_finalizacion'    => $fecha_actual,  
          'descripcion'           => 'Cancelado',  
          'estado'                => 0,    
          'planilla'              => $planilla,    
                  
      );
    $this->db->where('id_orden_descuento', $id_orden_descuento);
    $this->db->update('orden_descuentos',$data);
    return true;

  }

  function incacipacidades($id_empleado){
      $this->db->select('pe.*');
      $this->db->from('permisos_empleados pe');
      $this->db->join('contrato co', 'co.id_contrato=pe.id_contrato');
      $this->db->where('pe.tipo_permiso', 7);
      $this->db->where('pe.estado', 2);             
      $this->db->where('co.id_empleado', $id_empleado);
      //$this->db->where('pe.desde >=', $primerDia);
      //$this->db->where('pe.hasta <=', $ultimoDia);

      $result = $this->db->get();
      return $result->result();
  }

  function savePlanilla($data){
    $result=$this->db->insert('planilla',$data);
    return $result;
  }

  function validarExistencia($id_empleado,$primerDia,$ultimoDia){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');            
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('pl.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      //$this->db->where('((pl.isss > 0 and pl.afp_ipsfa > 0) or pl.viaticos > 0)');
      //$this->db->where('pl.afp_ipsfa >', 0);  

      $result = $this->db->get();
      return $result->result();
  }


  function validarPlanillas($id_contrato,$mes,$num_quincena){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('planilla'); 
      $this->db->where('id_contrato', $id_contrato);
      $this->db->where('mes', $mes);
      $this->db->where('tiempo', $num_quincena);
      $this->db->where('estado', 1);
      $this->db->where('(aprobado = 0 or aprobado = 1)');
      //$this->db->or_where('aprobado', 1);

      $result = $this->db->get();
      return $result->result();
  }

  function validarVacaciones($id_empleado,$primerDia,$ultimoDia){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('vacaciones');
      $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');          
      $this->db->where('contrato.id_empleado', $id_empleado);
      $this->db->where('vacaciones.aprobado', 1);
      $this->db->where('(vacaciones.estado = 1 or vacaciones.estado = 2)');
      $this->db->where('vacaciones.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');   

      $result = $this->db->get();
      return $result->result();
  }

  function validarMaternidad($id_empleado){
      $this->db->select('pe.hasta');
      $this->db->from('permisos_empleados pe');
      $this->db->join('contrato co', 'co.id_contrato=pe.id_contrato');          
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('pe.maternidad', 1);
      $this->db->where('pe.tipo_permiso', 9);

      $result = $this->db->get();
      return $result->result();
  }

  function contratosInactivos($agencia_planilla,$primerDia,$ultimoDia){
      $this->db->select('pl.id_contrato, pl.fecha_aplicacion, co.estado, em.activo, co.fecha_fin');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');    
      $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');    
      $this->db->where('co.id_agencia', $agencia_planilla);
      $this->db->where('pl.fecha_aplicacion  BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');   

      $result = $this->db->get();
      return $result->result();
  }

  function quitarPlanilla($id_contrato,$primerDia,$ultimoDia){
     $data = array(
          'estado'                => 0,                  
      );
    $this->db->where('id_contrato', $id_contrato);
    $this->db->where('fecha_aplicacion >= "'.$primerDia.'"');   
    $this->db->update('planilla',$data);
    return true;
  }

  function autorizarPlanilla($agencia_planilla, $primerDia, $ultimoDia, $empresa){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');          
      $this->db->where('pl.estado', 1);
      $this->db->where('pl.aprobado', 0);
      $this->db->where('co.id_agencia', $agencia_planilla);
      $this->db->where('pl.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
      $this->db->where('co.id_empresa', $empresa);   

      $result = $this->db->get();
      return $result->result();
  }

  function autorizarPlanillaGob($agencia_planilla, $primerDia, $ultimoDia, $empresa){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('planilla pl');
      $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');          
      $this->db->where('pl.estado', 2);
      $this->db->where('pl.aprobado', 0);
      $this->db->where('co.id_agencia', $agencia_planilla);
      $this->db->where('pl.fecha_aplicacion BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');
      $this->db->where('co.id_empresa', $empresa);   

      $result = $this->db->get();
      return $result->result();
  }

  function aprobarPlanillas($diaUno,$diaUltimo,$agencia,$empresa){
        $this->db->query('UPDATE planilla, contrato set planilla.aprobado = 1 where planilla.id_contrato=contrato.id_contrato and planilla.estado=1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and planilla.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

         //Consulta para regresar las incapacidad estado activo para que no siga cancelado
        $this->db->query('UPDATE viaticos_efectivos,viaticos_carteras, contrato SET viaticos_efectivos.estado = 1 WHERE viaticos_efectivos.id_viaticos_cartera=viaticos_carteras.id_viaticos_cartera and viaticos_efectivos.id_contrato=contrato.id_contrato and viaticos_efectivos.estado = 0 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and viaticos_efectivos.fecha_aplicacion >= "'.$diaUno.'" and viaticos_efectivos.fecha_aplicacion <= "'.$diaUltimo.'"');

        return true;
    }

    function aprobarPlanillasGob($diaUno,$diaUltimo,$agencia,$empresa){
        $this->db->query('UPDATE planilla, contrato set planilla.aprobado = 1 where planilla.id_contrato=contrato.id_contrato and planilla.estado=2 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and planilla.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

        return true;
    }

  function aprobarPagoPrestamoPer($diaUno,$diaUltimo,$agencia,$empresa){

   $this->db->query('UPDATE amortizacion_personales, prestamos_personales, contrato set amortizacion_personales.estado = 1 WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = 1  and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_personales.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

        return true;
  }

  function aprobarPagoPrestamoInt($diaUno,$diaUltimo,$agencia,$empresa){

    $this->db->query('UPDATE amortizacion_internos, prestamos_internos, contrato set amortizacion_internos.estado = 1 where amortizacion_internos.id_amortizacion=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_internos.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

        return true;
  }

  function empresas($permiso,$agencia){
    $this->db->select('em.id_empresa, em.nombre_empresa');
      $this->db->from('empresa em');
      $this->db->join('empresa_agencia ea', 'ea.id_empresa=em.id_empresa');          
      $this->db->join('agencias ag', 'ag.id_agencia=ea.id_agencia');
      if($permiso != 1){
        $this->db->where('ag.id_agencia', $agencia);
      }                
      $this->db->group_by('em.id_empresa');
      $this->db->group_by('em.nombre_empresa');
      $result = $this->db->get();
      return $result->result();
  }

  function updateFaltante($id_descuento_herramienta, $saldoH){
     $data = array(
          'saldo'    => $saldoH,  
                  
      );
    $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
    $this->db->update('descuento_herramienta',$data);
    return true;
  }

   function cancelarDescuentoH($id_descuento_herramienta){
     $data = array(
          'estado'    => 0,  
                  
      );
    $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
    $this->db->update('descuento_herramienta',$data);
    return true;
  }

  function faltante($id_empleado,$primerDia,$ultimoDia){
      $this->db->select('fa.id_faltante,fa.couta');
      $this->db->from('faltante fa');
      $this->db->join('contrato co', 'co.id_contrato=fa.id_contrato');
      $this->db->where('fa.estado', 1);            
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('fa.fecha_aplicada BETWEEN"'.$primerDia.'" and "'.$ultimoDia.'"');

      $result = $this->db->get();
      return $result->result();
  }
  function cancelarFaltante($id_faltante,$planilla){
     $data = array(
          'estado'    => 0,
          'planilla'  => $planilla,  
                  
      );
    $this->db->where('id_faltante', $id_faltante);
    $this->db->update('faltante',$data);
    return true;
  }

  function siguenteContrato($empleados,$contrato){
      $this->db->select('co.*, cat.Sbase');
      $this->db->from('contrato co'); 
      $this->db->join('categoria_cargo cat', 'cat.id_categoria=co.id_categoria');
      $this->db->where('co.id_empleado', $empleados);
      $this->db->where('co.id_contrato >', $contrato);
      $this->db->limit(1);

      $result = $this->db->get();
      return $result->result();
  }

  function verificarHerramienta($id_descuento_herramienta){
      $this->db->select('*');
      $this->db->from('pagos_descuento_herramienta');
      $this->db->where('estado', 1); 
      $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
      $this->db->order_by('id_pago','DESC'); 

      $result = $this->db->get();
      return $result->result();
  }

  function savePagoHer($data){
      
      $result=$this->db->insert('pagos_descuento_herramienta',$data);
      return $result;
  }

  function cancelarDesHer($id_descuento_herramienta,$planilla,$ultimoDia){
    $data = array(
          'estado'        => 0,
          'fecha_fin'     => $ultimoDia,
          'planilla'      => $planilla,  
                  
      );
    $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
    $this->db->update('descuento_herramienta',$data);
    return true;
  }

  function conteoPlanilla($agencia_planilla,$empresa,$num_quincena,$mes,$estado=null){
    $this->db->select('COUNT(*) as conte');
    $this->db->from('contrato co'); 
    $this->db->join('planilla pl', 'pl.id_contrato=co.id_contrato');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('empresa em', 'em.id_empresa=co.id_empresa');
    $this->db->where('pl.mes', $mes);
    if($estado == null){
      $this->db->where('pl.estado', 1);
    }else{
      $this->db->where('pl.estado', 2);
    }
    $this->db->where('co.id_empresa', $empresa);
    $this->db->where('co.id_agencia', $agencia_planilla);
    $this->db->where('pl.tiempo', $num_quincena);
    //$this->db->where('((pl.isss > 0 and pl.afp_ipsfa > 0) or pl.viaticos > 0)');
    //$this->db->where('pl.afp_ipsfa >', 0);

    $result = $this->db->get();
    return $result->result();
  }

  function planillaReporte($empresa,$agencias,$primerDia,$ultimoDia){
    $this->db->select('COUNT(*) as conteo, ag.agencia, em.nombre, em.apellido, em.dui, ca.cargo, SUM(pl.salario_quincena) as quincena, SUM(pl.dias) as dias, SUM(pl.sueldo_bruto) as bruto, SUM(pl.bono + pl.comision) as bono, SUM(pl.isss) as isss, SUM(pl.afp_ipsfa) as afp, SUM(pl.total_pagar) as total');
    $this->db->from('contrato co'); 
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
    $this->db->join('planilla pl', 'pl.id_contrato=co.id_contrato');

    if($agencias != 'todas'){
      $this->db->where('co.id_agencia', $agencias);
    }
    if($empresa != 'todas'){
      $this->db->where('co.id_empresa', $empresa);
    }

    $this->db->where('pl.aprobado', 1);
    $this->db->where('pl.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 

    $this->db->group_by('ag.agencia');
    $this->db->group_by('em.nombre');
    $this->db->group_by('em.apellido');
    $this->db->group_by('em.dui');
    $this->db->group_by('ca.cargo');

    $result = $this->db->get();
    return $result->result();
  }

  function diasTrabajados($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('dh.id_descuento_horas,dh.a_descontar,dh.cantidad_horas');
      $this->db->from('descuentos_horas dh'); 
      $this->db->join('contrato co', 'co.id_contrato=dh.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('dh.cancelado', 0);
      $this->db->where('dh.estado2', 3);
      $this->db->where('dh.fecha BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      $result = $this->db->get();
      return $result->result();
  }

  function controlPlanillas($id_contrato,$agencia,$empresa,$hora,$fecha,$diaUltimo,$estado,$bloqueo){
     $data = array(
            'id_contrato'        => $id_contrato, 
            'id_agencia'         => $agencia, 
            'id_empresa'         => $empresa, 
            'hora'               => $hora, 
            'fecha'              => $fecha, 
            'fecha_quincena'     => $diaUltimo, 
            'estado'             => $estado, 
            'bloqueo'            => $bloqueo,
                  
      );
      $result=$this->db->insert('control_planilla',$data);
      return $result;
  }
  
  function reporteControl($empresa,$agencias,$primerDia,$ultimoDia){
     $this->db->select('em.nombre, em.apellido, ca.cargo, ag.agencia, emp.nombre_empresa, cp.fecha_quincena, cp.fecha, cp.hora, cp.estado');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('control_planilla cp', 'cp.id_contrato=co.id_contrato');
      $this->db->join('empresa emp', 'emp.id_empresa=cp.id_empresa');
      $this->db->join('agencias ag', 'ag.id_agencia=cp.id_agencia');

      if($agencias != 'todas'){
        $this->db->where('cp.id_agencia', $agencias);
      }
      if($empresa != 'todas'){
        $this->db->where('cp.id_empresa', $empresa);
      }
      if($primerDia != null && $ultimoDia != null){
        $this->db->where('cp.fecha_quincena BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      }

      $result = $this->db->get();
      return $result->result();
  }

  function bloqueoControl($empresa,$agencias,$primerDia,$ultimoDia){
     $this->db->select('em.nombre, em.apellido, ca.cargo, ag.agencia, emp.nombre_empresa, cp.fecha_quincena, cp.id_control, cp.bloqueo');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('control_planilla cp', 'cp.id_contrato=co.id_contrato');
      $this->db->join('empresa emp', 'emp.id_empresa=cp.id_empresa');
      $this->db->join('agencias ag', 'ag.id_agencia=cp.id_agencia');
      $this->db->where('(cp.estado = 1 or cp.estado = 5)');
      if($agencias != 'todas'){
        $this->db->where('cp.id_agencia', $agencias);
      }
      if($empresa != 'todas'){
        $this->db->where('cp.id_empresa', $empresa);
      }
      if($primerDia != null && $ultimoDia != null){
        $this->db->where('cp.fecha_quincena BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      }

      $result = $this->db->get();
      return $result->result();
  }

  function updateControl($code,$data){
      $this->db->where('id_control', $code);
      $this->db->update('control_planilla',$data);
      return true;
  }

  function revisarBloqueo($agencia,$empresa,$ultimoDia){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('control_planilla'); 
      $this->db->where('id_agencia', $agencia);
      $this->db->where('id_empresa', $empresa);
      $this->db->where('fecha_quincena', $ultimoDia);
      $this->db->where('(bloqueo = 1 OR bloqueo = 3)');

      $result = $this->db->get();
      return $result->result();
  }

  function getMaternidad($primerDia,$ultimoDia,$id_empleado){
      $this->db->select('ma.fecha_fin');
      $this->db->from('maternidad ma'); 
      $this->db->join('contrato co', 'co.id_contrato=ma.id_contrato');
      $this->db->where('ma.estado', 0);
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('ma.fecha_fin BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function controlUp($agencia,$empresa,$diaUno,$diaUltimo,$planillaCl=null){
    if($planillaCl==null){
      $estado = 3;
      $estado2 =  1;
    }else{
      $estado = 7;
      $estado2 =  5;
    }

    $data = array(     
      'estado'         => $estado,
      'bloqueo'        => 0,
    );
    $this->db->where('estado', $estado2);
    $this->db->where('id_agencia', $agencia);
    $this->db->where('id_empresa', $empresa);
    $this->db->where('fecha_quincena BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');
    $this->db->update('control_planilla',$data);
    return true;
  }

  function buscarbloqueo($agencia_planilla,$ultimoDia,$empresa){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('control_planilla'); 
      $this->db->where('id_empresa', $empresa);
      $this->db->where('id_agencia', $agencia_planilla);
      $this->db->where('fecha_quincena', $ultimoDia);
      $this->db->where('(bloqueo = 2 or bloqueo = 3)');

      $result = $this->db->get();
      return $result->result();
  }

  function buscarbloqueoGob($agencia_planilla,$ultimoDia,$empresa){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('control_planilla'); 
      $this->db->where('id_empresa', $empresa);
      $this->db->where('id_agencia', $agencia_planilla);
      $this->db->where('fecha_quincena', $ultimoDia);
      $this->db->where('(bloqueo = 6 or bloqueo = 7)');

      $result = $this->db->get();
      return $result->result();
  }

  function incapacidadesEmpleados($id_empleado){
      $this->db->select('inc.*');
      $this->db->from('incapacidad inc'); 
      $this->db->join('contrato co', 'co.id_contrato=inc.id_contrato');
      $this->db->where('inc.estado', 1);
      $this->db->where('inc.planilla', 1);
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->order_by('hasta','ASC');

      $result = $this->db->get();
      return $result->result();
  }


  //DESDE AQUI EMPIEZA EL APARTADO DE ELIMINAR LA PLANILLA
  //METODO PARA CAMBIAR LOS ESTADOS DE LAS TABLAS QUE SE NECESITAN
    function regresarPlanilla($mesAnt,$diaUno,$diaUltimo,$agencia,$empresa){
      //Metodo para regresar las comisiones al estado de aprobacion
      $this->db->query('UPDATE comisiones, contrato set comisiones.estado = 1 WHERE contrato.id_contrato=comisiones.id_contrato and comisiones.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and comisiones.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los bonos normales a sus estado de aprobacion
      $this->db->query('UPDATE bonos, contrato SET bonos.estado = 1 WHERE bonos.planilla = 1 and bonos.id_contrato=contrato.id_contrato and bonos.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and bonos.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los prestamos internos al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_internos, contrato SET prestamos_internos.estado = 1 WHERE prestamos_internos.planilla = 1 and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and prestamos_internos.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los prestamos personales al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_personales, contrato SET prestamos_personales.estado = 1 WHERE prestamos_personales.planilla = 1 and prestamos_personales.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and prestamos_personales.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los Viaticos al estado activo para que no siga cancelado
      $this->db->query('UPDATE viaticos, contrato SET viaticos.estado = 1, viaticos.quincenas_restante = viaticos.quincenas_restante + 1 WHERE viaticos.planilla = 1 AND viaticos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and viaticos.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los Anticipos al estado activo para que no siga cancelado
      $this->db->query('UPDATE anticipos, contrato set anticipos.estado = 1 where anticipos.planilla = 1 and anticipos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las Horas Extras al estado activo para que no siga cancelado
      $this->db->query('UPDATE horas_extras, contrato SET horas_extras.cancelado = 1 WHERE horas_extras.cancelado = 1 and horas_extras.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and horas_extras.fecha BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las Horas de Descuento al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuentos_horas, contrato SET descuentos_horas.cancelado = 0 WHERE descuentos_horas.cancelado = 1 and descuentos_horas.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and descuentos_horas.fecha BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los decuentos por herramientas al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuento_herramienta, contrato set descuento_herramienta.estado = 1 where descuento_herramienta.planilla = 1 and descuento_herramienta.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and descuento_herramienta.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE faltante, contrato SET faltante.estado = 1 WHERE faltante.planilla = 1 and faltante.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and faltante.fecha_aplicada BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las ordenes de descuento estado activo para que no siga cancelado
      $this->db->query('UPDATE orden_descuentos, contrato SET orden_descuentos.estado = 1 WHERE orden_descuentos.planilla = 1 and orden_descuentos.id_contrato=contrato.id_contrato AND contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and orden_descuentos.fecha_finalizacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las incapacidad estado activo para que no siga cancelado
      $this->db->query('UPDATE incapacidad, contrato SET incapacidad.estado = 1 WHERE incapacidad.estado = 2 and incapacidad.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and incapacidad.fecha_planilla BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      /*$this->db->query('UPDATE amortizacion_personales,prestamos_personales,contrato SET amortizacion_personales.estado = 0 WHERE amortizacion_personales.estado = 1 and amortizacion_personales.planilla = 1 and amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_personales.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      $this->db->query('UPDATE amortizacion_internos,prestamos_internos,contrato SET amortizacion_internos.estado = 0 WHERE amortizacion_internos.estado = 1 and amortizacion_internos.planilla = 1 and amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_internos.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');*/

        return true;
    }

    function regresar_planilla($id_empleado,$diaUno,$diaUltimo){
      //Metodo para regresar las comisiones al estado de aprobacion
      $this->db->query('UPDATE comisiones, contrato set comisiones.estado = 1 WHERE contrato.id_contrato=comisiones.id_contrato and comisiones.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and comisiones.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los bonos normales a sus estado de aprobacion
      $this->db->query('UPDATE bonos, contrato SET bonos.planilla = 0, bonos.estado = 2 WHERE bonos.planilla = 1 and bonos.id_contrato=contrato.id_contrato and bonos.estado = 0 and contrato.id_empleado = "'.$id_empleado.'" and bonos.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los prestamos internos al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_internos, contrato SET prestamos_internos.estado = 1 WHERE prestamos_internos.planilla = 1 and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and prestamos_internos.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los prestamos personales al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_personales, contrato SET prestamos_personales.estado = 1 WHERE prestamos_personales.planilla = 1 and prestamos_personales.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and prestamos_personales.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los Viaticos al estado activo para que no siga cancelado
      $this->db->query('UPDATE viaticos, contrato SET viaticos.estado = 1, viaticos.quincenas_restante = viaticos.quincenas_restante + 1 WHERE viaticos.planilla = 1 AND viaticos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and viaticos.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los Anticipos al estado activo para que no siga cancelado
      $this->db->query('UPDATE anticipos, contrato set anticipos.estado = 1 where anticipos.planilla = 1 and anticipos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las Horas Extras al estado activo para que no siga cancelado
      $this->db->query('UPDATE horas_extras, contrato SET horas_extras.cancelado = 1 WHERE horas_extras.cancelado = 1 and horas_extras.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and horas_extras.fecha BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las Horas de Descuento al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuentos_horas, contrato SET descuentos_horas.cancelado = 0 WHERE descuentos_horas.cancelado = 1 and descuentos_horas.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and descuentos_horas.fecha BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los decuentos por herramientas al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuento_herramienta, contrato set descuento_herramienta.estado = 1 where descuento_herramienta.planilla = 1 and descuento_herramienta.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and descuento_herramienta.fecha_fin BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE faltante, contrato SET faltante.estado = 1 WHERE faltante.planilla = 1 and faltante.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and faltante.fecha_aplicada BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las ordenes de descuento estado activo para que no siga cancelado
      $this->db->query('UPDATE orden_descuentos, contrato SET orden_descuentos.estado = 1 WHERE orden_descuentos.planilla = 1 and orden_descuentos.id_contrato=contrato.id_contrato AND contrato.id_empleado = "'.$id_empleado.'" and orden_descuentos.fecha_finalizacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para regresar las incapacidad estado activo para que no siga cancelado
      $this->db->query('UPDATE incapacidad, contrato SET incapacidad.estado = 1 WHERE incapacidad.estado = 2 and incapacidad.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and incapacidad.fecha_planilla BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

        return true;
    }

    function eliminar_pagos_p($diaUno,$diaUltimo,$agencia,$empresa){
      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('UPDATE amortizacion_personales,prestamos_personales,contrato SET amortizacion_personales.estado = 0 WHERE amortizacion_personales.estado = 1 and amortizacion_personales.planilla = 1 and amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_personales.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      $this->db->query('UPDATE amortizacion_internos,prestamos_internos,contrato SET amortizacion_internos.estado = 0 WHERE amortizacion_internos.estado = 1 and amortizacion_internos.planilla = 1 and amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_internos.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

        return true;
    }

    //METODO DONDE SE ELIMINAN PERMANENTEMENTE LOS DATOS DE LA PLANILLA
    function eliminarPagos($diaUno,$diaUltimo,$agencia,$empresa){
      //Consulta para eliminar los pagos de los prestamos internos que se hacen en la planilla
      $this->db->query('DELETE amortizacion_internos.* FROM amortizacion_internos, prestamos_internos, contrato WHERE amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and amortizacion_internos.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_internos.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('DELETE amortizacion_personales.* FROM amortizacion_personales, prestamos_personales, contrato WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and amortizacion_personales.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de las ordenes de descuento que se hacen en la planilla
      $this->db->query('DELETE orden_descuento_abono.* FROM orden_descuento_abono, orden_descuentos, contrato WHERE orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento and orden_descuentos.id_contrato=contrato.id_contrato and orden_descuento_abono.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and orden_descuento_abono.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de los descuentos de las herramientas que se hacen en la planilla
      $this->db->query('DELETE pagos_descuento_herramienta.* FROM pagos_descuento_herramienta, descuento_herramienta, contrato WHERE pagos_descuento_herramienta.id_descuento_herramienta=descuento_herramienta.id_descuento_herramienta and descuento_herramienta.id_contrato=contrato.id_contrato and pagos_descuento_herramienta.estado = 1 and pagos_descuento_herramienta.planilla = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los datos de la tabla planilla que no se necesitan
      $this->db->query('DELETE planilla.* FROM planilla, contrato WHERE planilla.id_contrato=contrato.id_contrato and planilla.estado = 1 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and planilla.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

       //Consulta para eliminar los datos de la tabla de viaticos_efectivos
      $this->db->query('DELETE viaticos_efectivos.* FROM viaticos_efectivos,viaticos_carteras, contrato WHERE viaticos_efectivos.id_viaticos_cartera=viaticos_carteras.id_viaticos_cartera and viaticos_efectivos.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and viaticos_efectivos.fecha_aplicacion >= "'.$diaUno.'" and viaticos_efectivos.fecha_aplicacion <= "'.$diaUltimo.'"');

      return true;

    }

    function eliminar_pagos($id_empleado,$diaUno,$diaUltimo){
      //Consulta para eliminar los pagos de los prestamos internos que se hacen en la planilla
      $this->db->query('DELETE amortizacion_internos.* FROM amortizacion_internos, prestamos_internos, contrato WHERE amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and amortizacion_internos.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and amortizacion_internos.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('DELETE amortizacion_personales.* FROM amortizacion_personales, prestamos_personales, contrato WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and amortizacion_personales.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de las ordenes de descuento que se hacen en la planilla
      $this->db->query('DELETE orden_descuento_abono.* FROM orden_descuento_abono, orden_descuentos, contrato WHERE orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento and orden_descuentos.id_contrato=contrato.id_contrato and orden_descuento_abono.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and orden_descuento_abono.fecha_abono BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los pagos de los descuentos de las herramientas que se hacen en la planilla
      $this->db->query('DELETE pagos_descuento_herramienta.* FROM pagos_descuento_herramienta, descuento_herramienta, contrato WHERE pagos_descuento_herramienta.id_descuento_herramienta=descuento_herramienta.id_descuento_herramienta and descuento_herramienta.id_contrato=contrato.id_contrato and pagos_descuento_herramienta.estado = 1 and pagos_descuento_herramienta.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      //Consulta para eliminar los datos de la tabla planilla que no se necesitan
      $this->db->query('DELETE planilla.* FROM planilla, contrato WHERE planilla.id_contrato=contrato.id_contrato and planilla.estado = 1 and contrato.id_empleado = "'.$id_empleado.'" and planilla.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

       //Consulta para eliminar los datos de la tabla de viaticos_efectivos
      $this->db->query('DELETE viaticos_efectivos.* FROM viaticos_efectivos,viaticos_carteras, contrato WHERE viaticos_efectivos.id_viaticos_cartera=viaticos_carteras.id_viaticos_cartera and viaticos_efectivos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and viaticos_efectivos.fecha_aplicacion >= "'.$diaUno.'" and viaticos_efectivos.fecha_aplicacion <= "'.$diaUltimo.'"');

      return true;

    }

    //FUNCION PARA REGRESAR LAS COSAS DE LAS PERSONAS QUE NO SALGAN EN PLANILLA
    function regrePlanillaEmple($fecha,$primerDia,$ultimoDia,$id_empleado){
      //Metodo para regresar las comisiones al estado de aprobacion
      $this->db->query('UPDATE comisiones, contrato set comisiones.estado = 1 WHERE contrato.id_contrato=comisiones.id_contrato and comisiones.planilla = 1 and comisiones.mes = "'.$fecha.'" and contrato.id_empleado = "'.$id_empleado.'"');

      //Consulta para regresar los bonos normales a sus estado de aprobacion
      $this->db->query('UPDATE bonos, contrato SET bonos.estado = 1 WHERE bonos.id_contrato=contrato.id_contrato and bonos.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and bonos.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los prestamos internos al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_internos, contrato SET prestamos_internos.estado = 1 WHERE prestamos_internos.planilla = 1 and prestamos_internos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and prestamos_internos.fecha_fin BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los prestamos personales al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_personales, contrato SET prestamos_personales.estado = 1 WHERE prestamos_personales.planilla = 1 and prestamos_personales.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and prestamos_personales.fecha_fin BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los Viaticos al estado activo para que no siga cancelado
      $this->db->query('UPDATE viaticos, contrato SET viaticos.estado = 1, viaticos.quincenas_restante = viaticos.quincenas_restante + 1 WHERE viaticos.planilla = 1 AND viaticos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and viaticos.fecha_fin BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los Anticipos al estado activo para que no siga cancelado
      $this->db->query('UPDATE anticipos, contrato set anticipos.estado = 1 where anticipos.planilla = 1 and anticipos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar las Horas Extras al estado activo para que no siga cancelado
      $this->db->query('UPDATE horas_extras, contrato SET horas_extras.cancelado = 1 WHERE horas_extras.cancelado = 1 and horas_extras.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and horas_extras.fecha BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar las Horas de Descuento al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuentos_horas, contrato SET descuentos_horas.cancelado = 0 WHERE descuentos_horas.cancelado = 1 and descuentos_horas.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and descuentos_horas.fecha BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los decuentos por herramientas al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuento_herramienta, contrato set descuento_herramienta.estado = 1 where descuento_herramienta.planilla = 1 and descuento_herramienta.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and descuento_herramienta.fecha_fin BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE faltante, contrato SET faltante.estado = 1 WHERE faltante.estado = 0 and faltante.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and faltante.fecha_aplicada BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar las ordenes de descuento estado activo para que no siga cancelado
      $this->db->query('UPDATE orden_descuentos, contrato SET orden_descuentos.estado = 1 WHERE orden_descuentos.planilla = 1 and orden_descuentos.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and orden_descuentos.fecha_finalizacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para regresar las incapacidad estado activo para que no siga cancelado
      $this->db->query('UPDATE incapacidad, contrato SET incapacidad.estado = 1 WHERE incapacidad.estado = 2 and incapacidad.id_contrato=contrato.id_contrato and contrato.id_empleado = "'.$id_empleado.'" and incapacidad.fecha_planilla BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

        return true;
    }


    //METODO DONDE SE ELIMINAN PERMANENTEMENTE LOS DATOS DEL EMPLEADO
    //QUE NO SALDRA EN PLANILLA
    function eliminarPagosEmple($primerDia,$ultimoDia,$id_empleado){
      //Consulta para eliminar los pagos de los prestamos internos que se hacen en la planilla
      $this->db->query('DELETE amortizacion_internos.* FROM amortizacion_internos, prestamos_internos, contrato WHERE amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and amortizacion_internos.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and amortizacion_internos.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('DELETE amortizacion_personales.* FROM amortizacion_personales, prestamos_personales, contrato WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'"  and amortizacion_personales.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para eliminar los pagos de las ordenes de descuento que se hacen en la planilla
      $this->db->query('DELETE orden_descuento_abono.* FROM orden_descuento_abono, orden_descuentos, contrato WHERE orden_descuento_abono.id_orden_descuento=orden_descuentos.id_orden_descuento and orden_descuentos.id_contrato=contrato.id_contrato and orden_descuento_abono.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and orden_descuento_abono.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para eliminar los pagos de los descuentos de las herramientas que se hacen en la planilla
      $this->db->query('DELETE pagos_descuento_herramienta.* FROM pagos_descuento_herramienta, descuento_herramienta, contrato WHERE pagos_descuento_herramienta.id_descuento_herramienta=descuento_herramienta.id_descuento_herramienta and descuento_herramienta.id_contrato=contrato.id_contrato and pagos_descuento_herramienta.planilla = 1 and contrato.id_empleado = "'.$id_empleado.'" and pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      //Consulta para eliminar los datos de la tabla planilla que no se necesitan
      $this->db->query('DELETE planilla.* FROM planilla, contrato WHERE planilla.id_contrato=contrato.id_contrato and planilla.estado = 1 and contrato.id_empleado = "'.$id_empleado.'" and planilla.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      return true;

    }

    function eliminarPagosGob($diaUno,$diaUltimo,$agencia,$empresa){
      //Consulta para eliminar los datos de la tabla planilla que no se necesitan
      $this->db->query('DELETE planilla.* FROM planilla, contrato WHERE planilla.id_contrato=contrato.id_contrato and planilla.estado = 2 and contrato.id_agencia = "'.$agencia.'" and contrato.id_empresa = "'.$empresa.'" and planilla.fecha_aplicacion BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');

      return true;
    }

    function encontrarEmpresa($id_contrato){
        $this->db->select('*');
        $this->db->from('contrato');     
        $this->db->where('id_contrato',$id_contrato);            

        $result = $this->db->get();
        return $result->result();
    }

    function empleadosPlanillas(){
        $this->db->select('em.nombre, em.apellido, ag.agencia, cc.Sbase, co.*');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');            
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');            
        $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');            
        $this->db->where('co.id_empresa',2);            

        $result = $this->db->get();
        return $result->result();
    }

    function contratosMenoresPl($id_empleado,$id_contrato){
        $this->db->select('*');
        $this->db->from('contrato'); 
        $this->db->where('id_empleado',$id_empleado);
        $this->db->where('id_contrato < ',$id_contrato);
        $this->db->order_by('id_contrato','DESC');

        $result = $this->db->get();
        return $result->result();
   }

   function cancelarIncap($id_incapacidad,$ultimoDia){
        $data = array(     
          'fecha_planilla'      => $ultimoDia,
          'estado '             => 2,
        );
        $this->db->where('estado', 1);
        $this->db->where('id_incapacida', $id_incapacidad);
        $this->db->update('incapacidad',$data);
        return true;
   }

   function empleados_gob($agencia){
      $this->db->select('co.id_contrato,co.id_empleado,co.fecha_inicio,, em.nombre, em.apellido, em.dui, ca.cargo, emp.nombre_empresa, ag.agencia');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
      $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
      $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      if($agencia != 'todos'){
        $this->db->where('co.id_agencia', $agencia);
      }
      $this->db->where('em.activo = 1');
      $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');

      $result = $this->db->get();
      return $result->result();
   }

   function VerificarGob($id_empleado){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('subsidio_aplicar su'); 
      $this->db->join('contrato co', 'co.id_contrato=su.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
   }

   function conteoPlanillaGob($agencia_planilla,$empresa,$num_quincena,$mes){
      $this->db->select('COUNT(*) as conte');
      $this->db->from('contrato co'); 
      $this->db->join('planilla pl', 'pl.id_contrato=co.id_contrato');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('empresa em', 'em.id_empresa=co.id_empresa');
      $this->db->where('pl.mes', $mes);
      $this->db->where('pl.estado = 2');
      $this->db->where('co.id_empresa', $empresa);
      $this->db->where('co.id_agencia', $agencia_planilla);
      $this->db->where('pl.tiempo', $num_quincena);

      $result = $this->db->get();
      return $result->result();
  }

  function maternidadGob($id_empleado){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('maternidad ma'); 
      $this->db->join('contrato co', 'ma.id_contrato=co.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }

  function obtenerContrato($code){
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

  function empleadoGob($code,$id_contrato,$fecha_aplicar,$fecha_actual){
    $data = array(
            'id_contrato'        => $code, 
            'id_auto'            => $id_contrato, 
            'fecha_aplicar'      => $fecha_aplicar, 
            'fecha_ingreso'      => $fecha_actual, 
            'estado'             => 1, 
            
      );
      $result=$this->db->insert('subsidio_aplicar',$data);
      return $result;
  }


  function verificarGobierno($id_empleado,$primerDia,$ultimoDia){
      $this->db->select('COUNT(*) as conteo');
      $this->db->from('subsidio_aplicar su'); 
      $this->db->join('contrato co', 'co.id_contrato=su.id_contrato');
      $this->db->where('co.id_empleado', $id_empleado);
      $this->db->where('su.fecha_aplicar BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarEmpleadosGob($agencia_planilla,$primerDia,$ultimoDia,$empresa){
      $this->db->select('co.id_contrato, em.id_empleado,em.nombre,cc.Sbase,co.fecha_inicio, su.fecha_aplicar');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('categoria_cargo  cc', 'cc.id_categoria=co.id_categoria');
      $this->db->join('subsidio_aplicar su', 'su.id_contrato=co.id_contrato');
      $this->db->where('em.activo = 1');
      $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');
      $this->db->where('co.id_agencia', $agencia_planilla);
      $this->db->where('co.id_empresa', $empresa);
      $this->db->where('su.fecha_aplicar BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 

      $result = $this->db->get();
      return $result->result();
  }

  function boletaDatos($empleado,$primerDia,$ultimoDia,$boleta){
      $this->db->select('em.nombre, em.apellido, em.dui, em.nit, ca.cargo, emp.id_empresa, emp.img, ag.agencia,pl.*');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
      $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
      $this->db->join('planilla pl', 'pl.id_contrato=co.id_contrato');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->where('pl.aprobado', 1);
      $this->db->where('pl.estado',$boleta);
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('pl.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarPagoI($empleado,$primerDia,$ultimoDia){
      $this->db->select('ti.nombre_prestamo, am.pago_total');
      $this->db->from('tipo_prestamo ti'); 
      $this->db->join('prestamos_internos pr', 'pr.id_tipo_prestamo=ti.id_tipo_prestamo');
      $this->db->join('amortizacion_internos am', 'am.id_prestamo_interno=pr.id_prestamo');
      $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
      $this->db->where('am.estado', 1);
      $this->db->where('am.planilla', 1);
      $this->db->where('pr.id_prestamo', 1);
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('am.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarPagoP($empleado,$primerDia,$ultimoDia){
      $this->db->select('ti.nombre_tipos, am.pago_total');
      $this->db->from('tipo_prestamos_personales ti'); 
      $this->db->join('prestamos_personales pr', 'pr.id_prest_personales=ti.id_prest_personales');
      $this->db->join('amortizacion_personales am', 'am.id_prestamo_personal=pr.id_prestamo_personal');
      $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
      $this->db->where('am.estado', 1);
      $this->db->where('am.planilla', 1);
      $this->db->where('pr.id_prestamo_personal', 1);
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('am.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarAnticipo($empleado,$primerDia,$ultimoDia){
      $this->db->select('ti.nombre_tipo, an.monto_otorgado');
      $this->db->from('tipo_anticipo ti'); 
      $this->db->join('anticipos an', 'an.id_tipo_anticipo=ti.id_tipo_anticipo');
      $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
      $this->db->where('an.estado', 0);
      $this->db->where('an.planilla', 1);
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('an.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarHerramientas($empleado,$primerDia,$ultimoDia){
      
      $this->db->select('ti.nombre_tipo, pd.pago');
      $this->db->from('tipo_descuento ti'); 
      $this->db->join('descuento_herramienta dh', 'dh.id_tipo_descuento=ti.id_tipo_descuento');
      $this->db->join('pagos_descuento_herramienta pd', 'pd.id_descuento_herramienta=dh.id_descuento_herramienta');
      $this->db->join('contrato co', 'co.id_contrato=dh.id_contrato');
      $this->db->where('pd.estado', 1);
      $this->db->where('pd.planilla', 1);
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('pd.fecha_ingreso BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function buscarOrdes($empleado,$primerDia,$ultimoDia){
      $this->db->select('ba.nombre_banco, ord.cantidad_abonada');
      $this->db->from('bancos ba'); 
      $this->db->join('orden_descuentos od', 'od.id_banco=ba.id_banco');
      $this->db->join('orden_descuento_abono ord', 'ord.id_orden_descuento=od.id_orden_descuento');
      $this->db->join('contrato co', 'co.id_contrato=od.id_contrato');
      $this->db->where('co.id_empleado', $empleado);
      $this->db->where('ord.fecha_abono BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"'); 
      
      $result = $this->db->get();
      return $result->result();
  }

  function empresasFirmasPl($agencia){
        $this->db->select('emp.nombre_empresa, emp.id_empresa');
        $this->db->from('empresa emp');
        $this->db->join('empresa_agencia ea', 'ea.id_empresa=emp.id_empresa');
        $this->db->join('agencias ag', 'ag.id_agencia=ea.id_agencia');
        $this->db->where('ea.id_agencia', $agencia);
        $this->db->where('ea.estado', 1);
        
        $query = $this->db->get();
        return $query->result();
   }

  function empleadosFima($agencia,$primerDia,$ultimoDia,$empresa,$hoja){
      $this->db->select('em.nombre, em.apellido, emp.id_empresa, ag.id_agencia, ag.agencia');
      $this->db->from('empleados em'); 
      $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
      $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
      $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
      $this->db->join('planilla pl', 'pl.id_contrato=co.id_contrato');

      $this->db->where('pl.estado', $hoja);
      $this->db->where('pl.aprobado', 1);
      $this->db->where('co.id_agencia', $agencia);
      $this->db->where('co.id_empresa', $empresa);
      $this->db->where('pl.fecha_aplicacion BETWEEN "'.$primerDia.'" and "'.$ultimoDia.'"');

      $result = $this->db->get();
      return $result->result();
  }

  //NUEVO MUDULO DE INCAPACIDADES DE LAS PLANILLAS
  function incapacidades($id_empleado){
      $this->db->select('inc.id_incapacida, inc.id_contrato, inc.desde, inc.hasta, inc.tipo_incapacidad');
      $this->db->from('incapacidad inc'); 
      $this->db->join('contrato co', 'co.id_contrato=inc.id_contrato');
      $this->db->where('inc.estado', 1);
     // $this->db->where('inc.id_inca_exte IS null');
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
  }
  
  function buscarIncapacidad($id_incapacida){
      $this->db->select('*');
      $this->db->from('incapacidad');
      $this->db->where('(id_inca_exte = '.$id_incapacida.')');

      $result = $this->db->get();
      return $result->result();
  }

  function cancelarIncapacidades($ultimoDia,$id_incapacida){
      $data = array(     
        'fecha_planilla'      => $ultimoDia,
        'estado '             => 2,
      );
      $this->db->where('(id_incapacida = '.$id_incapacida.' or id_inca_exte = '.$id_incapacida.')');
      $this->db->update('incapacidad',$data);
      return true;
  }

  function empleados_viaticos($id_empleado,$mes,$num_quincena){
      $this->db->select('*');
      $this->db->from('viaticos_carteras');
      $this->db->where('id_empleado', $id_empleado);
      $this->db->where('quincena', $num_quincena);
      $this->db->where('mes', $mes);
      $this->db->where('estado != 0 or (estado = 6 and mes <= "'.$mes.'" and id_empleado = '.$id_empleado.')');
      //$this->db->where('or (estado = 6 and mes <= "'.$mes.'"" and quincena <= '.$num_quincena.')');

      $result = $this->db->get();
      return $result->result();
  }

  function insert_viaticos($data_viaticos){
    $result=$this->db->insert('viaticos_efectivos',$data_viaticos);
    return $result;
  }

  function buscar_viaticos($empleado,$primerDia,$ultimoDia,$estado){
      $this->db->select('SUM(viaticos_efectivos.consumo_ruta) as consumo_ruta, SUM(viaticos_efectivos.depreciacion) as depreciacion, SUM(viaticos_efectivos.llanta_del) as llanta_del, SUM(viaticos_efectivos.llanta_tra) as llanta_tra, SUM(viaticos_efectivos.mant_gral) as mant_gral, SUM(viaticos_efectivos.aceite) as aceite');
      $this->db->from('viaticos_efectivos'); 

      $this->db->join('contrato', 'contrato.id_contrato=viaticos_efectivos.id_contrato');
      $this->db->join('viaticos_carteras', 'viaticos_carteras.id_viaticos_cartera=viaticos_efectivos.id_viaticos_cartera');

      $this->db->where('viaticos_efectivos.estado = 1');
      $this->db->where('contrato.id_empleado',$empleado);
      $this->db->where('viaticos_efectivos.fecha_aplicacion >=',$primerDia);
      $this->db->where('viaticos_efectivos.fecha_aplicacion <=',$ultimoDia);
      if($estado == 1){
        $this->db->where('(viaticos_carteras.estado = 1 or viaticos_carteras.estado = 2 or viaticos_carteras.estado = 3 and viaticos_carteras.estado = 4)');
      }else if($estado == 2){
        $this->db->where('viaticos_carteras.estado = 5');
      }else if($estado == 3){
        $this->db->where('viaticos_carteras.estado = 6');
      }

      //$this->db->group_by('viaticos_carteras.estado');
      //$this->db->order_by('viaticos_carteras.estado','DESC');

      $result = $this->db->get();
      return $result->result();
  }

  function traer_contratos($id_agencia,$id_empresa){
      $this->db->select('*');
      $this->db->from('contrato');
      $this->db->where('id_agencia',$id_agencia);
      $this->db->where('(estado = 1 or estado = 3)');

      $result = $this->db->get();
      return $result->result();
  }

  function update_contratos($data,$id_contrato){
      $this->db->where('id_contrato', $id_contrato);
      $this->db->update('contrato',$data);
      return true;
  }

  function ingresar_contratos($data){
      $this->db->insert('contrato',$data);
      return $this->db->insert_id();
  }

  function buscar_planilla($id_contrato,$fecha){
      $this->db->select('*');
      $this->db->from('planilla');
      $this->db->where('id_contrato',$id_contrato);
      $this->db->where('fecha_aplicacion',$fecha);

      $result = $this->db->get();
      return $result->result();
  }

  function update_planilla($data,$id_planilla){
      $this->db->where('id_planilla', $id_planilla);
      $this->db->update('planilla',$data);
      return true;
  }

   //APARTADO PARA LOS CREDITOS DE SIGA
   function desembolos_creditos($id_empleado,$fecha_inicio,$num_quincena){
    if($num_quincena == 1){
      $dias = "and tipo_credito.dias_interes = 15";
    }else if($num_quincena == 2){
      $dias = "and tipo_credito.dias_interes >= 15";
    }
    $this->db->db_select('Operaciones');
    $this->db->select('cliente.codigo, cliente_empleado.id_empleado, concat(cliente.nombre," ",cliente.apellido) as nombre, tipo_credito.interes_total, tipo_credito.interes_alter, tipo_credito.dias_interes, credito_empleado.codigo, credito_empleado.monto_pagar, substr(desembolso_empleado.fecha_desembolso, 1, 10) as fecha_desembolso, solicitud.monto, factibilidad.cuota_diaria,cuota_seguro_vida,cuota_seguro_deuda,cuota_vehicular');
    $this->db->from('solicitud');

    $this->db->join('tipo_credito', 'tipo_credito.id_tipo_credito=solicitud.plazo');
    $this->db->join('desembolso_empleado', 'desembolso_empleado.id_solicitud=solicitud.id_solicitud');
    $this->db->join('credito_empleado', 'credito_empleado.id_desembolso=desembolso_empleado.id_desembolso');
    $this->db->join('factibilidad', 'factibilidad.id_solicitud=solicitud.id_solicitud');
    $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
    $this->db->join('cliente_empleado', 'cliente_empleado.id_cliente=cliente.codigo');

    $this->db->where("credito_empleado.estado",1);
    $this->db->where("desembolso_empleado.estado_desembolso=1");
    $this->db->where("cliente_empleado.id_empleado", $id_empleado);
    $this->db->where("substr(desembolso_empleado.fecha_desembolso, 1, 10) <=", $fecha_inicio);
    $this->db->where("tipo_credito.linea = '0005' ".$dias);

    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  public function ultimo_pago($credito){
    $this->db->db_select('Operaciones');
    $this->db->select('*');
    $this->db->from('pagos_empleado');   
    $this->db->where("credito", $credito);
    $this->db->where("(pagos_empleado.estado = 1 or  pagos_empleado.estado = 2 or pagos_empleado.estado = 3 or pagos_empleado.estado = 4)");

    //$this->db->order_by('comprobante','DESC');
    $this->db->order_by('substr(fecha_pago,1,10) DESC');
    $this->db->limit(1);  
    
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  public function numero_pagos($agencia){
    $this->db->db_select('Operaciones');
    $this->db->select('*');
    $this->db->from('pagos_empleado');
    $this->db->like("comprobante", $agencia, 'after');
            

    $query = $this->db->get();
    $this->db->db_select('tablero');
    return $query->num_rows();
  }

  public function verificar_comprobante($codigo){
    $this->db->db_select('Operaciones');
    $this->db->select('*');
    $this->db->from('pagos_empleado');
    $this->db->where("comprobante", $codigo);
            
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  //APARTADO PARA NUEVAS PLANILLAS 
  function datos_autorizante($id_empleado){
    $this->db->select('concat(empleados.nombre," ",empleados.apellido) as nombre, contrato.id_contrato');
    $this->db->from('empleados'); 
    $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');

    $this->db->where('contrato.id_empleado', $id_empleado);
    $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
    $this->db->order_by('fecha_inicio','DESC');

    $result = $this->db->get();
    return $result->result();
  }

  function empleados_agencia($agencia,$empresa){
    $this->db->select('empresa.id_empresa, empresa.nombre_empresa, ag.id_agencia, ag.agencia, co.id_contrato, em.id_empleado, em.nombre, em.apellido,em.afp,em.ipsfa,em.isss,cc.Sbase,co.fecha_inicio');
    $this->db->from('empleados em '); 
    $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
    $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
    $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
    $this->db->join('empresa', 'empresa.id_empresa=co.id_empresa');

    $this->db->where('co.id_agencia', $agencia);
    $this->db->where('co.id_empresa', $empresa);

    $this->db->where('em.activo = 1 and (co.estado = 1 or co.estado = 3) and  ((em.afp IS NOT NULL and em.afp != "") OR (em.ipsfa IS NOT NULL and em.ipsfa != "")) and (em.isss != "" and em.isss IS NOT NULL)');

    $this->db->order_by('em.nombre','asc');

    $result = $this->db->get();
    return $result->result();
  }

  function planilla_empleado($id_empleado,$fecha){
    $this->db->select('planilla.*');
    $this->db->from('planilla'); 
    $this->db->join('contrato', 'contrato.id_contrato=planilla.id_contrato');

    $this->db->where('planilla.fecha_aplicacion', $fecha);
    $this->db->where('contrato.id_empleado', $id_empleado);
    $this->db->where('planilla.estado = 1');

    $result = $this->db->get();
    return $result->result();
  }

  function insert_pago_siga($data){
      $this->db->db_select('Operaciones');
      $result=$this->db->insert('pagos_empleado',$data);
      $this->db->db_select('tablero');
      return $result;
  }
  public function actualizar_credito($codigo,$data){
    $this->db->db_select('Operaciones');
    $this->db->where('codigo', $codigo);
    $this->db->update('credito_empleado', $data);
    $this->db->db_select('tablero');
    return true;        
  }

  function empleados_planilla($agencia,$empresa,$primerDia,$ultimoDia){
    $this->db->select('contrato.id_empleado');
    $this->db->from('planilla'); 
    $this->db->join('contrato', 'contrato.id_contrato=planilla.id_contrato');

    $this->db->where('contrato.id_agencia', $agencia);
    $this->db->where('contrato.id_empresa', $empresa);
    $this->db->where('planilla.fecha_aplicacion >=', $primerDia);
    $this->db->where('planilla.fecha_aplicacion <=', $ultimoDia);
    
    $result = $this->db->get();
    return $result->result();
  }

  function pagos_planilla($codigo,$primerDia,$ultimoDia){
    $this->db->db_select('Operaciones');
    $this->db->select('*');
    $this->db->from('pagos_empleado'); 

    $this->db->where('credito', $codigo);
    $this->db->where('substr(fecha_pago, 1, 10) >=', $primerDia);
    $this->db->where('substr(fecha_pago, 1, 10) <=', $ultimoDia);
    $this->db->where('estado = 4');
    
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  function pago_ultimo($codigo,$comprobante){
    $this->db->db_select('Operaciones');
    $this->db->select('*');
    $this->db->from('pagos_empleado'); 

    $this->db->where('credito', $codigo);
    $this->db->where('comprobante >', $comprobante);
    $this->db->where('estado != 0');
    
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  function revertir_pago($data,$comprobante){
    $this->db->db_select('Operaciones');
    $this->db->where('comprobante', $comprobante);
    $this->db->update('pagos_empleado',$data);
    $this->db->db_select('tablero');
    return true;
  }

  function buscar_pago_siga($id_empleado,$diaUno,$diaUltimo){
    $this->db->db_select('Operaciones');
    $this->db->select('pagos_empleado.*');
    $this->db->from('pagos_empleado'); 
    $this->db->join('credito_empleado', 'credito_empleado.codigo=pagos_empleado.credito');
    $this->db->join('desembolso_empleado', 'desembolso_empleado.id_desembolso=credito_empleado.id_desembolso');
    $this->db->join('solicitud', 'solicitud.id_solicitud=desembolso_empleado.id_solicitud');
    $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
    $this->db->join('cliente_empleado', 'cliente_empleado.id_cliente=cliente.codigo');

    $this->db->where('cliente_empleado.id_empleado', $id_empleado);
    $this->db->where('substr(pagos_empleado.fecha_pago,1,10) >=', $diaUno);
    $this->db->where('substr(pagos_empleado.fecha_pago,1,10) <=', $diaUltimo);
    $this->db->where('pagos_empleado.estado = 4');
    
    $result = $this->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

}