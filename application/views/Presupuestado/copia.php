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
                     
                    '</td>';
                    <?php if(($ver)!=1){ ?>

                         document.getElementById('comentario').disabled = "true";

                     document.getElementById('add-button').disabled = "true";
                 <?php }?>

                  

                            } 

                        
                        }

                   if (bandera) {
                    if (cont !=0) {
                      //condicion para le que se encarga de llenarlo
                         html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                    
                    '</td>';
                        $('.add-button').removeAttr("disabled")
                        $('.comentario').removeAttr("disabled")

                    } else {
                      <?php if (($ver)==1) {
                        ?>
                        
                          html += '<td>'+
                    '<label> Semana '+semanas+'</label><br>'+
                    '<label> '+dias[dt.getUTCDay()]+' '+i+'</label>'+
                     
                    '</td>';
                  
                        <?php
                        }else{
                    ?>
                         

                          
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
      
         

              if (data.comentario.length==0) {
               document.getElementById('comentario').value = "";
               
               html2='<h4 class="alert alert-info text-center" >SIN ESTADO</H4>';
                        $('#editar').html('');
                                                  $('#editar_boton').html('');


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
                <h1>Hola Mundo</h1>
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
        
    </div>

</form>
