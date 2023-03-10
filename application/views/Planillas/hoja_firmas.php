<style type="text/css" media="print">
.ocultar{
    display: none;
}
</style>
<?php setlocale(LC_TIME, 'es_ES.UTF-8'); 
 function meses($meses){
    switch($meses){
        case 1: $meses="Enero"; break;
        case 2: $meses="Febrero"; break;
        case 3: $meses="Marzo"; break;
        case 4: $meses="Abril"; break;
        case 5: $meses="Mayo"; break;
        case 6: $meses="Junio"; break;
        case 7: $meses="Julio"; break;
        case 8: $meses="Agosto"; break;
        case 9: $meses="Septiembre"; break;
        case 10: $meses="Octubre"; break;
        case 11: $meses="Noviembre"; break;
        case 12: $meses="Diciembre"; break;
    }

    return $meses;
}
?>
<style type="text/css">
    @media print {
        .logo_gob{
            width: 80px;
            height: 80px;
        }
    }
</style>
<div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Imprimir Hojas de firmas</h2>
    </div>
        <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(3); ?>" readonly>
        <input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $this->uri->segment(4); ?>" readonly>


    <div class="col-sm-10" id="buscador">
        <div class="col-sm-12">
           <div class="col-sm-4 ocultar">
               <label for="inputState" id="labelM">Mes de Boleta</label>
               <input type="month" class="form-control" id="mes" name="mes" value="<?php echo date("Y-m");?>">
           </div>
           
           <div class="form-group col-sm-3 ocultar">
              <label for="inputState" id="labelQ">Quincena</label>
              <select class="form-control" name="quincena" id="quincena" class="form-control">
                  <option value="1">Primera Quincena</option>
                  <option value="2">Segunda Quincena</option>
              </select>
           </div>

           <input type="hidden" name="aprobar" id="aprobar" value="<?php echo $aprobar; ?>" readonly>

            <div class="form-group col-sm-3">
                <button class="btn btn-success crear ocultar" id="btn_imprimir" style="position: relative; top: 25px">Imprimir</button>
           </div>
                         
        </div>
    </div>
    <div class="col-sm-12">
        <div class="" id="mostrar">
        </div><!--mostrar-->


    </div>

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        imprimir_datos();

        $('.crear').click(function(){  
            window.print();
        });
         $('#mes').change(function(){
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            imprimir_datos(mes, quincena);
        });

        $('#quincena').change(function(){
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            imprimir_datos(mes, quincena);
        });

        function imprimir_datos(mes=null,quincena=null){ 
            var id_agencia = $('#id_agencia').val();
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            var aprobar = $('#aprobar').val();
            var id_empresa = $('#id_empresa').val();
           
            var i=0;
            $("#mostrar").empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Boleta_pago/llamar_hoja')?>',
                dataType : 'JSON',
                data : {id_agencia:id_agencia,mes:mes,quincena:quincena,aprobar:aprobar,id_empresa:id_empresa},
                success : function(data){
                console.log(data);
                //$.each(data,function(key, registro){ });
                if (data==null) {
                     $('#btn_imprimir').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Hoja de Firmas</h4></div>'+
                            '<div class="panel-body">No se ha encontrado ningun resultado</div>'+
                            '</div>'
                        );
                }else if(data.aprobado == 1){
                    $('#btn_imprimir').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-success">'+
                            '<div class="panel-heading"><h4>Hoja de Firmas</h4></div>'+
                            '<div class="panel-body">Hoja de firmas en espera de aprobacion</div>'+
                            '</div>'
                        );
                }else{

                $('#btn_imprimir').show();
                    i=0;
                    a=0
                $.each(data.boleta,function(key, registro){
                    if (i==0) {
                        //GENERACION DE LAS BOLETAS NORMALES
                    if (data.boleta[a].id_empresa==1){
                        $('#mostrar').append(
                            '<!--INICIO DEL LA HOJA-->'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso">'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<div>LOS ABAJO FIRMANTES DECLARAMOS HABER RECIBIDO A NUESTRA ENTERA</div>'+
                                '<div>SATISFACCION EL PAGO DE SALARIOS DEL PERIODO CORRESPONDIENTE</div>'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                        );  
                        }else if (data.boleta[a].id_empresa==2){
                        $('#mostrar').append(
                            '<!--INICIO DEL LA HOJA-->'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<img src="<?= base_url();?>/assets/images/AlterOcci.png" style="width:200px" id="logo_permiso">'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<div>LOS ABAJO FIRMANTES DECLARAMOS HABER RECIBIDO A NUESTRA ENTERA</div>'+
                                '<div>SATISFACCION EL PAGO DE SALARIOS DEL PERIODO CORRESPONDIENTE</div>'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                            );
                            }else if (data.boleta[a].id_empresa==3){
                             $('#mostrar').append(
                            '<!--INICIO DEL LA HOJA-->'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<img src="<?= base_url();?>/assets/images/secofi_logo.png" id="logo_permiso" style="width:125px">'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center;" >'+
                                '<div>LOS ABAJO FIRMANTES DECLARAMOS HABER RECIBIDO A NUESTRA ENTERA</div>'+
                                '<div>SATISFACCION EL PAGO DE SALARIOS DEL PERIODO CORRESPONDIENTE</div>'+
                            '</div>'+
                            '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                        );  
                        }

                    }//cuando i es 0 debe volver a generarse el encabezado

                    var total_pagar=parseFloat(data.boleta[a].total_pagar).toFixed(2);                 
                        $('#mostrar').append(
                        '<div class="col-sm-12" style="text-align: center; "><!--Contenedor de todo-->'+
                            '<div class="col-sm-1"></div>'+
                            '<div class="col-sm-9">'+
                                '<div class="row" style="margin: 5px;text-align: center">'+
                                    '<div class="col-sm-5"><b>'+data.boleta[a].nombre+' '+data.boleta[a].apellido+'</b></div>'+
                                    '<div class="col-sm-3"></div>'+
                                    '<div class="col-sm-4"><b>F____________________</b></div>'+
                                    '<br><hr style="border: solid 0.5px;">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2"></div>'+
                        '</div><br><br>'
                        );
                    i++;
                    a++;
               
                if (i == 12) {
                    $('#mostrar').append(
                    '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;"><!--Contenedor de todo-->'+
                      '<br><hr style="border: solid 0.5px;">'+
                      '<div><b>'+data.boleta[0].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b></div>'+
                    '</div>'+
                    '<div style="margin-top:15px;page-break-before: always"><br>'
                    );

                i=0;
                } 
                });//fin del each

                 if(i<12){
                        for (var j = i; j <= 11; j++) {
                        $('#mostrar').append(
                        '<div class="col-sm-12" style="text-align: center; "><!--Contenedor de todo-->'+
                            '<div class="col-sm-1"></div>'+
                            '<div class="col-sm-9">'+
                                '<div class="row" style="margin: 5px;text-align: center">'+
                                    '<div class="col-sm-5"><b></b></div>'+
                                    '<div class="col-sm-3"><b></b></div>'+
                                    '<div class="col-sm-4"><b></b></div>'+
                                    '<br><hr style="border: solid 0.0px;'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2"></div>'+
                        '</div>'
                        ); 
                    }
                    
                $('#mostrar').append(
                    '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;margin-bottom:40px;"><!--Contenedor de todo-->'+
                      '<br><hr style="border: solid 0.5px;">'+
                      '<div><b>'+data.boleta[0].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b></div>'+
                    '</div>'//en una hoja solo caben 12 por agencia
                    ); 
                }

                //IMPRESION DE LA HOJA DE FIRMAS CON EL GOB
                    x=0;
                    y=0
                if (data.boleta[0].isss==0) {
                $.each(data.boleta,function(key, registro){
                    if (x==0) {
                    //GENERACION DE LAS BOLETAS DEL GOB
                        decre='<div style="margin: 10px;text-align: center;" ><b style="font-size:15px">En cumplimiento al DL. N° 641 y el DL. N° 685</b></div>';
                            dui_nit="<span>DUI: <br> NIT:</span>";
                        if (data.boleta[y].id_empresa==1){
                        $('#mostrar').append(
                            '<!--INICIO DEL LA HOJA-->'+
                            '<div class="row" style="margin: 5px;text-align: center;" >'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/watermark.png" style="margin-top:30px;width:200px" id="logo_permiso"></div>'+
                                '<div class="col-sm-4"></div></div>'+
                            '</div>'+
                            '<div style="margin: 5px;text-align: center;" >'+
                                '<div>Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> En cumplimiento al DL. N° 641 y el DL. N° 685</div>'+
                                    
                            '</div>'+
                            '<div style="margin: 5px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                        );  
                        }else if (data.boleta[y].id_empresa==2){
                        $('#mostrar').append(
                            '<!--INICIO DEL LA HOJA-->'+
                            '<div class="row" style="margin: 5px;text-align: center;" >'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/AlterOcci.png" style="margin-top:15px;width:200px" id="logo_permiso"></div>'+
                                '<div class="col-sm-4"></div></div>'+
                            '</div>'+
                            '<div style="margin: 5px;text-align: center;" >'+
                                '<div>Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> En cumplimiento al DL. N° 641 y el DL. N° 685</div>'+
                                    
                            '</div>'+
                            '<div style="margin: 5px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                            );
                            }else if (data.boleta[y].id_empresa==3){
                             $('#mostrar').append(
                             '<!--INICIO DEL LA HOJA-->'+
                             '<div class="row" style="margin: 5px;text-align: center;" >'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                                '<div class="col-sm-4"><img src="<?= base_url();?>/assets/images/secofi_logo.png" id="logo_permiso" style="width:125px"></div>'+
                                '<div class="col-sm-4"></div></div>'+
                            '</div>'+
                            '<div style="margin: 5px;text-align: center;" >'+
                                '<div>Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> En cumplimiento al DL. N° 641 y el DL. N° 685</div>'+
                                    
                            '</div>'+
                            '<div style="margin: 5px;text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].agencia+', <?=  date("j")." de ".meses(date('m'))." de ".date("Y");?></b>'+
                                '<div style="text-align: center; text-transform: uppercase;" >'+
                                '<b>'+data.boleta[0].fecha+'</b>'+
                                '</div>'+
                            '</div>'+
                            '<!--FIN DEL LA HOJA-->'
                            );  
                          }

                    }//cuando i es 0 debe volver a generarse el encabezado

                    var total_pagar=parseFloat(data.boleta[y].total_pagar).toFixed(2);                 
                        $('#mostrar').append(
                        '<div class="col-sm-12"><!--Contenedor de todo-->'+
                            '<div class="col-sm-1"></div>'+
                            '<div class="col-sm-9">'+
                                '<div class="row" style="margin: 5px;">'+
                                    '<div class="col-sm-5"><b>'+data.boleta[y].nombre+' '+data.boleta[y].apellido+'</b></div>'+
                                    '<div class="col-sm-4" style="text-align: left;">'+dui_nit+'</div>'+
                                    '<div class="col-sm-2"><b>F_______________</b></div>'+
                                    '<br><hr style="border: solid 0.2px;">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2"></div>'+
                        '</div><br><br>'
                        );
                    x++;
                    y++;
               
                if (x == 12) {
                    $('#mostrar').append(
                    '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;"><!--Contenedor de todo-->'+
                      '<br><hr style="border: solid 0.5px;">'+
                      '<div><b>'+data.boleta[0].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b></div>'+
                    '</div>'+
                    '<div style="margin-top:15px;page-break-before: always"><br>'
                    );

                x=0;
                } 
                });//fin del each

                 if(x<12){
                        for (var z = x; z <= 11; z++) {
                        $('#mostrar').append(
                        '<div class="col-sm-12" style="text-align: center; "><!--Contenedor de todo-->'+
                            '<div class="col-sm-1"></div>'+
                            '<div class="col-sm-9">'+
                                '<div class="row" style="margin: 5px;text-align: center">'+
                                    '<div class="col-sm-5"><b></b></div>'+
                                    '<div class="col-sm-3"><b></b></div>'+
                                    '<div class="col-sm-4"><b></b></div>'+
                                    '<br><hr style="border: solid 0.0px;'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2"></div>'+
                        '</div>'
                        ); 
                    }
                    
                $('#mostrar').append(
                    '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;"><!--Contenedor de todo-->'+
                      '<br><hr style="border: solid 0.5px;">'+
                      '<div><b>'+data.boleta[0].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b></div>'+
                    '</div>'//en una hoja solo caben 12 por agencia
                    ); 
                }
                }

         
            }//FIN DEL ELSE QUE PERMITE VER LA IMPRESION

                   
            },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

    });//Fin jQuery <tr><td>&nbsp;</td></tr>

</script>
</body>
<style>

</style>
</html>