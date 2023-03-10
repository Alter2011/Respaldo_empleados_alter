<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->



        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Agencias</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php if ($crear==1) {?>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php }?></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th>Codigo Agencia</th>
                                    
                                    <th>Titulo</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Tipo</th>
                                    <th>Número de plazas</th>
                                    <th style="text-align: right;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                
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
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Agencia Nueva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="validacion" style="color:red"></div>
                    <?php
                        //if($this->session->userdata('rol')=="Administrador"){ 
                    /*if ($this->session->flashdata('errors')){
                        echo '<div class="alert alert-danger">';
                        echo $this->session->flashdata('errors');
                        echo "</div>";
                    } */
                    ?>
                       
                        <!--<div class="form-group row">
                            <label class="col-md-2 col-form-label">Codigo agencia</label>
                            <div class="col-md-10">
                              <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                            </div>
                        </div>-->
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Titulo</label>
                            <div class="col-md-10">
                              <input type="text" name="agn_titulo" id="agn_titulo" class="form-control" placeholder="Nombre Agencia" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                            <input type="text" name="agn_dir" id="agn_dir" class="form-control" placeholder="Direccion Agencia" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Telefono</label>
                            <div class="col-md-10">
                              <input type="text" name="agn_tel" id="agn_tel" class="form-control" placeholder="####-####" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Techo</label>
                            <div class="col-md-10">
                              <input type="text" name="agn_techo" id="agn_techo" class="form-control" placeholder="####" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Costo de Vida</label>
                            <div class="col-md-10">
                              <input type="text" name="agn_costo" id="agn_costo" class="form-control" placeholder="##" >
                            </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-2 col-form-label">Tipo</label>
                            <div class="col-md-10">
                            <select name="agn_tipo" id="agn_tipo" class="form-control" placeholder="Tipo">
                                    <option id=1>Agencia</option>
                                    <option id=2>Punto</option>
                                    <option id=3>Mini-Agencia</option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-2 col-form-label">Numero de Plazas</label>
                            <div class="col-md-10">
                              <input type="number" name="agn_totalPlaza" id="agn_totalPlaza" class="form-control" placeholder="Numero de agencias" min="1" max="15" value="1">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Pais</label>
                            <div class="col-md-10">
                              <select class="form-control" name="agn_pais" id="agn_pais" class="form-control">
                                         <?php
                                            $i=0;
                                            foreach($paises as $a){
                                        ?>
                                            <option id="<?= ($paises[$i]->id_pais);?>" value="<?= ($paises[$i]->id_pais);?>"><?php echo($paises[$i]->nombre_pais);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-2 col-form-label">De la Empresa</label>
                            <div class="col-md-10">
                            <?php
                            if($empresas != null){
                                foreach ($empresas as $empresa) { ?>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check" name="check" value="<?php echo($empresa->id_empresa);?>" class="check_imprimir"><?php echo($empresa->nombre_empresa);?>
                                    </label>
                            <?php 
                                } 
                            }else{
                                echo 'No hay empresas registradas';
                            } ?>
                            </div>
                        </div>
                        
                    <?php //}else{?>
                       
                    <?php // }?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <?php
                        //if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    <button type="button" type="submit" id="save_agn_controller" class="btn btn-primary">Guardar</button>
                    <?php
                       // }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            </form>
<!--END MODAL ADD-->

<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Agencia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                  <div id="validacion_edit" style="color:red"></div>
                <div class="form-group row">
                    <!--
                    <label class="col-md-2 col-form-label">Product Code</label>
                    -->    
                </div>
                <div class="form-group row">
                   
                    <div class="col-md-10">
                        <input type="hidden" name="agn_code_edit" id="agn_code_edit" class="form-control" placeholder="Product Code">
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Titulo</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_titulo_edit" id="agn_titulo_edit" class="form-control" placeholder="Nombre Agencia">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Direccion</label>
                    <div class="col-md-10">
                    <input type="text" name="agn_dir_edit" id="agn_dir_edit" class="form-control" placeholder="Direccion">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Telefono</label>
                    <div class="col-md-10">
                        <input type="mail" name="agn_tel_edit" id="agn_tel_edit" class="form-control" placeholder="####-####">
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Techo</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_techo_edit" id="agn_techo_edit" class="form-control" placeholder="####" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Costo de Vida</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_costo_edit" id="agn_costo_edit" class="form-control" placeholder="##" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo</label>
                    <div class="col-md-10">
                    <select name="agn_tipo_edit" id="agn_tipo_edit" class="form-control" placeholder="Price">
                            <option id=1>Agencia</option>
                            <option id=2>Punto</option>
                            <option id=3>Mini-Agencia</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Numero de Plazas</label>
                     <div class="col-md-10">
                    <input type="text" name="agn_totalPlaza_edit" id="agn_totalPlaza_edit" class="form-control" placeholder="Numero de agencias">
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pais</label>
                    <div class="col-md-10">
                    <select class="form-control" name="agn_pais_edit" id="agn_pais_edit" class="form-control">
                        <?php
                            $i=0;
                            foreach($paises as $a){
                        ?>
                        <option id="<?= ($paises[$i]->id_pais);?>" value="<?= ($paises[$i]->id_pais);?>"><?php echo($paises[$i]->nombre_pais);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                    </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">De la Empresa</label>
                    <div class="col-md-10" id="check_edit" name="check_edit">
                         
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <strong>¿Seguro que desea eliminar?</strong>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="agn_code_delete" id="agn_code_delete" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
            </div>
        </div>
        </div>
    </div>
</form>

<!--END MODAL DELETE-->
<!--MODAL READ-->
<form>
    <div class="modal fade" id="Modal_Read" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ver Datos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">      
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Titulo</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_titulo_read" id="agn_titulo_read" class="form-control" placeholder="Nombre usuario" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Direccion</label>
                    <div class="col-md-10">
                    <input type="text" name="agn_dir_read" id="agn_dir_read" class="form-control" placeholder="Apellido usuario" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Telefono</label>
                    <div class="col-md-10">
                        <input type="mail" name="agn_tel_read" id="agn_tel_read" class="form-control" placeholder="Correo Electronico" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Techo</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_techo_read" id="agn_techo_read" class="form-control" placeholder="####" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Costo de Vida</label>
                    <div class="col-md-10">
                        <input type="text" name="agn_costo_read" id="agn_costo_read" class="form-control" placeholder="##" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo</label>
                    <div class="col-md-10">
                    <select name="agn_tipo_read" id="agn_tipo_read" class="form-control" placeholder="Price" readonly>
                            <option id=1>Agencia</option>
                            <option id=2>Punto</option>
                            <option id=3>Mini-Agencia</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Numero de plazas</label>
                     <div class="col-md-10">
                    <input type="number" name="agn_totalPlaza_read" id="agn_totalPlaza_read" class="form-control" placeholder="Numero de agencias" readonly>
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pais</label>
                        <div class="col-md-10">
                            <select class="form-control" name="agn_pais_read" id="agn_pais_read" class="form-control" disabled>
                                <?php
                                    $i=0;
                                    foreach($paises as $a){
                                ?>
                                    <option id="<?= ($paises[$i]->id_pais);?>" value="<?= ($paises[$i]->id_pais);?>"><?php echo($paises[$i]->nombre_pais);?></option>
                                <?php
                                    $i++;
                                    }
                                ?>
                            </select>
                        </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">De la Empresa</label>
                    <div class="col-md-10" id="check_read" name="check_read">
                         
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL READ-->
<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script><!-- Llamo de libreria JQuery para Mask de numero -->
<script type="text/javascript">
    $(document).ready(function(){
        show_agencia(); //call function show all product

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
            }
        } );

        //function show all product
        function show_agencia(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('agencias/agencia_data')?>',
                async : false,
                dataType : 'json',
                success : function(data){

                    var html = '';
                    var i;
                    var ran;
                    console.log(data);
                    <?php $ran = 0; ?>
                    for(i=0; i<data.length; i++){
                        <?php $ran = rand(0,4); ?>
                        ran = Math.floor(Math.random() * 4);                        
                        html += '<tr>'+
                                '<td>'+data[i].id_agencia+'</td>'+
                                '<td>'+data[i].agencia+'</td>'+
                                '<td>'+data[i].direccion+'</td>'+
                                '<td>'+data[i].tel+'</td>'+
                                '<td>'+data[i].tipo+'</td>'+
                                '<td>'+data[i].total_plaza+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<?php if ($editar==1) {?><a href="#" id="editar" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-id_agencia="'+data[i].id_agencia+'" data-titulo="'+data[i].agencia+'" data-direccion="'+data[i].direccion+'" data-tel="'+data[i].tel+'"data-tipo="'+data[i].tipo+'" data-total_plaza="'+data[i].total_plaza+'" data-techo="'+data[i].techo+'" data-costo_vida="'+data[i].costo_vida+'" data-pais="'+data[i].pais+'">Editar</a><?php } ?>'+' '+

                                    '<?php if ($eliminar==1) {?><a href="#" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-id_agencia="'+data[i].id_agencia+'">Delete</a><?php } ?>'+' '+

                                    '<?php if ($ver==1) {?><a href="#" data-toggle="modal" data-target="#Modal_Read" class="btn btn-success btn-sm item_read" data-id_agencia="'+data[i].id_agencia+'" data-titulo="'+data[i].agencia+'" data-direccion="'+data[i].direccion+'" data-tel="'+data[i].tel+'"data-tipo="'+data[i].tipo+'"data-total_plaza="'+data[i].total_plaza+'" data-techo="'+data[i].techo+'" data-costo_vida="'+data[i].costo_vida+'" data-pais="'+data[i].pais+'">Ver</a><?php } ?>'+' '+
                                '</td>'+
                                '</tr>';
                    }
                    
                    $('#show_data').html(html);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
 //Save agencia
 $('#save_agn_controller').on('click',function(){
            //this.disabled=true;
            //var product_code = $('#product_code').val();
            var agn_titulo = $('#agn_titulo').val();
            var agn_dir = $('#agn_dir').val();
            var agn_tel = $('#agn_tel').val();
            var agn_tipo  = $('#agn_tipo').val();
            var agn_techo  = $('#agn_techo').val();
            var agn_costo  = $('#agn_costo').val();
            var agn_empresa  = $('#agn_empresa').val();
            var agn_totalPlaza  = $('#agn_totalPlaza').val();
            var agn_pais  = $('#agn_pais').children(":selected").attr("id");
            var empresas=[]; 

            //Trae la informacion de los check que estan seleccionados
            $('#check:checked').each(
                function(){
                    //ingresamos los id de las empresas a un arreglo
                    empresas.push($(this).val());
                }
            );

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/save')?>",
                dataType : "JSON",
                data : {agn_titulo:agn_titulo,agn_dir:agn_dir,agn_tel:agn_tel,agn_tipo:agn_tipo,agn_totalPlaza:agn_totalPlaza,agn_empresa:agn_empresa,agn_techo:agn_techo,agn_costo:agn_costo,empresas:empresas,agn_pais:agn_pais},
                success: function(data){
                    if (data==null){
                        document.getElementById('validacion').innerHTML = '';
                    this.disabled=false;
                    location.reload();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                            for (i = 0; i <= data.length-1; i++) {
                                document.getElementById('validacion').innerHTML += data[i]; 
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


        //Captura informacion para ver
        $('#show_data').on('click','.item_read',function(){
            var agn_code   = $(this).data('id_agencia');
            var agn_titulo   = $(this).data('titulo');
            var agn_dir   = $(this).data('direccion');
            var agn_tel   = $(this).data('tel');
            var agn_tipo  = $(this).data('tipo');
            var agn_totalPlaza = $(this).data('total_plaza');
            var agn_techo  = $(this).data('techo');
            var agn_costo  = $(this).data('costo_vida');
            var techo = parseFloat(agn_techo).toFixed(2);
            var costo = parseFloat(agn_costo).toFixed(2);
            var agn_pais = $(this).data('pais');

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('agencias/llenadoEmpresa')?>",
                dataType : "JSON",
                data : {agn_code:agn_code},
                success: function(data){
                    console.log(data);
                    $("#check_read").empty();
                    $.each(data.AllEmpresas,function(key, registro) {
                         $("#check_read").append(
                            '<label class="checkbox-inline">'+
                            '<input disabled type="checkbox" class="check_imprimir '+registro.id_empresa+'" >'+registro.nombre_empresa);''+
                            '</label>'
                    });
                    
                    $.each(data.Empresa,function(key, registro){
                        $('.'+registro.id_empresa+'').prop('checked',true);  
                    });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            
            $('[name="product_code_read"]').val(agn_code);
            $('[name="agn_titulo_read"]').val(agn_titulo);
            $('[name="agn_dir_read"]').val(agn_dir);
            $('[name="agn_tel_read"]').val(agn_tel);
            $('[name="agn_tipo_read"]').val(agn_tipo);
            $('[name="agn_totalPlaza_read"]').val(agn_totalPlaza);
            $('#agn_pais_read').val(agn_pais);
            $('[name="agn_techo_read"]').val(techo);
            $('[name="agn_costo_read"]').val(costo);

            $('#Modal_Read').modal('show');
        });

        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var agn_code   = $(this).data('id_agencia');
            var agn_titulo_edit   = $(this).data('titulo');
            var agn_dir_edit   = $(this).data('direccion');
            var agn_tel_edit   = $(this).data('tel');
            var agn_tipo_edit  = $(this).data('tipo');
            var agn_totalPlaza_edit  = $(this).data('total_plaza');
            var agn_techo_edit  = $(this).data('techo');
            var agn_costo_edit  = $(this).data('costo_vida');
            var techo = parseFloat(agn_techo_edit).toFixed(2);
            var costo = parseFloat(agn_costo_edit).toFixed(2);
            var agn_pais_Edit = $(this).data('pais');
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('agencias/llenadoEmpresa')?>",
                dataType : "JSON",
                data : {agn_code:agn_code},
                success: function(data){
                    console.log(data);
                    $("#check_edit").empty();
                    $.each(data.AllEmpresas,function(key, registro) {
                         $("#check_edit").append(
                            '<label class="checkbox-inline">'+
                            '<input type="checkbox" id="check_editar"  class="check_imprimir '+registro.id_empresa+'" value="'+registro.id_empresa+'">'+registro.nombre_empresa+''+
                            '</label>'
                            );
                    });
                    
                    $.each(data.Empresa,function(key, registro){
                        $('.'+registro.id_empresa+'').prop('checked',true);  
                    });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

            $('[name="agn_code_edit"]').val(agn_code);
            $('[name="agn_titulo_edit"]').val(agn_titulo_edit);
            $('[name="agn_dir_edit"]').val(agn_dir_edit);
            $('[name="agn_tel_edit"]').val(agn_tel_edit);
            $('[name="agn_tipo_edit"]').val(agn_tipo_edit);
            $('[name="agn_totalPlaza_edit"]').val(agn_totalPlaza_edit);
            $('[name="agn_techo_edit"]').val(techo);
            $('[name="agn_costo_edit"]').val(costo);
            $('#agn_pais_edit').val(agn_pais_Edit);

            $('#Modal_Edit').modal('show');

        });

        //update record to database
         $('#btn_update').on('click',function(){
            var agn_code_edit = $('#agn_code_edit').val();
            var agn_titulo_edit = $('#agn_titulo_edit').val();
            var agn_dir_edit = $('#agn_dir_edit').val();
            var agn_tel_edit = $('#agn_tel_edit').val();
            var agn_tipo_edit  = $('#agn_tipo_edit').val();
            var agn_totalPlaza_edit  = $('#agn_totalPlaza_edit').val();
            var agn_techo_edit  = $('#agn_techo_edit').val();
            var agn_costo_edit  = $('#agn_costo_edit').val();
            var agn_pais_edit  = $('#agn_pais_edit').val();
            var empresas=[];

            //Trae la informacion de los check que estan seleccionados
            $('#check_editar:checked').each(
                function(){
                    //ingresamos los id de las empresas a un arreglo
                    empresas.push($(this).val());
                    //alert($(this).val());
                }
            );

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('agencias/update')?>",
                dataType : "JSON",
                data : {agn_code_edit:agn_code_edit,agn_titulo_edit:agn_titulo_edit,agn_dir_edit:agn_dir_edit,agn_tel_edit:agn_tel_edit, agn_tipo_edit:agn_tipo_edit,agn_totalPlaza_edit:agn_totalPlaza_edit,agn_techo_edit:agn_techo_edit,agn_costo_edit:agn_costo_edit,agn_pais_edit:agn_pais_edit,empresas:empresas},
                success: function(data){
                    if (data.length==0){  
                    document.getElementById('validacion_edit').innerHTML = '';
                    this.disabled=false;
                    location.reload();
                    }else{ 
                        document.getElementById('validacion_edit').innerHTML = '';
                            for (i = 0; i <= data.length-1; i++) {
                                document.getElementById('validacion_edit').innerHTML += data[i]; 
                            }
                    }
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

        //get data for delete record
        $('#show_data').on('click','.item_delete',function(){
            var product_code = $(this).data('id_agencia');
            $('#Modal_Delete').modal('show');
            $('[name="agn_code_delete"]').val(product_code);
        });

        //delete record to database
         $('#btn_delete').on('click',function(){
            var product_code = $('#agn_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('agencias/delete')?>",
                dataType : "JSON",
                data : {product_code:product_code},
                success: function(data){                   
                    location.reload();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

        $('input[name="agn_tel"]').mask('0000-0000');//validacion solo numero y mascara en campo agn_tel
        $('input[name="agn_tel_edit"]').mask('0000-0000');//validacion solo numero y mascara en campo agn_tel_edit
        $('input[name="agn_totalPlaza"]').mask('00');//numero de plazas
        $('input[name="agn_totalPlaza_edit"]').mask('00');

    });

</script>

</body>
</html>