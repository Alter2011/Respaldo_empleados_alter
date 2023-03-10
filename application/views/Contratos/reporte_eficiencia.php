<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Reporte de efectividad</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">

                <table class="table table-bordered" id="mydata">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Empresa</th>      
                            <th style="text-align:center;">Region</th>      
                            <th style="text-align:center;">Agencia</th>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align: center">S base</th>
                            <th style="text-align: center">Cargo</th>
                            <th style="text-align: center">F Inicio</th>
                            <th style="text-align: center"><?=ucfirst(strtolower($mes3))?> E</th>
                            <th style="text-align: center"><?=ucfirst(strtolower($mes2))?> E</th>
                            <th style="text-align: center"><?=ucfirst(strtolower($mes1))?> E</th>
                        </tr>
                    </thead>
                    <tbody id="show_data">
                        <?php
                              
                            foreach ($empleados as $empleado) {
                                echo "<tr>";
                                echo "<td>".$empleado->nombre_empresa."</td>";
                                echo "<td>".$empleado->region."</td>";
                                echo "<td>".$empleado->agencia."</td>";
                                echo "<td>".$empleado->nombre." ".$empleado->apellido."</td>";
                                echo "<td>".$empleado->Sbase."</td>";
                                echo "<td>".$empleado->cargo."</td>";
                                echo "<td>".$empleado->fecha_i."</td>";
                                echo "<td>".$empleado->efectiva1."</td>";
                                echo "<td>".$empleado->efectiva2."</td>";
                                echo "<td>".$empleado->efectiva3."</td>";
                                
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
                
    </div>
</div>