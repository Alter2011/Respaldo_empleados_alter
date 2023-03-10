<style type="text/css">
    @media print{
        #contenido{
            margin-top: 5%;
            margin-left: 6%;
            margin-right: 6%; 
        }
        #myEntrada{
            margin-bottom: 15%;
        }

        #texto_entrada{
            font-size: 12px;
        }
        #fecha{
            font-size: 12px;
        }
        #empresa{
            font-size: 12px;
        }
        #mes{
            font-size: 12px;
        }
        #presente{
            font-size: 12px;
        }
        #negrita{
            font-size: 12px;
        }
    }

    .crear{
        margin-bottom: 3%;
    }
</style>
        <div class="col-sm-10">
            <div class="text-center well text-white blue ocultar">
                <h2>Prestamos Personales Para Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel" id="contenido">
                    <div class="panel-body">
                    <?php if($reportes == 1 || $Agregar==1){ ?>    
                    <ul class="nav nav-tabs ocultar">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Ingreso de Prestamo</a></li>
                        <?php if($reportes == 1){ ?> 
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Reporte salida</a></li>
                        <li><a data-toggle="tab" href="#menu2" id="pag3">Reporte entrada</a></li>
                        <li><a data-toggle="tab" href="#menu3" id="pag4">Reintegro de préstamo</a></li>
                        <?php } ?>
                        <?php if($Agregar == 1){ ?> 
                        <li><a data-toggle="tab" href="#menu4" id="pag5">Calculadora</a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                <?php if($ver==1) { ?>
                                     <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_prestamo" id="agencia_prestamo" class="form-control">
                                             <?php
                                                $i=0;
                                                foreach($agencia as $a){
                                            ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php }else{ ?>
                                    <input type="hidden" name="agencia_prestamo" id="agencia_prestamo" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
                                <?php } ?>
                                    <input type="hidden" name="perfin_user" id="perfin_user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>
                                    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                                </div>
                            </div>
                        </nav>
                        <table class="table table-bordered" id="mydata">
                            <thead>
                                <tr class="success">
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>

                        </div>
                        <div id="menu1" class="tab-pane fade"><br>

                        <div class="form-row ocultar" id="reporte3">
                            <div class="form-group col-md-3">
                                <label for="inputState">Mes de Prestamo</label>
                                <input type="month" class="form-control" id="mes_reporte" name="mes_reporte" value="<?php echo date('Y-m')?>">
                            </div>
                        </div>

                        <div class="form-row ocultar" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center>
                                    <a class="btn btn-success crear ocultar" id="btn_permiso" style="margin-top: 22px;"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
                                </center>
                            </div>
                        </div>
                        

                            <table class="table table-bordered" id="myReporte">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empresa</th>      
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Empleado</th>
                                        <th style="text-align:center;">Cargo</th>
                                        <th style="text-align:center;">Fecha Otorgado</th>
                                        <th style="text-align:center;">Desembolso</th>
                                        <th style="text-align:center;">M. prestamo</th>
                                        <th style="text-align:center;">Ref</th>
                                        <th style="text-align:center;">Desembolsado</th>
                                    </tr>
                                </thead>
                                <tbody id="reporte">

                                </tbody>
                                
                            </table>

                            <table class="table" id="myReporte">
                                <tbody id="subtotales">

                                </tbody>
                                <tfoot id="totales">
                                    
                                </tfoot>
                            </table><br><br><br>

                            <div class="row">
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span>F_______________________</span></div>
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span>F_______________________</span></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span id="recibe"></span></div>
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span>Licda. Iris Mayen de Alvarado</span></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span>Recibe</span></div>
                                <div class="col-sm-2"><span></span></div>
                                <div class="col-sm-4"><span>Autorizante</span></div>
                            </div>

                        </div>
                        <div id="menu2" class="tab-pane fade"><br><br>

                            <div class="row">
                                <div class="form-group col-md-3 ocultar">
                                    <label for="inputState">Empresa</label>
                                    <select class="form-control" name="empresa_entrada" id="empresa_entrada" class="form-control">
                                        <?php
                                            $i=0;
                                            foreach($empresa as $a){
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                                $i++;
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-row ocultar" id="reporte3">
                                    <div class="form-group col-md-3">
                                        <label for="inputState">Mes de Prestamo</label>
                                        <input type="month" class="form-control" id="mes_entrada" name="mes_entrada" value="<?php echo date('Y-m')?>">
                                    </div>
                                </div>

                                <div class="form-row ocultar" id="reporte5">
                                    <div class="form-group col-md-2">
                                        <center><a id="filtrar" class="btn btn-primary item_entrada" style="margin-top: 23px;">Aceptar</a></center>
                                    </div>
                                </div>

                                <div class="form-row" id="reporte5">
                                    <div class="form-group col-md-2">
                                        <center>
                                            <a class="btn btn-success crear ocultar" id="btn_permiso" style="margin-top: 22px;"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
                                        </center>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-4"><span id="fecha"></span></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-4"><b id="empresa"></b></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-8" id="presente">Presente. <b id="negrita">Asunto: Coutas de Préstamos de Empleados</b></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-12" id="texto_entrada" style="text-align: justify;"></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-4"><b id="mes"></b></div>
                            </div>
                            <div class="row" id="tabla_entrada">
                                
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-sm-4"><b></b></div>
                                <div class="col-sm-4"><center><b>Iris Indira Mayen de Alvarado</b></center></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-4"><b></b></div>
                                <div class="col-sm-4"><center><b>LA ACREADORA</b></center></div>
                            </div><br>
                        </div>

                        <div id="menu3" class="tab-pane fade"><br>

                            <a href="#" class="btn btn-primary btn-sm item_reintegro" data-toggle="modal" data-target="#Modal_Reintegro"><span class="glyphicon glyphicon-plus"></span>Añadir Reintegro</a><br><br>

                            <div class="form-row ocultar" id="reporte3">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Mes de Reintegro</label>
                                    <input type="month" class="form-control" id="mes_reintegro" name="mes_reintegro" value="<?php echo date('Y-m')?>">
                                </div>
                            </div>

                            <div class="form-row ocultar" id="reporte5">
                                <div class="form-group col-md-2">
                                    <center><a id="filtrar" class="btn btn-primary item_reint" style="margin-top: 23px;">Aceptar</a></center>
                                </div>
                            </div>

                            <table class="table table-bordered" id="myReintegro">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Fecha</th>      
                                        <th style="text-align:center;">Numero de Cheque</th>
                                        <th style="text-align:center;">Banco</th>
                                        <th style="text-align:center;">Cantidad</th>
                                        <th style="text-align:center;">Emitido a Nombre de</th>
                                        <th style="text-align:center;">Remesado en Cuenta</th>
                                        <th style="text-align:center;">Referencia</th>
                                        <th style="text-align:center;">Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="reintegro">

                                </tbody>
                                <tfoot id="total_reintegro">
                                    
                                </tfoot>
                                
                            </table>

                        </div>

                        <div id="menu4" class="tab-pane fade"><br>
                            <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipo de Prestamo:</label>
                            <div class="col-md-6">
                                <select class="form-control" name="prestamo_calculadora" id="prestamo_calculadora" class="form-control prestamoSe">
                                    <?php
                                    $i=0;
                                    if($prestamos != null){
                                        foreach($prestamos as $a){
                                    ?>
                                        <option id="<?= ($prestamos[$i]->id_prest_personales);?>"><?php echo($prestamos[$i]->nombre_tipos);?></option>
                                    <?php
                                        $i++;
                                    }
                                }else{ ?>

                                    <option value=NULL>No existen tipos de prestamos</option>

                                <?php } ?>
                                
                                </select>
                                <div id="validacion_calculadora" style="color:red"></div>
                            </div>

                             <div class="col-md-3">
                                 <a class="btn btn-primary" id="calcular"><span class="glyphicon glyphicon-phone"></span> Calcular</a>
                                 <a class="btn btn-danger" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</a>
                             </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cantidad del Prestamo $:</label>
                            <div class="col-md-6">
                                <input type="text" name="cantidad_calculadora" id="cantidad_calculadora" class="form-control prestamo" placeholder="0.00">
                                <div id="validacion2_calculadora" style="color:red"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cantidad de Quincenas a Pagar:</label>
                            <div class="col-md-6">
                                <input type="number" name="quincena_calculadora" id="quincena_calculadora" class="form-control prestamo" placeholder="00">
                                <div id="validacio3_calculadora" style="color:red"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cuota $:</label>
                            <div class="col-md-6">
                                <input type="number" name="couta_calculadora" id="couta_calculadora" class="form-control prestamo" placeholder="00" readonly>
                            </div>
                        </div>

                        </div>

                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>
<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Prestamo Personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <center><div id="validacion_user" style="color:red"></div></center>
                
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_contrato" id="code_contrato" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo de Prestamo:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_prestamo" id="tipo_prestamo" class="form-control prestamoSe">
                            <?php
                            $i=0;
                                foreach($prestamos as $a){
                            ?>
                                <option id="<?= ($prestamos[$i]->id_prest_personales);?>"><?php echo($prestamos[$i]->nombre_tipos);?></option>
                            <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_prestamo" id="cantidad_prestamo" class="form-control prestamo" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad de Quincenas a Pagar:</label>
                    <div class="col-md-10">
                        <input type="number" name="tiempo_prestamo" id="tiempo_prestamo" class="form-control prestamo" placeholder="00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripcion del Prestamo:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control prestamo" id="descripcion_prestano" name="descripcion_prestano"></textarea>
                        <div id="validacion5" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrar" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            <!--Se utiliza para cuando se alguien que no sea admin pida una aprobacion de prestamos-->
            <center><div id="validacion3" style="color:red"></div>
            <button type="button" type="submit" id="btn_solicitud" class="btn btn-success solicitud" style="display: none;">Hacer Solicitud</button>
            <button type="button" class="btn btn-danger cancelar" id="btn_cancelar" style="display: none;">Cancelar</button></center>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL REINTEGRO -->
<form>
    <div class="modal fade" id="Modal_Reintegro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Reintegros</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <center><div id="validacion_user" style="color:red"></div></center>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha:</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_reintegro" id="fecha_reintegro" class="form-control prestamo">
                        <div id="validacion_reintegro" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Numero de cheque:</label>
                    <div class="col-md-9">
                        <input type="text" name="num_reintegro" id="num_reintegro" class="form-control prestamo" placeholder="0000123456789">
                        <div id="validacion_reintegro2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Banco:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="banco_reintegro" id="banco_reintegro" class="form-control">
                            <?php
                                $i=0;
                                foreach($banco as $a){
                            ?>
                                <option id="<?= ($banco[$i]->id_banco);?>"><?php echo($banco[$i]->nombre_banco);?></option>
                            <?php
                                    $i++;
                                }
                            ?>
                        </select>
                        <div id="validacion_reintegro3" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Cantidad:</label>
                    <div class="col-md-9">
                        <input type="texte" name="cantidad_reintegro" id="cantidad_reintegro" class="form-control prestamo" placeholder="00">
                        <div id="validacion_reintegro4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Empresa:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="empresa_reintegro" id="empresa_reintegro" class="form-control">
                            <?php
                                $i=0;
                                foreach($empresa as $a){
                            ?>
                                <option id="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                            <?php
                                    $i++;
                                }
                            ?>
                        </select>
                        <div id="validacion_reintegro5" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Remesado:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="remesado_reintegro" id="remesado_reintegro" class="form-control">
                            <?php
                                $i=0;
                                foreach($banco as $a){
                            ?>
                                <option id="<?= ($banco[$i]->id_banco);?>"><?php echo($banco[$i]->nombre_banco);?> <?php echo($banco[$i]->numero_cuenta);?></option>
                            <?php
                                    $i++;
                                }
                            ?>
                        </select>
                        <div id="validacion_reintegro6" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Referencia:</label>
                    <div class="col-md-9">
                        <input type="text" name="referencia_reintegro" id="referencia_reintegro" class="form-control prestamo" placeholder="00">
                        <div id="validacion_reintegro7" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrar" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_reintegro" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL REINTEGRO-->

<!--Modal_Eliminar-->
<form>
  <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="text-align: center;">
          <h4 class="modal-title" id="exampleModalLabel">Cancelacion de Reintegro</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <strong>¿Seguro que desea cancelar esta reintegro?</strong><br><br>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="code_eliminar" id="code_eliminar" class="form-control" readonly>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!--END Modal_Eliminar-->


<!-- Llamar JavaScript -->

<script type="text/javascript">
    $(document).ready(function(){
       
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_prestamo').change(function(){
            show_data();
        });
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
            $('#show_data').empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/empleados_data')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('#show_data').append(
                        '<tr>'+
                            '<td>'+registro.nombre+'</td>'+//Agencia
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//estado
                            '<td>'+registro.cargo+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                //'<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'">Agregar Prestamo</a><?php } ?>'+
                                ' <?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/PrestamosPersonales/verPrestamos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                    
                            '</td>'+
                        '</tr>'
                        );
                   });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#mydata').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "order": [[ 4, "asc" ]],
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };

        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacion3').innerHTML = '';
            document.getElementById('validacion4').innerHTML = '';
            document.getElementById('validacion5').innerHTML = '';

           $('[name="code_contrato"]').val(code);
            $('[name="cantidad_prestamo"]').val("");
            $('[name="tiempo_prestamo"]').val("");
            $("#tipo_prestamo option:first").attr('selected','selected'); 
            $(".solicitud").css("display", "none");
            $(".cancelar").css("display", "none");
            $("#btn_save").show();
            $(".cerrar").show();
            $("#tipo_prestamo").prop('disabled', false);
            $(".prestamo").prop("readonly",false);
            $(".close").show();
            $('#Modal_add').modal('show');
            
        });
       
         //Save Prestamos Personales
         $('#btn_save').on('click',function(){
            var code = $('#code_contrato').val();
            var cantidad_prestamo = $('#cantidad_prestamo').val();
            var tiempo_prestamo = $('#tiempo_prestamo').val();
            var tipo_prestamo = $('#tipo_prestamo').children(":selected").attr("id");
            var descripcion_prestano = $('#descripcion_prestano').val();
            var autorizado = $('#user').val();
            var perfil = $('#perfin_user').val();

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/insertPrestamos')?>",
                dataType : "JSON",
                data : {code:code,cantidad_prestamo:cantidad_prestamo,tiempo_prestamo:tiempo_prestamo,tipo_prestamo:tipo_prestamo,descripcion_prestano:descripcion_prestano,autorizado:autorizado,perfil:perfil},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                         $('[name="code_contrato"]').val("");
                         $('[name="cantidad_prestamo"]').val("");
                         $('[name="tiempo_prestamo"]').val("");
                         $('[name="descripcion_prestano"]').val("");
                         $("#tipo_prestamo option:first").attr('selected','selected'); 
                         
                         alert("El ingreso se Realizo Correctamente");
                         $(".modal:visible").modal('toggle');
                        
                         this.disabled=false;
                         show_area();
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Pretamo";
                            }else if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Pretamo de Forma Correcta(0.00)";
                            }else if(data[i] == 6){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Pretamo debe de ser Mayor a Cero";
                            }else if(data[i] == 10){
                                document.getElementById('validacion').innerHTML += "La cantidad del Prestamo tiene que ser mayor que el techo de los anticipos Corrientes";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Timpo a Pretamo";
                            }else if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML += "Solo se Aceptan Numeros Enteros en el Tiempo a Pagar y Mayores a Cero";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion4').innerHTML += "Debe de agregar un tipo de prestamo";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion5').innerHTML += "Debe Ingresar una Descripcion del Prestamo";

                            }else if(data[i] == 8){
                                document.getElementById('validacion5').innerHTML += "Solo puede ingresar un maximo de 500 caracteres(Cuentan los espacios)";

                            }
                            if(data[i] == 9){
                                document.getElementById('validacion3').innerHTML = "Usted no Tiene Los permisos necesarios para aprobar este prestamos<br>¿Desea mandar una solicitud para Aprobacion?<br>";
                                $(".solicitud").show();
                                $(".cancelar").show();
                                $("#btn_save").hide();
                                $(".cerrar").hide();
                                $(".prestamo").prop("readonly",true);
                                $("#tipo_prestamo").prop('disabled', true);
                                $(".close").hide();
                            }
                        }
                    }
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });

        //Se manda la solicitud
        $('#btn_solicitud').on('click',function(){
            var code = $('#code_contrato').val();
            var cantidad_prestamo = $('#cantidad_prestamo').val();
            var tiempo_prestamo = $('#tiempo_prestamo').val();
            var tipo_prestamo = $('#tipo_prestamo').children(":selected").attr("id");
            var descripcion_prestano = $('#descripcion_prestano').val();
            var autorizado = $('#user').val();

            var confirmar = confirm("¿Desea Solicitar este Prestamo Personal?");
            if(confirmar){
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/crearSolicitud')?>",
                dataType : "JSON",
                data : {code:code,cantidad_prestamo:cantidad_prestamo,tiempo_prestamo:tiempo_prestamo,tipo_prestamo:tipo_prestamo,autorizado:autorizado,descripcion_prestano:descripcion_prestano},
                success: function(data){
                    console.log(data);
                    
                    document.getElementById('validacion3').innerHTML = '';
                    $('[name="code_contrato"]').val("");
                    $('[name="cantidad_prestamo"]').val("");
                    $('[name="tiempo_prestamo"]').val("");
                    $('[name="descripcion_prestano"]').val("");
                    $("#tipo_prestamo option:first").attr('selected','selected'); 
                    
                    alert("La solicitud se Realizo Correctamente");
                    $(".modal:visible").modal('toggle');
                        
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
        });

        //Se cancela la solicitud de pretsmo
        $('#btn_cancelar').on('click',function(){
            var confirmar = confirm("¿Desea Cancelar esta Solicitud de Prestamo Personal?");

            if(confirmar){
                $(".modal:visible").modal('toggle');
            }
        });

        $('#pag2').on('click',function(){
            reporte();
        });

        $('.item_filtrar').on('click',function(){
            reporte();
        });

        function reporte(){
            //Se usa para destruir la tabla 
            $('#myReporte').dataTable().fnDestroy();
            $('#reporte').empty();
            $('#subtotales').empty();
            $('#totales').empty();

            var texto = "";
            var totales = 0;
            var mes_reporte = $('#mes_reporte').val();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('PrestamosPersonales/reporte_salida')?>',
                async : false,
                dataType : 'JSON',
                data : {mes_reporte:mes_reporte},
                success : function(data){
                    console.log(data);
                   $.each(data.datos,function(key, registro){
                    if(registro.tipo_desembolso == 1){
                        texto = "Cheque";
                    }else if(registro.tipo_desembolso == 2){
                        texto = "Efectivo";
                    }else if(registro.tipo_desembolso == 3){
                        texto = "Transferencia";
                    }
                    $('#reporte').append(
                        '<tr>'+
                            '<td>'+registro.nombre_empresa+'</td>'+
                            '<td>'+registro.agencia+'</td>'+
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                            '<td>'+registro.cargo+'</td>'+
                            '<td>'+registro.fecha_desembolso+'</td>'+
                            '<td>'+texto+'</td>'+
                            '<td>$'+parseFloat(registro.monto_otorgado).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.refinanciamiento).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.otorgado).toFixed(2)+'</td>'+
                                
                        '</tr>'
                        );
                        //NO13022023 cambios 
                    
                   });
                   //inicia
                   $.each(data.datos_siga,function(key, registro){
                    if(registro.tipo_desembolso == 1){
                        texto = "Cheque";
                    }else if(registro.tipo_desembolso == 2){
                        texto = "Efectivo";
                    }else if(registro.tipo_desembolso == 3){
                        texto = "Transferencia";
                    }
                    $('#reporte').append(
                        '<tr>'+
                            '<td>'+registro.nombre_empresa+'</td>'+
                            '<td>'+registro.agencia+'</td>'+
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                            '<td>'+registro.cargo+'</td>'+
                            '<td>'+registro.fecha_desembolso+'</td>'+
                            '<td>'+texto+'</td>'+
                            '<td>$'+parseFloat(registro.monto).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.refinanciamiento).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.otorgado).toFixed(2)+'</td>'+
                                
                        '</tr>'
                        );
                        
                    
                   });
                   //finaliza
                   $.each(data.empresa,function(key, registro){
                    totales += parseFloat(registro.total);
                    $('#subtotales').append(
                        '<tr>'+
                            '<td><b>Subtotal</b></td>'+
                            '<td colspan="3" style="text-align:left;"><b>'+registro.empresa+'</b></td>'+
                            '<td colspan="3"></b>$'+parseFloat(registro.total).toFixed(2)+'</b></td>'+
                        '</tr>'
                        );
                   });
                   //NO14022023 inicia cambio, 
                   $.each(data.empresa_SIGA,function(key, registro){
                    totales += parseFloat(registro.total);
                    $('#subtotales').append(
                        '<tr>'+
                            '<td><b>Subtotal</b></td>'+
                            '<td colspan="3" style="text-align:left;"><b>'+registro.empresa+'</b></td>'+
                            '<td colspan="3"></b>$'+parseFloat(registro.total).toFixed(2)+'</b></td>'+
                        '</tr>'
                        );
                   });
                   //finaliza cambio

                   $('#totales').append(
                        '<tr class="success">'+
                            '<td><b>Total</b></td>'+
                            '<td colspan="3" style="text-align:center;"><b></b></td>'+
                            '<td colspan="3"></b>$'+totales.toFixed(2)+'</b></td>'+
                        '</tr>'
                    );
                   document.getElementById('recibe').innerHTML = data.recibe[0].nombre+" "+data.recibe[0].apellido;
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

        };

        $('.crear').click(function(){
            $('.ocultar').hide();
            window.print();
            $('.ocultar').show();
        });

        $('#pag3').on('click',function(){
            reporte_entrada();
        });

        $('.item_entrada').on('click',function(){
            reporte_entrada();
        });

        function reporte_entrada(){
            var empresa = $('#empresa_entrada').children(":selected").attr("id");
            var mes_entrada = $('#mes_entrada').val();
            var texto = '';
            var i = 1, j = 0, m = 0, n = 0;
            var subtotalq1 = 0, subtotalq2 = 0, total = 0;
            
            $('#myEntrada').dataTable().fnDestroy();
            $('#texto_entrada').empty();
            //$('#total_entrada').empty();
             document.getElementById('tabla_entrada').innerHTML = "";
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/reporte_entrada')?>",
                dataType : "JSON",
                data : {empresa:empresa,mes_entrada:mes_entrada},
                success: function(data){
                    console.log(data);
                    texto = 'De nuestra consideración: Por medio de la presente solicitamos el pago de las coutas retenidas a los empleados, correspondientes al mes '+data.mes+' <b id="negrita">'+data.total_letras+'</b>($'+parseFloat(data.total).toFixed(2)+') por los fondos dados en préstamos personales a los emplrados de la empresa. Sírvase encontrar a continuación el detalle de las coutas correspondienteal referido mes';
                    document.getElementById('fecha').innerHTML = data.fecha;
                    document.getElementById('empresa').innerHTML = data.empresa;
                    document.getElementById('texto_entrada').innerHTML = texto;
                    document.getElementById('mes').innerHTML = data.mes2;
                    n = data.cuota.length;
                    $.each(data.cuota,function(key, registro){
                        subtotalq1 += parseFloat(registro.pago1);
                        subtotalq2 += parseFloat(registro.pago2);
                        total += parseFloat(registro.total);

                        if(j == 0){
                            m++;
                            $('#tabla_entrada').append(
                                
                                '<table class="table table-bordered" id="myEntrada" style="margin-top:4%;">'+
                                '<thead>'+
                                '<tr class="success">'+
                                '<th style="text-align:center;"><b></b></th>'+
                                '<th style="text-align:center;">Empleado</th>'+
                                '<th style="text-align:center;">Agencia</th>'+
                                '<th style="text-align:center;">1° Q</th>'+
                                '<th style="text-align:center;">2° Q</th>'+
                                '<th style="text-align:center;">Total</th>'+
                                '<th style="text-align:center;">Observaciones</th>'+
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="entrada'+m+'">'+
                                '</tbody>'+
                                '<tfoot id="total_entrada'+m+'">'+
                                '</tfoot>'
                            );
                        }
                        $('#entrada'+m).append(
                            '<tr>'+
                                '<td>'+i+'</td>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>$'+parseFloat(registro.pago1).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(registro.pago2).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+
                                '<td>'+registro.descripcion+'</td>'+
                            '</tr>'
                        );
                        i++;
                        j++;

                        if(j == 22 && j < n){
                            $('#total_entrada'+m).append(
                                '<tr>'+
                                    '<td><b></b></td>'+
                                    '<td><b>SUB TOTAL</b></td>'+
                                    '<td><b></b></td>'+
                                    '<td><b>$'+subtotalq1.toFixed(2)+'</b></td>'+
                                    '<td><b>$'+subtotalq2.toFixed(2)+'</b></td>'+
                                    '<td><b>$'+total.toFixed(2)+'</b></td>'+
                                    '<td><b></b></td>'+
                                '</tr>'
                            );
                            $('#tabla_entrada'+m).append(
                                '</table>'+
                                '</div>'+
                                '<div style="page-break-before: always;">'
                            );

                            j = 0;
                            subtotalq1 = 0;
                            subtotalq2 = 0;
                            total = 0;
                        }
                        
                    });

                    $('#total_entrada'+m).append(
                        '<tr>'+
                            '<td><b></b></td>'+
                            '<td><b>SUB TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b>$'+subtotalq1.toFixed(2)+'</b></td>'+
                            '<td><b>$'+subtotalq2.toFixed(2)+'</b></td>'+
                            '<td><b>$'+total.toFixed(2)+'</b></td>'+
                            '<td><b></b></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><b></b></td>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b>$'+parseFloat(data.totalQ1).toFixed(2)+'</b></td>'+
                            '<td><b>$'+parseFloat(data.totalQ2).toFixed(2)+'</b></td>'+
                            '<td><b>$'+parseFloat(data.total).toFixed(2)+'</b></td>'+
                            '<td><b></b></td>'+
                        '</tr>'
                    );

                    $('#myEntrada').dataTable({
                        "paging":false,
                        "bAutoWidth": false,
                        "bFilter": false,
                        "bInfo" : false

                    });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        };

        $('#pag4').on('click',function(){
            reintegros();
        });

        $('.item_reint').on('click',function(){
            reintegros();
        });

        function reintegros(){
            var mes_reintegro = $('#mes_reintegro').val();
            var total = 0;

            //Se usa para destruir la tabla 
            $('#myReintegro').dataTable().fnDestroy();
            $('#reintegro').empty();
            $('#total_reintegro').empty();

            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('PrestamosPersonales/showReintegro')?>',
                async : false,
                dataType : 'JSON',
                data : {mes_reintegro:mes_reintegro},
                success : function(data){
                    $.each(data,function(key, registro){
                        total += parseFloat(registro.cantidad);
                        $('#reintegro').append(
                            '<tr>'+
                                '<td>'+registro.fecha+'</td>'+
                                '<td>'+registro.num_cheque+'</td>'+
                                '<td>'+registro.nombre_banco+'</td>'+
                                '<td>$'+parseFloat(registro.cantidad).toFixed(2)+'</td>'+
                                '<td>'+registro.nombre_empresa+'</td>'+
                                '<td>'+registro.numero_cuenta+'</td>'+
                                '<td>'+registro.referencia+'</td>'+
                                '<td style="text-align:center;">'+
                                    '<a class="btn btn-danger btn-sm item_eliminar" data-toggle="modal" data-target="#Modal_Eliminar" title="Cancelar" onclick="cancelar(this)" data-codigo='+registro.id_reintegro+'>'+
                                    '<em class="glyphicon glyphicon-trash"></em>'+
                                    '</a>'+                                   
                                '</td>'+
                            '</tr>'
                        );
                   });

                    $('#total_reintegro').append(
                        '<tr>'+
                            '<td><b>Total Pagado</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td><b>$'+total.toFixed(2)+'</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td ><b></b></td>'+
                        '</tr>'
                    );

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#myReintegro').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "order": [[ 4, "asc" ]],
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };


        $('.item_reintegro').on('click',function(){
            var d = new Date();
            var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

            document.getElementById('validacion_reintegro').innerHTML = '';
            document.getElementById('validacion_reintegro2').innerHTML = '';
            document.getElementById('validacion_reintegro3').innerHTML = '';
            document.getElementById('validacion_reintegro4').innerHTML = '';
            document.getElementById('validacion_reintegro5').innerHTML = '';
            document.getElementById('validacion_reintegro6').innerHTML = '';
            document.getElementById('validacion_reintegro7').innerHTML = '';

            $('[name="fecha_reintegro"]').val(strDate);
            $('[name="num_reintegro"]').val("");
            $("#banco_reintegro option:first").attr('selected','selected');
            $('[name="cantidad_reintegro"]').val("");
            $("#empresa_reintegro option:first").attr('selected','selected');
            $("#remesado_reintegro option:first").attr('selected','selected');
            $('[name="referencia_reintegro"]').val("");
        });

        $('#btn_reintegro').on('click',function(){
            var fecha_reintegro = $('#fecha_reintegro').val();
            var num_reintegro = $('#num_reintegro').val();
            var banco_reintegro  = $('#banco_reintegro').children(":selected").attr("id");
            var cantidad_reintegro = $('#cantidad_reintegro').val();
            var empresa_reintegro  = $('#empresa_reintegro').children(":selected").attr("id");
            var remesado_reintegro  = $('#remesado_reintegro').children(":selected").attr("id");
            var referencia_reintegro = $('#referencia_reintegro').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/ingresar_reintegro')?>",
                dataType : "JSON",
                data : {fecha_reintegro:fecha_reintegro,num_reintegro:num_reintegro,banco_reintegro:banco_reintegro,cantidad_reintegro:cantidad_reintegro,empresa_reintegro:empresa_reintegro,remesado_reintegro:remesado_reintegro,referencia_reintegro:referencia_reintegro},
                success: function(data){
                    if(data==null){
                        document.getElementById('validacion_reintegro').innerHTML = '';
                        document.getElementById('validacion_reintegro2').innerHTML = '';
                        document.getElementById('validacion_reintegro3').innerHTML = '';
                        document.getElementById('validacion_reintegro4').innerHTML = '';
                        document.getElementById('validacion_reintegro5').innerHTML = '';
                        document.getElementById('validacion_reintegro6').innerHTML = '';
                        document.getElementById('validacion_reintegro7').innerHTML = '';

                        alert("Se ha ingresado con exito");
                        $("#Modal_Reintegro:visible").modal('toggle');
                        this.disabled=false;
                        reintegros();
                    }else{
                        document.getElementById('validacion_reintegro').innerHTML = '';
                        document.getElementById('validacion_reintegro2').innerHTML = '';
                        document.getElementById('validacion_reintegro3').innerHTML = '';
                        document.getElementById('validacion_reintegro4').innerHTML = '';
                        document.getElementById('validacion_reintegro5').innerHTML = '';
                        document.getElementById('validacion_reintegro6').innerHTML = '';
                        document.getElementById('validacion_reintegro7').innerHTML = '';
                       for(i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_reintegro').innerHTML += "Debe de ingresar la fecha de reintegro.";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion_reintegro2').innerHTML += "Debe de ingresar el numero de cheque.";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion_reintegro3').innerHTML += "Debe de ingresa un banco.";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion_reintegro4').innerHTML += "Debe de ingresar la cantidad.";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion_reintegro4').innerHTML += "Debe de ingresar la cantidad en forma correcta (0.00).";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion_reintegro5').innerHTML += "Debe de ingresar una empresa.";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion_reintegro6').innerHTML += "Debe de ingresa una remesa.";
                            }
                            if(data[i] == 8){
                                document.getElementById('validacion_reintegro7').innerHTML += "Debe de ingresa una referencia.";
                            }
                       }//fin for data.length
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });//fin de la funcion crear_banco
        
         //metodo para ingresar los dias de vacacion anticipada
        $('#btn_eliminar').on('click',function(){
            var code = $('#code_eliminar').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/cancelarReintegro')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $("#Modal_Eliminar:visible").modal('toggle');
                    reintegros();
                },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
                }
            });
            return false;
        });//fin de insercionde dias de vacacion anticipada

        //metodo para la calculadora de prestamos
        $('#calcular').on('click',function(){
            var prestamo_calculadora = $('#prestamo_calculadora').children(":selected").attr("id");
            var cantidad_calculadora = $('#cantidad_calculadora').val();
            var quincena_calculadora = $('#quincena_calculadora').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/calculadora')?>",
                dataType : "JSON",
                data : {prestamo_calculadora:prestamo_calculadora,cantidad_calculadora:cantidad_calculadora,quincena_calculadora:quincena_calculadora},
                success: function(data){
                    document.getElementById('validacion_calculadora').innerHTML = '';
                    document.getElementById('validacion2_calculadora').innerHTML = '';
                    document.getElementById('validacio3_calculadora').innerHTML = '';
                    if(data.validacion == null){
                        $('[name="couta_calculadora"]').val(data.cuota);
                    }else{
                        console.log(data);
                        for(i = 0; i <= data.validacion.length-1; i++){
                            if(data.validacion[i] == 1){
                                document.getElementById('validacion_calculadora').innerHTML += "Debe de ingresar el timpo a pretamo.";
                            }

                            if(data.validacion[i] == 2){
                                document.getElementById('validacion2_calculadora').innerHTML += "Debe de ingresar una cantidad.";
                            }else if(data.validacion[i] == 3){
                                document.getElementById('validacion2_calculadora').innerHTML += "Debe de ingresar la cantidad del pretamo de forma correcta(0.00).";
                            }else if(data.validacion[i] == 4){
                                document.getElementById('validacion2_calculadora').innerHTML += "La cantidad del pretamo debe de ser mayor a cero.";
                            }else if(data.validacion[i] == 5){
                                document.getElementById('validacion2_calculadora').innerHTML += "La cantidad del prestamo tiene que ser mayor que el techo de los anticipos corrientes.";
                            }

                            if(data.validacion[i] == 6){
                                document.getElementById('validacio3_calculadora').innerHTML += "Debe de ingresar una cantidad de quincenas.";
                            }else if(data.validacion[i] == 7){
                                document.getElementById('validacio3_calculadora').innerHTML += "Solo se aceptan numeros enteros en el tiempo a pagar.";
                            }else if(data.validacion[i] == 8){
                                document.getElementById('validacio3_calculadora').innerHTML += "La cantidad de quincenas debe de ser mayor a cero.";
                            }
                        }
                    }
                },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
                }
            });
            return false;
        });//fin metodo calcular

        $('#limpiar').on('click',function(){
            document.getElementById('validacion_calculadora').innerHTML = '';
            document.getElementById('validacion2_calculadora').innerHTML = '';
            document.getElementById('validacio3_calculadora').innerHTML = '';

            $('#prestamo_calculadora option:first-child').attr("selected", "selected");
            //$('#prestamo_calculadora option:first-child')

            $('[name="cantidad_calculadora"]').val('');
            $('[name="quincena_calculadora"]').val('');
            $('[name="couta_calculadora"]').val('');

        });

    });


    function cancelar(boton){
        var code = boton.dataset.codigo;
        $('[name="code_eliminar"]').val(code); 
    }
</script>
</body>

</html>