<?php
class Reportes_model extends CI_Model{

    function ColocacionNueva($PptoMin, $PptoMax, $coloMin, $coloMax, $fechaMin, $fechaMax, $rol){
        
        switch ($rol) {
            case 'Detalle':
                $this->db->db_select('Produccion');
                $this->db->select('colocado.id_colocado as codigoFox, colocado.prospecto as codigoProspecto, concat(usuarios.nombre," ",usuarios.apellido) as asesor, colocado.monto_colocado as MontoColocado, agencias.agencia, carteras.cartera, colocado.fecha');
                $this->db->from('colocado');
                $this->db->join('prospectos', 'colocado.prospecto = prospectos.id_prospectos');
                $this->db->join('carteras', 'prospectos.cartera = carteras.id_cartera');
                $this->db->join('agencias', 'carteras.id_agencia = agencias.id_agencia');
                $this->db->join('usuarios', 'prospectos.usuario = usuarios.id_usuarios');
                if (isset($PptoMin)) {
                    # code...
                }
                if (isset($PptoMax)) {
                    # code...
                }
                if($coloMin==0 and $coloMax==0){
                    $this->db->where('colocado.monto_colocado>=',0);
                }
                if (isset($coloMin )and $coloMin!=0) {
                    $this->db->where('colocado.monto_colocado>=',$coloMin);
                }
                if (isset($coloMax) and $coloMax!=0) {
                    
                    $this->db->where('colocado.monto_colocado<=',$coloMax);
                }
                if (isset($fechaMin)) {
                    
                    $this->db->where('colocado.fecha>=',$fechaMin);
                }
                if (isset($fechaMax) and $fechaMax!='') {
                    $this->db->where('colocado.fecha<=',$fechaMax);
                }
                $this->db->order_by('agencias.id_agencia','asc');
                $this->db->order_by('colocado.fecha','asc');
                $this->db->order_by('carteras.id_cartera','asc');
                break;
            case 'General':
                $this->db->db_select('Produccion');
                $this->db->select('CONCAT(usuarios.nombre," ",usuarios.apellido) AS asesor, sum(colocado.monto_colocado) AS MontoColocado,agencias.agencia,carteras.cartera, agencias.id_agencia');                
                $this->db->from('colocado');
                $this->db->join('prospectos', 'colocado.prospecto = prospectos.id_prospectos');
                $this->db->join('carteras', 'prospectos.cartera = carteras.id_cartera');
                $this->db->join('agencias', 'carteras.id_agencia = agencias.id_agencia');
                $this->db->join('usuarios', 'prospectos.usuario = usuarios.id_usuarios');
                if (isset($PptoMin)) {
                    # code...
                }
                if (isset($PptoMax)) {
                    # code...
                }
                if($coloMin==0 and $coloMax==0){
                    $this->db->where('colocado.monto_colocado>=',0);
                }
                if (isset($coloMin )and $coloMin!=0) {
                    $this->db->where('colocado.monto_colocado>=',$coloMin);
                }
                if (isset($coloMax) and $coloMax!=0) {
                    
                    $this->db->where('colocado.monto_colocado<=',$coloMax);
                }
                if (isset($fechaMin)) {
                    
                    $this->db->where('colocado.fecha>=',$fechaMin);
                }
                if (isset($fechaMax) and $fechaMax!='') {
                    $this->db->where('colocado.fecha<=',$fechaMax);
                }
                $this->db->group_by('usuarios.nombre');
                $this->db->group_by('usuarios.apellido');
                $this->db->group_by('agencias.agencia');
                $this->db->group_by('carteras.cartera');
                $this->db->group_by('agencias.id_agencia');
                $this->db->order_by('agencias.id_agencia',"asc");
                $this->db->order_by('agencias.agencia',"asc");
                $this->db->order_by('carteras.cartera',"asc");
                break;
            
            default:
                # code...
                break;
        }  
        
        $query=$this->db->get();
        
        return $query->result();
    }
    function NoColoco($fecha,$fecha2,$rol){
        $this->db->db_select('Produccion');
        switch ($rol) {
            case 'Gerencial':
            $query = $this->db->query('select concat(usuarios.nombre, " ",usuarios.apellido) as Nombre, carteras.cartera, agencias.agencia from usuarios join permisos on permisos.id_usuarios=usuarios.id_usuarios join carteras on carteras.id_cartera=permisos.id_cartera join agencias on agencias.id_agencia=carteras.id_agencia WHERE usuarios.id_rol=4 and usuarios.activo=1 and usuarios.id_usuarios not in (SELECT permisos.id_usuarios FROM colocado JOIN permisos ON SUBSTR(colocado.prospecto, 1, 5) = permisos.id_cartera WHERE colocado.fecha >="'.$fecha.'" and colocado.fecha<="'.$fecha2.'") order by agencias.id_agencia ');
                break;
            
            default:
                # code...
                break;
        }
                

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return "Todos ingresaron";
        }
    }
    
}