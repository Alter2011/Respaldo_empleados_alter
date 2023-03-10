<?php

class Bitacora{
    protected $ci;
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('Bitacora_model');
    }

    public function controlDesLey($user,$nombreDes,$porcentaje,$techo,$aplica,$estado,$code=null){
    	if($estado == 1){
    		$accion='Ingreso '.$nombreDes.' con porcentaje de '.$porcentaje.'%, techo de '.$techo.' y aplica a '.$aplica;

    	}else if($estado == 2){
            $por = '';
            $tec='';
            $apl ='';
            $nombre=$this->ci->Bitacora_model->nombreDes($code);
            if($nombre[0]->porcentaje != $porcentaje){
                $por = 'Porcentaje de '.($nombre[0]->porcentaje*100).'% a '.$porcentaje.'%. ';
            }
            if($nombre[0]->techo != $techo){
                $tec = 'Techo de '.$nombre[0]->techo.' a '.$techo.'. ';
            }
            if($nombre[0]->aplica != $aplica){
                $apl = 'Aplica de '.$nombre[0]->aplica.' a '.$aplica.'. ';
            }
            if($nombre[0]->porcentaje == $porcentaje && $nombre[0]->techo == $techo && $nombre[0]->aplica == $aplica){
                $texto = 'solo presiono el boton modificar';
            }else{
                $texto = $por.''.$tec.''.$apl;
            }
            $accion='Edito '.$nombreDes.', Cambios: '.$texto;
        }

    	date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);

    }//fin controlDesLey

    public function controlEliminar($code,$user,$forma){
        $accion = '';
        $estado = 3;
        //if para controlar los descuentos de ley que se eliminan
        if($forma == 1){
            $nombre = $this->ci->Bitacora_model->nombreDes($code);

            $accion = 'Elimino el descuento de ley '.$nombre[0]->nombre_descuento.' con porcentaje '.$nombre[0]->porcentaje.', aplicado a '.$nombre[0]->aplica;
        }else if($forma == 2){
            //if para controlar los tramos de renta que se eliminan
            $tramoAnt = $this->ci->Bitacora_model->buscarTrammo($code);

            $accion = 'Elimino el tramo de renta '.$tramoAnt[0]->tramo.', desde: '.number_format($tramoAnt[0]->desde,2).', hasta: '.number_format($tramoAnt[0]->hasta,2).', porcentaje: '.($tramoAnt[0]->porcentaje*100).'%, cuota: '.number_format($tramoAnt[0]->cuota,2);

        }else if($forma == 3){
            //if para el control de los tiempos de renta que se eliminen
            $tiempo = $this->ci->Bitacora_model->buscarTiempo($code);

            $accion = 'Elimino el tiempo de renta '.$tiempo[0]->nombre.', Unidad de basica: '.$tiempo[0]->unidad_basica.', Total a trabjar: '.$tiempo[0]->total_trabajo;

        }else if($forma == 4){
            //If para el control de los tipos de prestamos internos que se eliminen 
            $tipoInt = $this->ci->Bitacora_model->buscarTipoInt($code);
            $tasa=$this->ci->Bitacora_model->buscarTasa($tipoInt[0]->id_tasa);

            $accion = 'Elimino el tipo de prestamo interno '.$tipoInt[0]->nombre_prestamo.' con tasa de '.($tasa[0]->tasa*100).'%.';

        }else if($forma == 5){
            //if para el control de los faltantes que son cancelados
            $faltante = $this->ci->Bitacora_model->buscarFaltante($code);

            if($faltante[0]->tipo == 1){
                $tipo = 'Faltante';
            }else if($faltante[0]->tipo == 2){
                $tipo = 'Descuento';
            }

            $accion = 'Elimino el Faltante de tipo '.$tipo.' a '.$faltante[0]->nombre.' '.$faltante[0]->apellido.' con monto de $'.$faltante[0]->monto.' aplicado en la fecha de '.$faltante[0]->fecha_aplicada;

        }else if($forma == 6){
            //if para el control de los permisos que son cancelados 
            $tipo='';
            $permiso = $this->ci->Bitacora_model->buscarPermiso($code);
            if($permiso[0]->tipo_permiso == 1){
                $tipo='Con Goce de sueldo. ';
            }else if($permiso[0]->tipo_permiso == 2){
                $tipo='Mision Oficial. ';
            }else if($permiso[0]->tipo_permiso == 3){
                $tipo='Ausencia injustificada. ';
            }else if($permiso[0]->tipo_permiso == 5){
                $tipo='Sin Goce de sueldo. ';
            }else if($permiso[0]->tipo_permiso == 4){
                $tipo='Compensatorio. ';
            }else if($permiso[0]->tipo_permiso == 6){
                $tipo='Capacitacion. ';
            }else if($permiso[0]->tipo_permiso == 7){
                $tipo='Incapacidad. ';
            }else if($permiso[0]->tipo_permiso == 8){
                $tipo='Vacaciones. ';
            }else if($permiso[0]->tipo_permiso == 9){
                $tipo='Maternidad. ';
            }else if($permiso[0]->tipo_permiso == 10){
                $tipo='Otros. ';
            }

            $nombre = $this->ci->Bitacora_model->nombreEmpl($permiso[0]->id_contrato);

            $accion = 'Elimino un permiso: '.$tipo.'Para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' Desde: '.$permiso[0]->desde.', Hasta: '.$permiso[0]->hasta;

        }else if($forma == 7){
            $descuento = $this->ci->Bitacora_model->buscarDescuento($code);

            $nombre = $this->ci->Bitacora_model->nombreEmpl($descuento[0]->id_contrato);

            $accion = 'Elimino un descuento de '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' aplicado la fecha '.$descuento[0]->fecha.' con un descuento de $'.number_format($descuento[0]->a_descontar,2);

        }else if($forma == 8){
            $anticipo = $this->ci->Bitacora_model->buscarAnticipo($code);

            $nombre = $this->ci->Bitacora_model->nombreEmpl($anticipo[0]->id_contrato);

            $accion = 'Elimino un anticipo de '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' aplicado la fecha '.$anticipo[0]->fecha_aplicacion.' por la cantidad de $'.$anticipo[0]->monto_otorgado;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user);
        //echo $user; 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);

    }// fin controlEliminar

    public function controlRenta($user,$estado,$tramo,$desde,$hasta,$porcentaje,$sobre,$cuota,$tiempo,$code=null){
        if($estado == 1){
            $accion = 'Ingreso de tramo '.$tramo.' desde '.$desde.', hasta '.$hasta.', porcentaje '.($porcentaje*100).'%, sobre '.$sobre.', cuota '.$cuota.', tiempo '.$tiempo;

        }else if($estado == 2){

            $tra = '';$des = '';$has = '';$por ='';
            $sob = '';$cou = '';
            $tramoAnt = $this->ci->Bitacora_model->buscarTrammo($code);
            if($tramoAnt[0]->tramo != $tramo){
                $tra = 'Tramo de '.$tramoAnt[0]->tramo.' a '.$tramo.'. ';
            }else{
                $tra = 'Tramo '.$tramo.'. ';
            }
            if($tramoAnt[0]->desde != $desde){
                $des = 'Desde de '.$tramoAnt[0]->desde.' a '.$desde.'. ';
            }
            if($tramoAnt[0]->hasta != $hasta){
                $has = 'Hasta de '.$tramoAnt[0]->hasta.' a '.$hasta.'. ';
            }
            if($tramoAnt[0]->porcentaje != $porcentaje){
                $por = 'Porcentaje de '.($tramoAnt[0]->porcentaje*100).'% a '.($porcentaje*100).'%. ';
            }
            if($tramoAnt[0]->sobre != $sobre){
                $sob = 'Sobre de '.$tramoAnt[0]->sobre.' a '.$sobre.'. ';
            }
            if($tramoAnt[0]->cuota != $cuota){
                $cou = 'Couta de '.$tramoAnt[0]->cuota.' a '.$cuota.'. ';
            }
            if($tramoAnt[0]->id_tiempo != $tiempo){
                $pag = 'Tiempo de '.$tramoAnt[0]->id_tiempo.' a '.$tiempo.'.';
            }

            if($tramoAnt[0]->tramo == $tramo && $tramoAnt[0]->desde == $desde && $tramoAnt[0]->hasta == $hasta && $tramoAnt[0]->porcentaje == $porcentaje && $tramoAnt[0]->sobre == $sobre && $tramoAnt[0]->cuota == $cuota && $tramoAnt[0]->id_tiempo == $tiempo){
                $texto = $tra.' Cambio: Solo presiono el boton modificar';
            }else{
                $texto = $tra.''.$des.''.$has.''.$por.''.$sob.''.$cou;
            }
            $accion='Edito '.$texto;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }//fin controlRenta

    public function controlTiempoRenta($user,$estado,$nombreTiempo,$unidad,$total,$code=null){
        if($estado == 1){
            $accion = 'Ingreso el tiempo de renta: '.$nombreTiempo.' con unidad de '.$unidad.' y total a trabajar de '.$total;

        }else if($estado == 2){
            $nom = '';$uni = '';$tot = '';
            $tiempo = $this->ci->Bitacora_model->buscarTiempo($code);
            if($tiempo[0]->nombre != $nombreTiempo){
                $nom = 'Nombre de tiempo de '.$tiempo[0]->nombre.' a '.$nombreTiempo.'. ';
            }else{
                $nom = 'Nombre de tiempo '.$nombreTiempo.'. ';
            }
            if($tiempo[0]->unidad_basica != $unidad){
                $uni = 'Unidad basica de '.$tiempo[0]->unidad_basica.' a '.$unidad.'. ';
            }
            if($tiempo[0]->total_trabajo != $total){
                $tot = 'Total a tabrajar de '.$tiempo[0]->total_trabajo.' a '.$total.'. ';
            }

            if($tiempo[0]->nombre == $nombreTiempo && $tiempo[0]->unidad_basica == $unidad && $tiempo[0]->total_trabajo == $total){
                $texto = $nom.' Solo presiono el boton modificar';

            }else{
                $texto = $nom .''.$uni .''.$tot;
            }
            $accion = 'Edito '.$texto;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }//fin controlTiempoRenta

    public function controlTipoInt($user,$estado,$nombre_prestamo,$tasa,$code=null){
        $nomTasa=$this->ci->Bitacora_model->buscarTasa($tasa);
        if($estado == 1){
            $accion = 'Ingreso el tipo de prestamo interno '.$nombre_prestamo.' con tasa de'.($nomTasa[0]->tasa*100).'%';
        }else if($estado == 2){
            $nomT = '';$tas = '';
            $tipoInt = $this->ci->Bitacora_model->buscarTipoInt($code);
            if($tipoInt[0]->nombre_prestamo != $nombre_prestamo){
                $nomT = 'Nombre de tipo de prestamo Interno de '.$tipoInt[0]->nombre_prestamo.' a '.$nombre_prestamo.'. ';
            }else{
                $nomT = 'Nombre de tipo de prestamo Interno '.$tipoInt[0]->nombre_prestamo.'. ';
            }
            if($tipoInt[0]->id_tasa != $tasa){
                $tasaAn=$this->ci->Bitacora_model->buscarTasa($tipoInt[0]->id_tasa);
                $tas = 'Tasa de '.($tasaAn[0]->tasa*100).'% a '.($nomTasa[0]->tasa*100).'%. ';
            }

            if($tipoInt[0]->nombre_prestamo == $nombre_prestamo && $tipoInt[0]->id_tasa == $tasa){
                $texto = $nomT.' Solo presiono el boton modificar';
            }else{
                $texto = $nomT.''.$tas;
            }
            $accion = 'Edito '.$texto;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }//fin controlTipoInt

    public function controlPresInt($user,$estado,$empleado,$cantidad,$tasa,$periodo,$cuota){
        if($estado == 1){
            $empleado = $this->ci->Bitacora_model->nombreEmp($empleado);
            $accion = 'Ingreso con aprobacion de prestamo interno de '.$empleado[0]->nombre.' '.$empleado[0]->apellido.' por la cantidad de $'.$cantidad.', tasa de '.($tasa*100).'%, periodo de '.$periodo.' quincenas y cuota de $'.$cuota;
        }else if($estado == 2){
            $estado = 1;
            $empleado = $this->ci->Bitacora_model->nombreEmp($empleado);
            $accion = 'Ingreso de solicitud de prestamo interno para '.$empleado[0]->nombre.' '.$empleado[0]->apellido.' por la cantidad de $'.$cantidad.', tasa de '.($tasa*100).'%, periodo de '.$periodo.' quincenas y cuota de $'.$cuota;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }

    public function controlIntAcc($user,$code,$estado,$cantidad=null,$tipo=null,$tasa=null,$periodo=null,$cuota=null){
        if($estado == 1){
            $estado = 4;
            $prestamoInt = $this->ci->Bitacora_model->prestamosInterno($code);

            $accion = 'Aprobacion del prestamo interno de '.$prestamoInt[0]->nombre.' '.$prestamoInt[0]->apellido.' por la cantidad de $'.$prestamoInt[0]->monto.', tasa de '.($prestamoInt[0]->tasa*100).'% y cuota de $'.$prestamoInt[0]->cuota;
        }else if($estado == 2){
            $estado = 5;
            $prestamoInt = $this->ci->Bitacora_model->prestamosInterno($code);

            $accion = 'Rechazo del prestamo interno de '.$prestamoInt[0]->nombre.' '.$prestamoInt[0]->apellido.' por la cantidad de $'.$prestamoInt[0]->monto.', tasa de '.($prestamoInt[0]->tasa*100).'% y cuota de $'.$prestamoInt[0]->cuota;
        }else if($estado == 3){
            $cant = '';$tas = '';$per = '';
            $prestamoInt = $this->ci->Bitacora_model->prestamosInterno($code);

            if($prestamoInt[0]->monto != $cantidad){
                $cant = 'Cantidad de '.$prestamoInt[0]->monto.' a '.$cantidad.'. ';
            }
            if($prestamoInt[0]->id_tipo_prestamo != $tipo){
                $tasa1 = $this->ci->Bitacora_model->buscarTasas($prestamoInt[0]->id_tipo_prestamo);

                $tas = 'Tasa de '.($tasa1[0]->tasa*100).'% a '.($tasa*100).'%. ';
            }
            if($prestamoInt[0]->plazo_quincena != $periodo){
                $per = 'Periodo de '.$prestamoInt[0]->plazo_quincena.' a '.$periodo.' en quincenas. ';
            }

            if($prestamoInt[0]->monto == $cantidad && $prestamoInt[0]->id_tipo_prestamo == $tipo && $prestamoInt[0]->plazo_quincena == $periodo){
                $texto = 'Prestamo Interno de '.$prestamoInt[0]->nombre.' '.$prestamoInt[0]->apellido.', cantidad otorgada de '.$cantidad.', cuota de '.$cuota.', Solo presiono el boton modificar.';
            }else{
                $texto = 'Prestamo Interno de '.$prestamoInt[0]->nombre.' '.$prestamoInt[0]->apellido.', '.$cant.''.$tas.''.$per.'cuota de '.$cuota;
            }
            $accion = 'Edito '.$texto;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }

    public function controlFaltante($empleado,$user,$tipo,$cantidad,$fecha){
        $nombre = $this->ci->Bitacora_model->nombreEmpl($empleado);
        $estado = 1;
        if($tipo == 1){
            $faltante = 'Faltante';
        }else if($tipo == 2){
            $faltante = 'Descuento';
        }

        $accion = 'Ingreso de Faltante de tipo: '.$faltante.' a '.$nombre[0]->nombre.''.$nombre[0]->apellido.' con monto de $'.$cantidad.' aplicado en la fecha: '.$fecha;

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }

    public function controlPermisos($user,$empleado,$estado,$tipo,$desde,$hasta,$descuento=null){
        if($estado == 1){
            $forma='';
            if($tipo == 1){
                $forma='Con Goce de sueldo. ';
            }else if($tipo == 2){
                $forma='Mision Oficial. ';
            }else if($tipo == 3){
                $forma='Ausencia injustificada. ';
            }else if($tipo == 4){
                $forma='Compensatorio. ';
            }else if($tipo == 6){
                $forma='Capacitacion. ';
            }else if($tipo == 7){
                $forma='Incapacidad. ';
            }else if($tipo == 8){
                $forma='Vacaciones. ';
            }else if($tipo == 9){
                $forma='Maternidad. ';
            }else if($tipo == 10){
                $forma='Otros. ';
            }
            $nombre = $this->ci->Bitacora_model->buscarNomEmp($empleado);
            $accion = 'Ingreso un permiso: '.$forma.'Para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' Desde: '.$desde.', Hasta: '.$hasta;
        }else if($estado == 2){
            $forma='';
            if($tipo == 5){
                $forma = 'Sin Goce de sueldo. ';
            }else{
                $forma = 'Otros. ';
            }

            $nombre = $this->ci->Bitacora_model->buscarNomEmp($empleado);
            $accion = 'Ingreso un permiso: '.$forma.'Para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' Desde: '.$desde.', Hasta: '.$hasta.', Descuento: $'.number_format($descuento,2);
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }

    public function controlDesHoras($user,$empleado,$estado,$horas,$min,$cantidad,$fecha){
        $nombre = $this->ci->Bitacora_model->nombreEmpl($empleado);

        if($estado == 1){
            $accion = 'Ingreso un descuento de septimon para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.', horas: '.$horas.', $minutos '.$min.', cantidad a descontar '.number_format($cantidad,2).', fecha de aplicacion '.$fecha;
        }else if($estado == 2){
            $accion = 'Ingreso un descuento de horas para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.', horas: '.$horas.', $minutos '.$min.', cantidad a descontar '.number_format($cantidad,2).', fecha de aplicacion '.$fecha;
        }

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }

    public function controlAnticipo($user,$empleado,$cantidad,$tipo,$fecha){
        $estado = 1;
        $nombre = $this->ci->Bitacora_model->nombreEmpl($empleado);

        $tipoAnt = $this->ci->Bitacora_model->buscarTipoAnt($tipo);

        $accion = 'Ingreso un anticipo para '.$nombre[0]->nombre.' '.$nombre[0]->apellido.' de tipo '.$tipoAnt[0]->nombre_tipo.', cantidad de $'.$cantidad.', fecha de aplicacion '.$fecha;

        date_default_timezone_set('America/El_Salvador');
        $hora = date('h:i:s', time());
        $fecha = date('Y-m-d');

        $contrato = $this->ci->Bitacora_model->controlContrato($user); 
        $this->ci->Bitacora_model->controlSistema($contrato[0]->id_contrato,$fecha,$hora,$accion,$estado);
    }
  
}