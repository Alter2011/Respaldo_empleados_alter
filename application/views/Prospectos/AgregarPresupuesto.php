<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->

<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Agregar presupuesto anual de carteras</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                    <nav class="float-right">
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2"><a href="<?= base_url();?>index.php/permisos" class="btn btn-success" ><span class="fa fa-search"></span> Ver Presupuesto</a></div>
                    </nav>
                        <form action="<?= base_url();?>index.php/permisos/savePresupuesto" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputvalor">Valor</label>
                                    <input type="number" step="any" pattern="(\d{3})([\.])(\d{2})" name="presu_valor" id="presu_valor" class="form-control" placeholder="15,800.00">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCartera">Cartera</label>
                                    <input type="number" step="1" name="cartera" id="cartera" class="form-control" placeholder="01021">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputIndice">Indice Eficiencia</label>
                                    <input type="number" name="presu_indice" id="presu_indice" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputFecha">Fecha</label>
                                    <input type="date" name="presu_fecha" id="presu_fecha" class="form-control">
                                </div>

                            </div>
                            
                            <!--
                            <div class="form-row">
                                <label class="col-md-2 col-form-label">Foto</label>
                                <div class="col-md-10">
                                    <input type="file" name="cargo_salario_edit" id="cargo_salario_edit" class="form-control" placeholder="Ingresa cambio">
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-10">
                                    <!--Vacio-->
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Borrar</button>
                                </div>
                                <div class="form-group col-md-1">
                                    <button  type="submit" id="btn_agregar" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
i = 0;

    $(document).ready(function(){
        $('#loading').hide(); 

        //function DUI EXISTE
        function R_DUI(){
            $('#loading').show();

            var cargo_name = $("#empleado_dui").val();
            var code = $("#empleado_dui").val();
            var name = $("#empleado_dui").val();
            console.log(code);
		    $.ajax({
                type : "POST",
		        url   : '<?php echo site_url('Empleado/Existe')?>',
		        async : false,
		        dataType : 'json',
                data : { code:code,name:name},

		        success : function(data){
                    console.log(data);

                    $("#DUICON").text(data);
		        },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
		    });
		}

        $( "#empleado_dui" ).keyup(function(){
            $('#loading').fadeIn(3000);

            var code = $("#empleado_dui").val();
            var name = $("#empleado_dui").val();
            console.log(code);
		    $.ajax({
		        type  : 'POST',
		        url   : '<?php echo site_url('Empleado/Existe')?>',
		        async : false,
		        dataType : 'json',
                data : { code:code},

		        success : function(data){
                    console.log(data);
                    //console.log();
if(data==""){
    $("#DUICON").text("");
    $('#loading').fadeOut(3000);

}else{
//$('#loading').fadeOut(3000);
$('#loading').fadeOut("fast",function (){
        $("#DUICON").text("   Este DUI le pertenece a: "+data[0].nombre);
    });
}

		        },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
		    });
            //$("#DUICON").text($("#empleado_dui").val());
        });


    });//Fin Jquery
</script>
</body>
</html>