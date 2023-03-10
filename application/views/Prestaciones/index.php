<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Renta</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Tramo</th>      
                                    <th style="text-align:center;">Desde</th>
                                    <th style="text-align:center;">Hasta</th>
                                    <th style="text-align:center;">Porcentaje</th>
                                    <th style="text-align:center;">Sobre  el exceso</th>
                                    <th style="text-align:center;">Cuota Fija</th>
                                    <th style="text-align:center;">Pagadas a</th>
                                    <th style="text-align: center" colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                            <tbody>
                                <?php
                              
                                foreach ($rentas as $renta) {
                                   
                                   echo "<tr>";
                                   echo "<td>".$renta->tramo."</td>";
                                   echo "<td>$ ".number_format($renta->desde,2)."</td>";
                                   echo "<td>$ ".number_format($renta->hasta,2)."</td>";
                                   echo "<td>".number_format(($renta->porcentaje*100),2)." %</td>";
                                   echo "<td>$ ".number_format($renta->sobre,2)."</td>";
                                   echo "<td>$ ".number_format($renta->cuota,2)."</td>";
                                   echo "<td>".$renta->nombre."</td>";
                                   echo '<td style="text-align:right;"><a href="#" data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_renta="'.$renta->id_renta.'"> Editar </a></td>';
                                   echo '<td><a href="#" data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$renta->id_renta.'"> Eliminar </a></td>';
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
    </div>
</div>
<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tramo de Renta</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tramo:</label>
                    <div class="col-md-10">
                        <input type="text" name="tramo_name" id="tramo_name" class="form-control" placeholder="Ingrese la nuevo tramo">
                    </div>
                </div>
            

           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Desde:</label>
                    <div class="col-md-10">
                        <input type="text" name="desde_name" id="desde_name" class="form-control" placeholder="Desde">
                    </div>
                </div>
            
            
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta:</label>
                    <div class="col-md-10">
                        <input type="text" name="hasta_name" id="hasta_name" class="form-control" placeholder="Hasta">
                    </div>
                </div>
           

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_name" id="porcentaje_name" class="form-control" placeholder="Porcentaje">
                    </div>
                </div>
           
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Sobre  el exceso:</label>
                    <div class="col-md-10">
                        <input type="text" name="sobre_name" id="sobre_name" class="form-control" placeholder="Sobre">
                    </div>
                </div>
           

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuota Fija:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuota_name" id="cuota_name" class="form-control" placeholder="Cuota">
                    </div>
                </div>
            
            
             
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pagadas a:</label>
                    <div class="col-md-10">
                         <select name="pagadas_name" id="pagadas_name" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($tiempo as $a){
                        
                        ?>
                            <option id="<?= ($tiempo[$i]->id_tiempo);?>"><?php echo($tiempo[$i]->nombre);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                        </select>
                    </div>
                </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->


 <!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Tramo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <!--
                <label class="col-md-2 col-form-label">Product Code</label>
-->
                <div class="col-md-10">
                    <input type="hidden" name="renta_code_edit" id="renta_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tramo:</label>
                <div class="col-md-10">
                    <input type="text" name="tramo_edit" id="tramo_edit" class="form-control" placeholder="Ingresa cambio de descuentos">
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Desde:</label>
                <div class="col-md-10">
                    <input type="text" name="desde_edit" id="desde_edit" class="form-control" placeholder="Ingresa cambio de porcentaje">
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Hasta:</label>
                <div class="col-md-10">
                    <input type="text" name="hasta_edit" id="hasta_edit" class="form-control" placeholder="Ingresa cambio de techo">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Porcentaje:</label>
                <div class="col-md-10">
                    <input type="text" name="porcentaje_edit" id="porcentaje_edit" class="form-control" placeholder="Ingresa cambio de techo">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sobre:</label>
                <div class="col-md-10">
                    <input type="text" name="sobre_edit" id="sobre_edit" class="form-control" placeholder="Ingresa cambio de techo">
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Cuota:</label>
                <div class="col-md-10">
                    <input type="text" name="cuota_edit" id="cuota_edit" class="form-control" placeholder="Ingresa cambio de techo">
                </div>
            </div>

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pagadas a:</label>
                    <div class="col-md-10">
                         <select name="pagadas_edit" id="pagadas_edit" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($tiempo as $a){
                        
                        ?>
                            <option id="<?= ($tiempo[$i]->id_tiempo);?>" value="<?= ($tiempo[$i]->id_tiempo);?>"><?php echo($tiempo[$i]->nombre);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                        </select>
                    </div>
                </div>
            

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
            </div>

            </div>           
        </div>
        </div>
    </div>
</form>
        <!--END MODAL EDIT-->

        <!--MODAL DELETE-->
        <form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Renta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="renta_code_delete" id="renta_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->

<script type="text/javascript">
    $(document).ready(function(){

        $('#mydata').dataTable( {
            "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
            "iDisplayLength": 5,
            "oLanguage": {
                "sLengthMenu": "Your words here _MENU_ and/or here",
            },
            "oLanguage": {
                "sSearch": "Buscador: "
            },
            "search": {
                "caseInsensitive": false
            },
            responsive: true
        } );

        //Metooo para e ingreso 
        $('#btn_save').on('click',function(){
            var tramo_name = $('#tramo_name').val();
            var desde_name = $('#desde_name').val();
            var hasta_name = $('#hasta_name').val();
            var porcentaje_name = ($('#porcentaje_name').val())/100;
            var sobre_name = $('#sobre_name').val();
            var cuota_name = $('#cuota_name').val();
            var pagadas_name = $('#pagadas_name').children(":selected").attr("id");

            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/saveRenta')?>",
                dataType : "JSON",
                data : {tramo_name:tramo_name,desde_name:desde_name,hasta_name:hasta_name,porcentaje_name:porcentaje_name,sobre_name:sobre_name,cuota_name:cuota_name,pagadas_name:pagadas_name},
                success: function(data){
                    $('[name="tramo_name"]').val("");
                    $('[name="desde_name"]').val("");
                    $('[name="hasta_name"]').val("");
                    $('[name="porcentaje_name"]').val("");
                    $('[name="sobre_name"]').val("");
                    $('[name="cuota_name"]').val("");
                    $('[name="pagadas_name"]').val("");
                    location.reload();
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
        });//fin de insercionde 

        //Metodo para llenar los campos de modificar
        $('.item_edit').click(function(){
           var code = $(this).data('id_renta');
          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/llenarEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="renta_code_edit"]').val(data[0].id_renta);
                    $('[name="tramo_edit"]').val(data[0].tramo);
                    $('[name="desde_edit"]').val(data[0].desde);
                    $('[name="hasta_edit"]').val(data[0].hasta);
                    $('[name="porcentaje_edit"]').val(data[0].porcentaje);
                    $('[name="sobre_edit"]').val(data[0].sobre);
                    $('[name="cuota_edit"]').val(data[0].cuota);
                    $('[name="pagadas_edit"]').val(data[0].id_tiempo);
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         });//fin llenado de modal editar

        //metodo para modificar 
        $('#btn_update').on('click',function(){
            var code = $('#renta_code_edit').val();
            var tramo = $('#tramo_edit').val();
            var desde = $('#desde_edit').val();
            var hasta = $('#hasta_edit').val();
            var porcentaje = $('#porcentaje_edit').val();
            var sobre = $('#sobre_edit').val();
            var cuota = $('#cuota_edit').val();
            var pagadas = $('#pagadas_edit').children(":selected").attr("id");
            
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/updateRenta')?>",
                dataType : "JSON",
                data : {code:code,tramo:tramo,desde:desde,hasta:hasta,porcentaje:porcentaje,sobre:sobre,cuota:cuota,pagadas:pagadas},
                success: function(data){
                    $('[name="renta_code_edit"]').val("");
                    $('[name="tramo_edit"]').val("");
                    $('[name="desde_edit"]').val("");
                    $('[name="hasta_edit"]').val("");
                    $('[name="porcentaje_edit"]').val("");
                    $('[name="sobre_edit"]').val("");
                    $('[name="cuota_edit"]').val("");
                    $('[name="pagadas_edit"]').val("");

                    $('#Modal_Edit').modal('toggle');
                    $('.modal-backdrop').remove();
                    location.reload();

                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo modificar

         //se obtiene el id para poder eliminar
        $('.item_delete').click(function(){
            var code   = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="renta_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#renta_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/deleteRenta')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="renta_code_delete"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();
                    location.reload();

                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo eliminar 

    });
</script>
</body>

</html> 