<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Servicios disponibles</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                         <nav class="float-right"><?php ?><a href="<?= base_url();?>index.php/Tesoreria/ver_planes" class="btn btn-primary"><span></span>Volver</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>

                                    <th style="text-align:left;">Nombre de servicio</th>
                                    <th style="text-align:left;">Tipo de servicio</th>
                                    <th style="text-align:left;">Cantidad disponible del servicio</th>

                                    <th style="text-align:left;">Descripcion del servicio</th>

                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php

                               foreach ($ver_servicios as $tipo) {

                                //print_r($tipo);

                                 /*  if($tipo->Tipo_empresa == 1){
                                        $type = 'Claro S.A de C.V';
                                   }elseif($tipo->Tipo_empresa == 2){
                                        $type = 'Movistar S.A de C.V';
                                   }elseif($tipo->Tipo_empresa == 3){
                                     $type = 'Digicel S.A de C.V';
                                   }elseif($tipo->Tipo_empresa == 4){
                                     $type = 'Tigo S.A de C.V';
                                   }*/

                                   echo "<tr>";
                                   echo '<td style="text-align: left;">'.$tipo->nombre_servicio."</td>";
                                   echo '<td style="text-align: left;">'.$tipo->n_servicio."</td>";
                                   echo '<td style="text-align: left;">'.$tipo->cantidad. " " .$tipo->abreviatura."</td>";
                                   echo '<td style="text-align: left;">'.$tipo->descripcion."</td>";
                                   echo "</tr>";
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