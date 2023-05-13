<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Test para prospectos</h2>
                <p>Para realizar los examenes el prospecto debe visitar el siguiente link: http://192.168.1.69/employee_info/index.php/test/test_info</p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                       <button class="btn btn-primary" onClick="addTest()" data-toggle="modal" data-target="#Modal_Add">Agregar prospecto para realizar examenes</button>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>DUI</th>
                                    <th>Test #1 (DISC)</th>
                                    <th>Test #2 (Tetramap)</th>
                                    <!-- <th style="text-align: right;">Accion</th> -->
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php 
                                foreach ($candidatos as $candidato) {
                                    echo "<tr>";
                                    echo "<td>".$candidato->nombre_prospecto."</td>";
                                    echo "<td>".$candidato->DUI."</td>";
                                    if($candidato->estado_test1 == 0){
                                        echo "<td>Incompleto</td>";
                                    }else{
                                        echo "<td>Completado
                                        <button class='btn btn-success'>Ver resultados</button>
                                        </td>";
                                    }
                                    if($candidato->estado_test2 == 0){
                                        echo "<td>Incompleto</td>";
                                    }else{
                                        echo "<td>Completado <br>
                                        <a href=".site_url('/Mantenimiento/resultados_tetra/'.$candidato->id_agendar.'')." class='btn btn-success'>Ver resultados</a>
                                        </td>";
                                    }
                                   
                                   
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                
            </div>
        </div>
    </div>
</div>
<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Registrar usuario para realizar test</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
         
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">DUI</label>
                    <div class="col-md-10">
                        <input type="text" name="DUI" id="DUI" class="form-control numbers" placeholder="000000000-0" onkeypress="format_dui(this)" onchange="format_dui(this)">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre</label>
                    <div class="col-md-10">
                        <input type="text" name="prospecto_nombre" id="prospecto_nombre" class="form-control" placeholder="John Doe">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" onClick="guardarProspecto()">Guardar</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->



<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    function format_dui(dui){
      var num_sf= dui.value;
      if (num_sf.length == 8)  {
        num_cf=num_sf+"-";
        //console.log(num_cf);
        dui.value =num_cf;
      }
      else if (num_sf.length > 10)  {
        num_cf=num_sf.slice(0, 10);
        //console.log(num_cf);
        dui.value =num_cf;
      }
    }

    $(document).ready(function(){
        $("input.numbers").keypress(function(event) {
      return /\d/.test(String.fromCharCode(event.keyCode));
    });
        	//call function show all product

        $('#mydata').dataTable( {
            "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
            "iDisplayLength": 5,
            "oLanguage": {
                "sLengthMenu": "Your words here _MENU_ and/or here",
            },
            "oLanguage": {
                "sSearch": "Buscador: "
            }
        } );
    })

    function addTest(){
        console.log('entre')
        $("#Modal_Add").modal('show')
    }
    function guardarProspecto(){
        let DUI = $("#DUI").val()
        let nombreProspecto = $("#prospecto_nombre").val()
        if(nombreProspecto == ''){
            Swal.fire({
                        title: 'Ha ocurrido un error ',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar'
                        });
        }else{
        $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Mantenimiento/guardarTest')?>",
                dataType : "JSON",
                data : {DUI:DUI, nombreProspecto:nombreProspecto},
                success: function(data){
                    if(data == null){
                        Swal.fire({
                        title: 'Prospecto agregado a realizar test',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar'
                        }).then(function() {
                        location.reload();
                        });
                    }else{
                        Swal.fire({
                        title: 'Ha ocurrido un error '+data,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar'
                        });
                    } 
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
        }
    }
</script>
</body>
</html>