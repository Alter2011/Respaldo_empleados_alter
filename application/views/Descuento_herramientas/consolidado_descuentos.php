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
                <h2>Consolidado descuento de Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel" id="contenido">
                    <div class="panel-body">
                     
                    <ul class="nav nav-tabs ocultar">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Descuentos</a></li>
                    </ul>
                   

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                           
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

                                    <div class="form-group col-md-3">
                                        <label for="inputState">Mes de Prestamo</label>
                                        <input type="month" class="form-control" id="mes_reporte" name="mes_reporte" value="<?php echo date('Y-m')?>">
                                    </div>
                                     

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
                        

                    </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>


<!-- Llamar JavaScript -->

