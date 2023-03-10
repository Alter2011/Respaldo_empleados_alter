<?php
class Tesoreria_model extends CI_Model{


    //parametros para ingresar contrato
    function saveContrato($empresa,$proveedor,$fecha_inicio,$fecha_fin, $monto, $descripcion, $fecha_ingreso){

    $data = array( 
        'Empresa'           => $empresa,  
        'Tipo_proveedor'      => $proveedor,  
        'Fecha_inicio'      => $fecha_inicio,
        'Fecha_fin'         => $fecha_fin,
        'Monto'             => $monto,
        'Descripcion'       => $descripcion,
        'Fecha_ingreso'     => $fecha_ingreso,
        'estado'            => 1,
    );
    $result=$this->db->insert('contrato_telefonos',$data);
    return $result;
  }


   //funcion para modificar contrato
  public function update_contratos($code,$empresa,$proveedor,$fecha_inicio,$fecha_fin,$monto,$descripcion){
        $data = array(
            
        'Empresa'           => $empresa,  
        'Tipo_proveedor'      => $proveedor,  
        'Fecha_inicio'      => $fecha_inicio,
        'Fecha_fin'         => $fecha_fin,
        'Monto'             => $monto,
        'Descripcion'       => $descripcion,
        );

        $this->db->where('Id_contrato', $code);
        $this->db->update('contrato_telefonos', $data);
        return true;
     }

  //funcion para mostrar los contratos en la vista
  function getContrato(){
    $this->db->select('Id_contrato,Empresa, Tipo_proveedor, Fecha_inicio, Fecha_fin, Monto, contrato_telefonos.Descripcion, Fecha_ingreso, em.nombre_empresa, ti.nombre_proveedor, contrato_telefonos.estado');

    $this->db->from('contrato_telefonos'); 
    $this->db->join('empresa em', 'em.id_empresa=contrato_telefonos.Empresa');
    $this->db->join('tipo_proveedor ti', 'ti.id_proveedor=contrato_telefonos.Tipo_proveedor');


    //$this->db->where('contrato_telefonos.estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  //muestra las marcas de los telefonos que estan creadas
  public function ver_marcas(){
        $this->db->select('id_marca,nombre_marca');
        $this->db->from('marca'); 

        $this->db->where('estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

     //muestra los proveedores
  public function verProveedor(){
        $this->db->select('id_proveedor,nombre_proveedor');
        $this->db->from('tipo_proveedor'); 

        $this->db->where('estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

     //muestra los planes creados
  public function verPlanes(){
        $this->db->select('id_plan,nombre_plan,cantidad,precio_plan, planes.id_contrato, em.nombre_empresa');
        $this->db->from('planes');

         $this->db->join('contrato_telefonos co', 'co.Id_contrato=planes.id_contrato');
          $this->db->join('empresa em', 'em.id_empresa= co.Empresa'); 


        $this->db->where('planes.estado', 1);
        $this->db->where('co.estado', 1);


        $result = $this->db->get();
        return $result->result();
         
    }

       //muestra los planes creados
  public function verPlanes_asig(){
        $this->db->select('nombre_plan, se.cantidad ');
        $this->db->from('planes');

        $this->db->join('servicios se', 'se.id_plan= planes.id_plan', 'left'); 
        //$this->db->join('tipo_servicio ti', 'ti.id_tipo_servicio= se.tipo_servicio'); 

        $this->db->where('planes.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

       //muestra los planes creados
  public function ver_Planes(){
        $this->db->select('id_plan,nombre_plan');
        $this->db->from('planes');

        $this->db->where('estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

       //muestra los planes creados
  public function ver_info_plan($plan){
         $this->db->select('planes.cantidad, planes.precio_plan, se.cantidad as cantidad_servicio, se.nombre_servicio');
        $this->db->from('planes');

        $this->db->join('servicios se', 'se.id_plan= planes.id_plan', 'left');
        $this->db->join('tipo_servicio ti', 'ti.id_tipo_servicio= se.tipo_servicio', 'left');


        $this->db->where('planes.id_plan', $plan);
        $this->db->where('planes.estado', 1);


        $result = $this->db->get();
        return $result->result(); 

    }

     //muestra la informacion de las lineas
  public function ver_info_linea(){
        $this->db->select('id_tel_numero,numero_telefono');
        $this->db->from('tel_numero');

        $this->db->where('estado', 1);


        $result = $this->db->get();
        return $result->result(); 
    }

      //muestra los empleados
  public function verEmpleados($agencia){
        $this->db->select('empleados.id_empleado,empleados.nombre,empleados.apellido, co.id_agencia');
        $this->db->from('empleados');

         $this->db->join('contrato co', 'co.id_empleado=empleados.id_empleado');

        $this->db->where('(co.estado = 1 or co.estado = 3)');
        $this->db->where('co.id_agencia', $agencia);


        $result = $this->db->get();
        return $result->result();
         
    }

       //muestra las agencias
  public function verAgencias(){
        $this->db->select('id_agencia,agencia');
        $this->db->from('agencias');

        $result = $this->db->get();
        return $result->result();
         
    }

          //muestra las lineas creadas
 /* public function verLineas(){
      $this->db->select('lineas.id_linea,nombre_linea, lineas.id_plan, lineas.numero_telefono, pl.nombre_plan, as.id_telefono, ma.nombre_marca, mo.nombre_modelo, te.id_telefono, te.marca');
        $this->db->from('lineas');

         $this->db->join('planes pl', 'pl.id_plan=lineas.id_plan');
         $this->db->join('asignacion_telefono as', 'as.id_linea=lineas.id_linea', 'left');
         $this->db->join('telefono te', 'te.id_telefono=as.id_telefono', 'left' );
         $this->db->join('marca ma', 'ma.id_marca=te.marca', 'left');
         $this->db->join('modelo mo', 'mo.id_modelo=te.id_modelo', 'left');

         $this->db->where('lineas.estado', 1);


        $result = $this->db->get();
        return $result->result();
         
    }*/

           //muestra las lineas creadas
      public function verLineas(){
      $this->db->select('tel.numero_telefono, pl.nombre_plan, ma.nombre_marca, mo.nombre_modelo, te.id_telefono, te.marca');

        $this->db->from('asignacion_telefono');


         $this->db->join('tel_numero tel', 'tel.id_tel_numero=asignacion_telefono.id_tel_numero');
         $this->db->join('empleados em', 'em.id_empleado=asignacion_telefono.id_empleado');
         $this->db->join('telefono te', 'te.id_telefono=asignacion_telefono.id_telefono');
         $this->db->join('planes pl', 'pl.id_plan=asignacion_telefono.id_planes');


         $this->db->join('marca ma', 'ma.id_marca=te.marca');
         $this->db->join('modelo mo', 'mo.id_modelo=te.id_modelo');

         $this->db->where('asignacion_telefono.estado', 1);


        $result = $this->db->get();
        return $result->result();
         
       }






         //muestra los servicios creados
  public function verServicios($code){
        $this->db->select('servicios.nombre_servicio, tipo_servicio, cantidad, descripcion, ti.nombre_servicio as n_servicio, ti.abreviatura');
       
        $this->db->from('servicios');

        $this->db->join('tipo_servicio ti', 'ti.id_tipo_servicio=servicios.tipo_servicio');

        $this->db->where('id_plan', $code);
        $this->db->where('servicios.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

       //muestra las marcas de los telefonos que estan creadas
  public function verTelefonos(){
        $this->db->select('marca,id_telefono,ma.nombre_marca, telefono.id_modelo,imei, mo.nombre_modelo, telefono.descripcion');
        $this->db->from('telefono'); 

        $this->db->join('marca ma', 'ma.id_marca=telefono.marca');
        $this->db->join('modelo mo', 'mo.id_modelo=telefono.id_modelo');
        //$this->db->where('telefono.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

        //muestra la asignacion de los telefonos
  public function ver_asignacion(){
        $this->db->select('nombre_linea,pl.nombre_plan, em.nombre, em.apellido');
        $this->db->from('lineas'); 
    
        $this->db->join('asignacion_telefono as', 'as.id_linea=lineas.id_linea');
        $this->db->join('planes pl', 'pl.id_plan=lineas.id_plan');

        $this->db->join('empleados em', 'em.id_empleado=as.id_empleado');

        $this->db->where('lineas.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }

      //muestra las marcas de los telefonos que estan creadas
 /* public function ver_telefonos_asig(){
        $this->db->select('marca,id_telefono,ma.nombre_marca, telefono.id_modelo,imei, mo.nombre_modelo, telefono.descripcion');
        $this->db->from('telefono'); 

        $this->db->join('marca ma', 'ma.id_marca=telefono.marca');
        $this->db->join('modelo mo', 'mo.id_modelo=telefono.id_modelo');
        $this->db->where('telefono.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }*/

     //funcion para obtener las marcas y modelos de los telefonos
  public function getTelefonos(){
        $this->db->select('id_modelo,nombre_modelo,ma.id_marca,ma.nombre_marca');
        $this->db->from('modelo');

        $this->db->join('marca ma', 'ma.id_marca=modelo.id_marca');
        $this->db->where('modelo.estado', 1);

        $result = $this->db->get();
        return $result->result();
         
    }



      //muestra las marcas de los telefonos que estan creadas aqui
   function buscar_marcas($marca=null){
    $this->db->select('modelo.id_modelo,modelo.nombre_modelo, modelo.id_marca, modelo.fecha_servidor, ma.nombre_marca, modelo.peso, modelo.tamaño, modelo.ram, modelo.rom, modelo.precio,modelo.bateria, modelo.camaras, modelo.gama');

    $this->db->from('modelo'); 
    $this->db->join('marca ma', 'ma.id_marca=modelo.id_marca');
    $this->db->where('modelo.estado',1);
    $this->db->where('modelo.id_marca', $marca);


    $result = $this->db->get();
    return $result->result();
  }

      //muestra las marcas de los telefonos que estan creadas aqui
   function buscar_marcas_tel($marca=null){
    $this->db->select('telefono.id_telefono,telefono.marca, telefono.id_modelo,mo.id_modelo,mo.nombre_modelo, ma.id_marca, ma.nombre_marca, telefono.imei, telefono.descripcion');

    $this->db->from('telefono'); 
    $this->db->join('marca ma', 'ma.id_marca=telefono.marca');
    $this->db->join('modelo mo', 'mo.id_modelo=telefono.id_modelo');


    //$this->db->where('telefono.estado',1);
    $this->db->where('telefono.marca', $marca);


    $result = $this->db->get();
    return $result->result();
  }

    //funcion para llenar datos al darle boton modificar
   function llenarContrato($code){
    $this->db->select('Id_contrato,Empresa, Tipo_proveedor, Fecha_inicio, Fecha_fin, Monto, Descripcion, Fecha_ingreso');
    $this->db->from('contrato_telefonos'); 
   
    $this->db->where('Id_contrato', $code);


    $result = $this->db->get();
    return $result->result();
  }

   //funcion para llenar las lineas al darle boton editar
   function llenarLinea($code){
    $this->db->select('lineas.id_linea,lineas.nombre_linea, lineas.id_plan, lineas.numero_telefono, lineas.nombre_linea, te.id_telefono');
    $this->db->from('lineas');


    $this->db->join('asignacion_lineas as', 'as.id_linea=lineas.id_linea', 'left');
    $this->db->join('telefono te', 'te.id_telefono=as.id_telefono', 'left');


    $this->db->where('lineas.estado',1);
    $this->db->where('lineas.id_linea', $code);


    $result = $this->db->get();
    return $result->result();
  }

   //funcion para llenar las lineas al darle boton editar
   function adicionar_plan($code){
    $this->db->select('id_plan, nombre_plan, cantidad');
    $this->db->from('planes');

    $this->db->where('estado',1);
    $this->db->where('id_plan', $code);


    $result = $this->db->get();
    return $result->result();
  }

  //Funcion para eliminar contratos
    public function deleteContrato($code){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('Id_contrato', $code);
        $this->db->update('contrato_telefonos', $data);
        return true;
     }



 //parametros para ingresar una marca
    function saveMarca($nombre,$fecha_ingreso,$descripcion){

    $data = array( 
        'nombre_marca'      => $nombre,  
        'fecha_servidor'    => $fecha_ingreso,
        'descripcion'       => $descripcion,
        'estado'            => 1,
    );
    $result=$this->db->insert('marca',$data);
    return $result;
  }

   //parametros para ingresar una marca
    function asignar_linea($numero,$empleado,$telefonos,$plan,$fecha_servidor){


    $data = array( 
        'id_tel_numero'     => $numero,  
        'id_empleado'       => $empleado,
        'id_telefono'       => $telefonos,
        'id_planes'         => $plan,
        'fecha_servidor'    => $fecha_servidor,
        'estado'            => 1,

    );
    $result=$this->db->insert('asignacion_telefono',$data);
    return $result;
  }

   //parametros para ingresar una nueva linea
    function saveLinea($nombre_linea,$planes, $numero,  $fecha_actual){

    $data = array( 
        'nombre_linea'         => $nombre_linea,  
        'id_plan'              => $planes,  
        'numero_telefono'      => $numero,  
        'fecha_servidor'       => $fecha_actual,
        'estado'               => 1,
    );
    $result=$this->db->insert('lineas',$data);
    return $this->db->insert_id();
   
  }

  //parametros para asignar telefono a linea
    function asignacion_linea($telefono,$linea, $fecha_actual){

    $data = array( 
        'id_telefono'          => $telefono,  
        'id_linea'             => $linea,  
        'fecha_asignacion'     => $fecha_actual,
        'estado'               => 1,
    );
    $result=$this->db->insert('asignacion_lineas',$data);
     return true;
  }

   //funcion para asignar un telefono
  /*public function telefono_asig($telefono){
        $data = array(
            
        'estado'      => 0,  
        );

        $this->db->where('id_telefono', $telefono);
        $this->db->update('telefono', $data);
           return true;
     }*/

   //funcion para modificar marca
  public function update_marca($code,$nombre,$descripcion){
        $data = array(
            
        'nombre_marca'      => $nombre,  
        'descripcion'       => $descripcion,  
        );

        $this->db->where('id_marca', $code);
        $this->db->update('marca', $data);
        return true;
     }

  //funcion para mostrar las marcas en la vista
  function getMarca(){
    $this->db->select('id_marca,nombre_marca, fecha_servidor, descripcion');
    $this->db->from('marca'); 
    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

    //funcion para llenar datos al darle boton modificar
   function llenarMarca($code){
    $this->db->select('id_marca,nombre_marca, fecha_servidor, descripcion');
    $this->db->from('marca'); 
    $this->db->where('estado',1);
    $this->db->where('id_marca', $code);


    $result = $this->db->get();
    return $result->result();
  }

    //funcion para llenar datos del telefono al darle click
   function llenarTelefono($code){
    $this->db->select('id_telefono, marca,id_modelo, imei, descripcion');
    $this->db->from('telefono'); 
    
    //$this->db->where('estado',1);
    $this->db->where('id_telefono', $code);


    $result = $this->db->get();
    return $result->result();
  }

  //parametros para ingresar un telefono
    function saveTelefono($marca,$modelo,$fecha_actual, $imei, $descripcion){

    $data = array(
        'marca'             => $marca,  
        'id_modelo'         => $modelo,  
        'fecha_servidor'    => $fecha_actual,
        'imei'              => $imei,
        'descripcion'       => $descripcion,
        'estado'            => 1,
    );
    $result=$this->db->insert('telefono',$data);
    return $result;
  }

  function GetImei($imei){
    $this->db->select('*');
    $this->db->from('telefono'); 
    $this->db->where('estado',1);

    $this->db->where('imei', $imei);


    $result = $this->db->get();
    return $result->result();
  }

   function GetImei_update($imei,$code){
    $this->db->select('*');
    $this->db->from('telefono'); 
    $this->db->where('estado',1);

    $this->db->where('imei', $imei);
    $this->db->where('id_telefono !=', $code);

    $result = $this->db->get();
    return $result->result();
  }


   //funcion para modificar telefonos
  public function update_telefono($code,$marca,$modelo, $imei, $descripcion){
        $data = array(
        'marca'             => $marca,  
        'id_modelo'         => $modelo,  
        'imei'              => $imei,
        'descripcion'       => $descripcion,  
        );

        $this->db->where('id_telefono', $code);
        $this->db->update('telefono', $data);
        return true;
     }

      //funcion para modificar las lineas
  public function update_lineas($code,$linea,$planes,$numero){
        $data = array(
        'nombre_linea'             => $linea,  
        'id_plan'                  => $planes,  
        'numero_telefono'          => $numero,
        );

        $this->db->where('id_linea', $code);
        $this->db->update('lineas', $data);
        return true;
     }

         //funcion para modificar los telefonos asignados
  public function update_tel($code,$telefonos){
        $data = array(
        'id_telefono'             => $telefonos,  
        );

        $this->db->where('id_linea', $code);
        $this->db->update('asignacion_lineas', $data);
        return true;
     }



  //Funcion para eliminar Marcas
   /* public function deleteMarca($code){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('id_marca', $code);
        $this->db->update('marca', $data);
        return true;
     }*/


      //parametros para ingresar un modelo
    function saveModelo($modelo,$marca,$fecha_actual,$peso, $tamaño, $ram, $rom, $precio, $bateria, $camaras, $gama){

    $data = array( 
        'nombre_modelo'     => $modelo,  
        'id_marca'          => $marca,  
        'fecha_servidor'    => $fecha_actual,
        'peso'              => $peso,
        'tamaño'            => $tamaño,
        'ram'               => $ram,
        'rom'               => $rom,
        'precio'            => $precio,
        'bateria'           => $bateria,
        'camaras'           => $camaras,
        'gama'              => $gama,
        'estado'            => 1,
    );
    $result=$this->db->insert('modelo',$data);
    return $result;
  }

   //funcion para modificar modelo
  public function update_modelo($code,$marca,$modelo,$peso, $tamaño, $ram, $rom, $precio, $bateria, $camaras, $gama){
        $data = array(
            
        'nombre_modelo'        => $modelo,  
        'id_marca'             => $marca,  
        'peso'                 => $peso,
        'tamaño'               => $tamaño,
        'ram'                  => $ram,
        'rom'                  => $rom,
        'precio'               => $precio,
        'bateria'              => $bateria,
        'camaras'              => $camaras,
        'gama'                 => $gama,

        );

        $this->db->where('id_modelo', $code);
        $this->db->update('modelo', $data);
        return true;
     }

  //funcion para mostrar los modelos en la vista
  function getModelo(){
    $this->db->select('modelo.id_modelo,modelo.nombre_modelo, modelo.id_marca, modelo.fecha_servidor, ma.nombre_marca, modelo.peso, modelo.tamaño, modelo.ram, modelo.rom, modelo.precio, modelo.bateria, modelo.camaras, modelo.gama');

    $this->db->from('modelo'); 
    $this->db->join('marca ma', 'ma.id_marca=modelo.id_marca');
    $this->db->where('modelo.estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  //funcion para obtener las empresas
  function getEmpresas(){
    $this->db->select('id_empresa, nombre_empresa');
    $this->db->from('empresa'); 

    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

  //funcion para obtener los tipos de servicios
  function getTipos(){
    $this->db->select('id_tipo_servicio, nombre_servicio, abreviatura');
    $this->db->from('tipo_servicio'); 

    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

    //funcion para llenar datos al darle boton modificar
   function llenarModelo($code){
    $this->db->select('id_modelo,nombre_modelo, id_marca, peso, tamaño, ram, rom, precio, bateria, camaras, gama');
    $this->db->from('modelo'); 
    $this->db->where('estado',1);
    $this->db->where('id_modelo', $code);


    $result = $this->db->get();
    return $result->result();
  }

  //funcion para llenar los modelos
   function ver_modelos($marca){
    $this->db->select('id_modelo,nombre_modelo');
    $this->db->from('modelo'); 
    $this->db->where('estado',1);

    $this->db->where('id_marca', $marca);


    $result = $this->db->get();
    return $result->result();
  }

  //funcion para encontrar los servicios
   function buscar_servicio($plan, $tipo_servicio){
    $this->db->select('planes.nombre_plan,se.nombre_servicio, se.cantidad');
    $this->db->from('planes'); 

    $this->db->join('servicios se', 'se.id_plan=planes.id_plan');
    $this->db->join('tipo_servicio ti', 'ti.id_tipo_servicio=se.tipo_servicio');


    $this->db->where('planes.estado',1);

    $this->db->where('planes.id_plan', $plan);
    $this->db->where('ti.id_tipo_servicio', $tipo_servicio);

    $result = $this->db->get();
    return $result->result();
  }



   //funcion para llenar los tipos de servicios
   function ver_servicios($servicio){
    $this->db->select('id_tipo_servicio,nombre_servicio, tipo_de_uso');
    $this->db->from('tipo_servicio'); 
    $this->db->where('estado',1);

    $this->db->where('id_tipo_servicio', $servicio);


    $result = $this->db->get();
    return $result->result();
  }

   //funcion para ver los servicios en la tabla de informacion
   function ver_servicios_asig(){
    $this->db->select('nombre_servicio,cantidad');
    
    $this->db->from('servicios');

    $this->db->where('estado',1);

    $result = $this->db->get();
    return $result->result();
  }

   //parametros para ingresar uno o varios servicios
    function saveServicios($nombre,$tipo,$cantidad, $id_plan, $descripcion){

    $data = array( 
        'nombre_servicio'   => $nombre,  
        'tipo_servicio'     => $tipo,  
        'cantidad'          => $cantidad,
        'id_plan'           => $id_plan,
        'descripcion'       => $descripcion,
        'estado'            => 1,
    );
    $result=$this->db->insert('servicios',$data);
    return $result;
  }

   function savePlan($nombre_plan,$cantidad_plan,$monto_plan,$fecha_actual, $contrata){

    $data = array( 
        'nombre_plan'          => $nombre_plan,  
        'cantidad'             => $cantidad_plan,  
        'precio_plan'          => $monto_plan,
        'fecha_servidor'       => $fecha_actual,
        'estado'               => 1,
        'id_contrato'          => $contrata,
    );
    $result=$this->db->insert('planes',$data);
    return $this->db->insert_id();
  }

  //Funcion para eliminar modelo
   /* public function deleteModelo($code){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('id_modelo', $code);
        $this->db->update('modelo', $data);
        return true;
     }*/



}