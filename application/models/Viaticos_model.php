<?php
class Viaticos_model extends CI_Model{

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

  function saveViaticos($cantidad_viatico,$forma_viatico,$fecha_viatico,$fecha,$contrato,$quincenas,$tipo_viatico,$autorizado){
       $data = array(
                'cantidad'            => $cantidad_viatico,  
                'tipo'                => $forma_viatico,
                'fecha_aplicacion'    => $fecha_viatico,
                'quincenas'           => $quincenas,
                'quincenas_restante'  => $quincenas,
                'fecha_creacion'      => $fecha,
                'id_contrato'         => $contrato,
                'id_tipo_viaticos'    => $tipo_viatico,
                'id_cont_autorizado'  => $autorizado,
                'estado'              => 1,
            );
        $result=$this->db->insert('viaticos',$data);
         return $result;
  }

  function verViaticos($id_empleado,$orden,$fecha_inicio){
     $this->db->select('vi.id_viaticos,em.nombre, em.apellido, em.dui, ag.agencia, ca.cargo, format(vi.cantidad,2) as cantidad, vi.tipo, vi.fecha_aplicacion,vi.fecha_creacion,vi.quincenas, vi.estado,tv.nombre as tViatico,vi.id_cont_autorizado');
     $this->db->from('empleados  em');
     $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
     $this->db->join('agencias ag', 'ag.id_agencia = co.id_agencia');
     $this->db->join('cargos ca', 'ca.id_cargo = co.id_cargo');
     $this->db->join('viaticos vi', 'vi.id_contrato = co.id_contrato');
     $this->db->join('tipo_viaticos tv', 'tv.id_tipo_viaticos=vi.id_tipo_viaticos');
     $this->db->where('em.id_empleado', $id_empleado);
     if($orden == 0 || $orden == 1){
        $this->db->where('vi.estado', $orden);
     }
     if($fecha_inicio != null){
        $this->db->where('vi.fecha_aplicacion >=', $fecha_inicio);
     }
     $this->db->group_by('em.nombre');
     $this->db->group_by('em.apellido');
     $this->db->group_by('em.dui');
     $this->db->group_by('ag.agencia');
     $this->db->group_by('ca.cargo');
     $this->db->group_by('vi.cantidad');
     $this->db->group_by('vi.tipo');
     $this->db->group_by('vi.fecha_aplicacion');
     $this->db->group_by('vi.fecha_creacion');
     $this->db->group_by('vi.quincenas');
     $this->db->group_by('vi.estado');
     $this->db->group_by('tv.nombre');
     $this->db->group_by('vi.id_viaticos');
     $this->db->group_by('vi.id_cont_autorizado');

     $query = $this->db->get();
     return $query->result();
  }

  function verAuto($id_autorizacion){
        $this->db->select('em.nombre, em.apellido');
        $this->db->from('empleados em');
        $this->db->join('contrato co', 'em.id_empleado = co.id_empleado');
        $this->db->join('viaticos vi', 'vi.id_cont_autorizado = co.id_contrato');
        $this->db->where('co.id_contrato', $id_autorizacion);
        $this->db->group_by('em.nombre');
        $this->db->group_by('em.apellido');
        
        $query = $this->db->get();
        return $query->result();
    }

  function viaticoEdit($code){
    $this->db->select('format(cantidad, 2) as cantidad, tipo, fecha_aplicacion, quincenas, id_tipo_viaticos');
    $this->db->from('viaticos');
    $this->db->where('id_viaticos', $code); 

    $result = $this->db->get();
    return $result->result();
  }

  function updateViaticos($code,$tipo,$cantidad,$forma,$fecha_aplicacion,$fecha_final){
    $this->db->set('cantidad', $cantidad);
    $this->db->set('tipo', $forma); 
    $this->db->set('fecha_aplicacion', $fecha_aplicacion);
    if(!($fecha_final == null)){    
        $this->db->set('quincenas', $fecha_final);           
    }
    $this->db->set('id_tipo_viaticos', $tipo);
    $this->db->where('id_viaticos', $code);

    $result=$this->db->update('viaticos');
    return $result;
  }

  function deleteViaticos($code,$planilla){
    $data = array(
        'estado'    => 0,
        'planilla'  => $planilla,
    );

    $this->db->where('id_viaticos', $code);
    $this->db->update('viaticos', $data);
    return true;
  }

//METODOS PARA LOS TIPOS DE VIATICOS
  function VerTipoViaticos(){
    //tipos de viaticos actuales activos
    $this->db->select('*');
    $this->db->from('tipo_viaticos'); 
    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  function saveTiposViaticos($tipo_name,$tipo_viatico,$descripcion,$fecha){

    $data = array(
        'nombre'            => $tipo_name,  
        'tipo'              => $tipo_viatico,  
        'descripcion'       => $descripcion,
        'fecha'             => $fecha,
        'estado'            => 1,
    );
    $result=$this->db->insert('tipo_viaticos',$data);
    return $result;
  }

  function updateTiposViaticos($code,$nombre,$tipo,$descripcion,$fecha){
    $data = array(
        'nombre'            => $nombre, 
        'tipo'              => $tipo, 
        'descripcion'       => $descripcion, 
        'fecha'             => $fecha,
    );
    $this->db->where('id_tipo_viaticos', $code);
    $this->db->update('tipo_viaticos', $data);
    return true;
  }

  function deleteTiposViaticos($code){
    $data = array(
         'estado'            => 0,
    );
    $this->db->where('id_tipo_viaticos', $code);
    $this->db->update('tipo_viaticos', $data);
    return true;
  }

  function getTipoViatico(){
    $this->db->select('id_tipo_viaticos, nombre');
    $this->db->from('tipo_viaticos'); 
    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  function empleados_min(){
    $this->db->select('empleados.nombre, empleados.apellido, contrato.id_contrato, categoria_cargo.Sbase');
    $this->db->from('contrato');
    $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
    $this->db->join('categoria_cargo', 'categoria_cargo.id_categoria=contrato.id_categoria');
    $this->db->where('(contrato.estado = 1 or contrato.estado = 3) and categoria_cargo.Sbase = 304.17');
        
    $query = $this->db->get();
    return $query->result();
  }

  function viaticos_gob($data){
    $result=$this->db->insert('viaticos',$data);
    return $result;
  }

  function precio_gas(){
    //precios actuales de la gasolina
    $this->db->select('*');
    $this->db->from('precio_gasolina'); 
    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  function precios_datos($precio){
    $this->db->select('*');
    $this->db->from('precio_gasolina'); 
    $this->db->where('id_precio',$precio);

    $result = $this->db->get();
    return $result->result();
  }

  function update_precio($precio,$codigo_precio){
    $this->db->where('id_precio', $codigo_precio);
    $this->db->update('precio_gasolina', $precio);
    return true;
  }

  function insert_precio($data){
    $result=$this->db->insert('precio_gasolina',$data);
    return $result;
  }

  function moto_base($id_moto=null){
    $this->db->select('*');
    $this->db->from('motocicleta_base');
    if($id_moto != null){
      $this->db->where('id_motocicleta',$id_moto);
    }else{
      $this->db->where('estado',1);
    } 

    $result = $this->db->get();
    return $result->result();
  }

  function update_moto($moto,$codigo){
    $this->db->where('id_motocicleta', $codigo);
    $this->db->update('motocicleta_base', $moto);
    return true;
  }

  function insert_moto($data){
    $result=$this->db->insert('motocicleta_base',$data);
    return $result;
  }

  function agencias_listas($admin=null){
      $this->db->select('id_agencia, agencia');
      $this->db->from('agencias');
      $this->db->order_by('agencia','ASC');
      if($admin==null){
        $this->db->where('id_agencia != 24 and id_agencia != 00');
      }else{
        $this->db->where('id_agencia != 24');
      }
      $result = $this ->db->get();
      return $result->result();
  }

  function all_carteras($agencia=null,$empresa=null){
    $this->db->db_select('Operaciones');
    $this->db->select('carteras.id_cartera, carteras.cartera, carteras.KM, carteras.vehiculo, concat(usuarios.nombre," ",usuarios.apellido) as nombre, usuarios.id_usuarios, carteras.id_agencia, agencias.agencia');
    $this->db->from('carteras');
    $this->db->join('usuario_cartera', 'usuario_cartera.id_cartera=carteras.id_cartera');
    $this->db->join('usuarios', 'usuarios.id_usuarios=usuario_cartera.id_usuarios');
    $this->db->join('agencias', 'agencias.id_agencia=carteras.id_agencia');
    $this->db->join('tablero.login as login', 'login.id_login=usuarios.id_usuarios');
    $this->db->join('tablero.empleados as empleados', 'empleados.id_empleado=login.id_empleado');
    $this->db->join('tablero.contrato as contrato', 'contrato.id_empleado=empleados.id_empleado');

    $this->db->where('carteras.activo = 1 and carteras.id_agencia != 24');
    if($agencia != null){
      $this->db->where('contrato.id_agencia',$agencia);
    }
    if($empresa != null){
      $this->db->where('contrato.id_empresa',$empresa);
    }
    $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');

    $this->db->group_by('carteras.id_cartera, carteras.cartera, carteras.KM, carteras.vehiculo, nombre, usuarios.id_usuarios, carteras.id_agencia, agencias.agencia');
    $this->db->order_by('agencias.agencia','ASC');
    
    $query = $this->db->get();
    $this->db->db_select('tablero');
    return $query->result();
  }

  function precios_zona($id_agencia){
    $this->db->select('precio_gasolina.precio, agencias.agencia, if(agencias.zona = 1, "Central", if(agencias.zona = 2, "Occidental", "Oriental")) as zona');
    $this->db->from('agencias'); 
    $this->db->join('precio_gasolina', 'precio_gasolina.zona=agencias.zona');
    $this->db->where('agencias.id_agencia',$id_agencia);
    $this->db->where('precio_gasolina.estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  function depreciacion_motocicleta($codigo=null){
    $this->db->select('*');
    $this->db->from('depreciacion_motocicleta');
    if($codigo != null){
      $this->db->where('id_depreciacion',$codigo);
    }else{
      $this->db->where('estado !=',0);
    } 
    $this->db->order_by('estado','ASC');

    $result = $this->db->get();
    return $result->result();
  }

  function update_depreciacion($data,$codigo){
    $this->db->where('id_depreciacion', $codigo);
    $this->db->update('depreciacion_motocicleta', $data);
    return true;
  }

  function insert_depreciacion($data){
    $result=$this->db->insert('depreciacion_motocicleta',$data);
    return $result;
  }

  function insert_viaticos($viaticos){
    $result=$this->db->insert('viaticos_carteras',$viaticos);
    return $result;
  }

  function get_viaticos($cartera,$quincena,$mes,$estado=null){
    $this->db->select('agencias.agencia,concat(empleados.nombre," ",empleados.apellido) as nombre,viaticos_carteras.*');
    $this->db->from('viaticos_carteras');
    $this->db->join('agencias', 'agencias.id_agencia=viaticos_carteras.id_agencia');
    $this->db->join('empleados', 'empleados.id_empleado=viaticos_carteras.id_empleado');
    if($cartera != null){
      $this->db->where('viaticos_carteras.id_cartera = ',$cartera);
    }
    $this->db->where('viaticos_carteras.quincena',$quincena);
    $this->db->where('viaticos_carteras.mes',$mes);
    if($estado!=null){
      $this->db->where('viaticos_carteras.estado',$estado);
    }
    $this->db->order_by('agencia','ASC');

    $result = $this->db->get();
    return $result->result();
  }

  function rechazar_viaticos($empresa,$agencia,$quincena,$mes){
    $cons = '';
    if($agencia != null){
      $cons .= ' and contrato.id_agencia = '.$agencia.' ';
    }

    if($empresa != null){
      $cons .= ' and contrato.id_empresa = '.$empresa.' ';
    }

    $this->db->query('DELETE viaticos_carteras.* FROM viaticos_carteras,  contrato
    WHERE viaticos_carteras.id_empleado=contrato.id_empleado
    '.$cons.' and viaticos_carteras.quincena = '.$quincena.' and viaticos_carteras.mes = "'.$mes.'" and viaticos_carteras.estado = 1');
    return true;
  }

  function viaticos_rechazar($data){
    $data=implode(',', $data);
    $this->db->where('id_viaticos_cartera in  ('.$data.')');
    $this->db->delete('viaticos_carteras');
  }

  function login_emplados($id_usuarios){
      $this->db->select('id_empleado');
      $this->db->from('login');
      $this->db->where('id_login',$id_usuarios);
      $result = $this ->db->get();
      return $result->result();
  }

  function login_contrato($id_empleado){
      $this->db->select('*');
      $this->db->from('contrato');
      $this->db->where('id_empleado',$id_empleado);
      $this->db->where('(estado = 1 or estado = 3)');

      $result = $this ->db->get();
      return $result->result();
  }

  function empleados_get($id_agencia){
    $this->db->select('empleados.id_empleado, agencias.agencia, empresa.nombre_empresa,concat(empleados.nombre," ",empleados.apellido) as nombre, cargos.cargo');
    $this->db->from('empleados');
    $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
    $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
    $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
    $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');

    $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
    $this->db->where('contrato.id_agencia', $id_agencia);
    $this->db->order_by('empleados.nombre','ASC');

    $result = $this->db->get();
    return $result->result();
  }

  function viaticos_temp($id_empleado,$mes,$quincena){
    $this->db->select('sum(consumo_ruta) as consumo_ruta, sum(depreciacion) as depreciacion, sum(llanta_del) as llanta_del, sum(llanta_tra) as llanta_tra, sum(mant_gral) as mant_gral, sum(aceite) as aceite, sum(total) as total');
    $this->db->from('viaticos_carteras');
    $this->db->where('id_empleado',$id_empleado);
    $this->db->where('mes',$mes);
    $this->db->where('quincena',$quincena);
    $this->db->where('estado != 1 and estado != 0');

    $result = $this ->db->get();
    return $result->result();
  }

  function carteras_viaticos($agencia,$cartera=null){
    $this->db->db_select('Operaciones');

    $this->db->select('*');
    $this->db->from('carteras');
    $this->db->where('id_agencia',$agencia);
    $this->db->where('activo = 1');
    if($cartera != null){
      $this->db->where('id_cartera',$cartera);
    }

    $result = $this ->db->get();
    $this->db->db_select('tablero');
    return $result->result();
  }

  function verificar_ruta($id_cartera,$quincena,$mes,$estado){
    $this->db->select('*');
    $this->db->from('viaticos_carteras');
    $this->db->where('estado',$estado);
    $this->db->where('mes',$mes);
    $this->db->where('quincena',$quincena);
    $this->db->where('id_cartera',$id_cartera);

    $result = $this->db->get();
    return $result->result();
  }

  function update_viaticos($viaticos,$id_viaticos_cartera){
    $this->db->where('id_viaticos_cartera', $id_viaticos_cartera);
    $this->db->update('viaticos_carteras', $viaticos);
    return true;
  }

  function datos_empleado($id_empleado){
    $this->db->select('concat(empleados.nombre," ",empleados.apellido) as nombre, agencias.agencia, cargos.cargo, empleados.dui');
    $this->db->from('empleados');
    $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
    $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');
    $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');

    $this->db->where('empleados.id_empleado', $id_empleado);
    $this->db->group_by('empleados.nombre');
    $this->db->group_by('empleados.apellido');
    $this->db->group_by('agencias.agencia');
    $this->db->group_by('cargos.cargo');
    $this->db->group_by('empleados.dui');

    $result = $this->db->get();
    return $result->result();
  }

  function viaticos_empleado($id_empleado,$mes,$quincena=null,$estado=null){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 
    $this->db->where('id_empleado',$id_empleado);
    $this->db->where('estado != 0');
    if($mes != null){
      $this->db->where('mes',$mes);
    }
    if($quincena != null and $quincena != 0){
      $this->db->where('quincena',$quincena);
    }

    $this->db->order_by('mes','DESC');
    if($estado == 1){
      $this->db->limit(1); 
    }

    $result = $this->db->get();
    return $result->result();
  }

  function agencia_buscar($empleado){
    $this->db->select('*');
    $this->db->from('contrato'); 
    $this->db->where('id_empleado',$empleado);

    $this->db->order_by('fecha_inicio','DESC');
    $this->db->limit(1); 


    $result = $this->db->get();
    return $result->result();
  }

  function viaticos_efectivos($id_agencia,$quincena,$mes){
    $this->db->select('viaticos_carteras.id_empleado,viaticos_efectivos.quincena, viaticos_efectivos.mes, concat(empleados.nombre," ",empleados.apellido) as nombre, agencias.agencia,cargos.cargo, SUM(viaticos_efectivos.consumo_ruta) as consumo_ruta, SUM(viaticos_efectivos.depreciacion) as depreciacion, SUM(viaticos_efectivos.llanta_del) as llanta_del, SUM(viaticos_efectivos.llanta_del) as llanta_del, SUM(viaticos_efectivos.llanta_tra) as llanta_tra, SUM(viaticos_efectivos.mant_gral) as mant_gral, SUM(viaticos_efectivos.aceite) as aceite, SUM(viaticos_efectivos.total) as total');
    $this->db->from('viaticos_efectivos');

    $this->db->join('contrato', 'contrato.id_contrato=viaticos_efectivos.id_contrato');
    $this->db->join('viaticos_carteras', 'viaticos_carteras.id_viaticos_cartera=viaticos_efectivos.id_viaticos_cartera');
    $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado');
    $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
    $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');

    $this->db->where('contrato.id_agencia', $id_agencia);
    $this->db->where('viaticos_efectivos.estado', 1);
    $this->db->where('viaticos_efectivos.mes', $mes);
    $this->db->where('viaticos_efectivos.quincena', $quincena);

    $this->db->group_by('viaticos_carteras.id_empleado');
    $this->db->group_by('empleados.nombre');
    $this->db->group_by('empleados.apellido');
    $this->db->group_by('agencias.agencia');
    $this->db->group_by('viaticos_efectivos.quincena');
    $this->db->group_by('viaticos_efectivos.mes');
    $this->db->group_by('cargos.cargo');

    $result = $this->db->get();
    return $result->result();
  }

  function efectovos_datos($empleado,$quincena,$mes){
    $this->db->select('viaticos_carteras.estado as tipo, viaticos_efectivos.*');
    $this->db->from('viaticos_efectivos'); 
    $this->db->join('contrato', 'contrato.id_contrato=viaticos_efectivos.id_contrato');
    $this->db->join('viaticos_carteras', 'viaticos_carteras.id_viaticos_cartera=viaticos_efectivos.id_viaticos_cartera');

    $this->db->where('contrato.id_empleado',$empleado);
    $this->db->where('viaticos_efectivos.mes',$mes);
    $this->db->where('viaticos_efectivos.quincena',$quincena);
    $this->db->where('viaticos_efectivos.estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  function buscar_viaticos($empresa,$agencia,$quincena,$mes){
    $this->db->select('*');
    $this->db->from('viaticos_efectivos'); 
    $this->db->join('viaticos_carteras', 'viaticos_carteras.id_viaticos_cartera=viaticos_efectivos.id_viaticos_cartera');
    $this->db->join('contrato', 'contrato.id_contrato=viaticos_efectivos.id_contrato');
    if($agencia != null){
      $this->db->where('viaticos_carteras.id_agencia',$agencia);
    }
    if($empresa != null){
      $this->db->where('contrato.id_empresa',$empresa);
    }
    $this->db->where('viaticos_efectivos.mes',$mes);
    $this->db->where('viaticos_efectivos.quincena',$quincena);
    $this->db->where('viaticos_carteras.estado = 1');

    $result = $this->db->get();
    return $result->result();
  }

  function viaticos_agencia($empresa,$estado=null){
    $this->db->select('ag.id_agencia,ag.agencia');
    $this->db->from('agencias ag');
    $this->db->join('empresa_agencia ea', ' ea.id_agencia=ag.id_agencia');
    if($empresa != null){
      $this->db->where('ea.id_empresa',$empresa);
    }
    $this->db->where('ea.estado',1);
    $this->db->where('ag.id_agencia != 24');
    if($estado==null){
      $this->db->where('ag.id_agencia != 00');
    }
    $this->db->group_by('ag.id_agencia');
    $this->db->group_by('ag.agencia');
    $this->db->order_by('ag.agencia','ASC');

    $query = $this->db->get();
    return $query->result();
  }

  function empleados_inactivos($empresa=null,$agencia=null,$mes=null){
    $this->db->select('empleados.id_empleado, concat(empleados.nombre," ",empleados.apellido) as nombre, agencias.agencia, empresa.nombre_empresa, cargos.cargo, contrato.fecha_fin, contrato.tipo_des_ren');
    $this->db->from('empleados');
    $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
    $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
    $this->db->join('empresa', 'empresa.id_empresa=contrato.id_empresa');
    $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');

    if($empresa != null){
      $this->db->where('contrato.id_empresa',$empresa);
    }
    if($agencia != null){
      $this->db->where('contrato.id_agencia',$agencia);
    }
    if($mes != null){
      $this->db->where('substr(contrato.fecha_fin,1,7) =',$mes);
    }
    $this->db->where('(contrato.estado = 0 or contrato.estado = 4)');
    $this->db->order_by('contrato.fecha_fin','DESC');

    $query = $this->db->get();
    return $query->result();
  }

  function viaticos_inactivo_all($id_empleado,$mes){
    $this->db->select('SUM(total) as total');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('(estado = 7 or estado = 8)');
    $this->db->where('mes',$mes);
    $this->db->where('id_empleado',$id_empleado);

    $result = $this->db->get();
    return $result->result();
  }

  function viaticos_inactivo($id_empleado,$mes=null){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('(estado = 7 or estado = 8)');
    $this->db->where('id_empleado',$id_empleado);
    if($mes != null){
      $this->db->where('mes',$mes);
    }

    $result = $this->db->get();
    return $result->result();
  }

  //PROXIMO SUBIR 29032022
   function obtener_km($id_cartera){
    $this->db->db_select('Operaciones');

    $this->db->select('*');
    $this->db->from('carteras'); 

    $this->db->where('id_cartera',$id_cartera);

    $query = $this->db->get();
    $this->db->db_select('tablero');
    return $query->result();
  }
  //FIN

  function dias_uso($id_empleado,$quincena,$mes,$estado){
    $this->db->select('SUM(dias) as dias');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('estado',$estado);
    $this->db->where('id_empleado',$id_empleado);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }

  function dias_cartera($id_cartera,$quincena,$mes,$estado){
    $this->db->select('SUM(dias) as dias');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('estado',$estado);
    $this->db->where('id_cartera',$id_cartera);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }


  function buscar_viatico($id_cartera,$quincena,$mes,$estado){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('estado',$estado);
    //$this->db->where('id_empleado',$id_empleado);
    $this->db->where('id_cartera',$id_cartera);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }

  function buscar_viatico_empleado($id_empleado,$quincena,$mes,$estado){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('estado',$estado);
    $this->db->where('id_empleado',$id_empleado);
    //$this->db->where('id_cartera',$id_cartera);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }

  function eliminar_viaticos($id_viaticos_cartera){
    $this->db->where('id_viaticos_cartera', $id_viaticos_cartera);
    $this->db->delete('viaticos_carteras');
    return true;

  }

  function datos_viaticos($id_viaticos_cartera){
    $this->db->select('*');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('id_viaticos_cartera',$id_viaticos_cartera);

    $result = $this->db->get();
    return $result->result();
  
  }

  function datos_carteras($id_empleado=null,$id_cartera=null){
    $this->db->db_select('Operaciones');
    $this->db->select('carteras.id_cartera, carteras.cartera, carteras.KM, carteras.vehiculo, concat(usuarios.nombre," ",usuarios.apellido) as nombre, usuarios.id_usuarios, carteras.id_agencia, agencias.agencia, login.id_empleado');
    $this->db->from('carteras');
    $this->db->join('usuario_cartera', 'usuario_cartera.id_cartera=carteras.id_cartera');
    $this->db->join('usuarios', 'usuarios.id_usuarios=usuario_cartera.id_usuarios');
    $this->db->join('agencias', 'agencias.id_agencia=carteras.id_agencia');
    $this->db->join('tablero.login as login', 'login.id_login=usuarios.id_usuarios');
    if($id_empleado != null){
      $this->db->where('login.id_empleado',$id_empleado);
    }
    if($id_cartera != null){
      $this->db->where('carteras.id_cartera',$id_cartera);
    }
    
    $query = $this->db->get();
    $this->db->db_select('tablero');
    return $query->result();
  }

  function all_dias_uso($id_empleado,$quincena,$mes){
    $this->db->select('SUM(dias) as dias');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('(estado = 1 or estado = 9)');
    $this->db->where('id_empleado',$id_empleado);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }

  function all_dias_cartera($id_cartera,$quincena,$mes){
    $this->db->select('SUM(dias) as dias');
    $this->db->from('viaticos_carteras'); 

    $this->db->where('(estado = 1 or estado = 9)');
    $this->db->where('id_cartera',$id_cartera);
    $this->db->where('quincena',$quincena);
    $this->db->where('mes',$mes);

    $result = $this->db->get();
    return $result->result();
  }

}