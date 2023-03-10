<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Horas Extras</h2>
    </div>
        <div class="row">
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
                <nav class="float-right">
                    <div class="col-sm-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState" id="mes">Mes</label>
                                    <input type="month" name="filtro_mes" id="filtro_mes" class="form-control" value="<?php echo date("Y-m");?>">
                                </div>
                            </div>
                        </nav>
                <nav class="float-right">
                    <div class="col-sm-4">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="inputState" id="quincena">Quincena</label>
                                <select class="form-control" name="filtro_quincena" id="filtro_quincena" class="form-control">
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                    </select>
                                </div>
                            </div>
                        </nav>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                         
                    </div>
                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</div>


<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
   $(document).ready(function(){
        
        //show_data();
        traer_horas();
        $('.item_filtrar').click(function(){
            show_data();
        });

        function traer_horas(){
            var id_contrato = $('#id_empleado').val();
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Horas_extras/calculo_horas')?>',
            dataType : 'JSON',
            data : {id_contrato:id_contrato},
            success : function(data){
                show_data(data);
                },  
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

        

        function show_data(data=null){

            var id_contrato = $('#id_empleado').val();
            var filtro_mes = $('#filtro_mes').val();
            var filtro_quincena = $('#filtro_quincena').val();
            var mes_actual = $('#filtro_mes').val();
            var dias='';
            var horas='';
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Horas_extras/calculo_horas')?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato,filtro_mes:filtro_mes,filtro_quincena:filtro_quincena},
                success : function(data){
                console.log(data);

                if(data == null){
                    $('#filtro_mes').hide();
                    $('#filtro_quincena').hide();
                    $('#filtrar').hide();
                    $('#mes').hide();
                    $('#quincena').hide();
                    $('#mostrar').append(

                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Horas Extras</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas extras</div>'+
                            '</div>'
                        );
                   }  else if (data.total_dias_diurnas==0 && data.total_dias_nocturnas==0) {
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Horas Extras</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no posee horas extras en este mes</div>'+
                            '</div>'
                        );
                }else {
                        if(data.total_dias_diurnas==1){
                            dias='dia';
                        }else if(data.total_dias_diurnas !=1){
                            dias='dias';
                        }
                        if(data.total_horas_diurnas==1){
                            horas='hora';
                        }else if(data.total_horas_diurnas !=1){
                            horas='horas';
                        }
                        if(data.total_dias_nocturnas==1){
                            diasn='dia';
                        }else if(data.total_dias_nocturnas !=1){
                            diasn='dias';
                        }
                        if(data.total_horas_nocturnas==1){
                            horasn='hora';
                        }else if(data.total_horas_nocturnas !=1){
                            horasn='horas';
                        }
                    $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info">'+
                            '<h3 class="modal-title">Horas Extras </h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+data.nombre+' '+data.apellido +'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+data.dui+'</div>'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+data.agencia+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+data.cargo +' </div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong> '+data.nombrePlaza+'</div>'+
                            '<div class="col-md-4"><strong>Salario:</strong> $'+data.salario+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Total dias Diurnas:</strong> '+data.total_dias_diurnas+' '+dias+'</div> '+
                            '<div class="col-md-4"><strong>Total horas Diurnas:</strong> '+data.total_horas_diurnas+' '+horas+'</div>'+
                            '<div class="col-md-4"><strong>Total de horas extras Diurnas:</strong> $'+data.horas_extras_diurnas.toFixed(2)+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Total dias Nocturnas:</strong> '+data.total_dias_nocturnas+' '+diasn+'</div>'+
                            '<div class="col-md-4"><strong>Total horas Nocturnas:</strong> '+data.total_horas_nocturnas+' '+horasn+'</div>'+
                            '<div class="col-md-4"><strong>Total de horas extras Nocturnas:</strong> $'+data.horas_extras_nocturnas.toFixed(2)+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong></strong></div>'+
                            '<div class="col-md-4"><strong>Total de horas extras:</strong> $'+data.total_horas_extras.toFixed(2)+'</div>'+
                            '<div class="col-md-4"><strong></strong></div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>' 
                           
                        );
                  }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data


         });//Fin jQuery

    
</script>
</body>


</html>