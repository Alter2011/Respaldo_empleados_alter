<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->
<?php //print_r($empleado[0]); ?>

        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Modificar Empleado</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                    <nav class="float-right">
                        <div class="col-sm-10"><a href="<?= base_url();?>index.php/Empleado/Agregar/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Nuevo</a></div>
                        <div class="col-sm-2"><a href="<?= base_url();?>index.php/Empleado/Ver/" class="btn btn-success" ><span class="fa fa-search"></span> Ver Empleados</a></div>
                    </nav>
                        <form action="<?= base_url();?>index.php/Empleado/update/" enctype="multipart/form-data" method="post" accept-charset="utf-8" id="formulario">
                            <div clas="form-row">
                            <input type="hidden" readonly name="empleado_id" id="empleado_id" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->id_empleado;?>">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Nombres</label>
                                    <input type="text" name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->nombre;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Apellidos</label>
                                    <input type="text" name="empleado_apellido" id="empleado_apellido" class="form-control" placeholder="Ej: Valladares Quezada" value="<?= $empleado[0]->apellido;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha Nacimiento</label>
                                    <input type="date" name="empleado_fecha" id="empleado_fecha" class="form-control" value="<?= $empleado[0]->fecha_nac;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Nacionalidad</label>
                                     <select name="nacionalidad" id="nacionalidad" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($nacionalidad as $a){
                                            if ($empleado[0]->nacionalidad==$nacionalidad[$i]->id_nacionalidad)
                                            {
                                            ?>
                                            <option selected id="<?= ($nacionalidad[$i]->id_nacionalidad);?>" value="<?= ($nacionalidad[$i]->id_nacionalidad);?>"><?php echo($nacionalidad[$i]->pais_nac);?></option>
                                    <?php 
                                            }else{
                                    ?>
                                            <option id="<?= ($nacionalidad[$i]->id_nacionalidad);?>" value="<?= ($nacionalidad[$i]->id_nacionalidad);?>"><?php echo($nacionalidad[$i]->pais_nac);?></option>
                                    <?php
                                        }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Estado Civil</label>
                                    <select class="form-control" name="empleado_civil" id="empleado_civil" class="form-control">
                                    <?php
                                    if($empleado[0]->estado_civil==0){
                                        ?>
                                        <option selected value=0>Soltero/a</option>
                                        <option value=1>Casado/a</option>
                                    <?php
                                    }else{
                                    ?>
                                        <option value=0>Soltero/a</option>
                                        <option selected value=1>Casado/a</option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Profesion u Oficio</label>
                                    <input type="text" name="profesion" id="profesion" class="form-control" placeholder="Ej: Estudiante" value="<?= $empleado[0]->profesion_oficio;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Genero</label>
                                    <select class="form-control" name="genero" id="genero" class="form-control">
                                        <?php if ($empleado[0]->genero==0) { ?>
                                            <option selected value="0">Masculino</option>
                                            <option value="1">Femenino</option>
                                       <?php }else{ ?>
                                            <option value="0">Masculino</option>
                                            <option selected value="1">Femenino</option>
                                       <?php } ?>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputoFoto">URL foto</label>                             
                                    <label for="empleado_foto" id="FOTO" class="label label-danger" ></label>
                                    <input type="text" data-grouplength="8," name="empleado_foto" id="empleado_foto" class="form-control " placeholder="Ej: https://drive.com" value="<?= $empleado[0]->foto;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">DUI</label>                             
                                    <label for="empleado_DUI" id="DUICON" class="label label-danger" ></label>
                                    <input type="text" data-grouplength="8," name="empleado_dui" id="empleado_dui" class="form-control " placeholder="Ej: #########-#" value="<?= $empleado[0]->dui;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Lugar de expedicion</label>
                                    <input type="text" name="dui_expedicion" id="dui_expedicion" class="form-control" placeholder="Ej: Sonsonate,Sonsonate" value="<?= $empleado[0]->lugar_expedicion_dui;?>">
                                </div>
                               
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Fecha de expedicion</label>
                                    <input type="date" name="dui_fecha_expedicion" id="dui_fecha_expedicion" class="form-control" value="<?= $empleado[0]->fecha_expedicion_dui;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">NIT</label>
                                    <input type="text" name="empleado_nit" id="empleado_nit" class="form-control" placeholder="Ej: ####-######-###-#" value="<?= $empleado[0]->nit;?>">
                                </div>
                            <?php if((strlen($empleado[0]->afp)==0 && strlen($empleado[0]->ipsfa)==0) || strlen($empleado[0]->afp)>0){ ?>
                                <div class="form-group col-md-3" id="afp">
                                    <label for="inputEmail4">AFP</label>
                                    <input type="text" name="empleado_afp" id="empleado_afp" class="form-control" placeholder="Ej: ##########" value="<?= $empleado[0]->afp;?>">
                                </div>

                                <div class="form-group col-md-3" id="afp_tipo">
                                    <label for="inputState">Tipo de AFP</label>
                                    <select class="form-control" name="fondo_tipo" id="fondo_tipo" class="form-control">
                                    <?php if ($empleado[0]->tipo_afp==1) { ?>
                                        <option selected value=1>AFP CRECER</option>
                                        <option value=2>AFP CONFIA</option>
                                        <option value=3>UPISSS</option>
                                        <option value=4>NPEP</option>
                                    <?php }else if ($empleado[0]->tipo_afp==2) { ?>
                                        <option value=1>AFP CRECER</option>
                                        <option selected value=2>AFP CONFIA</option>
                                        <option value=3>UPISSS</option>
                                        <option value=4>NPEP</option>
                                    <?php }else if ($empleado[0]->tipo_afp==3) { ?>
                                        <option value=1>AFP CRECER</option>
                                        <option value=2>AFP CONFIA</option>
                                        <option selected value=3>UPISSS</option>
                                        <option value=4>NPEP</option>
                                    <?php }else if ($empleado[0]->tipo_afp==4) { ?>
                                        <option value=1>AFP CRECER</option>
                                        <option value=2>AFP CONFIA</option>
                                        <option value=3>UPISSS</option>
                                        <option selected value=4>NPEP</option>
                                    <?php }else{ ?>
                                        <option value=1>AFP CRECER</option>
                                        <option value=2>AFP CONFIA</option>
                                        <option value=3>UPISSS</option>
                                        <option value=4>NPEP</option>
                                    <?php } ?>

                                    </select>
                                </div>
                            <?php }else if(strlen($empleado[0]->ipsfa) > 0){ ?>
                                <div class="form-group col-md-3" id="ipsfa">
                                    <label for="inputEmail4">IPDFA</label>
                                    <input type="text" name="empleado_ipsfa" id="empleado_ipsfa" class="form-control" placeholder="Ej: ##########" value="<?= $empleado[0]->ipsfa;?>">
                                </div>
                            <?php } ?>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">ISSS</label>
                                    <input type="text" name="empleado_isss" id="empleado_isss" class="form-control" placeholder="Ej: ##########" value="<?= $empleado[0]->isss;?>">
                                </div>
                            <div class="form-group col-md-3">
                                <label for="inputAddress2">Domicilio</label>
                                <input type="text" name="domicilio" id="domicilio" class="form-control" placeholder="Ej: San Salvador,San Salvador" value="<?= $empleado[0]->domicilio;?>">
                            </div>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Direccion</label>
                                <input type="text" name="empleado_dir" id="empleado_dir" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27" value="<?= $empleado[0]->direccion1;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Direccion 2</label>
                                <input type="text" name="empleado_dir2" id="empleado_dir2" class="form-control" placeholder="Ej: Direccion opcional" value="<?= $empleado[0]->direccion2;?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                <label for="inputCity">Correo Electronico</label>
                                <input type="text" name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com" value="<?= $empleado[0]->correo_personal;?>">
                                </div>
                                <div class="form-group col-md-3">
                                <label for="inputCity">Correo Empresarial</label>
                                <input type="text" name="empleado_correo_emp" id="empleado_correo_emp" class="form-control" placeholder="Ej: altercredit.armamin@mail.com" value="<?= $empleado[0]->correo_empresa;?>">
                                </div>
                                <div class="form-group col-md-6">
                                <label for="inputState">Nivel Academico</label>
                                    <select name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price"value="<?= $empleado[0]->correo_empresa;?>">
                                        <?php
                                        $i=0;
                                        foreach($nivel as $a){
                                            if($empleado[0]->id_nivel==$nivel[$i]->id_nivel)
                                            {
                                            ?>
                                                <option selected id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                                <?php
                                            }else
                                            {
                                                ?>
                                                <option id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                            <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                <label for="inputState">Telefono</label>
                                <input type="text" name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####" value="<?= $empleado[0]->tel_personal;?>">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Telefono Emergencia</label>
                                    <input type="text" name="empleado_cel_eme" id="empleado_cel_eme" class="form-control" placeholder="Ej: ####-####" value="<?= $empleado[0]->tel_emergencia;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Telefono Empresa</label>
                                    <input type="text" name="empleado_cel_emp" id="empleado_cel_emp" class="form-control" placeholder="Ej: ####-####" value="<?= $empleado[0]->tel_empresa;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 1</label>
                                    <input type="text" name="depen_uno_emp" id="depen_uno_emp" class="form-control" placeholder="Ej: Maria Sophia Valladares Quezada" value="<?= $empleado[0]->dependiente1;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 1</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente1" name="edad_dependiente1" placeholder="25 Años" value="<?= $empleado[0]->edad_dependiente1;?>"> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 1</label>
                                    <select name="paren_uno_emp" id="paren_uno_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                            if ($empleado[0]->parentesco1==$parentesco[$i]->parentesco)
                                            {
                                            ?>
                                            <option selected id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php 
                                            }else{
                                    ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php
                                        }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 1</label>
                                    <input type="text" name="depen_direc1" id="depen_direc1" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27" value="<?= $empleado[0]->dependiente_direccion1;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 2</label>
                                    <input type="text" name="depen_dos_emp" id="depen_dos_emp" class="form-control" placeholder="Ej: Jose Rodrigo Garcia Lopez" value="<?= $empleado[0]->dependiente2;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 2</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente2" name="edad_dependiente2" placeholder="25 Años" value="<?= $empleado[0]->edad_dependiente2;?>"> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 2</label>
                                    <select name="paren_dos_emp" id="paren_dos_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                            if ($empleado[0]->parentesco2==$parentesco[$i]->parentesco)
                                            {
                                            ?>
                                            <option selected id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php 
                                            }else{
                                    ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php
                                        }
                                            $i++;
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 2</label>
                                    <input type="text" name="depen_direc2" id="depen_direc2" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27" value="<?= $empleado[0]->dependiente_direccion2;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 3</label>
                                    <input type="text" name="depen_tres_emp" id="depen_tres_emp" class="form-control" placeholder="Ej: Leonel Antonio Lopez Carranza" value="<?= $empleado[0]->dependiente3;?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Edad Dependiente 3</label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="edad_dependiente3" name="edad_dependiente3" placeholder="25 Años" value="<?= $empleado[0]->edad_dependiente3;?>"> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 3</label>
                                     <select name="paren_tres_emp" id="paren_tres_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                            if ($empleado[0]->parentesco3==$parentesco[$i]->parentesco)
                                            {
                                            ?>
                                            <option selected id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php 
                                            }else{
                                    ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                    <?php
                                        }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 3</label>
                                    <input type="text" name="depen_direc3" id="depen_direc3" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27" value="<?= $empleado[0]->dependiente_direccion3;?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="empleado_activo">Empleado Activo</label><br>
                                <?php
                                if($empleado[0]->activo==1){
                                    ?>
                                    <input class="form-check-input form-control" type="checkbox" id="empleado_activo" name="empleado_activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-offstyle="danger" checked>
                                <?php
                                }else{
                                ?>
                                    <input class="form-check-input form-control" type="checkbox" id="empleado_activo" name="empleado_activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-offstyle="danger">
                                <?php
                                }
                                ?>
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
                                    
                                </div>
                                <div class="form-group col-md-1">
                                    <button  type="submit" id="btn_modificar" class="btn btn-primary">Modificar</button>
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
                            
    //NO1702023 esta funcion sirve para prevenir el comportamiento predeterminado del formulario para que no se mande por defecto, entonces se separa el url de la foto para modificarlo y que dicha url sirva para etiquetas embebidas
    $(document).ready(function(){
        $('#loading').hide();
        const formulario = document.querySelector("#formulario")
        formulario.addEventListener('submit', function(e){
            e.preventDefault();
            var url_foto = $("#empleado_foto").val()
            const separador = "/"
            var foto_array = url_foto.split(separador)
            foto_array[foto_array.length-1] = 'preview'
            var nueva_url_foto = foto_array.join(separador)
            $("#empleado_foto").val(nueva_url_foto)
            formulario.submit();
        }) 

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