
<?php 

    $mes = date('Y').'-12';
$aux = date('Y-m-d', strtotime("{$mes} + 1 month"));
$ultimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
//print_r($carteras_asignadas);
 ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>


<div class="col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2><?=$titulo ?></h2>
        
    </div>
    <div class="panel-group col-sm-12">
    <?php 
    if (!empty($carteras_asignadas)) {
            for ($i=0; $i < count($carteras_asignadas) ; $i++) { 
            echo '<div class="panel-group col-sm-2">';
            echo '<a href="'.base_url("index.php/permisos/filtro_tablero_global/").$carteras_asignadas[$i]->id_agencia.'" class="btn btn-primary">'.$carteras_asignadas[$i]->agencia.'</a>';
            echo '</div>';


          } 
    }
      ?>
    </div>

                <div class="row">
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading"><label></label></div>
                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home" id="pag1">Gráfico puntuado</a></li>
                                    <li><a data-toggle="tab" href="#menu1" id="pag1">Rendición </a></li>
                                    <li><a data-toggle="tab" href="#menu2" id="pag2">Proyección </a></li>

                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active"><br>

                                        <div>
                                            <label>Desde:</label>
                                            <input type="date" id="dDesde" value="2022-01-14">
                                            <label>Hasta:</label>
                                            <input type="date" id="dHasta" value="2022-12-31">
                                            <button onclick="cambio_fecha()" value="Cargar">Cargar</button>
                                        </div>
                                        <div id="curve_chart" style="width: 100%; height: 500px"></div>
                                    </div>
                                    <div id="menu1" class="tab-pane fade"><br>
                                        <div>
                                            <!--<label>Desde:</label>
                                            <input type="date" id="rDesde" value="2022-01-14">
                                            <label>Hasta:</label>
                                            <input type="date" id="rHasta" value="2022-12-31">-->
                                            
                                            <button onclick="rendicion()" value="Cargar">Cargar</button>
                                        </div>
                                        <div class="panel-group col-sm-12">
                                            <table class="table table-striped" id="rendicion">

                                            </table>

                                        </div>

                                    </div>
                                    <div id="menu2" class="tab-pane fade"><br>

                                        <div>
                                            <label>Desde:</label>
                                            <input type="date" id="pDesde" value="2022-01-14">
                                            <label>Hasta:</label>
                                            <input type="date" id="pHasta" value="2022-12-31">
                                            <button onclick="proyeccion()" value="Cargar">Cargar</button>
                                        </div>
                                        <div id="grafico_proyeccion" style="width: 100%; height: 500px"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer">                            
                            </div> 
                        </div>
                   
        </div>
    </div>
        <!-- calendario empresarial y global-->
    <div class="col-md-3">
        <label>Fecha de carteras:</label>
        <input class="form-control" type="text" id="datepicker" onchange="indicadores_globales()">


        <br>
    </div>
    <!-- fin calendario-->
        
    
    <!-- tablero global-->
    <div class="panel-group col-sm-12">
        <div class="panel panel-primary ">
            <div class="panel-heading"><label style="margin-right: 75%"><?= $titulo_global ?></label>  <label id="fecha_empresa">Fecha: </label></div>
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><label>Carteras</label></div>
                    <div class="panel-body">
                        <!--ACTIVA-->
                        <label>Efectividad Cartera Activa:<span  id="efectividad_activa">%</span></label><br>
                        <label>Cartera Activa</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" id="barra_cartera_activa">
                                <label class="text-center" id="cartera_activa" for="">$</label>
                            </div>
                        </div>
                        <label>Presupuesto Cartera Activa</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                <label class="text-center" id="presupuesto_activa" for="">$</label>
                            </div>
                        </div>
                        <!--Efectividad-->
                        <label>Efectividad Cartera Efectiva:<span  id="efectividad_efectiva">%</span></label><br>
                        <label>Cartera Efectiva</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" id="barra_cartera_efectiva">
                                <label class="text-center" id="cartera_efectiva" for="">$</label>
                            </div>
                        </div>
                        <label>Presupuesto Cartera Efectiva</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                <label class="text-center" id="presupuesto_efectiva" for="">$</label>
                            </div>
                        </div>
                        <!--RECUPERACION-->
                        <label>Efectividad Cartera Recuperación:<span  id="efectividad_recuperacion">%</span></label><br>
                        <label>Cartera Recuperación</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" id="barra_cartera_recuperacion">
                                <label class="text-center" id="cartera_recuperacion" for="">$</label>
                            </div>
                        </div>
                        <label>Presupuesto Cartera Recuperación</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                <label class="text-center" id="presupuesto_recuperacion" for="">$</label>
                            </div>
                        </div>
                        <!--GLOBAL-->
                        <label>Efectividad Global: <span id="efectividad_global">%</span></label><br>
                        <label>Cartera Global</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" id="barra_cartera_global" >
                                <label class="text-center" id="cartera_global" for="">$</label>
                            </div>
                        </div>
                        <label>Presupuesto Cartera Global</label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" id="barra_presupuesto_global" style="width:100%;">
                                <label class="text-center" id="presupuesto_global" for="">$</label>
                            </div>
                        </div>
                        <center>
                            
                            <div id="chart_div" style="width: 400px; height: 120px;"></div>
                        </center>

                    </div>

                </div>


            </div>
            <div class="panel-footer">                            
            </div> 
        </div>
    </div>

    <!--fin tablero global-->
    <?php if (!empty($titulo_global)): ?>

    <div class="panel-group col-sm-12">
        <?php for ($i=0; $i < count($asignaciones); $i++){ 
                  $data = array('estado' => $estado,'codigo'=>$asignaciones[$i]->$parametro );  
                  $arr = serialize($data);
                  $arr = base64_encode($arr);
                  $arr = urldecode($arr);
                  $arr=$url.$arr; 


            ?>
            
        <div class="panel-group col-sm-4">
            <div class="panel panel-success">
                <div class="panel-heading">

               
                    <label style="margin-right: 75px"><?= $titulo_secundario." ".$asignaciones[$i]->$parametro2 ?></label> <br>          
                    <label <?= 'id="fecha_region_'.($i+1).'"';  ?>>Fecha:</label>

                    <a href="<?php echo base_url("index.php/Permisos/").$arr; ?>" class="close" > <span aria-hidden="true"><i class="glyphicon glyphicon-circle-arrow-right"></i></span></a>
            

                </div>
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Carteras</label></div>
                        <div class="panel-body">

                            <!--ACTIVA-->
                            <label>Efectividad Cartera Activa:<span  <?= 'id="efectividad_activa_'.($i+1).'"';  ?>>%</span></label><br>
                            <label>Cartera Activa</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" <?= 'id="barra_cartera_activa_'.($i+1).'"';  ?>>
                                    <label class="text-center" <?= 'id="cartera_activa_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Activa</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                    <label class="text-center" <?= 'id="presupuesto_activa_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <!--Efectividad-->
                            <label>Efectividad Cartera Efectiva:<span  <?= 'id="efectividad_efectiva_'.($i+1).'"';  ?>>%</span></label><br>
                            <label>Cartera Efectiva</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" <?= 'id="barra_cartera_efectiva_'.($i+1).'"';  ?>>
                                    <label class="text-center" <?= 'id="cartera_efectiva_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Efectiva</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                    <label class="text-center" <?= 'id="presupuesto_efectiva_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <!--RECUPERACION-->
                            <label>Efectividad Cartera Recuperación:<span  <?= 'id="efectividad_recuperacion_'.($i+1).'"';  ?>>%</span></label><br>
                            <label>Cartera Recuperación</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" <?= 'id="barra_cartera_recuperacion_'.($i+1).'"';  ?>>
                                    <label class="text-center" <?= 'id="cartera_recuperacion_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Recuperación</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;"><!--tamaño-->
                                    <label class="text-center" <?= 'id="presupuesto_recuperacion_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <!--GLOBAL-->
                            <label>Efectividad Global: <span <?= 'id="efectividad_global_'.($i+1).'"';  ?>>%</span></label><br>
                            <label>Cartera Global</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-green progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" <?= 'id="barra_cartera_global_'.($i+1).'"';  ?>  >
                                    <label class="text-center" <?= 'id="cartera_global_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Global</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" <?= 'id="efectividad_global_'.($i+1).'"';  ?> id="barra_presupuesto_global" style="width:100%;">
                                    <label class="text-center" <?= 'id="presupuesto_global_'.($i+1).'"';  ?>  for="">$</label>
                                </div>
                            </div>
                            <div  <?= 'id="chart_div_'.($i+1).'"';  ?> style="width: 400px; height: 120px;"></div>
                        </div>

                    </div>


                </div>
                            <div class="panel-footer">
                                <label>Encargado: </label>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="#"><i class="fa fa-user fa-fw"></i> <span  <?= 'id="encargado_'.($i+1).'"';  ?>></span> </a>
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                                        <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-pencil fa-fw"></i> Ver Informacion</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-unlock"></i> Permisos</a></li>
                                    </ul>
                                </div>
                            </div>
            </div>

        </div>
        <?php } ?>

    </div>

<?php endif ?>

</div>
    <style type="text/css">
        .event a {
            background-color: #5FBA7D !important;
            color: #ffffff !important;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">


    


      $(document).ready(function(){

         // indicadores_globales();
        document.ready = document.getElementById("datepicker").value = 'Seleccione una fecha';

       
    });
    function rendicion(){
      
            rDesde = $("#rDesde").val();
            rHasta = $("#rHasta").val();
            codigo_region=<?php echo json_encode($this->uri->segment('3')); ?>;


            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/rendicion_global')?>",
                dataType : "JSON",
                data : { desde:rDesde, hasta:rHasta,codigo_region:codigo_region},
                success: function(data){
                    //$('#rendicion').dataTable().fnDestroy();
                //$('#rendicion').DataTable().destroy();
                //$('#rendicion').empty();\
                var titulos = ['Carteras','Cartera activa real', 'Presup. cartera activa', 'Situación de C. activa','','Indice de eficiencia real','Presup. indice eficiencia','Situación de I. eficiencia','','Cartera efectiva real','Presup. cartera efectiva','Situación de C. efectiva'];

                document.getElementById("rendicion").innerHTML = "";
                // var body = document.getElementsById('rendicion')[0];
                var table = document.getElementById('rendicion');
                  var tableHead = document.createElement('THEAD');
                  table.appendChild(tableHead);
                    //var trA = document.createElement('TR');
                    // Append the rows to the head

                        //console.log(data);
   for (i = 0; i < titulos.length; i++) {
                                var tr = document.createElement('TR');
                            tr.setAttribute('id', 'titulo_'+i);

                            tableHead.appendChild(tr);


                            var th_ = document.createElement('th');

                            th_.innerHTML = titulos[i];
                            // Append them to the rows



                            tr.appendChild(th_);
        for (j = 0; j < data.length; j++) {                     
            var trA = document.getElementById('titulo_'+i);
            tableHead.appendChild(trA);
            var th = document.createElement('th');
            if (i==0) {
                th.innerHTML = data[j].mes;
            }
            //CARTERA ACTIVA
            if (i==1) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].cartera_act_real)+ Number.EPSILON) * 100) / 100,2,',','');
            } 
            if (i==2) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].cartera_activa)+ Number.EPSILON) * 100) / 100,2,',','');
            } 
            if (i==3) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].rendicion_cartera_activa)+ Number.EPSILON) * 100) / 100,2,',','');
            } 
            //INDICE DE EFICIENCIA
            if (i==5) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].indice_eficiencia)+ Number.EPSILON) * 100) / 100,2,',','');

            }
            if (i==6) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].indice_eficiencia_presupuestado)+ Number.EPSILON) * 100) / 100,2,',','');

            }
            if (i==7) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].indice_eficiencia_presupuestado-data[j].indice_eficiencia)+ Number.EPSILON) * 100) / 100,2,',','');

            }
            //CARTERA EFECTIVA
            if (i==9) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].efectiva)+ Number.EPSILON) * 100) / 100,2,',','');

            }
            if (i==10) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].presu_car_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');

            }
            if (i==11) {
                th.innerHTML = number_format(Math.round((parseFloat(data[j].rendicion_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');

            }
                // Append them to the rows              
            trA.appendChild(th);
        }
    }
    // Append the table body to the table
    // Loop to create the cells and rows
   /* for ( i = 0; i < 13; i++) {
        // Create the rows
        var tr = document.createElement('TR');
        // Append the rows to the body
        tableBody.appendChild(tr);

        // Agregar celdas a la fila, con base en cantidad de letras
        for ( j = 0; j < titulos.length; j++){ 
            var td = document.createElement('TD');
            if(j === 0) {
                // Es la primera columna, colocar número de fila
                td.innerText = i + 1;
                // Agregar clase que corresponde
                td.setAttribute('class', 'lettersTD');
            } else {
               // td.setAttribute('contenteditable', 'true');
            }
            // Append them to the rows
            tr.appendChild(td);
        }
    }*/
    // Append the table to the body
   // body.appendChild(table);
                //document.getElementById("rendicion").innerHTML = tabla;

                                                    /*'<thead>'+
                                                    '<tr>'+
                                                        '<th> Cartera activa</th>'+
                                                        '<td><strong> Diciembre</strong></td>'+
                                                        '<td><strong> Enero</strong></td>'+
                                                        '<td><strong> Febrero</strong></td>'+
                                                        '<td><strong> Marzo</strong></td>'+
                                                        '<td><strong> Resultado</strong></td>'+
                                                   ' </tr>'+



                                               ' </thead>';*/

                    //drawCurveTypes(data);

                    //console.log(table);
                },  
                error: function(data){
                    //drawCurveTypes(data);
                    var a =JSON.stringify(data);
                    alert(a);
                }
            });
    }
    function cambio_fecha(){
      
            fdesde = $("#dDesde").val();
            fHasta = $("#dHasta").val();
            codigo_region=<?php echo json_encode($this->uri->segment('3')); ?>;


            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/grafico_global')?>",
                dataType : "JSON",
                data : { desde:fdesde, hasta:fHasta,codigo_region:codigo_region},
                success: function(data){
                    drawCurveTypes(data);


                },  
                error: function(data){
                    //drawCurveTypes(data);
                    var a =JSON.stringify(data);
                    alert(a);
                }
            });
    }
    function indicadores_globales() {
            fecha = $("#datepicker").val();
            codigo_region=<?php echo json_encode($this->uri->segment('3')); ?>;


            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/indicadores_globales')?>",
                dataType : "JSON",
                data : { fecha:fecha,codigo_region:codigo_region},
                success: function(data){
                        let date = new Date(data[0].hasta)

                        let day = date.getDate()+1
                        let month = date.getMonth() + 1
                        let year = date.getFullYear()

                        if(month < 10){
                          fecha=`${day}-0${month}-${year}`
                        }else{
                          fecha=`${day}-${month}-${year}`
                        }
                       $('#fecha_empresa').html("Fecha: "+fecha)
                        //TABLERO DEL SEGMENTO GLOBAL
                            //barra cartera global
                            efectividad_global=number_format(Math.round((parseFloat(data[0].efectividad_global)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_global=number_format(Math.round((parseFloat(data[0].cartera_global)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_global").className = 'label label-'+data[0].color_efectividad_global+'';
                           $('#efectividad_global').html(efectividad_global+'%')
                            b_global = document.getElementById('barra_cartera_global');
                            b_global.style.width= efectividad_global+'%';
                            b_global.style.color  = 'black';

                            document.getElementById("barra_cartera_global").className = 'progress-bar progress-bar-'+data[0].color_efectividad_global+' progress-bar-striped active';
                           $('#cartera_global').html('$'+cartera_global)

                            //barra presupuesto global
                            presupuesto_global=number_format(Math.round((parseFloat(data[0].presupuesto_global)+ Number.EPSILON) * 100) / 100,2,',','');

                           $('#presupuesto_global').html('$'+presupuesto_global)

                        //Activa
                            //barra cartera global
                            efectividad_activa=number_format(Math.round((parseFloat(data[0].efectividad_activa)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_activa=number_format(Math.round((parseFloat(data[0].cartera_act)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_activa").className = 'label label-'+data[0].color_efectividad_activa+'';
                           $('#efectividad_activa').html(efectividad_activa+'%')
                            b_global = document.getElementById('barra_cartera_activa');
                            b_global.style.width  = efectividad_activa+'%';
                            b_global.style.color  = 'black';

                            document.getElementById("barra_cartera_activa").className = 'progress-bar progress-bar-'+data[0].color_efectividad_activa+' progress-bar-striped active';
                           $('#cartera_activa').html('$'+cartera_activa)

                            //barra presupuesto global
                            presupuesto_activa=number_format(Math.round((parseFloat(data[0].presu_cartera_activa)+ Number.EPSILON) * 100) / 100,2,',','');

                           $('#presupuesto_activa').html('$'+presupuesto_activa)

                        //Recuperacion
                            //barra cartera global
                            efectividad_recuperacion=number_format(Math.round((parseFloat(data[0].efectividad_recupera)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_recuperacion=number_format(Math.round((parseFloat(data[0].recupera)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_recuperacion").className = 'label label-'+data[0].color_efectividad_recupera+'';
                           $('#efectividad_recuperacion').html(efectividad_recuperacion+'%')
                            b_global = document.getElementById('barra_cartera_recuperacion');
                            b_global.style.width  = efectividad_recuperacion+'%';
                            b_global.style.color  = 'black';

                            document.getElementById("barra_cartera_recuperacion").className = 'progress-bar progress-bar-'+data[0].color_efectividad_recupera+' progress-bar-striped active';
                           $('#cartera_recuperacion').html('$'+cartera_recuperacion)

                            //barra presupuesto global
                            presupuesto_recuperacion=number_format(Math.round((parseFloat(data[0].presu_cartera_recuperacion)+ Number.EPSILON) * 100) / 100,2,',','');
                           $('#presupuesto_recuperacion').html('$'+presupuesto_recuperacion)

                        //Recuperacion
                            //barra cartera global
                            efectividad_efectiva=number_format(Math.round((parseFloat(data[0].efectividad_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_efectiva=number_format(Math.round((parseFloat(data[0].efectiva)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_efectiva").className = 'label label-'+data[0].color_efectividad_efectiva+'';
                           $('#efectividad_efectiva').html(efectividad_efectiva+'%')
                            b_global = document.getElementById('barra_cartera_efectiva');
                            b_global.style.width  = efectividad_efectiva+'%';
                            b_global.style.color  = 'black';

                            document.getElementById("barra_cartera_efectiva").className = 'progress-bar progress-bar-'+data[0].color_efectividad_efectiva+' progress-bar-striped active';
                           $('#cartera_efectiva').html('$'+cartera_efectiva)

                            //barra presupuesto global
                            presupuesto_efectiva=number_format(Math.round((parseFloat(data[0].presu_cartera_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');
                           $('#presupuesto_efectiva').html('$'+presupuesto_efectiva)


                            indice_efec= ((parseFloat(data[0].efectiva))/(parseFloat(data[0].cartera_act)))*100
                            valores=[]
                            valores[0]=indice_efec;
                            valores[1]='chart_div';
                            drawCurveTypes(null,valores);

                    
                    //FIN TABLERO DEL SEGMENTO GLOBAL







                    for (var i = 1; i < data.length; i++) {
            
                        if (data[i].presu_cartera_activa !== undefined) {
                        
                        let date = new Date(data[i].hasta)

                        let day = date.getDate()+1
                        let month = date.getMonth() + 1
                        let year = date.getFullYear()

                        if(month < 10){
                          fecha=`${day}-0${month}-${year}`
                        }else{
                          fecha=`${day}-${month}-${year}`
                        }
                       $('#fecha_region_'+i).html("Fecha: "+fecha)

                        //GLOBAL
                            //barra cartera global
                            efectividad_global=number_format(Math.round((parseFloat(data[i].efectividad_global)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_global=number_format(Math.round((parseFloat(data[i].cartera_global)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_global_"+i).className = 'label label-'+data[i].color_efectividad_global+'';
                           $('#efectividad_global_'+i).html(efectividad_global+'%')
                            b_global = document.getElementById('barra_cartera_global_'+i);
                            b_global.style.width  = efectividad_global+'%';
                            b_global.style.color  = 'black';
                            document.getElementById("barra_cartera_global_"+i).className = 'progress-bar progress-bar-'+data[i].color_efectividad_global+' progress-bar-striped active';
                           $('#cartera_global_'+i).html('$'+cartera_global)

                            //barra presupuesto global
                            presupuesto_global=number_format(Math.round((parseFloat(data[i].presupuesto_global)+ Number.EPSILON) * 100) / 100,2,',','');

                           $('#presupuesto_global_'+i).html('$'+presupuesto_global)

                        //Activa
                            //barra cartera global
                            efectividad_activa=number_format(Math.round((parseFloat(data[i].efectividad_activa)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_activa=number_format(Math.round((parseFloat(data[i].cartera_act)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_activa_"+i).className = 'label label-'+data[i].color_efectividad_activa+'';
                           $('#efectividad_activa_'+i).html(efectividad_activa+'%')
                            b_global = document.getElementById('barra_cartera_activa_'+i);
                            b_global.style.width  = efectividad_activa+'%';
                            b_global.style.color  = 'black';
                            document.getElementById("barra_cartera_activa_"+i).className = 'progress-bar progress-bar-'+data[i].color_efectividad_activa+' progress-bar-striped active';
                           $('#cartera_activa_'+i).html('$'+cartera_activa)

                            //barra presupuesto global
                            presupuesto_activa=number_format(Math.round((parseFloat(data[i].presu_cartera_activa)+ Number.EPSILON) * 100) / 100,2,',','');

                           $('#presupuesto_activa_'+i).html('$'+presupuesto_activa)

                        //Recuperacion
                            //barra cartera global
                            efectividad_recuperacion=number_format(Math.round((parseFloat(data[i].efectividad_recupera)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_recuperacion=number_format(Math.round((parseFloat(data[i].recupera)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_recuperacion_"+i).className = 'label label-'+data[i].color_efectividad_recupera+'';
                           $('#efectividad_recuperacion_'+i).html(efectividad_recuperacion+'%')
                            b_global = document.getElementById('barra_cartera_recuperacion_'+i);
                            b_global.style.width  = efectividad_recuperacion+'%';
                            b_global.style.color  = 'black';
                            document.getElementById("barra_cartera_recuperacion_"+i).className = 'progress-bar progress-bar-'+data[i].color_efectividad_recupera+' progress-bar-striped active';
                           $('#cartera_recuperacion_'+i).html('$'+cartera_recuperacion)

                            //barra presupuesto global
                            presupuesto_recuperacion=number_format(Math.round((parseFloat(data[i].presu_cartera_recuperacion)+ Number.EPSILON) * 100) / 100,2,',','');
                           $('#presupuesto_recuperacion_'+i).html('$'+presupuesto_recuperacion)

                        //Efectiva
                            //barra cartera global
                            efectividad_efectiva=number_format(Math.round((parseFloat(data[i].efectividad_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');
                            cartera_efectiva=number_format(Math.round((parseFloat(data[i].efectiva)+ Number.EPSILON) * 100) / 100,2,',','');

                            document.getElementById("efectividad_efectiva_"+i).className = 'label label-'+data[i].color_efectividad_efectiva+'';
                           $('#efectividad_efectiva_'+i).html(efectividad_efectiva+'%')
                            b_global = document.getElementById('barra_cartera_efectiva_'+i);
                            b_global.style.width  = efectividad_efectiva+'%';
                            b_global.style.color  = 'black';
                            document.getElementById("barra_cartera_efectiva_"+i).className = 'progress-bar progress-bar-'+data[i].color_efectividad_efectiva+' progress-bar-striped active';
                           $('#cartera_efectiva_'+i).html('$'+cartera_efectiva)

                           $('#encargado_'+i).html(data[i].encargado)

                            //barra presupuesto global
                            presupuesto_efectiva=number_format(Math.round((parseFloat(data[i].presu_cartera_efectiva)+ Number.EPSILON) * 100) / 100,2,',','');
                           $('#presupuesto_efectiva_'+i).html('$'+presupuesto_efectiva)
                            indice_efec= ((parseFloat(data[i].efectiva))/(parseFloat(data[i].cartera_act)))*100

                           valores=[]
                            valores[0]=indice_efec;
                            valores[1]='chart_div_'+i;
                            drawCurveTypes(null,valores);
                           }
                        }
                    


                },  
                error: function(data){
                    //drawCurveTypes(data);
                    var a =JSON.stringify(data);
                    alert(a);
                }
            });
    }


    google.charts.load('current', { 'packages': ['corechart', 'gauge'],  'callback': indicadores_globales,
 });
          google.charts.setOnLoadCallback(cambio_fecha);


    function drawCurveTypes(datos=null,datos2=null) {

        if (datos != null) {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'X');
            data.addColumn('number', 'IE pre');
            data.addColumn('number', 'IE');
            data.addColumn('number', 'Pre Glob')
            data.addColumn('number', 'Glob');
            data.addColumn('number', 'PreAct');
            data.addColumn('number', 'Act');
            data.addColumn('number', 'PreRecup');
            data.addColumn('number', 'Recup');
            data.addColumn('number', 'PreEfe');
            data.addColumn('number', 'Efe');

        

        for (let i = 0; i < datos.length; i++) {

            presu_cartera_global = Math.round(((parseFloat(datos[i].presu_cartera_activa)+parseFloat(datos[i].presu_cartera_recuperacion))+ Number.EPSILON) * 100) / 100
            cartera_global =  Math.round(((parseFloat(datos[i].cartera_act)+parseFloat(datos[i].recupera))+ Number.EPSILON) * 100) / 100

            presu_porcentaje = Math.round((parseFloat(datos[i].presu_car_efectiva))/(parseFloat(datos[i].presu_cartera_activa))*100)

            presu_cartera_activa = Math.round((parseFloat(datos[i].presu_cartera_activa)+ Number.EPSILON) * 100) / 100
            cartera_act =  Math.round((parseFloat(datos[i].cartera_act)+ Number.EPSILON) * 100) / 100


            recupera = Math.round((parseFloat(datos[i].recupera)+ Number.EPSILON) * 100) / 100
            presu_cartera_recuperacion =  Math.round((parseFloat(datos[i].presu_cartera_recuperacion)+ Number.EPSILON) * 100) / 100


            presu_car_efectiva = Math.round((parseFloat(datos[i].presu_car_efectiva)+ Number.EPSILON) * 100) / 100
            efectiva = Math.round((parseFloat(datos[i].efectiva)+ Number.EPSILON) * 100) / 100

            porcentaje_eficiencia_real = Math.round((efectiva/cartera_act)*100)

            


            dddia = new Date(datos[i].fecha);
            dddia.setDate(dddia.getDate()+1);
            dddia.setHours(0,0,0);
            data.addRows([
                    [dddia,presu_porcentaje,porcentaje_eficiencia_real,presu_cartera_global, cartera_global,presu_cartera_activa, cartera_act,presu_cartera_recuperacion,recupera,presu_car_efectiva,efectiva,]
            ]);  
        }


        
        var options = {
            //colors: ['#ff0000', '#00ff00', '#0000ff']
        pointSize: 5,
        fontSize: 11,
        series:{
            //colors: ['#ff0000', '#00ff00', '#0000ff']
                0: {
                    color: "#D1B5FF",
                targetAxisIndex: 2},
                1: {
                color: "#6003F9",
                targetAxisIndex: 2
                },
                2: {
                color: "#33A2FF"},
                3: {
                    color: "#0036C6"
                },
                4: {
                    color: "#FF0000"
                },
                5: {
                    color: "#A40505"
                },
                6: {
                    color: "#EDA746"
                },
                7: {
                    color: "#FE5C00"
                },
                8: {
                    color: "#70D660"
                },
                9: {
                    color: "#1B7D0B"
                },

        },
        hAxis: {
            title: 'Mes'
        },
        vAxes: {
        0: {
            format: "$000,000.00",
            viewWindow: {
                min: 0,
            },
            title: 'Valor en Dolares'
        },
        2: {
            viewWindow: {
                min: 50,

            },
            title: 'Porcentaje'
        }
    },

            chartArea : { left: 120, top:50, right:120 },
            legend: { position: 'bottom' },
            width: 1035,
            height: 500
            //curveType: 'function'
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
                }

        
                if (datos2!=null) {

        var data = new google.visualization.DataTable();
        data.addColumn('string', '');
        data.addColumn('number', '');
                data.addRows([
          ['Efectividad', datos2[0]]]);


        var options = {
          width: 400, height: 120,
          greenFrom:90, greenTo: 100,
          yellowFrom:80, yellowTo: 90,
          redFrom: 0, redTo: 80,
          min:65,
          minorTicks: 5
        };

      

        var chart = new google.visualization.Gauge(document.getElementById(datos2[1]));

        chart.draw(data, options);

        }
    }
    function grafico_proyeccion(datos=null,datos2=null) {

        if (datos != null) {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'X');

            data.addColumn('number', 'Presupuesto cartera activa');
            data.addColumn('number', 'Cartera activa real');
            data.addColumn('number', 'Proyeccion cartera activa');

        

        for (let i = 0; i < datos.length; i++) {

            presu_cartera_global = Math.round(((parseFloat(datos[i].presu_cartera_activa)+parseFloat(datos[i].presu_cartera_recuperacion))+ Number.EPSILON) * 100) / 100
            cartera_global =  Math.round(((parseFloat(datos[i].cartera_act)+parseFloat(datos[i].recupera))+ Number.EPSILON) * 100) / 100
            presu_cartera_activa = Math.round((parseFloat(datos[i].presu_cartera_activa)+ Number.EPSILON) * 100) / 100
            cartera_act =  Math.round((parseFloat(datos[i].cartera_act)+ Number.EPSILON) * 100) / 100


            recupera = Math.round((parseFloat(datos[i].recupera)+ Number.EPSILON) * 100) / 100
            presu_cartera_recuperacion =  Math.round((parseFloat(datos[i].presu_cartera_recuperacion)+ Number.EPSILON) * 100) / 100


            presu_car_efectiva = Math.round((parseFloat(datos[i].presu_car_efectiva)+ Number.EPSILON) * 100) / 100
            efectiva = Math.round((parseFloat(datos[i].efectiva)+ Number.EPSILON) * 100) / 100

            


            dddia = new Date(datos[i].fecha);
            dddia.setDate(dddia.getDate()+1);
            dddia.setHours(0,0,0);
            data.addRows([
                    [dddia, presu_cartera_global, cartera_global,presu_cartera_activa, cartera_act,presu_cartera_recuperacion,recupera,presu_car_efectiva,efectiva,]
            ]);  
        }

        
        var options = {
        pointSize: 5,
        fontSize: 11,
        hAxis: {
            title: 'Mes'
        },
        vAxis: {
            minValue: 0
                //title: 'Popularity'
            },
            chartArea : { left: 120, top:50, right:120 },
            legend: { position: 'bottom' },
            width: 1035,
            height: 500
            //curveType: 'function'
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
                }

    
    }
function number_format(number, decimals, decPoint, thousandsSep){
    decimals = decimals || 0;
    number = parseFloat(number);

    if(!decPoint || !thousandsSep){
        decPoint = '.';
        thousandsSep = ',';
    }

    var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
    var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
    var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
    var formattedNumber = "";

    while(numbersString.length > 3){
        formattedNumber += thousandsSep + numbersString.slice(-3)
        numbersString = numbersString.slice(0,-3);
    }

    return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
}
$( function() {
    // An array of dates
    var eventDates = {};

    <?php for ($i=0; $i < count($fechas_cartera); $i++) { 

        $anio=substr($fechas_cartera[$i]->fecha, 0,4);
        $mes=substr($fechas_cartera[$i]->fecha, 5,2);
        $dia=substr($fechas_cartera[$i]->fecha, 8,2);
        $fecha2=$anio."/".$mes."/".$dia;
          ?>
     eventDates[ new Date('<?php echo date($fecha2)?>')] = new Date('<?php echo date($fecha2)?>');

                      <?php  }  ?>
   
    // datepicker
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function( date ) {
            var highlight = eventDates[date];
            if( highlight ) {
                 return [true, "event", 'Datos ingresados'];
            } else {
                 return [true, '', ''];
            }
        }
    });
});



</script>

</body>
</html>