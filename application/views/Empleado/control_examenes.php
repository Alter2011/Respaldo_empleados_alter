
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<div class="col-sm-10">
    <div class="well text-center blue text-white">
        <h1>CONTROL EXÁMENES DE EMPLEADOS</h1>
    </div>

    <div class="panel-group col-sm-12">
        <div class="panel-body">
           <ul class="nav nav-tabs">
               <li><a data-toggle="tab" href="#menu5" id="pag3">Pensum </a></li>
               <li><a data-toggle="tab" href="#menu3" id="pag3">Asignar modulos </a></li>
                <li class="active"><a data-toggle="tab" href="#home" id="pag1">Examenes</a></li>
                <!-- <li><a data-toggle="tab" href="#menu1" id="pag2">Competencias </a></li> -->
                <li><a data-toggle="tab" href="#menu2" id="pag3">Preguntas </a></li>
                <li><a data-toggle="tab" href="#menu4" id="pag3">Resultados </a></li>


            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active"><br>
                    <h2>Exámenes</h2>
                    <button id="insertar" data-toggle="modal" data-target="#Modal_examen" class="btn btn-success">Insertar</button>
                    <br>
                    <br>
                    <table id="tabla_examenes" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                            <th style="text-align: center">Examen</th>
                            <th style="text-align: center">Fecha inicio</th>
                            <th style="text-align: center">Fecha fin</th>
                            <th style="text-align: center">Fecha creación</th>
                            <th style="text-align: center">Usuario creador</th>
                            <th style="text-align: center">Acciones</th>

                        </tr>
                        </thead>
                        <tbody id="examenes">
                        </tbody>
                    </table>
                </div>
                <div id="menu1" class="tab-pane fade"><br>
                    <h2>Competencias</h2>
                    <button id="insertar" onclick="ver_insertar_competencias()" data-toggle="modal" data-target="#Modal_competencia" class="btn btn-success">Insertar</button>
                    <br>
                    <br>
                    <table id="tabla_competencias" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                            <th style="text-align: center">Competencia</th>
                            <th style="text-align: center">Examen</th>
                            <th style="text-align: center">Fecha creación</th>
                            <th style="text-align: center">Usuario creador</th>
                            <th style="text-align: center">Acciones</th>

                        </tr>
                        </thead>
                        <tbody id="competencias">
                        </tbody>
                    </table>
                </div>
                <div id="menu2" class="tab-pane fade"><br>
                    <h2>Preguntas</h2>
                    <button id="insertar" onclick="llenar_select_examenes()" data-toggle="modal" data-target="#Modal_preguntas" class="btn btn-success">Insertar</button>
                    <br>
                    <br>
                    <table id="tabla_preguntas" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                            <th style="text-align: center">Pregunta</th>
                            
                            <th style="text-align: center">Examen</th>
                            <th style="text-align: center">Fecha creación</th>
                            <th style="text-align: center">Usuario creador</th>
                            <th style="text-align: center">Acciones</th>


                        </tr>
                        </thead>
                        <tbody id="preguntas">
                        </tbody>
                    </table>
                </div>
                <div id="menu4" class="tab-pane fade"><br>
                    <h2>Notas de empleados</h2>
                   
                    <br>
                    <br>
                    <table id="tabla_notas" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                            <th style="text-align: center">Empleado</th>
                            <th style="text-align: center">Examen</th>
                            <th style="text-align: center">Nota</th>


                        </tr>
                        </thead>
                        <tbody id="notas">
                        </tbody>
                    </table>
                </div>

                <div id="menu3" class="tab-pane fade"><br>
                    <h2>Asignar modulos a empleados</h2>
                    <div class="form-group col-md-12">

                    <div class="col-md-3">
                     <select class='form-control' name="resultados_id_agencia" id="resultados_id_agencia">
                        <option value="">Todas</option>
                        <?php foreach ($agencias as $agencia) { ?>
                            <option value="<?php echo $agencia->id_agencia ?>"><?php echo $agencia->agencia ?></option>
                        <?php } ?>
                     </select>               
                    </div>
                    <div class="col-md-4">
                        <button type="button" title="Agregar modulo a empleado"  class="btn btn-primary eliminar_examen"><span class="glyphicon glyphicon-search"></span></button>   

                        <button type="button" title="Agregar modulo a empleado"  class="btn btn-success eliminar_examen" onclick="agregar_modulo()"><span class="glyphicon glyphicon-plus"></span></button>                                     
                    </div>
                    <div class="col-md-8">
                
                    </div>
                    </div>
                    <table id="tabla_resultados" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                           
                            <th style="text-align: center">Empleado</th>
                            <th style="text-align: center">Modulo</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Nota</th>
                            <th style="text-align: center">Acciones</th>
                            
                        </tr>
                        </thead>
                        <tbody id="resultados">
                        </tbody>
                    </table>
                </div>

                <div id="menu5" class="tab-pane fade">
                    <h2>Asignar historietas a roles</h2>
                    <button id="insertar_historietas" data-toggle="modal" data-target="#Modal_historietas" class="btn btn-success">Insertar</button>
                    <br><br>
                    <table id="tabla_pensum" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                        <tr>
                            <th style="text-align: center">Pensum para cargo</th>
                            <th style="text-align: center">Fecha creación</th>
                            <th style="text-align: center">Usuario creador</th>
                            <th style="text-align: center">Acciones</th>

                        </tr>
                        </thead>
                        <tbody id="data_pensum">
                        </tbody>
                    </table>
                </div>
           </div>
        </div>
    </div>
</div>

<!--Modelo insertar examen-->
<div class="modal fade" id="Modal_examen" tabindex="-1" role="dialog" aria-labelledby="Modal_examenes" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_examenes">Insertar examen</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="nombre_examen">Nombre:</label>
                    <input type="text" name="nombre_examen" id="nombre_examen" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_inicio">Fecha inicio examen:</label>
                    <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_fin">Fecha fin examen:</label>
                    <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_fin">Materia:</label>
                    <select name="materias" class='form-control' id="materias" onchange="get_modulos()">
                     
                        <?php 
                        foreach ($modulos as $modulo) {
                            echo '<option value="'.$modulo->id_historieta.'">'.$modulo->historieta.'</option>';
                        }
                        ?>
                    </select>
                 </div>
                 <div class="form-group col-md-3">
                    <label for="fecha_fin">Modulo:</label>
                    <select name="modulo" class='form-control' id="modulo">
                        <option value="0">Seleccione el modulo</option>
                    </select>
                 </div>
            </div>


           
               
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insertar_examen()">Insertar</button>
                </div>
           
        </div>
    </div>
</div>

<!--Modelo insertar competencias-->
<div class="modal fade" id="Modal_competencia" tabindex="-1" role="dialog" aria-labelledby="Modal_competencias" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_competencias">Insertar Competencias</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="form-group col-md-10">

                        <label for="examenes">Exámenes:</label>
                        <select name="examenes_empleados" class='form-control' id="examenes_empleados">
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-primary" onclick="agregar_competencia()">Añadir competencia</button>
                    </div>
                    <input type="hidden" id="contador_competencias" value="1">
                    <div id="contenedor-competencias" >
                        <div class="form-group col-md-3">
                            <label for="nombre_competencia">Competencia 1: </label>
                            <input type="text" name="nombre_competencia[]"  class="form-control" >
                        </div>
                    </div>

                </div>
            </div>
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insertar_competencia()">Insertar</button>
                </div>
           
        </div>
    </div>
</div>
<!-- Modelo insertar pregunta-->
<div class="modal fade" id="Modal_preguntas" tabindex="-1" role="dialog" aria-labelledby="Modal_preguntas" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_preguntas">Insertar Preguntas</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="form-group col-md-10">

                        <label for="examenes">Exámenes:</label>
                        <select name="examenes_preguntas_empleados" onchange="llenar_select_competencias()" class='form-control' id="examenes_preguntas_empleados">
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="form-group col-md-10">

                       
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-primary" onclick="agregar_pregunta()">Añadir pregunta</button>
                    </div>
                    <input type="hidden" id="contador_preguntas" value="1">
                    <div id="contenedor-preguntas" >
                        <div class="form-group col-md-12">
                            <label for="nombre_pregunta">Pregunta 1: </label>
                            <input type="text" name="nombre_pregunta[]"  class="form-control" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nombre_pregunta">Respuesta 1: </label>
                            <input type="text" name="respuesta_pregunta[]"  class="form-control" >
                            <label for="respuesta_correcta">Marcar como respuesta correcta </label>
                            <input type="radio" name="respuesta_correcta" id="respuesta4" value="4">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nombre_pregunta">Respuesta 2: </label>
                            <input type="text" name="respuesta_pregunta[]"  class="form-control" >
                            <label for="respuesta_correcta">Marcar como respuesta correcta </label>
                            <input type="radio" name="respuesta_correcta" id="respuesta4" value="4">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nombre_pregunta">Respuesta 3: </label>
                            <input type="text" name="respuesta_pregunta[]"  class="form-control" >
                            <label for="respuesta_correcta">Marcar como respuesta correcta </label>
                            <input type="radio" name="respuesta_correcta" id="respuesta4" value="4">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nombre_pregunta">Respuesta 4: </label>
                            <input type="text" name="respuesta_pregunta[]"  class="form-control" >
                            <label for="respuesta_correcta">Marcar como respuesta correcta </label>
                            <input type="radio" name="respuesta_correcta" id="respuesta4" value="4">
                        </div>
                       
                    </div>

                </div>
            </div>
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insertar_preguntas()">Insertar</button>
                </div>
           
        </div>
    </div>
</div>

<!-- Ver examen-->
<div class="modal fade" id="Modal_ver_examen" tabindex="-1" role="dialog" aria-labelledby="Modal_ver_examen" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_ver_examen">Vista del examen</h3>
            </div>
            <div class="form-row">
            
                <div class="form-group col-md-12">
                    <br>
                    <div class="form-group col-md-3">
                    </div>
                    <div class="form-group col-md-6">
                        <h2 id="titulo_examen">Titulo examen</h2>
                        <h4 id="nota_promedio"></h4>

                    </div>
                    <div class="form-group col-md-3">

                    </div>
                </div>
                <div class="form-group col-md-12" id="contenedor_competencias">

                </div>


            </div>
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
           
        </div>
    </div>
</div>

<!--Modelo editar examen-->
<div class="modal fade" id="Modal_editar_examen" tabindex="-1" role="dialog" aria-labelledby="Modal_editar_examenes" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_editar_examenes">Editar examen</h3>
            </div>
            <div class="form-row">
                <input type="hidden" name="editar_id_examen" id="editar_id_examen">
                <div class="form-group col-md-3">
                    <label for="nombre_examen">Nombre:</label>
                    <input type="text" name="editar_nombre_examen" id="editar_nombre_examen" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_inicio">Fecha inicio examen:</label>
                    <input type="datetime-local" name="editar_fecha_inicio" id="editar_fecha_inicio" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_fin">Fecha fin examen:</label>
                    <input type="datetime-local" name="editar_fecha_fin" id="editar_fecha_fin" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                 </div>
            </div>


           
               
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editar_examen()">Editar</button>
                </div>
           
        </div>
    </div>
</div>

<!--Modelo insertar historietas a roles-->
<div class="modal fade" id="Modal_historietas" tabindex="-1" role="dialog" aria-labelledby="Modal_examenes" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="Modal_historietash">Insertar historietas</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label >Rol:</label>
                </div>
                <div class="form-group col-md-3">
                    <select name="roles" class='form-control' id="roles">
                        <?php 
                        foreach ($roles as $roles) {
                            echo '<option value="'.$roles->id_rol.'">'.$roles->rol.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <br><br><br>
                <div class="form-row" id="container_filas">
                    <div class="form-group col-md-1" style="width: 90px;">
                        <label >Historietas:</label>
                    </div>
                    <div class="form-group col-md-3" style="width: 250px;">
                        <select name="historietas[]" class="form-control">
                            <?php 
                            foreach ($modulos as $modulos) {
                                echo '<option value="'.$modulos->id_historieta.'">'.$modulos->historieta.'</option>';
                                
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2" style="width: 200px;">
                        <select name="nivel[]" class="form-control" >
                            <option disabled selected> Seleccione un nivel </option>
                            <option value="1"> basico </option>
                            <option value="2"> intermedio </option>
                            <option value="3"> avanzado </option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" style="width: 200px;">
                        <button type="button" class="btn btn-primary" onclick="agregarFila()">+</button>
                    </div>
                    <div class="form-group col-md-3" style="width: 150px; height: 40px">
                        <input type="hidden" name="modulo[]" placeholder="Nº Modulo" class="form-control">
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insertar_historietas()">Insertar</button>
                </div>
           
        </div>
    </div>
</div>
<!--Modelo vista de historietas asociadas al pensum-->
<div class="modal fade" id="vista_historietas" tabindex="-1" role="dialog" aria-labelledby="vista_pensum" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="view_historiestas">Historietas inscriptas en pensum para cargo: <span id="cargo"></span></h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12" id="contenedor_historietas">
                    <table id="tabla_data_his" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th style="text-align: center">Historieta</th>
                                <th style="text-align: center">Nivel</th>
                                <!-- <th style="text-align: center">Modulo</th> -->
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="data_historieta"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-end"> <!-- Agrega la clase "justify-content-end" para alinear los botones a la derecha -->
                <button type="button" data-rol="" id="eliminar_todo" class="btn btn-danger">Eliminar Todo</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



 <style>    
table{
    table-layout: fixed;
    width: 250px;
}

th, td {
    border: 1px solid blue;
    width: 100px;
    word-wrap: break-word;
}
</style>
<script>
function agregar_modulo(){
    roles = <?php echo json_encode($roles_modulos); ?>

    modulos = <?php echo json_encode($modulos2); ?>

    agencias = <?php echo json_encode($agencias); ?>

    var option_roles = ''
    $.each(roles, function(index, value){
        option_roles += '<option value="'+value.id_rol+'">'+value.rol+'</option>';
    });

    // var option = '';
    // $.each(modulos, function(index, value) {
    //   option += '<option value="' + value.id_historieta + '">' + value.historieta + '</option>';
    // });
    var option_agencias = '';
    $.each(agencias, function(index, value) {
        option_agencias += '<option value="' + value.id_agencia + '">' + value.agencia + '</option>';
    });

    Swal.fire({
  title: 'Ingresar un modulo a un empleado',

  html:
    '<select class="form-control" id="rol" onchange="select_roles()">'+
    '<option selected disabled>Seleccionar un cargo</option>'+
    option_roles+
    '</select><br>'+
    '<select class="form-control" id="select1" >' +
    '<option>Selecciona una historieta</option>'+
    '</select>' +
    '<br>'+
    '<select id="select2" class="form-control" onchange="select_empleados()">' +
    '<option>Selecciona una agencia</option>'+
    option_agencias+
    '</select>'+
    '<br>'+
    '<select id="empleados_list" class="form-control">'+
    '<option>Selecciona un empleado</option>'+
    '</select>',
  showCancelButton: true,
  confirmButtonText: 'Enviar',
  cancelButtonText: 'Cancelar',
  preConfirm: () => {
    const input1 = Swal.getPopup().querySelector('#select1').value;
    const input2 = Swal.getPopup().querySelector('#select2').value;
    const input3 = Swal.getPopup().querySelector('#empleados_list').value;
    const input4 = Swal.getPopup().querySelector('#rol').value;
    console.log(input3)
    if (!input1 || !input2 || !input3 || input3== 'Selecciona un empleado' || input3== 0) {
      Swal.showValidationMessage('Por favor, completa ambos campos');
    }
    
    return { input1: input1, input2: input2, input3: input3 };
  }
}).then((result) => {
  if (result.dismiss === Swal.DismissReason.cancel) {
    Swal.fire(
      'Cancelado',
      'La operación ha sido cancelada',
      'error'
    );
  } else if (result.value) {
    $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Empleado/insertar_modulo_empleado')?>",
        dataType : "JSON",
        data : { id_empleado:result.value.input3,id_historieta:result.value.input1},
        success: function(data){
            if(data!=null){
                Swal.fire(
                    'Insercion correcta',
                    '',
                    'success'
                )
                listar_resultados();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error de inserción',
                    text: 'Por favor revise que haya ingresado todos los datos correctamente',
                })
                //alert('Por favor revise que haya ingresado todos los datos');
            }
        },
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
        
        }
    });

  }
});
}
function select_roles(){
    id_rol= $('#rol').val();
    $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Empleado/get_modulo_rol')?>",
        dataType : "JSON",
        data : { id_rol:id_rol},
        success: function(data){
            $('#select1').empty();
            $('#select1').append('<option selected disabled value="0">Seleccione la historieta</option>');
            for (var i = 0 ; i <data.length; i++) {
                $('#select1').append('<option value="'+data[i].id_historieta+'">'+data[i].historieta+'</option>');
            }
        },
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
        
        }
    });
}

function select_empleados(){
    id_agencia = $('#select2').val();
    $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Empleado/get_empleados_agencia')?>",
        dataType : "JSON",
        data : { id_agencia:id_agencia},
        success: function(data){
            console.log(data)
            $('#empleados_list').empty();
            $('#empleados_list').append('<option value="0">Seleccione el empleado</option>');
            for (var i = 0 ; i <data.length; i++) {
                $('#empleados_list').append('<option value="'+data[i].id_empleado+'">'+data[i].nombre+" "+data[i].apellido+'</option>');
            }
        },
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
        
        }
    });
}
function get_modulos(){
    $("#materias").val();
    $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Empleado/get_modulos')?>",
        dataType : "JSON",
        data : { id_historieta:$("#materias").val()},
        success: function(data){
            console.log(data)
            $('#modulo').empty();
            $('#modulo').append('<option value="0">Seleccione el modulo</option>');
            for (var i = 0 ; i <data.length; i++) {
                $('#modulo').append('<option value="'+data[i].id_capitulos+'">'+data[i].capitulo+'</option>');
            }
        },
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
        
        }
    });
}

$(document).ready(function() {
  listar_examenes();
  listar_pensum();
  listar_competencias();  
  listar_preguntas();
  listar_resultados();
  listar_notas();
} );
    //NO10072023
    function insertar_examen(){
            nombre_examen = $('#nombre_examen').val();
            fecha_inicio = $('#fecha_inicio').val();
            fecha_fin = $('#fecha_fin').val();
            modulo = $("#modulo").val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/insertar_examen')?>",
                dataType : "JSON",
                data : { nombre_examen:nombre_examen,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin, modulo:modulo},
                success: function(data){
                    if(data!=null){
                       // alert('Insercion correcta');
                        Swal.fire(
                            'Insercion correcta',
                            '',
                            'success'
                        )
                        listar_examenes();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de inserción',
                            text: 'Por favor revise que haya ingresado todos los datos correctamente',
                        })
                        //alert('Por favor revise que haya ingresado todos los datos');
                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
    function listar_examenes(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_examenes')?>",
                dataType : "JSON",
                success: function(data){
                    $('#tabla_examenes').DataTable().destroy();
                    $('#tabla_examenes #examenes').empty();
                    if (data != null) {
                        for (var i = 0 ; i <data.length; i++) {
                            $('#examenes').append('<tr>'+
                                                    '<td>'+data[i].nombre_examen+'</td>'+
                                                    '<td>'+data[i].fecha_inicio+'</td>'+
                                                    '<td>'+data[i].fecha_fin+'</td>'+
                                                    '<td>'+data[i].fecha_creacion+'</td>'+
                                                    '<td>'+data[i].nombre_empleado+'</td>'+
                                                    '<td>'+
                                                        '<button type="button" title="Vista previa" data-toggle="modal" data-target="#Modal_ver_examen" onclick="ver_examen('+data[i].id_examen+')" class="btn btn-success ver_examen"><span class="glyphicon glyphicon-eye-open"></span></button> '+
                                                        '<button type="button" title="Editar examen" data-toggle="modal" data-target="#Modal_editar_examen" onclick="cargar_editar_examen('+data[i].id_examen+')" class="btn btn-primary editar_examen"><span class="glyphicon glyphicon-pencil"></span></button> '+
                                                        '<button type="button" title="Eliminar examen" onclick="eliminar_examen('+data[i].id_examen+')" class="btn btn-danger eliminar_examen"><span class="glyphicon glyphicon-trash"></span></button> '+                                       
                                                    '</td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_examenes').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 3, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
   function ver_insertar_competencias() {
    $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_examenes')?>",
                dataType : "JSON",
                //data : { estado:1},
                success: function(data){
                    $('#examenes_empleados').empty();
                    if (data.length != 0) {
                        for (var i = 0 ; i <data.length; i++) {
                            //llenar el select de examenes
                            $('#examenes_empleados').append('<option value="'+data[i].id_examen+'">'+data[i].nombre_examen+'</option>');
                        }
                    }else{
                        $('#examenes_empleados').append('<option value="null">No existe ningun examen</option>');

                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
   }
   function agregar_competencia() {
        contador_competencias = parseInt($('#contador_competencias').val(), 10)+1;
        $('#contenedor-competencias').append('<div class="form-group col-md-3">'+
                                        '<label for="nombre_competencia">Competencia '+contador_competencias+': </label>'+
                                        '<input type="text" name="nombre_competencia[]" class="form-control">'+
                                        '<button type="button" title="Eliminar competencia" class="btn btn-default remover_competencia"><span class="glyphicon glyphicon-trash"></span></button>'+
                                    '</div>');
        $('#contador_competencias').val(contador_competencias);
    }
        $('#contenedor-competencias').on("click",".remover_competencia",function(e) {
                e.preventDefault();
                contador_competencias = parseInt($('#contador_competencias').val(), 10)-1;
                $('#contador_competencias').val(contador_competencias);
                $(this).parent('div').remove();
        });
    function insertar_competencia() {
        competencias = document.getElementsByName('nombre_competencia[]');
        valor_competencia=[];
        for (i = 0; i < competencias.length; i++) {
            valor_competencia[i] = competencias[i].value;
        }
        id_examen = $('#examenes_empleados').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/insertar_competencias')?>",
                dataType : "JSON",
                data : { valor_competencia:valor_competencia,id_examen:id_examen},
                success: function(data){
                    if(data!=null){
                        //alert('Insercion correcta');
                        Swal.fire(
                            'Insercion correcta',
                            '',
                            'success'
                        )
                        listar_competencias();
                  
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de inserción',
                            text: 'Por favor revise que haya ingresado todos los datos',
                        })
                       // alert('Por favor revise que haya ingresado todos los datos');
                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
    function listar_competencias(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_competencias_examen')?>",
                dataType : "JSON",
                success: function(data){
                    $('#tabla_competencias').DataTable().destroy();
                    $('#tabla_competencias #competencias').empty();
                    if (data != null) {
                        for (var i = 0 ; i <data.length; i++) {
                            $('#competencias').append('<tr>'+
                                                    '<td>'+data[i].nombre_competencia+'</td>'+
                                                    '<td>'+data[i].nombre_examen+'</td>'+
                                                    '<td>'+data[i].fecha_creacion+'</td>'+
                                                    '<td>'+data[i].nombre_empleado+'</td>'+
                                                    '<td><button type="button" title="Eliminar competencia" onclick="eliminar_competencia('+data[i].id_competencia+')" class="btn btn-danger eliminar_competencia"><span class="glyphicon glyphicon-trash"></span></button></td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_competencias').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 2, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
    function listar_notas(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/traer_notas')?>",
                dataType : "JSON",
                success: function(data){
                    console.log(data)
                    $('#tabla_notas').DataTable().destroy();
                    $('#tabla_notas #notas').empty();
                    if (data != null) {
                        for (var i = 0 ; i <data.length; i++) {
                            $('#notas').append('<tr>'+
                                                    '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                                                    '<td>'+data[i].nombre_examen+'</td>'+
                                                    '<td>'+data[i].nota+'</td>'+
                                                    
                                                   

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_notas').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 2, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
    function llenar_select_examenes() {
    $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_examenes')?>",
                dataType : "JSON",
                //data : { estado:1},
                success: function(data){
                    $('#examenes_preguntas_empleados').empty();
                    if (data.length != 0) {
                        for (var i = 0 ; i <data.length; i++) {
                            //llenar el select de examenes
                            $('#examenes_preguntas_empleados').append('<option value="'+data[i].id_examen+'">'+data[i].nombre_examen+'</option>');
                        }
                        llenar_select_competencias();
                    }else{
                        $('#examenes_preguntas_empleados').append('<option value="null">No existe ningun examen</option>');

                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
   }
   function llenar_select_competencias() {
    id_examen = $('#examenes_preguntas_empleados').val();
    $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_competencias_examen')?>",
                dataType : "JSON",
                data : { id_examen:id_examen},
                success: function(data){
                    $('#competencias_preguntas_empleados').empty();
                    if (data.length != 0) {
                        for (var i = 0 ; i <data.length; i++) {
                            //llenar el select de examenes
                            $('#competencias_preguntas_empleados').append('<option value="'+data[i].id_competencia+'">'+data[i].nombre_competencia+'</option>');
                        }
                    }else{
                        $('#competencias_preguntas_empleados').append('<option value="null">No existe ninguna competencia</option>');

                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
   }
   function agregar_pregunta() {
        contador_preguntas = parseInt($('#contador_preguntas').val(), 10)+1;
        $('#contenedor-preguntas').append('<div class="form-group col-md-12">'+
                                        '<label for="nombre_pregunta">Pregunta '+contador_preguntas+': </label>'+
                                        '<input type="text" name="nombre_pregunta[]" class="form-control"><div class="form-group col-md-4"><label for="nombre_pregunta">Respuesta 1: </label><input type="text" name="respuesta_pregunta[]"  class="form-control"> <label for="respuesta_correcta">Marcar como respuesta correcta </label>   <input type="radio" name="respuesta_correcta'+contador_preguntas+'" id="respuesta4" value="4">  </div>   <div class="form-group col-md-4"><label for="nombre_pregunta">Respuesta 2: </label><input type="text" name="respuesta_pregunta[]"  class="form-control">   <label for="respuesta_correcta">Marcar como respuesta correcta </label> <input type="radio" name="respuesta_correcta'+contador_preguntas+'" id="respuesta4" value="4">  </div>  <div class="form-group col-md-4"><label for="nombre_pregunta">Respuesta 3: </label><input type="text" name="respuesta_pregunta[]"  class="form-control">   <label for="respuesta_correcta">Marcar como respuesta correcta </label> <input type="radio" name="respuesta_correcta'+contador_preguntas+'" id="respuesta4" value="4">  </div><div class="form-group col-md-4"><label for="nombre_pregunta">Respuesta 4: </label><input type="text" name="respuesta_pregunta[]"  class="form-control">   <label for="respuesta_correcta">Marcar como respuesta correcta </label><input type="radio" name="respuesta_correcta'+contador_preguntas+'" id="respuesta4" value="4"> </div><button type="button" title="Remover pregunta" style="margin-top:25px" class="btn btn-default remover_campo"><span class="glyphicon glyphicon-trash"></span></button></div>');
        $('#contador_preguntas').val(contador_preguntas);
    }
        $('#contenedor-preguntas').on("click",".remover_campo",function(e) {
                e.preventDefault();
                contador_preguntas = parseInt($('#contador_preguntas').val(), 10)-1;
                $('#contador_preguntas').val(contador_preguntas);
                $(this).parent('div').remove();
        });

    function insertar_preguntas() {
        preguntas = document.getElementsByName('nombre_pregunta[]');
        console.log(preguntas);
        respuestas = document.getElementsByName('respuesta_pregunta[]');

        respuesta_correcta = []
        valor_preguntas=[];
        for (i = 0; i < preguntas.length; i++) {
            valor_preguntas[i] = preguntas[i].value;
            if(i == 0){
                respuesta_correcta[i] = document.getElementsByName('respuesta_correcta');
            }else{
                respuesta_correcta[i] = document.getElementsByName('respuesta_correcta'+(i+1));
            }
           
        }
       
        new_respuesta = []
        validacion_respuestas = []
        respuesta_correcta.forEach(element => {
            validation = false
           for (let i = 0; i < 4; i++) {
            if(element[i].checked){
                validation = true;
            }
            new_respuesta.push(element[i]);
           }
           if(validation === false){
            validacion_respuestas.push(validation);
           }
        });


      
        validacion_global = true;
        validacion_respuestas.forEach(element => {
            if(element === false){
                validacion_global = false;
            }
        });
      
        
        id_examen = $('#examenes_preguntas_empleados').val();
        valor_respuestas = []
        for (i  = 0 ; i < respuestas.length; i++) {
                if (new_respuesta[i].checked) {
                    valor_respuestas[i] = {veracidad: 1, respuesta:respuestas[i].value};
                }else{
                    valor_respuestas[i] = {veracidad: 0, respuesta:respuestas[i].value};
                }               
            
        }
      

        if(validacion_global === true){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/insertar_preguntas')?>",
                dataType : "JSON",
                data : { valor_preguntas:valor_preguntas,id_examen:id_examen, valor_respuestas:valor_respuestas},
                success: function(data){
                    if(data!=null){
                        //alert('Insercion correcta');
                        Swal.fire(
                            'Insercion correcta',
                            '',
                            'success'
                        )
                        listar_preguntas();
                        //limpiar seccion de ingreso de preguntas
                        $('#contenedor-preguntas').empty();
                        $('#contenedor-preguntas').append('<div class="form-group col-md-4">'+
                                        '<label for="nombre_pregunta">Pregunta '+1+': </label>'+
                                        '<input type="text" name="nombre_pregunta[]" class="form-control">'+
                                        '<button type="button" title="Remover pregunta" class="btn btn-default remover_campo"><span class="glyphicon glyphicon-trash"></span></button>'+
                                    '</div>');
                        $('#contador_preguntas').val(1);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de inserción',
                            text: 'Por favor revise que haya ingresado todos los datos',
                        })
                        //alert('Por favor revise que haya ingresado todos los datos');
                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error de inserción',
                text: 'Por favor revise que haya ingresado todos los datos',
            })
        }
    }
    //listar preguntas de una competencia
    function listar_preguntas() {
        $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_preguntas')?>",
                dataType : "JSON",
                //data : { id_competencia:id_competencia},
                success: function(data){
                    $('#tabla_preguntas').DataTable().destroy();
                    $('#tabla_preguntas #preguntas').empty();
                    if (data.length != 0) {
                        for (var i = 0 ; i <data.length; i++) {
                            //llenar el select de examenes
                            $('#preguntas').append('<tr>'+
                                                    '<td>'+data[i].nombre_pregunta+'</td>'+
                                                   
                                                    '<td>'+data[i].nombre_examen+'</td>'+
                                                    '<td>'+data[i].fecha_creacion+'</td>'+
                                                    '<td>'+data[i].nombre_empleado+'</td>'+
                                                    '<td><button type="button" title="Eliminar pregunta" onclick="eliminar_pregunta('+data[i].id_pregunta+')" class="btn btn-danger eliminar_pregunta"><span class="glyphicon glyphicon-trash"></span></button></td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_preguntas').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 3, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    };
                //eliminar pregunta
                function eliminar_pregunta(id_pregunta) {
                    Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Este proceso no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, eliminar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //luego de verificar eliminar pregunta
                            $.ajax({
                                type : "POST",
                                url  : "<?php echo site_url('Empleado/eliminar_pregunta')?>",
                                dataType : "JSON",
                                data : { id_pregunta:id_pregunta},
                                success: function(data){
                            
                            //alert('Eliminacion correcta');
                            Swal.fire(
                            'Eliminado!',
                            'Eliminacion correcta.',
                            'success'
                            )
                            listar_preguntas();
                            },
                                error: function(data){
                                    var a =JSON.stringify(data['responseText']);
                                    alert(a);
                                
                                }
                            });

                        }
                    })
            };
                //eliminar competencia
                function eliminar_competencia(id_competencia) {
                    Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Este proceso no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, eliminar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //luego de verificar eliminar competencia
                            $.ajax({
                                type : "POST",
                                url  : "<?php echo site_url('Empleado/eliminar_competencia')?>",
                                dataType : "JSON",
                                data : { id_competencia:id_competencia},
                                success: function(data){
                                    //alert('Eliminacion correcta');
                                    if(data){
                                        Swal.fire(
                                        'Eliminado!',
                                        'Eliminacion correcta.',
                                        'success'
                                        )
                                        listar_competencias();
                                     }else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error de eliminacion',
                                            text: 'Esa competencia posee preguntas',
                                        })
                                     }
                                },
                                error: function(data){
                                    var a =JSON.stringify(data['responseText']);
                                    alert(a);
                                }
                            });
                        }
                    })
            };
                //eliminar examen
                function eliminar_examen(id_examen) {
                    Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Este proceso no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, eliminar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //luego de verificar eliminar examen
                            $.ajax({
                                type : "POST",
                                url  : "<?php echo site_url('Empleado/eliminar_examen')?>",
                                dataType : "JSON",
                                data : { id_examen:id_examen},
                                success: function(data){
                                    //alert('Eliminacion correcta');
                                    if(data){
                                        Swal.fire(
                                        'Eliminado!',
                                        'Eliminacion correcta.',
                                        'success'
                                        )
                                        listar_examenes();
                                     }else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error de eliminacion',
                                            text: 'Este examen posee competencias',
                                        })
                                     }
                                },
                                error: function(data){
                                    var a =JSON.stringify(data['responseText']);
                                    alert(a);
                                }
                            });
                        }
                    })
            };
            function ver_examen(id_examen) {
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Empleado/ver_examen')?>",
                    dataType : "JSON",
                    data : { id_examen:id_examen},
                    success: function(data){
                        console.log(data);
                        $('#contenedor_competencias').empty();
                        $('#titulo_examen').text(data.examen[0].nombre_examen);
                        contenido_examen='';
                        contenido_examen+='<div class="col-md-12">';


                       

                            contenido_examen+='</div>';
                                //competencias
                                //console.log(data.competencias[i]);

                                for (j = 0; j < data.preguntas.length; j++) {
                                    contenido_examen+='<div class="col-md-12">';
                                        contenido_examen+='<table class="table table-bordered" >';
                                            contenido_examen+='<tbody>';
                                                contenido_examen+='<tr>';
                                                    contenido_examen+='<td><p><strong>'+data.preguntas[j].nombre_pregunta+'</strong></p></td>';
                                                   for (let i = 0; i < 4; i++) {
                                                    if(data.respuestas[j][i].veracidad == 1){
                                                        contenido_examen+='<td> <label for="">'+data.respuestas[j][i].pregunta+' (C)</label> <span class="glyphicon glyphicon-ok"></span></td> ';
                                                    }else{
                                                    contenido_examen+='<td> <label for="">'+data.respuestas[j][i].pregunta+'</label></td> ';
                                                    }
                                                    
                                                   }
                                                contenido_examen+='</tr>';
                                            contenido_examen+='</tbody>';
                                            contenido_examen+='</table>';
                                    contenido_examen+='</div>';
                                }
                        

                           $('#contenedor_competencias').append(contenido_examen);    
                    },
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                });
            }

            function cargar_editar_examen(id_examen) {
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Empleado/ver_examen')?>",
                    dataType : "JSON",
                    data : { id_examen:id_examen},
                    success: function(data){
                        console.log(data);
                        //llenar input
                        $('#editar_id_examen').val(data.examen[0].id_examen);
                        $('#editar_nombre_examen').val(data.examen[0].nombre_examen);
                        $('#editar_fecha_inicio').val(data.examen[0].fecha_inicio);
                        $('#editar_fecha_fin').val(data.examen[0].fecha_fin);
                    },
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                });
            }
            function editar_examen() {
                var id_examen = $('#editar_id_examen').val();
                var nombre_examen = $('#editar_nombre_examen').val();
                var fecha_inicio = $('#editar_fecha_inicio').val();
                var fecha_fin = $('#editar_fecha_fin').val();
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Empleado/editar_examen')?>",
                    dataType : "JSON",
                    data : { id_examen:id_examen, nombre_examen:nombre_examen, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin},
                    success: function(data){
                        //$('#modal_editar_examen').modal('hide');
                    if(data!=null){
                        Swal.fire({
                            icon: 'success',
                            title: 'Examen editado',
                            text: '',
                        });
                        listar_examenes();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de edición ',
                            text: 'Por favor revise que haya ingresado todos los datos correctamente',
                        })
                        //alert('Por favor revise que haya ingresado todos los datos');
                    }
                    },
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                });

            }
            function listar_resultados(){
                var id_agencia = $('#resultados_id_agencia').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/resultados_examenes')?>",
                dataType : "JSON",
                data : { id_agencia:id_agencia},

                success: function(data){
                    console.log(data)
                    $('#tabla_resultados').DataTable().destroy();
                    $('#tabla_resultados #resultados').empty();
                    if (data != null) {
                        for (var i = 0 ; i <data.length; i++) {
                            estado = ''
                            acciones = ''
                            if(data[i].estado == 1){
                                estado = 'En curso'
                                acciones = '<button type="button" class="btn btn-warning" title="Finalizar modulo" onclick="finalizar_modulo('+data[i].id+')">Finalizar</button>'
                            }else if(data[i].estado == 2){
                                estado = 'Finalizado'
                                acciones = '<div class="alert alert-success" role="alert">Modulo finalizado</div>'
                            }
                            $('#resultados').append('<tr>'+
                                                    '<td>'+data[i].nombre+" "+data[i].apellido+'</td>'+
                                                    '<td>'+data[i].historieta+'</td>'+
                                                    '<td>'+estado+'</td>'+
                                                    '<td>'+(data[i].nota_final*10).toFixed(2)+'</td>'+
                                                    '<td>'+acciones+'</td>'+
                                                    // '<td>'+
                                                    //     '<button type="button" title="Vista previa" data-toggle="modal" data-target="#Modal_ver_examen" onclick="ver_examen_resultados('+data[i].id_examen+','+data[i].id_empleado+')" class="btn btn-success ver_examen"><span class="glyphicon glyphicon-eye-open"></span></button> '+
                                                    //     //'<button type="button" title="Eliminar examen" onclick="eliminar_resultados('+data[i].id_examen+')" class="btn btn-danger eliminar_examen"><span class="glyphicon glyphicon-trash"></span></button> '+                                       
                                                    // '</td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_resultados').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 3, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }
    function finalizar_modulo(id_modulo){
        Swal.fire({
            title: 'Esta seguro de finalizar este modulo?',
            text: "Este proceso no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',

            confirmButtonText: 'Si, finalizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //luego de verificar eliminar examen
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Empleado/finalizar_modulo')?>",
                        dataType : "JSON",
                        data : { id_modulo:id_modulo},
                        success: function(data){
                            //alert('Eliminacion correcta');
                            if(data){
                                Swal.fire(
                                'Finalizado!',
                                'Modulo finalizado.',
                                'success'
                                )
                                listar_resultados();
                             }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de finalizacion',
                                    text: 'Este modulo ya fue finalizado',
                                })
                             }
                        },
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                }
            })
    }
    function ver_examen_resultados(id_examen,id_empleado) {
        $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Empleado/ver_examen_calificado')?>",
                    dataType : "JSON",
                    data : { id_examen:id_examen,id_empleado:id_empleado},
                    success: function(data){
                        $('#contenedor_competencias').empty();
                        $('#titulo_examen').text(data.examen[0].nombre_examen);
                        $('#nota_promedio').text('(Nota: '+round(data.promedio.total,2)+')');
                        contenido_examen='';
                        contenido_examen+='<div class="col-md-12">';

                        contenido_examen+='<table class="table table-bordered" >';
                                contenido_examen+='<tbody>';
                                    contenido_examen+='<tr>';
                                        contenido_examen+='<td><strong>Puntuaciones</strong></td>';
                                        contenido_examen+='<td>1</td>';
                                        contenido_examen+='<td>2</td>';
                                        contenido_examen+='<td>3</td>';
                                        contenido_examen+='<td>4</td>';
                                        contenido_examen+='<td>5</td>';
                                    contenido_examen+='</tr>';
                                contenido_examen+='</tbody>';
                            contenido_examen+='</table>';
                        contenido_examen+='</div>';
                        contador=0;
                        for (i = 0; i < data.competencias.length; i++) {
                            promedio_competencia=0;
                            contador_respuestas=0;
                            contenido_examen+='<div class="col-md-12">';
                                contenido_examen+='<div id="competencia'+(i+1)+'" ><strong>Competencia '+(i+1)+': '+data.competencias[i].nombre_competencia+' (Nota: '+data.promedio_competencias[data.competencias[i].id_competencia]+')</strong></div>';

                            contenido_examen+='</div>';
                                //competencias
                                //console.log(data.competencias[i]);

                                for (j = 0; j < data.preguntas[i].length; j++) {
                                    promedio_competencia+=parseFloat(data.respuestas[contador].respuesta);
                                    contador_respuestas++;
                                    check=[];
                                    check[1]='';
                                    check[2]='';
                                    check[3]='';
                                    check[4]='';
                                    check[5]='';
                                    if(data.preguntas[i][j].id_pregunta==data.respuestas[contador].id_preguntas_examenes){
                                        check[data.respuestas[contador].respuesta]='checked';//chequea los radio button según la respuesta
                                    }
                                    
                                    contenido_examen+='<div class="col-md-12">';
                                        contenido_examen+='<table class="table table-bordered" >';
                                            contenido_examen+='<tbody>';
                                                contenido_examen+='<tr>';
                                                    contenido_examen+='<td><p><strong>'+data.preguntas[i][j].nombre_pregunta+'</strong></p></td>';
                                                    contenido_examen+='<td><input class="form-check-input" type="radio" '+check[1]+' name="respuesta'+i+j+'" value="1"></td> ';
                                                    contenido_examen+='<td><input class="form-check-input" type="radio" '+check[2]+' name="respuesta'+i+j+'" value="2"></td> ';
                                                    contenido_examen+='<td><input class="form-check-input" type="radio" '+check[3]+' name="respuesta'+i+j+'" value="3"></td> ';
                                                    contenido_examen+='<td><input class="form-check-input" type="radio" '+check[4]+' name="respuesta'+i+j+'" value="4"></td> ';
                                                    contenido_examen+='<td><input class="form-check-input" type="radio" '+check[5]+' name="respuesta'+i+j+'" value="5"></td> ';
                                                contenido_examen+='</tr>';
                                            contenido_examen+='</tbody>';
                                        contenido_examen+='</table>';
                                    contenido_examen+='</div>';
                                    contador++;
                                }
                                //console.log(parseFloat(promedio_competencia/contador_respuestas));
                        }

                           $('#contenedor_competencias').append(contenido_examen);    
                    },
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                });
                function round(value, exp) {
                    if (typeof exp === 'undefined' || +exp === 0)
                        return Math.round(value);

                    value = +value;
                    exp = +exp;

                    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
                        return NaN;

                    // Shift
                    value = value.toString().split('e');
                    value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

                    // Shift back
                    value = value.toString().split('e');
                    return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
                    }
    }

    function agregarFila() {
        var opciones = <?= json_encode($modulos2); ?>

        var select = ""
        for(var i=0; i<opciones.length; i++){
            select += '<option value="'+opciones[i].id_historieta+'">'+opciones[i].historieta+'</option>'
        }
        $('#container_filas').append('<div class="form-group col-md-2" style="width: 90px;">'+
                    '<label >Historietas:</label></div>'+
                    '<div class="form-group col-md-3" style="width: 250px;">'+
                    '<select name="historietas[]" class="form-control">'+
                    select + // Aquí concatenamos las opciones generadas por PHP
                    '</select></div>'+
                    '<div class="form-group col-md-3" style="width: 200px;">'+
                    '<select name="nivel[]" class="form-control" >'+
                            '<option disabled selected> Seleccione un nivel </option>'+
                            '<option value="1"> basico </option>'+
                            '<option value="2"> intermedio </option>'+
                            '<option value="3"> avanzado </option>'+
                    '</select></div>'+
                    '<div class="form-group col-md-3" style="width: 200px;">'+
                    '<button type="button" class="btn btn-primary" onclick="agregarFila()">+</button></div>'+
                    '<div class="form-group col-md-3" style="width: 150px; height: 40px">'+
                    '<input type="hidden" name="modulo[]" placeholder="Nº Modulo" class="form-control"></div>');
    }

    function listar_pensum(){
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/listado_pensum')?>",
                dataType : "JSON",
                success: function(data){
                    $('#tabla_pensum').DataTable().destroy();
                    $('#tabla_pensum #data_pensum').empty();
                    if (data != null) {
                        for (var i = 0 ; i <data.length; i++) {
                            $('#data_pensum').append('<tr>'+
                                                    '<td>'+data[i].rol+'</td>'+
                                                    '<td>'+data[i].fecha_creacion+'</td>'+
                                                    '<td>'+data[i].nombre_empleado+'</td>'+
                                                    '<td>'+
                                                        '<button type="button" title="Vista previa"  data-toggle="modal" data-target="#vista_historietas" onclick="ver_historietas('+data[i].id_rol+')" class="btn btn-success ver_examen"><span class="glyphicon glyphicon-eye-open"></span></button> '+
                                                    '</td>'+

                                                  '</tr>');
                        }   
                    }
                    $('#tabla_pensum').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sSearch": "Buscador: "
                          },
                        "order": [[ 3, "desc" ]],
                    });
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            });
    }

    function insertar_historietas(){
        modal = document.getElementById('Modal_historietas');
        rol =  document.getElementById('roles').value
        historieta_text = document.getElementsByName('historietas[]');
        nivel_text = document.getElementsByName('nivel[]');
        

        historieta= []
        nivel=[];
        for (i = 0; i < historieta_text.length; i++) {
            historieta[i] = historieta_text[i].value;
        }
        for (i = 0; i < nivel_text.length; i++) {
            nivel[i] = nivel_text[i].value;
        }

        $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Empleado/insertar_carrera')?>",
                dataType : "JSON",
                data : { rol:rol,historieta:historieta,nivel:nivel},
                success: function(data){
                    if(data!=null){
                        //alert('Insercion correcta');
                        Swal.fire(
                            'Insercion correcta',
                            '',
                            'success'
                        )
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de inserción',
                            text: 'Por favor revise que haya ingresado todos los datos',
                        })
                        //alert('Por favor revise que haya ingresado todos los datos');
                    }
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                
                }
            }); 
    }

    function ver_historietas(rol) {
        $('#eliminar_todo').attr('data-rol',rol);

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Empleado/ver_historietas')?>",
            dataType : "JSON",
            data : { rol:rol},
            success: function(data){
                console.log(data)
                $('#cargo').text(data.datos_empleados[0].rol);
                $('#tabla_data_his').DataTable().destroy();
                $('#tabla_data_his #data_historieta').empty(); 
                if (data != null) {
                    for (var i = 0 ; i <data.historietas.length; i++) {
                        $('#data_historieta').append('<tr>'+
                            '<td>'+data.historietas[i].historieta+'</td>'+
                            '<td>'+data.historietas[i].id_nivel+'</td>'+
                            // '<td>'+data.historietas[i].id_modulo+'</td>'+
                            '<td><button type="button" title="Eliminar historieta" onclick="eliminar_historieta('+data.historietas[i].id_pensum+')" class="btn btn-danger eliminar_examen"><span class="glyphicon glyphicon-trash"></span></button></td>'+ 
                            '</tr>');
                    }   
                }   
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function eliminar_historieta(id_pensum){
        var rol = null
        Swal.fire({
            title: 'Esta seguro de eliminar este registro?',
            text: "Este proceso no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //luego de verificar eliminar examen
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Empleado/eliminar_historieta_pensum')?>",
                        dataType : "JSON",
                        data : { id_pensum:id_pensum, rol:rol},
                        success: function(data){
                        //alert('Eliminacion correcta');
                            if(data){
                                Swal.fire(
                                    'Eliminado!',
                                    'Eliminacion correcta.',
                                    'success'
                                ).then(function(){
                                    window.location.href = "<?php echo site_url('Empleado/control_examenes')?>";
                                });
                                
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de eliminacion',
                                    text: 'Este examen posee competencias',
                                })
                            }
                        },
                            error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                }
            })
    }

    $('#eliminar_todo').on('click', function(){
        var rol = $(this).attr('data-rol')
        var id_pensum =  null

        Swal.fire({
            title: 'Esta seguro de eliminar este registro?',
            text: "Este proceso no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //luego de verificar eliminar examen
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Empleado/eliminar_historieta_pensum')?>",
                        dataType : "JSON",
                        data : { id_pensum:id_pensum, rol:rol},
                        success: function(data){
                        //alert('Eliminacion correcta');
                            if(data){
                                Swal.fire(
                                    'Eliminado!',
                                    'Eliminacion correcta.',
                                    'success'
                                ).then(function(){
                                    window.location.href = "<?php echo site_url('Empleado/control_examenes')?>";
                                });
                                
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de eliminacion',
                                    text: 'Este examen posee competencias',
                                })
                            }
                        },
                            error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                }
            })
        
    });


</script><th