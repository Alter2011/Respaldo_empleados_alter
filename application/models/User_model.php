<?php
class User_model extends CI_Model{
  
  public function getUser($user=null,$password=null){
    $this -> db -> select('id_login,usuario,contrasena,id_empleado,login.id_perfil as id_perfil,nombre, usuarioP, codigo');
    $this -> db -> from('login'); 
    $this-> db->join('perfil','perfil.id_perfil=login.id_perfil');
    $this -> db -> where('usuario', $user);
    $this -> db -> limit(1);
    $result = $this -> db -> get();

    if($result->num_rows()>0){
     $usuario = $result->row();
     $pass = $usuario->contrasena; 

             //$contra= $this->encrypt->encode($pass);  //si se quiere encriptar
             $contra=  $this->encryption->decrypt($pass); //la descencriptamos 
             if (strcmp($password, $contra) == 0) {
              return $result->result();
             }else{
              return false;
             }
          }else{
            return null;
          }
        }
        public function userProducc($user=null,$password=null){
          $this->db->db_select('Produccion');

          $this -> db -> select('clave,correo');
          $this -> db -> from('usuarios'); 
          $this -> db -> where('id_usuarios', $user);
          $this -> db -> limit(1);
          $result = $this -> db -> get();

          if($result->num_rows()>0){
           $usuario = $result->row();
           $pass = $usuario->clave; 

             //$contra= $this->encrypt->encode($pass);  //si se quiere encriptar
             $password=  md5($password); //la descencriptamos 
             if (strcmp($password, $pass) == 0) {
              $this->db->db_select('tablero');

              $this -> db -> select('id_login,usuario,id_empleado,login.id_perfil as id_perfil,nombre,usuarioP, codigo');
              $this -> db -> from('login'); 
              $this-> db->join('perfil','perfil.id_perfil=login.id_perfil');
              $this -> db -> where('usuarioP', $user);
              $this -> db -> limit(1);
              $result = $this -> db -> get();

              return $result->result();
            }else{
              return false;
            }
          }else{
            return null;
          }

        }
        public function cargoUser($id_empleado){
          $this-> db->select('cargos.cargo');
          $this-> db->from('contrato');
          $this-> db->join('cargos','contrato.id_cargo=cargos.id_cargo');
          $this-> db->where('contrato.id_empleado',$id_empleado);
          $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
          
          $result = $this -> db -> get();
          if ($result->num_rows()>0) {
            return $result->result();
          }else{
            return false;
          }
        }

        public function agenciaUser($id_empleado){
          $this->db->select('contrato.id_agencia');
          $this->db->from('contrato');
          $this->db->where('contrato.id_empleado',$id_empleado);
          $this->db->where('(contrato.estado = 1 or contrato.estado = 3)');
          $query = $this->db->get();

          if ($query->num_rows() >= 1){
            return $query->result();
          } else {
            return false;
          }
        }

        public function agenciaUserLogin($id_empleado){
          $this->db->select('login.id_agencia');
          $this->db->from('login');
          $this->db->where('login.id_empleado',$id_empleado);
          $this->db->order_by('login.id_agencia', "DESC");
          $query = $this->db->get();

          if ($query->num_rows() >= 1){
            return $query->result();
          } else {
            return false;
          }
        }


        public function actualizar_contrasenia($id,$contra){
            $contra= $this->encryption->encrypt($contra);//encriptacion de contraseña

            $data = array(
             'contrasena' =>  $contra
           );

            $this->db->where('id_login', $id);
            $this->db->update('login', $data); 

            return true;
          }
        public function actualizar_contrasenia_altercredit($id,$contra){

          $this->db->db_select('Operaciones');



            $contra= $this->encryption->encrypt($contra);//encriptacion de contraseña

            $data = array(
             'clave' =>  $contra
           );

            $this->db->where('id_usuarios', $id);
            $this->db->update('usuarios', $data); 

          $this->db->db_select('tablero');
            return true;
        }

        //MODELOS DE PERMISOS Y PERFILES
          public function  permisos_usuario($perfil){
            $this->db->select('permisos.id_permiso');
            $this->db->from('detalle_perfil');
            $this->db->join('permisos', 'detalle_perfil.id_permiso = permisos.id_permiso');
            $this->db->where('detalle_perfil.id_perfil', $perfil);
            $query = $this->db->get();

            if ($query->num_rows() >= 1) {
             return $query->result();
           } else {
             return false;
           }

         }

         public function  obtener_perfil($id){
          $this->db->select('id_perfil, nombre, descripcion');
          $this->db->from('perfil');
          $this->db->where('id_perfil', $id);
          $query = $this->db->get();

          if ($query->num_rows() >= 1) {
           return $query->result();
         } else {
           return false;
         }
       }

       public function  obtener_permisos_perfil($id_perfil){
        $query = $this->db->query("SELECT permisos.id_permiso, permisos.nombre, case when permisos.id_permiso in (select detalle_perfil.id_permiso from detalle_perfil where detalle_perfil.id_perfil = ".$id_perfil.") then 'true' else 'false' end AS agregado FROM `permisos`");
        $this->db->from('permisos');

        if ($query->num_rows() >= 1) {
         return $query->result();
       } else {
         return false;
       }
     }
     public function obtener_usuario($id){
      $this->db->select('nombre,apellido,usuario,usuarioP,login.id_empleado as id_empleado,id_perfil,id_login,id_agencia,codigo');
      $this->db->from('login');
      $this->db->join('empleados','empleados.id_empleado=login.id_empleado');
      $this->db->where('id_login',$id);
      $query = $this->db->get();
      return $query->result();
    }
    public function obtener_usuarioP($id){
      $this->db->db_select('tablero');
      
      $this->db->select('login.id_empleado,nombre,apellido');
      $this->db->from('login');
      $this->db->join('empleados','empleados.id_empleado=login.id_empleado');
      $this->db->where('usuarioP',$id);
      $query = $this->db->get();
      return $query->result();
    }
    public function  obtener_permisos(){
      $this->db->select('permisos.id_permiso, permisos.nombre, "false" as agregado');
      $this->db->from('permisos');
      $query = $this->db->get();

      if ($query->num_rows() >= 1) {
       return $query->result();
     } else {
       return false;
     }
   }

   public function  insertar_perfil($nombre_perfil,$descripcion_perfil){

     $data = array(
       'nombre' => $nombre_perfil,
       'descripcion' => $descripcion_perfil 
     );

     $this->db->insert('perfil', $data);
     return $this->db->insert_id();
   }
   public function insertar_permisos($id_perfil,$id_permiso){

    $datos = array(
      'id_perfil' => $id_perfil,
      'id_permiso'=> $id_permiso
    );
    //datos es un arreglo de todos los datos
    $this->db->insert('detalle_perfil', $datos); 

  }
  public function contarpermisos(){

    return $this->db->count_all_results('permisos');

  }
  public function eliminar_permisos($id_perfil){
    $this->db->where('id_perfil', $id_perfil);
    $this->db->delete('detalle_perfil');
  }
  public function Actualizar_nomdesc_perfil($id_perfil,$nombre_perfil,$descripcion_perfil){

    $data = array(
     'nombre' => $nombre_perfil,
     'descripcion' => $descripcion_perfil);

    $this->db->where('id_perfil', $id_perfil);
    $this->db->update('perfil', $data); 

  }
  public function obtener_usuarios(){
   $this->db->select('id_login,usuario,usuarioP,empleados.nombre as nombre, empleados.apellido as apellido,perfil.nombre as perfil,login.id_empleado as id_empleado');
   $this->db->from('login');
   $this->db->join('empleados','empleados.id_empleado=login.id_empleado');
   $this->db->join('perfil','perfil.id_perfil=login.id_perfil');
     $this->db->where('activo', '1');
   
   $this->db->where('usuario !=', 'admin');

   $query = $this->db->get();
   return $query->result();
  }
    public function obtener_usuarios_operaciones(){
     $this->db->select('id_login,usuario,usuarioP,empleados.nombre as nombre, empleados.apellido as apellido,pf.nombre as perfil');
     $this->db->from('login');
     $this->db->join('empleados','empleados.id_empleado=login.id_empleado');
     $this->db->join('perfil pf','pf.id_perfil=login.id_perfil');
     $this->db->where('activo', '1');
     
     $this->db->where('usuario !=', 'admin');
     $this->db->like('pf.nombre', 'Operaciones');

     $query = $this->db->get();
     return $query->result();
  }
      public function obtener_usuarios_produccion(){
     $this->db->select('id_login,usuario,usuarioP,empleados.nombre as nombre, empleados.apellido as apellido,pf.nombre as perfil');
     $this->db->from('login');
     $this->db->join('empleados','empleados.id_empleado=login.id_empleado');
     $this->db->join('perfil pf','pf.id_perfil=login.id_perfil');

     $this->db->where('usuario !=', 'admin');
     $this->db->where('activo', '1');

     $this->db->like('pf.nombre', 'Produccion');

     $query = $this->db->get();
     return $query->result();
  }
  public function get_user($user){
      $this->db->select('id_empleado,usuario');
      $this->db->from('login');
      $this->db->where('usuario',$user);
      $query = $this->db->get();
      return $query->result();
  }
  public function obtener_perfiles(){
    $this->db->select('id_perfil,nombre');
    $this->db->from('perfil');
    $query = $this->db->get();
    return $query->result();
  }
   public function obtener_perfiles_operaciones(){
    $this->db->select('id_perfil,nombre');
    $this->db->from('perfil');
     $this->db->like('nombre', 'Operaciones');
   

    $query = $this->db->get();
    return $query->result();
  }
     public function obtener_perfiles_produccion(){
    $this->db->select('id_perfil,nombre');
    $this->db->from('perfil');
     $this->db->like('nombre', 'Produccion');
   

    $query = $this->db->get();
    return $query->result();
  }
  public function getUser_empleado($id){
      $this->db->select('usuario');
      $this->db->from('login');
      $this->db->where('login.id_empleado',$id);
      $query = $this->db->get();
      return $query->result();
    }
  public function insertar_usuario($data){
    $this->db->insert('login', $data);
    return $this->db->insert_id();
 
  }
  public function insertar_usuario_altercredit($data){
    $this->db->db_select('Operaciones');
    $this->db->insert('usuarios', $data);
    $this->db->insert_id();
    $this->db->db_select('tablero');
    return 1;
  }
  public function editar_usuario($data,$id){
      $this->db->where('id_login', $id);
      $this->db->update('login', $data); 
 
  }
  public function editar_usuario_altercredit($data,$id){
      $this->db->db_select('Operaciones');
      $this->db->where('id_usuarios', $id);
      $this->db->update('usuarios', $data); 
      $this->db->db_select('tablero');

 
  }
   public function eliminar_usuario($id){
     $this->db->where('id_login', $id);
    $this->db->delete('login');
  }

  public function buscar_asignaciones($perfil){
      $this->db->select('aa.id_perfil, pe.nombre as perfil, aa.fecha_creacion, aa.nombre, aa.codigo');
      $this->db->from('asignar_agencias aa');
      $this->db->join('perfil pe', 'pe.id_perfil=aa.id_perfil');

      $this->db->group_by('aa.id_perfil');    
      $this->db->group_by('perfil');
      $this->db->group_by('aa.fecha_creacion');
      $this->db->group_by('aa.nombre');
      $this->db->group_by('aa.codigo');

      $this->db->where('aa.id_perfil',$perfil);
      $this->db->where('(aa.estado = 1 or aa.estado = 2)');
      $this->db->where('pe.id_perfil IN (SELECT id_perfil FROM asignar_agencias)');

      $result = $this->db->get();
      return $result->result();
  }

  public function get_telefonos(){
    $this->db->select('emp.nombre_empresa, ag.agencia, ar.area, car.cargo,CONCAT(empl.nombre," ",empl.apellido) as empleado, tel.*');
    $this->db->from('telefonos_empresariales as tel');
    $this->db->join('empresa as emp','emp.id_empresa=tel.id_empresa');
    $this->db->join('agencias as ag','ag.id_agencia=tel.id_agencia');
    $this->db->join('area as ar','ar.id_area=tel.area');
    $this->db->join('Operaciones.cargos as car','car.id_cargo=tel.id_cargo');
    $this->db->join('empleados as empl','empl.id_empleado=tel.id_empleado');
    $this->db->where('tel.estado',1);

    $result = $this->db->get();
    return $result->result();
  }

}

?>