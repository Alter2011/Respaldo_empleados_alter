    <?php
    class Conteos_model extends CI_Model{

            function lista_data(){
                //$this->db->db_select('tablero');
                $this->db->db_select('tablero');
                $agencias = $this->db->query('SELECT * FROM agencias');
                $cargos = $this->db->query('SELECT * FROM cargos');
                $empleados = $this->db->query('SELECT * FROM empleados');
                $areas = $this->db->query('SELECT * FROM areas');
                $contratos = $this->db->query('SELECT * from empleados where empleados.id_empleado IN (select id_empleado from contrato group by id_empleado)');

                $data = array(
                    'agencias'  => $agencias->num_rows(), 
                    'cargos'  => $cargos->num_rows(), 
                    'empleado' => $empleados->num_rows(),
                    'areas' => $areas->num_rows(), 
                    'contratos' => $areas->num_rows(), 
                );
                return $data;
            }
            function list_data(){
                $this -> db -> select('id_agencia,count(id_agencia) as numero');
                $this -> db -> from('contrato'); 
                $this -> db -> where('estado = 1 or estado = 3');
                $this->db->group_by('id_agencia');

                $query = $this-> db->get();

                if ($query->num_rows() >= 1) {
                 return $query->result();
             } else {
                 return 0;
             }
         }
         //NO07062023 traer el ultimo bono que tiene
         function get_last_bono($id_contrato){  
            $this->db->select("*");
            $this->db->from('bonificacion');
            $this->db->where('id_contrato', $id_contrato);
            $this->db->where('estado_control = 1');
            $this->db->order_by('mes', 'desc');
            $this->db->limit(1);
            $result = $this->db->get();
            return $result->result();
         }

        function n_coord(){//Saca el numero de coordinadores
            $this->db->db_select('Produccion');
            $this->db->where('id_rol', 2);
            $this->db->order_by('id_usuarios, nombre');
            $hasil=$this->db->get('usuarios');
            return $hasil->result();
        }
        function carteras($agencia){
            $this->db->db_select('Produccion');

            $this -> db -> select('id_cartera','cartera');
            $this -> db -> from('carteras'); 
            $this -> db -> where('id_agencia', $agencia);
            $this->db->order_by('id_cartera');
                        $this->db->where('carteras.activo ', 1);

            $query = $this-> db->get();

            if ($query->num_rows() >= 1) {
             return $query->result();
         } else {
             return 0;
         }
     }
         function carteras2(){
            $this->db->db_select('Produccion');

            $this -> db -> select('carteras.id_cartera as id_cartera,cartera,agencias.agencia as agencia,nombre, apellido');
            $this -> db -> from('carteras'); 

            $this->db->join('agencias','agencias.id_agencia=carteras.id_agencia');
            $this->db->join('permisos','permisos.id_cartera=carteras.id_cartera');
            $this->db->join('usuarios','usuarios.id_usuarios=permisos.id_usuarios');
            $this ->db-> where('usuarios.id_rol', 3);
            $this ->db-> or_where('usuarios.id_rol', 4);
                        $this->db->where('carteras.activo ', 1);


            $this->db->order_by('id_cartera');

            $query = $this-> db->get();

            if ($query->num_rows() >= 1) {
             return $query->result();
         } else {
             return 0;
         }
     }
        function n_agencias($coord,$filto=null){//Saca el numero de coordinadores
            $this->db->db_select('Produccion');

        //select agencias.agencia from permisos inner join carteras on permisos.id_cartera=carteras.id_cartera INNER join agencias on agencias.id_agencia=carteras.id_agencia where permisos.id_usuarios="JA01"

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

        function n_agencia($agenc,$condicion=null){//Saca el numero de Jefes
            $this->db->db_select('Produccion');

        //select agencias.agencia from permisos inner join carteras on permisos.id_cartera=carteras.id_cartera INNER join agencias on agencias.id_agencia=carteras.id_agencia where permisos.id_usuarios="JA01"

            $this->db->select('permisos.id_usuarios, agencias.agencia, permisos.id_cartera, agencias.id_agencia, usuarios.*, carteras.cartera');
            $this->db->from('carteras');
            $this->db->join('permisos', 'permisos.id_cartera=carteras.id_cartera');
            $this->db->join('agencias', 'agencias.id_agencia=carteras.id_agencia');
            $this->db->join('usuarios', 'permisos.id_usuarios=usuarios.id_usuarios');
            if ($condicion != null) {
                $this->db->where('permisos.id_cartera', $agenc);
            }else{
                $this->db->where('substr(permisos.id_cartera,1,2)', $agenc);
            }
             $this->db->where('carteras.activo ', 1);
   
            $this->db->where('usuarios.id_rol >=', 3);
            $query = $this->db->get();
            return $query->result();
        }
        function asesor($id_usuario){
                  $this->db->db_select('Produccion');

            $this->db->select('permisos.id_usuarios, agencias.agencia, permisos.id_cartera, agencias.id_agencia, usuarios.*, carteras.cartera');
            $this->db->from('carteras');
            $this->db->join('permisos', 'permisos.id_cartera=carteras.id_cartera');
            $this->db->join('agencias', 'agencias.id_agencia=carteras.id_agencia');
            $this->db->join('usuarios', 'permisos.id_usuarios=usuarios.id_usuarios');
            $this->db->where('usuarios.id_rol =', 4);
                        $this->db->where('carteras.activo ', 1);

            $this->db->where('permisos.id_usuarios =', $id_usuario);    
            $query = $this->db->get();
            return $query->result();
        }
        function Cmora(){//Saca el numero de Jefes
           
        }

        function permisos($usuario){/*Muestra los permisos que tenga el usuario enviado*/
            $this->db->db_select('Produccion');

            $this->db->select('*');
            $this->db->from('permisos');
            $this->db->join('agencias', 'agencias.id_agencia=SUBSTR(permisos.id_cartera,1,2)');
            $this->db->where('permisos.id_usuarios =', $usuario);   
            $query = $this->db->get();
            $this->db->db_select('tablero');

            return $query->result();
        }

        function generales($fecha=null,$filtro=null){
            $this->db->db_select('Produccion');
            $this->db->select('sucursal,grupo,asesor,sum(cartera) as cartera,fecha,sum(mora) as mora');
            $this->db->from('generales');
            $this->db->where('grupo =', 01);
            if ($fecha != null) {
                $this->db->like('fecha', $fecha,'after');
            }
            if ($filtro != null) {
            $this->db->like('sucursal',$filtro,'after'); //hace un $id%, pone el simbolo luego de la variable       
        }
                $this->db->group_by('sucursal,grupo,asesor,fecha');

        $this->db->order_by('fecha','ASC');
        $query=$this->db->get();
        return $query->result();

    }
            function generales2($fechaInicio=null,$fechaFinal=null,$filtro=null){
            $this->db->db_select('Produccion');
            $this->db->select('id_general,sucursal,grupo,asesor,cartera,fecha,mora');
            $this->db->from('generales');
            $this->db->where('grupo =', 01);
            $this->db->where('fecha >=', $fechaInicio);
            $this->db->where('fecha <=', $fechaFinal);
            if ($filtro != null) {
            $this->db->like('sucursal',$filtro,'after'); //hace un $id%, pone el simbolo luego de la variable       
        }
        $this->db->order_by('fecha','ASC');
        $query=$this->db->get();
        return $query->result();

    }
    function presupuestado($fecha=null,$filtro=null){
        $this->db->db_select('Produccion');
        $this->db->select('id_presupuestado,presupuestado,presupuestado.cartera,fecha, indice_eficiencia,cartera_efectiva,(presupuestado*(indice_eficiencia/100)) as car_efectiva');
        $this->db->from('presupuestado');
            $this->db->join('carteras','carteras.id_cartera=presupuestado.cartera');
        if ($fecha != null) {
            $this->db->like('fecha', $fecha,'after');
        }
        if ($filtro != null) {
            $this->db->like('cartera',$filtro,'after'); //hace un $id%, pone el simbolo luego de la variable       
        }
            $this->db->where('carteras.activo', 1);

        $this->db->order_by('fecha','ASC');
        $query=$this->db->get();
        return $query->result();

    }
     function presupuestado2($fechaInicio=null,$fechaFinal=null){
        $this->db->db_select('Produccion');
        $this->db->select('cartera,sum(presupuestado) as presu,sum(cartera_efectiva) as carEfec,fecha');
        $this->db->from('presupuestado');      
        if ($fechaFinal==null) {
        $this->db->like('fecha', $fechaInicio,'after'); 
            
        }else{
            $this->db->where('fecha >=', $fechaInicio);
            $this->db->where('fecha <=', $fechaFinal);
        }

        $this->db->group_by('cartera,fecha');

        $this->db->order_by('cartera','ASC');

        $query=$this->db->get();
        return $query->result();

    }
    function fechas(){
        $this->db->db_select('Operaciones');
        $this->db->select('hasta as fecha');
        $this->db->from('generales_produccion');
        $this->db->group_by('fecha','ASC');
        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }

    function generalTotal($desde,$hasta){
        $this->db->db_select('Produccion');
        $this->db->select('sum(generales.cartera) as cartera,fecha,sum(mora) as mora');
        $this->db->from('generales');
        $this->db->join('carteras','carteras.id_cartera=generales.sucursal');

        $this->db->where('grupo=',01);
        $this->db->where('fecha>=',$desde);
        $this->db->where('fecha<=',$hasta);
        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');
        $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        return $query->result();
    }


 
    function generalTotal2($desde,$hasta){
        $this->db->db_select('Produccion');
        $this->db->select('sum(cartera) as cartera,fecha,sum(mora) as mora,sucursal');
        $this->db->from('generales');
        $this->db->where('grupo=',01);
        $this->db->where('fecha>=',$desde);
        $this->db->where('fecha<=',$hasta);
        $this->db->group_by('fecha,sucursal','ASC');
        $this->db->order_by('fecha','ASC');
         //  $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        return $query->result();
    }
    function presupuestoTotal($desde,$hasta){
        $this->db->db_select('Produccion');
        $this->db->select('sum(presupuestado) as presu,sum(cartera_efectiva) as carEfec,fecha,sum(presupuestado*(indice_eficiencia/100)) as car_efectiva_presupuestada');
        $this->db->from('presupuestado');
        $this->db->join('carteras','carteras.id_cartera=presupuestado.cartera');
        $this->db->where('fecha>=',$desde);
        $this->db->where('fecha<=',$hasta);
        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');
        $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        return $query->result();
    }


        function presupuestoTotal2($desde,$hasta){
        $this->db->db_select('Produccion');
        $this->db->select('sum(presupuestado) as presu,sum(cartera_efectiva) as carEfec,fecha,presupuestado.cartera,sum(presupuestado*(indice_eficiencia/100)) as car_efectiva_presupuestada');
        $this->db->from('presupuestado');
        $this->db->join('carteras','carteras.id_cartera=presupuestado.cartera');

        $this->db->where('fecha>=',$desde);
        $this->db->where('fecha<=',$hasta);
        $this->db->group_by('fecha,cartera','ASC');
        $this->db->order_by('fecha','ASC');
            $this->db->where('carteras.activo ', 1);
        
        $query=$this->db->get();
        return $query->result();
    }

    function produccion($id){
        $this->db->db_select('Produccion');
        $this->db->select('permisos.id_usuarios');
        $this->db->from('permisos');
        $this->db->join('usuarios', 'usuarios.id_usuarios = permisos.id_usuarios');
        $this->db->where('usuarios.id_rol',2);
            $this->db->like('permisos.id_cartera',$id,'after'); //hace un $id%, pone el simbolo luego de la variable

            $query=$this->db->get();
            return $query->result();

        }
        function usuario($user){
           $this->db->db_select('Produccion');
           $this->db->select('id_agencia');
           $this->db->from('usuarios');
           $this->db->where('id_usuarios',$user);

           $query=$this->db->get();
           return $query->result();
       }
       function Prospectos($estado, $desde, $hasta){
        $this->db->db_select('Produccion');

        switch ($estado) {
            case 1:
            $this->db->select('*');
            $this->db->from('prospectos');
            if($estado==1){
                $this->db->where('estado=',$estado);
            }else{
                $this->db->where('estado!=',1);
                $this->db->where('estado!=',10);
            }
            
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            break;
            case 10:
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            break;
            default:
            $this->db->select('*');
            $this->db->from('prospectos');
            $this->db->where('estado!=',1);
            $this->db->where('estado!=',10);
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            break;
        }


        $query=$this->db->get();
        return $query->result();
    }

    function clientes_perdidos($estado,$desde,$hasta){
        $this->db->db_select('Produccion');

        if($estado == 1){
            $this->db->select('(ge.nuevos - ge.vencidos) as inactivos, ge.act, ge.inact, ge.sucursal, ge.fecha, ca.id_cartera, pe.id_usuarios, us.nombre, us.apellido');
        }else if($estado == 2){
            $this->db->select('SUM(ge.act) as activo, SUM(ge.nuevos - ge.vencidos) as inactivos');
        }
            $this->db->from('generales ge'); 
            $this->db->join('carteras ca','ca.id_cartera=ge.sucursal');
            $this->db->join('permisos pe','pe.id_cartera=ca.id_cartera');
            $this->db->join('usuarios us','us.id_usuarios=pe.id_usuarios');
            $this->db->where('ge.fecha BETWEEN"'.$desde.'" and "'.$hasta.'"');
            $this->db->where('ca.activo ', 1);


        $query=$this->db->get();
        return $query->result(); 
    }

    function Coloca($Coloca, $desde, $hasta){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1:
            $this->db->select_sum('monto_colocado');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);

            break;
            case 2:
            $this->db->select_sum('monto');
            $this->db->from('detalle_colocación'); 
            $this->db->join('colocacion','colocacion.id_detalle = detalle_colocación.id_detalle') ;
            $this->db->where('estado=', 1);
            $this->db->where('colocacion.fecha >= ',$desde);
            $this->db->where('colocacion.fecha <= ',$hasta);
            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function ProspectosRegion($estado, $desde, $hasta, $coordinador){
        $this->db->db_select('Produccion');


        switch ($estado) {
            case 1:
            $this->db->select('*');
            $this->db->from('prospectos');
            if($estado==1){
                $this->db->where('estado=',$estado);
            }else{
                $this->db->where('estado!=',1);
                $this->db->where('estado!=',10);
            }
            
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            $this->db->join('permisos', 'substr(prospectos.cartera,1,2)=substr(permisos.id_cartera,1,2)');
            $this->db->where('permisos.id_usuarios=', $coordinador);
            break;
            case 10:
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            $this->db->join('permisos', 'substr(colocado.prospecto,1,2)=substr(permisos.id_cartera,1,2)');
            $this->db->where('permisos.id_usuarios=', $coordinador);
            break;
            default:
            $this->db->select('*');
            $this->db->from('prospectos');
            $this->db->where('estado!=',1);
            $this->db->where('estado!=',10);
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            $this->db->join('permisos', 'substr(prospectos.cartera,1,2)=substr(permisos.id_cartera,1,2)');
            $this->db->where('permisos.id_usuarios=', $coordinador);
            break;
        }


        $query=$this->db->get();
        return $query->result();
    }

    function ColocaRegion($Coloca, $desde, $hasta,$coordinador){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1:
            $this->db->select_sum('monto_colocado');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            $this->db->join('permisos', 'substr(colocado.prospecto,1,2)=substr(permisos.id_cartera,1,2)');
            $this->db->where('permisos.id_usuarios=', $coordinador);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function ProspectosAgencia($estado, $desde, $hasta, $agencia){
        $this->db->db_select('Produccion');


        switch ($estado) {
            case 1:
            $this->db->select('*');
            $this->db->from('prospectos');
            if($estado==1){
                $this->db->where('estado=',$estado);
            }else{
                $this->db->where('estado!=',1);
                $this->db->where('estado!=',10);
            }
            
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(cartera,1,2)=', $agencia);
            break;
            case 10:
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(prospecto,1,2)=', $agencia);
            break;
            default:
            $this->db->select('*');
            $this->db->from('prospectos');
            $this->db->where('estado!=',1);
            $this->db->where('estado!=',10);
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            $this->db->where('substr(cartera,1,2)=', $agencia);
            break;
        }


        $query=$this->db->get();
        return $query->result();
    }


    function ColocaAgencia($Coloca, $desde, $hasta,$agencia){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1:
            $this->db->select_sum('monto_colocado');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(prospecto,1,2)=', $agencia);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function ProspectosCartera($estado, $desde, $hasta, $cartera){
        $this->db->db_select('Produccion');


        switch ($estado) {
            case 1:
            $this->db->select('*');
            $this->db->from('prospectos');
            if($estado==1){
                $this->db->where('estado=',$estado);
            }else{
                $this->db->where('estado!=',1);
                $this->db->where('estado!=',10);
            }
            
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('cartera=', $cartera);
            break;
            case 10:
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(prospecto,1,5)=', $cartera);
            break;
            default:
            $this->db->select('*');
            $this->db->from('prospectos');
            $this->db->where('estado!=',1);
            $this->db->where('estado!=',10);
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            $this->db->where('cartera=', $cartera);
            break;
        }


        $query=$this->db->get();
        return $query->result();
    }

    function ColocaCartera($Coloca, $desde, $hasta,$cartera){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1:
            $this->db->select_sum('monto_colocado');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            
            $this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function ColocaCarteraDiario($Coloca, $desde, $hasta,$cartera){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1://asesor - cartera
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
            case 2: //general
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            
            //$this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
            case 3://jefes - agencia
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
            $this->db->where('substr(prospecto,1,2)=', $cartera);

            break;
            case 4://coordinador - region
            $this->db->select('*');
            $this->db->from('colocado');
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            $this->db->where('SUBSTR(prospecto, 1, 2) IN (SELECT SUBSTR(id_cartera, 1, 2) FROM permisos WHERE id_usuarios = "'.$cartera.'")');
            
            //$this->db->where('substr(prospecto,1,2)=', $cartera);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function PresupuestoDiario($Coloca, $desde, $hasta,$cartera){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1://asesor - cartera
            $this->db->select('colocacion.monto,colocacion.fecha as fecha,cartera');
            $this->db->from('detalle_colocación');
            $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
            $this->db->where('detalle_colocación.estado',1);
            $this->db->where('colocacion.fecha>=',$desde);
            $this->db->where('colocacion.fecha<',$hasta);
            
            $this->db->where('substr(detalle_colocación.cartera,1,5)=', $cartera);

            break;
            case 2: //general
            $this->db->select('colocacion.monto,colocacion.fecha as fecha,cartera');
            $this->db->from('detalle_colocación');
            $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
            $this->db->where('detalle_colocación.estado',1);
            $this->db->where('colocacion.fecha>=',$desde);
            $this->db->where('colocacion.fecha<',$hasta);
            
            //$this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
            case 3://jefes - agencia
            $this->db->select('colocacion.monto,colocacion.fecha as fecha,cartera');
            $this->db->from('detalle_colocación');
            $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
            $this->db->where('detalle_colocación.estado',1);
            $this->db->where('colocacion.fecha>=',$desde);
            $this->db->where('colocacion.fecha<',$hasta);
            
            $this->db->where('substr(detalle_colocación.cartera,1,2)=', $cartera);

            break;
            case 4://coordinador - region
            $coordinador = $cartera;
            $this->db->select('colocacion.monto,colocacion.fecha as fecha,cartera');
            $this->db->from('detalle_colocación');
            $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
             $this->db->join('permisos', 'substr(permisos.id_cartera,1,2) = substr(detalle_colocación.cartera,1,2)');

            $this->db->where('detalle_colocación.estado',1);
            $this->db->where('colocacion.fecha>=',$desde);
            $this->db->where('colocacion.fecha<',$hasta);
            $this->db->where('permisos.id_usuarios=',$coordinador);
            //$this->db->where('permisos.id_cartera in (select id_cartera from permisos where id_usuarios="'.$cartera.'") and permisos.id_usuarios!="'.$cartera.'"');
            /*$this->db->where('SUBSTR(prospecto, 1, 2) IN (SELECT SUBSTR(id_cartera, 1, 2) FROM permisos WHERE id_usuarios = "'.$cartera.'")');*/
            
            //$this->db->where('substr(prospecto,1,2)=', $cartera);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function FactibilidadDiaria($Coloca, $desde, $hasta,$cartera){
        $this->db->db_select('Produccion');
        switch ($Coloca) {
            case 1://asesor - cartera
            $this->db->select('*');
            $this->db->from('datos_resultados');
            $this->db->where('resultado_final',"CREDITO APROBADO");
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            
            $this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
            case 2: //general
            $this->db->select('*');
            $this->db->from('datos_resultados');
            $this->db->where('resultado_final',"CREDITO APROBADO");
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            
            //$this->db->where('substr(prospecto,1,5)=', $cartera);

            break;
            case 3://jefes - agencia
            $this->db->select('*');
            $this->db->from('datos_resultados');
            $this->db->where('resultado_final',"CREDITO APROBADO");
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<',$hasta);
            
            $this->db->where('substr(prospecto,1,2)=', $cartera);

            break;
            case 4://coordinador - region
            $coordinador = $cartera;
            $this->db->select('*');
            $this->db->from('datos_resultados');
            $this->db->join('permisos','substr(datos_resultados.prospecto,1,2)=substr(permisos.id_cartera,1,2)');
            $this->db->where('datos_resultados.fecha>=',$desde);
            $this->db->where('datos_resultados.fecha<',$hasta);
            $this->db->where('permisos.id_usuarios=',$coordinador);
            //$this->db->where('SUBSTR(prospecto, 1, 2) IN (SELECT SUBSTR(id_cartera, 1, 2) FROM permisos WHERE id_usuarios = "'.$cartera.'")');
            
            //$this->db->where('substr(prospecto,1,2)=', $cartera);

            break;
        }
        $query=$this->db->get();
        return $query->result();
    }

    function insertarColocacion($data){
        $this->db->db_select('Produccion');
        $result=$this->db->insert('colocacion',$data);
        return $result;
    }
    function insertarDetalleColoca($data){
        $this->db->db_select('Produccion');
        $result=$this->db->insert('detalle_colocación',$data);
        return $this->db->insert_id();
    }
    
    function verColocacion($id_usuario,$fecha){
        $this->db->db_select('Produccion');
        $this->db->select('monto,colocacion.fecha');
        $this->db->from('colocacion');
        $this->db->join('detalle_colocación as detalle', 'detalle.id_detalle=colocacion.id_detalle');
        $this->db->where('detalle.usuario',$id_usuario);
        $this->db->like('colocacion.fecha',$fecha);
        $query=$this->db->get();
        return $query->result();

    }
    function verDetalleColocacion($id_usuario,$fecha){
         $this->db->db_select('Produccion');
        $this->db->select('comentario,estado,usuario,detalle.id_detalle');
        $this->db->from('detalle_colocación as detalle');
         $this->db->join('colocacion as coloca', 'detalle.id_detalle=coloca.id_detalle');
        $this->db->where('usuario',$id_usuario);
        $this->db->like('coloca.fecha',$fecha);
        $query=$this->db->get();
        return $query->result();

    }
    function actualizarDetalleColocacion($id_usuario,$fecha,$estado,$comentario){
        $this->db->db_select('Produccion');
        $this->db->set('estado', $estado);
        $this->db->set('comentario', $comentario);
        $this->db->where('usuario',$id_usuario);
        $this->db->like('fecha',$fecha);
        $result=$this->db->update('detalle_colocación');
        return $result;
    }
    function eliminarColocacion($id_detalle,$fecha){
        $this->db->where('id_detalle', $id_detalle);
        $this->db->like('fecha',$fecha);
        $result=$this->db->delete('colocacion');
        return $result;
    }
    /*
            SELECT * FROM `colocacion` inner join detalle_colocación on colocacion.id_detalle = detalle_colocación.id_detalle where
            detalle_colocación.cartera ='05029' and estado = '1'
    */
    function ColocacionCartera($cartera,$fecha=null){
        $this->db->db_select('Produccion');
        $this->db->select('monto,colocacion.fecha as fecha,cartera');
        $this->db->from('detalle_colocación');
        $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
        //$this->db->where('detalle_colocación.cartera',$cartera);
        $this->db->like('detalle_colocación.cartera',$cartera,'after');

        $this->db->where('estado',1);

        if ($fecha!=null) {            
        $this->db->like('colocacion.fecha',$fecha,'after');
        }
       $this->db->group_by('colocacion.id_colocacion');

        $query=$this->db->get();
        return $query->result();    
    }
    
    function ColoCarteraTotal($fecha=null){
        $this->db->db_select('Produccion');
        $this->db->select('monto,colocacion.fecha as fecha,cartera');
        $this->db->from('detalle_colocación');
        $this->db->join('colocacion', 'colocacion.id_detalle = detalle_colocación.id_detalle');
        $this->db->where('estado',1);
        if ($fecha!=null) {            
        $this->db->like('colocacion.fecha',$fecha,'after');
        }
       $this->db->group_by('colocacion.id_colocacion');

        $query=$this->db->get();
        return $query->result();    
    }
    function nombreCartera($id_cartera){
         $this->db->db_select('Operaciones');

            $this->db-> select('cartera');
            $this->db-> from('carteras'); 
            $this->db-> where('id_cartera', $id_cartera);
            $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        return $query->result();
    }

    /*
   select agencia,(select nombre FROM generales as gene where gene.sucursal=generales.sucursal ORDER BY gene.fecha DESC limit 1) as nombre,carteras.cartera,(select sum(monto_colocado) from colocado where substr(colocado.prospecto,1,5) =generales.sucursal and colocado.fecha>="2019-09-01" and colocado.fecha<="2019-09-30") AS nuevos,generales.sucursal as car,AVG(generales.cartera) as cartera2,(AVG((mora/generales.cartera)*100)) AS mora FROM `generales` inner join carteras on generales.sucursal = carteras.id_cartera WHERE generales.fecha >= "2019-09-01" and generales.fecha <= "2019-09-30" and generales.grupo = 01 GROUP by agencia,sucursal ORDER BY generales.sucursal
    */


     function ReporteRC($fechaInicio,$fechaFinal){
 
    $this->db->db_select('Produccion');
    
  
             $query = $this->db->query('select agencia,(select nombre FROM generales as gene where gene.sucursal=generales.sucursal ORDER BY gene.fecha DESC limit 1) as nombre,carteras.cartera,(select sum(monto_colocado) from colocado where substr(colocado.prospecto,1,5) =generales.sucursal and colocado.fecha>="'.$fechaInicio.'" and colocado.fecha<="'.$fechaFinal.'") AS nuevos,generales.sucursal as car,AVG(generales.cartera) as cartera2,(AVG((mora/generales.cartera)*100)) AS mora, sum(vencidos) as clientesv FROM `generales` inner join carteras on generales.sucursal = carteras.id_cartera 
                WHERE generales.fecha >= "'.$fechaInicio.'" and generales.fecha <= "'.$fechaFinal.'" and generales.grupo = 01 
                GROUP by agencia,sucursal
                ORDER BY generales.sucursal');

 

            return $query->result();
       
    }
        function ReporteRC2($fechaInicio,$fechaFinal=null){
            $this->db->db_select('Produccion');

            $this ->db-> select('agencia,sucursal,sum(generales.cartera) as cartera,sum((mora/generales.cartera)*100) AS mora,sum(mora) as mora2,sum(salvenc) as capitalv,sum(nuevos) as clientesn,(select sum(monto_colocado) from colocado where substr(colocado.prospecto,1,5) =generales.sucursal and colocado.fecha like "'.$fechaInicio.'") AS nuevos,sum(vencidos) as clientesv,sum(cap_recup) as cap_recup,sum(colocacion) as colocacion');
            $this ->db-> from('generales'); 
            if ($fechaFinal==null) {
                # code...
                 $this ->db-> like('fecha', $fechaInicio,'after');
            }else{
                $this->db->where('fecha >=', $fechaInicio);
                $this->db->where('fecha <=', $fechaFinal);
            }
            $this ->db-> where('grupo', 01);
            $this->db->group_by('sucursal');    
            $this->db->group_by('agencia');    

            $this ->db->order_by('sucursal','ASC');

            $query=$this->db->get();
            $this->db->db_select('tablero');

            return $query->result();

             
    }



     function fecha_cierre($fechaInicio){
            $this->db->db_select('Produccion');

            $this -> db -> select('fecha');
            $this -> db -> from('generales'); 
            $this -> db -> like('fecha', $fechaInicio,'after');

            $this ->db ->order_by('fecha','DESC');
            $this ->db ->limit(1);

            $query=$this->db->get();
            return $query->row();

             
    }
    function fecha_cierre2($fechaInicio){
            $this->db->db_select('Produccion');

            $this -> db -> select('fecha');
            $this -> db -> from('generales'); 
            $this -> db -> where('fecha <=', $fechaInicio);

            $this ->db ->order_by('fecha','DESC');
            $this ->db ->limit(1);

            $query=$this->db->get();
            return $query->row();

             
    }

    function reporte_cartera($fechaInicio){
            $this->db->db_select('Produccion');

            $this ->db-> select('agencia, SUM(cartera) as cartera,fecha');
            $this ->db-> from('generales'); 
            $this ->db-> like('fecha', $fechaInicio,'after');
            $this ->db-> where('grupo', 01);
            
            $this ->db ->group_by('agencia','ASC');
            $this ->db ->group_by('fecha','ASC');

            $query=$this->db->get();
            return $query->result();
    }

    function buscar_agencia(){
        $this ->db->select('id_agencia, agencia');
        $this ->db-> where('id_agencia != 00');
        $result = $this ->db->get('agencias');
        return $result->result();
    }

    function buscar_perfil(){
        $this ->db->select('id_perfil, nombre');
        $this ->db-> where('id_perfil != 1 and id_perfil != 24');
        $result = $this ->db->get('perfil');
        return $result->result();
    }

    function insertar_asignaciones($datos){
        $this->db->insert('asignar_agencias', $datos);
    }

    function get_asignaciones(){
        $this->db->select('aa.id_perfil, pe.nombre as perfil, aa.fecha_creacion, aa.nombre, aa.codigo');
        $this->db->from('asignar_agencias aa');
        $this->db->join('perfil pe', 'pe.id_perfil=aa.id_perfil');
      
        $this->db->group_by('aa.id_perfil');    
        $this->db->group_by('pe.nombre');
        $this->db->group_by('aa.fecha_creacion');
        $this->db->group_by('aa.nombre');
        $this->db->group_by('aa.codigo');

        $this->db->where('pe.id_perfil IN (SELECT id_perfil FROM asignar_agencias)');

        $result = $this->db->get();
        return $result->result();
    }

    function get_asignaciones2($codigo=null,$asignacion=null){
        $this->db->db_select('tablero');
        $this->db->select('aa.id_perfil, pe.nombre as perfil, aa.id_agencia, aa.fecha_creacion, aa.nombre, aa.estado');
        $this->db->from('asignar_agencias aa');
        $this->db->join('perfil pe', 'pe.id_perfil=aa.id_perfil');

        if($codigo != null){
            $this->db->where('aa.codigo',$codigo);
        }else if($asignacion != null){
            $this->db->where('aa.codigo',$asignacion);
        }
        $this->db->where('aa.estado != 0');
        $this->db->where('pe.id_perfil IN (SELECT id_perfil FROM asignar_agencias)');

        $result = $this->db->get();
        return $result->result();
    }

    //APARTADO PARA LA COLOCACION DE SISTEMA ALTERCREDIT
    function coloca_operaciones($desde,$hasta,$estado=null){
        $this->db->db_select('Operaciones');
        $this->db->select('cliente.dui,cliente.nit,cliente.cartera,solicitud.monto,desembolso.fecha_desembolso,carteras.cartera as nom_cartera');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');
        $this->db->where('desembolso.estado_desembolso', 1);
        $this->db->where('solicitud.tipo_solicitud', 0);
        if($estado != null){
            $this->db->where('desembolso.fecha_desembolso >=',$desde);
            $this->db->where('desembolso.fecha_desembolso <',$hasta);
        }else if($estado == null){
            //$this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
            $this->db->where('desembolso.fecha_desembolso >=',$desde);
            $this->db->where('desembolso.fecha_desembolso <',$hasta);
        }else if($estado == 2){
            $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
        }
                        $this->db->where('carteras.activo ', 1);

        /*$this->db->db_select('Operaciones');
        $this->db->select('cliente.nombre,cliente.apellido,cliente.dui,cliente.nit,cliente.cartera,solicitud.monto,desembolso.fecha_desembolso');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');

        $this->db->where('desembolso.estado_desembolso', 1);
        $this->db->where('solicitud.tipo_solicitud', 0);
        $this->db->where('carteras.id_agencia', 18);
        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');*/

        $query=$this->db->get();
        return $query->result();
    }

    function carteras_agencias($id_agencia){
        $this->db->db_select('Produccion');
        $this->db->select('*');
        $this->db->from('carteras');
        $this->db->where('id_agencia', $id_agencia);
        $this->db->where('activo', 1);


        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function colocados_operaciones($desde,$hasta,$id_cartera){
        //datos necesarios para mostrar las colocaciones del mes
        $this->db->db_select('Operaciones');
        $this->db->select('cliente.dui,cliente.nit,cliente.cartera,solicitud.monto,desembolso.fecha_desembolso,carteras.cartera as nom_cartera');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');
        $this->db->where('desembolso.estado_desembolso', 1);
        $this->db->where('solicitud.tipo_solicitud', 0);
        $this->db->where('cliente.cartera', $id_cartera);
        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
                                $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function buscar_nombre($id_cartera){
        $this->db->db_select('Produccion');
        $this->db->select('usuarios.id_usuarios, concat(usuarios.nombre," ",usuarios.apellido) as nombre');
        $this->db->from('usuarios');
        $this->db->join('permisos', 'permisos.id_usuarios=usuarios.id_usuarios');
        $this->db->where('permisos.id_cartera', $id_cartera);

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function buscar_region($id_agencia){
        $this->db->select('*');
        $this->db->from('asignar_agencias');
        $this->db->where('id_agencia', $id_agencia);
        $this->db->where('estado', 1);

        $query=$this->db->get();
        return $query->result();
    }

    function buscar_agencias(){
        $this->db->select('*');
        $this->db->from('agencias');

        $query=$this->db->get();
        return $query->result();
    }

    function vefificacion_fox($dui,$agencia){
        $this->db->db_select('basefox');
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('resumen_maeasoc_'.$agencia);
         $this->db->where('DUI="'. $dui. '"');
        $this->db->where('substr(CODIGO, 0,1) != "F"');

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function verifica_codigo_fox($dui,$nit){
        $this->db->db_select('Operaciones');
        $this->db->select('COUNT(*) as conteo');
        $this->db->from('fox_operaciones');
        $this->db->join('cliente', 'cliente.codigo=fox_operaciones.codigo_operaciones');
        
        $this->db->where('cliente.dui', $dui);
        $this->db->or_where('cliente.nit', $nit);

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    
    public function asignacion_regional(){
            $this->db->select('aa.nombre, aa.codigo,concat(substring_index(empleados.nombre," ",1)," ",substring_index(empleados.apellido," ",1)) as empleado');
            $this->db->from('asignar_agencias aa');
            $this->db->join('login', 'login.codigo=aa.codigo','left');
            $this->db->join('empleados', 'empleados.id_empleado=login.id_empleado','left');


            $this->db->where('aa.estado',1);

            $this->db->group_by('aa.nombre, aa.codigo,concat(substring_index(empleados.nombre," ",1)," ",substring_index(empleados.apellido," ",1))');

            $result = $this->db->get();


            return $result->result();
    }   
    public function buscar_asignaciones($codigo=null,$agencia=null){
            $this->db->select('aa.id_perfil, aa.fecha_creacion, aa.nombre, aa.codigo,aa.id_agencia,age.agencia');
            $this->db->from('asignar_agencias aa');
            $this->db->join('agencias age', 'age.id_agencia=aa.id_agencia');
            $this->db->where('aa.estado',1);
            $this->db->where('age.id_agencia !=',24);

            if ($codigo!=null) {
             $this->db->where('aa.codigo',$codigo);
              
            }
            if ($agencia!=null) {
             $this->db->where('aa.id_agencia',$agencia);
              
            }
            $result = $this->db->get();


            return $result->result();
    }  
  
    function rendicion_global($mes=null,$agencia=null,$cartera=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('(cartera_act) as cartera_act,(efectiva) as efectiva,hasta,((efectiva)/(cartera_act))*100 as indice_efectiva,(monto_actual) as recupera');
        $this->db->from('generales_produccion');
        if ($mes!=null ) {
            $this->db->like('hasta',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable
            $this->db->order_by('hasta','DESC');
        
        }
        if ($agencia!=null) {
            $this->db->where('agencia',$agencia);
        }
        if ($cartera!=null) {
            $this->db->where('id_cartera',$cartera);
        }

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function generales_global($desde=null,$hasta=null,$agencia=null,$cartera=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act))*100 as indice_efectiva,sum(monto_actual) as recupera');
        $this->db->from('generales_produccion');
        if ($desde!=null and $hasta!=null) {
            $this->db->where('hasta>=',$desde);
            $this->db->where('hasta<=',$hasta);
            
        }else if($hasta!=null){
            $this->db->where('hasta',$hasta);
        }else{  
            $this->db->order_by('hasta','DESC');
            $this->db->limit(1);
        }

        
        if ($agencia!=null) {
            $this->db->where('agencia',$agencia);

        }
        if ($cartera!=null) {
            $this->db->where('id_cartera',$cartera);

        }
        $this->db->group_by('hasta','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function presupuesto_global($desde=null,$hasta=null,$agencia=null,$cartera=null){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as presu_cartera_activa,sum(cartera_recuperacion) as presu_cartera_recuperacion,fecha,sum(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva');
        $this->db->from('presupuestado');
        $this->db->join('carteras','carteras.id_cartera=presupuestado.cartera');

        if ($desde!=null and $hasta!=null) {
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
        }else{
            $this->db->where('fecha',$hasta);

        }
        $this->db->where('carteras.activo ', 1);
        if ($agencia!=null) {
            $this->db->where('carteras.id_agencia',$agencia);

        }
        if ($cartera!=null) {
            $this->db->where('carteras.id_cartera',$cartera);

        }
        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    public function generales_regional($desde,$hasta,$region)
    {
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act))*100 as indice_efectiva,sum(monto_actual) as recupera');
        $this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');

      

            $this->db->where('hasta>=',$desde);
            $this->db->where('hasta<=',$hasta);
            

        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.codigo',$region);


        $this->db->group_by('hasta','ASC');


        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function presupuesto_regional($desde=null,$hasta=null,$region){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as presu_cartera_activa,sum(cartera_recuperacion) as presu_cartera_recuperacion,fecha,sum(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva');
        $this->db->from('Operaciones.presupuestado op,tablero.asignar_agencias aa,Operaciones.carteras oc');


        if ($desde!=null and $hasta!=null) {
            $this->db->where('fecha>=',$desde);
            $this->db->where('fecha<=',$hasta);
            
        }else{
            $this->db->where('fecha',$hasta);

        }
        $this->db->where('aa.id_agencia=substr(op.cartera,1,2)');
        $this->db->where('op.cartera=oc.id_cartera');


        $this->db->where('oc.activo ', 1);
        $this->db->where('aa.codigo ', $region);

        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();


    }
    public function generales_indicadores_region($fecha=null,$region)
    {
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act))*100 as indice_efectiva,sum(monto_actual) as recupera,aa.codigo');
        $this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');

        if($fecha!=null){
            $this->db->where('hasta',$fecha);
        
        }else{  
            $this->db->order_by('hasta','DESC');
            $this->db->limit(1);

        }
        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.codigo',$region);


        $this->db->group_by('hasta','ASC');


        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    public function generales_indicadores_regional($fecha=null,$id_agencia)
    {
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act))*100 as indice_efectiva,sum(monto_actual) as recupera,aa.id_agencia');
        $this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');

        if($fecha!=null){
            $this->db->where('hasta',$fecha);
        
        }else{  
            $this->db->order_by('hasta','DESC');
            $this->db->limit(1);

        }
            $this->db->group_by('aa.id_agencia','ASC');
        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.id_agencia',$id_agencia);


        $this->db->group_by('hasta','ASC');


        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function presupuesto_indicadores_region($fecha=null,$region){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as presu_cartera_activa,sum(cartera_recuperacion) as presu_cartera_recuperacion,fecha,sum(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva,aa.codigo');
        $this->db->from('Operaciones.presupuestado op,tablero.asignar_agencias aa,Operaciones.carteras oc');



            $this->db->where('fecha',$fecha);

        
        $this->db->where('aa.id_agencia=substr(op.cartera,1,2)');
        $this->db->where('op.cartera=oc.id_cartera');


        $this->db->where('aa.codigo',$region);

        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();


    }
    function presupuesto_indicadores_regional($fecha=null,$agencia){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as presu_cartera_activa,sum(cartera_recuperacion) as presu_cartera_recuperacion,fecha,sum(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva,aa.id_agencia');
        $this->db->from('Operaciones.presupuestado op,tablero.asignar_agencias aa,Operaciones.carteras oc');



            $this->db->where('fecha',$fecha);

        
        $this->db->where('aa.id_agencia=substr(op.cartera,1,2)');
        $this->db->where('op.cartera=oc.id_cartera');


        $this->db->where('oc.activo ', 1);
        $this->db->where('aa.id_agencia ', $agencia);
            $this->db->group_by('aa.id_agencia','ASC');

        $this->db->group_by('fecha','ASC');
        $this->db->order_by('fecha','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();


    }
    function generales_indicadores_agencia($hasta=null,$agencia=null,$cartera=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('cartera_act as cartera_act,efectiva,hasta,(efectiva/cartera_act)*100 as indice_efectiva,monto_actual as recupera,id_cartera,asesor,mora,clientes,clientes_vencidos,total_colocacion,capital_recuperado,vencidos,nuevos');
        $this->db->from('generales_produccion');

            $this->db->where('hasta',$hasta);


        
        if ($agencia!=null) {
            $this->db->where('agencia',$agencia);

        }
        if ($cartera!=null) {
            $this->db->where('id_cartera',$cartera);

        }

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function generales_mensuales_global($hasta){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act)) as indice_efectiva,sum(monto_actual) as recupera');
        $this->db->from('generales_produccion');
        $this->db->join('carteras','carteras.id_cartera=generales_produccion.id_cartera');
        $this->db->like('hasta',$hasta,'after'); //hace un $id%, pone el simbolo luego de la variable
        $this->db->group_by('hasta');
        $this->db->order_by('hasta','DESC');
        $this->db->limit(1);


        $this->db->where('carteras.activo ', 1);


        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }  
    function generales_mensuales_regional($hasta,$region){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act)) as indice_efectiva,sum(monto_actual) as recupera');
        $this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');
        //$this->db->join('carteras','carteras.id_cartera=generales_produccion.id_cartera');
        $this->db->like('hasta',$hasta,'after'); //hace un $id%, pone el simbolo luego de la variable
        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.codigo',$region);

        $this->db->group_by('hasta');
        $this->db->order_by('hasta','DESC');
        $this->db->limit(1);


        //$this->db->where('carteras.activo ', 1);
/*
$this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');

        $this->db->where('desde>=',$desde);
        $this->db->where('hasta<=',$hasta);
        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.codigo',$region);


        $this->db->group_by('hasta','ASC');

*/

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }  
    function presupuesto_mensuales_global($fecha){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as pre_cartera_activa,sum(cartera_recuperacion) as pre_cartera_recuperacion,fecha');

        $this->db->from('presupuestado');
        $this->db->join('carteras','carteras.id_cartera=presupuestado.cartera');
        $this->db->like('fecha',$fecha,'after'); //hace un $id%, pone el simbolo luego de la variable
        $this->db->group_by('fecha');
        $this->db->order_by('fecha','DESC');
        $this->db->limit(1);


        $this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function presupuesto_mensuales_regional($fecha,$region){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as pre_cartera_activa,sum(cartera_recuperacion) as pre_cartera_recuperacion,fecha');

        $this->db->from('Operaciones.presupuestado op,tablero.asignar_agencias aa,Operaciones.carteras oc');
        $this->db->like('fecha',$fecha,'after'); //hace un $id%, pone el simbolo luego de la variable
        $this->db->where('aa.id_agencia=substr(op.cartera,1,2)');
        $this->db->where('op.cartera=oc.id_cartera');
        $this->db->where('oc.activo ', 1);
        $this->db->where('aa.codigo ', $region);

        $this->db->order_by('fecha','DESC');
        $this->db->group_by('fecha');
        $this->db->limit(1);



        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
        function carteras_operaciones($agencia){
            $this->db->db_select('Operaciones');

            $this -> db -> select('id_cartera,cartera,agencias.agencia');
            $this -> db -> from('carteras'); 
            $this->db->join('agencias','agencias.id_agencia=carteras.id_agencia');
            
            
            $this -> db -> where('carteras.id_agencia', $agencia);
            $this->db->where('carteras.activo ', 1);

            $this->db->order_by('id_cartera');
            $query = $this-> db->get();

            if ($query->num_rows() >= 1) {
        $this->db->db_select('tablero');
             return $query->result();
         } else {
        $this->db->db_select('tablero');
            
             return 0;
         }
     }
        function cartera_operaciones($id_cartera){
            $this->db->db_select('Operaciones');

            $this -> db -> select('carteras.id_cartera,cartera,agencias.agencia,concat(substring_index(usuarios.nombre," ",1)," ",substring_index(usuarios.apellido," ",1)) as empleado');
            $this -> db -> from('carteras'); 
            $this->db->join('agencias','agencias.id_agencia=carteras.id_agencia', 'left');
            $this->db->join('usuario_cartera','usuario_cartera.id_cartera=carteras.id_cartera','left');
            $this->db->join('usuarios','usuarios.id_usuarios=usuario_cartera.id_usuarios','left');


            
            
            $this -> db -> where('carteras.id_cartera', $id_cartera);
            $this->db->where('carteras.activo ', 1);

            $this->db->order_by('carteras.id_cartera');
            $query = $this-> db->get();

            if ($query->num_rows() >= 1) {
        $this->db->db_select('tablero');
             return $query->result();
         } else {
             return 0;
         }
     }
       public function usuario_cargo($id_agencia,$id_cargo){
            $this->db->db_select('Operaciones');

            $this->db->select('usuarios.nombre,usuarios.apellido,cargos.cargo');
            $this->db->from('usuarios');
            $this->db->join('cargos', 'cargos.id_cargo=usuarios.id_cargo');
            if ($id_agencia!=null) {
             $this->db->where('usuarios.id_agencia', $id_agencia);
           }
           $this->db->where('usuarios.id_cargo', $id_cargo);
           $this->db->where('usuarios.id_estado', '1');


           $result = $this->db->get();
                $this->db->db_select('tablero');
           return $result->result();
          }

        function cartera_empleado($id_usuario){
            $this->db->db_select('Operaciones');

            $this -> db -> select('carteras.id_cartera,cartera,agencias.agencia,concat(substring_index(usuarios.nombre," ",1)," ",substring_index(usuarios.apellido," ",1)) as empleado');
            $this -> db -> from('carteras'); 
            $this->db->join('agencias','agencias.id_agencia=carteras.id_agencia');
            $this->db->join('usuario_cartera','usuario_cartera.id_cartera=carteras.id_cartera','left');
            $this->db->join('usuarios','usuarios.id_usuarios=usuario_cartera.id_usuarios','left');


            
            
            $this -> db -> where('usuario_cartera.id_usuarios', $id_usuario);
            $this->db->where('carteras.activo ', 1);

            $this->db->order_by('carteras.id_cartera');
            $query = $this-> db->get();

            if ($query->num_rows() >= 1) {
        $this->db->db_select('tablero');
             return $query->result();
         } else {
             return 0;
         }
     }
         public function contador_generales_indicadores_region($fecha=null,$region)
    {
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_act) as cartera_act,sum(efectiva) as efectiva,hasta,(sum(efectiva)/sum(cartera_act))*100 as indice_efectiva,sum(monto_actual) as recupera,aa.id_agencia');
        $this->db->from('Operaciones.generales_produccion gp,tablero.asignar_agencias aa');

        if($fecha!=null){
            $this->db->where('hasta',$fecha);
        
        }else{  
            $this->db->order_by('hasta','DESC');
            $this->db->limit(1);

        }
        $this->db->where('aa.id_agencia=gp.agencia');
        $this->db->where('aa.codigo',$region);


        $this->db->group_by('id_agencia','ASC');


        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
    function contador_presupuesto_indicadores_region($fecha=null,$region){
        $this->db->db_select('Operaciones');
        $this->db->select('sum(cartera_activa) as presu_cartera_activa,sum(cartera_recuperacion) as presu_cartera_recuperacion,fecha,sum(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva,aa.id_agencia');
        $this->db->from('Operaciones.presupuestado op,tablero.asignar_agencias aa,Operaciones.carteras oc');



            $this->db->where('fecha',$fecha);

        
        $this->db->where('aa.id_agencia=substr(op.cartera,1,2)');
        $this->db->where('op.cartera=oc.id_cartera');


        $this->db->where('aa.codigo',$region);

        $this->db->group_by('id_agencia','ASC');
        $this->db->order_by('fecha','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();


    }

    //reporte de bonificacion

    function ReporteBono($fechaInicio,$fechaFinal){

    $this->db->db_select('Produccion');
    
  
             $query = $this->db->query('select agencia,(select nombre FROM generales as gene where gene.sucursal=generales.sucursal ORDER BY gene.fecha DESC limit 1) as nombre,carteras.cartera,(select sum(monto_colocado) from colocado where substr(colocado.prospecto,1,5) =generales.sucursal and colocado.fecha>="'.$fechaInicio.'" and colocado.fecha<="'.$fechaFinal.'") AS nuevos,generales.sucursal as car,AVG(generales.cartera) as cartera2,(AVG((mora/generales.cartera)*100)) AS mora FROM `generales` inner join carteras on generales.sucursal = carteras.id_cartera 
                WHERE generales.fecha >= "'.$fechaInicio.'" and generales.fecha <= "'.$fechaFinal.'" and generales.grupo = 01 
                GROUP by agencia,sucursal
                ORDER BY generales.sucursal');

 
       if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return "Todos ingresaron";
        }
    }
    function reporte_bonificacion($fechaInicio,$fechaFinal,$agencia=null){
        //consulta para poder hacer los calculos de las comisiones
        $this->db->db_select('Operaciones');
        $this->db-> select('usuarios.id_usuarios,agencias.id_agencia,agencias.agencia,generales_produccion.id_cartera,carteras.cartera,CONCAT(usuarios.nombre," ",usuarios.apellido) as empleado,sum(nuevos) as nuevos,AVG(cartera_act) as cartera_act,avg(mora) as mora,(((AVG(mora+vencidos)/AVG(cartera_act))*100)) AS indice_mora,100-(((AVG(mora)/AVG(cartera_act))*100)) as indice_eficiencia,aa.nombre as region');
        $this->db-> from('generales_produccion,tablero.asignar_agencias aa'); 
        $this->db->join('agencias','agencias.id_agencia=generales_produccion.agencia');
        $this->db->join('carteras','carteras.id_cartera=generales_produccion.id_cartera');
        $this->db->join('usuario_cartera','usuario_cartera.id_cartera=carteras.id_cartera','left');
        $this->db->join('usuarios',' usuarios.id_usuarios=usuario_cartera.id_usuarios','left');
        $this->db->where('agencias.id_agencia=aa.id_agencia');
        $this->db->where('desde >=',$fechaInicio);
        $this->db->where('hasta <=',$fechaFinal);
        $this->db->where('hasta !=','2022-07-30');

        if ($agencia!=null) {
            $this->db->where('agencias.id_agencia',$agencia);  
        }
        $this->db->group_by('agencias.id_agencia,agencia,id_cartera,aa.nombre,CONCAT(usuarios.nombre," ",usuarios.apellido),usuarios.id_usuarios');
        $this->db->order_by('aa.nombre','ASC');
        $this->db->order_by('id_cartera','ASC');
        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function empleados_cargos($id_agencia){
        $this->db->select('empleados.id_empleado, agencias.id_agencia, agencias.agencia, contrato.id_contrato, concat(empleados.nombre," ",empleados.apellido) as nombre, cargos.id_cargo, cargos.cargo ');
        $this->db->from('empleados');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('agencias', 'agencias.id_agencia=contrato.id_agencia');
        $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');

        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
        $this->db->where('contrato.id_agencia',$id_agencia);
        //$this->db->where('(cargos.id_cargo = 015 or cargos.id_cargo = 016 or cargos.id_cargo = 017)');
        $this->db->where('(cargos.id_cargo = 015 or cargos.id_cargo = 016)');

        $result = $this->db->get();
        return $result->result();

    }

    function coordinador_bono($agencia){
        $this->db->select('empleados.id_empleado,contrato.id_contrato,concat(empleados.nombre," ",empleados.apellido) as coordinador');
        $this->db->from('empleados'); 
        $this->db->join('login', 'login.id_empleado=empleados.id_empleado');
        $this->db->join('asignar_agencias', 'asignar_agencias.codigo=login.codigo');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');

        $this->db->where('asignar_agencias.id_agencia', $agencia);
        $this->db->where('asignar_agencias.estado', 1);
        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
            
        $result = $this->db->get();
        return $result->result();
    }

    function contrato_login($id_usuarios){
        $this->db->select('login.id_login,empleados.id_empleado, contrato.id_contrato, concat(empleados.nombre," ",empleados.apellido) as nombre,contrato.id_cargo,cargo,contrato.id_agencia,contrato.fecha_inicio');
        $this->db->from('login'); 
        $this->db->join('empleados', 'empleados.id_empleado=login.id_empleado');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');


        $this->db->where('login.id_login', $id_usuarios);
        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
            
        $result = $this->db->get();
        return $result->result();
    }

    function usuario_multiple($agencia){
        $this->db->select('login.id_login, empleados.id_empleado, contrato.id_contrato, concat(empleados.nombre," ",empleados.apellido) as nombre, cargos.id_cargo');
        $this->db->from('login'); 
        $this->db->join('empleados', 'empleados.id_empleado=login.id_empleado');
        $this->db->join('contrato', 'contrato.id_empleado=empleados.id_empleado');
        $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo');
        $this->db->join('Operaciones.usuario_agencia ua', 'ua.id_usuario=login.id_login');
        $this->db->join('Operaciones.usuarios us', 'us.id_usuarios=ua.id_usuario');

        $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
        $this->db->where('ua.id_agencia',$agencia);
        $this->db->where('(cargos.id_cargo = 015 or cargos.id_cargo = 016)');
        $this->db->where('(us.id_rol = 13 or us.id_rol = 7)');
            
        $result = $this->db->get();
        return $result->result();
    }
    //NO23012023 inicia function para traer a los referentes de cartera
    function get_referente_cartera($id_cartera){
        $this->db->db_select(("Operaciones"));
        $this->db->select("*");
        $this->db->from("usuario_referente_cartera");
        $this->db->where("id_cartera", $id_cartera);
        $result = $this->db->get();
        $this->db->db_select("tablero");
        return $result->result();

    }
    //finaliza la functiona para traer a los referentes de cartera

    function insert_bonificacion($data){
        $result= $this->db->insert('bonificacion',$data);
        return $result;
    }

    function insert_bonos_no_pagados($data){
        $result= $this->db->insert('bonos_no_pagados',$data);
        return $result;
    }

    function get_bonificacion($agencia,$mes_bono){
        $this->db->select('bonificacion.id_bono,empleados.id_empleado,agencias.agencia, concat(empleados.nombre," ",empleados.apellido) as nombre, cargos.cargo, car.cartera, bonificacion.bono, bonificacion.mes, bonificacion.quincena, bonificacion.id_cartera, bonificacion.estado_control,bonificacion.estado,numero_control, bonificacion.tipo_bono');
        $this->db->from('bonificacion'); 

        $this->db->join('contrato', 'contrato.id_contrato=bonificacion.id_contrato', "left");
        $this->db->join('empleados', 'empleados.id_empleado=contrato.id_empleado', "left");
        $this->db->join('cargos', 'cargos.id_cargo=contrato.id_cargo', "left");
        $this->db->join('Operaciones.carteras car', 'car.id_cartera=bonificacion.id_cartera', "left");
        $this->db->join('agencias', 'agencias.id_agencia=substr(bonificacion.id_cartera,1,2)', "left");

        $this->db->where('bonificacion.mes',$mes_bono);
        $this->db->where('(bonificacion.estado_control != 0 or bonificacion.estado_control != 4 or bonificacion.estado_control != 5)');
        if($agencia != null){
            $this->db->where('substr(bonificacion.id_cartera,1,2) = ',$agencia);
        }
            
        $result = $this->db->get();
        return $result->result();
    }

    function get_mes_comision($mes){
        $this->db->select('*');
        $this->db->from('bonificacion'); 
        $this->db->where('estado_control = 2');
        $this->db->where('mes', $mes);

        $result = $this->db->get();
        return $result->result();
    }

    function update_comision($data,$id_bono){
        $this->db->where('id_bono',$id_bono);
        $this->db->update('bonificacion',$data);
        return true;
    }

    function delete_comisiones($mes){
      $this->db->where('mes', $code);
      $this->db->where('estado_control != 0');
      $this->db->delete('bonificacion');
      return true;
  }

    public function carteras_agencias_asesor($id_cartera=null){
        $this->db->db_select('Operaciones');
        $this->db->select('carteras.id_cartera, carteras.cartera, usuarios.nombre, usuarios.apellido');
        $this->db->from('carteras');

        $this->db->join('usuario_cartera', 'usuario_cartera.id_cartera=carteras.id_cartera','left');
        $this->db->join('usuarios', 'usuarios.id_usuarios=usuario_cartera.id_usuarios','left');

        $this->db->where("carteras.activo", 1);  

        if ($id_cartera != null){
        $this->db->where("usuario_cartera.id_cartera", $id_cartera);
        $this->db->where("usuarios.id_estado", 1);
        }

        $result = $this->db->get();
        $this->db->db_select('tablero');
        return $result->result();
    }

    function desembolsos_nuevos_asesor($desde,$hasta,$cartera){
        $this->db->db_select('Operaciones');
        $this->db->select('cliente.dui,cliente.nit,cliente.cartera,solicitud.monto,desembolso.fecha_desembolso,carteras.cartera as nom_cartera, carteras.id_agencia');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');
        $this->db->where('desembolso.estado_desembolso', 1);
        $this->db->where('solicitud.tipo_solicitud', 0);
        $this->db->where('carteras.id_cartera', $cartera);
        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
        //$this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

     function desembolsos_nuevos($desde,$hasta,$agencia){
        $this->db->db_select('Operaciones');
        $this->db->select('cliente.dui,cliente.nit,cliente.cartera,solicitud.monto,desembolso.fecha_desembolso,carteras.cartera as nom_cartera, carteras.id_agencia');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');
        $this->db->where('desembolso.estado_desembolso', 1);
        $this->db->where('solicitud.tipo_solicitud', 0);


        $this->db->where('carteras.id_agencia', $agencia);

        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
        //$this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }


    function bonos_pagos($agencia=null,$mes=null){
        $this->db->db_select('Operaciones');
        $this->db->select('bonificacion.id_agencia, agencias.agencia,bonificacion.gestion, SUM(bonificacion.bono_gestion) as bono_gestion, bonificacion.apoyo, SUM(bonificacion.bono_apoyo) as bono_apoyo, COUNT(*) as conteo');
        $this->db->from('bonificacion');

        $this->db->join('usuarios', 'usuarios.id_usuarios=bonificacion.id_usuario_ingreso');
        $this->db->join('agencias', 'agencias.id_agencia=bonificacion.id_agencia');

        if($agencia!=null){
            $this->db->where('bonificacion.id_agencia', $agencia);
        }

        $this->db->where('bonificacion.mes_aplicar', $mes);
        $this->db->where('bonificacion.estado = 2');

        $this->db->group_by('bonificacion.id_agencia,agencias.agencia,bonificacion.gestion,bonificacion.apoyo');

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function empleados_pagos($id_usuaro=null){
        $this->db->db_select('Operaciones');
        $this->db->select('usuarios.id_usuarios, concat(usuarios.nombre," ",usuarios.apellido) as nombre, roles.id_rol, roles.rol');
        $this->db->from('usuarios');  
        $this->db->join('roles', 'roles.id_rol=usuarios.id_rol', 'left');      
    
        if($id_usuaro != null){
            $this->db->where("usuarios.id_usuarios", $id_usuaro);
        }
        $this->db->order_by('nombre','ASC');

        $query=$this->db->get();
        $this->db->db_select('tablero');
        return $query->result();
    }

    function bonos_recuperacion($mes){
        $this->db->select('*');
        $this->db->from('bonificacion'); 
        $this->db->where('estado_control = 1 and estado = 2');
        $this->db->where('mes', $mes);

        $result = $this->db->get();
        return $result->result();
    }

    function bonos_no_pagados($agencia,$mes_bono){
        $this->db->select('agencias.agencia, bonos_no_pagados.empleado, roles.rol, bonos_no_pagados.bono, bonos_no_pagados.numero_control');
        $this->db->from('bonos_no_pagados'); 

        $this->db->join('agencias', 'agencias.id_agencia=bonos_no_pagados.id_agencia');
        $this->db->join('Operaciones.usuarios as usuarios', 'usuarios.id_usuarios=bonos_no_pagados.id_usuario');
        $this->db->join('Operaciones.roles as roles', 'roles.id_rol=usuarios.id_rol');


        $this->db->where('bonos_no_pagados.mes',$mes_bono);
        $this->db->where('bonos_no_pagados.estado_control=1 ');
        if($agencia != null){
            $this->db->where('bonos_no_pagados.id_agencia',$agencia);
        }
            
        $result = $this->db->get();
        return $result->result();
    }

    function update_recuperados($data,$mes_recupera){
        $this->db->db_select('Operaciones');
        $this->db->where('mes_aplicar', $mes_recupera);
        $this->db->where('estado = 2');
        $this->db->update('bonificacion',$data);
        $this->db->db_select('tablero');
        return true;
    }

       function agencias_region_codigo(){
        $this->db->db_select('tablero');
        $this->db->select('agencias.id_agencia, agencias.agencia, asignar_agencias.*');
        $this->db->from('asignar_agencias');
        $this->db->join('agencias', 'agencias.id_agencia=asignar_agencias.id_agencia');
        //$this->db->where("asignar_agencias.codigo", $codigo);
        $this->db->where("asignar_agencias.estado", 1);
        $this->db->where("agencias.id_agencia !=", 24);
        //$this->db->where("agencias.id_agencia =", '03');

        $result = $this->db->get();
        $this->db->db_select('Operaciones');
        return $result->result();
    }

    function mora_cartera($id_agencia=null, $fecha1, $fecha2){
    $this->db->db_select('Operaciones');

    $this->db->select('id_cartera,agencia, desde,hasta, cartera_act, SUM(mora) as suma_mora, efectiva, SUM(nuevos) as nuevos');
    $this->db->from('generales_produccion');

    $this->db->where("agencia", $id_agencia);
    $this->db->where('SUBSTR(`hasta`, 1,10) >=', $fecha1);
    $this->db->where('SUBSTR(`hasta`, 1,10) <=', $fecha2);

    $this->db->group_by('desde');
    $this->db->group_by('hasta');
    $this->db->group_by('cartera_act');
    $this->db->group_by('efectiva');

    $this->db->group_by('id_cartera');
    $this->db->group_by('agencia');
    

    $this->db->order_by("id_cartera", "DESC");
    $this->db->order_by("hasta", "DESC");

    //$this->db->limit(1); 

    $result = $this->db->get();
    $this->db->db_select('Operaciones');

    return $result->result();
    }

    function mora_cartera2($id_agencia=null, $fecha2){
    $this->db->db_select('Operaciones');
    $this->db->select('id_cartera, agencia, desde,hasta, cartera_act, SUM(mora) as suma_mora, efectiva, SUM(nuevos) as nuevos');
    $this->db->from('generales_produccion');

    $this->db->where("agencia", $id_agencia);
    $this->db->where('SUBSTR(`hasta`, 1,10) <=', $fecha2);

    $this->db->group_by('desde');
    $this->db->group_by('hasta');
    $this->db->group_by('cartera_act');
    $this->db->group_by('efectiva');
    $this->db->group_by('id_cartera');
    $this->db->group_by('agencia');
    

    $this->db->order_by("hasta", "DESC");
    $this->db->limit(1);

    $result = $this->db->get();
    $this->db->db_select('Operaciones');
    return $result->result();
    }



      function total_desembolsos_asesor($desde,$hasta,$cartera){
        $this->db->db_select('Operaciones');

        $this->db->select('SUM(solicitud.monto ) as monto');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');

        $this->db->where('desembolso.estado_desembolso', 1);
      
        $this->db->where('carteras.id_cartera', $cartera);
        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
        //$this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
         $this->db->db_select('Operaciones');
        return $query->result();
    }

    function total_desembolsos($desde,$hasta,$agencia){
        $this->db->db_select('Operaciones');
        $this->db->select('SUM(solicitud.monto ) as monto');
        $this->db->from('solicitud');
        $this->db->join('desembolso', 'desembolso.id_solicitud=solicitud.id_solicitud');
        $this->db->join('cliente', 'cliente.codigo=solicitud.id_cliente');
        $this->db->join('carteras', 'carteras.id_cartera=cliente.cartera');

        $this->db->where('desembolso.estado_desembolso', 1);
      
        $this->db->where('carteras.id_agencia', $agencia);
        $this->db->where('substr(desembolso.fecha_desembolso, 1,10) BETWEEN"'.$desde.'" and "'.$hasta.'"');
        //$this->db->where('carteras.activo ', 1);

        $query=$this->db->get();
        $this->db->db_select('Operaciones');
        return $query->result();
    }

    function quincena_vacacion($id_empleado,$fecha1,$fecha2){
        $this->db->select('vacaciones.*');
        $this->db->from('vacaciones'); 

        $this->db->join('contrato', 'contrato.id_contrato=vacaciones.id_contrato');

        $this->db->where('contrato.id_empleado',$id_empleado);
        $this->db->where('vacaciones.fecha_aplicacion >=',$fecha1);
        $this->db->where('vacaciones.fecha_aplicacion <=',$fecha2);
        $this->db->where('(vacaciones.estado = 1 or vacaciones.estado = 2)');
            
        $result = $this->db->get();
        return $result->result();
    }


    function regiones(){
        $this->db->select('DISTINCT(codigo), nombre');
        $this->db->from('asignar_agencias'); 

        $this->db->where('estado = 1');
        $this->db->group_by('codigo');
        $this->db->group_by('nombre');
            
        $result = $this->db->get();
        return $result->result();


    }


    function regiones_agencias($codigo){
        $this->db->db_select('tablero');
        $this->db->select('agencias.id_agencia, agencias.agencia, asignar_agencias.*');
        $this->db->from('asignar_agencias');
        $this->db->join('agencias', 'agencias.id_agencia=asignar_agencias.id_agencia');
        $this->db->where("asignar_agencias.codigo", $codigo);
        $this->db->where("asignar_agencias.estado", 1);
        $this->db->where("agencias.id_agencia != 24 and agencias.id_agencia != 00");

        $result = $this->db->get();
        $this->db->db_select('Operaciones');
        return $result->result();
    }

    public function carteras_asignadas($id_usuario)
    {
        $this->db->db_select('Operaciones');
        $this->db->select('usuario_cartera.*,carteras.*,agencias.agencia');
        $this->db->from('usuario_cartera');
        $this->db->join('carteras', 'carteras.id_cartera=usuario_cartera.id_cartera');
        $this->db->join('agencias', 'agencias.id_agencia=carteras.id_agencia');


        $this->db->where("id_usuarios", $id_usuario);

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();        
    }
      
     function fecha_cierre_rc($fechaInicio){
            $this->db->db_select('Operaciones');

            $this -> db -> select('hasta');
            $this -> db -> from('generales_produccion'); 
            $this -> db -> like('hasta', $fechaInicio,'after');

            $this ->db ->order_by('hasta','DESC');
            $this ->db ->limit(1);

            $query=$this->db->get();
                        $this->db->db_select('tablero');

            return $query->row();

             
    }
    public function asignaciones_rc(){
            $this->db->select('aa.nombre, aa.codigo, aa.id_agencia,oc.cartera,oc.id_cartera, age.agencia');
            $this->db->from('tablero.asignar_agencias aa,Operaciones.carteras oc, tablero.agencias age');
            $this->db->where('aa.estado = 1 AND aa.id_agencia != 24 and (oc.id_agencia=aa.id_agencia) and oc.activo=1 and (age.id_agencia=aa.id_agencia)');
            $this->db->order_by('aa.nombre,aa.id_agencia','ASC');


            $result = $this->db->get();


            return $result->result();
    }
     function reporte_rc($desde,$hasta,$cartera){
 
            $this->db->db_select('Operaciones');
    
  
            $this ->db-> select('avg(cartera_act) as cartera_act,avg(mora) as mora,avg(vencidos) as vencidos');
            $this ->db-> from('generales_produccion'); 
            
            $this->db->where('desde >=', $desde);
            $this->db->where('hasta <=', $hasta);
            $this->db->where('id_cartera',$cartera);
            
            
            $this->db->group_by('agencia');    


            $query=$this->db->get();
            $this->db->db_select('tablero');

            return $query->result();
       
    }
}