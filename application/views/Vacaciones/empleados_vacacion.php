<style type="text/css">
    div > .linea {
      border-top: double; 
      text-align: center;
      font-size: 16px;
    }
    #linea{border-top: double;}
    #centrado {text-align: center;}
    .principal > #centrado{
        margin: 15px;
        text-align: center;
    }
</style>
<?php 
    if(!empty($vacacion_guardar)){
        $vacaciones1=json_encode($vacacion_guardar);
    }else{
        $vacaciones1="";
    }
    if(!empty($prestamo_interno)){
        $prestamo_interno1=json_encode($prestamo_interno);
    }else{
        $prestamo_interno1="";
    }
    if(!empty($prestamo_per)){
        $prestamo_per1=json_encode($prestamo_per);
    }else{
        $prestamo_per1="";
    }
    if(!empty($anticipo)){
        $anticipo1=json_encode($anticipo);
    }else{
        $anticipo1="";
    }
    if(!empty($descuenta_herramienta)){
        $descuenta_herramienta1=json_encode($descuenta_herramienta);
    }else{
        $descuenta_herramienta1="";
    }
    if(!empty($orden_descuento)){
        $orden_descuento1=json_encode($orden_descuento);
    }else{
        $orden_descuento1="";
    }
    if(!empty($prestamos_siga)){
        $prestamos_siga1=json_encode($prestamos_siga);
    }else{
        $prestamos_siga1="";
    }
?>
<div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Vacaciones</h2>
    </div>

    <div class="principal" id="principal" style="margin-top: 10px"> 
        <div class="row" id="centrado"> 
            <div class="col-sm-3" style="text-align: center;">
                <img src="<?php echo base_url("assets/images/watermark.png"); ?>" alt="..." style="height: 30px;margin-left: 30px;">
            </div>
            <div class="col-sm-6" style="text-align: center;">
                <h4><?=$titulo?>.</h4>
            </div>
            <?php if($validar_aprobar == 1 && !empty($vacacion_guardar)){ ?>
            <div class="col-sm-3" style="text-align: center;">
                <a class="btn btn-success" id="btn_bienes" data-toggle="modal" data-target="#Modal_aprobar_vaca"><span class="glyphicon glyphicon-check"></span> Aprobar</a><br><br>
            </div>
            <?php } ?>
        </div>
    </div>

    <div id="linea"></div><br><br>

    <div class=" col-sm-12 col-md-12 ">
        <table class="table table-striped table-dark" style="font-size: 82%">
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center; border-right:1px solid #969793;">Datos generales</th>
                    <th colspan="4" style="text-align: center; border-right:1px solid #969793;">Devengado</th>
                    <th colspan="3" style="text-align: center; border-right:1px solid #969793;">Descuentos ley</th>
                    <th colspan="4" style="text-align: center; border-right:1px solid #969793;">Otros descuentos</th>
                    <th rowspan="2" style="text-align:center;vertical-align: middle;">Total pagar<br>($)</th>
                </tr>

                <tr>
                  <th style="text-align:center;vertical-align: middle;">A</th>
                  <th style="text-align:center;vertical-align: middle;">Agencia</th>
                  <th style="text-align:center;vertical-align: middle;">Empresa</th>
                  <th style="text-align:center;vertical-align: middle;">Nombre</th>
                  <th style="text-align:center;vertical-align: middle;">Aplicar</th>
                  <th style="text-align:center;vertical-align: middle; border-right:1px solid #969793;">Fin</th>
                  <th style="text-align:center;">Sueldo<br>($)</th>
                  <th style="text-align:center;">Bono<br>($)</th>
                  <th style="text-align:center;">Prima<br>($)</th>
                  <th style="text-align:center; border-right:1px solid #969793;">Total Deveng.<br>($)</th>
                  <th style="text-align:center;">ISSS<br>($)</th>
                  <th style="text-align:center;">AFP<br>($)</th>
                  <th style="text-align:center; border-right:1px solid #969793;">ISR<br>($)</th>
                  <th style="text-align:center;">P. Internos<br>($)</th>
                  <th style="text-align:center;">P. Personal<br>($)</th>
                  <th style="text-align:center;">O. Descuento<br>($)</th>
                  <th style="text-align:center; border-right:1px solid #969793;">Anticipo<br>($)</th>
                  <!--<th style="text-align:center; border-right:1px solid #969793;">Faltante<br>($)</th>-->
                </tr>
                
            </thead>
            <tbody>
                <?php 
                $total_sueldo_quin=0;
                $total_comision=0;
                $total_prima=0;
                $total_pagar=0;
                $total_isss=0;
                $total_afp=0;
                $total_isr=0;
                $total_interno=0;
                $total_personal=0;
                $total_orden_desc=0;
                $total_anticipo=0;
                $total_faltante=0;
                $total_a_pagar=0;

                foreach($vacaciones as $vacacion){
                    if($vacacion->guardado == 1){
                        $guardado = 'Si';
                    }else{
                        $guardado = 'No';
                    }
                    echo "<tr>";
                    echo "<td style='text-align: left'>".$guardado."</td>";
                    echo "<td style='text-align: left'>".$vacacion->agencia."</td>";
                    echo "<td style='text-align: left'>".$vacacion->nombre_empresa."</td>";
                    echo "<td style='text-align: left;'>".$vacacion->empleado."</td>";
                    echo "<td style='text-align: left;'>".date_format(date_create($vacacion->fecha_aplicar),"Y/m/d")."</td>";
                    echo "<td style='text-align: left; border-right:1px solid #969793;'>".date_format(date_create($vacacion->fecha_final),"Y/m/d")."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->sueldo_quin,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->comisiones,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->prima,2)."</td>";
                    echo "<td style='text-align: right;  border-right:1px solid #969793;'>".number_format($vacacion->total_pagar,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->isss,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->afp,2)."</td>";
                    echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacacion->renta,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->interno,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->personal,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->orden_descuento,2)."</td>";;
                    echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacacion->anticipos,2)."</td>";
                    //echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacacion->descuentos_faltantes,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacacion->a_pagar,2)."</td>";
                    echo "</tr>";

                    $total_sueldo_quin+=$vacacion->sueldo_quin;
                    $total_comision+=$vacacion->comisiones;
                    $total_prima+=$vacacion->prima;
                    $total_pagar+=$vacacion->total_pagar;
                    $total_isss+=$vacacion->isss;
                    $total_afp+=$vacacion->afp;
                    $total_isr+=$vacacion->renta;
                    $total_interno+=$vacacion->interno;
                    $total_personal+=$vacacion->personal;
                    $total_orden_desc+=$vacacion->orden_descuento;
                    $total_anticipo+=$vacacion->anticipos;
                    //$total_faltante+=$vacacion->descuentos_faltantes;
                    $total_a_pagar+=$vacacion->a_pagar;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                   <td colspan="6" style="text-align: center; border-right:1px solid #969793;"><strong>TOTAL</strong></td> 
                   <td style='text-align: right;'><strong><?= number_format($total_sueldo_quin, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_comision, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_prima, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right; border-right:1px solid #969793;'><strong><?= number_format($total_pagar, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_isss, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_afp, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;border-right:1px solid #969793;'><strong><?= number_format($total_isr, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_interno, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_personal, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;'><strong><?= number_format($total_orden_desc, 2, '.', ',') ?></strong></td>
                   <td style='text-align: right;border-right:1px solid #969793;'><strong><?= number_format($total_anticipo, 2, '.', ',') ?></strong></td>
                   <!--<td style='text-align: right;border-right:1px solid #969793;'><strong><?= number_format($total_faltante, 2, '.', ',') ?></strong></td>-->
                   <td style='text-align: right;'><strong><?= number_format($total_a_pagar, 2, '.', ',') ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<form action="<?= base_url();?>index.php/Vacaciones/guardar_vacaciones" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="modal fade" id="Modal_aprobar_vaca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel">Aprobación de vacaciones</h4></center>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea aprobar estas vacaciones?</strong>
                </div>

                <div class="modal-footer">
                    <input type='hidden' name='vaca' id='vaca' value='<?php echo $vacaciones1 ?>' class="form-control" readonly>
                    <input type='hidden' name='internos' id='internos' value='<?php echo $prestamo_interno1 ?>' class="form-control" readonly>
                    <input type='hidden' name='personales' id='personales' value='<?php echo $prestamo_per1 ?>' class="form-control" readonly>
                    <input type='hidden' name='anticipos' id='anticipos' value='<?php echo $anticipo1 ?>' class="form-control" readonly>
                    <input type='hidden' name='herramientas' id='herramientas' value='<?php echo $descuenta_herramienta1 ?>' class="form-control" readonly>
                    <input type='hidden' name='faltantes' id='faltantes' value='<?php echo $faltante1 ?>' class="form-control" readonly>
                    <input type='hidden' name='orden' id='orden' value='<?php echo $orden_descuento1 ?>' class="form-control" readonly>
                    <input type='hidden' name='siga' id='siga' value='<?php echo $prestamos_siga1 ?>' class="form-control" readonly>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_aprobar" class="btn btn-primary" onclick="modal_gif()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal GIF-->
<div class="modal fade" id="modalGif" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">Cargando Por Favor Espere</h4>
        </div>
        <div class="modal-body" >
          <center><div class="lds-dual-ring"></div></center>
        </div>
       
      </div>
      
    </div>
</div>
<script type="text/javascript">
    function modal_gif() {
        $("#Modal_aprobar_vaca").modal('toggle');
        $('#modalGif').modal('show')
    }
</script>