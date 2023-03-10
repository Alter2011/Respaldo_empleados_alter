<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style type="text/css">
  #logo_empre{
      width: 220px;
      height: 80px;
  }
  .bonde{
    border-top-style:solid;
    border-top: 1.5px solid black; 
    width: 15%; 
  }
  .hr_liquidacion{
    border: 0 ; 
    border-top: 4px double #337AB7; 
    width: 90%;
  }

  .texto_recibo_liq{
    margin-left: 20%; 
      margin-right:20%;
  }

  .hr1_liq{
      height: 5px;
    background-color: #872222;
  }
  .hr2_liq{
      height: 2px;
    background-color: #872222;
    margin-top: -4%;
  }
  .pie_pag_liq{
      margin-top: -2%;
      font-size: 12px;
  }

  #invicible2{
    display: none;
    page-break-before: always
  }

  @media print{
      #logo_empre{
        width: 200px;
        height: 50px;
        margin-top: 8%; 
      }
      #invicible{
        display: none;
      }
      .negrita{
        font-weight: bold;
        font-size: 12px;
      }

      .texto_recibo_liq{
    margin-left: 12%; 
      margin-right:12%;
  }

    .hr1_liq{
        display: block;
        border-color: #872222;
        border-width:5px;
        margin-top: 40%;
    }
    .hr2_liq{
        display: block;
        border-color: #872222;
        margin-top: -3%;
        border-width:2px;
    }
    .pie_pag_liq{
        margin-top: -2%;
        font-size: 13px;
    }
    .hr_liquidacion{
      display: none;
    }
    .texto_deuda{
      font-size: 12px;
    }
  }
    
</style>
<?php setlocale(LC_TIME, 'es_ES.UTF-8'); 
 function meses($meses){
    switch($meses){
        case 1: $meses="Enero"; break;
        case 2: $meses="Febrero"; break;
        case 3: $meses="Marzo"; break;
        case 4: $meses="Abril"; break;
        case 5: $meses="Mayo"; break;
        case 6: $meses="Junio"; break;
        case 7: $meses="Julio"; break;
        case 8: $meses="Agosto"; break;
        case 9: $meses="Septiembre"; break;
        case 10: $meses="Octubre"; break;
        case 11: $meses="Noviembre"; break;
        case 12: $meses="Diciembre"; break;
    }

    return $meses;
}  
?>
<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Liquidacion Para Empleados</h2>
            </div>

              <?php if(!empty($liquidacion[1]) && $perdon == 1){ ?>
                <ul class="nav nav-tabs ocultar">
                  <li class="active"><a data-toggle="tab" href="#home" id="pag1">Liquidacion sin perdon de dias</a></li>
                  <li><a data-toggle="tab" href="#menu1" id="pag2">Liquidacion con perdon de dias</a></li>
                </ul><br>
              <?php } ?>

              <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                <?php if($liquidacion[0]->dias_cesantia > 0 && $liquidacion[0]->dias_perdonados == 0){ ?>
                  <div class="alert alert-success ocultar">
                    <span class="glyphicon glyphicon-warning-sign"></span> <b>Esta liquidacion tiene <?= $liquidacion[0]->dias_cesantia ?> dias de cesantia</b>
                  </div>

                <?php }else if($liquidacion[0]->dias_perdonados > 0){ ?>
                  <div class="alert alert-success ocultar col-sm-6">
                    <span class="glyphicon glyphicon-warning-sign"></span> <b>Esta liquidacion tiene <?= $liquidacion[0]->dias_cesantia ?> dias de cesantia</b>
                  </div>
                  <div class="alert alert-info ocultar col-sm-6">
                    <span class="glyphicon glyphicon-thumbs-up"></span> <b>Se le han perdonado <?= $liquidacion[0]->dias_perdonados ?> dias de cesantia</b>
                  </div>
                <?php } ?>

              <?php if($liquidacion[0]->tipo_des_ren == 5 && $liquidacion[0]->estado == 0){ ?>
                <a class="btn btn-default item_agregar ocultar" data-toggle="modal" data-target="#Modal_Add" id="btn_permiso" data-id_liquidacion="<?= $liquidacion[0]->id_liquidacion;?>"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
              <?php }
                if($liquidacion[0]->estado == 1){
               ?>
                <a class="btn btn-success crear ocultar" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
            <?php }else if($liquidacion[0]->estado == 0){?>
              <?php if($aprobar == 1){ ?>
              <a class="btn btn-primary" data-toggle="modal" data-target="#Modal_Aprobar" id="btn_permiso"><span class="glyphicon glyphicon-ok"></span> Aprobar</a>
              <?php }
                if($rechazar == 1){
               ?>
                <?php if(!empty($liquidacion[1])){ ?>
                  <a class="btn btn-danger ocultar" data-toggle="modal" data-target="#Modal_Rechazar3" id="btn_permiso"><span class="glyphicon glyphicon-remove"></span> Rechazar</a>
                <?php }else{ ?>
                  <a class="btn btn-danger ocultar" data-toggle="modal" data-target="#Modal_Rechazar" id="btn_permiso"><span class="glyphicon glyphicon-remove"></span> Rechazar</a>
                <?php } ?>

              <?php } ?>

            <?php }
              $i = 1; 
              if($liquidacion[0]->dias_cesantia > 0 && $liquidacion[0]->estado == 0 && $perdon == 1){ ?>
                <a class="btn btn-info ocultar" data-toggle="modal" data-target="#Modal_dias" id="btn_permiso"><span class="glyphicon glyphicon-thumbs-up"></span> Perdon de dias de cesantia</a>
            <?php } ?>
                        
                <div class="col-sm-12">

                  <?php if($liquidacion[0]->id_empresa == 1){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?></b></h3>
                    </div>
                    
                  <?php }else if($liquidacion[0]->id_empresa == 2){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?></b></h3>
                    </div>

                  <?php }else if($liquidacion[0]->id_empresa == 3){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?></b></h3>
                    </div>

                  <?php } ?>
    
                  <?php if($liquidacion[0]->tipo_des_ren == 1){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?> tal como lo expresa el Código de Trabajo de El Salvador en su art. 50 numeral  3: Por la perdida de confianza del patrono en el trabajador, cuando este desempeña un cargo de direccion, vigilancia, fiscalizacion u otro de igual importancia y responsabilidad. El Juez respectivo apreciara prudencialmente los hechos que el patrono estableciere para justificar la perdida de confianza. Las cantidades se le detallan a continuacion:</p>
                    </div><br>

                  <?php }else if($liquidacion[0]->tipo_des_ren == 2){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?> tal como lo expresa el Código de Trabajo de El Salvador Art. 197 y 198 numeral 1º y Art.58 párrafos 1 y 2; y Reglamento Interno de Trabajo que se aplica en <?php echo $liquidacion[0]->nombre_empresa ?> en las cantidades que a continuación se detallan:</p>
                    </div><br>

                  <?php }else if($liquidacion[0]->tipo_des_ren == 3){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[0]->fecha_fin, 0,4); ?> Terminando el contrato <b>sin responsabilidad para el patrono</b> tal como lo expresa el Código de Trabajo de El Salvador en su art. 28: En los contratos individuales de trabajo podra estipularse que los primeros treinta dias seran de prueba. Dentro de este termino, cualquiera de las partes podra dar por terminado el contrato sin expresion de causa.</p>
                    </div><br>

                  <?php }else if($liquidacion[0]->tipo_des_ren == 4 || ($liquidacion[0]->tipo_des_ren == 5 && $liquidacion[0]->dias_laborado >= 200)){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> se le notifica que hemos aceptado su renuncia a la plaza de:<b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?> por lo tanto se presentan los cálculos de los dias laborados a continuacion:</p>
                    </div><br>

                  <?php }else if($liquidacion[0]->tipo_des_ren == 5 && $liquidacion[0]->dias_laborado < 200){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> se le notifica que hemos aceptado su renuncia a la plaza de:<b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?>, que hizo de manera escrita a su jefe(a) inmediato(a) por lo tanto se presentan los cálculos de los dias laborados tal como lo expresa el Codigo de Trabajo de El Salvador en su art. 180, <b>Mínimo de días Laborados para derecho a vacaciones</b>: Todo trabajador, para tener derecho a vacaciones, debera acreditar un mínimo de doscientos dias trabajados en el año, aunque en el contrato respectivo no se le exija trabajar todos los dias de la semana, ni se le exija trabajar en cada dia el maximo de horas ordinarias.</p>
                    </div><br>
                  <?php } ?>
                      
                  <div class="contenedor">

                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;">DATOS GENRALES</b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>SALARIO BASE QUINCENAL</b></div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[0]->sueldo_quincena,2) ?> </span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>FECHA DE INICIO:</b></div>
                      <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[0]->fecha_inicio),'d/m/Y') ?></span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>FECHA DE RETIRO:</b></div>
                      <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[0]->fecha_fin),'d/m/Y') ?> </span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>DIAS LABORADOS:</b></div>
                      <div class="col-sm-2"><span><?php echo $liquidacion[0]->dias_laborado; ?> DIAS</span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <?php if($liquidacion[0]->fecha_vacacion != null && $liquidacion[0]->fecha_inicio != $liquidacion[0]->fecha_vacacion){ ?>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b>FECHA DE ULTIMA VACACION:</b></div>
                        <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[0]->fecha_vacacion),'d/m/Y') ?> </span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                    <?php } ?>
                    <br><br>

                    <?php 
                      //DIFERENCIA DE DIAS ENTRE LAS FECHAS 
                      $difInd = date_diff(date_create(substr($liquidacion[0]->fecha_fin, 0,4).'-01-01'),date_create($liquidacion[0]->fecha_fin));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasInd = ($difInd->format('%a') + 1);

                      $difAg = date_diff(date_create($liquidacion[0]->fecha_aguinaldo),date_create($liquidacion[0]->fecha_fin));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasAg = ($difAg->format('%a') + 1);

                      $difLab = date_diff(date_create($liquidacion[0]->fecha_quin1),date_create($liquidacion[0]->fecha_quin2));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasLab = ($difLab->format('%a') + 1);

                      if($diasLab > 15){
                        $diasLab = 15;
                      }

                     ?>

                    <?php if(($liquidacion[0]->tipo_des_ren == 2 || $liquidacion[0]->tipo_des_ren == 5) && $liquidacion[0]->indemnizacion > 0){ ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)INDEMNIZACION PROPORCIONAL</b></div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[0]->indemnizacion,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">
                        <b>del <?php echo '01/01/'.substr($liquidacion[0]->fecha_fin, 0,4); ?> al <?php echo date_format(date_create($liquidacion[0]->fecha_fin),'d/m/Y') ?></b>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">Proporcionalidad a <?= $diasInd ?> dias</div>
                        <div class="col-sm-4"><b></b></div>
                    </div><br>
                    <?php $i++;
                    } ?>

                    <?php if($liquidacion[0]->tipo_des_ren == 2){ ?>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)AGUINALDO</b></div>
                          <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">
                          <b>del <?php echo date_format(date_create($liquidacion[0]->fecha_aguinaldo),'d/m/Y') ?> al <?php echo date_format(date_create($liquidacion[0]->fecha_fin),'d/m/Y') ?></b>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">Proporcionalidad a <?= $diasAg ?> dias</div>
                        <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[0]->aguinaldo,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div><br>
                    <?php $i++;
                    } ?>

                    <?php if(($liquidacion[0]->tipo_des_ren == 1 || $liquidacion[0]->tipo_des_ren == 2 || $liquidacion[0]->tipo_des_ren == 3 || $liquidacion[0]->tipo_des_ren == 4 || $liquidacion[0]->tipo_des_ren == 5) && $liquidacion[0]->vacacion > 0 && $liquidacion[0]->prima_vacacion > 0){ ?>

                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)VACACION PROPORCIONAL</b></div>
                          <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">
                          <b>Periodo del 
                            <?php 
                            if($liquidacion[0]->fecha_vacacion != null){  
                              echo date_format(date_create($liquidacion[0]->fecha_vacacion),'d/m/Y'); 
                            }else{
                              echo date_format(date_create($liquidacion[0]->fecha_inicio),'d/m/Y');
                            }
                            ?> 
                            al <?php echo date_format(date_create($liquidacion[0]->fecha_fin),'d/m/Y') ?></b>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">Proporcionalidad a <?= $liquidacion[0]->dias_vacacion ?> dias</div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">VACACION POR SALARIO BASE</div>
                        <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[0]->vacacion,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">PRIMA POR SALARIO BASE 30%</div>
                        <div class="col-sm-2"><span style="border-bottom-style: double;">$ <?php echo number_format($liquidacion[0]->prima_vacacion,2) ?>&nbsp;&nbsp;&nbsp;</span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b>TOTAL A PAGAR VACACION:</b></div>
                        <div class="col-sm-2"><span><b>$ <?php echo number_format($liquidacion[0]->vacacion + $liquidacion[0]->prima_vacacion,2) ?></b></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div><br>
                    <?php $i++;
                    } ?>

                    <?php if($liquidacion[0]->tipo_des_ren == 1 || $liquidacion[0]->tipo_des_ren == 2 || $liquidacion[0]->tipo_des_ren == 3 || $liquidacion[0]->tipo_des_ren == 4 || $liquidacion[0]->tipo_des_ren == 5){ ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)SUELDO</b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">
                        <b>del <?php echo date_format(date_create($liquidacion[0]->fecha_quin1),'d/m/Y') ?> al <?php echo date_format(date_create($liquidacion[0]->fecha_quin2),'d/m/Y') ?></b>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">DIAS LABORADOS</div>
                      <div class="col-sm-2"><?php echo $diasLab; ?></div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->pago_dias,2) ?></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">SUELDO DIARIO</div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->sueldo_quincena/15,2); ?></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">VIATICOS</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;">$ <?php echo number_format($liquidacion[0]->viaticos,2) ?>&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL POR DIAS LABORADOS</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><b>$ <?php echo number_format($liquidacion[0]->pago_dias+$liquidacion[0]->viaticos,2); ?></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL A PAGAR PRESTACIONES</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;"><b>$ <?php echo number_format($liquidacion[0]->total_prestaciones,2); ?></b></span></div>
                    </div><br>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL GRAVADO</div>
                      <div class="col-sm-2"><b>$ <?php echo number_format($liquidacion[0]->total_gravado,2); ?></b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <br>
                    <?php $i++;
                    } ?>

                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)DEDUCCIONES:</b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">ISSS (3%)</div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->isss,2); ?></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">AFP (7.25%)</div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[0]->afp,2); ?></span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">ISR</div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->isr,2); ?>&nbsp;</div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    
                    <?php 
                      $total_deducciones = $liquidacion[0]->isss + $liquidacion[0]->afp + $liquidacion[0]->isr;
                    ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL DEDUCCIONES:</div>
                      <div class="col-sm-2"><span style="border-top-style: double;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;"><b>$ <?php echo number_format($total_deducciones,2); ?></b></span></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">MONTO A PAGAR:</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span><b>$ <?php echo number_format($liquidacion[0]->total_prestaciones - $total_deducciones,2); ?></b></span></div>
                    </div>
                    <br><br>

                    <div style="text-align: center;">
                      <div class="row">
                        <div class="col-sm-6"><span><?= $liquidacion[0]->agencia ?>, <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></span></div>
                      </div>
                    </div>
                    <div style="height: 60px;"></div>
                    <div style="text-align: center;" id="prueba">
                      <div class="row">
                        <div class="col-sm-6"><span>F_______________________</span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6"><span><?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?></span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6"><span>DUI: <?= $liquidacion[0]->dui ?></span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6"><span>NIT: <?= $liquidacion[0]->nit ?></span></div>
                        <div class="col-sm-6"><img src="<?= base_url();?>/assets/images/firma_vacacion.png" id="img_vacacion" style="width:240px;position:relative;top: -70px; "></div>
                      </div>

                      <br>
                    </div>

                  </div>

                   <!--APARTADO PARA LOS RECIBOS DE DEUDA-->
                <?php if($estadoR == 1 || $estadoR == 2){ ?>

                <div style="page-break-before: always"></div>

                <hr class="hr_liquidacion" ><br>

                <?php if($liquidacion[0]->id_empresa == 1){ ?>
                  <div style="margin: 10px;text-align: center;" >
                    <img src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
                  </div><br>
                    
                <?php }else if($liquidacion[0]->id_empresa == 2){ ?>
                  <div style="margin: 10px;text-align: center;" >
                    <img src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
                  </div><br>

                <?php }else if($liquidacion[0]->id_empresa == 3){ ?>
                  <div style="margin: 10px;text-align: center;" >
                    <img src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_empre">
                  </div><br>
                <?php } ?>

                <?php if($estadoR = 1){ ?>
                <div class="texto_recibo_liq">

                <div class="contenedor">
                  <h5 class="text-justify texto_finiquito">A quien Interese:</h5><br>
                </div>

                  <h5 class="text-justify texto_finiquito" style="line-height: 1.5;">
                    Por medio de la presente se hace constar que el señor(a): <b class="negrita"><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, tiene una deuda por <b class="negrita"> <?php echo $deuda.' ($'.number_format($totalDes,2).')'; ?></b> con la empresa <b class="negrita"><?php echo $liquidacion[0]->nombre_empresa ?></b> en los siguientes conceptos:
                    <br><br>
                <?php 
                if($descuentos != null){
                  for($i = 0; $i < count($descuentos); $i++){ ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-6"><b class="negrita">- <?php echo $descuentos[$i]['tipoD']; ?></b></div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($descuentos[$i]['pagoD'],2); ?></span></div>
                    </div>
                <?php 
                    }
                  }
                 ?>
                <?php if($faltante > 0){ ?>
                 <div class="row">
                    <div class="col-sm-1"><b></b></div>
                    <div class="col-sm-6"><b class="negrita">- Faltante</b></div>
                    <div class="col-sm-2"><span class="texto_deuda">$ <?php echo number_format($faltante,2); ?></span></div>
                  </div>
                <?php } ?>
                <?php if($anticipo > 0){ ?>
                 <div class="row">
                    <div class="col-sm-1"><b></b></div>
                    <div class="col-sm-6"><b class="negrita">- Anticipo</b></div>
                    <div class="col-sm-2"><span class="texto_deuda">$ <?php echo number_format($anticipo,2); ?></span></div>
                  </div>
                <?php } ?>
                <?php if($Personal > 0){ ?>
                 <div class="row">
                    <div class="col-sm-1"><b></b></div>
                    <div class="col-sm-6"><b class="negrita">- Prestamo Personal</b></div>
                    <div class="col-sm-2"><span class="texto_deuda">$ <?php echo number_format($Personal,2); ?></span></div>
                  </div>
                <?php } ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-6"><b>&nbsp;&nbsp;</b></div>
                  <div class="col-sm-2 bonde"><span class="texto_deuda">$ <?php echo number_format($totalDes,2); ?></span></div>
                </div><br><br>
                
                
                  De dicho saldo el Señor:(a): <b class="negrita"><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>  abono la cantidad de <b class="negrita"> <?php echo $abono.' ($'.number_format($liquido,2).')'; ?>,</b> quedando pendiente de pago la cantidad de <b class="negrita"><?php echo $resta.' ($'.number_format($restante,2).')'; ?>,</b>  los cuales serán pagados a <?php echo $liquidacion[0]->nombre_empresa ?>
                <br><br>

                
                  Como constancia se extiende la presente en <?= $liquidacion[0]->agencia ?> a los <?=  date("j")." días del mes de ". meses(date('m'))." de ".date("Y");?>
               <br><br><br>
                </h5>
                <div style="text-align: center;" id="prueba">
                  <div class="row">
                    <div class="col-sm-6"><span class="texto_deuda">F_______________________</span></div>
                    <div class="col-sm-6"><span></span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><span class="texto_deuda"><?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?></span></div>
                    <div class="col-sm-6"><span></span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><span class="texto_deuda">DUI: <?= $liquidacion[0]->dui ?></span></div>
                    <div class="col-sm-6"><span></span></div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6"><span class="texto_deuda">NIT: <?= $liquidacion[0]->nit ?></span></div>  
                  </div><br>

                  <hr class="hr1_liq"><hr class="hr2_liq">
                  <p class="pie_pag_liq"><?= $liquidacion[0]->casa_matriz ?><br>
                  Tel: 2448-0554 </p>

                  </div>
                  </div>
                <br><br>
                <?php }else if($estadoR = 2){ ?>

                <?php } ?>

              <?php }//Fin if($estadoR = 1 || $estadoR = 2)  ?>

               <hr class="hr_liquidacion" id="invicible"><br>

                  <!--FINIQUITO PARA TODAS LAS LIQUIDACIONES-->
                  <div id="invicible">

                  <?php 
                    if($liquidacion[0]->estado == 1){
                  ?>
                  <a class="btn btn-success" id="btn_permiso" href="<?php echo base_url();?>index.php/Liquidacion/word/<?php echo $liquidacion[0]->id_contrato ?>">
                      <span class="glyphicon glyphicon-floppy-save"></span> 
                    Guardar
                  </a>
                <?php } ?>

                  <div class="row" id="div_fecha">
                    <div class="col-sm-5">&nbsp;</div>
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-4"><p class="texto_finiquito"><?= $liquidacion[0]->agencia ?>, <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></p></div>
                  </div>

                  <div class="row" style="text-align: center;">
                    <h3><b class="encabezado_finiquito">Recibo de Finiquito</b></h3>
                  </div>

                  <div style="margin: 15px; margin-top: 0%;" class="contenedor ">
                  <p class="text-justify texto_finiquito">Entre <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> con Documento Único de Identidad numero <?= $liquidacion[0]->dui ?> del domicilio de <?= $liquidacion[0]->domicilio ?> en adelante «el trabajador», y <?= $liquidacion[0]->nombre_completo ?>, que se abrevia <?= $liquidacion[0]->nombre_empresa ?>, en adelante «el empleador», se deja testimonio y se ha acordado el finiquito que consta de las siguientes cláusulas:</p>
                </div>
                <?php 
                  $dia = substr($liquidacion[0]->fecha_inicio, 8,2);
                  $mes = substr($liquidacion[0]->fecha_inicio, 5,2);
                  $anio = substr($liquidacion[0]->fecha_inicio, 0,4);

                  $desde = $dia.' de '.meses($mes).' de '.$anio; 

                  $dia2 = substr($liquidacion[0]->fecha_fin, 8,2);
                  $mes2 = substr($liquidacion[0]->fecha_fin, 5,2);
                  $anio2 = substr($liquidacion[0]->fecha_fin, 0,4);

                  $hasta = $dia2.' de '.meses($mes2).' de '.$anio2;
                ?>

                <?php  ?>

                <div style="margin: 15px; margin-top: -1.5%;" class="contenedor texto_finiquito">
                  <p class="text-justify texto_finiquito">PRIMERO: El trabajador prestó servicios al empleador desde el <?= $desde ?> hasta el <?= $hasta ?>. SEGUNDO: <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> declara recibir en este acto, a su entera satisfacción, de parte de <?= $liquidacion[0]->nombre_empresa ?> la suma de $<?php echo number_format($liquidacion[0]->total_prestaciones - $total_deducciones,2) ?> según se señala a continuación:</p>
                </div>

                <?php if($liquidacion[0]->indemnizacion > 0){ ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>- Indemnizacion Proporcional </b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->indemnizacion,2); ?></div>
                </div>
                <?php } ?>
                <?php if($liquidacion[0]->aguinaldo > 0){ ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>- Aguinaldo Proporcional </b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->aguinaldo, 2); ?></div>
                </div>
                <?php } ?>
                <?php if($liquidacion[0]->vacacion > 0){ ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>- Vacación proporcional</b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->vacacion + $liquidacion[0]->prima_vacacion, 2) ?></div>
                </div>
                <?php } ?>
                <?php if($liquidacion[0]->viaticos > 0){ ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>- Viaticos </b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->viaticos, 2); ?></div>
                </div>
                <?php } ?>
                <?php 
                  if($dia2 >= 16 && $dia2 <= 31){
                    $diaQ = '16 al '.$dia2.' de '.meses($mes2).'-'.substr($anio2, 2,2);
                  }else{
                    $diaQ = '01 al '.$dia2.' de '.meses($mes2).'-'.substr($anio2, 2,2);
                  } 
                ?>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>- Salario devengado del <?= $diaQ ?></b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->pago_dias,2) ?></div>
                </div>

                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>&nbsp;&nbsp;Total devengado</b></div>
                  <div class="col-sm-3 bonde">$ <?php echo number_format($liquidacion[0]->total_prestaciones,2); ?></div>
                </div>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>&nbsp;&nbsp;Deducciones un total de</b></div>
                  <div class="col-sm-2">$ <?php echo number_format($total_deducciones,2); ?></div>
                </div>
                <div class="row">
                  <div class="col-sm-1"><b></b></div>
                  <div class="col-sm-5"><b>&nbsp;&nbsp;Liquido a recibir</b></div>
                  <div class="col-sm-2">$ <?php echo number_format($liquidacion[0]->total_prestaciones - $total_deducciones,2); ?></div>
                </div>

                <div style="margin: 15px; margin-top: 1%;" class="contenedor">
                  <p class="text-justify texto_finiquito"><?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> declara haber analizado y estudiado detenidamente dicha liquidación, aceptándola en todas sus partes, sin tener observación alguna que formularle y exime al empleador de toda responsabilidad laboral.</p>
                </div>
                <div style="margin: 15px; margin-top: -1.5%;" class="contenedor">
                  <p class="text-justify texto_finiquito">TERCERO: En consecuencia, el empleador paga a <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> en dinero efectivo la suma de $ <?php echo number_format($liquidacion[0]->total_prestaciones - $total_deducciones,2); ?> que el trabajador declara recibir en este acto a su entera satisfacción.  CUARTO: <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> deja constancia que durante el tiempo que prestó servicios a  recibió oportunamente el total de las remuneraciones de acuerdo a su contrato de trabajo, y que en tal virtud el empleador nada le adeuda por tales conceptos, ni por horas extraordinarias, feriado, indemnización por años de servicios, imposiciones previsionales, así como por ningún otro concepto, ya sea legal o contractual, derivado de la prestación de sus servicios, de su contrato de trabajo o de la terminación del mismo. En consecuencia, <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> declara que no tiene reclamo alguno que formular en contra de <?= $liquidacion[0]->nombre_empresa ?> renunciando a todas las acciones que pudieran emanar del contrato que los vinculó.</p>
                </div>
                <div style="margin: 15px; margin-top: -1.5%;" class="contenedor">
                  <p class="text-justify texto_finiquito">QUINTO: En virtud de lo anteriormente expuesto, <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> manifiesta expresamente que  nada le adeuda en relación con los servicios prestados, con el contrato de trabajo o con motivo de la terminación del mismo, por lo que libre y espontáneamente, y con el pleno y cabal conocimiento de sus derechos, otorga a su empleador, el más amplio, completo, total y definitivo finiquito por los servicios prestados o la terminación de ellos. SEXTO: Asimismo, declara el trabajador que, en todo caso, y a todo evento, renuncia expresamente a cualquier derecho, acción o reclamo que eventualmente tuviere o pudiere corresponderle en contra del empleador, en relación directa o indirecta con su contrato de trabajo, con los servicios prestados, con la terminación del referido contrato o dichos servicios, sepa que esos derechos o acciones correspondan a remuneraciones, cotizaciones previsionales, de seguridad social o de salud, subsidios, beneficios contractuales adicionales a las remuneraciones, indemnizaciones, compensaciones, o con cualquier otra causa o concepto. </p>
                </div>

                <div style="margin: 15px; margin-top: -1.5%;" class="contenedor">
                  <p class="text-justify texto_finiquito">Para constancia, las partes firman el presente finiquito en tres ejemplares, quedando uno en poder de cada una de ellas, y en cumplimiento de la legislación vigente, <?= $liquidacion[0]->nombre ?> <?= $liquidacion[0]->apellido ?> lo lee, firma y lo ratifica ante Yedmy Batres.</p>
                </div>

                <div style="height: 40px;"></div>
                <div style="text-align: center;" id="prueba">
                  <div class="row">
                    <div class="col-sm-6"><b>........................................</b></div>
                    <div class="col-sm-6"><b>........................................</b></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">TRABAJADOR</div>
                    <div class="col-sm-6">EMPLEADOR</div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><span>DUI: <?= $liquidacion[0]->dui ?> </span></div>
                    <div class="col-sm-6"><b>........................................</b></div>
                  </div>
                </div><br><br>
                </div>

               

                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <?php if(!empty($liquidacion[1])){ ?>
                
                <?php if($liquidacion[1]->dias_cesantia > 0){ ?>
                  
                    <div class="alert alert-success col-sm-6">
                      <span class="glyphicon glyphicon-warning-sign"></span> <b>Esta liquidacion tiene <?= $liquidacion[1]->dias_cesantia ?> dias de cesantia</b>
                    </div>
                    
                    <div class="alert alert-info col-sm-6">
                      <span class="glyphicon glyphicon-thumbs-up"></span> <b>Se le han perdonado <?= $liquidacion[1]->dias_perdonados ?> dias de cesantia</b>
                    </div>

                <?php } ?>

                <?php if($liquidacion[1]->tipo_des_ren == 5 && $liquidacion[1]->estado == 0){ ?>
                  <a class="btn btn-default item_agregar" data-toggle="modal" data-target="#Modal_Add" id="btn_permiso" data-id_liquidacion="<?= $liquidacion[1]->id_liquidacion;?>"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <?php }
                  if($liquidacion[1]->estado == 1){
                ?>
                  <a class="btn btn-success crear" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
                <?php }else if($liquidacion[1]->estado == 0){?>
                  <?php if($aprobar == 1){ ?>
                  <a class="btn btn-primary" data-toggle="modal" data-target="#Modal_Aprobar2" id="btn_permiso"><span class="glyphicon glyphicon-ok"></span> Aprobar</a>
                  <?php }
                    if($rechazar == 1){
                   ?>
                  <a class="btn btn-danger" data-toggle="modal" data-target="#Modal_Rechazar2" id="btn_permiso"><span class="glyphicon glyphicon-remove"></span> Rechazar</a>
                  <?php } ?>
                <?php }
                  $i = 1; ?>

                <div class="col-sm-12">
                  
                  <?php if($liquidacion[1]->id_empresa == 1){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?></b></h3>
                    </div>
                    
                  <?php }else if($liquidacion[1]->id_empresa == 2){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?></b></h3>
                    </div>

                  <?php }else if($liquidacion[1]->id_empresa == 3){ ?>
                    <div style="margin: 10px;text-align: center;" >
                      <img src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_empre">
                    </div><br>
                    <div style="margin: 10px;text-align: center;">
                      <h3><b>RECIBOS DE LIQUIDACION <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?></b></h3>
                    </div>

                  <?php } ?>
    
                  <?php if($liquidacion[1]->tipo_des_ren == 1){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[1]->nombre.' '.$liquidacion[1]->apellido ?></b>, empleado de <?php echo $liquidacion[1]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[1]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[1]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?> tal como lo expresa el Código de Trabajo de El Salvador en su art. 50 numeral  3: Por la perdida de confianza del patrono en el trabajador, cuando este desempeña un cargo de direccion, vigilancia, fiscalizacion u otro de igual importancia y responsabilidad. El Juez respectivo apreciara prudencialmente los hechos que el patrono estableciere para justificar la perdida de confianza. Las cantidades se le detallan a continuacion:</p>
                    </div><br>

                  <?php }else if($liquidacion[1]->tipo_des_ren == 2){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[1]->nombre.' '.$liquidacion[1]->apellido ?></b>, empleado de <?php echo $liquidacion[1]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[1]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[1]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?> tal como lo expresa el Código de Trabajo de El Salvador Art. 197 y 198 numeral 1º y Art.58 párrafos 1 y 2; y Reglamento Interno de Trabajo que se aplica en <?php echo $liquidacion[0]->nombre_empresa ?> en las cantidades que a continuación se detallan:</p>
                    </div><br>

                  <?php }else if($liquidacion[0]->tipo_des_ren == 3){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[1]->nombre.' '.$liquidacion[1]->apellido ?></b>, empleado de <?php echo $liquidacion[1]->nombre_empresa ?> Se le notifica que prescindiremos de sus servicios a la plaza de <b><?php echo $liquidacion[1]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[1]->agencia ?> por lo tanto se le presentan sus cálculos por liquidación por el año <?php echo substr($liquidacion[1]->fecha_fin, 0,4); ?> Terminando el contrato <b>sin responsabilidad para el patrono</b> tal como lo expresa el Código de Trabajo de El Salvador en su art. 28: En los contratos individuales de trabajo podra estipularse que los primeros treinta dias seran de prueba. Dentro de este termino, cualquiera de las partes podra dar por terminado el contrato sin expresion de causa.</p>
                    </div><br>

                  <?php }else if($liquidacion[1]->tipo_des_ren == 4 || ($liquidacion[1]->tipo_des_ren == 5 && $liquidacion[1]->dias_laborado >= 200)){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[1]->nombre.' '.$liquidacion[1]->apellido ?></b>, empleado de <?php echo $liquidacion[1]->nombre_empresa ?> se le notifica que hemos aceptado su renuncia a la plaza de:<b><?php echo $liquidacion[1]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[1]->agencia ?> por lo tanto se presentan los cálculos de los dias laborados a continuacion:</p>
                    </div><br>

                 <?php }else if($liquidacion[1]->tipo_des_ren == 5 && $liquidacion[1]->dias_laborado < 200){ ?>
                    <div style="margin: 10px;" class="contenedor">
                      <p class="text-justify">Sr.(a) <b><?php echo $liquidacion[0]->nombre.' '.$liquidacion[0]->apellido ?></b>, empleado de <?php echo $liquidacion[0]->nombre_empresa ?> se le notifica que hemos aceptado su renuncia a la plaza de:<b><?php echo $liquidacion[0]->cargo ?></b> que desempeña en agencia <?php echo $liquidacion[0]->agencia ?>, que hizo de manera escrita a su jefe(a) inmediato(a) por lo tanto se presentan los cálculos de los dias laborados tal como lo expresa el Codigo de Trabajo de El Salvador en su art. 180, <b>Mínimo de días Laborados para derecho a vacaciones</b>: Todo trabajador, para tener derecho a vacaciones, debera acreditar un mínimo de doscientos dias trabajados en el año, aunque en el contrato respectivo no se le exija trabajar todos los dias de la semana, ni se le exija trabajar en cada dia el maximo de horas ordinarias.</p>
                    </div><br>
                  <?php } ?>

                  <div class="contenedor">
                    
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;">DATOS</b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>SALARIO BASE QUINCENAL</b></div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[1]->sueldo_quincena,2) ?> </span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>FECHA DE INICIO:</b></div>
                      <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[1]->fecha_inicio),'d/m/Y') ?></span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>FECHA DE RETIRO:</b></div>
                      <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[1]->fecha_fin),'d/m/Y') ?> </span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b>DIAS LABORADOS:</b></div>
                      <div class="col-sm-2"><span><?php echo $liquidacion[1]->dias_laborado; ?> DIAS</span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <?php if($liquidacion[1]->fecha_vacacion != null && $liquidacion[1]->fecha_inicio != $liquidacion[1]->fecha_vacacion){ ?>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b>FECHA DE ULTIMA VACACION:</b></div>
                        <div class="col-sm-2"><span><?php echo date_format(date_create($liquidacion[1]->fecha_vacacion),'d/m/Y') ?> </span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                    <?php } ?>
                    <br><br>

                     <?php 
                      //DIFERENCIA DE DIAS ENTRE LAS FECHAS 
                      $difInd2 = date_diff(date_create(substr($liquidacion[1]->fecha_fin, 0,4).'-01-01'),date_create($liquidacion[1]->fecha_fin));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasInd2 = ($difInd2->format('%a') + 1);

                      $difAg2 = date_diff(date_create($liquidacion[1]->fecha_aguinaldo),date_create($liquidacion[1]->fecha_fin));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasAg2 = ($difAg2->format('%a') + 1);

                      $difLab2 = date_diff(date_create($liquidacion[1]->fecha_quin1),date_create($liquidacion[1]->fecha_quin2));
                      //Se encuentran el total de dias que hay entre las dos fechas 
                      $diasLab2 = ($difLab2->format('%a') + 1);

                      if($diasLab2 > 15){
                        $diasLab2 = 15;
                      }

                     ?>

                    <?php if(($liquidacion[1]->tipo_des_ren == 2 || $liquidacion[1]->tipo_des_ren == 5) && $liquidacion[1]->indemnizacion > 0){ ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)INDEMNIZACION PROPORCIONAL</b></div>
                      <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[1]->indemnizacion,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">
                        <b>del <?php echo date_format(date_create($liquidacion[1]->fecha_inicio),'d/m/Y') ?> al <?php echo date_format(date_create($liquidacion[1]->fecha_fin),'d/m/Y') ?></b>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">Proporcionalidad a <?= $diasInd2 ?> dias</div>
                        <div class="col-sm-4"><b></b></div>
                    </div><br>
                    <?php $i++;
                    } ?>

                    <?php if($liquidacion[1]->tipo_des_ren == 2){ ?>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)AGUINALDO</b></div>
                          <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">
                          <b>del <?php echo date_format(date_create($liquidacion[1]->fecha_inicio),'d/m/Y') ?> al <?php echo date_format(date_create($liquidacion[1]->fecha_fin),'d/m/Y') ?></b>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">Proporcionalidad a <?= $diasAg2 ?> dias</div>
                        <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[1]->aguinaldo,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div><br>
                    <?php $i++;
                    } ?>

                    <?php if(($liquidacion[1]->tipo_des_ren == 1 || $liquidacion[1]->tipo_des_ren == 2 || $liquidacion[1]->tipo_des_ren == 3 || $liquidacion[1]->tipo_des_ren == 4 || $liquidacion[1]->tipo_des_ren == 5) && $liquidacion[1]->vacacion > 0 && $liquidacion[1]->prima_vacacion > 0){ ?>

                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)VACACION PROPORCIONAL</b></div>
                          <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">
                          <b>Periodo del 
                            <?php 
                            if($liquidacion[1]->fecha_vacacion != null){  
                              echo date_format(date_create($liquidacion[1]->fecha_vacacion),'d/m/Y'); 
                            }else{
                              echo date_format(date_create($liquidacion[1]->fecha_inicio),'d/m/Y');
                            }
                            ?> 
                            al <?php echo date_format(date_create($liquidacion[1]->fecha_fin),'d/m/Y') ?></b>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">Proporcionalidad a <?= $liquidacion[1]->dias_vacacion ?> dias</div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">VACACION POR SALARIO BASE</div>
                        <div class="col-sm-2"><span>$ <?php echo number_format($liquidacion[1]->vacacion,2) ?></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4">PRIMA POR SALARIO BASE 30%</div>
                        <div class="col-sm-2"><span style="border-bottom-style: double;">$ <?php echo number_format($liquidacion[1]->prima_vacacion,2) ?>&nbsp;&nbsp;&nbsp;</span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"><b></b></div>
                        <div class="col-sm-4"><b>TOTAL A PAGAR VACACION:</b></div>
                        <div class="col-sm-2"><span><b>$ <?php echo number_format($liquidacion[1]->vacacion + $liquidacion[1]->prima_vacacion,2) ?></b></span></div>
                        <div class="col-sm-4"><b></b></div>
                      </div><br>
                    <?php $i++;
                    } ?>

                    <?php if($liquidacion[1]->tipo_des_ren == 1 || $liquidacion[1]->tipo_des_ren == 2 || $liquidacion[1]->tipo_des_ren == 3 || $liquidacion[1]->tipo_des_ren == 4 || $liquidacion[1]->tipo_des_ren == 5){ ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)SUELDO</b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">
                        <b>del <?php echo date_format(date_create($liquidacion[1]->fecha_quin1),'d/m/Y') ?> al <?php echo date_format(date_create($liquidacion[1]->fecha_quin2),'d/m/Y') ?></b>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">DIAS LABORADOS</div>
                      <div class="col-sm-2"><?php echo $diasLab2; ?></div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[1]->pago_dias,2) ?></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">SUELDO DIARIO</div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[1]->sueldo_quincena/15,2); ?></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">VIATICOS</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double; border-top-style: double;">$ <?php echo number_format($liquidacion[1]->viaticos,2) ?>&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL POR DIAS LABORADOS</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><b>$ <?php echo number_format($liquidacion[1]->pago_dias+$liquidacion[1]->viaticos,2); ?></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL A PAGAR PRESTACIONES</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;"><b>$ <?php echo number_format($liquidacion[1]->total_prestaciones,2); ?></b></span></div>
                    </div><br>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL GRAVADO</div>
                      <div class="col-sm-2"><b>$ <?php echo number_format($liquidacion[1]->total_gravado,2); ?></b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <br>
                    <?php $i++;
                    } ?>

                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4"><b style="text-decoration: underline;"><?= $i ?>)DEDUCCIONES:</b></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">ISSS (3%)</div>
                      <div class="col-sm-2">$ <?php echo number_format($liquidacion[1]->isss,2); ?></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">AFP (7.25%)</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;">$ <?php echo number_format($liquidacion[1]->afp,2); ?></span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">ISR</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;">$ <?php echo number_format($liquidacion[1]->isr,2); ?>&nbsp;</span></div>
                      <div class="col-sm-4"><b></b></div>
                    </div>

                    <?php  
                      $total_deducciones =$liquidacion[1]->isss + $liquidacion[1]->afp + $liquidacion[1]->isr ;
                    ?>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">TOTAL DEDUCCIONES:</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span style="border-bottom-style: double;"><b>$ <?php echo number_format($total_deducciones,2); ?></b></span></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"><b></b></div>
                      <div class="col-sm-4">MONTO A PAGAR:</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2">&nbsp;</div>
                      <div class="col-sm-2"><span><b>$ <?php echo number_format($liquidacion[1]->total_prestaciones - $total_deducciones,2); ?></b></span></div>
                    </div>
                    <br><br>

                    <div style="text-align: center;">
                      <div class="row">
                        <div class="col-sm-6"><span><?= $liquidacion[1]->agencia ?>, <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></span></div>
                      </div>
                    </div>
                    <div style="height: 60px;"></div>
                    <div style="text-align: center;">
                      <div class="row">
                        <div class="col-sm-6"><span>F_______________________</span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6"><span><?= $liquidacion[1]->nombre ?> <?= $liquidacion[1]->apellido ?></span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6"><span>DUI: <?= $liquidacion[1]->dui ?></span></div>
                        <div class="col-sm-6"><span></span></div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6"><span>NIT: <?= $liquidacion[1]->nit ?></span></div>
                        <div class="col-sm-6"><img src="<?= base_url();?>/assets/images/firma_vacacion.png" id="img_vacacion" style="width:240px;position:relative;top: -70px; "></div>
                      </div>

                      <br>
                    </div>

                  </div><!--Fin <div class="contenedor">-->
                </div><!--Fin <div class="col-sm-12">-->

              <?php }else{ ?>
                <br><h3>Le vale</h3>
              <?php } ?>

            </div>
          </div><!--Fin div tab-content-->
          

          
        </div>
    </div>
</div>

<form>
  <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                Agregar Seccion de Liquidacion 
              </h4>
            </center>
                
          </div>
          <div class="modal-body">
              <div id="validacion" style="color:red"></div>
              <br>
              <div class="row">
                <div class="col-sm-4">
                  <div class="pretty p-switch p-fill">
                    <input type="checkbox" name="switch1" id="indemnizacion" />
                      <div class="state p-success">
                        <label>Indemnizacion Proporcional</label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-1"><b></b></div>

                <div class="col-sm-4">
                  <div class="pretty p-switch p-fill">
                    <input type="checkbox" name="switch1" id="pro_vacacion" />
                    <div class="state p-success">
                      <label>Vacacion Proporcional</label>
                    </div>
                  </div>
                </div>
              </div>
                    <!--<div id="cantidad_anticipada" style="color: blue">Hola Mundo</div>-->
              <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                    <br><p style="color: #24B4F7" id="cantidad"></p>
                    <label>Porcentaje de Indemnizacion:</label><br>
                    <input type="number" class="form-control" id="por_indemnizacion" name="por_indemnizacion">
                    <p id="dado" style="color: #F32323;"></p>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                    <br><p style="color: #24B4F7" id="cantidad_vacacion"></p>
                    <label>Porcentaje de Indemnizacion:</label><br>
                    <input type="number" class="form-control" id="por_vacacion" name="por_vacacion">
                    <p id="vacacion_dada" style="color: #F32323;"></p>
                  </div>
              </div>
              
            </div>        


                    
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_liquidacion" id="id_liquidacion" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
            <input type="hidden" name="cant" id="cant" class="form-control" readonly>
            <input type="hidden" name="cant_vaca" id="cant_vaca" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form>
  <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                <b>Aprobar Liquidacion</b> 
              </h4>
            </center>
                
          </div>
          <div class="modal-body"> 
            <label>¿Desea Aprobar Esta Liquidacion?</label>        
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_liq_aprobar" id="id_liq_aprobar" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
            <?php if(!empty($liquidacion[1])){ ?>
              <input type="hidden" name="id_liq_aprobar2" id="id_liq_aprobar2" class="form-control" readonly value="<?= ($liquidacion[1]->id_liquidacion);?>">
            <?php }else{ ?>
              <input type="hidden" name="id_liq_aprobar2" id="id_liq_aprobar2" class="form-control" readonly value="no_cesantia">
            <?php } ?>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_aprobar" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form action="<?= base_url();?>index.php/Liquidacion/rechazarLiquidacion/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
  <div class="modal fade" id="Modal_Rechazar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                <b>Rechazar Liquidacion</b> 
              </h4>
            </center>
                
          </div>
          <div class="modal-body"> 
            <label>¿Desea Rechazar Esta Liquidacion?</label>        
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_liq_rechazar" id="id_liq_rechazar" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form>
  <div class="modal fade" id="Modal_Rechazar3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                <b>Rechazar Liquidacion</b> 
              </h4>
            </center>
                
          </div>
          <div class="modal-body"> 
            <label>¿Desea Rechazar Esta Liquidacion?</label>        
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_liq_rechaza3" id="id_liq_rechazar3" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_rechazar2" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>


<form>
    <div class="modal fade" id="Modal_dias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel"><strong>Perdonar dias de Cesantía</strong></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <div class="modal-body">
                    <b>¿Cuantos dias de Cesantía desea perdonar?</b><br><br>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-form-label">Dias perdonados:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="num_dias" id="num_dias" class="form-control">
                        </div>
                    </div>
                    <div id="validacion_cesantia" style="color:red"></div>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="id_liq_perdon" id="id_liq_perdon" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
                <input type="hidden" name="cant_dias" id="cant_dias" class="form-control" readonly value="<?= ($liquidacion[0]->dias_cesantia);?>">
                <input type="hidden" name="cant_per" id="cant_per" class="form-control" readonly value="<?= ($liquidacion[0]->dias_perdonados);?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_dias" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form>
  <div class="modal fade" id="Modal_Aprobar2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                <b>Aprobar Liquidacion</b> 
              </h4>
            </center>
                
          </div>
          <div class="modal-body"> 
            <label>¿Desea Aprobar Esta Liquidacion?</label>        
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_aprobar1" id="id_aprobar1" class="form-control" readonly value="<?= ($liquidacion[0]->id_liquidacion);?>">
            <input type="hidden" name="id_aprobar2" id="id_aprobar2" class="form-control" readonly value="<?= ($liquidacion[1]->id_liquidacion);?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_aprobar2" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form>
  <div class="modal fade" id="Modal_Rechazar2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center>
              <h4 class="modal-title" id="exampleModalLabel">
                <b>Rechazar Liquidacion</b> 
              </h4>
            </center>
                
          </div>
          <div class="modal-body"> 
            <label>¿Desea Rechazar Esta Liquidacion?</label>        
          </div>
          <div class="modal-footer">
            <input type="hidden" name="id_liq_rechazar2" id="id_liq_rechazar2" class="form-control" readonly value="<?= ($liquidacion[1]->id_liquidacion);?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_rechazar" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.crear').click(function(){
            $('.ocultar').hide();
            window.print();
            $('.ocultar').show();
        });

        check();
        $('#indemnizacion').on('click', function() {
            check();
        });
        $('#pro_vacacion').on('click', function() {
            check();
        });

        function check(){
          if($('#indemnizacion').is(':checked')) {
            $("#por_indemnizacion").prop('disabled', false);
          }else{
            $('#por_indemnizacion').val("");
            $("#por_indemnizacion").prop('disabled', true);
          }

          if($('#pro_vacacion').is(':checked')) {
            $("#por_vacacion").prop('disabled', false);
          }else{
            $('#por_vacacion').val("");
            $("#por_vacacion").prop('disabled', true);
          }

        };

        $('.item_agregar').click(function(){
          var code = $(this).data('id_liquidacion');
          $.ajax({
              type : "POST",
              url  : "<?php echo site_url('liquidacion/verLiquidacion')?>",
              dataType : "JSON",
              data : {code:code},
              success: function(data){
                document.getElementById('cantidad').innerHTML = data.enunciado;
                document.getElementById('cantidad_vacacion').innerHTML = data.vacacion;
                $('[name="cant"]').val(data.cantidad);
                $('[name="cant_vaca"]').val(data.total_vaca);
              },  
              error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
          });
          
        });

        calcular();
        $("#por_indemnizacion").keyup(function(){
          calcular();
        });

        $("#por_vacacion").keyup(function(){
          calcular();
        });

        function calcular(){
          var por_indemnizacion = $('#por_indemnizacion').val();
          var por_vacacion = $('#por_vacacion').val();
          var cant = $('#cant').val();
          var cant_vaca = $('#cant_vaca').val();
          var liquidacion = 0;
          var vacacion = 0;

          if(por_indemnizacion == ""){
            por_indemnizacion = 0;
            liquidacion = cant * (por_indemnizacion/100);

            document.getElementById('dado').innerHTML = 'Indemnizacion otorgada $'+parseFloat(liquidacion).toFixed(2);
          }else{
            liquidacion = cant * (por_indemnizacion/100);

            document.getElementById('dado').innerHTML = 'Indemnizacion otorgada $'+parseFloat(liquidacion).toFixed(2);

          }

          if(por_vacacion == ""){
            por_vacacion = 0;
            vacacion = cant_vaca * (por_vacacion/100);

            document.getElementById('vacacion_dada').innerHTML = 'Vacacion otorgada $'+parseFloat(vacacion).toFixed(2);
          }else{
            vacacion = cant_vaca * (por_vacacion/100);
            
            document.getElementById('vacacion_dada').innerHTML = 'Vacacion otorgada $'+parseFloat(vacacion).toFixed(2);
          }

        };


        //Metooo para el ingreso 
        $('#btn_save').on('click',function(){
            var id_liquidacion = $('#id_liquidacion').val();

            if($('#indemnizacion').is(':checked')){
              var indemnizacion = 1;
              var por_indemnizacion = $('#por_indemnizacion').val();
            }else{
              var indemnizacion = 0;
              var por_indemnizacion = null;
            }

            if($('#pro_vacacion').is(':checked')){
              var vacacion = 1;
              var por_vacacion = $('#por_vacacion').val();
            }else{
              var vacacion = 0;
              var por_vacacion = null;
            }

            $.ajax({
              type : "POST",
              url  : "<?php echo site_url('Liquidacion/agregarFuncion')?>",
              dataType : "JSON",
              data : {id_liquidacion:id_liquidacion,indemnizacion:indemnizacion,por_indemnizacion:por_indemnizacion,vacacion:vacacion,por_vacacion:por_vacacion},
              success: function(data){
                if(data == null){
                  document.getElementById('validacion').innerHTML = '';
                  $('[name="por_indemnizacion"]').val("");

                  location.reload();
                  this.disabled=false;
                  show_area();
                }else{
                  document.getElementById('validacion').innerHTML = '';
                  for (i = 0; i <= data.length-1; i++){
                    document.getElementById('validacion').innerHTML += data[i];
                  }//Fin For

                }//Fin if else
                                
              },  
              error: function(data){
              var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
            });
            return false;
                
        });//fin de insercionde 


        //Metodo para aprobar 
        $('#btn_aprobar').on('click',function(){
            var code = $('#id_liq_aprobar').val();
            var id_liq_aprobar2 = $('#id_liq_aprobar2').val();
            
            if(id_liq_aprobar2 == "no_cesantia"){
              var bandera = true;
            }else{
              var bandera = confirm("Si aprueba esta liquidacion se eliminara la liquidacion con perdon de dias ¿Desea Aprobar?");
            }

            if(bandera){
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/aprobarLiquidacion')?>",
                dataType : "JSON",
                data : {code:code,id_liq_aprobar2:id_liq_aprobar2},
                success: function(data){
                  Swal.fire(
                      'La Liquidacion a Sido Aprobada Con Exito!',
                      '',
                      'success'
                    )
                  setTimeout('document.location.reload()',2000);
                  this.disabled=false;
                  show_area();               
                },  
                error: function(data){
                var a =JSON.stringify(data['responseText']);
                  alert(a);
                  this.disabled=false;
                }
              });
              return false;
            }
     
        });//fin de aprobar 

        //Metooo para el ingreso 
        $('#btn_dias').on('click',function(){
            var id_liq_perdon = $('#id_liq_perdon').val();
            var num_dias = $('#num_dias').val();
            var cant_dias = $('#cant_dias').val();
            var cant_per = $('#cant_per').val();
            $.ajax({
              type : "POST",
              url  : "<?php echo site_url('Liquidacion/perdonarDias')?>",
              dataType : "JSON",
              data : {id_liq_perdon:id_liq_perdon,num_dias:num_dias,cant_dias:cant_dias,cant_per:cant_per},
              success: function(data){
                if(data == null){
                  document.getElementById('validacion_cesantia').innerHTML = '';
                  $('[name="num_dias"]').val("");

                  Swal.fire(
                    'Días Perdonados Con Exito!',
                    '',
                    'success'
                  )
                setTimeout('document.location.reload()',2000);
                  this.disabled=false;
                  show_area();
                }else{
                  document.getElementById('validacion_cesantia').innerHTML = '';
                  for (i = 0; i <= data.length-1; i++){
                    document.getElementById('validacion_cesantia').innerHTML += data[i];
                  }//Fin For

                }//Fin if else
                                
              },  
              error: function(data){
              var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
            });
            return false;
                
        });//fin de insercionde

        //Metodo para el rechazo de la segunda indemnizacion 
        $('#btn_rechazar').on('click',function(){
            var id_liq_rechazar2 = $('#id_liq_rechazar2').val();
            $.ajax({
              type : "POST",
              url  : "<?php echo site_url('Liquidacion/rechazarLiquidacion2')?>",
              dataType : "JSON",
              data : {id_liq_rechazar2:id_liq_rechazar2},
              success: function(data){
                Swal.fire(
                    'Liquidacion Eliminada Correctamente!',
                    '',
                    'error'
                  )
                setTimeout('document.location.reload()',2000);
                this.disabled=false;
                show_area();               
              },  
              error: function(data){
              var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
            });
            return false;
                
        });//fin de rechazo

        //Metodo para aprobar segunda indemnizacion
        $('#btn_aprobar2').on('click',function(){
            var id_aprobar1 = $('#id_aprobar1').val();
            var id_aprobar2 = $('#id_aprobar2').val();
            var bandera = confirm("Si aprueba la liquidacion con perdon de dias se eliminara la liquidacion normal ¿Desea Aprobar?");
            if(bandera){
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/aprobarLiquidacion2')?>",
                dataType : "JSON",
                data : {id_aprobar1:id_aprobar1,id_aprobar2:id_aprobar2},
                success: function(data){
                  Swal.fire(
                      'La Liquidacion a Sido Aprobada Con Exito!',
                      '',
                      'success'
                    )
                  setTimeout('document.location.reload()',2000);
                  this.disabled=false;
                  show_area();               
                },  
                error: function(data){
                var a =JSON.stringify(data['responseText']);
                  alert(a);
                  this.disabled=false;
                }
              });
              return false;
            }
     
        });//fin de aprobar

        //Metodo para el rechazo de la segunda indemnizacion 
        $('#btn_rechazar2').on('click',function(){
            var id_liq_rechazar3 = $('#id_liq_rechazar3').val();
            $.ajax({
              type : "POST",
              url  : "<?php echo site_url('Liquidacion/rechazarLiquidacion3')?>",
              dataType : "JSON",
              data : {id_liq_rechazar3:id_liq_rechazar3},
              success: function(data){
                Swal.fire(
                    'Liquidacion Eliminada Correctamente!',
                    '',
                    'error'
                  )
                setTimeout('document.location.reload()',2000);
                this.disabled=false;
                show_area();               
              },  
              error: function(data){
              var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
            });
            return false;
                
        });//fin de rechazo

    });//Fin jQuery

</script>
</body>

</style>
</html>