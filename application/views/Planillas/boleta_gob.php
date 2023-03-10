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
        td{
        border:1px solid;  
        }
        .logo_gob{
            width: 85px;
            height: 100px;
        }
    }
</style>
<div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Imprimir Boletas de Pago</h2>
    </div>
    <?php if (isset($boletas)) {
       if ($boletas=='personal') { ?>
        <input type="hidden" name="id_contrato" id="id_contrato" value="<?php echo $this->uri->segment(3); ?>" readonly>
        <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(4); ?>" readonly>
       <?php

        }else if ($boletas=='todos') { ?>
        <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(3); ?>" readonly>
        <input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $this->uri->segment(4); ?>" readonly>
        <input type="hidden" name="id_contrato" id="id_contrato" value="null" readonly>
        <?php
        }
    } 
    ?>
    <div class="col-sm-10" id="buscador">
        <div class="col-sm-12">
           <div class="col-sm-4">
               <label for="inputState" id="labelM">Mes de Boleta</label>
               <input type="month" class="form-control" id="mes" name="mes" value="<?php echo date("Y-m");?>">
           </div>
           
           <div class="form-group col-sm-3">
              <label for="inputState" id="labelQ">Quincena</label>
              <select class="form-control" name="quincena" id="quincena" class="form-control">
                  <option value="1">Primera Quincena</option>
                  <option value="2">Segunda Quincena</option>
              </select>
           </div>

            <input type="hidden" name="aprobar" id="aprobar" value="<?php echo $aprobar; ?>" readonly>

            <div class="form-group col-sm-3">
                <button class="btn btn-success crear" id="btn_imprimir" style="position: relative; top: 25px">Imprimir</button>
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


        $('.crear').click(function(){  
            $('#btn_imprimir').hide();
            $("#buscador").hide();
            window.print();
            $("#buscador").show();
            $('#btn_imprimir').show();
        });

        function imprimir_datos(mes=null,quincena=null){
            var id_contrato = $('#id_contrato').val();
            var id_agencia = $('#id_agencia').val();
            var id_empresa = $('#id_empresa').val();
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            var aprobar = $('#aprobar').val();
            var j=0;
            var i=0;

            var bancos = [];
            var cuota = [];
            var mostrar_banco=[];

            var descuento_herramienta=[];
            var cuota_herramienta=[];
            var nombre_herramienta=[];

            var anticipo=[];
            var monto_otorgado=[];
            var nombre_anticipo=[];

            var mostrar_prestamo=[];
            var cuota_prestamo=[];
            var nombre_prestamo=[];

            var espacio=[];
            var aux=[];
            var aux2=[];
            var aux3=[];


            var prueba='';
            var desc_herra='';
            //alert(id_contrato+" "+id_agencia);
            $("#mostrar").empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php if ($boletas=="personal"){echo site_url("Boleta_pago/imprimir_boleta");}else if($boletas=="todos"){echo site_url("Boleta_pago/traer_boletas_gob");}?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato,id_agencia:id_agencia,mes:mes,quincena:quincena,aprobar:aprobar,id_empresa:id_empresa},
                success : function(data){
                console.log(data);
                //$('#nombre').text(data.nombre);
                    if(data == "datos"){
                    $('#filtro_mes').show();
                    $('#filtro_quincena').show();
                    $('#filtrar').show();
                    $('#mes').show();
                    $('#quincena').show();
                    $('#labelM').show();
                    $('#labelQ').show();
                    $('#btn_imprimir').hide();
                    $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Boleta de Pago</h4></div>'+
                            '<div class="panel-body">El empleado no posee Boleta de Pago en este mes</div>'+
                            '</div>'//descuentyo de herramientas desc emp
                        );

                   }else if(data == "bloqueo"){
                    $('#filtro_mes').show();
                    $('#filtro_quincena').show();
                    $('#filtrar').show();
                    $('#mes').show();
                    $('#quincena').show();
                    $('#labelM').show();
                    $('#labelQ').show();
                    $('#btn_imprimir').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-danger">'+
                            '<div class="panel-heading"><h4>Boleta de Pago</h4></div>'+
                            '<div class="panel-body">La planilla esta bloqueda</div>'+
                            '</div>'
                        );
                } else if(data.boleta[0].aprobado == 0){
                    $('#filtro_mes').show();
                    $('#filtro_quincena').show();
                    $('#filtrar').show();
                    $('#mes').show();
                    $('#quincena').show();
                    $('#labelM').show();
                    $('#labelQ').show();
                    $('#btn_imprimir').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-success">'+
                            '<div class="panel-heading"><h4>Boleta de Pago</h4></div>'+
                            '<div class="panel-body">Boleta de Pago en espera de aprobacion</div>'+
                            '</div>'
                        );
                }else{
                    $('#btn_imprimir').show();
                    j=0;
                    i=0;
                    $.each(data.boleta,function(key, registro){

                    if (data.boleta[j].isss!=0 || data.boleta[j].afp_ipsfa!=0) {
                    
                        //Inicio de bancos
                    if (data.boleta[j].bancos.length!=0) {
                        for (var i = 0; i < data.boleta[j].bancos.cuota.length; i++) {
                            cuota[i]=data.boleta[j].bancos.cuota[i];
                        }
                        for (var i = 0; i < data.boleta[j].bancos.nombre_banco.length; i++) {
                            bancos[i]=data.boleta[j].bancos.nombre_banco[i];
                        }
                        for (var i = 0; i < data.boleta[j].bancos.cuota.length; i++) {
                            mostrar_banco[i]='<div class="col-sm-8"><b>'+bancos[i]+'</b> </div>'+
                            '<div class="col-sm-4"><b>$ '+parseFloat(cuota[i]).toFixed(2)+'</b></div>';
                            espacio[i]="<br>";
                        }  
                    }else{
                        mostrar_banco[i]='';
                        espacio=[];
                    }
                    //fin de bancos

                    //inicio de prestamos internos
                    total_interno=0;
                    if (data.boleta[j].prestamos_internos.length!=0) {                
                        for (var i = 0; i < data.boleta[j].prestamos_internos.cuota.length; i++) {
                            cuota_prestamo[i]=data.boleta[j].prestamos_internos.cuota[i];
                        }
                        for (var i = 0; i < data.boleta[j].prestamos_internos.nombre_prestamo.length; i++) {
                           nombre_prestamo[i]=data.boleta[j].prestamos_internos.nombre_prestamo[i];
                        }
                        for (var i = 0; i < data.boleta[j].prestamos_internos.cuota.length; i++) {
                            mostrar_prestamo[i]='<div class="col-sm-8"><b>'+nombre_prestamo[i]+'</b> </div>'+
                            '<div class="col-sm-4"><b>$ '+parseFloat(cuota_prestamo[i]).toFixed(2)+'</b></div>';
                            aux[i]='<br>';
                            prueba='<div class="col-sm-12" style="margin:7px"></div>';
                        }
                    }else{
                        mostrar_prestamo[i]='';
                            aux[i]='';
                            prueba='';
                    }
                    //Fin de prestamos internos

                    //inicio de Desceunto de herramientas
                    if (data.boleta[j].descuento_herramienta.length!=0) {                
                        for (var i = 0; i < data.boleta[j].descuento_herramienta.cuota.length; i++) {
                            cuota_herramienta[i]=data.boleta[j].descuento_herramienta.cuota[i];
                        }
                        for (var i = 0; i < data.boleta[j].descuento_herramienta.nombre_descuento.length; i++) {
                           nombre_herramienta[i]=data.boleta[j].descuento_herramienta.nombre_descuento[i];
                        }
                        for (var i = 0; i < data.boleta[j].descuento_herramienta.cuota.length; i++) {
                            descuento_herramienta[i]='<div class="col-sm-8"><b>'+nombre_herramienta[i]+'</b> </div>'+
                            '<div class="col-sm-4"><b>$ '+parseFloat(cuota_herramienta[i]).toFixed(2)+'</b></div>';
                            aux2[i]='<br>';
                            desc_herra='<div class="col-sm-12" style="margin:7px"></div>';
                        }
                    }else{
                        descuento_herramienta[i]='';
                        aux2[i]=''; 
                        desc_herra='';  
                    }
                    //Fin de Desceunto de herramientas

                    //inicio de Anticipos
                    if (data.boleta[j].anticipo.length!=0) {                
                        for (var i = 0; i < data.boleta[j].anticipo.monto_otorgado.length; i++) {
                            monto_otorgado[i]=data.boleta[j].anticipo.monto_otorgado[i];
                        }
                        for (var i = 0; i < data.boleta[j].anticipo.nombre_anticipo.length; i++) {
                           nombre_anticipo[i]=data.boleta[j].anticipo.nombre_anticipo[i];
                        }
                        for (var i = 0; i < data.boleta[j].anticipo.monto_otorgado.length; i++) {
                            anticipo[i]='<div class="col-sm-8"><b>'+nombre_anticipo[i]+'</b> </div>'+
                            '<div class="col-sm-4"><b>$ '+parseFloat(monto_otorgado[i]).toFixed(2)+'</b></div>';
                            aux3[i]='<br>';
                            desc_anti='<div class="col-sm-12" style="margin:7px"></div>';
                        }
                    }else{
                        anticipo[i]='';
                        aux3[i]=''; 
                        desc_anti='';
                    }
                    //Fin de Anticipos

                }else{//if para no mostrar los detalles 
                    mostrar_banco[i]='';
                    espacio=[];
                    mostrar_prestamo[i]='';
                    aux[i]='';
                    prueba='';
                    descuento_herramienta[i]='';
                    aux2[i]=''; 
                    desc_herra=''; 
                    anticipo[i]='';
                    aux3[i]=''; 
                    desc_anti='';
                }   
                    comision=parseFloat(data.boleta[j].comision).toFixed(2);
                    bono=parseFloat(data.boleta[j].bono).toFixed(2);
                    
                    porcentaje_isss=0.03;
                    porcentaje_afp=0.0725;
                    //bono=30;
                    bono_isss=0;
                    bono_afp=0;
                    bono_isss_afp=0;
                    if (data.boleta[j].total_bono!=0) {
                        bono_isss=parseFloat(data.boleta[j].total_bono*porcentaje_isss).toFixed(2);
                        bono_afp=parseFloat(data.boleta[j].total_bono*porcentaje_afp).toFixed(2);
                        bono_isss_afp=parseFloat(Number(bono_isss)+Number(bono_afp)).toFixed(2);    
                    }else{
                        bono_isss="0.00";
                        bono_afp="0.00";
                        bono_isss_afp="0.00"; 
                    }
                    

                    horas_extras=parseFloat(data.boleta[j].horas_extras).toFixed(2);
                    viaticos=parseFloat(data.boleta[j].viaticos).toFixed(2);
                    vacacion=parseFloat(data.boleta[j].vacacion).toFixed(2);

                    descuentos_faltantes=parseFloat(data.boleta[j].descuentos_faltantes).toFixed(2);
                    isss=parseFloat(data.boleta[j].isss).toFixed(2);
                    afp_ipsfa=parseFloat(data.boleta[j].afp_ipsfa).toFixed(2);

                    //solo serviran para poder generar el reporte
                    total_bono=parseFloat(data.boleta[j].total_bono).toFixed(2);
                    total_viaticos=parseFloat(data.boleta[j].total_viatico).toFixed(2);

                    total_bono=parseFloat(Number(data.boleta[j].total_bono)-Number(bono_isss_afp)).toFixed(2);

                    parse_bono=Number(total_bono);
                    parse_viaticos=Number(total_viaticos);
                    total_bono_viatico=parseFloat(parse_bono+parse_viaticos).toFixed(2);
                    //isss=0;
                    //afp_ipsfa=0;
                    isr=parseFloat(data.boleta[j].isr).toFixed(2);
                    anticipos=parseFloat(data.boleta[j].anticipos).toFixed(2);
                    prestamo_interno=parseFloat(data.boleta[j].prestamo_interno).toFixed(2);
                    prestamo_personal=parseFloat(data.boleta[j].prestamo_personal).toFixed(2);
                    banco=parseFloat(data.boleta[j].orden_descuento).toFixed(2);
                    horas_descuento=parseFloat(data.boleta[j].horas_descuento).toFixed(2);
                    total_pagar=parseFloat(data.boleta[j].total_pagar).toFixed(2);
                    salario_quincenal=parseFloat(data.boleta[j].salario_quincena).toFixed(2);
                    total_devengado=parseFloat(data.boleta[j].total_devengado).toFixed(2);
                    total_deducciones=Math.floor(data.boleta[j].total_deducciones * 100) / 100 ;
                    dias=parseFloat(data.boleta[j].dias).toFixed(2);
                    
                    if (isss==0  && afp_ipsfa==0) {
                        decre='<div style="margin: 10px;text-align: center;" ><b style="font-size:15px">En cumplimiento al DL. N° 641 y el DL. N° 685</b></div>';
                        if (data.boleta[j].id_empresa==1){
                        $('#mostrar').append(
                        '<br><div class="row" style="margin: 10px;text-align: center;" >'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/watermark.png" style="width:140px; height=140px;margin-top:35px" id="logo_permiso"></div>'+
                            '<div class="col-sm-4"></div></div>'+
                        '</div> <div style="margin: 12px;text-align: center;" > <b style="font-size:16.5px">Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> '+decre+'</b> </div>'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE PAGO</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        );
                        }else if (data.boleta[j].id_empresa==2){
                           $('#mostrar').append(
                        '<br><div class="row" style="margin: 10px;text-align: center;" >'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/AlterOcci.png" ></div>'+
                            '<div class="col-sm-4"></div></div>'+
                        '</div> <div style="margin: 12px;text-align: center;" > <b style="font-size:16.5px">Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> '+decre+'</b> </div>'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE PAGO</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        );
                        }else if (data.boleta[j].id_empresa==3){
                        $('#mostrar').append(
                        '<br><div class="row" style="margin: 10px;text-align: center;" >'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob"></div>'+
                            '<div class="col-sm-4" ><img src="<?= base_url();?>/assets/images/secofi_logo.png" style="width:140px; height=140px;" id="logo_permiso"></div>'+
                            '<div class="col-sm-4"></div></div>'+
                        '</div> <div style="margin: 12px;text-align: center;" > <b style="font-size:16.5px">Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento<br>  a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. <br> '+decre+'</b> </div>'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE PAGO</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        );
                        }
                       

                    }
                    if (isss==0  && afp_ipsfa==0) {
                    $('#mostrar').append(
                    '<div class="col-sm-12" >'+
                        '<div class="row col-sm-12" >'+
                            '<div class="row" style="margin: 5px;text-align: left; ">'+
                                '<div class="col-sm-4" style="border:1px solid"><b>DATOS DEL EMPLEADO</b></div>'+
                                '<div class="col-sm-4"></div>'+
                                '<div class="col-sm-4"><b>N° de dias trabajados: '+dias+'</b></div> '+
                            '</div>'+
                            '<div class="row" style="margin: 5px;text-align: center">'+         
                                '<table class="table" style="border:1px solid" >'+
                                  '<thead>'+
                                    '<tr >'+
                                          '<td style="border:1px solid"><b>Codigo</b></td>'+
                                          '<td style="border:1px solid"><b>Nombres</b></td>'+
                                          '<td style="border:1px solid"><b>Apellidos</b></td>'+
                                          '<td style="border:1px solid"><b>DUI</b></td>'+
                                          '<td style="border:1px solid"><b>Cargo</b></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                          '<td style="border:1px solid"><b></b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].nombre+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].apellido+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].dui+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].cargo+'</b></td>'+
                                    '</tr>'+
                                  '</thead>'+
                                    '<tbody id="prueba">'+

                                    '</tbody>'+
                                '</table>'+
                            '</div>'+     
                        '</div>'+
                        '<div class="row col-sm-12" >'+
                            '<div class="row" style="margin: 5px;text-align: center">'+
                                '<div class="col-sm-6" style="border:1px solid; padding: 5px"><b>REMUNERACIONES</b></div>'+
                                '<div class="col-sm-6" style="border:1px solid;padding: 5px"><b>RETENCIONES/DESCUENTOS</b></div>'+
                                '<!--datos a traer-->'+
                                '<div class="col-sm-6" style="border:1px solid;">'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Salario Quincenal</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ '+salario_quincenal+'</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Comisiones</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+comision+'</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Bonos</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+bono+'</label></div>   '+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Horas Extras</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+horas_extras+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Viaticos</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+viaticos+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3" style="border-top:double;"></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-6"><b>TOTAL DEVENGADO</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+total_devengado+'</label></div>'+
                                   '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b></b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>&nbsp;</label></div> '+  
                                    '</div>'+
                                    //

                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b></b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>&nbsp;</label></div> '+  
                                    '</div>'+
                                    //
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 0px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                     '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    espacio.join('')+//Metodo join() une todos los elemntos y los vuelve una cadena
                                    aux.join('')+
                                    aux2.join('')+
                                    desc_herra+
                                    aux3.join('')+
                                    desc_anti+//julio ernesto garcia el va del 16 al 30
                                    prueba+//sirve para llenar espacios cuando se crea un elemento en la tabla
                                '</div>'+
                                //siguiente mitad
                                '<div class="col-sm-6" style="border:1px solid">'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Isss</b></div>'+
                                       ' <div class="col-sm-4"></div>'+
                                       ' <div class="col-sm-3"><label>$  '+isss+'</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Afp/Ipsfa</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$  '+afp_ipsfa+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Isr</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$  '+isr+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Total Anticipo</b></div>'+
                                       ' <div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ '+anticipos+'</label></div>'+ 

                                     //inicio
                                    '<div class="col-sm-12 prueba" id="mostrar_herramientas'+j+'" style="">'+
                                        '<div class="row " style="margin: 7.5px;text-align: left;">'+
                                            descuento_herramienta.join('')+
                                            anticipo.join('')+
                                        '</div>'+
                                    '</div>'+
                                    //fin de donde deberia ir el for 
                                    '</div>'+
                                    //faltantes
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Faltantes</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ '+descuentos_faltantes+'</label></div>'+   
                                    '</div>'+
                                    //faltantes
                                     
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Total Prestamo Interno</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+prestamo_interno+'</label></div> '+ 
                                    //inicio
                                    '<div class="col-sm-12 prueba" id="mostrar_pres'+j+'" style="">'+
                                        '<div class="row " style="margin: 7.5px;text-align: left;">'+
                                            mostrar_prestamo.join('')+
                                        '</div>'+
                                    '</div>'+
                                    //fin de donde deberia ir el for 
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Prestamo personal</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+prestamo_personal+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Total Bancos</b></div>'+
                                       ' <div class="col-sm-3"><p id="a"></p></div>'+
                                        '<div class="col-sm-3"><label>$ '+banco+'</label></div>'+
                                    //inicio
                                    '<div class="col-sm-12">'+
                                    '<div class="row" style="margin: 7.5px;text-align: left;">'+
                                      mostrar_banco.join('')+
                                      '</div>'+
                                    '</div>'+
                                    //fin de donde deberia ir el for
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Descuento de horas</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+horas_descuento+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                            '<div class="col-sm-5"></div>'+
                                            '<div class="col-sm-4"></div>'+
                                            '<div class="col-sm-3" style="border-top:double;"></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>TOTAL DEDUCCIONES</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+total_deducciones+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px" >'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                '</div>'+
                           ' </div>'+      
                        '</div>'+
                        '<div class="col-sm-6">'+
                           ' <div>'+
                                '<br><br><br><br><br>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                           ' <div style="margin: 10px;text-align: center;" >'+
                                '<div class="row col-sm-12" style="border:1px solid;border-radius: 15px;" >'+
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-6"><b>TOTAL A PAGAR</b></div>'+
                                       ' <div class="col-sm-2"></div>'+
                                        '<div class="col-sm-4"><label>$ '+total_pagar+'</label></div> '+     
                                    '</div>'+
                               ' </div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '<div class="col-sm-12">'+
                    '<div><br>'+
                        '<div class="row">'+           
                           '<center><div class="col-md-6" id="firma_auto"><b>__________________________<br>Firma Autorizado</b></div></center>'+
                            '<center><div class="col-md-6" id="jefe_inme"><b>__________________________<br>Firma Empleado<br>N° DUI: '+data.boleta[j].dui+' <br> N° NIT: '+data.boleta[j].nit+'</b></div></center>'+
                       ' </div>'+
                    '</div><br>'+
                '</div>'+
                '<div id="esp" style="page-break-before: always">'+//salto de pagina
                '</div><br><br>'
                        ); //final de creacion de la boleta
                }
                    /*
                    /*CREACION DE BOLETA DE BONOS*/
                    //ESTO SE VA A QUITAR DESPUES YA QUE EN MESES ANTERIORES SE GENERAN ESTAS BOLETAS
                    
                  /*  if (data.boleta[j].total_bono > 0 || data.boleta[j].total_viatico  > 0 ) {
                         if (data.boleta[j].id_empresa==1){
                        $('#mostrar').append(
                        '<br><div style="margin: 10px;text-align: center;" >'+
                            '<img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso">'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE BONOS Y VIATICOS</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        );
                        }else if (data.boleta[j].id_empresa==2){
                            $('#mostrar').append(
                        '<br><div style="margin: 10px;text-align: center;" >'+
                            '<img src="<?= base_url();?>/assets/images/AlterOcci.png" id="logo_permiso">'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE BONOS Y VIATICOS</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        ); 
                        }else if (data.boleta[j].id_empresa==3){
                        $('#mostrar').append(
                        '<br><div style="margin: 10px;text-align: center;" >'+
                            '<img src="<?= base_url();?>/assets/images/secofi_logo.png" id="logo_permiso">'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center;" >'+
                        '    <b>BOLETA DE BONOS Y VIATICOS</b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[0].agencia+', <?=  date("j")." de ". meses(date('m'))." de ".date("Y");?></b>'+
                        '</div>'+
                        '<div style="margin: 10px;text-align: center; text-transform: uppercase;" >'+
                        '    <b>'+data.boleta[j].fecha+'</b>'+
                        '</div>' +
                        '<br><br>'
                        );
                        }
                        decre="";

                        $('#mostrar').append(
                    '<div class="col-sm-12" >'+
                        '<div class="row col-sm-12" >'+
                            '<div class="row" style="margin: 5px;text-align: left; ">'+
                                '<div class="col-sm-4" style="border:1px solid"><b>DATOS DEL EMPLEADO</b></div>'+
                                '<div class="col-sm-4"></div>'+
                                '<div class="col-sm-4"><b>N° de dias trabajados: '+dias+'</b></div> '+
                            '</div>'+
                            '<div class="row" style="margin: 5px;text-align: center">'+         
                                '<table class="table" style="border:1px solid" >'+
                                  '<thead>'+
                                    '<tr >'+
                                          '<td style="border:1px solid"><b>Codigo</b></td>'+
                                          '<td style="border:1px solid"><b>Nombres</b></td>'+
                                          '<td style="border:1px solid"><b>Apellidos</b></td>'+
                                          '<td style="border:1px solid"><b>DUI</b></td>'+
                                          '<td style="border:1px solid"><b>Cargo</b></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                          '<td style="border:1px solid"><b></b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].nombre+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].apellido+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].dui+'</b></td>'+
                                          '<td style="border:1px solid"><b>'+data.boleta[j].cargo+'</b></td>'+
                                    '</tr>'+
                                  '</thead>'+
                                    '<tbody id="prueba">'+

                                    '</tbody>'+
                                '</table>'+
                            '</div>'+     
                        '</div>'+
                        '<div class="row col-sm-12" >'+
                            '<div class="row" style="margin: 5px;text-align: center">'+
                                '<div class="col-sm-6" style="border:1px solid; padding: 5px"><b>REMUNERACIONES</b></div>'+
                                '<div class="col-sm-6" style="border:1px solid;padding: 5px"><b>RETENCIONES/DESCUENTOS</b></div>'+
                                '<!--datos a traer-->'+
                                '<div class="col-sm-6" style="border:1px solid;">'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Salario Quincenal</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Comisiones</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Bonos</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+total_bono+'</label></div>   '+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Horas Extras</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b>Viaticos</b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>$ '+total_viaticos+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3" style="border-top:double;"></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-6"><b>TOTAL DEVENGADO</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+total_bono_viatico+'</label></div>'+
                                   '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b></b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>&nbsp;</label></div> '+  
                                    '</div>'+
                                    //

                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-4"><b></b></div>'+
                                        '<div class="col-sm-5"></div>'+
                                        '<div class="col-sm-3"><label>&nbsp;</label></div> '+  
                                    '</div>'+
                                    //
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 0px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                     '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                '</div>'+
                                //siguiente mitad
                                '<div class="col-sm-6" style="border:1px solid">'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Isss</b></div>'+
                                       ' <div class="col-sm-4"></div>'+
                                       ' <div class="col-sm-3"><label>$ '+bono_isss+'</label></div> '+  
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Afp/Ipsfa</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$  '+bono_afp+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Isr</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$  0.00</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Total Anticipo</b></div>'+
                                       ' <div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+ 
                                    //fin de donde deberia ir el for 
                                    '</div>'+
                                    //faltantes
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-5"><b>Faltantes</b></div>'+
                                        '<div class="col-sm-4"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+   
                                    '</div>'+
                                    //faltantes
                                     
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Total Prestamo Interno</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div> '+ 
                                    //inicio
                                    //fin de donde deberia ir el for 
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Prestamo personal</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Total Bancos</b></div>'+
                                       ' <div class="col-sm-3"><p id="a"></p></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+
                                    //inicio
                                    '<div class="col-sm-12">'+
                                    '<div class="row" style="margin: 7.5px;text-align: left;">'+
                                      '</div>'+
                                    '</div>'+
                                    //fin de donde deberia ir el for
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>Descuento de horas</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ 0.00</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                            '<div class="col-sm-5"></div>'+
                                            '<div class="col-sm-4"></div>'+
                                            '<div class="col-sm-3" style="border-top:double;"></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px;text-align: left;">'+
                                        '<div class="col-sm-6"><b>TOTAL DEDUCCIONES</b></div>'+
                                        '<div class="col-sm-3"></div>'+
                                        '<div class="col-sm-3"><label>$ '+bono_isss_afp+'</label></div>'+   
                                    '</div>'+
                                    '<div class="row" style="margin: 5px" >'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                    '<div class="row" style="margin: 5px">'+
                                        '<div class="col-sm-12">&nbsp;</div>'+
                                    '</div>'+
                                '</div>'+
                           ' </div>'+      
                        '</div>'+
                        '<div class="col-sm-6">'+
                           ' <div>'+
                                '<br><br><br><br><br>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                           ' <div style="margin: 10px;text-align: center;" >'+
                                '<div class="row col-sm-12" style="border:1px solid;border-radius: 15px;" >'+
                                    '<div class="row" style="margin: 10px">'+
                                        '<div class="col-sm-6"><b>TOTAL A PAGAR</b></div>'+
                                       ' <div class="col-sm-2"></div>'+
                                        '<div class="col-sm-4"><label>$ '+total_bono_viatico+'</label></div> '+     
                                    '</div>'+
                               ' </div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '<div class="col-sm-12">'+
                    '<div><br>'+
                        '<div class="row">'+           
                           '<center><div class="col-md-6" id="firma_auto"><b>__________________________<br>Firma Autorizado</b></div></center>'+
                            '<center><div class="col-md-6" id="jefe_inme"><b>__________________________<br>Firma Empleado<br>N° DUI: '+data.boleta[j].dui+' <br> N° NIT: '+data.boleta[j].nit+'</b></div></center>'+
                       ' </div>'+
                    '</div><br>'+
                '</div>'+
                '<div id="esp" style="page-break-before: always">'+//salto de pagina
                '</div><br><br>'
                        );*/ //final de creacion de la boleta
                    //}

                    mostrar_banco=[];
                    mostrar_prestamo=[];
                    descuento_herramienta=[];
                    anticipo=[];

                    aux=[];
                    aux2=[];
                    aux3=[];

                    espacio=[];
                    prueba='';
                    desc_herra='';
                    desc_anti='';
                    if(data.boleta[j].prestamos_internos.length==0){
                        $('#mostrar_pres'+j+'').css('display','none');
                    }else{
                    $('#mostrar_pres'+j+'').show();
                    }

                    if(data.boleta[j].descuento_herramienta.length==0 && data.boleta[j].anticipo.length==0){
                        $('#mostrar_herramientas'+j+'').css('display','none');
                    }else{
                    $('#mostrar_herramientas'+j+'').show();
                    }

                    i++;
                    j++;
                    });
                }    
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