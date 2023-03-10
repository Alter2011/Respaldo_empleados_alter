<?php
class Presupuesto_model extends CI_Model{

    function savePresupuesto(){
        
        $data = array(

            'presupuestado'          => $this->input->post('presu_valor'), 
            'cartera'                => $this->input->post('cartera'), 
            'indice_eficiencia'      => $this->input->post('presu_indice'),  
            'usuario'                => "NP01", 
            'fecha'                  => $this->input->post('presu_fecha'), 
            //'foto'              => $this->input->post('empleado_nombre'), 
            );
        
        $this->db->db_select('Produccion');
        $result=$this->db->insert('presupuestado',$data);
        
        return $result;
    }

    function obtener_agencias(){
            $this ->db->select('id_agencia, agencia');
            $this->db->from('agencias');
       
            $this->db->where('id_agencia != "00" and id_agencia != "24"' );
            
            $query = $this->db->get();
            return $query->result();
        }
    function obtener_agencias2(){
            $this ->db->select('id_agencia, agencia');
            $this->db->from('agencias');
       
            $this->db->where('id_agencia = "01"' );
            
            $query = $this->db->get();
            return $query->result();
        }

        function obtener_inactivos($id_agencia, $opcion){
            $this->db->db_select('Operaciones');
            $this ->db->select('COUNT(id_inactivos) as cantidad_inactivos');
            $this->db->from('clientes_inactivos');

            $this->db->where("SUBSTR(`id_credito`, 3,2)=", $id_agencia);
            $this->db->where("clientes_inactivos.seleccion", $opcion);

        
            //$this->db->like("SUBSTR(`id_credito`, 3,2)", $id_agencia, 'after');
            
            $result = $this->db->get();
            $this->db->db_select('tablero');

            return $result->result();
        }


    public function get_indicadores($id_agencia){
          $this->db->db_select('Operaciones');
          $this->db->select('SUM(inactivos_n) as inactivos_n, SUM(inactivos_negados) as inactivos_negados, SUM(mora_8) as mora_8, SUM(mora_15) as mora_15, SUM(colocacion_nuevos) as colocacion_nuevos, SUM(reproceso) as reproceso, SUM(reconsideraciones) as reconsideraciones, SUM(acuerdos) as acuerdos, SUM(vencidos_actual) as vencidos_actual, SUM(vencidos_nuevos) as vencidos_nuevos, agencias.agencia');
          $this->db->from('presupuesto_operac');

          $this->db->join('agencias', 'agencias.id_agencia = presupuesto_operac.id_agencia');

          $this->db->where("presupuesto_operac.id_agencia", $id_agencia);

           
          $result = $this->db->get();
          $this->db->db_select('tablero');

            return $result->result();
            
        }

     function rendicion_global($mes=null,$agencia=null,$region=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('SUM(cartera_act) as cartera_act_real,SUM(cartera_activa) as cartera_activa,SUM(cartera_activa-cartera_act) as rendicion_cartera_activa ,SUM(efectiva)  as efectiva,SUM(cartera_activa*(indice_eficiencia/100)) as presu_car_efectiva,SUM(cartera_activa*(indice_eficiencia/100))-SUM(efectiva) as rendicion_efectiva,hasta,(SUM(efectiva)/SUM(cartera_act))*100 as indice_efectiva,100-(((AVG(mora)/AVG(cartera_act))*100)) as indice_eficiencia,AVG(indice_eficiencia) as indice_eficiencia_presupuestado');
        $this->db->from('generales_produccion,tablero.asignar_agencias aa');
          $this->db->join('presupuestado', 'generales_produccion.id_cartera = presupuestado.cartera','left');

        if ($mes!=null ) {
            $this->db->like('hasta',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable
            $this->db->like('presupuestado.fecha',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable

            $this->db->order_by('hasta','DESC');
        
        }
                $this->db->where('aa.id_agencia=generales_produccion.agencia');

        if ($agencia!=null) {

            $this->db->like('id_cartera',$agencia,'after');
            //$this->db->group_by('agencia,hasta');

        }
        if ($region!=null) {

            $this->db->where('aa.codigo',$region);
        }
            $this->db->group_by('hasta');
       // if ($cartera!=null) {
      //  }

        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }   

     function primera_rendicion_global($mes=null,$agencia=null,$region=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('hasta');
        $this->db->from('generales_produccion,tablero.asignar_agencias aa');
          $this->db->join('presupuestado', 'generales_produccion.id_cartera = presupuestado.cartera','left');

        if ($mes!=null ) {
            $this->db->like('hasta',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable
            $this->db->like('presupuestado.fecha',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable

            $this->db->order_by('hasta','ASC');
        
        }
        if ($agencia!=null) {
            $this->db->like('id_cartera',$agencia,'after');
            $this->db->group_by('agencia,hasta');

        }
        if ($region!=null) {

            $this->db->where('aa.codigo',$region);
            $this->db->group_by('hasta');
        }
        $this->db->limit(1);
        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }
     function ultima_rendicion_global($mes=null,$agencia=null,$region=null){
        //efectiva/activa
        //Monto Actual/monto presupuestado cartera recuperacion
        //(cartera activa+monto actual)/(ambos presupuestos)
        $this->db->db_select('Operaciones');
        $this->db->select('hasta');
        $this->db->from('generales_produccion,tablero.asignar_agencias aa');

        if ($mes!=null ) {
            $this->db->like('hasta',$mes,'after'); //hace un $id%, pone el simbolo luego de la variable

            $this->db->order_by('hasta','DESC');
        
        }
        if ($agencia!=null) {
            $this->db->like('id_cartera',$agencia,'after');

        }
        if ($region!=null) {

            $this->db->where('aa.codigo',$region);
        }
            //$this->db->group_by('hasta');
        $this->db->limit(1);
        $query=$this->db->get();
        $this->db->db_select('tablero');

        return $query->result();
    }    
}