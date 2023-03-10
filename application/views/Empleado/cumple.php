

    




<div class="col-sm-1"></div>
<div class="well-print col-sm-10 no-print" style="position: center">
  <div class="panel panel-success">
    <div class="well text-center blue text-white">
                <h1>Cumpleañeros </h1>
                
            </div>

    <div class="row">

      <div class="col-sm-12">

        <div class="container col-sm-12 col-xs-12">

          <div class="row">
              <table id="example" class="table table-striped table-bordered" style="width:100%">

                <thead class="text-center">
                  <tr>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Fecha</th>
                    <th style="text-align: center">Edad</th>
                    <th style="text-align: center">Telefono</th>

                  </tr>
                </thead>
                <tbody>

                  
                   <?php foreach ($cumple as $value ) {
                    echo "<tr class='table'>";
                     echo '<td>'.$value->nombre2;
                     echo '<td>'.$value->fecha_nacimiento;
                     $edad=date("Y")-$value->anio;
                     echo '<td>'.$edad;
                     echo '<td>'.$value->telefono;
                     echo "</tr>";
                   } ?>


                 </tr> 

               </tbody>
             
             </table>
       </div>
      </div>
    </div>
    </div>
    <!--<div  class="text-center col-sm-1 justify-center">
       <p></p>
      <a class="no-print btn btn-lg btn-success align-middle " role="button" onclick="window.print()">
        imprimir
      </a>
    </div>-->
  </div>
  
<a class="btn btn-primary" role="button" onClick='history.go(-1);'>Atras</a>

</div> 
<script  type="text/javascript">
   $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

