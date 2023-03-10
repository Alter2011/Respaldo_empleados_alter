        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Contratos proximos a vencer</h2>
            </div>
            <div class="row">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">
                        <?php if($ver){?>
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia" id="agencia" class="form-control">
                                        <option value="">Todos</option>
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
                            <?php }?>
                                <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	
	 $(document).ready(function(){

	 	show_data();
        $('#agencia').change(function(){
            show_data();
        });
        function show_data(){
            var agencia = $('#agencia').children(":selected").attr("id");
            
            $('#row').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contratacion/mostrar_contratos_vencer')?>',
                dataType : 'JSON',
                data : {agencia:agencia},
                success : function(data){
                    console.log(data);
                $.each(data.proximos_vencer,function(key, registro){
	                $('#row').append(
							'<div class="col-sm-6">'+
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><strong>Empleado: </strong>'+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Agencia: </strong>'+registro.agencia+'</div>'+
                            '<div class="col-md-6"><strong>Cargo: </strong>'+registro.cargo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Plaza: </strong>'+registro.nombrePlaza+'</div>'+
                            '<div class="col-md-6"><strong>Fecha vencimiento : </strong>'+registro.fecha_fin+'</div>'+
                             '</div>'+
                            '</div>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success crear">Ir a historial de empleado</a>'+
                            '</center>'+
                            '</div>'+
                            '</div>'+
                            '</div>' 
	                	);
                });//fin del each

                if(data.proximos_vencer == 0){
                    $('#row').append(
                    	'<div class="col-sm-1"></div>'+
                        '<center><div class="col-sm-10">'+
                        '<div class="panel panel-danger">'+
                        '<div class="panel-heading">Contratos a Vencer</div>'+
                        '<div class="panel-body">No se encontraron Contratos proximos a vencer en esta Agencia</div>'+
                        '</div>'+
                        '</div>'+
                        '</div></center>'
                    );
                }

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data

	 });

</script>