<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
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

                </div>

                <table class="table table-bordered" border="1" id="mydata">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <center><div id="fecha"></div></center>
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

<!--MODAL DELETE-->
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
                    <strong>¿Seleccione la accion que desea realizar?</strong><br><br>
                    <div id="validacion" style="color:red"></div>
                    <div class="pretty p-switch p-fill">
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
                    
                </div>
                <div class="modal-footer">
                    <input type="text" name="fecha_vacacion" id="fecha_vacacion" class="form-control" readonly>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_save" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
</form>
<!--END MODAL DELETE-->



<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){

        load();
        $('#mes_vacacion').change(function(){
            load();
        });
        
        function load(){
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

            //arreglo que tiene los dias de la semana
            var dia=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
            //se da formato que se necesita para recorrer los dias
            var fechaInicio = new Date(diaUno);
            var fechaFin    = new Date(diaUltimo);
            //contador que servira para dar el salto en la tabla
            var contador = 1;
            //es una variable para dar los espacios si un mes no empieza ldomingo
            var inicio = 1;
            var i = 0;
            //$('#mydata').dataTable().fnDestroy();
            //se limpia la tabla 
            $('.tabla1').empty();

           while(fechaFin.getTime() >= fechaInicio.getTime()){
                //se obtiene la fecha de los dias 
                fechaInicio.setDate(fechaInicio.getDate() + 1);
                //se inicia con las filas de las tablas

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
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+
                                    dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                //este es lunes
                }else if(fechaInicio.getDay() == 1){
                   
                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" onclick="myFunction()" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                //este es martes
                }else if(fechaInicio.getDay() == 2){

                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" onclick="myFunction()" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                }else if(fechaInicio.getDay() == 3){

                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" onclick="myFunction()" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                }else if(fechaInicio.getDay() == 4){

                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" onclick="myFunction()" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                }else if(fechaInicio.getDay() == 5){

                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" onclick="myFunction()" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'
                    );
                    contador = 0;

                }else if(fechaInicio.getDay() == 6){
                   
                    $(".tabla1").append(
                        '<td>'+
                            '<div class="checkbox">'+
                                '<label>'+
                                    '<b>'+
                                    dia[fechaInicio.getDay()] +' '+fechaInicio.getDate()+'</b><br>'+
                                    '<a class="btn btn-success btn-sm btn_agregar '+fecha+'" onclick="myFunction(this)" data-codigo="'+fechaInicio.getFullYear() + '-' + (fechaInicio.getMonth() + 1) + '-' + fechaInicio.getDate()+'" id="agregar" style="display: none;">Agregar</a>'+
                                '</label>'+
                            '</div>'+
                        '</td>'+
                        '</tr>'
                    );
                    contador = 1;
                }

                $(".btn_agregar").show();
                

            }//Fin de while
                //validacionVacacion();


        };//fin load

        $( '#completo' ).on( 'click', function() {
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
        if( $('#completo').is(':checked') ) {
            var dia = 1;
        }else{
            var dia = 0;
        }

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/ingresoDias')?>",
                dataType : "JSON",
                data : {fecha:fecha,horas:horas,minutos:minutos,dia:dia,code:code},
                success: function(data){
                if ((data==null)) {
                    document.getElementById('validacion').innerHTML = '';

                    $('[name="fecha_vacacion"]').val("");
                    $('[name="horas"]').val("");
                    $('[name="minutos"]').val("");
                    $("#completo").prop("checked", false);
                    $("#horas").prop('disabled', false);
                    $("#minutos").prop('disabled', false);

                    location.reload();
                    this.disabled=false;
                    show_area();
                }else{
                document.getElementById('validacion').innerHTML = '';

                    for (i = 0; i <= data.length-1; i++){

                            document.getElementById('validacion').innerHTML += data[i];
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

    
        
    });//Fin jQuery
    
    //funcion que llama y obtiene la feha del dia que se esta seleccionando
    function myFunction(boton) {
        console.log(boton.dataset.codigo);
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
        var datos = document.getElementById("agregar");
        var fecha = datos.dataset.codigo;
        //se llama el modal y se coloca la fecha en un input
        $('#Modal_agregar').modal('show');
        $('[name="fecha_vacacion"]').val(fecha);
    }

</script>
</body>


</html>