<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Historico de plazas ocupadas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">

                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                   
                                    <th style="text-align:center;">Empleado</th> 
                                    <th style="text-align:center;">Fecha inicio</th>      
                                    <th style="text-align:center;">Fecha finalizacion</th>
  
                                </tr>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                            <?php foreach ($empleados as $empleado) { 
                               
                                ?>
                                    <tr>
                                    <td><?= $empleado->nombre.' '.$empleado->apellido  ?></td>
                                    <td><?= $empleado->fecha_inicio ?></td>
                                    <td><?= $empleado->fecha_fin ?></td>
                                    </tr>
                             <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                
            </div>
        </div>
    </div>
</div>