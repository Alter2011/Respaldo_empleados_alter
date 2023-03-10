<?php
class Renta_model extends CI_Model{

	 public function getRentas(){
      //se traen los todos los datos que esten activos ya preparados para utilizar en vista
	 	$this->db->select('re.id_renta,re.tramo, format(re.desde,2) as desde, format(re.hasta,2) as hasta, format(re.porcentaje*100,2) as porcentaje, format(re.sobre,2) as sobre, format(re.cuota,2) as cuota, tr.nombre');
        $this->db->from('renta re'); 
        $this->db->join('tiempo_renta tr', 're.id_tiempo = tr.id_tiempo');
        $this->db->where('re.estado',1);

        $result = $this->db->get();
        return $result->result();
	 }

     function tiempoLista(){
        $this->db->select('id_tiempo, nombre');
        $this->db->from('tiempo_renta'); 
        $this->db->where('estado',1);
        $result = $this->db->get();
        return $result->result();
    }

    function validarExistRenta($tramo){
        $this->db->select('count(*)as conteo');
        $this->db->from('renta');
        $this->db->where('tramo',$tramo);
        $this->db->where('estado',1);

        $result = $this->db->get();
        return $result->result();
    }

	 public function saveRentas($data){
	 	$result=$this->db->insert('renta',$data);
        return $result;
	 }

     public function getRenta($code){
        $this->db->select('re.id_renta,re.tramo,format(re.desde,2) as desde,format(re.hasta,2) as hasta,format(re.porcentaje*100,2) as porcentaje ,format(re.sobre,2) as sobre,format(re.cuota,2) as cuota,tr.id_tiempo');
        $this->db->from('renta re'); 
        $this->db->join('tiempo_renta tr', 're.id_tiempo = tr.id_tiempo');
        $this->db->where('re.estado',1);
        $this->db->where('re.id_renta',$code);

        $result = $this->db->get();
        return $result->result();

     }

     public function updateRenta($code,$tramo,$desde,$hasta,$porcentaje,$sobre,$cuota,$pagadas){
        $data = array(
            'tramo'         => $tramo, 
            'desde'         => $desde, 
            'hasta'         => $hasta, 
            'porcentaje'    => $porcentaje, 
            'sobre'         => $sobre, 
            'cuota'         => $cuota,
            'id_tiempo'     => $pagadas,
        );

        $this->db->where('id_renta', $code);
        $this->db->update('renta', $data);
        return true;
     }

     public function deleteRenta($code){
        $data = array(
             'estado'        => 0
        );

        $this->db->where('id_renta', $code);
        $this->db->update('renta', $data);
        return true;
     }
}