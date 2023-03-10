<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Calendario de Vacaciones</h2>
    </div>
    <div class="row">
        <nav class="float-right">
            <div class="col-sm-12">
                <div class="form-row">

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Mes de Vacacion</label>
                        <input type="month" class="form-control" id="mes_vacacion" name="mes_vacacion" value="<?php echo date('Y-m')?>">
                    </div>

                    <?php if ($estado==1 && $registrar==1) { ?>
                        <div class="form-group col-md-5"></div>
                        <div class="form-group col-md-4">
                        <center><label for="inputState">*Ingresar todos los dias de vacacion</label></center>
                            <div class="form-group col-md-8">
                                <label for="inputState">Fecha de inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d')?>">
                            </div>
                            <div class="form-group col-md-4">
                            <a id="item_iniciar" class="btn btn-primary btn-sm item_iniciar" style="margin-top: 23px;">Aceptar</a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>

                <table class="table table-bordered" border="1" id="mydata">
                    <thead>
                        <tr>
                            <th colspan="2" style=" border: inset 0pt"> 
                            </th>
                            <th colspan="3" style=" border: inset 0pt">
                                <div style="text-align: center;"><b id="nombre_empleado"></b></div>
                            </th>
                            <th colspan="2" style=" border: inset 0pt">
                                <div style="text-align: center;"><b>Fecha de Ingreso:</b> <b id="fecha_ingreso"></b></div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="7">
                                <center><div id="fecha"></div><div id="conteo"><?php echo $tvaca ?></div></center>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tabla1">
                    
                    </tbody>
                </table>

                </div>
            </div>
        </nav>
        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
    </div>
</div>

<!--MODAL AGREGAR-->
<form>
        <div class="modal fade" id="Modal_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">
                        Agregar vacacion 
                    </h4>
                </center>
                
                </div>
                <div class="modal-body">
                    <strong>¿Seleccione la accion que desea realizar?</strong><br>
                    <div id="validacion" style="color:red"></div>
                    <br><div class="pretty p-switch p-fill">
                        <input type="checkbox" name="switch1" id="completo" />
                        <div class="state p-success">
                            <label>Dia Completo</label>
                        </div>
                    </div><br><br>
                    <div class="form-inline">
                    <div class="form-group">
                        <label for="horas">horas:</label>
                        <input type="number" class="form-control" id="horas" name="horas">
                      </div>
                      <div class="form-group">
                        <label for="munitos">Minutos:</label>
                        <input type="number" class="form-control" id="minutos" name="minutos">
                      </div>
                    </div>

                    <center><div id="cantidad" style="color: blue"></div></center>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="fecha_vacacion" id="fecha_vacacion" class="form-control" readonly>
                    <input type="hidden" name="hora_vacacion" id="hora_vacacion" class="form-control" readonly>
                    <input type="hidden" name="minutos_vacacion" id="minutos_vacacion" class="form-control" readonly>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_save" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
</form>
<!--END MODAL AGREGAR-->

<!--MODAL AGREGAR VACACION ANTICIPADA-->
<form>
        <div class="modal fade" id="Modal_anticipada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">
                        Agregar Vacacion Anticipada
                    </h4>
                </center>
                
                </div>
                <div class="modal-body">
                    <strong>¿Seleccione la accion que desea realizar?</strong><br>
                    <div id="validacion_anticipada" style="color:red"></div>
                    <br><div class="pretty p-switch p-fill">
                        <input type="checkbox" name="switch1" id="completo_anticipada" />
                        <div class="state p-success">
                            <label>Dia Completo</label>
                        </div>
                    </div><br><br>
                    <div class="form-inline">
                    <div class="form-group">
                        <label for="horas">horas:</label>
                        <input type="number" class="form-control" id="horas_anticipada" name="horas_anticipada">
                      </div>
                      <div class="form-group">
                        <label for="munitos">Minutos:</label>
                        <input type="number" class="form-control" id="minutos_anticipada" name="minutos_anticipada">
                      </div>
                    </div>

                    <center><div id="cantidad_anticipada" style="color: blue"></div></center>
                    
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="fecha_anticipada" id="fecha_anticipada" class="form-control" readonly>
                    <input type="hidden" name="hora_ant" id="hora_ant" class="form-control" readonly>
                    <input type="hidden" name="minutos_ant" id="minutos_ant" class="form-control" readonly>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_save_ant" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
</form>
<!--END MODAL AGREGAR-->

<form>
    <div class="modal fade" id="Modal_Asuetos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel-success">
                <div class="modal-header panel-heading">
                    <center><h4 class="modal-title" id="nombre_asueto"></h4></center>
                    
                </div>
                <div class="modal-body">
                    <center><strong id='descripcion_asueto'></strong></center>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form>
    <div class="modal fade" id="Modal_Inicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel">Ingreso de Dias</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea ingresar todas las vacaciones?</strong>
                </div>
                <div class="modal-footer">
                <input type="text" name="fecha_inc" id="fecha_inc" class="form-control" readonly>
                <input type="text" name="empleado_inc" id="empleado_inc" class="form-control" readonly>
                <input type="text" name="user_inc" id="user_inc" class="form-control" readonly>
                <input type="text" name="dias_inc" id="dias_inc" class="form-control" readonly value="<?= ($dias);?>">
                <input type="text" name="hora_inc" id="hora_inc" class="form-control" readonly value="<?= ($horas);?>">
                <input type="text" name="min_inc" id="min_inc" class="form-control" readonly value="<?= ($min);?>">
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_todas_vaca" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){

        verDias();
        $('#mes_vacacion').change(function(){

            if($("#mes_vacacion").val().length == 0) { 
                var ahora = new Date();
                var mes = ("0" + (ahora.getMonth() + 1)).slice(-2);
                var hoy = ahora.getFullYear()+"-"+(mes);
                $('[name="mes_vacacion"]').val(hoy);
            }

            verDias();
        });

        //metodo que trae los dia donde han registrado vacacion
        function verDias(){
            //Id del empleado
            var code = $('#id_empleado').val();
            //obtenemos el mes y el año
            var mes = $('#mes_vacacion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/diasVaca')?>",
                dataType : "JSON",
                data : {code:code,mes:mes},
                success: function(data){
                    console.log(data);
                    //se manda lo que se obtuvo a donde se dibuja el calendario
                    load(data);
                },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
                }
            });
        };//fin verDias



        
        function load(data){
            var code = $('#id_empleado').val();
            //obtenemos el mes y el año
            var mes = $('#mes_vacacion').val();
            //se obtiene el primer dia de cada mes
            var diaUno = mes+'-01';
            //console.log(diasVacacion[0].fecha);
            var date = new Date(diaUno);
            //se obtiene el ultimo dia del mes seleccionado
            var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 2, 0);
            //se le da forma al erreglo 
            var diaUltimo = ultimoDia.getFullYear() + '-' + (ultimoDia.getMonth() + 1) + '-' + ultimoDia.getDate();
            //arreglo que tiene los meses del año
            var meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
           //se imprime el mes y el año
            document.getElementById('fecha').innerHTML = meses[ultimoDia.getMonth()]+' de '+ultimoDia.getFullYear();

            document.getElementById('nombre_empleado').innerHTML = data.nombre;
            document.getElementById('fecha_ingreso').innerHTML = data.inicio;

            //arreglo que tiene los dias de la semana
            var dia=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
            //se da formato que se necesita para recorrer los dias
            var fechaInicio = new Date(diaUno);
            var fechaFin    = new Date(diaUltimo);
            //contador que servira para dar el salto en la tabla
            var contador = 1;
            //es una variable para dar los espacios si un mes no empieza ldomingo
            var inicio = 1;
            //contador que sirve para el arreglo de data.dias
            var i = 0;
            //contador que sirve para el arreglo de data.incompleto
            var j = 0;
            //contador que sirve parael arreglo de data.diasA
            var a = 0, b = 0;
            //contador que sirve para el arreglo de data.incompletoA
            var k = 0;
            //contador que servira con data.diasAs
            var m = 0;
            //contadores que sirven para validar los contadores i y j
            var incompletos = 0;
            var completos = 0;
            //contadores que sirven para validar los contadores a y k
            var incompletosA = 0;
            var completosA = 0;
            //Contador para los asuetos que servira con m
            var asuetos = 0;
            
            var dia2 = '';
            var meses2 = '';
            var fecha = '';
            //se limpia la tabla 
            $('.tabla1').empty();

           while(fechaFin.getTime() >= fechaInicio.getTime()){
                //se obtiene la fecha de los dias 
                fechaInicio.setDate(fechaInicio.getDate() + 1);
                //se inicia con las filas de las tablas

                //se obtiene los dias del mes
                dia2 = fechaInicio.getDate();
                //se obtiene el mes
                meses2 = (fechaInicio.getMonth() + 1);

                //si el dia esta entre el rango de 1 a 9 se le antepondra un cero
                //ya que es necesario para que consida con la base
                if(dia2 >= 1 && dia2 <= 9){
                    dia2 = '0'+fechaInicio.getDate();
                }
                //si el mes esta entre el rango de 1 a 9 se le antepondra un cero
                if(meses2 >= 1 && meses2 <= 9){
                    meses2 = '0'+(fechaInicio.getMonth() + 1);
                }

                //se obtiene la fecha en formato año-mes-dia
                fecha = fechaInicio.getFullYear() + '-' + meses2 + '-' + dia2;

                if(contador == 1){
                    $('.tabla1').append(
                        '<tr>'
                    );
                }

                //if para dar espacio para cuando un mes no empieza domingo
                if(inicio == 1){
                    //si el mes empieza lunes se dejara un espacio
                    if(fechaInicio.getDay() == 1){
                        $('.tabla1').append(
                            '<th></th>'
                        );
                    //si el mes empieza martes se dejara dos espacios
                    }else if(fechaInicio.getDay() == 2){
                        $('.tabla1').append(
                            '<th></th>'+
                            '<th></th>'
                        );
                    //si el mes empieza miercoles se dejaran tres espacios
                    }else if(fechaInicio.getDay() == 3){
                        $('.tabla1').append(
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'
                        );
                    //si el mes empieza Jueves se dejaran cuatro espacios
                    }else if(fechaInicio.getDay() == 4){
                        $('.tabla1').append(
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'
                        );
                    //si el mes empieza viernes se dejeran cinco espacios
                    }else if(fechaInicio.getDay() == 5){
                        $('.tabla1').append(
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'
                        );
                    //si el mes empieza sabado se dejaran seis espacios
                    }else if(fechaInicio.getDay() == 6){
                        $('.tabla1').append(
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'+
                            '<th></th>'
                        );
                    }

                    //se cambia esta variable para que ya no entre y haga el recorrido normal
                    inicio = 0;
                }

                //if pasa saber que dias son
                //este es domingo
                if(fechaInicio.getDay() == 0){
                   
                    $(".tabla1").append(
                        '<td>'+
                            '<div id="'+fecha+'" style="border-style: none;">'+
                                '<div class="panel-heading">'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b>'+
                                '</div>'+
                                '<div class="panel-body" id="impri_'+fecha+'" >'+

                                    '<a class="btn btn-info btn-sm btn_asu-'+fecha+'" onclick="asuetos(this)" data-codigo="'+fecha+'" title="Ver Asueto">'+
                                    '<em class="glyphicon glyphicon-glass"></em></a>'+

                                    '<input type="hidden" name="nom_as-'+fecha+'" id="nom_as-'+fecha+'" readonly>'+
                                    '<input type="hidden" name="desc_as-'+fecha+'" id="desc_as-'+fecha+'" readonly>'+

                                '</div>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                //este es lunes
                }else if(fechaInicio.getDay() == 1  || fechaInicio.getDay() == 2 || fechaInicio.getDay() == 3 || fechaInicio.getDay() == 4 || fechaInicio.getDay() == 5){

                            $(".tabla1").append(
                                '<td>'+
                                    '<div id="'+fecha+'" style="border-style: none;">'+
                                        '<div class="panel-heading">'+
                                            '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b>'+
                                        '</div>'+
                                        '<div class="panel-body" id="impri_'+fecha+'">'+

                                            '<?php if ($estado==1 && $registrar==1) { ?><a class="btn btn-default btn-sm btn_agregar-'+fecha+'"onclick="myFunction(this)" title="Agregar Vacacion" data-codigo="'+fecha+'" style="display: none;">'+
        
                                            '<em class="glyphicon glyphicon-plus-sign"></em></a>&nbsp;<?php } ?>'+

                                            '<a class="btn btn-primary btn-sm btn_ver-'+fecha+'" title="Ver Tiempo Tomado" href="<?php echo base_url();?>index.php/Vacaciones/diaVacacion/'+code+'/'+fecha+'">'+
                                            '<em class="fa fa-bars"></em></a>'+

                                            ' <?php if ($estado==2 && $anticipada==1) { ?><a class="btn btn-default btn-sm btn_anticipada-'+fecha+'" title="Agregar Vacacion Anticipada" onclick="anticipada(this)" data-codigo="'+fecha+'" style="display: none;">'+
        
                                            '<em class="glyphicon glyphicon-font"></em></a>&nbsp;<?php } ?>'+

                                            '<a class="btn btn-info btn-sm btn_asu-'+fecha+'" onclick="asuetos(this)" data-codigo="'+fecha+'" title="Ver Asueto" style="display: none;">'+
                                            '<em class="glyphicon glyphicon-glass"></em></a>'+

                                            '<input type="hidden" name="nom_as-'+fecha+'" id="nom_as-'+fecha+'" readonly>'+
                                            '<input type="hidden" name="desc_as-'+fecha+'" id="desc_as-'+fecha+'" readonly>'+

                                        '</div>'+
                                    '</div>'+
                                '</td>'

                            );
                        
                   
                    contador = 0;

                //este es martes
                }else if(fechaInicio.getDay() == 6 ){

                            $(".tabla1").append(
                                '<td>'+
                                    '<div id="'+fecha+'" style="border-style: none;">'+
                                        '<div class="panel-heading">'+
                                            '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b>'+
                                        '</div>'+
                                        '<div class="panel-body" id="impri_'+fecha+'">'+
                                            '<?php if ($estado==1 && $registrar==1) { ?><a class="btn btn-default btn-sm btn_agregar-'+fecha+'" onclick="myFunction(this)" title="Agregar Vacacion" data-codigo="'+fecha+'" style="display: none;" id="agregar"><em class="glyphicon glyphicon-plus-sign"></em></a>&nbsp;<?php } ?>'+

                                            ' <a class="btn btn-primary btn-sm btn_ver-'+fecha+'" title="Ver Tiempo Tomado" href="<?php echo base_url();?>index.php/Vacaciones/diaVacacion/'+code+'/'+fecha+'">'+
                                            '<em class="fa fa-bars"></em></a>'+

                                            ' <?php if ($estado==2 && $anticipada==1) { ?><a class="btn btn-default btn-sm btn_anticipada-'+fecha+'" title="Agregar Vacacion Anticipada" onclick="anticipada(this)" data-codigo="'+fecha+'" style="display: none;">'+
        
                                            '<em class="glyphicon glyphicon-font"></em></a>&nbsp;<?php } ?>'+

                                            '<a class="btn btn-info btn-sm btn_asu-'+fecha+'" onclick="asuetos(this)" data-codigo="'+fecha+'" title="Ver Asueto" style="display: none;">'+
                                            '<em class="glyphicon glyphicon-glass"></em></a>'+

                                            '<input type="hidden" name="nom_as-'+fecha+'" id="nom_as-'+fecha+'" readonly>'+
                                            '<input type="hidden" name="desc_as-'+fecha+'" id="desc_as-'+fecha+'" readonly>'+

                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                '</tr>'

                            );

                    contador = 1;
                }


                //if para validar si hay por lo menos un arreglo lleno, ya sea data.dias o data.incompleto
                if(data.length == undefined){
                    //if para validar si el arreglo data.dias
                    if(data.dias == undefined){
                        //sino esta lleno entra para que el contador sea cero
                        incompletos = 0
                    }else{
                        //si esta lleno en contador toma el valor del la longitud del arreglo
                        incompletos = data.dias.length;
                    }
                    //if para validar si el arreglo data.incompleto
                    if(data.incompleto == undefined){
                        //sino esta lleno entra para que el contador sea cero
                        completos = 0;
                    }else{
                        //si esta lleno en contador toma el valor del la longitud del arreglo
                        completos = data.incompleto.length;
                    }

                    if(data.diasA == undefined){
                        //sino esta lleno entra para que el contador sea cero
                        incompletosA = 0;
                    }else{
                        incompletosA = data.diasA.length;
                    }


                    if(data.incompletoA == undefined){
                        completosA = 0;
                    }else{
                        completosA = data.incompletoA.length;
                    }

                    if(data.diasAs == undefined){
                        asuetos = 0;
                    }else{
                        asuetos = data.diasAs.length;
                    }
                    //este if es para los dias completos de vacaciones anticipadas
                    //no se quita de aqui porque se hace uso de la programacion estructurada
                    if(a < incompletosA){
                        if(data.diasA[a].fechaA == fecha){
                            $(".btn_anticipada-"+fecha).hide();
                            $("#"+fecha).addClass("panel panel-info");
                                
                            a++;
                        }else{
                            $(".btn_anticipada-"+fecha).show();
                            $("#"+fecha).addClass("panel panel-default");
                        }
                    }else{
                        $(".btn_agregar-"+fecha).show();
                        $(".btn_anticipada-"+fecha).show();
                        $("#"+fecha).addClass("panel panel-default");
                    }

                    //if para los dias completos de la vacaciones reales
                    if(i < incompletos){
                        if(data.dias[i].fecha == fecha){
                            $(".btn_agregar-"+fecha).hide();
                            $(".btn_anticipada-"+fecha).hide();
                            
                            $("#"+fecha).addClass("panel panel-primary");
                            i++;
                        }else{
                            $(".btn_agregar-"+fecha).show();
                            $("#"+fecha).addClass("panel panel-default");
                        }
                        
                    }

                    //este if es para los dias incompletos de las vacaciones reales
                    if(j < completos){
                        if(data.incompleto[j].fecha == fecha){
                            
                            $(".btn_agregar-"+fecha).show();
                            $("#"+fecha).addClass("panel panel-success");
                                
                            j++;
                        }
                    }
                    //este if espara los dias incompletos de las vacaciones anticipadas
                    if(k < completosA){
                        if(data.incompletoA[k].fechaA == fecha){
                            
                            $(".btn_anticipada-"+fecha).show();
                            $("#"+fecha).addClass("panel panel-warning");
                                
                            k++;
                        }
                    }

                    if(m < asuetos){
                        if(data.diasAs[m].fechaAs == fecha){
                            //$(".btn_agregar-"+fecha).hide();
                            //$(".btn_anticipada-"+fecha).hide();
                            $(".btn_ver-"+fecha).show();
                            $(".btn_asu-"+fecha).show();
                            $('[name="nom_as-'+fecha+'"]').val(data.diasAs[m].nomAsu);
                            $('[name="desc_as-'+fecha+'"]').val(data.diasAs[m].desAsu);
                            //document.getElementById('impri_'+fecha).innerHTML = data.diasAs[m].nomAsu;
                            
                            $("#"+fecha).addClass("panel panel-danger");
                            m++;
                        }
                    }

            }else{
                $(".btn_anticipada-"+fecha).show();
                $(".btn_agregar-"+fecha).show();
                $("#"+fecha).addClass("panel panel-default");
            }

            }//Fin de while
                //validacionVacacion();

        };//fin load
        check();
        $('#completo').on('click', function() {
            check();
        });

        function check(){
            if( $('#completo').is(':checked') ) {
                $('#horas').val("");
                $('#minutos').val("");
                $("#horas").prop('disabled', true);
                $("#minutos").prop('disabled', true);
            }else{
                $("#horas").prop('disabled', false);
                $("#minutos").prop('disabled', false);
            }
        };//fin check

    //metodo para ingresar los dias de vacacion
    $('#btn_save').on('click',function(){
        var code = $('#id_empleado').val();
        var fecha = $('#fecha_vacacion').val();
        var horas = $('#horas').val();
        var minutos = $('#minutos').val();
        var user = $('#user').val();
        $("#btn_save").prop('disabled', true);

        var horasusados = $('#hora_vacacion').val();
        var minusados = $('#minutos_vacacion').val();

        console.log(horasusados);
        console.log(minusados);
        

        if( $('#completo').is(':checked') ) {
            var dia = 1;
        }else{
            var dia = 0;
        }

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/ingresoDiasVa')?>",
                dataType : "JSON",
                data : {fecha:fecha,horas:horas,minutos:minutos,dia:dia,code:code,user:user,horasusados:horasusados,minusados:minusados},
                success: function(data){
                    console.log(data);
                if ((data.validacion.length==0)) {

                    document.getElementById('validacion').innerHTML = '';
                    document.getElementById('conteo').innerHTML = '';
                    document.getElementById('conteo').innerHTML = data.enunciado;

                    $('[name="fecha_vacacion"]').val("");
                    $('[name="horas"]').val("");
                    $('[name="minutos"]').val("");
                    $("#completo").prop("checked", false);
                    $("#horas").prop('disabled', false);
                    $("#minutos").prop('disabled', false);
                    $("#Modal_agregar").modal('toggle');
                    $("#btn_save").prop('disabled', false);
                    verDias();
                    //location.reload();
                    //this.disabled=false;
                }else{
                document.getElementById('validacion').innerHTML = '';

                    for (i = 0; i <= data.validacion.length-1; i++){

                            document.getElementById('validacion').innerHTML += data.validacion[i];
                    }//Fin For
            }//fin if else
        },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }
        });
        return false;
    });//fin de insercionde dias de vacacion

         //APARTADO PARA LA VACACIONES ANTICIPADAS
         checkAnt();
        $('#completo_anticipada').on('click', function() {
            checkAnt();
        });

        function checkAnt(){
            if( $('#completo_anticipada').is(':checked') ) {
                $('#horas_anticipada').val("");
                $('#minutos_anticipada').val("");
                $("#horas_anticipada").prop('disabled', true);
                $("#minutos_anticipada").prop('disabled', true);
            }else{
                $("#horas_anticipada").prop('disabled', false);
                $("#minutos_anticipada").prop('disabled', false);
            }
        };//fin check

        //metodo para ingresar los dias de vacacion anticipada
        $('#btn_save_ant').on('click',function(){
            var code = $('#id_empleado').val();
            var fecha = $('#fecha_anticipada').val();
            var horas = $('#horas_anticipada').val();
            var minutos = $('#minutos_anticipada').val();
            var user = $('#user').val();

            var horasusados = $('#hora_ant').val();
            var minusados = $('#minutos_ant').val();

            if( $('#completo_anticipada').is(':checked') ) {
                var dia = 1;
            }else{
                var dia = 0;
            }

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Vacaciones/ingresoDiasAnt')?>",
                    dataType : "JSON",
                    data : {fecha:fecha,horas:horas,minutos:minutos,dia:dia,code:code,user:user,horasusados:horasusados,minusados:minusados},
                    success: function(data){
                    if ((data.validacion.length==0)) {
                        document.getElementById('validacion_anticipada').innerHTML = '';
                        document.getElementById('conteo').innerHTML = '';
                        document.getElementById('conteo').innerHTML = data.enunciado;

                        $('[name="fecha_anticipada"]').val("");
                        $('[name="horas_anticipada"]').val("");
                        $('[name="minutos_anticipada"]').val("");
                        $("#completo_anticipada").prop("checked", false);
                        $("#horas_anticipada").prop('disabled', false);
                        $("#minutos_anticipada").prop('disabled', false);
                        $("#Modal_anticipada").modal('toggle');
                        verDias();
                        /*location.reload();
                        this.disabled=false;
                        show_area();*/
                    }else{
                    document.getElementById('validacion_anticipada').innerHTML = '';

                        for (i = 0; i <= data.validacion.length-1; i++){
                                document.getElementById('validacion_anticipada').innerHTML += data.validacion[i];
                        }//Fin For
                }//fin if else
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
                }
            });
            return false;
        });//fin de insercionde dias de vacacion anticipada

        //se obtienen todos los datos necesarios
        $('.item_iniciar').click(function(){
            var fecha_inicio = $('#fecha_inicio').val();
            var code = $('#id_empleado').val();
            var user = $('#user').val();
            $('#Modal_Inicio').modal('show');
            $('[name="fecha_inc"]').val(fecha_inicio);
            $('[name="empleado_inc"]').val(code);
            $('[name="user_inc"]').val(user);
        });//fin metodo llenado

        //metodo para ingresar los dias de vacacion anticipada
        $('#btn_todas_vaca').on('click',function(){
            var code = $('#empleado_inc').val();
            var user = $('#user_inc').val();
            var fecha_inc = $('#fecha_inc').val();
            var dias_inc = $('#dias_inc').val();
            var hora_inc = $('#hora_inc').val();
            var min_inc = $('#min_inc').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/ingresoAllDias')?>",
                dataType : "JSON",
                data : {code:code,user:user,fecha_inc:fecha_inc,dias_inc:dias_inc,hora_inc:hora_inc,min_inc:min_inc},
                success: function(data){
                if(data==null){
                    $('[name="empleado_inc"]').val("");
                    $('[name="user_inc"]').val("");
                    $('[name="fecha_inc"]').val("");

                    location.reload();
                    this.disabled=false;
                    show_area();
                }
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
                }
            });
            return false;
        });//fin de insercionde dias de vacacion anticipada
        
    });//Fin jQuery
    
    //funcion que llama y obtiene la feha del dia que se esta seleccionando
    function myFunction(boton) {
        //se vacian los campos 
        $('#horas').val("");
        $('#minutos').val("");
        //se habilitan
        $("#horas").prop('disabled', false);
        $("#minutos").prop('disabled', false);
        //se desmarca el checbox
        $("#completo").prop("checked", false);
        //se limpia el div del mensaje de la validacion
        document.getElementById('validacion').innerHTML = '';
        //se obtiene la fecha que se desea ingresar
        var fecha = boton.dataset.codigo;

        var code = $('#id_empleado').val();
        console.log(fecha);

        //se llama el modal y se coloca la fecha en un input
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Vacaciones/revisarDia')?>",
            dataType : "JSON",
            data : {code:code,fecha:fecha},
            success: function(data){
                console.log(data);
                document.getElementById('cantidad').innerHTML = data.enunciado;
                $('#Modal_agregar').modal('show');
                $('[name="fecha_vacacion"]').val(fecha);
                $('[name="hora_vacacion"]').val(data.horas);
                $('[name="minutos_vacacion"]').val(data.minutos);

            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
        
    }//fin myFunction

    //funcion para saber el tiempo que ha usado el empleado en un dia especifico
    function anticipada(boton) {
        //se vacian los campos 
        $('#horas_anticipada').val("");
        $('#minutos_anticipada').val("");
        //se habilitan
        $("#minutos_anticipada").prop('disabled', false);
        $("#minutos_anticipada").prop('disabled', false);
        //se desmarca el checbox
        $("#completo_anticipada").prop("checked", false);
        //se limpia el div del mensaje de la validacion
        document.getElementById('validacion_anticipada').innerHTML = '';
        //se obtiene la fecha que se desea ingresar
        var fecha = boton.dataset.codigo;

        var code = $('#id_empleado').val();

        //se llama el modal y se coloca la fecha en un input
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Vacaciones/revisarDiaAnt')?>",
            dataType : "JSON",
            data : {code:code,fecha:fecha},
            success: function(data){
                console.log(data);
                document.getElementById('cantidad_anticipada').innerHTML = data.enunciado;
                $('#Modal_anticipada').modal('show');
                $('[name="fecha_anticipada"]').val(fecha);
                $('[name="hora_ant"]').val(data.horas);
                $('[name="minutos_ant"]').val(data.minutos);

            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
        
    }//fin anticipada

    function asuetos(boton){
        var fecha = boton.dataset.codigo;
        var fechaI = new Date(boton.dataset.codigo);
        var fechaF = new Date(boton.dataset.codigo);
        fechaI.setDate(fechaI.getDate() + 1);

        var dia=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        var meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        var ultimoDia = new Date(fechaF.getFullYear(), fechaF.getMonth() + 1, 0);

        var nombre = $("#nom_as-"+fecha).val();
        var descripcion = $("#desc_as-"+fecha).val();

        document.getElementById('nombre_asueto').innerHTML = dia[fechaI.getDay()] +' '+ fechaI.getDate()+', '+meses[ultimoDia.getMonth()]+' de '+ultimoDia.getFullYear();

        if(nombre.length > 0 && descripcion.length > 0){
            document.getElementById('descripcion_asueto').innerHTML = nombre +': '+descripcion;
        }else{
            document.getElementById('descripcion_asueto').innerHTML = 'Empieza la semana';
        }
        $('#Modal_Asuetos').modal('show');

    }//fin asuetos
</script>
</body>


</html>