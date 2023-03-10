<style type="text/css">
    @media print{
    .ocultar{
    display: none;
        }
    .contenedor{
        text-align: left;
    }
    }
    @media print,screen {
    @page { 
        size: portrait;
    }
    b{ font-size: 12px }
    span{ font-size: 13px; }
    }
    b{text-transform: uppercase;}
    #cancelacion_text{font-size: 22px;}
    .c_text{font-size: 19px;}
    .c_text2{font-size: 17px;}
    hr { border: 1px solid;}
    .firma{
        width:150px; 
        height: 100px
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
<div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Recibo de Vacaciones</h2>
    </div>
        <input type="hidden" name="id_vacacion" id="id_vacacion" value="<?php echo $this->uri->segment(3); ?>" readonly>

    <div class="col-sm-10" id="buscador">
        <div class="col-sm-12">

            <div class="form-group col-sm-3">
                <button class="btn btn-success crear ocultar" id="btn_imprimir" >Imprimir</button>
           </div>
                         
        </div>
    </div>
    <div class="col-sm-12">
        <div id="mostrar" >
 
        <!--mostrar-->
        </div>
    </div>
    <div class="col-sm-12">
        <div id="mostrar2" >
 
        <!--mostrar-->
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->

<script type="text/javascript">
    $(document).ready(function(){
    //$('#mostrar2').hide();
    $('.crear').click(function(){  
        $('#btn_imprimir').hide();
        $("#mostrar2").removeClass("well");
        $('#mostrar2').show();
        window.print();
        $("#mostrar2").addClass("well");
        $('#mostrar2').show();
        $('#btn_imprimir').show();
    });

        llamar_datos();

        function llamar_datos(mes=null,quincena=null){ 
            var id_vacacion = $('#id_vacacion').val();
            var i=0;
            $("#mostrar").empty();
            $("#mostrar2").empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Vacaciones/llenar_recibo')?>',
                dataType : 'JSON',
                data : {id_vacacion:id_vacacion},
                success : function(data){
                console.log(data);
                cantidad_apagar=parseFloat(data[0].cantidad_apagar).toFixed(2);
                afp_ipsfa=parseFloat(data[0].afp_ipsfa).toFixed(2);
                isss=parseFloat(data[0].isss).toFixed(2);
                isr=parseFloat(data[0].isr).toFixed(2);
                prima=parseFloat(data[0].prima).toFixed(2);
                comision=parseFloat(data[0].comision).toFixed(2);
                bono=parseFloat(data[0].bono).toFixed(2);
                salario_base=(data.salario_base).replace(/,/g, "");
                prestaciones_legales=data.prestaciones_legales;
                salario_diario=((salario_base/15)).toFixed(2);
                total_devengado=parseFloat(salario_base+prestaciones_legales).toFixed(2);
                anticipos=parseFloat(data[0].anticipos).toFixed(2);
                prestamos_personal=parseFloat(data[0].prestamos_personal).toFixed(2);
                orden_descuento=parseFloat(data[0].orden_descuento).toFixed(2);
                prestamo_interno=parseFloat(data[0].prestamo_interno).toFixed(2);
                cancelacion=parseFloat(data.cancelacion).toFixed(2);
                anio = data[0].fecha_aprobado.substr(0,4);
                if (data[0].afp!=null){
                    nombreAfpIpsfa="AFP (7.25%)";
                }else{
                    nombreAfpIpsfa="IPSFA (6%)";
                }

                if (data[0].id_empresa==1){//Altercredit
                $('#mostrar').append(
                '<div id="todo">'+      
                '<div style="margin: 10px;text-align: center;" >'+
                    '<img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso">'+
                '</div><br>'+
                '<div style="margin: 10px;text-align: center;">'+
                    '<div><b>Recibo de vacaciones '+anio+'</b></div>'+
                '</div>'
                );
                }else if (data[0].id_empresa==2){//Altercredit Occidente
                $('#mostrar').append(
                '<div id="todo">'+      
                '<div style="margin: 10px;text-align: center;" >'+
                    '<img src="<?= base_url();?>/assets/images/AlterOcci.png" style="width:250px" id="logo_permiso">'+
                '</div><br>'+
                '<div style="margin: 10px;text-align: center;">'+
                    '<div><b>Recibo de vacaciones '+anio+'</b></div>'+
                '</div>'
                );
                }else if (data[0].id_empresa==3){//secofi
                $('#mostrar').append(
                '<div id="todo">'+      
                '<div style="margin: 10px;text-align: center;" >'+
                    '<img src="<?= base_url();?>/assets/images/secofi_logo.png" style="width:125px" id="logo_permiso">'+
                '</div><br>'+
                '<div style="margin: 10px;text-align: center;">'+
                    '<div><b>Recibo de vacaciones '+anio+'</b></div>'+
                '</div>'
                );
                }
                 $('#mostrar').append('<div style="margin: 10px;" class="contenedor">'+
                    '<span>Yo, <b>'+data[0].nombre+' '+data[0].apellido+'</b> empleado(a) de '+data[0].nombre_empresa+' destacado(a) en Agencia <b>'+data[0].agencia+'</b>, hago constar que se me ha otorgado el goce de las vacaciones que me corresponden en el presente año del '+anio+', del '+data.fecha_inicio+' al '+data.fecha_fin+', en la forma y términos que establece el Código de Trabajo de El Salvador y el Reglamento Interno de Trabajo que se aplica en '+data[0].nombre_empresa+' el periodo antes señalado me fue pagado, así como la prima vacacional a razón del 30% adicional sobre el salario base, de la siguiente manera:</span>'+
                '</div>'+
                '<br>'+
                '<!--Contenedor info-->'+
                '<div class="contenedor">'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>Salario base quincenal</b></div>'+
                        '<div class="col-sm-2"><span>$ '+salario_base+'</span></div>'+
                        '<div class="col-sm-4"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>Salario diario</b></div>'+
                        '<div class="col-sm-2"><span>$ '+salario_diario+'</span></div>'+
                        '<div class="col-sm-4"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>prestaciones legales</b></div>'+
                        '<div class="col-sm-2"><span>$ '+data.prestaciones_legales+'</span></div>'+
                        '<div class="col-sm-4"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>Total devengado</b></div>'+
                        '<div class="col-sm-2"><span>$ '+total_devengado+'</span></div>'+
                        '<div class="col-sm-4"><b></b></div>'+
                   '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>fecha de ingreso</b></div>'+
                        '<div class="col-sm-2"><span>'+data.empleado_inicio+'</span></div>'+
                        '<div class="col-sm-4"><b></b></div>'+
                    '</div><br><br>'+
                '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b style="text-decoration: underline;">1) Vacación</b></div>'+
                    '</div><br>'+
                '<!--Fin Contenedor info-->'+
                '<div class="contenedor">'+
                    '<div class="row">'+
                         '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>PRESTACIÓN POR VACACIÓN</span></div>'+
                        '<div class="col-sm-1">&nbsp;</div>'+
                        '<div class="col-sm-2"><span>$ '+total_devengado+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>PRIMA DE VACACIÓN</span></div>'+
                        '<div class="col-sm-1">&nbsp;</div>'+
                        '<div class="col-sm-2"><b style=" border-bottom-style: double;">$ '+prima+'</b></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b>total a pagar vacación</b></div>'+
                        '<div class="col-sm-1">&nbsp;</div>'+
                        '<div class="col-sm-2"><span>$ '+cantidad_apagar+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row" style="margin-top: 15px">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-6"><span>TOTAL A PAGAR VACACIÓN + PRESTACIONES</span></div>'+
                        '<div class="col-sm-2"><b style=" border-bottom-style: double;">$ '+cantidad_apagar+'</b></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div><br>'+
                '</div>'+
                '<div class="contenedor">'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>MONTO GRAVADO</span></div>'+
                        '<div class="col-sm-2"><span>$ '+cantidad_apagar+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div><br>'+
                    '<div class="row">'+
                    '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><b style="text-decoration: underline;">2) Deducciones</b></div>'+
                    '</div><br>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>ISSS (3%)</span></div>'+
                        '<div class="col-sm-2"><span>$ '+isss+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>'+nombreAfpIpsfa+'</span></div>'+
                        '<div class="col-sm-2"><span>$ '+afp_ipsfa+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>ISR</span></div>'+
                        '<div class="col-sm-2"><span>$ '+isr+'</span></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+

                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>TOTAL DEDUCCIONES</span></div>'+
                        '<div class="col-sm-2">&nbsp;</div>'+
                        '<div class="col-sm-2"><b style=" border-bottom-style: double;">$ '+data.total_deducciones+'</b></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-1"><b></b></div>'+
                        '<div class="col-sm-4"><span>MONTO A PAGAR</span></div>'+
                        '<div class="col-sm-2">&nbsp;</div>'+
                        '<div class="col-sm-2"><b style=" border-bottom-style: double;">$ '+data.monto_apagar+'</b></div>'+
                        '<div class="col-sm-3"><b></b></div>'+
                    '</div><br>'+
                '</div>'+
                '<div style="height: 50px;"></div>'+
                '<div style="text-align: center;">'+
                    '<div class="row">'+
                        '<div class="col-sm-6"><span>'+data[0].agencia+', '+data[0].fecha_aprobado.substr(8,2)+' de '+meses(data[0].fecha_aprobado.substr(5,2))+' de '+data[0].fecha_aprobado.substr(0,4)+'</span></div>'+
                    '</div>'+
                '</div>'+
                '<div style="height: 60px;"></div>'+

                '<div style="text-align: center;" class="col-sm-12">'+

                    '<div class="col-sm-6">'+
                        '<span>F_______________________</span><br>'+
                        '<span>'+data[0].nombre+' '+data[0].apellido+'</span><br>'+
                        '<span>DUI: '+data[0].dui+'</span><br>'+
                        '<span><span>NIT: '+data[0].nit+'</span>'+
                    '</div>'+

                    '<div class="col-sm-6">'+
                        '<img src="'+data.firma+'" id="firma" class="firma" style="width:240px;position:relative;top: -70px; "><br>'+
                        '<span style="position:relative;top: -60px; ">'+data.nombre_auto+'</span><br>'+
                        '<span style="position:relative;top: -60px; ">'+data.cargo_auto+'</span><br>'+
                    '</div>'+
                    

                '</div>'+

        '</div><!--todo-->'        
                 );

        if(cancelacion > 0){
               //cancelacion de deuda
            if (data[0].id_empresa==1){//Altercredit
                    $('#mostrar2').append(
                    '<br><br><div id="todo">'+      
                    '<div style="margin: 10px;text-align: center;" >'+
                        '<img src="<?= base_url();?>/assets/images/watermark.png" id="logo_permiso">'+
                    '</div><br>'
                    );
                    }else if (data[0].id_empresa==2){//Altercredit Occidente
                    $('#mostrar2').append(
                    '<br><br><div id="todo">'+      
                    '<div style="margin: 10px;text-align: center;" >'+
                        '<img src="<?= base_url();?>/assets/images/AlterOcci.png" style="width:250px" id="logo_permiso">'+
                    '</div><br>'
                    );
                    }else if (data[0].id_empresa==3){//secofi
                    $('#mostrar2').append(
                    '<br><br><div id="todo">'+      
                    '<div style="margin: 10px;text-align: center;" >'+
                        '<img src="<?= base_url();?>/assets/images/secofi_logo.png" style="width:125px" id="logo_permiso">'+
                    '</div><br>'
                    );
                    }
                     $('#mostrar2').append(
                        '<br><br>'+
                        '<div style="margin: 10px;text-align: center;">'+
                            '<div><b id="cancelacion_text">CANCELACIÓN DE DEUDA</b></div>'+
                        '</div>'+
                        '<div style="margin: 10px;" class="contenedor">'+
                        '<br><br><br><br>'+
                        '<span class="c_text">Por medio de la presente se hace constar el/la señor/a: <b class="c_text">'+data[0].nombre+' '+data[0].apellido+'</b> realizó el pago correspondiente al periodo de '+data.fecha_inicio+' al '+data.fecha_fin+', a la empresa <b class="c_text">'+data[0].nombre_empresa+'</b> por un monto de '+data.cancelacion_letras+' ($'+cancelacion+'), cancelándolo el día '+data[0].fecha_aprobado.substr(8,2)+' de '+meses(data[0].fecha_aprobado.substr(5,2))+' de '+data[0].fecha_aprobado.substr(0,4)+', en los siguientes conceptos:</span>'+
                    '</div>'+
                    '<br><br>'+
                    '<!--Contenedor info-->'+
                    '<div class="contenedor">'+
                        '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Anticipo Salarial</span></div>'+
                            '<div class="col-sm-2"><span class="c_text">$ '+anticipos+'</span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Cuota de préstamo Personal</<span></div>'+
                            '<div class="col-sm-2"><span class="c_text">$ '+prestamos_personal+' </span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Cuota de préstamo de Banco</<span></div>'+
                            '<div class="col-sm-2"><span class="c_text">$ '+orden_descuento+'</span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Cuota de Prestamo Interno</<span></div>'+
                            '<div class="col-sm-2"><span class="c_text">$ '+prestamo_interno+'</span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                       '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Faltante</<span></div>'+
                            '<div class="col-sm-2"><span class="c_text">$ 0.00</span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                        '</div>'+
                         '<div class="row">'+
                            '<div class="col-sm-1"><b></b></div>'+
                            '<div class="col-sm-5"><span class="c_text">Total</<span></div>'+
                            '<div class="col-sm-2"><span class="c_text" style=" border-top-style: double;">$ '+cancelacion+'</span></div>'+
                            '<div class="col-sm-3"><b></b></div>'+
                        '</div><br><br>'+
                        '<span class="c_text">Y para los usos que se estime conveniente se extiende la presente en la ciudad de '+data[0].agencia+', a los '+data[0].fecha_aprobado.substr(8,2)+' dias del mes de '+meses(data[0].fecha_aprobado.substr(5,2))+' de '+data[0].fecha_aprobado.substr(0,4)+'.<br><br><br></span>'+
                        '<div class="row">'+
                           '<center>'+

                                '<div class="col-sm-12">'+
                                    '<img src="'+data.firma+'" id="firma" class="firma" style="width:300px;"><br>'+
                                    '<span>'+data.nombre_auto+'</span><br>'+
                                    '<span>'+data.cargo_auto+'</span><br>'+
                                '</div>'+

                           '</center>'+
                        '</div>'+
                        '<br><br><br><br>'+
                        '<div class="row">'+
                            '<div class="col-sm-1"></div>'+
                            '<div class="col-sm-10"><br>'+
                            '<center><div class="col-sm-10" style="opacity:.5;border-top-style: solid; width:650px"><br>'+
                                //'<hr style="opacity: .5;">'+
                                //'<span>_________________________________________________________________________________________________________<br></span>'+
                                '<span class="c_text2">'+data[0].direccion+'.<br>Tel. '+data[0].tel+'</span></div>'+
                            '</div></center>'+
                            '<div class="col-sm-1">&nbsp</div>'+
                        '</div>'+
                            
                      '</div>'+
                    '</div>'+
            '</div><!--todo-->'        
                     
                );
        }
            //$.each(data,function(key, registro){ });
 
            },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

    });//Fin jQuery <tr><td>&nbsp;</td></tr>
    function meses(mes){
        var meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        return meses[mes-1];
    }
</script>
</body>

</html>