<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script> 
        <div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">

            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">

                    <div class="text-center well text-white blue no-print" id="prueba">
                        <h2>Reporte AFP</h2>

                        <form action="<?php echo base_url('index.php/Cambios/afpExcel'); ?>"  method="post">
                            <input type="hidden" id="empresa" name="empresa" value="<?php echo $empresa;?>">
                            <input type="hidden" id="mes_afp" name="mes_afp" value="<?php echo $mes_afp;?>">
                            <button type="submit" id="imprimir" class="btn btn-success btn-lg item_filtrar">Imprimir</button> 
                        </form>

                    </div>
                    <table class="table table-bordered" id="myTable" border="1">
                        <thead class="text-center">
                            <tr>
                                <th><center>N°</center></th>
                                <th><center>NUP</center></th>
                                <th><center>Institucion Previsional</center></th>
                                <th><center>Primer Nombre</center></th>
                                <th><center>Segundo Nombre</center></th>
                                <th><center>Primer Apellido</center></th>
                                <th><center>Segundo Apellido</center></th>
                                <th><center>Apellido Casada</center></th>
                                <th><center>Conocido Por</center></th>
                                <th><center>Genero</center></th>
                                <th><center>EstadoCivil</center></th>
                                <th><center>Fecha Nacimiento</center></th> 
                                <th><center>Tipo Documento</center></th>                               
                                <th><center>Numero Documento</center></th>                               
                                <th><center>NIT</center></th>                               
                                <th><center>Numero Isss</center></th>                               
                                <th><center>Numero Inpep</center></th>                               
                                <th><center>Nacionalidad</center></th>                               
                                <th><center>Salario Nominal</center></th>                               
                                <th><center>Puesto Trabajo</center></th>                               
                                <th><center>Direccion</center></th>                               
                                <th><center>Municipio</center></th>                               
                                <th><center>Departamento</center></th>                               
                                <th><center>Numero Telefonico</center></th>                               
                                <th><center>Correo Electronico</center></th>                               
                                <th><center>Tipo Empleado</center></th>                               
                                <th><center>Fecha Ingreso</center></th>                               
                                <th><center>Fecha Retiro</center></th>                               
                                <th><center>Fecha Fallecimiento</center></th>                               
                                <th><center>Planilla Periodo Devengue</center></th>                               
                                <th><center>Planilla Codigos Observacion</center></th>                               
                                <th><center>Planilla Ingreso Base Cotizacion</center></th>                               
                                <th><center>Planilla Horas Jornada Laboral</center></th>                               
                                <th><center>Planilla Dias Cotizados</center></th>                               
                                <th><center>Planilla Cotizacion Voluntaria Afiliado</center></th>                               
                                <th><center>Planilla Cotizacion Voluntaria Empleador</center></th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;          
                            foreach($afp as $key ){ 
                            ?>

                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?=$key['nup'];?></td>
                                <td><?=$key['institucion'];?></td>
                                <td><?=$key['nombre1'];?></td>
                                <td><?=$key['nombre2'];?></td>
                                <td><?=$key['apellido1'];?></td>
                                <td><?=$key['apellido2'];?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?=$key['genero'];?></td>
                                <td><?=$key['estado'];?></td>
                                <td><?=$key['fechaNac'];?></td>
                                <td><?=$key['doc'];?></td>
                                <td><?=$key['dui'];?></td>
                                <td><?=$key['nit'];?></td>
                                <td><?=$key['isss'];?></td>
                                <td>&nbsp;</td>
                                <td><?=$key['nacionalidad'];?></td>
                                <td><?=$key['salarioNo'];?></td>
                                <td><?=$key['cargo'];?></td>
                                <td><?=$key['direccion'];?></td>
                                <td>210</td>
                                <td>02</td>
                                <td>24480554</td>
                                <td>&nbsp;</td>
                                <td>P</td>
                                <td><?=$key['fechaIngreso'];?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?=$key['planillaPeri'];?></td>
                                <td><?=$key['codigo'];?></td>
                                <td><?=$key['ingresoBase'];?></td>
                                <td><?=$key['horas'];?></td>
                                <td><?=$key['dias'];?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <?php 
                            $i++;
                        } ?>

                  </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-md-6" >

                </div>
                <div class="col-sm-9 col-md-6" >
                    
                </div>
                
            </div>
        </div>
    </body>
</html>
