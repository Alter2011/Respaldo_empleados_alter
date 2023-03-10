<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material/material-icons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material.min.css">
<style>
table, th, td {
  border: 1px solid black;
  padding: 8px;
  text-align: center;
}
</style>
        <script type="text/javascript">
        var f    = new Date();
        var mes  =(f.getMonth() +1);
        var anio = f.getFullYear();
        var detalle=0;
        if (mes<=9) {
            fecha =  anio+'-0'+mes;
        } else {
            fecha =  anio+'-'+mes;
        }
        function aprobacion(numero){
           var comentario = $('#comentario').val();
           var segmento = $('#segmento').val();
          
               $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Presupuestado/aprobacion')?>",
                dataType : "JSON",
                data : { segmento:segmento, fecha:fecha,comentario:comentario,numero:numero},
                success: function(data){
                 console.log(data);

                load();

                // alert(data.monto[0].monto);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
        function modificar(){
          var numeros=new Array();
          
          for (var i = 1; i <= 31; i++) {
            numeros[i]=$('input:text[name='+i+']').val();
          }

                     var segmento = $('#segmento').val();
                 var comentario = $('#comentario').val();
                 var cartera = $('#cartera').val();
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Presupuestado/modificar')?>",
                dataType : "JSON",
                data : { segmento:segmento, fecha:fecha,comentario:comentario , numeros:numeros,cartera:cartera,detalle:detalle},
                success: function(data){
                 console.log(data);
                 alert('La modificacion se hizo correctamente');
                                 load();


                // alert(data.monto[0].monto);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
           $('#editar_boton').html('');

        }
          function editar(){
               $('.semana_1').removeAttr("disabled")
               $('.semana_2').removeAttr("disabled")
               $('.semana_3').removeAttr("disabled")
               $('.semana_4').removeAttr("disabled")
               $('.semana_5').removeAttr("disabled")
               //$('#comentario').removeAttr("disabled")
               //$('#add-button').removeAttr("disabled")
               html5 = ' <a onclick="modificar()" id="finalizarEditar" style="margin-left: 82%; margin-bottom: 40px" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent elemento" >Finalizar editar</a>';
                              $('#editar_boton').html(html5);


          }
            function load() {
                 var segmento = $('#segmento').val();
                 var comentario = $('#comentario').val();
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Presupuestado/ver')?>",
                dataType : "JSON",
                data : { segmento:segmento, fecha:fecha,comentario:comentario},
                success: function(data){
                 console.log(data);

                calendario(mes,anio,data);
                if (!(typeof data.comentario == "undefined")) {

                detalle=data.comentario[0].id_detalle;
                }
                // alert(data.comentario[0].id_detalle);

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
          }
        $(document).ready(function(){
            if (mes<=9) {
                document.ready = document.getElementById("nap").value = anio+'-0'+mes;
            } else {
                document.ready = document.getElementById("nap").value = anio+'-'+mes;
            }
            load();
            $("#nap").change(function () {
                fecha= $("#nap").val();
                mes=fecha.substr(5, 2);
                anio=fecha.substr(0, 4);
                             load();

                 //calendario(mes,anio,null);

           
             });
          });
          
                  valores=0;
              var bandera=parseFloat(0);

         function calendario(mes,anio,data){
         //document.getElementById("nap").value
         var dias=["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
         var dt=''; 
         var semanas=1;
         var bandera=true;
         var ultimoDia = new Date(anio, mes, 0);
         var html = '',html3=''; 
         var cont=0;
         var semana1=0,semana2=0,semana3=0,semana4=0,semana5=0,total=0;
         ultimoDia=ultimoDia.getUTCDate();
             contador=0; 
             html+="<tr>";
            for(i=1; i<=ultimoDia; i++){
               
                dt = new Date(mes+' '+i+', '+anio+' 12:00:00');
                 document.getElementById('comentario').value = "";
                    if (dt.getUTCDay() != 0) {
                        for(j=0; j<=data.monto.length-1; j++){
                        

                            if (parseFloat(data.monto[j].fecha.substr(8, 2))==i) {
                                cont ++;
                                bandera=false;
                                     html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    '<input disabled="true" type="text" min="0" id="semana_'+semanas+'" onclick="limpia()" class="semana_'+semanas+'" onblur="limpia()"  onfocus="resta(this)" onchange="sumatoria(this)" name="'+i+'" value="'+data.monto[j].monto+'">'+ 
                    '</td>';
                    <?php if(($ver)!=1){ ?>

                         document.getElementById('comentario').disabled = "true";

                     document.getElementById('add-button').disabled = "true";
                 <?php }?>

                    //sumatorias por semanas
                    switch(semanas) {
                      case 1:
                      semana1 +=parseFloat(data.monto[j].monto);
                      total +=parseFloat(data.monto[j].monto);
                        break;
                      case 2:
                      semana2 +=parseFloat(data.monto[j].monto);
                      total +=parseFloat(data.monto[j].monto);

                        break;
                      case 3:
                      semana3 +=parseFloat(data.monto[j].monto);
                      total +=parseFloat(data.monto[j].monto);
                        break;
                      case 4:
                      semana4 +=parseFloat(data.monto[j].monto);
                      total +=parseFloat(data.monto[j].monto);
                        break;

                      case 5:
                      semana5 +=parseFloat(data.monto[j].monto);
                       total +=parseFloat(data.monto[j].monto);
                        break;
                      default:
                    }

                            } 

                        
                        }

                   if (bandera) {
                    if (cont !=0) {
                      //condicion para le que se encarga de llenarlo
                         html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    '<input  disabled="true" class="semana_'+semanas+'" type="text" min="0"  id="semana_'+semanas+'" onclick="limpia()" onblur="limpia()"  onfocus="resta(this)" onchange="sumatoria(this)" name="'+i+'" value="0.00">'+ 
                    '</td>';
                        $('.add-button').removeAttr("disabled")
                        $('.comentario').removeAttr("disabled")

                    } else {
                      <?php if (($ver)==1) {
                        ?>
                        
                          html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    '<input disabled="true"  type="text" min="0" class="semana_'+semanas+'" id="semana_'+semanas+'" onclick="limpia()" onblur="limpia()"  onfocus="resta(this)" onchange="sumatoria(this)" name="'+i+'" value="0.00">'+ 
                    '</td>';
                  
                        <?php
                        }else{
                    ?>
                         if (data.comentario.length==0) {
                           html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    '<input type="text" class="semana_'+semanas+'" min="0" id="semana_'+semanas+'" onclick="limpia()" onblur="limpia()"  onfocus="resta(this)" onchange="sumatoria(this)" name="'+i+'" value="0.00">'+ 
                    '</td>';
                          }else{
                               html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    '<input disabled="true" type="text" class="semana_'+semanas+'" min="0" id="semana_'+semanas+'" onclick="limpia()" onblur="limpia()"  onfocus="resta(this)" onchange="sumatoria(this)" name="'+i+'" value="0.00">'+ 
                    '</td>';
                          }

                          
                      $('#add-button').removeAttr("disabled")
                       $('#comentario').removeAttr("disabled")

                    <?php
                        } ?>
                   
                    }
                } 
                                    bandera=true;
   
                    contador++;
                }

                if (dt.getUTCDay() == 5) {
                    semanas+=1;
                     html += 
                              '</tr>';
                    if (semanas==6) {semanas-=1;} 
                    if (contador==1) {semanas-=1;}
                  
                }
                if (!(typeof data.empleado == "undefined")) {

                empleado = 'Empleado: '+data.empleado[0].nombre+' '+data.empleado[0].apellido;
                        $('#empleado').html(empleado);
                }
            }
      
          //ASIGNACION DE COMENTARIOS SI EXISTEN
            if (typeof data.comentario == "undefined") {
              document.getElementById('comentario').value = "";
              html2='<span style="float: right;font-size:15px;" class="label label-default">SIN ESTADO</span>';
                  $('#editar').html('');


            }else{

              if (data.comentario.length==0) {
               document.getElementById('comentario').value = "";
               
               html2='<h4 class="alert alert-info text-center" >SIN ESTADO</H4>';
                        $('#editar').html('');
                                                  $('#editar_boton').html('');


              } else {
                        html3 =  '<a onclick="aprobacion(2)" style="margin-left: 60%; margin-bottom:'+ 
                    '40px" id="aprobacion" class="btn btn-primary btn-lg btn-danger"'+
                    'style="margin-left: 4px;">Desaprobar colocación</a>'+
                  '<div class="mdl-tooltip mdl-tooltip--large" for="cancel-button" >Desaprobar</div>';

             html3 += ' <a onclick="aprobacion(1)" style=" margin-bottom: 40px"'+
             'id="aprobacion" class="btn btn-primary btn-lg btn-success" >Aprobar colocación</a>'+
        '<div class="mdl-tooltip mdl-tooltip--large" for="cancel-button" >Aprobar</div>';

                   if (data.comentario[0].estado==0) {
              html2='<h4 class="alert alert-warning text-center" >EN ESPERA</h4>';
                                         $('#editar').html('');
                                                                   $('#editar_boton').html('');


          }else if (data.comentario[0].estado==1) {
              html2='<h4 class="alert alert-success text-center" >APROBADO</h4>';
                           $('#editar').html('');
                          $('#editar_boton').html('');

          }else if (data.comentario[0].estado==2) {
              html2='<h4 class="alert alert-danger text-center " >DESAPROBADO</span>';
                <?php if (!(($ver)==1)) {
                        ?>
             html6 = ' <a onclick="editar()" style=" margin-bottom: 40px"'+
             'id="aprobacion" class="btn btn-primary btn-lg btn-success" >Editar colocación</a>'+
        '<div class="mdl-tooltip mdl-tooltip--large" for="cancel-button" >Editar</div>';
            
             $('#editar').html(html6);

             <?php }
              ?>


          }
           

               document.getElementById('comentario').value = data.comentario[0].comentario;
              }
            }

            //asignacion final de las sumatorias 
            document.getElementById('semana_1').value = semana1;
            document.getElementById('semana_2').value = semana2;
            document.getElementById('semana_3').value = semana3;
            document.getElementById('semana_4').value = semana4;
            document.getElementById('semana_5').value = semana5;
           document.getElementById('total').value = total;
          
          //asignacion del label de estados

                       $('#enlaces').html(html3);
                      $('#estados').html(html2);
                      $('#show_data').html(html);
       }
       function limpia(){
        bandera=0;
       }
         function resta(control){
            if (bandera==0) {
                valores=control.value;
            }
        bandera++;
       }
      function sumatoria(control){
         dia = control.value;
                      
             if (!(!/^([0-9]+\.?[0-9]{0,2})$/.test(dia))){
             
           
            switch(control.id) {
              case 'semana_1':

               valor=document.getElementById("semana_1").value;
                 
               total=parseFloat(dia)+parseFloat(valor);

              document.getElementById("semana_1").value = total;

               if (valores != 0) {
                    totall=parseFloat(valor)-parseFloat(valores);
                    totall +=parseFloat(dia);
                    document.getElementById("semana_1").value = totall;

                          }
                break;
              case 'semana_2':
               valor=document.getElementById("semana_2").value;
               total=parseFloat(dia)+parseFloat(valor);
              document.getElementById("semana_2").value = total;
               if (valores != 0) {
                    totall=parseFloat(valor)-parseFloat(valores);
                    totall +=parseFloat(dia);
                    document.getElementById("semana_2").value = totall;

                          }
                break;
                 case 'semana_3':
               valor=document.getElementById("semana_3").value;
               total=parseFloat(dia)+parseFloat(valor);
              document.getElementById("semana_3").value = total;
               if (valores != 0) {
                    totall=parseFloat(valor)-parseFloat(valores);
                    totall +=parseFloat(dia);
                    document.getElementById("semana_3").value = totall;

                          }
                break;
                 case 'semana_4':
               valor=document.getElementById("semana_4").value;
               total=parseFloat(dia)+parseFloat(valor);
              document.getElementById("semana_4").value = total;
               if (valores != 0) {
                    totall=parseFloat(valor)-parseFloat(valores);
                    totall +=parseFloat(dia);
                    document.getElementById("semana_4").value = totall;

                          }
                break;
                 case 'semana_5':
               valor=document.getElementById("semana_5").value;
               total=parseFloat(dia)+parseFloat(valor);
              document.getElementById("semana_5").value = total;
               if (valores != 0) {
                    totall=parseFloat(valor)-parseFloat(valores);
                    totall +=parseFloat(dia);
                    document.getElementById("semana_5").value = totall;

                }
                break;
              default:
                // code block
            }
            total1=document.getElementById("semana_1").value;
            total2=document.getElementById("semana_2").value;
            total3=document.getElementById("semana_3").value;
            total4=document.getElementById("semana_4").value;
            total5=document.getElementById("semana_5").value;
            tot=parseFloat(total1)+parseFloat(total2)+parseFloat(total3)+parseFloat(total4)+parseFloat(total5);
            document.getElementById("total").value = tot;
             }else{
                alert('Ingrese solo numeros por favor');
                control.value=valores;
             }
             bandera=0;
             valores=0;

      }
     


        </script>

            <?php echo form_open('Presupuestado/insercion', array('class'=>'jsform')); ?>
      <input type="hidden" name="segmento" id="segmento" class="form-control" placeholder="Product Code" value="<?php echo $this->uri->segment(3);?>">
     <?php if (isset($cartera[0])): ?>
    <input type="hidden" name="cartera" id="cartera" class="form-control" placeholder="Product Code" value="<?php echo $cartera[0]->id_cartera;?>">
     <?php endif ?>
    <div class="col-sm-10">
            <div class="well text-center blue text-white">
                <h1>Colocación de presupuestos </h1>
            </div>
            <input type="month" id="nap" name="mes">
         
               <H5 id="empleado">
              
            </H5>

            <?php if (!isset($cartera[0]) and ($ver)!=1): ?>
                <p>No posee una cartera asignada</p>

            <?php endif ?>
            
            <div id="estados">
              
            </div>
            <div style="float: right;" id="editar">
              
            </div>  
           
        <br>
        <br>
        
        <label>MONTOS TOTALES</label>
        <br>
        <table>
            <tr>
                <td>
                <label> Semana 1</label><br>
                <input  disabled="true" type="text" min="0" id="semana_1" name="semana_1" value="0.00"> 
   
            </td>
            <td><label> Semana 2</label> <br>
               <input  disabled="true" type="text" min="0" id="semana_2" name="semana_2" value="0.00"> 
            </td>
             <td>
                <label> Semana 3</label><br>
        <input  disabled="true" type="text" min="0" id="semana_3" name="semana_3" value="0.00"> 
   
            </td>
            <td><label> Semana 4</label> <br>
                <input  disabled="true" type="text" min="0" id="semana_4" name="semana_4" value="0.00"> 
            </td>
            <td><label> Semana 5</label> <br>
               <input  disabled="true" type="text" min="0" id="semana_5" name="semana_5" value="0.00"> 
            </td>
            <td><label> Total: </label> <br>
               <input disabled="true" type="text" min="0" id="total" name="total" value="0.00"> 
            </td>
        </tr>
        </table>
        
        
        <br><br>
        <table id="show_data">
                                
        </table>
       
        <br>
       
        <br>
           <div class="form-group purple-border">

         <label>Comentario de la colocacion:</label>
        <textarea class="form-control" rows="5" name="comentario" id="comentario"></textarea>
        </div>
        <?php if(($ver)==1){ ?>
        <div id="enlaces">
          
        </div>
 
        <?php }else{?>
          
          <button onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();"  id="add-button" style="margin-left: 82%; margin-bottom: 40px" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent elemento"><i class="material-icons" role="presentation">note_add</i> Finalizar</button>
       <div class="mdl-tooltip mdl-tooltip--large" for="add-button">Finalizar colocación</div>
           <div id="editar_boton">
          
        </div>
           <?php
        } 
        ?>

    </div>

</form>
