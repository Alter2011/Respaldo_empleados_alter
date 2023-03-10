<style type="text/css">
    .chbox{
        margin: 4px 5px 0px !important;
    }
    .chbox_cre{
        margin: 4px 5px 0px !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Aguinaldo/Liquidacion para Empleados</h2>
    </div>
    <div class="row">
        <button style="position: sticky; top: 95%; left: 95%; cursor: pointer; z-index: 1000;" id="button"  type="button" class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-down"></span></button>
        <button style="position: sticky; top: 95%; left: 90%; cursor: pointer; z-index: 1000;" id="button_up"  type="button" class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-up"></span></button>
        
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="enunciado_aprobar" style="color:blue; display: none;" class="alert alert-info aprobar" role="alert">
                        <b id="taprobar"></b>
                    </div>
                    <ul class="nav nav-tabs">
                        <?php if($generar == 1 || $revisar == 1){ ?>
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados</a></li>
                        <?php } ?>
                        <?php if($generar == 1){ ?>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Aguinaldo</a></li>
                        <li><a data-toggle="tab" href="#menu2" id="pag3">Liquidacion</a></li>
                        <?php } ?>
                        <?php if($reporteA == 1){ ?>
                        <li><a data-toggle="tab" href="#menu3" id="pag4">Montos Aguinaldo</a></li>
                        <li><a data-toggle="tab" href="#menu4" id="pag5">Montos Liquidacion</a></li>
                        <!-- nueva pestaña para retencion de pago pasivo -->
                        <li><a data-toggle="tab" href="#menu5" id="pag6">Retencion anuales</a></li>
                         <li><a data-toggle="tab" href="#menu6" id="pag7">Retencion credito empleado</a></li>
                         <!-- NO03012023 pestaña para mostra las personas con retencion -->
                         <li><a data-toggle="tab" href="#menu7" id="pag8">Retenciones aprobadas</a></li>
                        <?php } ?>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active"><br>

                            <form action="<?php echo base_url('index.php/Liquidacion/hojasAguinaldo/'); ?>"  method="post" >

                            <div class="col-sm-12">
                            <?php if($ver == 1){ ?>
                            <nav class="float-right">
                                    <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_aguinaldo" id="agencia_aguinaldo" class="form-control">
                                            <?php
                                                $i=0;
                                                foreach($agencia as $a){

                                                if($admin == 1){
                                            ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                            <?php

                                                }else if($admin == 0 && $agencia[$i]->id_agencia != 00){
                                            ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                            <?php
                                                }
                                                    $i++;
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                            </nav>
                        <?php }else{ ?>
                            <input type="hidden" name="agencia_aguinaldo" id="agencia_aguinaldo" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
                        <?php } ?>

                            <div class="form-group col-md-3">
                                <center>
                                    <button type="submit" class="btn btn-success item_filtrar" style="margin-top: 23px;">Hoja de Firmas</button>
                                </center>
                            </div>

                        </div>

                        </form>

                            <table class="table table-striped table-bordered" id="mydata">
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

                        </div><!--Fin <div id="home" class="tab-pane fade in active">-->

                        <div id="menu1" class="tab-pane fade"><br><br>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia:</label>
                                    <select class="form-control" name="agencia_agui" id="agencia_agui" class="form-control">
                                        <?php
                                            $i=0;
                                            foreach($agencia as $a){

                                            if($admin == 1){
                                        ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php

                                            }else if($admin == 0 && $agencia[$i]->id_agencia != 00){
                                        ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            }
                                                $i++;
                                            }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_agui" id="anio_agui" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <center>
                                        <a id="filtrar" class="btn btn-success item_filtrar" style="margin-top: 23px;">
                                            <i class="fas fa-clipboard-list"></i> Generar Aguinaldo
                                        </a>
                                    </center>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" id="myaguinaldo">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" colspan="4">
                                            <a class="btn btn-primary item_aprobar" id="aprobar_aguinaldo">
                                                <i class="glyphicon glyphicon-check"></i> Aprobar</a> 
                                            <a class="btn btn-danger item_rechazar">
                                                <i class="glyphicon glyphicon-remove"></i> Rechazar</a>
                                        </th>      
                                        
                                    </tr>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Empresa</th>
                                        <th style="text-align:center;">Empleado ingreso</th>
                                        <th style="text-align:center;">DUI</th>
                                        <th style="text-align:center;">Monto</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="taguinaldo">

                                </tbody>
                                <tfoot id="totalAguinaldo">
                                    
                                </tfoot>
                            </table>

                            <input type="hidden" name="agencia_accion" id="agencia_accion" readonly>
                            <input type="hidden" name="anio_accion" id="anio_accion" readonly>

                        </div><!--Fin <div id="menu1" class="tab-pane fade">-->

                        <div id="menu2" class="tab-pane fade"><br><br>


                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia:</label>
                                    <select class="form-control" name="agencia_liquidacion" id="agencia_liquidacion" class="form-control">
                                        <?php
                                            $i=0;
                                            foreach($agencia as $a){

                                            if($admin == 1){
                                        ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php

                                            }else if($admin == 0 && $agencia[$i]->id_agencia != 00){
                                        ?>
                                                <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            }
                                                $i++;
                                            }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_liquidacion" id="anio_liquidacion" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <center>
                                        <a id="filtrar" class="btn btn-success item_liquidacion" style="margin-top: 23px;">
                                            <i class="fas fa-clipboard-list"></i> Generar Liquidacion
                                        </a>
                                    </center>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" id="myliquidacion">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" colspan="7">
                                            <a class="btn btn-primary item_aprobar_liqui" id="aprobar_liquidacion">
                                                <i class="glyphicon glyphicon-check"></i> Aprobar</a> 
                                            <a class="btn btn-danger item_rechazar_liqui" id="rechazar_liq">
                                                <i class="glyphicon glyphicon-remove"></i> Rechazar</a>
                                        </th>      
                                        
                                    </tr>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Empresa</th>
                                        <th style="text-align:center;">DUI</th>
                                        <th style="text-align:center;">Empleado ingreso</th>
                                        <th style="text-align:center;" WIDTH="120">Monto Bruto</th>
                                        <th style="text-align:center;" WIDTH="120">Retencion</th>
                                        <th style="text-align:center;" WIDTH="120">Anticipo</th>
                                        <th style="text-align:center;" WIDTH="150">Monto Liquido</th>
                                    </tr>
                                </thead>
                                <tbody id="tliquidacion">

                                </tbody>
                                <tfoot id="totalLiquidacion">
                                    
                                </tfoot>
                            </table>

                            <input type="hidden" name="agencia_accion_liqui" id="agencia_accion_liqui" readonly>
                            <input type="hidden" name="anio_accion_liqui" id="anio_accion_liqui" readonly>


                        </div>

                        <div id="menu3" class="tab-pane fade"><br><br>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Empresa</label>
                                    <select class="form-control" name="empresa_aguinaldo" id="empresa_aguinaldo" class="form-control">
                                        <option value="todas">Todas</option>
                                            <?php
                                            $i=0;
                                                foreach($empresa as $a){
                                                        
                                            ?>
                                                <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                            <?php
                                                $i++;
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_reporteA" id="agencia_reporteA" class="form-control">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_reporteA" id="anio_reporteA" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a class="btn btn-primary btn-sm item_reporteA" style="margin-top: 25px;">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-striped table-bordered" id="myaguinaldoR">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empresa</th>      
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="tmontoA">

                                </tbody>
                                <tfoot id="totalAguinaldoA">
                                    
                                </tfoot>
                            </table>


                        </div>

                        <div id="menu4" class="tab-pane fade"><br><br>.
                            
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Empresa</label>
                                    <select class="form-control" name="empresa_indemnizacion" id="empresa_indemnizacion" class="form-control">
                                        <option value="todas">Todas</option>
                                            <?php
                                            $i=0;
                                                foreach($empresa as $a){
                                                        
                                            ?>
                                                <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                            <?php
                                                $i++;
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_reporteL" id="agencia_reporteL" class="form-control">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_reporteL" id="anio_reporteL" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row" id="reporte5">
                                <div class="form-group col-md-2">
                                    <center><a class="btn btn-primary btn-sm item_reporteL" style="margin-top: 25px;">Aceptar</a></center>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" id="myaguinaldoL">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empresa</th>      
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Monto Bruto</th>
                                        <th style="text-align:center;">Retencion</th>
                                        <th style="text-align:center;">Anticipo</th>
                                        <th style="text-align:center;">Monto Liquido</th>
                                    </tr>
                                </thead>
                                <tbody id="tmontoL">

                                </tbody>
                                <tfoot id="totalAguinaldoL">
                                    
                                </tfoot>
                            </table>

                        </div>

<!-- inicio de pestaña para retencion pago pasivo NO271222-->
                    <div id="menu5" class="tab-pane fade"><br><br>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Empresa</label>
                                    <select class="form-control" name="empresa_retencion" id="empresa_retencion" class="form-control">
                                        <option value="todas">Todas</option>
                                            <?php
                                            $i=0;
                                                foreach($empresa as $a){
                                                        
                                            ?>
                                                <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                            <?php
                                                $i++;
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_retencion" id="agencia_retencion" class="form-control">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_reporteR" id="anio_reporteR" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row" id="reporte6">
                            <div class="form-group col-md-2">
                                <center><a class="btn btn-primary btn-sm" id="searchRetencion" style="margin-top: 25px;">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-striped table-bordered" id="retencionP">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Salario</th>
                                        <th style="text-align:center;">Indemnizacion</th>
                                        <th style="text-align:center;">Monto a retener</th>
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Empresa</th>
                                        <th style="text-align:center;">Año ingreso empleado</th>
                                        <th style="text-align:center;">Acciones
                                        <input type="checkbox" name="marcar" id="marcar" class="form-check-input">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="retencion">


                                </tbody>
                                
                                
                                    
                            </table>
                            <tfoot>
                                    <div class="col-sm-12">
                                    <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-success" name="bloqueos" id="bloqueos_retencion" value="Ejecutar Accion">
                                    </div>
                                    </div>
                            </tfoot>

                        </div>
    <!-- fin de la pestaña NO271222 -->
<!-- inicio de pestaña para retencion pago pasivo para los empleados con credito NO281222-->
                    <div id="menu6" class="tab-pane fade"><br><br>

                            
                            
                             <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_retencion_credito" id="agencia_retencion_credito" class="form-control">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_reporteCredito" id="anio_reportecredito" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row" id="reporte6">
                            <div class="form-group col-md-2">
                                <center><a class="btn btn-primary btn-sm" style="margin-top: 25px;" id="searchRetencionCredito">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-striped table-bordered" id="retencionC">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Salario</th>
                                        <th style="text-align:center;">Monto credito</th>
                                        <th style="text-align:center;">Monto a retener</th>
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Fecha desembolso</th>
                                        <th style="text-align:center;">Acciones
                                        <input type="checkbox" name="marcar" id="marcar_cre" class="form-check-input">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="retencion_credito">

                                </tbody>
                                
                                    
                            </table>
                            <tfoot>
                                    <div class="col-sm-12">
                                    <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-success" name="bloqueos" id="bloqueos_retencion_credito" value="Ejecutar Accion">
                                    </div>
                                    </div>
                            </tfoot>

                        </div>
    <!-- fin de la pestaña NO271222 -->
  <!-- inicio de la pestaña para las retenciones aplicadas -->
  <div id="menu7" class="tab-pane fade"><br><br>

                            
                            
                             <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" class="form-control" id="agencia_retencion_aprobadas">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>



                            <div class="form-row" id="reporte6">
                            <div class="form-group col-md-2">
                                <center><a class="btn btn-primary btn-sm" style="margin-top: 25px;" id="searchRetencionaprobadas">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-striped table-bordered" id="retencion_retenidos_table">
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Salario</th>
                                        <th style="text-align:center;">Monto retenido</th>
                                        <th style="text-align:center;">Agencia</th>
                                        <th style="text-align:center;">Motivo de retencion</th>
                                        <th style="text-align:center;">Año de la retencion</th>
                                        <th style="text-align:center;">Acciones
                                        <input type="checkbox" name="marcar" id="marcar_rete" class="form-check-input">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="retencion_retenidos">

                                </tbody>
                                
                                    
                            </table>
                            <tfoot>
                                    <div class="col-sm-12">
                                    <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-success" name="bloqueos" id="bloqueos_retencion_credito" value="Ejecutar Accion">
                                    </div>
                                    </div>
                            </tfoot>

                        </div>

                    </div>
                    
                </div>

            </div>
        </div><!--Fin <div class="col-sm-12">-->
    </div><!--Fin <div class="row">-->
</div><!--Fin <div class="col-sm-10">-->



<!--MODAL APROBAR-->
<form>
    <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Aprobacion de Pago de Aguinaldo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a de Aprobar Estos Aguinaldos?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR-->

<form>
    <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazo de Pago de Aguinaldo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Rechazar estos Aguinaldos?</strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
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

<!--MODAL APROBAR INDEMNIZACION-->
<form>
    <div class="modal fade" id="Modal_Aprobar_ind" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Aprobacion de Pago de Indemnizacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a de Aprobar Estas Indemnizacion?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_aprobar_liq" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR INDEMNIZACION-->

<!--MODAL RECHAZAR INDEMNIZACION-->
<form>
    <div class="modal fade" id="Modal_Eliminar_liq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazo de Pago de Indemnizacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Rechazar estas Indemnizacion?</strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_eliminar_liq" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL RECHAZAR INDEMNIZACION-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){

        setTimeout(function(){
            $(".aprobar").fadeOut(1500);
        },3000);

        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_aguinaldo').change(function(){
            show_data();
        });
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_aguinaldo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_aguinaldo').val();
            }
            $('#show_data').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/empleados_gestiones')?>',
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
                                '<a  href="<?php echo base_url();?>index.php/Liquidacion/reciboAguinaldo/'+registro.id_empleado+'" class="btn btn-default btn-sm item_add" ><span class="glyphicon glyphicon-tree-conifer"></span> Aguinaldo</a>'+
                                '</a> '+
                                '<a href="<?php echo base_url();?>index.php/Liquidacion/reciboIndemnizacion/'+registro.id_empleado+'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-gift"></span> Liquidacion</a>'+
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
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };
        
        //POR FAVOR NO QUITAR 
         function resolver1Seg() {
          return new Promise(resolve => {
            setTimeout(() => {
              resolve(aguinaldos());
            }, 1000);
          });
        }

        async function llamadoAsincrono() {
          $('#modalGif').modal('show');
          await resolver1Seg();
          
        }

        $('.item_filtrar').on('click',function(){
            llamadoAsincrono();
         });
        function aguinaldos(){
            //Se usa para destruir la tabla 
            $('#myaguinaldo').dataTable().fnDestroy();
            
            var agencia_ingreso = $('#agencia_agui').children(":selected").attr("id");
            var anio = $('#anio_agui').children(":selected").attr("id");
            var total = 0;
            var estado = '';
            $('#taguinaldo').empty()
            $('#totalAguinaldo').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/generaraAguinaldo')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_ingreso:agencia_ingreso,anio:anio},
                success : function(data){
                    console.log(data);
                   //$("#modalGif").modal('toggle');
                   $('#modalGif' ).modal( 'hide' ).data('bs.modal', null);
                   //$("#modalGif").removeClass('fade').modal('hide');
                   //$("#modalGif").modal("dispose");

                   $('[name="agencia_accion"]').val(data.datos[0].id_agencia);
                   $('[name="anio_accion"]').val(data.datos[0].anio_aplicar);
                   if(data.datos[0].estado == 1){
                        $('#aprobar_aguinaldo').hide();
                   }else{
                        $('#aprobar_aguinaldo').show();
                   }


                   $.each(data.datos,function(key, registro){
                    total += parseFloat(registro.cantidad);

                    $('#taguinaldo').append(
                        '<tr>'+
                            '<td style="text-align:left;">'+registro.nombre+' '+registro.apellido+'</td>'+
                            '<td>'+registro.nombre_empresa+'</td>'+
                            '<td>'+registro.ingreso_empleado+'</td>'+
                            '<td>'+registro.dui+'</td>'+
                            '<td>$ '+parseFloat(registro.cantidad).toFixed(2)+'</td>'+
                        '</tr>'
                        );
                   });

                   $('#totalAguinaldo').append(
                        '<tr>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td><b>$ '+total.toFixed(2)+'</b></td>'+

                        '</tr>'
                    );
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

            //Se genera la paguinacion cada ves que se ejeucuta la funcion
            $('#myaguinaldo').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };
        
        //$('#row').on('click','.item_aprobar',function(){ 
        $('.item_aprobar').click(function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }else{
                $('#Modal_Aprobar').modal('show');
            }
        });

        //Metodo para aprobar una vacacion
        $('#btn_aprobar').on('click',function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/apronarAguinaldo')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Aprobar").modal('toggle');
                    Swal.fire(
                        'Se ha aprobado con exito los aguinaldos!',
                        '',
                        'success'
                    )
                    aguinaldos();
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar 

        //$('#row').on('click','.item_aprobar',function(){ 
        $('.item_rechazar').click(function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }else{
                $('#Modal_Eliminar').modal('show');
            }
        });

        //Metodo para aprobar una vacacion
        $('#btn_eliminar').on('click',function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/rechazarAguinaldo')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Eliminar").modal('toggle');
                    Swal.fire(
                        'Se ha rechazado con exito los aguinaldos!',
                        '',
                        'error'
                    )
                    $('#taguinaldo').empty();
                    $('#totalAguinaldo').empty();
                    $('[name="agencia_accion"]').val("");
                    $('[name="anio_accion"]').val("");
                    $('#aprobar_aguinaldo').show();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar 

        //POR FAVOR NO QUITAR 
        function resolver1Seg2() {
          return new Promise(resolve => {
            setTimeout(() => {
              resolve(indemnizacion());
            }, 1000);
          });
        }

        async function llamadoAsincrono2() {
          $('#modalGif').modal('show');
          await resolver1Seg2();
          
        }

        $('.item_liquidacion').on('click',function(){
            llamadoAsincrono2();
         });

        function indemnizacion(){
            //Se usa para destruir la tabla 
            $('#myliquidacion').dataTable().fnDestroy();
            
            var agencia = $('#agencia_liquidacion').children(":selected").attr("id");
            var anio = $('#anio_liquidacion').children(":selected").attr("id");
            var total_bruto = 0;
            var total_retencion = 0;
            var total_liquido = 0;
            var total_anticipo = 0;
            var estado = '';
            $('#tliquidacion').empty()
            $('#totalLiquidacion').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/generarLiquidacion')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia:agencia,anio:anio},
                success : function(data){
                    console.log(data);
                   $('#modalGif' ).modal( 'hide' ).data('bs.modal', null);

                   $('[name="agencia_accion_liqui"]').val(data.datos[0].id_agencia);
                   $('[name="anio_accion_liqui"]').val(data.datos[0].anio_aplicar);
                   if(data.datos[0].estado == 1){
                        $('#aprobar_liquidacion').hide();
                   }else{
                        $('#aprobar_liquidacion').show();
                   }
                   if(data.retencion == 1){
                    const btnrechazar = document.getElementById('rechazar_liq')
                    btnrechazar.value = 1;
                   }


                   $.each(data.datos,function(key, registro){
                    total_bruto += parseFloat(registro.cantidad_bruto);
                    total_retencion += parseFloat(registro.retencion_indem);
                    total_liquido += parseFloat(registro.cantidad_liquida);
                    total_anticipo += parseFloat(registro.anticipo);

                    $('#tliquidacion').append(
                        '<tr>'+
                            '<td style="text-align:left;">'+registro.nombre+' '+registro.apellido+'</td>'+
                            '<td>'+registro.nombre_empresa+'</td>'+
                            '<td>'+registro.dui+'</td>'+
                            '<td>'+registro.ingreso_empleado+'</td>'+
                            '<td WIDTH="120">$'+parseFloat(registro.cantidad_bruto).toFixed(2)+'</td>'+
                            '<td WIDTH="120">$'+parseFloat(registro.retencion_indem).toFixed(2)+'</td>'+
                            '<td WIDTH="120">$'+parseFloat(registro.anticipo).toFixed(2)+'</td>'+
                            '<td WIDTH="150">$'+parseFloat(registro.cantidad_liquida).toFixed(2)+'</td>'+
                        '</tr>'
                        );
                   });

                   $('#totalLiquidacion').append(
                        '<tr>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td WIDTH="120"><b>$'+total_bruto.toFixed(2)+'</b></td>'+
                            '<td WIDTH="120"><b>$'+total_retencion.toFixed(2)+'</b></td>'+
                            '<td WIDTH="120"><b>$'+total_anticipo.toFixed(2)+'</b></td>'+
                            '<td WIDTH="150"><b>$'+total_liquido.toFixed(2)+'</b></td>'+

                        '</tr>'
                    );
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

            //Se genera la paguinacion cada ves que se ejeucuta la funcion
            $('#myliquidacion').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };

         //$('#row').on('click','.item_aprobar',function(){ 
        $('.item_aprobar_liqui').click(function(){
            var agencia   = $('#agencia_accion_liqui').val();
            var anio   = $('#agencia_accion_liqui').val();

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }else{
                $('#Modal_Aprobar_ind').modal('show');
            }
        });

        //Metodo para aprobar indemnizacion
        $('#btn_aprobar_liq').on('click',function(){
            var agencia   = $('#agencia_accion_liqui').val();
            var anio   = $('#anio_accion_liqui').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/apronarIndemnizacion')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Aprobar_ind").modal('toggle');
                    Swal.fire(
                        'Se ha aprobado con exito las indemnizacion!',
                        '',
                        'success'
                    )
                    indemnizacion();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar.

        $('.item_rechazar_liqui').click(function(){
            var agencia   = $('#agencia_accion_liqui').val();
            var anio   = $('#anio_accion_liqui').val();
            var btnrechazar = $("#rechazar_liq").val();
            console.log(btnrechazar)
            

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }
            else if(btnrechazar == 1 ){
                Swal.fire(
                        '!No se puede rechazar, hay usuarios con retencion aprobada!',
                        '',
                        'error'
                    )
            }
            else{
                $('#Modal_Eliminar_liq').modal('show');
            }
        });

        //Metodo para aprobar una vacacion
        $('#btn_eliminar_liq').on('click',function(){
            var agencia   = $('#agencia_accion_liqui').val();
            var anio   = $('#anio_accion_liqui').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/rechazarIndemnizacion')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Eliminar_liq").modal('toggle');
                    Swal.fire(
                        'Se ha rechazado con exito las indemnizacion!',
                        '',
                        'error'
                    )
                    $('#tliquidacion').empty();
                    $('#totalLiquidacion').empty();
                    $('[name="agencia_accion_liqui"]').val("");
                    $('[name="agencia_accion_liqui"]').val("");
                    $('#aprobar_liquidacion').show();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar 

        $('#pag4').on('click',function(){
            reporteAguinaldo();
        });
        $('.item_reporteA').on('click',function(){
            reporteAguinaldo();
        });

        function reporteAguinaldo(){
            $('#myaguinaldoR').dataTable().fnDestroy();
            $('#tmontoA').empty();
            $('#totalAguinaldoA').empty();

            var anio = $('#anio_reporteA').children(":selected").attr("id");
            var empresa = $('#empresa_aguinaldo').children(":selected").attr("value");
            var agencia = $('#agencia_reporteA').children(":selected").attr("value");
            var total_aguinal = 0;    
            console.log(empresa);
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/reportAguinaldo')?>',
                async : false,
                dataType : 'JSON',
                data : {anio:anio,empresa:empresa,agencia:agencia},
                success : function(data){
                   $.each(data.datos,function(key, registro){
                    total_aguinal += parseFloat(registro.monto);
                    $('#tmontoA').append(
                        '<tr>'+
                            '<td>'+registro.empresa+'</td>'+
                            '<td>'+registro.agencia+'</td>'+
                            '<td>$'+parseFloat(registro.monto).toFixed(2)+'</td>'+
                        '</tr>'
                        );
                   });

                   $('#totalAguinaldoA').append(
                        '<tr>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td WIDTH="150"><b>$'+total_aguinal.toFixed(2)+'</b></td>'+

                        '</tr>'
                    );
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
        
        agencia_reporteA();
        $("#empresa_aguinaldo").change(function(){
            agencia_reporteA();
        });

        agencia_reporteRetencion();
        //NO27122022 proximo a subir evento para funcion para cambiar de agencia
        $("#empresa_retencion").change(function(){
            agencia_reporteRetencion();
        })
        agencia_reporteRetencionCredito()
        //NO28122022 proximo a subir evento para cambiar de agencia
        $("#empresa_retencion_credito").change(function(){
            agencia_reporteRetencionCredito();
        })

        //NO04012023
        agencia_reporteRetencionAprobadas()

        //NO2712022 funcion para cambiar de agencia
        function agencia_reporteRetencion(){
            var empresa = $('#empresa_retencion').children(":selected").attr("value");
            $("#agencia_retencion").empty();
                $("#agencia_retencion").removeAttr('disabled');
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Liquidacion/agenciasReporteA')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_retencion").append('<option id="todas" value="todas">Todas</option>');
                        $.each(data.agencia,function(key, registro) {

                            $("#agencia_retencion").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
            return false;
        };
            function agencia_reporteRetencionCredito(){
            var empresa = $('#empresa_retencion').children(":selected").attr("value");
            $("#agencia_retencion_credito").empty();
                $("#agencia_retencion_credito").removeAttr('disabled');
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Liquidacion/agenciasReporteA')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_retencion_credito").append('<option id="todas" value="todas">Todas</option>');
                        $.each(data.agencia,function(key, registro) {

                            $("#agencia_retencion_credito").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
            return false;
        };
        //NO04012023
        function agencia_reporteRetencionAprobadas(){
            var empresa = $('#empresa_retencion').children(":selected").attr("value");
            $("#agencia_retencion_aprobadas").empty();
                $("#agencia_retencion_aprobadas").removeAttr('disabled');
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Liquidacion/agenciasReporteA')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_retencion_aprobadas").append('<option id="todas" value="todas">Todas</option>');
                        $.each(data.agencia,function(key, registro) {

                            $("#agencia_retencion_aprobadas").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
            return false;
        };

        function agencia_reporteA(){
            var empresa = $('#empresa_aguinaldo').children(":selected").attr("value");
            $("#agencia_reporteA").empty();
                $("#agencia_reporteA").removeAttr('disabled');
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Liquidacion/agenciasReporteA')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_reporteA").append('<option id="todas" value="todas">Todas</option>');
                        $.each(data.agencia,function(key, registro) {

                            $("#agencia_reporteA").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
            return false;
        };

        $("#empresa_indemnizacion").change(function(){
            agencia_reporteL();
        });

        function agencia_reporteL(){
            var empresa = $('#empresa_indemnizacion').children(":selected").attr("value");
            $("#agencia_reporteL").empty();
                $("#agencia_reporteL").removeAttr('disabled');
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Liquidacion/agenciasReporteA')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_reporteL").append('<option id="todas" value="todas">Todas</option>');
                        $.each(data.agencia,function(key, registro) {

                            $("#agencia_reporteL").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
            return false;
        };

        agencia_reporteL();
        $('#pag5').on('click',function(){
            reporteIndemnizacion();
        });
        $('.item_reporteL').on('click',function(){
            reporteIndemnizacion();
        });

        function reporteIndemnizacion(){
            $('#myaguinaldoL').dataTable().fnDestroy();
            $('#tmontoL').empty();
            $('#totalAguinaldoL').empty();

            var anio = $('#anio_reporteL').children(":selected").attr("id");
            var empresa = $('#empresa_indemnizacion').children(":selected").attr("value");
            var agencia = $('#agencia_reporteL').children(":selected").attr("value");
            var total_bruto = 0;    
            var total_retencion = 0;    
            var total_anticipo = 0;    
            var total_liquido = 0;    

            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/reportIndemnizacion')?>',
                async : false,
                dataType : 'JSON',
                data : {anio:anio,empresa:empresa,agencia:agencia},
                success : function(data){
                   $.each(data.datos,function(key, registro){
                    console.log(data);
                    total_bruto += parseFloat(registro.bruto);
                    total_retencion += parseFloat(registro.retencion);
                    total_anticipo += parseFloat(registro.anticipo);
                    total_liquido += parseFloat(registro.liquido);

                    $('#tmontoL').append(
                        '<tr>'+
                            '<td>'+registro.empresa+'</td>'+
                            '<td>'+registro.agencia+'</td>'+
                            '<td>$'+parseFloat(registro.bruto).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.retencion).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.anticipo).toFixed(2)+'</td>'+
                            '<td>$'+parseFloat(registro.liquido).toFixed(2)+'</td>'+
                        '</tr>'
                        );
                   });

                   $('#totalAguinaldoL').append(
                        '<tr>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td WIDTH="150"><b>$'+total_bruto.toFixed(2)+'</b></td>'+
                            '<td WIDTH="150"><b>$'+total_retencion.toFixed(2)+'</b></td>'+
                            '<td WIDTH="150"><b>$'+total_anticipo.toFixed(2)+'</b></td>'+
                            '<td WIDTH="150"><b>$'+total_liquido.toFixed(2)+'</b></td>'+
                        '</tr>'
                    );
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

        $('#btn_firmas').on('click',function(){
          var mes= $('#mes').val();
          var quincena= $('#quincena').val();
          //var agencia= $('#agencia_planilla').val();

          var agencia = $('#agencia_aguinaldo').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia_aguinaldo').val();
            }
          //var empresa= $('#empresaAu').val();
          window.location.href = '<?php echo site_url('Liquidacion/hoja_firmas/')?>'+agencia    
          });//fin de la funcion crear horas extras 

    });//Fin jQuery
        
        //NO301222
        $('#pag6').on('click',function(){
            showRetenciones();
        });

        $('#pag7').on('click',function(){
            showRetencionesCredito();
        });
        $('#pag8').on('click',function(){
            showRetencionesaprobadas();
        });

    function showRetenciones(){
        $('#retencionP').DataTable().destroy();
        $('#retencion').empty();

        $.ajax({
            type: 'POST',
            url : "<?php echo site_url('Liquidacion/getRetenciones') ?>",
            async: false,
            dataType: "JSON",
            success: function(data){
                console.log(data)
               for (var i = 0; i< data.length; i++) {
                   var retencion = (data[i].sbase/365)*90
               
                $('#retencion').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                            '<td>'+data[i].sbase+'</td>'+
                            '<td>'+parseFloat(data[i].cantidad_bruto).toFixed(2)+'</td>'+
                            '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+data[i].nombre_empresa+'</td>'+
                            '<td>'+data[i].ingreso_empleado+'</td>'+
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input style:'margin-left:5px;' type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</span></td>")+
                            
                        '</tr>'
                        );
            }

              
            }
        })
    }
    
    function showRetencionesCredito(){
        $('#retencionC').DataTable().destroy();
        $('#retencion_credito').empty();

        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('Liquidacion/getRetencionEmpleadoCredito') ?>",
            async: false,
            dataType: "JSON",
            success: function(data){
               
                if(data[0].length == undefined){
                    console.log("no hay data de la segunda query")
                }
                for (var i = 0; i< data.length-1; i++){
                    var retencion = (data[i].sbase/365)*90

                     $('#retencion_credito').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+'</td>'+
                            '<td>'+data[i].sbase+'</td>'+
                            '<td>'+parseFloat(data[i].monto_pagar).toFixed(2)+'</td>'+
                            '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+data[i].fecha_desembolso+'</td>'+
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[i].ultimo_contrato+"> <span class='label label-danger'>Eliminar retencion</a></td>'+":"<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</a></td>")+
                        '</tr>'
                        );

                }
                for(var i = 0; i < data[data.length-1].length; i++){
                    var retencion = (data[i].sbase/365)*90
                   $('#retencion_credito').append(
                        '<tr>'+
                            '<td>'+data[data.length-1][i].nombre+" "+data[data.length-1][i].apellido+'</td>'+
                            '<td>'+data[data.length-1][i].Sbase+'</td>'+
                            '<td>'+parseFloat(data[data.length-1][i].monto_otorgado).toFixed(2)+'</td>'+
                             '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[data.length-1][i].agencia+'</td>'+
                            '<td>'+data[data.length-1][i].fecha_otorgado+'</td>'+
                            ((data[data.length-1][i].retencion_indem !=0)? "'<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[data.length-1][i].ultimo_contrato+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[data.length-1][i].id_indemnizacion+"><span class='label label-success '>Añadir retencion</a></td>")+
                        '</tr>'
                        );
                }
                
            }
        })
    }
    //NO301222 botones para ir arriba o abajo del documento
    $('#button').click(function(){
        $('html, body').animate({scrollTop:$(document).height()}, 'slow');
        return false;
    });
    $('#button_up').click(function(){
        $('html, body').animate({scrollTop:$(document).height(0)}, 'slow');
        return false;
    });

    $("#marcar").on("click", function() {
          $(".chbox").prop("checked", this.checked);
    });
    $("#marcar_cre").on("click", function() {
          $(".chbox_cre").prop("checked", this.checked);
    });


    $('#bloqueos_retencion').on('click',function(){
        console.log("entre")
        $("#modalGif").modal('show')
        setTimeout(function (){
                retencion()
        }, 500)
    })
        function retencion(){
         var checkboxes = document.getElementsByName('check');
         var vals = []
         for (var i=0, n=checkboxes.length;i<n;i++){
            if (checkboxes[i].checked) //solo los que estan chequeado
                {
                    vals.push(checkboxes[i].value);

                }
         }
         if (vals.length==0) {
                $("#modalGif").modal('hide')
               Swal.fire(
                            'Debe seleccionar al menos un usuario' ,
                            '',
                            'error'
                            )
            }
        else{
         $.ajax({
                    type  : 'POST',
                    url   : '<?php echo site_url('Liquidacion/addRetencion')?>',
                    async : false,
                    dataType : 'JSON',
                    data : {vals:vals},
                    success: function(data){
                        $("#modalGif").modal('hide')
                        if(data == null){
                            Swal.fire(
                            'Exito' ,
                            '',
                            'success'
                            ).then(function(){
                            location.reload()
                            })
                        }
                    }
        

        })
     }
 }
    
    //tiempo de espera para mostrar el modal
    $('#bloqueos_retencion_credito').on('click',function(){
        $("#modalGif").modal('show');
        setTimeout(function(){
            retencion_credito()
        },500)
        
     })
        function retencion_credito(){
        console.log("entre")
         var checkboxes = document.getElementsByName('chbox_cre');
         var vals = []
         for (var i=0, n=checkboxes.length;i<n;i++){
            if (checkboxes[i].checked) //solo los que estan chequeado
                {
                    vals.push(checkboxes[i].value);

                }
         }
         if (vals.length==0) {
               $("#modalGif").modal('hide');
               Swal.fire(
                            'Debe seleccionar al menos un usuario' ,
                            '',
                            'error'
                            )

            }
        else{   
         $.ajax({
                    type  : 'POST',
                    url   : '<?php echo site_url('Liquidacion/addRetencion')?>',
                    async : false,
                    dataType : 'JSON',
                    data : {vals:vals},
                    success: function(data){
                        $("#modalGif").modal('hide');
                        if(data == null){
                            Swal.fire(
                            'Exito' ,
                            '',
                            'success'
                            ).then(function(){
                            location.reload()
                            })
                        }
                    }
        

        })
     }
 }
 $("#searchRetencion").on('click', function (){
        var empresa = $("#empresa_retencion").val()
        var agencia = $("#agencia_retencion").val()
        var anio = $("#anio_reporteR").val()
        console.log(anio)
        $("#retencionP").DataTable().destroy();
        $("#retencion").empty();

        $.ajax({
            type:'POST',
            url: "<?php echo site_url('Liquidacion/getRetenciones')?>",
            async:false,
            dataType: "JSON",
            data: {empresa: empresa, agencia:agencia, anio:anio},
            success: function(data){
                console.log(data)
                for(var i = 0; i<data.length; i++){
                     var retencion = (data[i].sbase/365)*90
                    $('#retencion').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                            '<td>'+data[i].sbase+'</td>'+
                            '<td>'+parseFloat(data[i].cantidad_bruto).toFixed(2)+'</td>'+
                            '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+data[i].nombre_empresa+'</td>'+
                            '<td>'+data[i].ingreso_empleado+'</td>'+
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_contrato+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input style:'margin-left:5px;' type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</span></td>")+
                        '</tr>'
                        );
                }
            }
        })
})

 $("#searchRetencionCredito").on('click', function (){
        var agencia = $("#agencia_retencion_credito").val();
        var anio = $("#anio_reportecredito").val();
        console.log(agencia)
        $("#retencionC").DataTable().destroy();
        $("#retencion_credito").empty();

        $.ajax({
            type: 'POST',
            url: "<?php   echo site_url ('Liquidacion/getRetencionEmpleadoCredito')  ?>",
            async: false,
            dataType: "JSON",
            data: {agencia:agencia, anio:anio},
            success: function(data){
                console.log(data)
            for (var i = 0; i< data.length-1; i++){
                if(data[i].agencia != 0){
                    var retencion = (data[i].sbase/365)*90
                     $('#retencion_credito').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+'</td>'+
                            '<td>'+data[i].sbase+'</td>'+
                            '<td>'+parseFloat(data[i].monto_pagar).toFixed(2)+'</td>'+
                             '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+data[i].fecha_desembolso+'</td>'+
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[i].id_indemnizacion+"> <span class='label label-danger'>Eliminar retencion</a></td>'+":"<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</a></td>")+
                        '</tr>'
                        );
                }

                }
                if(data[data.length-1].length != undefined  ){
                for(var i = 0; i < data[data.length-1].length; i++){
                    var retencion = (data[i].sbase/365)*90
                   $('#retencion_credito').append(
                        '<tr>'+
                            '<td>'+data[data.length-1][i].nombre+" "+data[data.length-1][i].apellido+'</td>'+
                            '<td>'+data[data.length-1][i].Sbase+'</td>'+
                            '<td>'+parseFloat(data[data.length-1][i].monto_otorgado).toFixed(2)+'</td>'+
                            '<td>'+parseFloat(retencion).toFixed(2)+'</td>'+
                            '<td>'+data[data.length-1][i].agencia+'</td>'+
                            '<td>'+data[data.length-1][i].fecha_otorgado+'</td>'+
                            ((data[data.length-1][i].retencion_indem !=0)? "'<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[data.length-1][i].ultimo_contrato+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input type='checkbox' name='chbox_cre' id='check' class='form-check-input chbox_cre' value="+data[data.length-1][i].id_indemnizacion+"><span class='label label-success '>Añadir retencion</a></td>")+
                        '</tr>'
                        );
                }
            }
            }
        })

 })
 function showRetencionesaprobadas(){
        $('#retencion_retenidos_table').DataTable().destroy();
        $('#retencion_retenidos').empty();

        $.ajax({
            type: 'POST',
            url : "<?php echo site_url('Liquidacion/getallRetenidos') ?>",
            async: false,
            dataType: "JSON",
            success: function(data){
                console.log(data)
               for (var i = 0; i< data.length; i++) {
                   var retencion = (data[i].sbase/365)*90
                   if(data[i].antiguedad > 365){
                    var motivo = "Prestamo interno"
                   }else{
                    var motivo = "Tiempo laboral insuficiente"
                   }
               
                $('#retencion_retenidos').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                            '<td>'+data[i].Sbase+'</td>'+
                            '<td>'+parseFloat(data[i].retencion_indem).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+motivo+'</td>'+
                            '<td>'+data[i].anio_aplicar+'</td>'+
                            
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input style:'margin-left:5px;' type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</span></td>")+
                            
                        '</tr>'
                        );
            }

              
            }
        })
    }

     $("#searchRetencionaprobadas").on('click', function (){
        var agencia = $("#agencia_retencion_aprobadas").val()
        
        console.log(agencia)
        $("#retencion_retenidos_table").DataTable().destroy();
        $("#retencion_retenidos").empty();

        $.ajax({
            type:'POST',
            url: "<?php echo site_url('Liquidacion/getallRetenidos')?>",
            async:false,
            dataType: "JSON",
            data: {agencia:agencia},
            success: function(data){
                if(data.length == 0){
                    console.log('vacio')
                    alert("No hay datos disponibles")
                }
                console.log(data)
                for(var i = 0; i<data.length; i++){
                      var retencion = (data[i].sbase/365)*90
                   if(data[i].antiguedad > 365){
                    var motivo = "Prestamo interno"
                   }else{
                    var motivo = "Tiempo laboral insuficiente"
                   }
               
                $('#retencion_retenidos').append(
                        '<tr>'+
                            '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                            '<td>'+data[i].Sbase+'</td>'+
                            '<td>'+parseFloat(data[i].retencion_indem).toFixed(2)+'</td>'+
                            '<td>'+data[i].agencia+'</td>'+
                            '<td>'+motivo+'</td>'+
                            '<td>'+data[i].anio_aplicar+'</td>'+
                            
                            ((data[i].retencion_indem !=0)? "'<td><input type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-danger'>Eliminar retencion</span></td>'+":"<td><input style:'margin-left:5px;' type='checkbox' name='check' id='check' class='form-check-input chbox' value="+data[i].id_indemnizacion+"><span class='label label-success'>Añadir retencion</span></td>")+
                            
                        '</tr>'
                        );
                }
            }
        })
})
    
   
</script>
</body>
</html>