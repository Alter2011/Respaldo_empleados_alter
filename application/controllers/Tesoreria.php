<?php
require_once APPPATH.'controllers/Base.php';
class Tesoreria extends Base {
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tesoreria_model');
     }
  
    public function index()
    {
       
        $this->load->view('dashboard/header');
        $data['activo'] = 'Contratos';

        //obtengo los contratos para la vista
        $data['tipos'] = $this->Tesoreria_model->getContrato();
        $data['ver_empresas'] = $this->Tesoreria_model->getEmpresas();
        $data['ver_proveedores'] = $this->Tesoreria_model->verProveedor();

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/tipos_contratos');


    }

    //funcion para mostrar el menu
     public function Tesoreria_menu()
    {
        $this->load->view('dashboard/header');

        $data['activo'] = 'Tesoreria_menu';
    
       
        $this->load->view('dashboard/menus' ,$data);
        $this->load->view('Tesoreria/menu_tesorerias');
    }

    //funcion para mostrar los planes creados
     public function ver_planes()
    {
        $this->load->view('dashboard/header');

        $data['activo'] = 'Planes';

        //obtengo las marcas para la vista
        $data['planes'] = $this->Tesoreria_model->verPlanes();
       
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/ver_planes');
    }

    //funcion para mostrar las marcas creadas
     public function marcas()
    {
        $this->load->view('dashboard/header');
        $data['activo'] = 'Marcas';

        //obtengo las marcas para la vista
        $data['tipos'] = $this->Tesoreria_model->getMarca();
       
        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/marcas');
    }


    //funcion para mostrar los modelos
     public function modelos(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Modelos';

        //obtengo los modelos
        $data['tipos'] = $this->Tesoreria_model->getModelo();

        //obtengo las marcas para el filtro
        $data["ver_marcas"]=$this->Tesoreria_model->ver_marcas();

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/modelos');
    }

    //funcion para mostrar los telefonos
     public function telefonos(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Telefonos';

        //muestra los modelos creados
        $data['ver_telefonos'] = $this->Tesoreria_model->verTelefonos();
        $data["ver_marcas"]=$this->Tesoreria_model->ver_marcas();

        $data['telefonos'] = $this->Tesoreria_model->getTelefonos();

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/telefonos');
    }

    //funcion para mostrar los planes
     public function planes(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Planes';

        $data['ver_empresas'] = $this->Tesoreria_model->getEmpresas();
        $data['ver_tipos'] = $this->Tesoreria_model->getTipos();

        $servicio= "1";


        $data['ver_servicios']=$this->Tesoreria_model->ver_servicios($servicio);



        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/planes');
    }

    //funcion para mostrar los planes
     public function llenarPlanes($id){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Planes';
  

        //muestra los servicios creados
        $data['ver_servicios'] = $this->Tesoreria_model->verServicios($id);

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/ver_servicio');
    }

    //llenar datos de contratos
    public function llenarLinea(){
        $code=$this->input->post('codigo');

        //muestra los contratos creados
        $data=$this->Tesoreria_model->llenarLinea($code);

        echo json_encode($data);
    }

     //llenar datos de contratos
    public function adicionar_plan(){
        $code=$this->input->post('codigo');

        //muestra los contratos creados
        $data=$this->Tesoreria_model->adicionar_plan($code);

        echo json_encode($data);
    }



    //funcion para crear las lineas
     public function asignacion_telefono(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'Lineas';
        $data['planes'] = [];


        $data['ver_agencias'] = $this->Tesoreria_model->verAgencias();    

        $data['tipos'] = $this->Tesoreria_model->getTipos();
        $data['ver_plan'] = $this->Tesoreria_model->verPlanes();
        $data['ver_telefonos'] = $this->Tesoreria_model->verTelefonos();
        

        $ver_planes = $this->Tesoreria_model->verPlanes();
        $ver_servicios=$this->Tesoreria_model->ver_servicios_asig();

   // echo "<pre>";


       // print_r($ver_planes);
        $data['ver_info_linea'] = $this->Tesoreria_model->ver_info_linea();
        //$data['ver_info_plan']=$this->Tesoreria_model->ver_info_plan();
        

    for($j = 0; $j<count($data['tipos']); $j++){
      for($i = 0; $i<count($ver_planes); $i++){

        $servicios = $this->Tesoreria_model->buscar_servicio($ver_planes[$i]->id_plan,$data['tipos'][$j]->id_tipo_servicio);

            $data2['nombre_servicio'] = $data['tipos'][$j]->nombre_servicio;


            if(!empty($servicios)){
                $data2['servicio_'.($i+1)] = $servicios[0]->cantidad.' '.$data['tipos'][$j]->abreviatura;
            }else{
                $data2['servicio_'.($i+1)] = "-";
            }
            //$data2['abreviatura'.($j+1)] = $data['tipos'][$j]->abreviatura;

   
        } 
       array_push($data['planes'], $data2);
    }


    $this->load->view('dashboard/menus',$data);
    $this->load->view('Tesoreria/asignacion_lineas');
    }

     //funcion para asignar linea a usuario
     public function asignar_linea(){
        $this->load->view('dashboard/header');

        $data['activo'] = 'asignar_linea';

         $numero=$this->input->post("numero");
         $empleado=$this->input->post("empleado");
         $telefonos=$this->input->post("telefonos");
         $plan=$this->input->post("plan");
         $fecha_servidor= date('Y-m-d H:i:s');

        $data['asignacion'] = $this->Tesoreria_model->asignar_linea($numero,$empleado,$telefonos,$plan,$fecha_servidor);

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/asignacion_lineas');
    }


    //funcion para crear las lineas
     public function asignacion_lineas(){
        $this->load->view('dashboard/header');
        $data['activo'] = 'asignacion_lineas';
 

        $data['ver_asignacion'] = $this->Tesoreria_model->ver_asignacion();

        $data['ver_agencias'] = $this->Tesoreria_model->verAgencias();
        $data['ver_lineas'] = $this->Tesoreria_model->verLineas();

        $data['ver_planes'] = $this->Tesoreria_model->ver_Planes();
       

        $this->load->view('dashboard/menus',$data);
        $this->load->view('Tesoreria/asignacion_lineas');
    }

     //funcion para crear las lineas
     public function add_linea(){
            $data = '';

         $nombre_linea=$this->input->post("linea");
         $numero=$this->input->post("numero");
         $telefono=$this->input->post("telefonos");
         $planes=$this->input->post("planes");
         $bandera=true;

         $fecha_actual=date('Y-m-d H:i:s');



        if($nombre_linea == null){
            $data = "Debe de ingresar un nombre de linea<br>";
            $bandera=false;
        }


          if($numero == null){
            $data .= "Debe de ingresar un numero de telefono<br>";
            $bandera=false;
        }elseif(!is_numeric($numero)){
            $data .= "El numero de telefono no debe tener letras<br>";
            $bandera=false;
        }elseif($numero <= 0){
            $data .= "El numero de telefono debe ser mayor a cero<br>";
            $bandera=false;
        }


        if($bandera){
                $id_linea = $this->Tesoreria_model->saveLinea($nombre_linea,$planes,$numero, $fecha_actual);


                if($telefono != null){
                //$data = $this->Tesoreria_model->telefono_asig($telefono);
                $data = $this->Tesoreria_model->asignacion_linea($telefono, $id_linea, $fecha_actual);
                }

                     echo json_encode(null);
                }else{
                    echo json_encode($data);

                }
   
    }

    //Funcion para mostrar por marcas segun se filtre
    public function seleccionar_marca($marca=null){
            $marca=$this->input->post("marca");

            //filtra segun la marca que se selecciono
            $data['ver_marcas']=$this->Tesoreria_model->buscar_marcas($marca);
 
        echo json_encode($data['ver_marcas']);
        }

           //Funcion para cambiar agencia
    public function cambiar_agencia(){
            $agencia=$this->input->post("agencia");


            //filtra segun la marca que se selecciono
            $data=$this->Tesoreria_model->verEmpleados($agencia);
 
        echo json_encode($data);
        }

        //Funcion para mostrar por marcas en telefonos
    public function seleccionar_marca_tel($marca=null){
            $marca=$this->input->post("marca");


            //filtra segun la marca que se selecciono
            $data['ver_marcas_tel']=$this->Tesoreria_model->buscar_marcas_tel($marca);
 
        echo json_encode($data['ver_marcas_tel']);
        }

        //Funcion para cambiar los modelos
    public function cambiarModelos($marca=null){
            $marca=$this->input->post("marca");

            //filtra segun la marca que se selecciono
            $data['ver_modelos']=$this->Tesoreria_model->ver_modelos($marca);
 
        echo json_encode($data['ver_modelos']);
        }


         //Funcion para cambiar la linea
    public function cambiarPlan(){
            $plan=$this->input->post("plan");


            //filtra segun la marca que se selecciono
            $data['ver_info_plan']=$this->Tesoreria_model->ver_info_plan($plan);
 
        echo json_encode($data['ver_info_plan']);
        }

          //Funcion para cambiar los modelos
    public function cambiarServicios($servicio=null){
            $servicio=$this->input->post("servicio");


            //filtra segun la marca que se selecciono
            $data['ver_servicios']=$this->Tesoreria_model->ver_servicios($servicio);
 
        echo json_encode($data['ver_servicios']);
        }


    //llenar datos de contratos
    public function llenarEdit(){
        $code=$this->input->post('code');

        //muestra los contratos creados
        $data=$this->Tesoreria_model->llenarContrato($code);

        echo json_encode($data);
    }

     //llenar datos de telefonos
    public function llenarTelefono(){
        $code=$this->input->post('codigo');

        //muestra los contratos creados
        $data=$this->Tesoreria_model->llenarTelefono($code);

        echo json_encode($data);
    }

    //funcion para guardar los telefonos
    function save_telefono(){
        $bandera=true;
        $data = array();

        $marca=$this->input->post('marca');
        $modelo=$this->input->post('modelo');
        $imei=$this->input->post('imei');
        $descripcion=$this->input->post('descripcion');


        $fecha_actual=date('Y-m-d H:i:s');
        $ver_imeis=$this->Tesoreria_model->GetImei($imei);


                  if($imei == null){
                    $data = "&nbsp;&nbsp;&nbsp;Debe ingresar un imei<br>";
                    $bandera=false;
                }elseif(!is_numeric($imei)){
                    $data = "&nbsp;&nbsp;&nbsp;El imei debe ser un numero<br>";
                    $bandera=false;
                }elseif($imei <= 0){
                    $data = "&nbsp;&nbsp;&nbsp;El imei debe ser mayor a cero<br>";
                    $bandera=false;
                }elseif(!empty($ver_imeis)){
                    $data = "&nbsp;&nbsp;&nbsp;El imei no puede ser duplicado<br>";
                    $bandera=false;
                }elseif(strlen($imei) < '15' || strlen($imei) > '15'){
                    $data = "&nbsp;&nbsp;&nbsp;El imei debe tener 15 caracteres<br>";
                    $bandera=false;
                }

                if($descripcion == null){
                    $data .= "&nbsp;&nbsp;&nbsp;Debe ingresar una descripcion<br>";
                    $bandera=false;
                }elseif(strlen($descripcion)>300){
                    $data .= "&nbsp;&nbsp;&nbsp;Descripcion debe ser menor a 300 caracteres<br>";
                    $bandera=false;
                }

                    if($bandera){
                $data=$this->Tesoreria_model->saveTelefono($marca,$modelo, $fecha_actual,$imei,$descripcion);

                     echo json_encode(null);
                }else{
                    echo json_encode($data);

                }
        }

  


    //Metodo para guardar los contratos
    function save_contratos(){
        $bandera=true;
        $data = array();

        //capturo los datos de mi contrato
        $empresa=$this->input->post('empresa');
        $proveedor=$this->input->post('proveedor');
        $fecha_inicio=$this->input->post('fecha_inicio');
        $fecha_fin=$this->input->post('fecha_fin');
        $monto=$this->input->post('monto');
        $descripcion=$this->input->post('descripcion');
        $fecha_actual=date('Y-m-d H:i:s');


        if($fecha_inicio == null){
            array_push($data,1);
            $bandera=false;
        }

        if($fecha_fin == null){
            array_push($data,2);
            $bandera=false;
        }

         if($monto == null){
            array_push($data,3);
            $bandera=false;
        }elseif(!is_numeric($monto)){
            array_push($data,4);
            $bandera=false;
        }elseif($monto <= 0){
            array_push($data,5);
            $bandera=false;
        }

        if($descripcion == null){
            array_push($data,6);
            $bandera=false;
        }

        if(strlen($descripcion)>300){
            array_push($data,7);
            $bandera=false;
        }

        //evaluo si existe un error o no
        if($bandera){
        $data=$this->Tesoreria_model->saveContrato($empresa,$proveedor,$fecha_inicio,$fecha_fin,$monto, $descripcion,$fecha_actual);

             echo json_encode(null);
        }else{
            echo json_encode($data);

        }
    }

    //Metodo para modificar los contratos
    function update_contratos(){
        $bandera=true;
        $data = array();

         //capturo los datos de mi contrato
        $code=$this->input->post('code');
        $empresa=$this->input->post('empresa');
        $proveedor=$this->input->post('proveedor');
        $fecha_inicio=$this->input->post('fecha_inicio');
        $fecha_fin=$this->input->post('fecha_fin');
        $monto=$this->input->post('monto');
        $descripcion=$this->input->post('descripcion');


         if($fecha_inicio == null){
      
            array_push($data,1);
            $bandera=false;
        }

        if($fecha_fin == null){
            array_push($data,2);
            $bandera=false;
        }

        if($monto == null){
            array_push($data,3);
            $bandera=false;
        }elseif(!is_numeric($monto)){
            array_push($data,4);
            $bandera=false;
        }elseif($monto <= 0){
            array_push($data,5);
            $bandera=false;
        }

        if($descripcion == null){
            array_push($data,6);
            $bandera=false;
        }

        if(strlen($descripcion)>300){
            array_push($data,7);
            $bandera=false;
        }


        if($bandera){
        $data=$this->Tesoreria_model->update_contratos($code,$empresa,$proveedor,$fecha_inicio,$fecha_fin,$monto, $descripcion);
        echo json_encode(null);
        }else{
          echo json_encode($data);
        }

    }

    //metodo para eliminar contrato segun codigo
    public function deleteContrato(){

        $code=$this->input->post('code');
        $data=$this->Tesoreria_model->deleteContrato($code);

    
        echo json_encode($data);
    }

     //llenar datos de marcas
    public function llenarMarca(){
        $code=$this->input->post('code');


        $data=$this->Tesoreria_model->llenarMarca($code);
        echo json_encode($data);
    }

    //Metodo para guardar las marcas de telefonos
    function save_marca(){
        $bandera=true;
        $data = array();

        $nombre=$this->input->post('nombre');
        $descripcion=$this->input->post('descripcion');

        $fecha_actual=date('Y-m-d H:i:s');

        if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }

        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }
        if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }


        if($bandera){
        $data=$this->Tesoreria_model->saveMarca($nombre,$fecha_actual,$descripcion);

             echo json_encode(null);
        }else{
            echo json_encode($data);

        }
    }

    //Metodo para modificar la marca
    function update_marca(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $nombre=$this->input->post('nombre');
        $descripcion=$this->input->post('descripcion');


         if($nombre == null){
            array_push($data,1);
            $bandera=false;
        }

        if($descripcion == null){
            array_push($data,2);
            $bandera=false;
        }
        if(strlen($descripcion)>300){
            array_push($data,3);
            $bandera=false;
        }

        if($bandera){
        $data=$this->Tesoreria_model->update_marca($code,$nombre,$descripcion);
        echo json_encode(null);
        }else{
          echo json_encode($data);
        }

    }

    //Metodo para modificar los telefonos
    function update_telefono(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');
        $marca=$this->input->post('marca');
        $modelo=$this->input->post('modelo');
        $imei=$this->input->post('imei');
        $descripcion=$this->input->post('descripcion');


         $ver_imeis=$this->Tesoreria_model->GetImei_update($imei,$code);


                if($imei == null){
                    $data = "Debe de ingresar un imei<br>";
                    $bandera=false;
                }elseif(!is_numeric($imei)){
                    $data = "El imei debe ser un numero<br>";
                    $bandera=false;
                }elseif($imei <= 0){
                    $data = "El imei debe ser mayor a cero<br>";
                    $bandera=false;
                }elseif(!empty($ver_imeis)){
                    $data = "El imei no puede ser duplicado<br>";
                    $bandera=false;
                }elseif(strlen($imei) < '15' || strlen($imei) > '15'){
                    $data = "El imei debe tener 15 caracteres<br>";
                    $bandera=false;
                }

                if($descripcion == null){
                    $data = "Debe ingresar una descripcion<br>";
                    $bandera=false;
                }elseif(strlen($descripcion)>300){
                    $data = "descripcion debe ser menor a 300 caracteres<br>";
                    $bandera=false;
                }


        if($bandera){
        $data=$this->Tesoreria_model->update_telefono($code,$marca,$modelo, $imei, $descripcion);
        echo json_encode(null);
        }else{
          echo json_encode($data);
        }

    }

    //Metodo para modificar las lineas
    function update_linea(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');

        $linea=$this->input->post('linea');
        $planes=$this->input->post('planes');
        $numero=$this->input->post('numero');
        $telefonos=$this->input->post('telefonos');


                 if($linea == null){
                    $data = "Debe de ingresar un nombre de linea<br>";
                    $bandera=false;
                }

                if($numero == null){
                    $data = "Debe de ingresar un numero de telefono<br>";
                    $bandera=false;
                }elseif($numero <= 0){
                    $data = "El numero de telefono debe ser mayor a cero<br>";
                    $bandera=false;
                }elseif(strlen($numero) < '9' || strlen($numero) > '9'){
                    $data = "El numero de telefono debe tener 9 caracteres<br>";
                    $bandera=false;
                }
         
        if($bandera){
        $data=$this->Tesoreria_model->update_lineas($code,$linea,$planes,$numero);

        $data=$this->Tesoreria_model->update_tel($code, $telefonos);


        echo json_encode(null);
        }else{
          echo json_encode($data);
        }

    }

    //metodo para eliminar marca segun codigo
   /* public function deleteMarca(){

        $code=$this->input->post('code');
        $data=$this->Tesoreria_model->deleteMarca($code);

    
        echo json_encode($data);
    }*/

    //llenar datos de los modelos
    public function llenarModelo(){
        $code=$this->input->post('code');

        $data=$this->Tesoreria_model->llenarModelo($code);
        echo json_encode($data);
    }

    //Metodo para guardar los modelos
    function save_modelo(){
        $bandera=true;
        $data = array();

        $modelo=$this->input->post('modelo');
        $marca=$this->input->post('marca');

        $peso=$this->input->post('peso');
        $fecha_actual=date('Y-m-d H:i:s');
        $tamaño=$this->input->post('tamaño');
        $ram=$this->input->post('ram');
        $rom=$this->input->post('rom');
        $precio=$this->input->post('precio');
        $bateria=$this->input->post('bateria');
        $camaras=$this->input->post('camaras');
        $gama=$this->input->post('gama');


         if($modelo == null){
            array_push($data,1);
            $bandera=false;
        }

        if($peso == null){
            array_push($data,2);
            $bandera=false;
        }elseif(!is_numeric($peso)){
            array_push($data,3);
            $bandera=false;
        }elseif($peso <= 0){
            array_push($data,4);
            $bandera=false;
        }

          if($tamaño == null){
            array_push($data,5);
            $bandera=false;
        }elseif(!is_numeric($tamaño)){
            array_push($data,6);
            $bandera=false;
        }elseif($tamaño <= 0){
            array_push($data,7);
            $bandera=false;
        }

         if($ram == null){
            array_push($data,8);
            $bandera=false;
        }

         if($rom == null){
            array_push($data,9);
            $bandera=false;
        }

         if($precio == null){
            array_push($data,10);
            $bandera=false;
        }elseif(!is_numeric($precio)){
            array_push($data,11);
            $bandera=false;
        }elseif($precio <= 0){
            array_push($data,12);
            $bandera=false;
        }

         if($bateria == null){
            array_push($data,13);
            $bandera=false;
        }

         if($camaras == null){
            array_push($data,14);
            $bandera=false;
        }

         if($gama == null){
            array_push($data,15);
            $bandera=false;
        }

        if($bandera){
        $data=$this->Tesoreria_model->saveModelo($modelo,$marca,$fecha_actual,$peso, $tamaño, $ram, $rom, $precio, $bateria, $camaras, $gama);

             echo json_encode(null);
        }else{
            echo json_encode($data);

        }
    }

    //Metodo para modificar los modelos
    function update_modelo(){
        $bandera=true;
        $data = array();

        $code=$this->input->post('code');


        $modelo=$this->input->post('modelo');
        $peso=$this->input->post('peso');
        $tamaño=$this->input->post('tamaño');
        $ram=$this->input->post('ram');
        $rom=$this->input->post('rom');
        $precio=$this->input->post('precio');
        $bateria=$this->input->post('bateria');
        $camaras=$this->input->post('camaras');
        $gama=$this->input->post('gama');

        $marca=$this->input->post('marca');



        if($modelo == null){
            array_push($data,1);
            $bandera=false;
        }

        if($peso == null){
            array_push($data,2);
            $bandera=false;
        }elseif(!is_numeric($peso)){
            array_push($data,3);
            $bandera=false;
        }elseif($peso <= 0){
            array_push($data,4);
            $bandera=false;
        }

          if($tamaño == null){
            array_push($data,5);
            $bandera=false;
        }elseif(!is_numeric($tamaño)){
            array_push($data,6);
            $bandera=false;
        }elseif($tamaño <= 0){
            array_push($data,7);
            $bandera=false;
        }

         if($ram == null){
            array_push($data,8);
            $bandera=false;
        }

         if($rom == null){
            array_push($data,9);
            $bandera=false;
        }

         if($precio == null){
            array_push($data,10);
            $bandera=false;
        }elseif(!is_numeric($precio)){
            array_push($data,11);
            $bandera=false;
        }elseif($precio <= 0){
            array_push($data,12);
            $bandera=false;
        }

         if($bateria == null){
            array_push($data,13);
            $bandera=false;
        }

         if($camaras == null){
            array_push($data,14);
            $bandera=false;
        }

         if($gama == null){
            array_push($data,15);
            $bandera=false;
        }

        

        if($bandera){
        $data=$this->Tesoreria_model->update_modelo($code,$marca,$modelo,$peso, $tamaño, $ram, $rom, $precio, $bateria, $camaras, $gama);
        echo json_encode(null);
        }else{
          echo json_encode($data);
        }

    }

    function save_planes(){
        $bandera=true;
        $data = '';
        $nombre_plan=$this->input->post('nombre');
        $cantidad_plan=$this->input->post('cantidad');
        $monto_plan=$this->input->post('monto');
        $beneficios=$this->input->post('beneficios');
        $contrata=$this->input->post('contrata');
        $fecha_actual=date('Y-m-d H:i:s');


        $nombre=$this->input->post('nombre_servicio');
        $tipo=$this->input->post('tipo_servicio');
        $cantidad=$this->input->post('cantidad_servicio');
        $descripcion=$this->input->post('descripcion');

        $values = array();
        parse_str($_POST['add_plan'], $values);

        //print_r($values);

        if($cantidad_plan == null){
            $data .= "Debe de ingresar una cantidad de planes<br>";
            $bandera=false;
        }elseif(!is_numeric($cantidad_plan)){
            $data .= "La cantidad del planes debe ser un numero<br>";
            $bandera=false;
        }elseif($cantidad_plan <= 0){
            $data .= "La cantidad del planes debe ser mayor a cero<br>";
            $bandera=false;
        }


        if($nombre_plan == null){
            $data = "Debe de ingresar un nombre del plan<br>";
            $bandera=false;
        }


          if($monto_plan == null){
            $data .= "Debe de ingresar un costo del plan<br>";
            $bandera=false;
        }elseif(!is_numeric($monto_plan)){
            $data .= "La cantidad del costo del plan debe ser un numero<br>";
            $bandera=false;
        }elseif($monto_plan <= 0){
            $data .= "La cantidad del costo del plan debe ser mayor a cero<br>";
            $bandera=false;
        }

         $j=1;
        for($i=0; $i < count($values['cantidad_servicio']); $i++){

          //evalua que se ingrese la informacion de los registros
        if($values['nombre_servicio'][$i] == null){
           $data .= "Debe de ingresar el nombre del servicio " . $j ."<br>";
           $bandera=false;
        }

        if($values['cantidad_servicio'][$i] == null){
            $data .= "Debe de ingresar la cantidad disponible del servicio " . $j . "<br>";
            $bandera=false;
        }elseif(!is_numeric($values['cantidad_servicio'][$i])){
            $data .= "La cantidad del servicio " . $j . "debe ser un numero<br>";
            $bandera=false;
        }elseif($values['cantidad_servicio'][$i] <= 0){
            $data .= "La cantidad del servicio " . $j . "debe ser mayor a cero" . $j . "<br>";
            $bandera=false;
        }

        if($values['descripcion'][$i] == null){
                    $data .= "Debe ingresar la descripcion del servicio " .$j. "<br>";
                    $bandera=false;
                }elseif(strlen($values['descripcion'][0])>300){
                    $data .= "Descripcion del servicio " . $j . "debe ser menor a 300 caracteres<br>";
                    $bandera=false;
                }

              $j++;  
        }


        if($bandera){
        $id_plan =$this->Tesoreria_model->savePlan($nombre_plan,$cantidad_plan,$monto_plan, $fecha_actual, $contrata);


        for($i=0; $i < count($values['cantidad_servicio']); $i++){
        $data=$this->Tesoreria_model->saveServicios($values['nombre_servicio'][$i],$values['tipo_servicios'][$i], $values['cantidad_servicio'][$i], $id_plan, $values['descripcion'][$i]);
        }

        echo json_encode(null);
        }else{
          echo json_encode($data);
        }




    }
    
    
}