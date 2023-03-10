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
                <h2>Agregar nuevo empleado</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                    <nav class="float-right">
                        <div class="col-sm-10"><a href="<?= base_url();?>index.php/Empleado/Agregar/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Nuevo</a></div>
                        <div class="col-sm-2"><a href="<?= base_url();?>index.php/Empleado/Ver/" class="btn btn-success" ><span class="fa fa-search"></span> Ver Empleados</a></div>
                    </nav>
                        <form action="<?= base_url();?>index.php/Empleado/save" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Nombres</label>
                                    <input type="text" name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Apellidos</label>
                                    <input type="text" name="empleado_apellido" id="empleado_apellido" class="form-control" placeholder="Ej: Valladares Quezada">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha Nacimiento</label>
                                    <input type="date" name="empleado_fecha" id="empleado_fecha" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Nacionalidad</label>
                                     <select name="nacionalidad" id="nacionalidad" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($nacionalidad as $nac){
                                        ?>
                                            <option id="<?= ($nacionalidad[$i]->id_nacionalidad);?>" value="<?= ($nacionalidad[$i]->id_nacionalidad);?>"><?php echo($nacionalidad[$i]->pais_nac);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Estado Civil</label>
                                    <select class="form-control" name="empleado_civil" id="empleado_civil" class="form-control">
                                        <option value=0>Soltero/a</option>
                                        <option value=1>Casado/a</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Genero</label>
                                    <select class="form-control" name="genero" id="genero" class="form-control">
                                        <option value=0>Masculino</option>
                                        <option value=1>Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Profesion u Oficio</label>
                                    <input type="text" name="profesion" id="profesion" class="form-control" placeholder="Ej: Estudiante">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">DUI</label>                             
                                    <span ><img src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="Ajax Indicator" /></span>
                                    <label for="empleado_DUI" id="DUICON" class="label label-danger"></label>
                                    <input type="text" data-grouplength="8," name="empleado_dui" id="empleado_dui" class="form-control " placeholder="Ej: #########-#">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Lugar de expedicion</label>
                                    <input type="text" name="dui_expedicion" id="dui_expedicion" class="form-control" placeholder="Ej: Sonsonate,Sonsonate  ">
                                </div>
                               
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha de expedicion</label>
                                    <input type="date" name="dui_fecha_expedicion" id="dui_fecha_expedicion" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">NIT</label>
                                    <input type="text" name="empleado_nit" id="empleado_nit" class="form-control" placeholder="Ej: ####-######-###-#">
                                </div>
                               
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">ISSS</label>
                                    <input type="text" name="empleado_isss" id="empleado_isss" class="form-control" placeholder="Ej: ##########">
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Tipo Fondo de pension</label>
                                    <select class="form-control" name="empleado_fondo" id="empleado_fondo" class="form-control">
                                        <option value=1>AFP</option>
                                        <option value=2>IPSFA</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3" id="afp_act">
                                    <label for="inputEmail4">AFP</label>
                                    <input type="text" name="empleado_afp" id="empleado_afp" class="form-control" placeholder="Ej: ##########">
                                </div>

                                <div class="form-group col-md-3" id="afp_tipo">
                                    <label for="inputState">Tipo de AFP</label>
                                    <select class="form-control" name="fondo_tipo" id="fondo_tipo" class="form-control">
                                        <option value=1>AFP CRECER</option>
                                        <option value=2>AFP CONFIA</option>
                                        <option value=3>UPISSS</option>
                                        <option value=4>NPEP</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group col-md-3" id="ipsfa_act">
                                <label for="inputEmail4">IPSFA</label>
                                <input type="text" name="empleado_ipsfa" id="empleado_ipsfa" class="form-control" placeholder="Ej: ##########">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputAddress2">Domicilio</label>
                                <input type="text" name="domicilio" id="domicilio" class="form-control" placeholder="Ej: San Salvador,San Salvador">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputAddress">Direccion</label>
                                <input type="text" name="empleado_dir" id="empleado_dir" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Direccion 2</label>
                                <input type="text" name="empleado_dir2" id="empleado_dir2" class="form-control" placeholder="Ej: Direccion opcional">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputCity">Correo Electronico</label>
                                    <input type="text" name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputCity">Correo Empresarial</label>
                                    <input type="text" name="empleado_correo_emp" id="empleado_correo_emp" class="form-control" placeholder="Ej: altercredit.armamin@mail.com">
                                </div>
                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Nivel Academico</label>
                                    <select name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($nivel as $a){
                                        
                                        ?>
                                            <option id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Telefono</label>
                                    <input type="text" name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Contacto de Emergencia</label>
                                    <input type="text" name="empleado_con_eme" id="empleado_con_eme" class="form-control" placeholder="Ej: Jose Rodrigo Garcia Lopez">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Telefono Emergencia</label>
                                    <input type="text" name="empleado_cel_eme" id="empleado_cel_eme" class="form-control" placeholder="Ej: ####-####">
                                </div>
                                
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Telefono Empresa</label>
                                    <input type="text" name="empleado_cel_emp" id="empleado_cel_emp" class="form-control" placeholder="Ej: ####-####">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 1</label>
                                    <input type="text" name="depen_uno_emp" id="depen_uno_emp" class="form-control" placeholder="Ej: Maria Sophia Valladares Quezada">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 1</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente1" name="edad_dependiente1" placeholder="25 Años" > 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 1</label>
                                    <select name="paren_uno_emp" id="paren_uno_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                        
                                        ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 1</label>
                                    <input type="text" name="depen_direc1" id="depen_direc1" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 2</label>
                                    <input type="text" name="depen_dos_emp" id="depen_dos_emp" class="form-control" placeholder="Ej: Jose Rodrigo Garcia Lopez">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 2</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente2" name="edad_dependiente2" placeholder="25 Años" > 
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 2</label>
                                    <select name="paren_dos_emp" id="paren_dos_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                        
                                        ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 2</label>
                                    <input type="text" name="depen_direc2" id="depen_direc2" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 3</label>
                                    <input type="text" name="depen_tres_emp" id="depen_tres_emp" class="form-control" placeholder="Ej: Leonel Antonio Lopez Carranza">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 3</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente3" name="edad_dependiente3" placeholder="25 Años" > 
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 3</label>
                                     <select name="paren_tres_emp" id="paren_tres_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                        
                                        ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 3</label>
                                    <input type="text" name="depen_direc3" id="depen_direc3" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="empleado_activo">Empleado Activo</label>
                                    <br>
                                    <input class="form-check-input form-control" type="checkbox" id="empleado_activo" name="empleado_activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-offstyle="danger">

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
        //Se usa para poder habilitar y desabilitar los campos de afp y ipsfa
        load();

        $("#empleado_fondo").change( function() {
             load();
         });//fin .change

        function load(){
            var tipo = $('#empleado_fondo').val();
            if (tipo === "1") {
                $('#afp_act').show();
                $('#afp_tipo').show();
                $('#ipsfa_act').hide();
                $("#empleado_afp").val("");
                $("#fondo_tipo").val("1");
                $("#empleado_ipsfa").val("");

            } else {
                $('#afp_act').hide();
                $('#afp_tipo').hide();
                $('#ipsfa_act').show();
                $("#empleado_afp").val("");
                $("#fondo_tipo").val("1");
                $("#empleado_ipsfa").val("");

            }
        };

    });//Fin Jquery
</script>
</body>
</html>