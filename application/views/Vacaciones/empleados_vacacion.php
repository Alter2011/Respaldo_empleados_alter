<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
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
        print_r($vacaciones1);
    }else{
        
        $vacaciones1="";
    }
    if(!empty($prestamo_interno)){
        $prestamo_interno1=json_encode($prestamo_interno);
        print_r($prestamo_interno1);
    }else{
        $prestamo_interno1="";
    }
    if(!empty($prestamo_per)){
        $prestamo_per1=json_encode($prestamo_per);
        print_r($prestamo_per1);
    }else{
        $prestamo_per1="";
    }
    if(!empty($anticipo)){
        $anticipo1=json_encode($anticipo);
         print_r($anticipo1);
    }else{
        $anticipo1="";
    }
    if(!empty($descuenta_herramienta)){
        $descuenta_herramienta1=json_encode($descuenta_herramienta);
         print_r($descuenta_herramienta1);
    }else{
        $descuenta_herramienta1="";
    }
    if(!empty($orden_descuento)){
        $orden_descuento1=json_encode($orden_descuento);
        print_r($orden_descuento1);
    }else{
        $orden_descuento1="";
    }
    if(!empty($prestamos_siga)){
        $prestamos_siga1=json_encode($prestamos_siga);
         print_r($prestamos_siga1);
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
            <!-- <?php if($validar_aprobar == 1 && !empty($vacacion_guardar)){ ?>
            <div class="col-sm-3" style="text-align: center;">
                <a class="btn btn-success" id="btn_bienes" data-toggle="modal" ><span class="glyphicon glyphicon-check"></span> Aprobar</a><br><br>
            </div>
            <?php } ?> -->
        </div>
    </div>

    <div id="linea"></div><br><br>

    <div class=" col-sm-12 col-md-12 ">
        <table class="table table-striped table-dark"  style="font-size: 82%" >
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center; border-right:1px solid #969793;">Datos generales</th>
                    <th colspan="4" style="text-align: center; border-right:1px solid #969793;">Devengado</th>
                    <th colspan="3" style="text-align: center; border-right:1px solid #969793;">Descuentos ley</th>
                    <th colspan="4" style="text-align: center; border-right:1px solid #969793;">Otros descuentos</th>
                    <th rowspan="4" style="text-align:center;border-right:1px solid #969793;">Total pagar<br>($)</th>
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
                  
                   for($i=0; $i < count($vacaciones); $i++){                      
                    if($vacaciones[$i]->guardado == 1){
                        $guardado = 'Si';
                    }else{
                        $guardado = 'No';
                    }
                    echo "<tr>";
                    echo "<td style='text-align: left'>".$guardado."</td>";
                    echo "<td style='text-align: left'>".$vacaciones[$i]->agencia."</td>";
                    echo "<td style='text-align: left'>".$vacaciones[$i]->nombre_empresa."</td>";
                    echo "<td style='text-align: left;'>".$vacaciones[$i]->empleado."</td>";
                    echo "<td style='text-align: left;'>".date_format(date_create($vacaciones[$i]->fecha_aplicar),"Y/m/d")."</td>";
                    echo "<td style='text-align: left; border-right:1px solid #969793;'>".date_format(date_create($vacaciones[$i]->fecha_final),"Y/m/d")."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->sueldo_quin,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->comisiones,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->prima,2)."</td>";
                    echo "<td style='text-align: right;  border-right:1px solid #969793;'>".number_format($vacaciones[$i]->total_pagar,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->isss,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->afp,2)."</td>";
                    echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacaciones[$i]->renta,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->interno,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->personal,2)."</td>";
                    echo "<td style='text-align: right'>".number_format($vacaciones[$i]->orden_descuento,2)."</td>";;
                    echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacaciones[$i]->anticipos,2)."</td>";
                    echo "<td style='text-align: right; border-right:1px solid #969793;'>".number_format($vacaciones[$i]->a_pagar,2)."</td>";

                    // WM21032023 se agrego boton individual para ingresar la vacacion del empleado solo si no tiene las vacaciones guardadas
                    if($vacaciones[$i]->guardado == 0){
                        echo "<td style='text-align: right'><a class='btn btn-success' id='btn_guardar_uno' href='#' onclick='guardar(this)'><span class='glyphicon glyphicon-check'></span></a></td>";   
                    }else{
                        echo "<td style='text-align: right'><a class='btn btn-danger' id='btn_revertir' href='#' onclick='revertir(this)'><i class='bi bi-person-fill-x'></i></a></td>";  
                    }
                   echo "<td><input type='hidden' id='id_contrato' value='".$vacaciones[$i]->id_contrato."'></input>";
                    
                    //WM21032023 se agregaron los td para obtener los datos a ocupar en guardar 
                    if($vacaciones[$i]->guardado == 0){
                        echo "<td><input type='hidden' id='comision' value='".$vacaciones[$i]->comisiones."'></input><input type='hidden' id='cumple' value='".$vacaciones[$i]->fecha_cumple."'></input><input type='hidden' id='id_empleado' value='".$vacaciones[$i]->id_empleado."'></input><input type='hidden' id='id_agencia' value='".$vacaciones[$i]->id_agencia."'></input></td>";
                    }
                    
                   
                    echo "</tr>";

                    $total_sueldo_quin+=$vacaciones[$i]->sueldo_quin;
                    $total_comision+=$vacaciones[$i]->comisiones;
                    $total_prima+=$vacaciones[$i]->prima;
                    $total_pagar+=$vacaciones[$i]->total_pagar;
                    $total_isss+=$vacaciones[$i]->isss;
                    $total_afp+=$vacaciones[$i]->afp;
                    $total_isr+=$vacaciones[$i]->renta;
                    $total_interno+=$vacaciones[$i]->interno;
                    $total_personal+=$vacaciones[$i]->personal;
                    $total_orden_desc+=$vacaciones[$i]->orden_descuento;
                    $total_anticipo+=$vacaciones[$i]->anticipos;
                    //$total_faltante+=$vacacion->descuentos_faltantes;
                    $total_a_pagar+=$vacaciones[$i]->a_pagar;
                    
                 
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
                   <td style='text-align: right;border-right:1px solid #969793;'><strong><?= number_format($total_a_pagar, 2, '.', ',') ?></strong></td>
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
                    <input type='hidden' name='checked' id='cheked' value='<?php echo $prestamos_siga1 ?>' class="form-control" readonly>


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

    // WM23032023 funcion para guardar individualmente las vacaciones 
    function guardar(btn){
        // obteniendo datos de la fila de la tabla y los hidden
        var fila = btn.closest("tr");
        var id_contrato = fila.querySelector("#id_contrato").value;
        var comision = fila.querySelector("#comision").value;
        var cumple = fila.querySelector("#cumple").value;
        var id_empleado = fila.querySelector("#id_empleado").value;
        var id_agencia = fila.querySelector("#id_agencia").value;

        // llenando arreglo para enviar datos de vacaciones
        var datos_fila_vacacion = {
            "id_contrato": id_contrato,
            "comision": comision,
            "cumple": cumple,
            "fecha_aplicar": fila.cells[4].textContent.trim(),
            "bono": fila.cells[7].textContent.trim(),
            "prima": fila.cells[8].textContent.trim(),
            "isss": fila.cells[10].textContent.trim(),
            "afp": fila.cells[11].textContent.trim(),
            "isr": fila.cells[12].textContent.trim(),
            "prestamo_interno": fila.cells[13].textContent.trim(),
            "prestamo_personal": fila.cells[14].textContent.trim(),
            "Orden_descuento": fila.cells[15].textContent.trim(),
            "anticipo": fila.cells[16].textContent.trim(),
            "cantidad_pagar": fila.cells[17].textContent.trim(),
            "id_empleado": id_empleado,
            "id_agencia": id_agencia,
            "fecha_fin": fila.cells[5].textContent.trim(),
        };
        console.log(datos_fila_vacacion)

         // traendo data de arreglos para asociarlo con el id_empleado
         var prestamo_interno = <?php echo json_encode($prestamo_interno) ?>;
         var prestamo_personal = <?php echo json_encode($prestamo_per) ?>;
         var anticipo = <?php echo json_encode($anticipo) ?>;
         var descuenta_herramienta = <?php echo json_encode($descuenta_herramienta) ?>;
         var orden_descuento = <?php echo json_encode($orden_descuento) ?>;
         var prestamo_siga = <?php echo json_encode($prestamos_siga) ?>;
         
         // inicio de if para comprobar si hay prestamos interno
         if(prestamo_interno !=  null){
            var dato_prestamo_interno = prestamo_interno.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_prestamo_interno = 0; 
         }
         // fin de if

         // inicio de if para comprobar si hay prestamos personales
         if(prestamo_personal !=  null){
            var dato_prestamo_personal = prestamo_personal.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_prestamo_personal = 0; 
         }
         // fin del if

         // inicio de if para comprobar si hay anticipo
         if(anticipo !=  null){
            var dato_anticipo = anticipo.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_anticipo = 0; 
         }
         // fin del if

         // inicio de if para comprobar si hay descuento de herramientas
         if(descuenta_herramienta !=  null){
            var dato_descuenta_herramienta = descuenta_herramienta.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_descuenta_herramienta = 0; 
         }
         // fin del if

         // inicio de if para comprobar si tiene ordenes de descuento
         if(orden_descuento !=  null){
            var dato_orden_descuento = orden_descuento.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_orden_descuento = 0; 
         }
         // fin del if

         // inicio de if para comprobar si hay prestamos del siga
         if(prestamo_siga != null){
            var dato_prestamo_siga = prestamo_siga.find(item => item.id_empleado === id_empleado);
         }else{
            var dato_prestamo_siga = 0;
         }
         // fin del if

         $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Vacaciones/guardar_vacaciones_uno')?>",
                    dataType : "JSON",
                    data : {datos_fila_vacacion:datos_fila_vacacion,dato_prestamo_interno:dato_prestamo_interno,dato_prestamo_personal:dato_prestamo_personal,dato_anticipo:dato_anticipo,dato_descuenta_herramienta:dato_descuenta_herramienta,dato_orden_descuento:dato_orden_descuento,dato_prestamo_siga:dato_prestamo_siga},
                    success: function(data){
                        console.log(data)
                         if(data == null){
                            Swal.fire("Error!", data, "error");
                         }else{
                            Swal.fire(data,'','success')
                            .then(() => {
                                // Aquí se recarga la pagina
                                location.reload();
                            });  
                    }
                }
         });


    }

    // WM23032023 funcion para reversion de las vacaciones
    function revertir(btn){
        // obteniendo datos de la fila de la tabla y los hidden
        var fila = btn.closest("tr");    
        var id_contrato = fila.querySelector("#id_contrato").value;
        var fecha_aplicar = fila.cells[4].textContent.trim();

        // traendo array para saber si tiene descuento de herrramientas 
        var descuenta_herramienta = <?php echo json_encode($descuenta_herramienta) ?>;
        var dato_hermaniemtas = 0;

        // inicio de if para comprobar si hay descuento de herramientas
         if(descuenta_herramienta !=  null){
            var dato_descuenta_herramienta = descuenta_herramienta.find(item => item.id_empleado === id_empleado);
            dato_hermaniemtas = 1;
         }
         // fin del if

        
        $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Vacaciones/revertir_vacaciones')?>",
                    dataType : "JSON",
                    data : {id_contrato:id_contrato, fecha_aplicar:fecha_aplicar,dato_hermaniemtas:dato_hermaniemtas},
                    success: function(data){
                        if(data.length != null){
                            Swal.fire("Error!", data, "error");
                        }else{
                            Swal.fire("Revertido correctamente",'','error')
                            .then(() => {
                                // Aquí se recarga la pagina
                                location.reload();
                            });
                        }  
                    
                    }
        });
    }

</script>