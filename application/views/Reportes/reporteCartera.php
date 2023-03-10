<?php
	/*echo "<pre>";
	print_r($carteras);
	echo "</pre>";*/

  ?>


<div class="col-sm-1"></div>
<div class="well-print col-sm-10 no-print" style="position: center">
  <div class="panel panel-success">
    <div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>reporte monto de cartera</h1>
    </div>

    <div class="row">

      <div class="col-sm-12">

        <div class="container col-sm-12 col-xs-12">

          <div class="row">
              <table id="example" class=" table table-striped table-bordered" style="width:100%">

                <thead class="text-center">
                  <tr>
                    <th>Agencia</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>
                    <th>---</th>

                    <th>total</th>

                  </tr>
                </thead>
                <tbody>

                  <tr class="table">
                   <?php

                   for ($i=1; $i < 13 ; $i++) { 
						if (isset($carteras[$i])) {
							# code...
						
							foreach ($carteras[$i] as $key => $value) {
								if (substr($value->fecha, 6,2)==$i) {
									# code...
					 echo '<th>'.$value->agencia;                    
                     echo '<th>'.$value->cartera;
                     echo '<th>'.$value->fecha;
                     echo "</tr>";
								}
							}
						}
					}
				    ?>


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
  
<a class="no-print btn btn-lg btn-success align-middle" role="button" onClick='history.go(-1);'>Atras</a>

</div> 
<script >
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap2.min.css
">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css
">
