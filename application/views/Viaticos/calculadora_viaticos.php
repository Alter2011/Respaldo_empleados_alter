    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="col-sm-10">
                <div class="col-sm-12">

                    <div class="text-center well text-white blue">
                        <h2>Calculadora Viaticos</h2>
                    </div>
                    <div class="col-sm-6">


                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Agencia:</label>
                        <div class="col-md-5">
                          <select class="form-control" name="agencia_v" id="agencia_v" onchange="seleccionar_ag()">
                            <?php
                                foreach($agencias as $agencia){
                                    if($agencia->id_agencia != '00'){
                            ?>
                                    <option value="<?= ($agencia->id_agencia);?>"><?php echo($agencia->agencia);?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Cartera:</label>
                        <div class="col-md-5">
                        <select class="form-control" name="cartera_v" id="cartera_v">
                            
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Dias laborados:</label>
                        <div class="col-md-5">
                            <input type="text" name="dias" id="dias" class="form-control">
                        <div id="validacion_calculadora" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Kilometros extra:</label>
                        <div class="col-md-5">
                            <input type="text" name="km_extra" id="km_extra" class="form-control">
                        <div id="validacion2_calculadora" style="color:red"></div>
                        </div>
                    </div>

            
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Consumo ruta $:</label>
                            <div class="col-md-5">
                                <input type="text" name="ruta" id="ruta" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Depreciacion $:</label>
                            <div class="col-md-5">
                                <input type="text" name="depreciacion" id="depreciacion" class="form-control" readonly>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6">


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Llanta delantera $:</label>
                            <div class="col-md-5">
                                <input type="text" name="llanta_del" id="llanta_del" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Llanta tracera $:</label>
                            <div class="col-md-5">
                                <input type="text" name="llanta_tra" id="llanta_tra" class="form-control" readonly>

                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-md-4 col-form-label">Mantenimiento general $:</label>
                            <div class="col-md-5">
                                <input type="text" name="manto_general" id="manto_general" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Aceite $:</label>
                            <div class="col-md-5">
                                <input type="text" name="aceite" id="aceite" class="form-control" readonly>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Viaticos totales $:</label>
                            <div class="col-md-5">
                                <input type="number" name="v_total" id="v_total" class="form-control" placeholder="00" readonly>
                            </div>
    
                        </div>

                    </div>


                          <div class="col-md-3">
                            <a class="btn btn-primary" id="calcular"><span class="glyphicon glyphicon-phone"></span> Calcular</a>
                            <a class="btn btn-danger" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</a>
                          </div>

                         </div>
                     </div>

            <script type="text/javascript">

                //PROXIMO SUBIR 28032022

    //metodo para la calculadora de viaticos
        $('#calcular').on('click',function(){

            //console.log("entre");
            var agencia = $('#agencia_v').val();
            var cartera = $('#cartera_v').val();
            var km_total = $('#km_total').val();
            var km_extra = $('#km_extra').val();
            var dias_lab = $('#dias').val();


            $.ajax({
                  type : "POST",
                url  : "<?php echo site_url('Viaticos/calculadora')?>",
                dataType : "JSON",
                data : {agencia:agencia,cartera:cartera,km_total:km_total,km_extra:km_extra, dias_lab:dias_lab},
                success: function(data){
                    document.getElementById('dias').innerHTML = '';
                    document.getElementById('km_extra').innerHTML = '';
                    document.getElementById('validacion_calculadora').innerHTML = '';
                    document.getElementById('validacion2_calculadora').innerHTML = '';


                      if(data.validacion == null){
                        console.log(data);


                        $('[name="ruta"]').val(data.info[0].consumo_ruta);
                        $('[name="depreciacion"]').val(data.info[0].depreciacion);
                        $('[name="llanta_del"]').val(data.info[0].llanta_del);
                        $('[name="llanta_tra"]').val(data.info[0].llanta_tra);
                        $('[name="manto_general"]').val(data.info[0].mont_gral);
                        $('[name="aceite"]').val(data.info[0].aceite);
                        $('[name="v_total"]').val(data.info[0].total);

                    }else{
                        console.log(data);
                        for(i = 0; i <= data.validacion.length-1; i++){

                            if(data.validacion[i] == 1){
                                document.getElementById('validacion_calculadora').innerHTML += "Debe ingresar cantidad de dias laborados.";
                            }else if(data.validacion[i] == 2){
                                document.getElementById('validacion_calculadora').innerHTML += "Los dias laborados deben ser un numero.";
                            }else if(data.validacion[i] == 3){
                                document.getElementById('validacion_calculadora').innerHTML += "Los dias laborados deben ser mayor a cero.";
                            }else if(data.validacion[i] == 4){
                                document.getElementById('validacion_calculadora').innerHTML += "Los dias trabajados debe ser menor o igual a 15.";
                            }

                            if(data.validacion[i] == 5){
                                document.getElementById('validacion2_calculadora').innerHTML += "Los kilometros extra deben ser un numero.";
                            }else if(data.validacion[i] == 6){
                                document.getElementById('validacion2_calculadora').innerHTML += "Los kilometros extra deben ser mayor a cero.";
                            }
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
        });//fin metodo calcular

           $('#limpiar').on('click',function(){
            document.getElementById('validacion_calculadora').innerHTML = '';
            document.getElementById('validacion2_calculadora').innerHTML = '';

            $('[name="dias"]').val('');
            $('[name="km_extra"]').val('');

            $('[name="ruta"]').val('');
            $('[name="depreciacion"]').val('');
            $('[name="llanta_del"]').val('');
            $('[name="llanta_tra"]').val('');
            $('[name="manto_general"]').val('');
            $('[name="aceite"]').val('');
            $('[name="v_total"]').val('');

        });

            //PROXIMO SUBIR
            seleccionar_ag();

             function seleccionar_ag(){
                agencia = $('#agencia_v').val();
                $('#cartera_v').empty();

                $.ajax({
                  type : "POST",
                  url  : "<?php echo site_url('Viaticos/carteras_agencia')?>",
                  dataType : "JSON",
                  data : {agencia:agencia},
                  success: function(data){
                      $.each(data,function(key, registro){
                        $("#cartera_v").append(
                          '<option value="'+registro.id_cartera+'">'+registro.cartera+'</option>'
                        );
                      });                          
                  },

                  error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                  }
                });
            }

         //FIN SUBIR

            </script>