<?php
class Liquidacion_model extends CI_Model{

    function allEmpresas(){
        $this->db->select('*');
        $this->db->from('empresa'); 
        $this->db->where('estado',1); 

        $result = $this->db->get();
        return $result->result();
    }

   function contratosEmpleados($empresa_liqui,$agencia_liqui){
        $this->db->select('em.id_empleado ,em.nombre, em.apellido, em.dui, ag.agencia, emp.nombre_empresa, ca.cargo, co.id_contrato, co.fecha_fin, co.fecha_inicio');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->where('(co.estado = 0 or co.estado = 4)');
        $this->db->where('co.tipo_des_ren != ', null);
        if($empresa_liqui != 'todas'){
            $this->db->where('co.id_empresa', $empresa_liqui);
        }
        if($agencia_liqui != 'todas' && $agencia_liqui != null){
            $this->db->where('co.id_agencia', $agencia_liqui);
        }
        $this->db->order_by('co.id_contrato','DESC');

        $query = $this->db->get();
        return $query->result();
   }

   function ultContrato($id_contrato){
        $this->db->select('cc.Sbase, em.nombre, em.apellido, em.afp, em.ipsfa, co.id_empleado, ag.agencia, emp.nombre_empresa, ca.cargo, co.fecha_inicio, co.fecha_fin, co.tipo_des_ren');
        $this->db->from('contrato co'); 
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_contrato',$id_contrato);
        $this->db->order_by('co.id_contrato','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
   }



   function contratosMenores($id_empleado,$id_contrato){
        //con estas consultas para traer los contratos anteriores
        $this->db->select('cc.Sbase, co.*');
        $this->db->from('contrato co'); 
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
        $this->db->where('co.id_empleado',$id_empleado);
        $this->db->where('co.id_contrato < ',$id_contrato);
        $this->db->order_by('co.id_contrato','DESC');

        $result = $this->db->get();
        return $result->result();
   }

   function ultimaVacacion($id_empleado){
        $this->db->select('va.*');
        $this->db->from('vacaciones va');
        $this->db->join('contrato co', 'va.id_contrato=co.id_contrato');
        $this->db->where('co.id_empleado',$id_empleado);
        $this->db->where('va.aprobado',1);
        $this->db->where('va.estado',1);
        $this->db->where('va.ingresado',1);
        $this->db->order_by('va.id_vacacion','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
   }

   function busquedaContrato($id_contrato,$id_empleado){
        $this->db->select('*');
        $this->db->from('contrato');
        $this->db->where('id_empleado',$id_empleado);
        $this->db->where('id_contrato >=',$id_contrato);
        $this->db->order_by('id_contrato','ASC');

        $query = $this->db->get();
        return $query->result();
   }

   function ultimaQuincena($id_empleado){
        $this->db->select('pl.*');
        $this->db->from('planilla pl');
        $this->db->join('contrato co', 'co.id_contrato=pl.id_contrato');
        $this->db->where('co.id_empleado',$id_empleado);
        $this->db->where('pl.aprobado',1);
        $this->db->order_by('pl.fecha_aplicacion','DESC');

        $query = $this->db->get();
        return $query->result();
   }

   function BusViaticosAc($id_empleado,$fechaQuin2){
        $this->db->select('vi.*');
        $this->db->from('viaticos vi');
        $this->db->join('contrato co', 'co.id_contrato=vi.id_contrato');
        $this->db->where('vi.estado', 1);    
        $this->db->where('vi.fecha_aplicacion <',$fechaQuin2);   
        $this->db->where('co.id_empleado', $id_empleado);

        $result = $this->db->get();
        return $result->result();
   }

   function cancelarViaticos($id_viaticos,$fechaFin,$liquidacion){
    $data = array(
          'estado'         => 0,
          'fecha_fin'      => $fechaFin,
          'planilla'       => $liquidacion,
    );
    $this->db->where('id_viaticos', $id_viaticos);
    $this->db->update('viaticos',$data);
    return true;
   }

   function descLey(){
        $this->db->select('*');
        $this->db->from('descuentos_ley'); 
        $this->db->where('estado', 1);
        $this->db->where('aplica', 'Empleado');

        $result = $this->db->get();
        return $result->result();
   }

   function rentaLiquidacion(){
        $this->db->select('renta.desde, renta.hasta, renta.porcentaje,renta.cuota,renta.sobre');
        $this->db->from('renta');
        $this->db->join('tiempo_renta', 'tiempo_renta.id_tiempo=renta.id_tiempo');
        $this->db->where('renta.estado', 1); 
        $this->db->where('tiempo_renta.nombre', 'Quincena'); 

        $result = $this->db->get();
        return $result->result();
   }

   function buscarPrestamo($id_empleado,$estado){
        $this->db->select('pr.id_prestamo_personal, pr.monto_otorgado, pr.cuota, pr.plazo_quincenas, tp.porcentaje, pr.fecha_otorgado,pr.estado');
        $this->db->from('prestamos_personales pr');
        $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        if($estado == 2 || $estado == 3){
            $this->db->where('pr.aprobado', 1);
            $this->db->where('(((pr.estado = 1 or pr.estado = 2) and pr.planilla = 0) or (pr.estado = 0 and pr.planilla = 3))');
        }else{
            $this->db->where('pr.aprobado', 1);
            $this->db->where('(pr.estado = 1 or pr.estado = 2)');
            $this->db->where('pr.planilla', 0);
        }

        $result = $this->db->get();
        return $result->result();
   }

   function buscarPagos($id_prestamo_personal,$ultimoDia){
        $this->db->select('*');
        $this->db->from('amortizacion_personales'); 
        $this->db->where('id_prestamo_personal',$id_prestamo_personal); 
        $this->db->where('fecha_abono <=', $ultimoDia);
        $this->db->where('(estado = 1 or estado = 2)'); 
        $this->db->where('(planilla != 3 and planilla != 4)');
        $this->db->order_by('fecha_abono','DESC'); 
        $this->db->limit(1); 

        $result = $this->db->get();
        return $result->result();
   }

   function busFaltante($id_empleado,$fechaQuin1,$fechaQuin2,$estado){
        $this->db->select('fa.*');
        $this->db->from('faltante fa');
        $this->db->join('contrato co', 'co.id_contrato=fa.id_contrato');
        if($estado == 2 || $estado == 3){
            $this->db->where('(fa.estado = 1 or (fa.estado = 0 and fa.planilla = 3))');
        }else{
            $this->db->where('fa.estado', 1);
        }            
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('fa.fecha_aplicada BETWEEN"'.$fechaQuin1.'" and "'.$fechaQuin2.'"');

        $result = $this->db->get();
        return $result->result();
   }

   function busHerramienta($id_empleado,$fechaFin,$estado){
        $this->db->select('de.*');
        $this->db->from('descuento_herramienta de');
        $this->db->join('contrato co ', 'co.id_contrato=de.id_contrato');
        if($estado == 2 || $estado == 3){
            $this->db->where('(de.estado = 1 or (de.estado = 0 and de.planilla = 3))');
        }else{
            $this->db->where('de.estado', 1);            
        }
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('de.fecha_ingreso <= "'.$fechaFin.'"');            

        $result = $this->db->get();
        return $result->result();
   }

   function verHerramientas($id_descuento_herramienta){
        $this->db->select('*');
        $this->db->from('pagos_descuento_herramienta');
        $this->db->where('estado', 1); 
        $this->db->where('(planilla != 3 and planilla != 4)'); 
        $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
        $this->db->order_by('id_pago','DESC');
        $this->db->limit(1);  

        $result = $this->db->get();
        return $result->result();
   }

   function busAnticipo($id_empleado,$fechaInicio,$fechaFin,$estado){
        $this->db->select('an.*');
        $this->db->from('anticipos an');
        $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
        if($estado == 2 || $estado == 3){
            $this->db->where('(an.estado = 1 or (an.estado = 0 and an.planilla = 3))');    
        }else{
            $this->db->where('an.estado', 1);    
        }
        $this->db->where('an.fecha_aplicacion BETWEEN"'.$fechaInicio.'" and "'.$fechaFin.'"');     
        $this->db->where('co.id_empleado', $id_empleado);

        $result = $this->db->get();
        return $result->result();
   }

   function buscarInternos($id_empleado,$estado){
        $this->db->select('pi.id_prestamo, pi.plazo_quincena, pi.monto_otorgado,pi.monto_pagar,pi.cuota, ta.tasa, pi.fecha_otorgado,pi.estado');
        $this->db->from('prestamos_internos pi');
        $this->db->join('contrato co', 'co.id_contrato=pi.id_contrato');
        $this->db->join('tipo_prestamo tp', 'pi.id_tipo_prestamo=tp.id_tipo_prestamo');
        $this->db->join('tasa ta', 'ta.id_tasa=tp.id_tasa');
        if($estado == 2 || $estado == 3){
            $this->db->where('((pi.estado = 1 or pi.estado = 2) or (pi.estado = 0 and pi.planilla = 3))'); 
            $this->db->where('pi.aprobado', 1); 
        }else{
            $this->db->where('(pi.estado = 1 or pi.estado = 2)'); 
            $this->db->where('pi.aprobado', 1); 
        }
        $this->db->where('co.id_empleado', $id_empleado);

        $result = $this->db->get();
        return $result->result();
   }

   function pagosInter($id_prestamo){
        $this->db->select('*');
        $this->db->from('amortizacion_internos');
        $this->db->where('(estado = 1 or estado = 2)'); 
        $this->db->where('(planilla != 3 and planilla != 4)'); 
        $this->db->where('id_prestamo_interno', $id_prestamo);
        $this->db->order_by('id_amortizacion','DESC'); 

        $result = $this->db->get();
        return $result->result();
   }

   function saveLiquidacion($data){
        $result=$this->db->insert('liquidacion',$data);
        return $result;
   }

   function verificarLiquidacion($id_contrato){
        //$this->db->select('COUNT(*) as conteo');
        $this->db->select('*');
        $this->db->from('liquidacion');
        $this->db->where('id_contrato',$id_contrato); 

        $result = $this->db->get();
        return $result->result();
   }

   function buscarLiquidacion($id_contrato){
        $this->db->select('em.nombre, em.apellido, em.dui, em.nit, em.domicilio, ag.agencia, emp.nombre_empresa, emp.nombre_completo, emp.id_empresa,  emp.casa_matriz, ca.cargo, li.*');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('liquidacion li', 'li.id_contrato=co.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('li.id_contrato', $id_contrato);
        $this->db->order_by('li.id_liquidacion','ASC');

        $result = $this->db->get();
        return $result->result();
   }

   function liquidacion($id_liquidacion){
        $this->db->select('*');
        $this->db->from('liquidacion'); 
        $this->db->where('id_liquidacion', $id_liquidacion);
        
        $result = $this->db->get();
        return $result->result();
   }

   function updateLiquidacion($id_liquidacion,$data){
        $this->db->where('id_liquidacion', $id_liquidacion);
        $this->db->update('liquidacion',$data);
        return true;
   }

   function deleteLiquidacion($code){
        $this->db->where('id_liquidacion', $code);
        $this->db->delete('liquidacion');
        return true;
   }

   function aporbarLiq($data,$code){
        $this->db->where('id_liquidacion', $code);
        $this->db->update('liquidacion',$data);
        return true;
   }

   function articuloEdit($code,$texto_edicion){
      $data = array(
            'descripcion'       => $texto_edicion,
      );
      $this->db->where('id_liquidacion', $code);
      $this->db->update('liquidacion',$data);
      return true;
   }

   function buscarCesantia($id_empleado,$fechaInicio,$fechaFin){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('control_contrato cc');
        $this->db->join('contrato co', 'co.id_contrato=cc.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('cc.fecha_fin !=', null);
        $this->db->where('cc.estado', 0);
        $this->db->where('cc.estado_contrato = 11');
        $this->db->where('cc.fecha_inicio BETWEEN"'.$fechaInicio.'" and "'.$fechaFin.'"');

        $result = $this->db->get();
        return $result->result();
   }

   function todaCesantia($id_empleado,$inicioAno,$fechaFin){
        $this->db->select('cc.*');
        $this->db->from('control_contrato cc');
        $this->db->join('contrato co', 'co.id_contrato=cc.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('cc.fecha_fin !=', null);
        $this->db->where('cc.estado', 0);
        $this->db->where('cc.estado_contrato = 11');
        $this->db->where('cc.fecha_inicio BETWEEN"'.$inicioAno.'" and "'.$fechaFin.'"');

        $result = $this->db->get();
        return $result->result();
   }

   function cancelarPersonalL($id_prestamo_personal,$planilla,$fecha_fin){
    $data = array(
          'fecha_fin'      => $fecha_fin,
          'estado'         => 0,
          'planilla'       => $planilla,
    );
    $this->db->where('id_prestamo_personal', $id_prestamo_personal);
    $this->db->update('prestamos_personales',$data);
    return true;
  }

  function cancelarInternoL($id_prestamo,$planilla,$fecha_fin){
        $data = array(
            'fecha_fin'      => $fecha_fin,
            'estado'         => 0,
            'planilla'       => $planilla,
        );
          $this->db->where('id_prestamo', $id_prestamo);
          $this->db->update('prestamos_internos',$data);
          return true;
  }

  function conteoDesc($id_descuento_herramienta){
        $this->db->select('id_pago, COUNT(*) as conteo');
        $this->db->from('pagos_descuento_herramienta');
        $this->db->where('id_descuento_herramienta',$id_descuento_herramienta); 
        $this->db->where('planilla',4);
        $this->db->group_by('id_pago'); 

        $result = $this->db->get();
        return $result->result();
  }

  function updatePagoHer($id_pago,$coutaH,$saldoH,$saldoAnterior){
        $data = array(
            'pago'              => $coutaH,
            'saldo_actual'      => $saldoH,
            'saldo_anterior'    => $saldoAnterior,
        );
          $this->db->where('id_pago', $id_pago);
          $this->db->update('pagos_descuento_herramienta',$data);
          return true;
  }

  function conteoPer($id_prestamo_personal){
        $this->db->select('id_amortizacion_personal, COUNT(*) as conteo');
        $this->db->from('amortizacion_personales');
        $this->db->where('id_prestamo_personal',$id_prestamo_personal); 
        $this->db->where('planilla',4);
        $this->db->group_by('id_amortizacion_personal'); 

        $result = $this->db->get();
        return $result->result();
  }

  function updatePresPer($id_amortizacion_personal,$saldoAnterior,$abonoCapital,$interes,$saldo,$pagoTotal){
        $data = array(
              'saldo_anterior'        => $saldoAnterior,  
              'abono_capital'         => $abonoCapital,  
              'interes_devengado'     => $interes,  
              'abono_interes'         => $interes,  
              'saldo_actual'          => $saldo,  
              'interes_pendiente'     => 0,    
              'pago_total'            => $pagoTotal,      
        );
        $this->db->where('id_amortizacion_personal', $id_amortizacion_personal);
        $this->db->update('amortizacion_personales',$data);
        return true;
  }

  function conteoInt($id_prestamo_interno){
        $this->db->select('id_amortizacion, COUNT(*) as conteo');
        $this->db->from('amortizacion_internos');
        $this->db->where('id_prestamo_interno',$id_prestamo_interno); 
        $this->db->where('planilla',4); 

        $result = $this->db->get();
        return $result->result();
  }

  function updatePresInt($id_amortizacion,$saldoAnterior,$abonoCapital,$interes,$saldo,$pagoTotal){
        $data = array(
            'saldo_anterior'        => $saldoAnterior,  
            'abono_capital'         => $abonoCapital,  
            'interes_devengado'     => $interes,  
            'abono_interes'         => $interes,  
            'saldo_actual'          => $saldo,  
            'interes_pendiente'     => 0,      
            'pago_total'            => $pagoTotal,    
        );
        $this->db->where('id_amortizacion', $id_amortizacion);
        $this->db->update('amortizacion_internos',$data);
        return true;
  }

  function verificarLiq($id_contrato){
        $this->db->select('*');
        $this->db->from('liquidacion');
        $this->db->where('id_contrato',$id_contrato);
        $this->db->order_by('id_liquidacion','ASC');
        $this->db->limit(2); 

        $result = $this->db->get();
        return $result->result();
  }

  function buscarFaltante($id_faltante){
        $this->db->select('*');
        $this->db->from('faltante');
        $this->db->where('id_faltante',$id_faltante);

        $result = $this->db->get();
        return $result->result();
  }

  function verificaFaltante($id_empleado,$fechaInicio,$fechaFin){
        $this->db->select('fa.*');
        $this->db->from('faltante fa');
        $this->db->join('contrato co', 'co.id_contrato=fa.id_contrato');
        $this->db->where('(fa.estado = 1 or (fa.estado = 0 and fa.planilla = 3) or (fa.estado = 0 and fa.planilla = 4))');           
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('fa.fecha_aplicada BETWEEN"'.$fechaInicio.'" and "'.$fechaInicio.'"');

        $result = $this->db->get();
        return $result->result();
  }

  function verificaDescuento($id_empleado,$fechaFin){
        $this->db->select('tp.nombre_tipo,co.id_empleado ,de.*');
        $this->db->from('descuento_herramienta de');
        $this->db->join('contrato co ', 'co.id_contrato=de.id_contrato');
        $this->db->join('tipo_descuento tp', 'tp.id_tipo_descuento=de.id_tipo_descuento');
        $this->db->where('(de.estado = 1 or (de.estado = 0 and de.planilla = 3) or (de.estado = 0 and de.planilla = 4))');            
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('de.fecha_ingreso <= "'.$fechaFin.'"');            

        $result = $this->db->get();
        return $result->result();
  }

  function verificaPagoD($id_descuento_herramienta){
        $this->db->select('*');
        $this->db->from('pagos_descuento_herramienta');
        $this->db->where('id_descuento_herramienta', $id_descuento_herramienta);
        $this->db->where('(planilla != 3 and planilla != 4)');
        $this->db->order_by('saldo_actual','ASC');          
        $result = $this->db->get();
        return $result->result();
  }

  function verificaAnticipo($id_empleado,$fechaInicio,$fechaFin){
        $this->db->select('an.*');
        $this->db->from('anticipos an');
        $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
        $this->db->where('(an.estado = 1 or (an.estado = 0 and an.planilla = 3))');  
        $this->db->where('an.fecha_aplicacion BETWEEN"'.$fechaInicio.'" and "'.$fechaFin.'"');     
        $this->db->where('co.id_empleado', $id_empleado);

        $result = $this->db->get();
        return $result->result();
  }

  function verificaPersonal($id_empleado,$fechaInicio,$fechaFin){
        $this->db->select('pr.id_prestamo_personal, pr.monto_otorgado, pr.cuota, pr.plazo_quincenas, tp.porcentaje, pr.fecha_otorgado,pr.estado,pr.planilla');
        $this->db->from('prestamos_personales pr');
        $this->db->join('tipo_prestamos_personales tp', 'tp.id_prest_personales=pr.id_prest_personales');
        $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('pr.aprobado', 1);
        $this->db->where('(((pr.estado = 1 or pr.estado = 2) and pr.planilla = 0) or (pr.estado = 0 and pr.planilla = 3) or (pr.estado = 0 and pr.planilla = 4))');

        $result = $this->db->get();
        return $result->result();
  }

   function regresarLiquidacion($id_contrato,$fecha_inicio,$fecha_fin,$planilla){
      //Consulta para regresar los descuentos de herramientas al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuento_herramienta, contrato, liquidacion SET descuento_herramienta.estado = 1 WHERE descuento_herramienta.planilla = "'.$planilla.'" and descuento_herramienta.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and descuento_herramienta.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los Anticipos al estado activo para que no siga cancelado
      $this->db->query('UPDATE anticipos, contrato, liquidacion set anticipos.estado = 1 where anticipos.planilla = "'.$planilla.'" and anticipos.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and fecha_aplicacion BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los prestamos personales al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_personales, contrato, liquidacion SET prestamos_personales.estado = 1, prestamos_personales.planilla = 0 WHERE prestamos_personales.planilla = "'.$planilla.'" and prestamos_personales.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and prestamos_personales.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los prestamos internos al estado activo para que no siga cancelado
      /*$this->db->query('UPDATE prestamos_internos, contrato, liquidacion SET prestamos_internos.estado = 1 WHERE prestamos_internos.planilla = "'.$planilla.'" and prestamos_internos.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and prestamos_internos.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');*/

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE faltante, contrato, liquidacion SET faltante.estado = 1 WHERE faltante.planilla = "'.$planilla.'" and faltante.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and faltante.fecha_aplicada BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      $this->db->query('UPDATE descuentos_horas, contrato, liquidacion SET descuentos_horas.cancelado = 0 WHERE descuentos_horas.cancelado = 1 and descuentos_horas.id_contrato=contrato.id_contrato and liquidacion.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and contrato.id_empresa = "'.$empresa.'" and descuentos_horas.fecha BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      return true;
   }

   function eliminarPagoL($id_contrato,$fecha_inicio,$fecha_fin,$planilla){
      //Consulta para eliminar los pagos de los descuentos de las herramientas que se hacen en la planilla
      $this->db->query('DELETE pagos_descuento_herramienta.* FROM pagos_descuento_herramienta, descuento_herramienta, contrato, liquidacion WHERE pagos_descuento_herramienta.id_descuento_herramienta=descuento_herramienta.id_descuento_herramienta and descuento_herramienta.id_contrato=contrato.id_contrato and pagos_descuento_herramienta.planilla = "'.$planilla.'" and liquidacion.id_contrato = "'.$id_contrato.'" and pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('DELETE amortizacion_personales.* FROM amortizacion_personales, prestamos_personales, contrato, liquidacion WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = "'.$planilla.'" and liquidacion.id_contrato = "'.$id_contrato.'" and amortizacion_personales.fecha_abono BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para eliminar los pagos de los prestamos internos que se hacen en la planilla
      /*$this->db->query('DELETE amortizacion_internos.* FROM amortizacion_internos, prestamos_internos, contrato, liquidacion WHERE amortizacion_internos.id_prestamo_interno=prestamos_internos.id_prestamo and prestamos_internos.id_contrato=contrato.id_contrato and amortizacion_internos.planilla = "'.$planilla.'" and liquidacion.id_contrato = "'.$id_contrato.'" and amortizacion_internos.fecha_abono BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');*/

      return true;

   }

   function updateEstados($id_contrato,$fecha_inicio,$fecha_fin){
      //Consulta para regresar los descuentos de herramientas al estado activo para que no siga cancelado
      $this->db->query('UPDATE descuento_herramienta, contrato, liquidacion SET descuento_herramienta.planilla = 3 WHERE descuento_herramienta.planilla = 4 and descuento_herramienta.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and descuento_herramienta.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los Anticipos al estado activo para que no siga cancelado
      $this->db->query('UPDATE anticipos, contrato, liquidacion set anticipos.planilla = 3 where anticipos.planilla = 4 and anticipos.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and fecha_aplicacion BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los prestamos personales al estado activo para que no siga cancelado
      $this->db->query('UPDATE prestamos_personales, contrato, liquidacion SET prestamos_personales.planilla = 3 WHERE prestamos_personales.planilla = 4 and prestamos_personales.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and prestamos_personales.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los prestamos internos al estado activo para que no siga cancelado
      /*$this->db->query('UPDATE prestamos_internos, contrato, liquidacion SET prestamos_internos.planilla = 3 WHERE prestamos_internos.planilla = 4 and prestamos_internos.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and prestamos_internos.fecha_fin BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');*/

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE faltante, contrato, liquidacion SET faltante.planilla = 3 WHERE faltante.planilla = 4 and faltante.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and faltante.fecha_aplicada BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE amortizacion_personales, prestamos_personales, contrato, liquidacion SET amortizacion_personales.planilla = 3 WHERE amortizacion_personales.planilla = 4 and prestamos_personales.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and amortizacion_personales.fecha_abono BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      /*$this->db->query('UPDATE amortizacion_internos, prestamos_internos, contrato, liquidacion SET amortizacion_internos.planilla = 3 WHERE amortizacion_internos.planilla = 4 and prestamos_internos.id_contrato=contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and amortizacion_internos.fecha_abono BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');*/

      //Consulta para regresar los faltantes al estado activo para que no siga cancelado
      $this->db->query('UPDATE pagos_descuento_herramienta, descuento_herramienta, contrato, liquidacion SET pagos_descuento_herramienta.planilla = 3 WHERE pagos_descuento_herramienta.planilla = 4 and descuento_herramienta.id_contrato = contrato.id_contrato and liquidacion.id_contrato = "'.$id_contrato.'" and pagos_descuento_herramienta.fecha_ingreso BETWEEN "'.$fecha_inicio.'" and "'.$fecha_fin.'"');

      return true;
   }


   function empleadosAguinaldo($agencia_ingreso){
        $this->db->select('em.nombre, em.apellido, cc.Sbase, co.*');
        $this->db->from('contrato co');
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
        $this->db->where('co.id_agencia', $agencia_ingreso);            
        $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');            

        $result = $this->db->get();
        return $result->result();
   }

   function verificarAguinaldo($agencia_ingreso,$anio){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('aguinaldo al');
        $this->db->join('contrato co', 'al.id_contrato=co.id_contrato');
        $this->db->where('co.id_agencia', $agencia_ingreso);                 
        $this->db->where('al.anio_aplicar', $anio);                                  
        $this->db->where('(al.estado = 0 or al.estado = 1)');                                  

        $result = $this->db->get();
        return $result->result();
   }

   function ingresoAguinaldoLiquidacion($data){
      $result=$this->db->insert('aguinaldo',$data);
      return $result;
   }

   function aguinaldoLiquidacion($agencia_ingreso,$anio){
        $this->db->select('em.nombre, em.apellido, em.dui, em.nit, emp.id_empresa, emp.nombre_empresa, al.ingreso_empleado, (al.cantidad - al.isr) as cantidad, ag.agencia, ag.id_agencia, al.anio_aplicar, al.estado, al.id_aguinaldo');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('aguinaldo al', 'al.id_contrato=co.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_agencia', $agencia_ingreso);                 
        $this->db->where('al.anio_aplicar', $anio);
        $this->db->where('al.estado !=', 2);                                  

        $result = $this->db->get();
        return $result->result();
   }

   function aguinaldoVerificar($agencia_ingreso,$anio){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('aguinaldo al ');
        $this->db->join('contrato co', 'co.id_contrato=al.id_contrato');
        $this->db->where('co.id_agencia', $agencia_ingreso);                 
        $this->db->where('al.anio_aplicar', $anio);                 
        $this->db->where('al.estado', 0);                 

        $result = $this->db->get();
        return $result->result();
   }

   function aprobarAguinaldo($anio,$agencia,$id_contrato){
        $this->db->query('UPDATE aguinaldo, contrato SET aguinaldo.estado = 1, aguinaldo.id_autorizante = "'.$id_contrato.'", aguinaldo.fecha_aprobacion = "'.date('Y-m-d').'" WHERE aguinaldo.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and aguinaldo.anio_aplicar = "'.$anio.'" and aguinaldo.estado = 0');

        return true;
   }

   function rechazoAguinaldo($anio,$agencia,$id_contrato){
      $this->db->query('UPDATE aguinaldo, contrato SET aguinaldo.estado = 2, aguinaldo.id_autorizante = "'.$id_contrato.'", aguinaldo.fecha_aprobacion = "'.date('Y-m-d').'" WHERE aguinaldo.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and aguinaldo.anio_aplicar = "'.$anio.'"');

        return true;
   }

   function controlAguinaldo($data){
        $result=$this->db->insert('control_aguinaldo_indemnizacion',$data);
        return $result;
   }
   
   function updateAguinaldo($code,$data){
      $this->db->where('id_aguinaldo', $code);
      $this->db->update('aguinaldo',$data);
      return true;
   }

   function verAguinaldo($empleado,$anio){
        $this->db->select('em.nombre, em.apellido, em.dui, em.nit, emp.id_empresa, emp.nombre_empresa, al.ingreso_empleado,al.cantidad, al.isr, (al.cantidad - al.isr) as liquido, ag.agencia, ag.id_agencia, al.anio_aplicar, al.estado, al.id_aguinaldo, al.fecha_aplicacion');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('aguinaldo al', 'al.id_contrato=co.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_empleado', $empleado);                 
        $this->db->where('al.anio_aplicar', $anio);
        $this->db->where('al.estado !=', 2);                                  

        $result = $this->db->get();
        return $result->result();
   }

   function tipoGestion(){
        $this->db->select('*');
        $this->db->from('gestion_cierre_anio');       
        $this->db->where('estado', 1);                 

        $result = $this->db->get();
        return $result->result();
   }

   function saveGestion($data){
        $result=$this->db->insert('gestion_cierre_anio',$data);
        return $result;
   }

   function buscarGestion($code){
        $this->db->select('*');
        $this->db->from('gestion_cierre_anio');       
        $this->db->where('id_gestion', $code);                 

        $result = $this->db->get();
        return $result->result();
   }

   function updateGestion($code,$data){
        $this->db->where('id_gestion', $code);
        $this->db->update('gestion_cierre_anio',$data);
        return true;
   }

   function deleteGestion($code){
        $data = array(
              'estado'              => 0
     
        );
        $this->db->where('id_gestion', $code);
        $this->db->update('gestion_cierre_anio', $data);
        return true;
   }

   function gestiones($estado){
        $this->db->select('*');
        $this->db->from('gestion_cierre_anio');       
        $this->db->where('aplicado', $estado);                 
        $this->db->where('estado', 1);                 
        $this->db->where('aplica_anios', 1);                 

        $result = $this->db->get();
        return $result->result();
   }

   function prestamosEmpleados($id_empleado){
      $this->db->select('pr.id_prestamo_personal, pr.monto_otorgado, pr.plazo_quincenas, pr.cuota, tp.porcentaje, pr.fecha_otorgado,pr.estado');
      $this->db->from('prestamos_personales pr');
      $this->db->join('contrato co', 'co.id_contrato=pr.id_contrato');
      $this->db->join('tipo_prestamos_personales tp', ' tp.id_prest_personales=pr.id_prest_personales');
      $this->db->where('((pr.estado = 1 and pr.aprobado = 1) or (pr.estado = 2 and pr.aprobado = 1))'); 
      $this->db->where('co.id_empleado', $id_empleado);

      $result = $this->db->get();
      return $result->result();
   }

   function amortizacionPrestamos($id_prestamo_personal){
      $this->db->select('*');
      $this->db->from('amortizacion_personales');
      $this->db->where('(estado = 1 or estado = 2 or estado = 3)'); 
      $this->db->where('id_prestamo_personal', $id_prestamo_personal);
      $this->db->order_by('fecha_abono','DESC'); 

      $result = $this->db->get();
      return $result->result();
   }

   function saveRetencion($data){
      $result=$this->db->insert('amortizacion_personales',$data);
      return $result;
   }

   function saveIndemnizacion($data){
      $result=$this->db->insert('indemnizacion',$data);
      return $result;
   }

   function verificarIndemnizacion($agencia,$anio){
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('indemnizacion ind');
        $this->db->join('contrato co', 'ind.id_contrato=co.id_contrato');
        $this->db->where('co.id_agencia', $agencia);                 
        $this->db->where('ind.anio_aplicar', $anio);                                  
        $this->db->where('(ind.estado = 0 or ind.estado = 1)');                                  

        $result = $this->db->get();
        return $result->result();
   }
   //NO31122022 modificar para traer los retenidos
   function datosIndemnizacion($agencia,$anio){
        $this->db->select('em.nombre, em.apellido, em.dui, emp.id_empresa, emp.nombre_empresa, ind.ingreso_empleado, ind.cantidad_bruto, ind.retencion, ind.cantidad_liquida, ind.retencion_indem, ind.anio_aplicar, ind.anticipo, ind.estado, ind.id_indemnizacion, ag.id_agencia, ag.agencia');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('indemnizacion ind', 'ind.id_contrato=co.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_agencia', $agencia);                 
        $this->db->where('ind.anio_aplicar', $anio);
        $this->db->where('ind.estado !=', 2);                                  

        $result = $this->db->get();
        return $result->result();
   }
   

   //NO28122022 funcion para traer a los empleados que aplican a retencion 
   function buscarRetencion($agencia = null, $empresa = null, $anio = null){
    $this->db->select("emp.nombre_empresa,em.nombre, em.apellido, em.dui, ind.ingreso_empleado,ind.retencion_indem, TIMESTAMPDIFF(DAY, ind.ingreso_empleado, '2022-12-31') as antiguedad, categoria_cargo.sbase, ind.cantidad_bruto, ind.retencion, ind.cantidad_liquida, ind.anio_aplicar, ind.anticipo, ag.agencia, co.id_empleado,co.id_contrato, ind.retencion_indem, ind.id_indemnizacion");
    $this->db->from("empleados em");
    $this->db->join("contrato co", 'co.id_empleado= em.id_empleado');
    $this->db->join('categoria_cargo', 'co.id_categoria=categoria_cargo.id_categoria');
    $this->db->join('empresa emp', 'emp.id_empresa = co.id_empresa');
    $this->db->join('indemnizacion ind', 'ind.id_contrato = co.id_contrato');
    $this->db->join('agencias ag', 'ag.id_agencia= co.id_agencia');
    $this->db->where('ind.estado != 2');
    if($anio != null){
    $this->db->where('anio_aplicar =',$anio);    
    }else{
    $this->db->where('anio_aplicar >= 2022');
    }
    if($agencia != null){
        $this->db->where('ag.id_agencia', $agencia);
    }
    if($empresa != null){
        $this->db->where('emp.id_empresa', $empresa);
    }
    $this->db->where('TIMESTAMPDIFF(DAY, ind.ingreso_empleado, "2022-12-31") <= 365');
    $result = $this->db->get();
    return $result->result();
   }

   //funcion para buscar empleados que cuentan con credito 301222
   function buscarempleadocredito($agencia = null, $anio = null){
    $this->db->db_select("Operaciones");
    $this->db->distinct();
    $this->db->select("credito.codigo as codigo, concat(cliente.nombre,' ',cliente.apellido) as nombre, monto_pagar, desembolso.fecha_desembolso, credito.id_cliente, tipo_credito.nombre as nombre_tipo, s.id_solicitud, agencias.agencia, agencias.empresa,agencias.id_agencia, s.monto, tipo_credito.interes_alter, cliente_empleado.id_empleado, tablero.categoria_cargo.sbase, tablero.contrato.id_contrato, tablero.indemnizacion.retencion_indem,tablero.indemnizacion.id_indemnizacion,(select id_contrato from tablero.contrato where id_empleado = cliente_empleado.id_empleado order by fecha_inicio desc limit 1) as ultimo_contrato, tablero.indemnizacion.anio_aplicar");
    $this->db->from('credito_empleado as credito');
    $this->db->join('desembolso_empleado as desembolso', 'desembolso.id_desembolso = credito.id_desembolso');
    $this->db->join('cliente', 'credito.id_cliente = cliente.codigo');
    $this->db->join('solicitud as s', 's.id_solicitud = desembolso.id_solicitud');
    $this->db->join('tipo_credito', 'tipo_credito.id_tipo_credito = s.plazo');
    $this->db->join('cliente_empleado', 'cliente_empleado.id_cliente = cliente.codigo');
    $this->db->join('agencias', 'agencias.id_agencia = credito.agencia');
    $this->db->join('factibilidad', 'factibilidad.id_solicitud = s.id_solicitud');
    $this->db->join("tablero.contrato", 'tablero.contrato.id_empleado = cliente_empleado.id_empleado');
    $this->db->join('tablero.categoria_cargo', 'tablero.contrato.id_categoria = tablero.categoria_cargo.id_categoria');
    $this->db->join('tablero.indemnizacion', 'tablero.indemnizacion.id_contrato = (select id_contrato from tablero.contrato where id_empleado = cliente_empleado.id_empleado and tablero.indemnizacion.estado = 0 order by fecha_inicio desc limit 1)');
    if($agencia != null){
    $this->db->where('agencias.id_agencia =', $agencia);
    }
    if($anio != null){
        $this->db->where('tablero.indemnizacion.anio_aplicar', $anio);
    }
    $this->db->where('substr(fecha_desembolso, 1, 10)>= "2022-01-01" and substr(fecha_desembolso,1,10) <= "2023-12-31"');
    $this->db->where('credito.estado = 1');
    $this->db->where('tablero.contrato.estado = 1 or tablero.contrato.estado = 3 or tablero.contrato.estado = 10');
    $this->db->where('tablero.indemnizacion.estado = 0');
    $result = $this->db->get();
    $this->db->db_select("tablero");
    return $result->result();
   }
    //NO301222 traer los empleados como prestamos personales
   function mostrarEmpleadosPrestamos($agencia = null, $anio =  null){
    $this->db->distinct();
    $this->db->select('em.id_empleado, pe.id_prestamo_personal, em.nombre, em.apellido, ca.cargo, ag.agencia,ag.id_agencia, pe.cuota, pe.monto_otorgado, pe.fecha_otorgado, pe.aprobado, pe.estado, pe.plazo_quincenas, co.estado, indemnizacion.id_indemnizacion,(select id_contrato from contrato where id_empleado = em.id_empleado order by fecha_inicio desc limit 1) as ultimo_contrato, indemnizacion.retencion_indem,indemnizacion.anio_aplicar, categoria_cargo.Sbase, co.id_contrato');
    $this->db->from('contrato as co');
    $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria = co.id_categoria');
    $this->db->join('empleados em', 'em.id_empleado = co.id_empleado');
    $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
    $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
    $this->db->join('prestamos_personales pe', 'pe.id_contrato = co.id_contrato');
    $this->db->join('indemnizacion', 'indemnizacion.id_contrato = (select id_contrato from contrato where id_empleado = em.id_empleado and indemnizacion.estado = 0 order by fecha_inicio desc limit 1)');
    if($agencia != null){
    $this->db->where('ag.id_agencia', $agencia);
    }
    if($anio != null){
        $this->db->where('indemnizacion.anio_aplicar', $anio);
    }

    $this->db->where("((pe.aprobado = 1 and pe.estado =1) or (pe.aprobado = 1 and pe.estado =2))");
    $this->db->where("((select estado from contrato where id_empleado = em.id_empleado order by fecha_inicio desc limit 1) =1 or (select estado from contrato where id_empleado = em.id_empleado order by fecha_inicio desc limit 1) = 3)");
    $result = $this->db->get();
    return $result->result();
   }


   //function para agregar retencion pasiva NO291222
   function addRetencion($id_indemnizacion, $retencion, $cantidad_liquida){
    $data = array(
        'retencion_indem' => $retencion,
        'cantidad_liquida' => $cantidad_liquida,
    );
    $this->db->where("id_indemnizacion", $id_indemnizacion);
    $this->db->update('indemnizacion', $data);
    return true;
   }

   //function para traer el salario base de un contrato NO301222
   function getSalarioBase($id_contrato){
    $this->db->select('categoria_cargo.Sbase');
    $this->db->from('contrato');
    $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria = contrato.id_categoria');
    $this->db->where('contrato.id_contrato', $id_contrato);
    $result = $this->db->get();
    return $result->result();
   }
   //function para traer la retencion de un contrato NO301222
   function  getRetencionIndem($id_indemnizacion){
    $this->db->select("indemnizacion.retencion_indem, indemnizacion.cantidad_liquida, indemnizacion.cantidad_bruto, indemnizacion.id_contrato");
    $this->db->from('indemnizacion');
    $this->db->where("id_indemnizacion", $id_indemnizacion);
    $this->db->order_by('fecha_ingreso', 'DESC');
    $this->db->limit(1);
    $response = $this->db->get();
    return $response->result();
   }
   //function para traer los empleados con retencion aprobadas NO030123
   function getRetenidos($agencia = null){
    $this->db->select('indemnizacion.*, agencias.agencia, empleados.nombre, empleados.apellido, categoria_cargo.Sbase, TIMESTAMPDIFF(DAY, indemnizacion.ingreso_empleado, "2022-12-31") as antiguedad');
    $this->db->from('indemnizacion');
    $this->db->join('contrato', 'contrato.id_contrato = indemnizacion.id_contrato');
    $this->db->join('agencias','agencias.id_agencia = contrato.id_agencia');
    $this->db->join('empleados', 'empleados.id_empleado = contrato.id_empleado');
    $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria = contrato.id_categoria');
    $this->db->where('indemnizacion.retencion_indem != 0');
    $this->db->where('indemnizacion.estado = 1');
    $this->db->where('indemnizacion.anio_aplicar = 2022');
    if($agencia != null){
    $this->db->where('agencias.id_agencia', $agencia);
    }
    $result = $this->db->get();
    return $result->result();
   }



   function buscarAnticipoG($id_empleado,$diaUno,$diaUltimo){
        $this->db->select('sum(an.monto) as total');
        $this->db->from('anticipo_prestaciones an');
        $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);                 
        $this->db->where('an.estado', 1);                                  
        $this->db->where('an.fecha_aplicar BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');                                  

        $result = $this->db->get();
        return $result->result();
   }

   function selectAnticipoPres($id_anticipo_pres){
        $this->db->select('an.id_prestaciones,an.id_contrato,an.id_autorizante,an.monto,an.fecha_aplicar,an.fecha_ingreso,emp.nombre,emp.apellido,emp.dui,emp.nit,empre.id_empresa,empre.nombre_empresa,empre.casa_matriz,agn.agencia,agn.direccion,agn.tel,agn.id_agencia');
        $this->db->from('anticipo_prestaciones an');
        $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
        $this->db->join('empresa empre', 'empre.id_empresa=co.id_empresa');
        $this->db->join('agencias agn', 'agn.id_agencia=co.id_agencia');
        $this->db->join('empleados emp', 'emp.id_empleado=co.id_empleado');
        $this->db->where('an.id_prestaciones', $id_anticipo_pres);                 
        $this->db->where('(an.estado = 1 or an.estado = 2)');                                  
        //$this->db->where('an.fecha_aplicar BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');                                  

        $result = $this->db->get();
        return $result->result();
   }

   function verificarSueldo($id_empleado){
        $this->db->select('sa.monto');
        $this->db->from('salario_inicio sa');
        $this->db->join('contrato co', 'co.id_contrato=sa.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);                 
        $this->db->where('sa.estado', 1);                                  
        
        $result = $this->db->get();
        return $result->result();
   }

   function aprobarIndemnizacion($anio,$agencia,$user){
        $this->db->query('UPDATE indemnizacion, contrato SET indemnizacion.estado = 1, indemnizacion.fecha_aprobacion = "'.date('Y-m-d').'", indemnizacion.id_usuario = '.$user.' WHERE indemnizacion.id_contrato=contrato.id_contrato AND contrato.id_agencia = "'.$agencia.'" and indemnizacion.anio_aplicar = "'.$anio.'" and indemnizacion.estado = 0');

        return true;
   }

   function rechazoIndemnizacion($anio,$agencia,$fecha1,$fecha2){
      $this->db->query('UPDATE indemnizacion, contrato SET indemnizacion.estado = 2 WHERE indemnizacion.id_contrato=contrato.id_contrato AND contrato.id_agencia = "'.$agencia.'" and indemnizacion.anio_aplicar = "'.$anio.'"');

      //Consulta para eliminar los pagos de los prestamos personales que se hacen en la planilla
      $this->db->query('DELETE amortizacion_personales.* FROM amortizacion_personales, prestamos_personales, contrato WHERE amortizacion_personales.id_prestamo_personal=prestamos_personales.id_prestamo_personal and prestamos_personales.id_contrato=contrato.id_contrato and amortizacion_personales.planilla = 3 and contrato.id_agencia = "'.$agencia.'"  and amortizacion_personales.fecha_abono BETWEEN "'.$fecha1.'" and "'.$fecha2.'"');

        return true;
   }

   function verIndemnizacion($empleado,$anio){
        $this->db->select('em.nombre, em.apellido, em.dui, em.nit, co.id_agencia, ag.agencia, emp.id_empresa, emp.nombre_empresa, ind.ingreso_empleado, ind.cantidad_bruto, ind.retencion, ind.cantidad_liquida,ind.retencion_indem, ind.anio_aplicar, ind.estado, ind.fecha_aplicacion, emp.casa_matriz');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('indemnizacion ind', 'ind.id_contrato=co.id_contrato');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('co.id_empleado', $empleado);                 
        $this->db->where('ind.anio_aplicar', $anio);
        $this->db->where('ind.estado !=', 2);                                  

        $result = $this->db->get();
        return $result->result();
   }

   function empleadosAnt($code){
        $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
        $this->db->where('co.id_agencia', $code);
        $this->db->where('em.activo', 1);
        $this->db->where('(co.estado = 1 or co.estado = 3  or co.estado = 10)');
         

        $query = $this->db->get();
        return $query->result();
   }

   function busquedaFecha(){
        $this->db->select('*');
        $this->db->from('gestion_cierre_anio');
        $this->db->where('aplicado', 2);
        $this->db->where('estado', 1);

        $query = $this->db->get();
        return $query->result();
   }

   function gestionAnticipos($id_empleado,$diaUno,$diaUltimo){
        $this->db->select('SUM(an.monto) as cantidad');
        $this->db->from('anticipo_prestaciones an');
        $this->db->join('contrato co', 'an.id_contrato=co.id_contrato');
        $this->db->where('co.id_empleado', $id_empleado);
        $this->db->where('an.estado', 1);
        $this->db->where('an.fecha_aplicar BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"');

        $query = $this->db->get();
        return $query->result();
   }

   function ingresarAnticpoG($data){
        $result=$this->db->insert('anticipo_prestaciones',$data);
        return $result;
   }

   function datosPersonalesP($id_empleado){
        $this->db->select('em.nombre, em.apellido, em.dui, ag.agencia, ca.cargo, pl.nombrePlaza, emp.id_empresa');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('plaza pl', 'pl.id_plaza=co.id_plaza');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->where('co.id_empleado', $id_empleado); 
        $this->db->where('(co.estado = 1 or co.estado = 3)'); 

        $result = $this->db->get();
        return $result->result();
   }

   function datosAnticipo($code,$diaUno,$diaUltimo){
        $this->db->select('an.*');
        $this->db->from('anticipo_prestaciones an');
        $this->db->join('contrato co', 'co.id_contrato=an.id_contrato');
        $this->db->where('co.id_empleado', $code);
        $this->db->where('(an.estado = 1 or an.estado = 2)');
        if($diaUno != null && $diaUltimo != null){
          $this->db->where('an.fecha_aplicar BETWEEN"'.$diaUno.'" and "'.$diaUltimo.'"'); 
        } 

        $result = $this->db->get();
        return $result->result();
   }

   function verAutorizacionAnticipoG($id_autorizante){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        //$this->db->join('permisos_empleados pe', 'pe.id_cont_autorizado = co.id_contrato ');
        $this->db->where('co.id_contrato', $id_autorizante);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
   }

   function deleteAnticipoG($code){
        $data = array(
              'estado'              => 0
     
        );
        $this->db->where('id_prestaciones', $code);
        $this->db->update('anticipo_prestaciones', $data);
        return true;
   }

   function agenciasLiq($agencia){
        $this->db->select('*');
        $this->db->from('agencias');
        if($agencia != 'todas'){
          $this->db->where('id_agencia', $agencia);
        }
        
        $query = $this->db->get();
        return $query->result();
   }

   function buscarTotalAg($id_agencia,$anio,$empresa){
        $this->db->select('SUM(al.cantidad - al.isr) as monto, emp.nombre_empresa');
        $this->db->from('aguinaldo al');
        $this->db->join('contrato co', 'co.id_contrato=al.id_contrato');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->where('co.id_agencia', $id_agencia);
        $this->db->where('al.anio_aplicar', $anio);
        if($empresa != 'todas'){
          $this->db->where('co.id_empresa', $empresa);
        }
        $this->db->where('al.estado', 1);
        $this->db->group_by('emp.nombre_empresa');

        $query = $this->db->get();
        return $query->result();
   }

   function empleadosGestiones($code){
        $this->db->select('co.id_contrato,co.id_empleado,co.id_empresa, em.nombre, em.apellido, em.dui, ca.cargo');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('agencias ag', 'co.id_agencia = ag.id_agencia');
        $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');         
        $this->db->where('co.id_agencia', $code);
        $this->db->where('em.activo', 1);
        $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');
         
        $query = $this->db->get();
        return $query->result();
   }

   function jefeRRHH(){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('areas ar', 'ar.id_area=ca.id_area');
        $this->db->where('ar.area LIKE "%Recursos Humanos%"');
        $this->db->where('(ca.cargo like "%jefe%" or ca.cargo like "%jefa%")');
        $this->db->where('(co.estado = 1 or co.estado = 3 or co.estado = 10)');
        $this->db->where('em.activo', 1);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
         
        $query = $this->db->get();
        return $query->result();
   }

   function agenciasEmpresaA($id){
        $this->db->select('ag.id_agencia,ag.agencia');
        $this->db->from('agencias ag');
        $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
        if($id != 'todas'){
          $this->db->where('ea.id_empresa',$id);
        }
        $this->db->where('ea.estado',1);
        $this->db->group_by('ag.id_agencia');
        $this->db->group_by('ag.agencia');

        $query = $this->db->get();
        return $query->result();
   }

   function empresasFirmas($agencia){
        $this->db->select('emp.nombre_empresa, emp.id_empresa');
        $this->db->from('empresa emp');
        $this->db->join('empresa_agencia ea', 'ea.id_empresa=emp.id_empresa');
        $this->db->join('agencias ag', 'ag.id_agencia=ea.id_agencia');
        $this->db->where('ea.id_agencia', $agencia);
        $this->db->where('ea.estado', 1);
        
        $query = $this->db->get();
        return $query->result();
   }

   function buscarTotalIn($id_agencia,$anio,$empresa){
        $this->db->select('SUM(ind.cantidad_bruto) as bruto, SUM(ind.retencion) as retencion, SUM(ind.anticipo) as anticipo, SUM(ind.cantidad_liquida) as liquido, emp.nombre_empresa');
        $this->db->from('indemnizacion ind');
        $this->db->join('contrato co', 'co.id_contrato=ind.id_contrato');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->where('co.id_agencia', $id_agencia);
        $this->db->where('ind.anio_aplicar', $anio);
        if($empresa != 'todas'){
          $this->db->where('co.id_empresa', $empresa);
        }
        $this->db->where('ind.estado', 1);
        $this->db->group_by('emp.nombre_empresa');

        $query = $this->db->get();
        return $query->result();
   }

   function empleadosFima($agencia,$anio,$empresa){
        $this->db->select('em.nombre, em.apellido, emp.id_empresa, ag.id_agencia, ag.agencia, al.cantidad');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('aguinaldo al', 'al.id_contrato=co.id_contrato');
        $this->db->where('al.estado', 1);
        $this->db->where('co.id_agencia', $agencia);
        $this->db->where('co.id_empresa', $empresa);
        $this->db->where('al.anio_aplicar', $anio);

        $query = $this->db->get();
        return $query->result();
   }

   function empleadosIndem($agencia,$anio,$empresa){
        $this->db->select('em.nombre, em.apellido, emp.id_empresa, ag.id_agencia, ag.agencia');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado=co.id_empleado');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->join('indemnizacion ind', 'ind.id_contrato=co.id_contrato');
        $this->db->where('ind.estado', 1);
        $this->db->where('co.id_agencia', $agencia);
        $this->db->where('co.id_empresa', $empresa);
        $this->db->where('ind.anio_aplicar', $anio);

        $query = $this->db->get();
        return $query->result();
   }

   function estadosIndemnizacion($diaUno,$diaUltimo,$agencia,$estado){
      if($estado == 1){
        $this->db->query('UPDATE anticipo_prestaciones, contrato SET anticipo_prestaciones.estado = 2 WHERE anticipo_prestaciones.estado = 1 and anticipo_prestaciones.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and anticipo_prestaciones.fecha_aplicar BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');
      }else if($estado == 2){
        $this->db->query('UPDATE anticipo_prestaciones, contrato SET anticipo_prestaciones.estado = 1 WHERE anticipo_prestaciones.estado = 2 and anticipo_prestaciones.id_contrato=contrato.id_contrato and contrato.id_agencia = "'.$agencia.'" and anticipo_prestaciones.fecha_aplicar BETWEEN "'.$diaUno.'" and "'.$diaUltimo.'"');
      }

      return true;
   }

   function datos_auto($id_empleado){
        $this->db->select('concat(em.nombre," ",em.apellido) as nombre, ca.cargo');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'co.id_empleado=em.id_empleado');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->where('em.id_empleado', $id_empleado);
        $this->db->order_by('co.id_contrato','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
   }

   function buscar_vacacion($id_empleado,$fechaQuin1,$fechaQuin2){
        $this->db->select('vacaciones.*');
        $this->db->from('vacaciones');
        $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');

        $this->db->where('vacaciones.aprobado = 1 and vacaciones.ingresado = 1 and (vacaciones.estado = 1 or vacaciones.estado = 2)');
        $this->db->where('contrato.id_empleado',$id_empleado);
        $this->db->where('vacaciones.fecha_aplicacion >=',$fechaQuin1);
        $this->db->where('vacaciones.fecha_aplicacion <=',$fechaQuin2);

        $query = $this->db->get();
        return $query->result();
   }
   
   function empleado_viatico_inactivo($id_empleado,$mes){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('(estado = 7 or estado = 8)');
    $this->db->where('id_empleado',$id_empleado);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
   }

   function datos_liquidacion(){
        $this->db->select('empleados.id_empleado, agencias.agencia, concat(empleados.nombre," ",empleados.apellido) as nombre, liquidacion.descuentos, liquidacion.prestamo_personal,liquidacion.fecha_fin,liquidacion.id_contrato');
        $this->db->from('liquidacion');
        $this->db->join('contrato', 'contrato.id_contrato=liquidacion.id_contrato');
        $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
        $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
        $this->db->join('prestamos_personales', 'prestamos_personales.id_contrato=contrato.id_contrato');
        $this->db->where('liquidacion.estado = 1 and ((liquidacion.descuentos > 0 and prestamos_personales.estado = 1 and prestamos_personales.estado = 1) or liquidacion.prestamo_personal > 0)');

        $this->db->group_by('agencias.agencia');
        $this->db->group_by('empleados.nombre');
        $this->db->group_by('empleados.apellido');
        $this->db->group_by('liquidacion.descuentos');
        $this->db->group_by('liquidacion.prestamo_personal');
        $this->db->group_by('empleados.id_empleado');
        $this->db->group_by('liquidacion.fecha_fin');
        $this->db->group_by('liquidacion.id_contrato');

        $query = $this->db->get();
        return $query->result();
   }

   function prestasmos_personales($id_empleado){
        $this->db->select('tipo_prestamos_personales.porcentaje,amortizacion_personales.*');
        $this->db->from('amortizacion_personales');
        $this->db->join('prestamos_personales', 'prestamos_personales.id_prestamo_personal=amortizacion_personales.id_prestamo_personal');
        $this->db->join('contrato', 'contrato.id_contrato=prestamos_personales.id_contrato');
        $this->db->join('tipo_prestamos_personales', 'tipo_prestamos_personales.id_prest_personales=prestamos_personales.id_prest_personales');

        $this->db->where('contrato.id_empleado',$id_empleado);
        $this->db->where('prestamos_personales.aprobado = 1 and prestamos_personales.estado = 1');
        $this->db->order_by('amortizacion_personales.fecha_abono','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
   }

   function descuento_herr($id_empleado){
        $this->db->select('pagos_descuento_herramienta.*');
        $this->db->from('pagos_descuento_herramienta');
        $this->db->join('descuento_herramienta', 'descuento_herramienta.id_descuento_herramienta=pagos_descuento_herramienta.id_descuento_herramienta');
        $this->db->join('contrato', 'contrato.id_contrato=descuento_herramienta.id_contrato');

        $this->db->where('contrato.id_empleado',$id_empleado);
        $this->db->where('descuento_herramienta.estado = 1');
        $this->db->order_by('pagos_descuento_herramienta.fecha_ingreso','DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
   }

    function get_empleado($id_empleado){
        $this->db->select('concat(nombre, " " ,apellido) as nombre');
        $this->db->from('empleados');
    
        $this->db->where('id_empleado', $id_empleado);                 
                               
        $result = $this->db->get();
        return $result->result();
   }

   //Proximo subir 28122022
    function usuario_agencias($id_agencia)
      {
          $this->db->db_select('Operaciones');

          $this->db->select('*');
          $this->db->from('usuarios');

          $this->db->join('roles','roles.id_rol=usuarios.id_rol');

          $this->db->where('id_agencia',$id_agencia);
          $this->db->where('usuarios.id_usuarios NOT IN (SELECT id_usuarios from usuario_cartera)');
          $this->db->where('id_estado',1);
          $this->db->where("(roles.id_rol = '4' or roles.id_rol = '5' or roles.id_rol = '13')");


          $result = $this->db->get();

        $this->db->db_select('tablero');
          return $result->result();
      }
        function contratos_empleado($id_empleado){
        $this->db->select('co.id_contrato,cc.Sbase, em.nombre, em.apellido, co.id_empleado, co.fecha_inicio, co.tipo_des_ren, co.estado');
        $this->db->from('contrato co'); 
        $this->db->join('empleados em', 'em.id_empleado=co.id_empleado');
        $this->db->join('categoria_cargo cc', 'cc.id_categoria=co.id_categoria');
        $this->db->join('empresa emp', 'emp.id_empresa=co.id_empresa');
        $this->db->join('cargos ca', 'ca.id_cargo=co.id_cargo');
        $this->db->join('agencias ag', 'ag.id_agencia=co.id_agencia');
        $this->db->where('em.id_empleado',$id_empleado);
        $this->db->order_by('co.id_contrato','ASC');


        $query = $this->db->get();
        return $query->result();
   }

}
