<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Planes disponibles</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <!-- <nav class="float-right"><?php ?><a href="<?= base_url();?>index.php/Tesoreria/planes" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar nuevo plan</a><?php ?><br><br></nav> -->
                        <table class="table table-striped" id="mydata" name="mydata"> 
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Nombre del plan</th>
                                    <th style="text-align:left;">Disponibilidad del plan</th>      
                                    <th style="text-align:left;">Precio del plan</th>
                                    <th style="text-align:left;">Contrata</th>

                                    <th style="text-align:left;">Acciones</th>


                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php

                               foreach ($planes as $tipo) {
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
                                   echo '<td style="text-align: left;">'.$tipo->nombre_plan."</td>";
                                   echo '<td style="text-align: left;">'.$tipo->cantidad. "</td>";
                        
                                   echo '<td style="text-align: left;">'. '$' .round($tipo->precio_plan,2)."</td>";
                                   echo '<td style="text-align: left;">'.$tipo->nombre_empresa."</td>";

                                    echo '<td><a class="btn btn-primary btn-sm" href="'.base_url().'index.php/Tesoreria/llenarPlanes/' . $tipo->id_plan .'">Ver detalles </a></td>';

    
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
        <script type="text/javascript">

             $(document).ready(function(){

    $('#mydata').dataTable( {
    
            "oLanguage": {
                "sSearch": "Buscador: "
            }
        } );
        } );

           function item_ver(boton){
        var code   = boton.dataset.codigo;

        console.log(code);


        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Tesoreria/llenarPlanes')?>",
          dataType : "JSON",
          data : {code:code},
          success: function(data){
            $('#Modal_ver').modal('show');
          },  
          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
        return false;
      }
  </script>