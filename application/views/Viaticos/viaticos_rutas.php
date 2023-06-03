<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- inicio de div principal -->
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Viaticos</h2>
    </div>

    <ul class="nav nav-tabs">

    
        <li class="active"><a data-toggle="tab" href="#home">Viaticos carteras</a></li>
        <li><a data-toggle="tab" href="#menu1">Viaticos extras</a></li>
        <li><a data-toggle="tab" href="#menu2">Viaticos efectivos</a></li>
        <li><a data-toggle="tab" href="#menu3">Viaticos renuncia/despedidos</a></li>
        <li><a data-toggle="tab" href="#menu4">Control de viaticos</a></li>

    </ul>
    <!-- inicio de div tab-content -->
    <div class="tab-content">
        <br>
        <!-- inicio de div de home -->
        <div id="home" class="tab-pane fade in active">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group col-md-2">
                        <label for="inputState">Empresa:</label>
                        <select class="form-control" name="empresa_viatico" id="empresa_viatico" class="form-control" onchange="select_agencia();">
                            <option value="todas" data-estado="1">Todas</option>
                            <?php
                                foreach($empresas as $empresa){
                            ?>
                                <option value="<?= ($empresa->id_empresa);?>" data-estado="0"><?php echo($empresa->nombre_empresa);?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputState">Agencia:</label>
                        <select class="form-control" name="agencia_viatico" id="agencia_viatico" class="form-control">
                            
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputState">Mes:</label>
                        <input type="month" name="mes_viatico" id="mes_viatico"  class="form-control" value="<?= date('Y-m') ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputState">Quincena:</label>
                        <select class="form-control" name="quincena_viatico" id="quincena_viatico" class="form-control">
                            <option value="1" <?php if($quincena == 1){echo 'selected';} ?>>Primera quincena</option>
                            <option value="2" <?php if($quincena == 2){echo 'selected';} ?>>Segunda quincena</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputState">Filtrar</label><br>
                        <a id="filtrar" class="btn btn-primary btn-sm" onclick="meses_viaticos()"><span class="glyphicon glyphicon-search"></span></a>
                    </div>
                </div>
            </div><br>


            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered" id="mydata">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <div class="form-group col-md-12">
                                        <div class="form-group col-md-8" id="titulo">
                                            <?= $titulo ?>
                                        </div>

                                        <?php if($aprobar == 1 || $rechazar == 1){ ?>
                                        <div class="form-group col-md-4" id="btn_guardar" >
                                            <?php 
                                            if(!empty($guardar) && $aprobar == 1){
                                                $datos=json_encode($guardar);
                                                $datos2='';
                                                ?>
                                                <center>
                                                    <button id="aprobar" name="aprobar" data-toggle="modal" data-target="#Modal_aprobar" class="btn btn-success">Aprobar viaticos</button>
                                                </center>
                                            <?php }else if(empty($guardar) && !empty($rehazo) && $rechazar == 1){ 
                                                $datos=json_encode($rehazo);
                                                $datos2=json_encode($id_rehazo);
                                            ?>
                                                <center>
                                                    <button id="rechazo" name="rechazo" class="btn btn-danger" data-toggle="modal" data-target="#Modal_Delete">Rechazar viaticos</button>
                                                </center>
                                            <?php } ?>
                                        </div>
                                        <input type='hidden' name='id_rehazo' id='id_rehazo' value='<?=$datos2?>'>
                                        <input type='hidden' name='all_viaticos' id='all_viaticos' value='<?=$datos?>'>
                                        <?php } ?>
                                    </div>
                                </th>
                            </tr>
                            <tr class="success">
                                <th style="text-align:center;" >Agencia</th>      
                                <th style="text-align:center;">Cartera</th>      
                                <th style="text-align:center;">Empleado</th>      
                                <th style="text-align:center;">Consumo ruta</th>      
                                <th style="text-align:center;">Depreciaciòn</th>      
                                <th style="text-align:center;">Llanta delantera</th>      
                                <th style="text-align:center;">Llanta tracera</th>      
                                <th style="text-align:center;">Mant. Gral</th>      
                                <th style="text-align:center;">Aceite</th>      
                                <th style="text-align:center;">Total</th>      
                                <th style="text-align:center;">Aprobado</th>      
                            </tr>
                        </thead>
                        <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                            <?php 
                                for($i = 0; $i < count($viaticos); $i++){
                                    echo '<tr>';
                                    echo '<td>'.$viaticos[$i]['agencia'].'</td>';
                                    echo '<td>'.$viaticos[$i]['cartera'].'</td>';
                                    echo '<td>'.$viaticos[$i]['nombre'].'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['consumo_ruta'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['depreciacion'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['llanta_del'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['llanta_tra'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['mont_gral'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['aceite'],2).'</td>';
                                    echo '<td>$'.number_format($viaticos[$i]['total'],2).'</td>';
                                    if($viaticos[$i]['guardado'] == 0){
                                        echo '<td style="color: #d9534f"><span title="Viatico no aprobado" class="glyphicon glyphicon-floppy-remove"></span></td>';
                                    }else if($viaticos[$i]['guardado'] == 1){
                                        echo '<td style="color: #5cb85c"><span title="Viatico aprobado" class="glyphicon glyphicon-floppy-saved"></span></td>';
                                    }
                                    echo '</tr>';
                                }
                                
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- fin de div de home -->

        <!-- inicio de div menu1 -->
        <div id="menu1" class="tab-pane fade">
            <div class="row">
            <div class="col-sm-12">
                <div class="form-group col-md-3">
                    <label for="inputState">Agencia:</label>
                    <select class="form-control" name="agencia_viatico_tem" id="agencia_viatico_tem" class="form-control">
                        <?php
                            foreach($agencias_ex as $agencia){
                        ?>
                            <option value="<?= ($agencia->id_agencia);?>" data-estado="0"><?php echo($agencia->agencia);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Mes:</label>
                    <input type="month" name="mes_viatico_temp" id="mes_viatico_temp"  class="form-control" value="<?= date('Y-m') ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Quincena:</label>
                    <select class="form-control" name="quincena_viatico_tempo" id="quincena_viatico_tempo" class="form-control">
                        <option value="1" <?php if($quincena == 1){echo 'selected';} ?>>Primera quincena</option>
                        <option value="2" <?php if($quincena == 2){echo 'selected';} ?>>Segunda quincena</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Filtrar</label><br>
                    <a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_viaticos()"><span class="glyphicon glyphicon-search"></span></a>
                </div>

            </div>
            </div><br>


            <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered" id="data_extra">
                    <thead>
                        <tr class="success">
                        <th style="text-align:center;">Agencia</th>         
                        <th style="text-align:center;">Empleado</th>      
                        <th style="text-align:center;">Cargo</th>      
                        <th style="text-align:center;">Comusumo ruta</th>      
                        <th style="text-align:center;">Depreciaciòn</th>      
                        <th style="text-align:center;">Llanta delantera</th>      
                        <th style="text-align:center;">Llanta tracera</th>      
                        <th style="text-align:center;">Mant. Gral</th>      
                        <th style="text-align:center;">Aceite</th>      
                        <th style="text-align:center;">Total</th>      
                        <th style="text-align:center;">Accion</th>      
                        </tr>
                    </thead>
                    <tbody id="show_extra"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                    <?php 
                        foreach($empleados as $empleado){
                            echo '<tr>';
                            echo '<td>'.$empleado->agencia.'</td>';
                            echo '<td>'.$empleado->nombre.'</td>';
                            echo '<td>'.$empleado->cargo.'</td>';
                            echo '<td>$'.number_format($empleado->consumo_ruta,2).'</td>';
                            echo '<td>$'.number_format($empleado->depreciacion,2).'</td>';
                            echo '<td>$'.number_format($empleado->llanta_del,2).'</td>';
                            echo '<td>$'.number_format($empleado->llanta_tra,2).'</td>';
                            echo '<td>$'.number_format($empleado->mant_gral,2).'</td>';
                            echo '<td>$'.number_format($empleado->aceite,2).'</td>';
                            echo '<td>$'.number_format($empleado->total,2).'</td>';
                            echo '<td>';
                            echo '<a class="btn btn-success" title="Agregar viatico" onclick="ingresar_datos('.$empleado->id_empleado.')"><span class="glyphicon glyphicon-plus-sign"></span></a>';
                            echo '<a class="btn btn-primary" href="'.base_url('index.php/Viaticos/viaticos_detalle/'.$empleado->id_empleado).'" title="Revisar viatico" ><span class="glyphicon glyphicon-check"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
        </div>
        <!-- fin de div menu1 -->
        <!-- inicio de div menu2 -->
        <div id="menu2" class="tab-pane fade">
            <div class="row">
            <div class="col-sm-12">
                <div class="form-group col-md-3">
                    <label for="inputState">Agencia:</label>
                    <select class="form-control" name="agencia_viatico_efec" id="agencia_viatico_efec" class="form-control">
                        <?php
                            foreach($agencias_ex as $agencia){
                        ?>
                            <option value="<?= ($agencia->id_agencia);?>" data-estado="0"><?php echo($agencia->agencia);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Mes:</label>
                    <input type="month" name="mes_viatico_efec" id="mes_viatico_efec"  class="form-control" value="<?= date('Y-m') ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Quincena:</label>
                    <select class="form-control" name="quincena_viatico_efec" id="quincena_viatico_efec" class="form-control">
                        <option value="1" <?php if($quincena == 1){echo 'selected';} ?>>Primera quincena</option>
                        <option value="2" <?php if($quincena == 2){echo 'selected';} ?>>Segunda quincena</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Filtrar</label><br>
                    <a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_efectivos()"><span class="glyphicon glyphicon-search"></span></a>
                </div>

            </div>
            </div><br>

            <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered" id="data_efectivo">
                    <thead>
                        <tr class="success">
                        <th style="text-align:center;">Agencia</th>         
                        <th style="text-align:center;">Empleado</th>      
                        <th style="text-align:center;">Cargo</th>      
                        <th style="text-align:center;">Comusumo ruta</th>      
                        <th style="text-align:center;">Depreciaciòn</th>      
                        <th style="text-align:center;">Llanta delantera</th>      
                        <th style="text-align:center;">Llanta tracera</th>      
                        <th style="text-align:center;">Mant. Gral</th>      
                        <th style="text-align:center;">Aceite</th>      
                        <th style="text-align:center;">Total</th>      
                        <th style="text-align:center;">Accion</th>      
                        </tr>
                    </thead>
                    <tbody id="show_efectivo"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                    <?php 
                        foreach($efectivos as $efectivo){
                            echo '<tr>';
                            echo '<td>'.$efectivo->agencia.'</td>';
                            echo '<td>'.$efectivo->nombre.'</td>';
                            echo '<td>'.$efectivo->cargo.'</td>';
                            echo '<td>$'.number_format($efectivo->consumo_ruta,2).'</td>';
                            echo '<td>$'.number_format($efectivo->depreciacion,2).'</td>';
                            echo '<td>$'.number_format($efectivo->llanta_del,2).'</td>';
                            echo '<td>$'.number_format($efectivo->llanta_tra,2).'</td>';
                            echo '<td>$'.number_format($efectivo->mant_gral,2).'</td>';
                            echo '<td>$'.number_format($efectivo->aceite,2).'</td>';
                            echo '<td>$'.number_format($efectivo->total,2).'</td>';
                            echo '<td>';
                            echo '<a class="btn btn-primary" data-mes="'.$efectivo->mes.'" data-quincena='.$efectivo->quincena.' data-id_empleado='.$efectivo->id_empleado.' onclick="get_efectivos(this)" title="Revisar viaticos" ><span class="glyphicon glyphicon-check"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
        </div>
        <!-- fin de div de menu2 -->
        <!-- inicio de div menu3 -->
        <div id="menu3" class="tab-pane fade">
            <div class="col-sm-12">
                <div class="form-group col-md-3">
                    <label for="inputState">Empresa:</label>
                    <select class="form-control" name="empresa_inactivo" id="empresa_inactivo" class="form-control" onchange="inactivo_agencia();">
                    <option value="todas">Todas</option>
                    <?php
                        foreach($empresas as $empresa){
                    ?>
                        <option value="<?= ($empresa->id_empresa);?>" data-estado="0"><?php echo($empresa->nombre_empresa);?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Agencia:</label>
                    <select class="form-control" name="agencia_inactivo" id="agencia_inactivo" class="form-control">
                        
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Mes de renuncia/despido:</label>
                    <input type="month" name="mes_inactivo" id="mes_inactivo"  class="form-control" value="<?= date('Y-m') ?>">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Filtrar</label><br>
                    <a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_inactivo()"><span class="glyphicon glyphicon-search"></span></a>
                </div>

            </div><br>

            <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered" id="data_inactivos">
                    <thead>
                        <tr class="success">
                            <th style="text-align:center;">Agencia</th>         
                            <th style="text-align:center;">Empresa</th>         
                            <th style="text-align:center;">Empleado</th>      
                            <th style="text-align:center;">Cargo</th>      
                            <th style="text-align:center;">Fecha fin</th>      
                            <th style="text-align:center;">Renuncia/despido</th>      
                            <th style="text-align:center;">Total</th>      
        
                            <th style="text-align:center;">Accion</th>      
                        </tr>
                    </thead>
                    <tbody id="show_inactivos"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                        <?php 
                            foreach($inactivos as $inactivo){
                                if($inactivo->tipo_des_ren == 1){
                                    $renuncia = 'Despido sin responsabilidad';
                                }else if($inactivo->tipo_des_ren == 2){
                                    $renuncia = 'Despido con responsabilidad';
                                }else if($inactivo->tipo_des_ren == 3){
                                    $renuncia = 'No aprobo periodo de prueba';
                                }else if($inactivo->tipo_des_ren == 4){
                                    $renuncia = 'Renuncia con previo aviso';
                                }else if($inactivo->tipo_des_ren == 5){
                                    $renuncia = 'Abandono de puesto';
                                }
                                echo '<tr>';
                                echo '<td>'.$inactivo->agencia.'</td>';
                                echo '<td>'.$inactivo->nombre_empresa.'</td>';
                                echo '<td>'.$inactivo->nombre.'</td>';
                                echo '<td>'.$inactivo->cargo.'</td>';
                                echo '<td>'.$inactivo->fecha_fin.'</td>';
                                echo '<td>'.$renuncia.'</td>';
                                echo '<td>$'.number_format($inactivo->total,2).'</td>';

                                echo '<td>';
                                echo '<a class="btn btn-success" title="Agregar viatico" onclick="datos_inactivos('.$inactivo->id_empleado.')"><span class="glyphicon glyphicon-plus-sign"></span></a> ';
                                echo '<a class="btn btn-primary" href="'.base_url('index.php/Viaticos/viaticos_detalle_inactivo/'.$inactivo->id_empleado).'" title="Revisar viaticos" ><span class="glyphicon glyphicon-check"></span></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
        </div>
        <!-- fin de div de menu3 -->
        <!-- inicio de div menu4 -->
        <div id="menu4" class="tab-pane fade">
            <form id="form_viaticos_control">
            <div class="row">
            <div class="col-sm-12">
                <div class="form-group col-md-3">
                    <label for="inputState">Agencia:</label>
                    <select class="form-control" name="agencia_viatico_control" id="agencia_viatico_control" class="form-control">
                        <?php
                            foreach($agencias_ex as $agencia){
                        ?>
                            <option value="<?= ($agencia->id_agencia);?>" data-estado="0"><?php echo($agencia->agencia);?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Mes:</label>
                    <input type="month" name="mes_viatico_control" id="mes_viatico_control"  class="form-control" value="<?= date('Y-m') ?>">        
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Quincena:</label>
                    <select class="form-control" name="quincena_viatico_control" id="quincena_viatico_control" class="form-control">
                        <option value="1" <?php if($quincena == 1){echo 'selected';} ?>>Primera quincena</option>
                        <option value="2" <?php if($quincena == 2){echo 'selected';} ?>>Segunda quincena</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Filtrar</label><br>
                       <button type="submit" id="viaticos_control" class="btn btn-primary bi bi-search"></button>
                </div>
            </div>    
            </div>
            </form><br>
            <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered" id="data_control">
                    <thead>
                        <tr class="success">
                        <th style="text-align:center;">Agencia</th>         
                        <th style="text-align:center;">Empleado</th>      
                        <th style="text-align:center;">Cargo</th>      
                        <th style="text-align:center;">Viatico Carteras</th> 
                        <th style="text-align:center;">Viatico Extra</th>         
                        <th style="text-align:center;">Viatico Permanentes</th>
                        <th style="text-align:center;">Viatico Parciales</th>
                        <th style="text-align:center;">Viatico Compartidos</th>        
                        <th style="text-align:center;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="show_control"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                    <?php 
                        foreach($empleados as $empleado){
                            echo '<tr>';
                            echo '<td>'.$empleado->agencia.'</td>';
                            echo '<td>'.$empleado->nombre.'</td>';
                            echo '<td>'.$empleado->cargo.'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '<td>$'.number_format(0.00,2).'</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>

        </div>
        <!-- fin de div de menu4 -->

    </div>
    <!-- fin de div tab-content -->
</div>
<!-- fin de div principal -->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">Rechazo de viaticos</h5>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div id="validacion_rechazo" style="color:red"></div>
                      </div>
                    </div>
                  <strong>¿Seguro/a que desea rechazar estos viaticos?</strong><br><br>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="btn_eliminar"  class="btn btn-danger" onclick="delete_viaticos()">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel"><center>Agregar viatico</center></h3>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                  <div class="col-md-12">
                    <div id="validacion" style="color:red"></div>
                    <input type="hidden" name="codigo_empleado" id="codigo_empleado" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tipo de anticipo:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="tipo_viatico" id="tipo_viatico" onchange="seleccionar_tipo()">
                            <option value="1">Viatico total</option>
                            <option value="2">Viatico parcial</option>
                            <option value="3">Viatico adicional</option>
                            <option value="4">Viatico extra</option>
                            <option value="5">Viatico permanente</option>
                            <option value="6">Viatico compartido</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Mes aplicar:</label>
                    <div class="col-md-9">
                        <input type="month" name="mes_ingreso" id="mes_ingreso"  class="form-control" value="<?= date('Y-m') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Quincena aplicar:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="quincena_viatico_temp" id="quincena_viatico_temp">
                            <option value="1">Primera quincena</option>
                            <option value="2">Segunda quincena</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="agencia_div">
                    <label class="col-md-3 col-form-label">agencia:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="agencia_ingreso" id="agencia_ingreso" onchange="seleccionar_moto()">
                            <?php
                                foreach($agencias as $agencia){
                                    if($agencia->id_agencia != '00'){
                            ?>
                                    <option value="<?= ($agencia->id_agencia);?>"><?php echo($agencia->agencia);?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="cartera_div">
                    <label class="col-md-3 col-form-label">Cartera:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="cartera_viatico" id="cartera_viatico">
                            
                        </select>
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="dias_cobertura">
                    <label class="col-md-3 col-form-label">Dias cobertura:</label>
                    <div class="col-md-9">
                        <input type="number" name="cobertura_dias" id="cobertura_dias" min="1" class="form-control number-only">
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="por_cobertura">
                    <label class="col-md-3 col-form-label">% cobertura:</label>
                    <div class="col-md-9">
                        <input type="text" name="cobertura_por" id="cobertura_por"  class="form-control">
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="dinero_cantidad">
                    <label class="col-md-3 col-form-label">Cantidad ($):</label>
                    <div class="col-md-9">
                        <input type="text" name="cantidad_dinero" id="cantidad_dinero"  class="form-control">
                    </div>
                </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" onclick="insert_viaticos()">Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL MOSTRAR-->
<div class="modal fade" id="Modal_datos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <center>
          <h4 class="modal-title">Detalles de viaticos</h4>
          </center>
        </div>

        <div class="modal-body">
            <center>
                <table class="table table-bordered" id="datos" style="width: 100%">
                    <thead>
                        <tr class="success">
                            <td><b>Nombre de empleado</b></td>
                            <td><b>Agencia</b></td>
                            <td><b>Cargo</b></td>
                            <td><b>Mes</b></td>
                            <td><b>Quincena</b></td>
                        </tr>
                    </thead>
                    <tbody class="datos_empleado">
                        
                    </tbody>
                </table>

                <table class="table table-bordered" id="efectivos" style="width: 100%">
                    <thead>
                        <tr class="success">      
                            <th style="text-align:center;">Tipo viatico</th>      
                            <th style="text-align:center;">Comusumo ruta</th>      
                            <th style="text-align:center;">Depreciaciòn</th>      
                            <th style="text-align:center;">Llanta delantera</th>      
                            <th style="text-align:center;">Llanta tracera</th>      
                            <th style="text-align:center;">Mant. Gral</th>      
                            <th style="text-align:center;">Aceite</th>      
                            <th style="text-align:center;">Total</th>      
                        </tr>
                    </thead>
                    <tbody class="datos_efectivos">
                    </tbody> 
                    <tfoot class="total_efectivos">
                      
                    </tfoot>
                </table>
            </center>
        </div>

        <div class="modal-footer" id="footer_botones">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<!--END MODAL MOSTRAR-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_inactivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel"><center>Agregar viatico renuncia/despido</center></h3>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                  <div class="col-md-12">
                    <div id="validacion_inactivo" style="color:red"></div>
                    <input type="hidden" name="empleado_inictivo" id="empleado_inictivo" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tipo de anticipo:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="tipo_inactivo" id="tipo_inactivo" onchange="seleccionar_tipo_inactivo()">
                            <option value="1">Viatico total</option>
                            <option value="2">Viatico extra</option>

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Mes aplicar:</label>
                    <div class="col-md-9">
                        <input type="month" name="mes_ingreso_inactivo" id="mes_ingreso_inactivo" class="form-control" value="<?= date('Y-m') ?>">
                    </div>
                </div>

                <div class="form-group row" id="agencia_inactivo_div">
                    <label class="col-md-3 col-form-label">agencia:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="agencia_ingreso_inactivo" id="agencia_ingreso_inactivo" onchange="seleccionar_cartera_inactivo()">
                            <?php
                                foreach($agencias as $agencia){
                                    if($agencia->id_agencia != '00'){
                            ?>
                                    <option value="<?= ($agencia->id_agencia);?>"><?php echo($agencia->agencia);?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="cartera_inactivo_div">
                    <label class="col-md-3 col-form-label">Cartera:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="cartera_viatico_inactivo" id="cartera_viatico_inactivo">
                            
                        </select>
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="dinero_inactivo_cantidad">
                    <label class="col-md-3 col-form-label">Cantidad ($):</label>
                    <div class="col-md-9">
                        <input type="text" name="cantidad_dinero_inactivo" id="cantidad_dinero_inactivo"  class="form-control">
                    </div>
                </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" onclick="insert_viaticos_inactivo()">Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

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

    <form enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="modal fade" id="Modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="exampleModalLabel">Aprobar viaticos</h4>
                    </center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <strong>¿Seguro/a que desea aprobar estos viaticos?</strong><br><br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Contraseña:</label>
                            <div class="col-md-10">
                                <input type="password" name="contra" id="contra" class="form-control"/>
                                <div id="validacion_pass" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a id="btn_rechazar"  class="btn btn-success" onclick="validar_pass()">Aceptar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

<script type="text/javascript">
    $('#mydata').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
    });

    $('#data_efectivo').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
    });

    $('#data_inactivos').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        },
        "order": [[ 4, "desc" ]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );
        }
    });

    


    function guardar_viatico(){
        datos = $('#all_viaticos').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('viaticos/viaticos_guardar')?>",
            dataType : "JSON",
            data : {datos:datos},
            success: function(data){
              //console.log(data);
              if (data==null){
                $("#modalGif").modal('toggle');
                Swal.fire(
                    'Viaticos aprobados correctamente!',
                    '',
                    'success'
                )
                meses_viaticos();
              }else{
                Swal.fire(
                    data,
                    '',
                    'error'
                )
              }
            },
            error: function(data){
              var a =JSON.stringify(data['responseText']);
              alert(a);
            }
        });
    }

    function validar_pass(){
        var contra = $('#contra').val();
        $.ajax({
            type  : 'POST',
            url:"<?php echo site_url('viaticos/valida_password')?>",
            dataType:"JSON",
            data:{contra:contra},
            success : function(data){
                console.log(data);
                if(data == null){
                    $("#Modal_aprobar").modal('toggle');
                    $('[name="contra"]').val("");
                    llamadoAsincrono();
                }else{
                    document.getElementById('validacion_pass').innerHTML = data;
                }
            }

        })
    }

    function resolver1Seg() {
        return new Promise(resolve => {
            setTimeout(() => {
              resolve(guardar_viatico());
            }, 1000);
        });
    }

    async function llamadoAsincrono() {
        $('#modalGif').modal('show');
        await resolver1Seg();
          
    }

    function meses_viaticos(){
        empresa = $('#empresa_viatico').val();
        agencia = $('#agencia_viatico').val();
        mes = $('#mes_viatico').val();
        quincena = $('#quincena_viatico').val();
        input = document.getElementById('agencia_viatico');
        estado_se=$(input).find(':selected').data('estado');

        //console.log(empresa);

        $('#mydata').DataTable().destroy();
        $('#mydata #show_data').empty();
        $('#titulo').empty();
        $('#btn_guardar').empty();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('viaticos/viatico_mes')?>",
            dataType : "JSON",
            data : {empresa:empresa,agencia:agencia,mes:mes,quincena:quincena},
            success: function(data){
                console.log(data);
                document.getElementById('titulo').innerHTML = data.titulo;
                if(<?php echo json_encode($aprobar); ?> == 1 && data.guardar.length > 0){
                    $('#btn_guardar').show();
                    var myJSON = JSON.stringify(data.guardar);
                    $('#all_viaticos').val(myJSON);

                    $("#btn_guardar").append(
                        '<center>'+
                        '<button id="aprobar" name="aprobar" data-toggle="modal" data-target="#Modal_aprobar" class="btn btn-success">Aprobar viaticos</button>'+
                        '</center>'
                    );
                }else if(data.guardar.length == 0 && data.rehazo.length > 0 && <?php echo json_encode($rechazar); ?> == 1){
                    var myJSON = JSON.stringify(data.rehazo);
                    var id_json = JSON.stringify(data.id_rehazo);
                    console.log(id_json);
                    $('#all_viaticos').val(myJSON);
                    $('#id_rehazo').val(id_json);

                    $("#btn_guardar").append(
                        '<center>'+
                        '<button id="rechazo" name="rechazo" class="btn btn-danger" data-toggle="modal" data-target="#Modal_Delete">Rechazar viaticos</button>'+
                        '</center>'
                    );
                }


                $.each(data.viaticos,function(key, registro){
                    if(registro.guardado == 0){
                        estado = '<td style="color: #d9534f"><span title="Viatico no aprobado" class="glyphicon glyphicon-floppy-remove"></span></td>';
                    }else if(registro.guardado == 1){
                        estado = '<td style="color: #5cb85c"><span title="Viatico aprobado" class="glyphicon glyphicon-floppy-saved"></span></td>';
                    }

                    $("#show_data").append(
                      '<tr>'+
                        '<td>'+registro.agencia+'</td>'+  
                        '<td>'+registro.cartera+'</td>'+  
                        '<td>'+registro.nombre+'</td>'+  
                        '<td>'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.mont_gral).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                        '<td>'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                        estado+
                      '</tr>'
                    );
                })
                $('#mydata').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
    });
            },
            error: function(data){
              var a =JSON.stringify(data['responseText']);
              alert(a);
            }
        });
    }

    function delete_viaticos(){
        datos = $('#all_viaticos').val();
        rechazos = $('#id_rehazo').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('viaticos/viaticos_rechazar')?>",
            dataType : "JSON",
            data : {datos:datos,rechazos:rechazos},
            success: function(data){
              //console.log(data);
              if(data == null){
                $("#Modal_Delete").modal('toggle');
                Swal.fire(
                    'Viaticos rechazados correctamente!',
                    '',
                    'success'
                )
                meses_viaticos();
            }else{
                document.getElementById('validacion_rechazo').innerHTML = data;
            }
              
            },
            error: function(data){
              var a =JSON.stringify(data['responseText']);
              alert(a);
            }
        });
    }

    $(function(){
        $('#cobertura_por').maskMoney();
        $('#cantidad_dinero').maskMoney();
        $('#cantidad_dinero_inactivo').maskMoney();
        $('#tipo_inactivo').val(1);
    })
    $('#data_extra').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
    });

    function seleccionar_tipo(){
        tipo_viatico = $('#tipo_viatico').val();

        if(tipo_viatico == 1 || tipo_viatico == 3){
            $('#dias_cobertura').hide();
            $('#por_cobertura').hide();
            $('#dinero_cantidad').hide();
            $('#agencia_div').show();
            $('#cartera_div').show();

        }else if(tipo_viatico == 2){
            $('#dinero_cantidad').hide();
            $('#dias_cobertura').show();
            $('#por_cobertura').show();
            $('#agencia_div').show();
            $('#cartera_div').show();

        }else if(tipo_viatico == 4 || tipo_viatico == 5){
            $('#dinero_cantidad').show();
            $('#dias_cobertura').hide();
            $('#por_cobertura').hide();
            $('#agencia_div').hide();
            $('#cartera_div').hide();

        }else if(tipo_viatico == 6){
            $('#dinero_cantidad').hide();
            $('#dias_cobertura').show();
            $('#por_cobertura').hide();
            $('#agencia_div').show();
            $('#cartera_div').show();
        }

    }


    function ingresar_datos(id_empleado){
        document.getElementById('validacion').innerHTML = '';
        $('[name="codigo_empleado"]').val(id_empleado);
        $('#Modal_agregar').modal('show');
    }

    seleccionar_moto();
    function seleccionar_moto(){
        agencia = $('#agencia_ingreso').val();
        $('#cartera_viatico').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/carteras_agencia')?>",
          dataType : "JSON",
          data : {agencia:agencia},
          success: function(data){
              $.each(data,function(key, registro){
                $("#cartera_viatico").append(
                  '<option value="'+registro.id_cartera+'">'+registro.cartera+'</option>'
                );
              });                          
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

   

    function seleccionar_viaticos(){
        agencia = $('#agencia_viatico_tem').val();
        mes = $('#mes_viatico_temp').val();
        quincena = $('#quincena_viatico_tempo').val();

        $('#data_extra').DataTable().destroy();
        $('#data_extra #show_extra').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/get_viaticos_temp')?>",
          dataType : "JSON",
          data : {agencia:agencia,mes:mes,quincena:quincena},
          success: function(data){
              $.each(data,function(key, registro){
                $("#show_extra").append(
                  '<tr>'+
                    '<td>'+registro.agencia+'</td>'+  
                    '<td>'+registro.nombre+'</td>'+  
                    '<td>'+registro.cargo+'</td>'+  
                    '<td>'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.mant_gral).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                    '<td>'+
                    '<a class="btn btn-success" title="Agregar viatico" onclick=ingresar_datos('+registro.id_empleado+')><span class="glyphicon glyphicon-plus-sign"></span></a>'+
                    '<a href="<?php echo base_url();?>index.php/Viaticos/viaticos_detalle/'+registro.id_empleado+'" class="btn btn-primary" title="Revisar viatico"><span class="glyphicon glyphicon-check"></span></a>'+
                    '</td>'+ 
                  '</tr>'
                );
              }); 

            $('#data_extra').dataTable({
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                },
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
            });                         
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    // function seleccionar_viaticos_control(){
    //     agencia = $('#agencia_viatico_control').val();
    //     mes = $('#mes_viatico_control').val();
    //     quincena = $('#quincena_viatico_control').val();

    //     $('#data_control').DataTable().destroy();
    //     $('#data_control #show_control').empty();.

    //     $.ajax({
    //       type : "POST",
    //       url  : "<?php echo site_url('Viaticos/get_viaticos_temp')?>",
    //       dataType : "JSON",
    //       data : {agencia:agencia,mes:mes,quincena:quincena}, 
    //       success: function(data){
    //         $.each(data,function(key, registro){
    //             $("#show_control").append(
    //               '<tr>'+
    //                 '<td>'+registro.agencia+'</td>'+  
    //                 '<td>'+registro.nombre+'</td>'+  
    //                 '<td>'+registro.cargo+'</td>'+  
    //                 '<td>'+parseFloat(registro.totalViaticos).toFixed(2)+'</td>'+ 
    //                 '<td>'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
    //                 '<td>'+parseFloat(registro.totalViaticos + registro.total).toFixed(2)+'</td>'+ 
    //               '</tr>'
    //             );
    //           }); 
    //       }
    //     });

    // }


    function insert_viaticos(){
        var empleado = $('#codigo_empleado').val();
        var tipo_viatico = $('#tipo_viatico').val();
        var mes = $('#mes_ingreso').val();
        var quincena = $('#quincena_viatico_temp').val();
        var agencia = $('#agencia_ingreso').val();
        var cartera = $('#cartera_viatico').val();
        var cobertura_dias = $('#cobertura_dias').val();
        var cobertura_por = $('#cobertura_por').val();
        var cantidad_dinero = $('#cantidad_dinero').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Viaticos/insert_temporal')?>",
            dataType : "JSON",
            data : {empleado:empleado,tipo_viatico:tipo_viatico,mes:mes,quincena:quincena,agencia:agencia,cartera:cartera,cobertura_dias:cobertura_dias,cobertura_por:cobertura_por,cantidad_dinero:cantidad_dinero},
            success: function(data){
                if(data == null){
                    Swal.fire(
                        'Depreciacion editada correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion').innerHTML = '';
                    $('[name="cobertura_dias"]').val("");
                    $('[name="cobertura_por"]').val("");
                    $('[name="cantidad_dinero"]').val("");
                    $('[name="tipo_viatico"]').val(1);
                    $("#Modal_agregar").modal('toggle');
                    seleccionar_tipo();
                    seleccionar_viaticos();
                    meses_viaticos();
                }else{
                    //console.log(data);
                    document.getElementById('validacion').innerHTML = data;
                }
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function seleccionar_efectivos(){
        agencia = $('#agencia_viatico_efec').val();
        mes = $('#mes_viatico_efec').val();
        quincena = $('#quincena_viatico_efec').val();

        $('#data_efectivo').DataTable().destroy();
        $('#data_efectivo #show_efectivo').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/get_viaticos_efec')?>",
          dataType : "JSON",
          data : {agencia:agencia,mes:mes,quincena:quincena},
          success: function(data){
              $.each(data,function(key, registro){
                $("#show_efectivo").append(
                  '<tr>'+
                    '<td>'+registro.agencia+'</td>'+  
                    '<td>'+registro.nombre+'</td>'+  
                    '<td>'+registro.cargo+'</td>'+  
                    '<td>$'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.mant_gral).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                    '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                    '<td>'+
                    '<a class="btn btn-primary" title="Revisar viaticos" data-mes="'+registro.mes+'" data-quincena='+registro.quincena+' data-id_empleado='+registro.id_empleado+' onclick="get_efectivos(this)" ><span class="glyphicon glyphicon-check"></span></a>'+
                    '</td>'+ 
                  '</tr>'
                );
              }); 

            $('#data_efectivo').dataTable({
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                },
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_consumo = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_consumo = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                '$'+number_format(pageTotal_consumo,2,',','') +' ($'+ number_format(total_consumo,2,',','') +' global)'
            );

            // Total over all pages
            total_dep = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_dep = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '$'+number_format(pageTotal_dep,2,',','') +' ($'+ number_format(total_dep,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_de = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_de = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_de,2,',','') +' ($'+ number_format(total_llanta_de,2,',','') +' global)'
            );

            // Total over all pages
            total_llanta_tra = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_llanta_tra = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '$'+number_format(pageTotal_llanta_tra,2,',','') +' ($'+ number_format(total_llanta_tra,2,',','') +' global)'
            );

            // Total over all pages
            total_mant = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_mant = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                '$'+number_format(pageTotal_mant,2,',','') +' ($'+ number_format(total_mant,2,',','') +' global)'
            );

            // Total over all pages
            total_aceite = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal_aceite = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                '$'+number_format(pageTotal_aceite,2,',','') +' ($'+ number_format(total_aceite,2,',','') +' global)'
            );

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
            );

        }
            });                         
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    function get_efectivos(boton){
        var mes =  boton.dataset.mes;
        var quincena = boton.dataset.quincena;
        var id_empleado = boton.dataset.id_empleado;

        consumo_ruta=0;
        depreciacion=0;
        llanta_del=0;
        llanta_tra=0;
        mant_gral=0;
        aceite=0;
        total=0;

        $('#datos').DataTable().destroy();
        $('#datos .datos_empleado').empty();

        $('#efectivos').DataTable().destroy();
        $('#efectivos .datos_efectivos').empty();
        $('#efectivos .total_efectivos').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/datos_efectivos')?>",
          dataType : "JSON",
          data : {mes:mes,quincena:quincena,id_empleado:id_empleado},
          success: function(data){
                $(".datos_empleado").append(
                  '<tr>'+
                    '<td>'+data.empleado[0].nombre+'</td>'+   
                    '<td>'+data.empleado[0].agencia+'</td>'+   
                    '<td>'+data.empleado[0].cargo+'</td>'+   
                    '<td>'+data.empleado[0].mes+'</td>'+   
                    '<td>'+data.empleado[0].quincena+'</td>'+   
                  '</tr>'
                );

                $.each(data.viaticos,function(key, registro){
                    if(registro.tipo == 1){
                        tipo = 'Ruta';
                    }else if(registro.tipo == 2){
                        tipo = 'Total';
                    }else if(registro.tipo == 3){
                        tipo = 'Parcial';
                    }else if(registro.tipo == 4){
                        tipo = 'Adicional';
                    }else if(registro.tipo == 5){
                        tipo = 'Extra';
                    }else if(registro.tipo == 6){
                        tipo = 'Permanente';
                    }

                    consumo_ruta+=parseFloat(registro.consumo_ruta);
                    depreciacion+=parseFloat(registro.depreciacion);
                    llanta_del+=parseFloat(registro.llanta_del);
                    llanta_tra+=parseFloat(registro.llanta_tra);
                    mant_gral+=parseFloat(registro.mant_gral);
                    aceite+=parseFloat(registro.aceite);
                    total+=parseFloat(registro.total);

                    $(".datos_efectivos").append(
                      '<tr>'+
                        '<td>'+tipo+'</td>'+  
                        '<td>$'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.mant_gral).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                        '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                      '</tr>'
                    );
                });

                $(".total_efectivos").append(
                  '<tr>'+
                    '<td><b>Total</b></td>'+  
                    '<td><b>$'+consumo_ruta.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+depreciacion.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+llanta_del.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+llanta_tra.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+mant_gral.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+aceite.toFixed(2)+'</b></td>'+ 
                    '<td><b>$'+total.toFixed(2)+'</b></td>'+ 
                  '</tr>'
                );

            $('#efectivos').dataTable({
                "bAutoWidth": false,
                "paging": false,
                "searching": false,
                "info": false,
            });

            $('#Modal_datos').modal('show');                          
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }
    select_agencia();
    function select_agencia(){
        var empresa = $('#empresa_viatico').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Viaticos/agencias_viaticos')?>",
            dataType : "JSON",
            data : {empresa:empresa},
            success: function(data){
                //console.log(data);
                $("#agencia_viatico").empty();
                $("#agencia_viatico").append('<option value="todas" data-estado="1">Todas</option>');
                $.each(data,function(key, registro) {
                    $("#agencia_viatico").append('<option value='+registro.id_agencia+' data-estado="0">'+registro.agencia+'</option>');
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

    inactivo_agencia();
    function inactivo_agencia(){
        var empresa = $('#empresa_inactivo').val();
        estado = 1;
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Viaticos/agencias_viaticos')?>",
            dataType : "JSON",
            data : {empresa:empresa,estado:estado},
            success: function(data){
                $("#agencia_inactivo").empty();
                $("#agencia_inactivo").append('<option value="todas" data-estado="1">Todas</option>');
                $.each(data,function(key, registro) {
                    $("#agencia_inactivo").append('<option value='+registro.id_agencia+' data-estado="0">'+registro.agencia+'</option>');
                });
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });
        return false;
    }

    function seleccionar_inactivo(){
        empresa = $('#empresa_inactivo').val();
        agencia = $('#agencia_inactivo').val();
        mes = $('#mes_inactivo').val();
        renuncia = '';
        //console.log(agencia);

        $('#data_inactivos').DataTable().destroy();
        $('#data_inactivos #show_inactivos').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/get_viaticos_inac')?>",
          dataType : "JSON",
          data : {empresa:empresa,agencia:agencia,mes:mes},
          success: function(data){
              $.each(data,function(key, registro){
                if(registro.tipo_des_ren == 1){
                    renuncia = 'Despido sin responsabilidad';
                }else if(registro.tipo_des_ren == 2){
                    renuncia = 'Despido con responsabilidad';
                }else if(registro.tipo_des_ren == 3){
                    renuncia = 'No aprobo periodo de prueba';
                }else if(registro.tipo_des_ren == 4){
                    renuncia = 'Renuncia con previo aviso';
                }else if(registro.tipo_des_ren == 5){
                    renuncia = 'Abandono de puesto';
                }
                $("#show_inactivos").append(
                  '<tr>'+
                    '<td>'+registro.agencia+'</td>'+  
                    '<td>'+registro.nombre_empresa+'</td>'+  
                    '<td>'+registro.nombre+'</td>'+  
                    '<td>'+registro.cargo+'</td>'+  
                    '<td>'+registro.fecha_fin+'</td>'+  
                    '<td>'+renuncia+'</td>'+  
                    '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+  

                    '<td>'+
                    '<a class="btn btn-success" title="Agregar viatico" onclick="datos_inactivos('+registro.id_empleado+')"><span class="glyphicon glyphicon-plus-sign"></span></a>'+
                    '<a class="btn btn-primary" title="Revisar viaticos" href="<?php echo base_url();?>index.php/Viaticos/viaticos_detalle_inactivo/'+registro.id_empleado+'"><span class="glyphicon glyphicon-check"></span></a>'+
                    '</td>'+ 
                  '</tr>'
                );
              }); 

            $('#data_inactivos').dataTable({
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                },
                "order": [[ 4, "desc" ]],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over all pages
                    total = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Total over this page
                    pageTotal = api
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        '$'+number_format(pageTotal,2,',','') +' ($'+ number_format(total,2,',','') +' global)'
                    );
                }
            });                         
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    function seleccionar_tipo_inactivo(){
        tipo_inactivo = $('#tipo_inactivo').val();

        if(tipo_inactivo == 1){
            $('#dinero_inactivo_cantidad').hide();
            $('#cartera_inactivo_div').show();
            $('#agencia_inactivo_div').show();
        }else if(tipo_inactivo == 2){
            $('#dinero_inactivo_cantidad').show();
            $('#cartera_inactivo_div').hide();
            $('#agencia_inactivo_div').hide();
        }
    }

    function datos_inactivos(id_empleado){
        document.getElementById('validacion_inactivo').innerHTML = '';
        $('[name="empleado_inictivo"]').val(id_empleado);
        $('#Modal_inactivo').modal('show');
    }

    seleccionar_cartera_inactivo();
    function seleccionar_cartera_inactivo(){
        agencia = $('#agencia_ingreso_inactivo').val();
        $('#cartera_viatico_inactivo').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/carteras_agencia')?>",
          dataType : "JSON",
          data : {agencia:agencia},
          success: function(data){
            console.log(data);
              $.each(data,function(key, registro){
                $("#cartera_viatico_inactivo").append(
                  '<option value="'+registro.id_cartera+'">'+registro.cartera+'</option>'
                );
              });                          
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    function insert_viaticos_inactivo(){
        var empleado = $('#empleado_inictivo').val();
        var tipo = $('#tipo_inactivo').val();
        var mes = $('#mes_ingreso_inactivo').val();
        var agencia = $('#agencia_ingreso_inactivo').val();
        var cartera = $('#cartera_viatico_inactivo').val();
        var cantidad_dinero = $('#cantidad_dinero_inactivo').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Viaticos/insert_viatico_inactivo')?>",
            dataType : "JSON",
            data : {empleado:empleado,tipo:tipo,mes:mes,agencia:agencia,cartera:cartera,cantidad_dinero:cantidad_dinero},
            success: function(data){
                if(data == null){
                    Swal.fire(
                        'Depreciacion editada correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion_inactivo').innerHTML = '';
                    $("#Modal_inactivo").modal('toggle');
                    seleccionar_tipo_inactivo();
                    seleccionar_inactivo();
                }else{
                    document.getElementById('validacion_inactivo').innerHTML = data;
                }
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    //WM08052023 funcion para llenar campos de tabla de control de viaticos
    $(document).ready(function() {
    // Escuchar el evento submit del formulario
        $('#form_viaticos_control').on('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario

            // Obtener los valores de los select del formulario
            var agencia = $('#agencia_viatico_control').val();
            var mes = $('#mes_viatico_control').val();
            var quincena = $('#quincena_viatico_control').val();

            // Realizar la consulta AJAX
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Viaticos/viaticos_control')?>",
                dataType: "JSON",
                data: {agencia: agencia, mes: mes, quincena: quincena},
                success: function(data) {
                    console.log(data)

                    // Limpiar la tabla y agregar los nuevos resultados
                    $('#show_control').empty();
                    // WM31052023 se modifico los td por cada uno de los viaticos que se tienen en la empresa
                    $.each(data, function(key, registro) {
                       $("#show_control").append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>'+parseFloat(registro.totalCartera).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.totalXtra).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.totalPermanentes).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.totalParciales).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.totalCompartido).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.ViaticoNeto).toFixed(2)+'</td>'+
                            '</tr>'
                        ); 
                    
                    });
                    }
            });
            // console.log(viaticosArray)     
        });
    });

    // mascara para los input que deben contener unicamente numeros, solo se debe añadir la clase numbers o number-only
    $("input.numbers").keypress(function(event) {
      return /\d/.test(String.fromCharCode(event.keyCode));
    });

    $(function(){
        $('.number-only').keypress(function(e) {
            if(isNaN(this.value+""+String.fromCharCode(e.charCode))) return false;
        })

    });
    $('number-only').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
    $('#cobertura_dias').bind('paste', function (e) { e.preventDefault(); });
</script>