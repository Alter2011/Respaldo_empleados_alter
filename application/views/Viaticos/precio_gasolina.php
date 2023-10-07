<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Mantenimientos</h2>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Precios de combustibles</a></li>
        <li><a data-toggle="tab" href="#menu1">Motocicleta reconocida</a></li>
        <li><a data-toggle="tab" href="#menu2">Depreciación</a></li>
        <li><a data-toggle="tab" href="#menu3">Limite de viaticos por agencia</a></li>
    </ul>

    <div class="tab-content">
        <br>
        <!--<nav class="float-right">
            <div class="col-sm-12">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="month" name="mes_combustible" class="form-control" value="<?= date('Y-m') ?>">
                    </div>
                     <div class="form-group col-md-3">
                         <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar">Aceptar</a></center>
                     </div>
                </div>
            </div>
        </nav><br><br><br>-->

        <div id="menu3" class="tab-pane fade">
            <div class="col-sm-10">
                <div class="col-sm-12">
                    <div class="col-sm-6">


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Agencia:</label>
                            <div class="col-md-5">
                                <select class="form-control" name="agencia_v" id="agencia_v"
                                    onchange="seleccionar_ag()">
                                    <option value="">Seleccionar una agencia</option>
                                    <?php
                                    foreach ($agencias as $agencia) {
                                        if ($agencia->id_agencia != '00') {
                                            ?>
                                            <option value="<?= ($agencia->id_agencia); ?>">
                                                <?php echo ($agencia->agencia); ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Viaticos de cartera por agencia:</label>
                            <div class="col-md-5">
                                <input type="text" name="viaticos_agencia" id="viaticos_agencia" class="form-control">
                                <div id="validacion_calculadora" style="color:red"></div>
                            </div>
                        </div>






                    </div>


                    <div class="col-sm-6">



                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Limite de viaticos extra:</label>
                            <div class="col-md-5">
                                <input type="text" name="limite_viaticos" id="limite_viaticos" class="form-control"
                                    onchange="revisar_input()">
                                    <p id="mensajeError" style="color: red;"></p>
                                <div id="validacion_calculadora" style="color:red"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Total de viaticos por agencia:</label>
                            <div class="col-md-5">
                                <input type="text" name="total_viaticos" id="total_viaticos" class="form-control">
                                <div id="validacion_calculadora" style="color:red"></div>
                            </div>
                        </div>



                    </div>





                    <div class="col-md-3">
                        <a onclick="sendLimiteViaticos()" class="btn btn-primary" id="calcular"><span class="glyphicon glyphicon-phone"></span>Guardar</a>


                    </div>

                </div>
            </div>
        </div>

        <div id="home" class="tab-pane fade in active">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered" id="mydata">
                        <thead>
                            <tr class="success">
                                <th style="text-align:center;">Zona</th>
                                <th style="text-align:center;">Gasolina</th>
                                <th style="text-align:center;">Variación</th>
                                <th style="text-align:center;">Estado</th>
                                <th style="text-align:center;">Fecha ingreso</th>
                                <th style="text-align:center;">Accion</th>
                            </tr>
                        </thead>
                        <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                            <?php
                            for ($i = 0; $i < count($combustible); $i++) {
                                if ($combustible[$i]->tipo_variacion == 2) {
                                    $tipo_var = 'glyphicon glyphicon-arrow-up';
                                    $color = 'red';
                                } else if ($combustible[$i]->tipo_variacion == 3) {
                                    $tipo_var = 'glyphicon glyphicon-arrow-down';
                                    $color = 'blue';
                                } else {
                                    $tipo_var = '';
                                    $color = '';
                                }

                                if ($combustible[$i]->estado == 1) {
                                    $estado = 'Activo';
                                } else if ($combustible[$i]->estado == 0) {
                                    $estado = 'Inactivo';
                                }

                                echo '<tr>';
                                echo '<td>' . $combustible[$i]->nombre_zona . '</td>';
                                echo '<td>$' . number_format($combustible[$i]->precio, 2) . '</td>';
                                echo '<td style="color:' . $color . ';"><span class="' . $tipo_var . '"></span> $' . number_format($combustible[$i]->variacion, 2) . '</td>';
                                echo '<td>' . $estado . '</td>';
                                echo '<td>' . $combustible[$i]->fecha_ingreso . '</td>';
                                echo '<td>';
                                echo '<a class="btn btn-success" onclick="datos_gasolina(' . $combustible[$i]->id_precio . ')"><span class="glyphicon glyphicon-pencil"></span> Editar</a> ';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="menu1" class="tab-pane fade">
            <table class="table table-bordered" id="motocicleta">
                <thead>
                    <tr class="success">
                        <th style="text-align:center;">Modelo</th>
                        <th style="text-align:center;">Consumo km/gal</th>
                        <th style="text-align:center;">Precio</th>
                        <th style="text-align:center;">Llanta delantera</th>
                        <th style="text-align:center;">Llanta trasera</th>
                        <th style="text-align:center;">Mant. Base</th>
                        <th style="text-align:center;">Mant. mayor</th>
                        <th style="text-align:center;">T. vida (años)</th>
                        <th style="text-align:center;">Km uso</th>
                        <th style="text-align:center;">Accion</th>
                    </tr>
                </thead>
                <tbody id="show_moto">
                    <?php
                    for ($i = 0; $i < count($moto); $i++) {
                        echo '<tr>';
                        echo '<td>' . $moto[$i]->modelo . '</td>';
                        echo '<td>' . number_format($moto[$i]->consumo_gal, 2) . '</td>';
                        echo '<td>$' . number_format($moto[$i]->precio, 2) . '</td>';
                        echo '<td>$' . number_format($moto[$i]->llanta_delantera, 2) . '</td>';
                        echo '<td>$' . number_format($moto[$i]->llanta_tracera, 2) . '</td>';
                        echo '<td>$' . number_format($moto[$i]->mantenimiento_base, 2) . '</td>';
                        echo '<td>$' . number_format($moto[$i]->mantenimiento_mayor, 2) . '</td>';
                        echo '<td>' . number_format($moto[$i]->tiempo_vida, 2) . '</td>';
                        echo '<td>' . number_format($moto[$i]->km_uso, 2) . '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-success" onclick="datos_moto(' . $moto[$i]->id_motocicleta . ')"><span class="glyphicon glyphicon-pencil"></span> Editar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="menu2" class="tab-pane fade">
            <table class="table table-bordered" id="depreciacion">
                <thead>
                    <tr class="success">
                        <th style="text-align:center;">Item</th>
                        <th style="text-align:center;">Valor</th>
                        <th style="text-align:center;">Meses</th>
                        <th style="text-align:center;">Mensual</th>
                        <th style="text-align:center;">Accion</th>
                    </tr>
                </thead>
                <tbody id="show_depreciacion">
                    <?php
                    for ($i = 0; $i < count($depreciacion); $i++) {
                        echo '<tr>';
                        echo '<td>' . $depreciacion[$i]->item . '</td>';
                        echo '<td>$ ' . number_format($depreciacion[$i]->valor, 2) . '</td>';
                        echo '<td>' . $depreciacion[$i]->meses . '</td>';
                        echo '<td>$ ' . number_format($depreciacion[$i]->mesual, 2) . '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-success" onclick="datos_depreciacion(' . $depreciacion[$i]->id_depreciacion . ')"><span class="glyphicon glyphicon-pencil"></span> Editar</a> ';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>



</div>





<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">
                        <center>Editar precio de combustible</center>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="validacion_edit" style="color:red"></div>
                            <input type="hidden" name="codigo_precio" id="codigo_precio" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Zona:</label>
                        <div class="col-md-10">
                            <select class="form-control" name="zona_edit" id="zona_edit" disabled>
                                <option value="1">Central</option>
                                <option value="2">Occidental</option>
                                <option value="3">Oriental</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Precio($):</label>
                        <div class="col-md-10">
                            <input type="text" name="precio_edit" id="precio_edit" class="form-control"
                                placeholder="Precio ">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false"
                        onclick="editar_gasolina()">Guardar</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_moto_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">
                        <center>Editar motocicleta</center>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="validacion_moto_edit" style="color:red"></div>
                            <input type="hidden" name="codigo_moto" id="codigo_moto" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Modelo:</label>
                        <div class="col-md-10">
                            <input type="text" name="modelo_edit" id="modelo_edit" class="form-control"
                                placeholder="Modelo">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Consumo km/gal:</label>
                        <div class="col-md-10">
                            <input type="text" name="consumo_edit" id="consumo_edit" class="form-control"
                                placeholder="Consumo km/gal">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Precio:</label>
                        <div class="col-md-10">
                            <input type="text" name="precio_moto_edit" id="precio_moto_edit" class="form-control"
                                placeholder="Precio">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">llanta delantera:</label>
                        <div class="col-md-10">
                            <input type="text" name="llantas_del_edit" id="llantas_del_edit" class="form-control"
                                placeholder="llantas delanteras">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">llanta tracera:</label>
                        <div class="col-md-10">
                            <input type="text" name="llantas_tra_edit" id="llantas_tra_edit" class="form-control"
                                placeholder="llantas traceras">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Mant. Base:</label>
                        <div class="col-md-10">
                            <input type="text" name="mant_b_edit" id="mant_b_edit" class="form-control"
                                placeholder="Mant. Base">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Mant. mayor:</label>
                        <div class="col-md-10">
                            <input type="text" name="mant_m_edit" id="mant_m_edit" class="form-control"
                                placeholder="Mant. mayor">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">T. vida (años):</label>
                        <div class="col-md-10">
                            <input type="text" name="anio_edit" id="anio_edit" class="form-control"
                                placeholder="T. vida (años)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Km uso:</label>
                        <div class="col-md-10">
                            <input type="text" name="km_edit" id="km_edit" class="form-control"
                                placeholder="T. vida (años)">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false"
                        onclick="editar_motocicleta()">Guardar</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_depreciacion_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">
                        <center>Editar depreciación</center>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="validacion_depreciacion_edit" style="color:red"></div>
                            <input type="hidden" name="codigo_depreciacion" id="codigo_depreciacion"
                                class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Item:</label>
                        <div class="col-md-10">
                            <input type="text" name="item_edit" id="item_edit" class="form-control" placeholder="Item">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Valor ($):</label>
                        <div class="col-md-10">
                            <input type="text" name="valor_edit" id="valor_edit" class="form-control"
                                placeholder="Valor">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Meses:</label>
                        <div class="col-md-10">
                            <input type="number" name="meses_edit" id="meses_edit" class="form-control"
                                placeholder="Meses">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Mensual ($):</label>
                        <div class="col-md-10">
                            <input type="text" name="mensual_edit" id="mensual_edit" class="form-control"
                                placeholder="Mensual">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false"
                        onclick="editar_depreciacion()">Guardar</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<script type="text/javascript">
    $(function () {
        $('#precio_edit').maskMoney();
        $('#consumo_edit').maskMoney();
        $('#precio_moto_edit').maskMoney();
        $('#llantas_del_edit').maskMoney();
        $('#llantas_tra_edit').maskMoney();
        $('#mant_b_edit').maskMoney();
        $('#mant_m_edit').maskMoney();
        $('#anio_edit').maskMoney();
        $('#km_edit').maskMoney();
        $('#valor_edit').maskMoney();
        $('#mensual_edit').maskMoney();
        $('#participacion_edit').maskMoney();
    })

    function seleccionar_precio() {
        $('#mydata').DataTable().destroy();
        $('#mydata #show_data').empty();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/viaticos_datos') ?>",
            dataType: "JSON",
            data: {},
            success: function (data) {
                $.each(data, function (key, registro) {
                    if (registro.tipo_variacion == 2) {
                        tipo_var = 'glyphicon glyphicon-arrow-up';
                        color = 'red';
                    } else if (registro.tipo_variacion == 3) {
                        tipo_var = 'glyphicon glyphicon-arrow-down';
                        color = 'blue';
                    } else {
                        tipo_var = '';
                        color = '';
                    }

                    $("#show_data").append(
                        '<tr>' +
                        '<td>' + registro.nombre_zona + '</td>' +
                        '<td>' + parseFloat(registro.precio).toFixed(2) + '</td>' +
                        '<td style="color:' + color + ';"><span class="' + tipo_var + '"></span> $' + parseFloat(registro.variacion).toFixed(2) + '</td>' +
                        '<td>' + registro.fecha_ingreso + '</td>' +
                        '<td>' +
                        '<a class="btn btn-success" onclick=datos_gasolina(' + registro.id_precio + ')><span class="glyphicon glyphicon-pencil"></span> Editar</a>' +
                        '</td>' +
                        '</tr>'
                    );
                });
            },

            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function datos_gasolina(precio) {
        document.getElementById('validacion_edit').innerHTML = '';
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/get_precios') ?>",
            dataType: "JSON",
            data: { precio: precio },
            success: function (data) {
                $('[name="codigo_precio"]').val(precio);
                $('[name="zona_edit"]').val(data[0].zona);
                $('[name="precio_edit"]').val(parseFloat(data[0].precio).toFixed(2));

                $('#Modal_Edit').modal('show');
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function editar_gasolina() {
        var codigo_precio = $('#codigo_precio').val();
        var precio_edit = $('#precio_edit').val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/edit_gasolina') ?>",
            dataType: "JSON",
            data: { codigo_precio: codigo_precio, precio_edit: precio_edit },
            success: function (data) {
                if (data == null) {
                    Swal.fire(
                        'Precio de combustible editado correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion_edit').innerHTML = '';
                    $("#Modal_Edit").modal('toggle');
                    seleccionar_precio();
                } else {
                    document.getElementById('validacion_edit').innerHTML = data;
                }
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function datos_moto(id_motocicleta) {
        document.getElementById('validacion_moto_edit').innerHTML = '';
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/get_motos') ?>",
            dataType: "JSON",
            data: { id_motocicleta: id_motocicleta },
            success: function (data) {
                $('[name="codigo_moto"]').val(id_motocicleta);
                $('[name="modelo_edit"]').val(data[0].modelo);
                $('[name="consumo_edit"]').val(parseFloat(data[0].consumo_gal).toFixed(2));
                $('[name="precio_moto_edit"]').val(parseFloat(data[0].precio).toFixed(2));
                $('[name="llantas_del_edit"]').val(parseFloat(data[0].llanta_delantera).toFixed(2));
                $('[name="llantas_tra_edit"]').val(parseFloat(data[0].llanta_tracera).toFixed(2));
                $('[name="mant_b_edit"]').val(parseFloat(data[0].mantenimiento_base).toFixed(2));
                $('[name="mant_m_edit"]').val(parseFloat(data[0].mantenimiento_mayor).toFixed(2));
                $('[name="anio_edit"]').val(parseFloat(data[0].tiempo_vida).toFixed(2));
                $('[name="km_edit"]').val(parseFloat(data[0].km_uso).toFixed(2));

                $('#Modal_moto_Edit').modal('show');
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function editar_motocicleta() {
        var codigo = $('#codigo_moto').val();
        var modelo = $('#modelo_edit').val();
        var consumo = $('#consumo_edit').val();
        var precio_moto = $('#precio_moto_edit').val();
        var llantas_del = $('#llantas_del_edit').val();
        var llantas_tra = $('#llantas_tra_edit').val();
        var mant_b = $('#mant_b_edit').val();
        var mant_m = $('#mant_m_edit').val();
        var anio = $('#anio_edit').val();
        var km = $('#km_edit').val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/edit_motocicleta') ?>",
            dataType: "JSON",
            data: { codigo: codigo, modelo: modelo, consumo: consumo, precio_moto: precio_moto, llantas_del: llantas_del, llantas_tra: llantas_tra, mant_b: mant_b, mant_m: mant_m, anio: anio, km: km },
            success: function (data) {
                if (data == null) {
                    Swal.fire(
                        'Motocicleta editada correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion_moto_edit').innerHTML = '';
                    $("#Modal_moto_Edit").modal('toggle');
                    seleccionar_moto();
                } else {
                    document.getElementById('validacion_moto_edit').innerHTML = data;
                }
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function seleccionar_moto() {
        $('#motocicleta').DataTable().destroy();
        $('#motocicleta #show_moto').empty();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/motos_datos') ?>",
            dataType: "JSON",
            data: {},
            success: function (data) {
                $.each(data, function (key, registro) {
                    $("#show_moto").append(
                        '<tr>' +
                        '<td>' + registro.modelo + '</td>' +
                        '<td>' + parseFloat(registro.consumo_gal).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.precio).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.llanta_delantera).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.llanta_tracera).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.mantenimiento_base).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.mantenimiento_mayor).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.tiempo_vida).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(registro.km_uso).toFixed(2) + '</td>' +
                        '<td>' +
                        '<a class="btn btn-success" onclick=datos_moto(' + registro.id_motocicleta + ')><span class="glyphicon glyphicon-pencil"></span> Editar</a>' +
                        '</td>' +
                        '</tr>'
                    );
                });
            },

            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function datos_depreciacion(id_depreciacion) {
        document.getElementById('validacion_moto_edit').innerHTML = '';
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/get_depreciacion') ?>",
            dataType: "JSON",
            data: { id_depreciacion: id_depreciacion },
            success: function (data) {
                $('[name="codigo_depreciacion"]').val(id_depreciacion);
                $('[name="item_edit"]').val(data[0].item);
                $('[name="valor_edit"]').val(parseFloat(data[0].valor).toFixed(2));
                $('[name="meses_edit"]').val(data[0].meses);
                $('[name="mensual_edit"]').val(parseFloat(data[0].mesual).toFixed(2));

                $('#Modal_depreciacion_Edit').modal('show');
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function editar_depreciacion() {
        var codigo = $('#codigo_depreciacion').val();
        var item = $('#item_edit').val();
        var valor = $('#valor_edit').val();
        var meses = $('#meses_edit').val();
        var mensual = $('#mensual_edit').val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/edit_depreciacion') ?>",
            dataType: "JSON",
            data: { codigo: codigo, item: item, valor: valor, meses: meses, mensual: mensual },
            success: function (data) {
                if (data == null) {
                    Swal.fire(
                        'Depreciacion editada correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion_depreciacion_edit').innerHTML = '';
                    $("#Modal_depreciacion_Edit").modal('toggle');
                    seleccionar_depreciacion();
                } else {
                    document.getElementById('validacion_depreciacion_edit').innerHTML = data;
                }
            },
            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function seleccionar_depreciacion() {
        $('#depreciacion').DataTable().destroy();
        $('#depreciacion #show_depreciacion').empty();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/depreciacion_datos') ?>",
            dataType: "JSON",
            data: {},
            success: function (data) {
                $.each(data, function (key, registro) {
                    $("#show_depreciacion").append(
                        '<tr>' +
                        '<td>' + registro.item + '</td>' +
                        '<td>' + parseFloat(registro.valor).toFixed(2) + '</td>' +
                        '<td>' + registro.meses + '</td>' +
                        '<td>' + parseFloat(registro.mesual).toFixed(2) + '</td>' +
                        '<td>' +
                        '<a class="btn btn-success" onclick=datos_depreciacion(' + registro.id_depreciacion + ')><span class="glyphicon glyphicon-pencil"></span> Editar</a>' +
                        '</td>' +
                        '</tr>'
                    );
                });
            },

            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }
    function seleccionar_ag() {
        agencia = $('#agencia_v').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/calcular_viatico_agencia') ?>",
            dataType: "JSON",
            data: { agencia: agencia },
            success: function (data) {
                console.log(data)
                $("#viaticos_agencia").val(data.totalViaticosAgencia.toFixed(2))
                $("#limite_viaticos").val(data.limite_viaticos_extra[0].limite_viaticos_extra)
                $("#total_viaticos").val(parseFloat(data.sumaTotal).toFixed(2) )
            },

            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }
    function revisar_input() {
        var valorInput = $("#limite_viaticos").val();
        const patronNumerico = /^[0-9]*(\.[0-9]+)?$/;

            if (!patronNumerico.test(valorInput)) {
                document.getElementById("mensajeError").textContent = "¡Ingrese solo valores numéricos!";
                $("#limite_viaticos").val(""); // Limpiar el valor no válido
            } else {
                document.getElementById("mensajeError").textContent = "";
                var viaticosAgencia = $("#viaticos_agencia").val()
                $("#total_viaticos").val(parseFloat(valorInput) + parseFloat(viaticosAgencia))

            }
    }

    function sendLimiteViaticos(){
        var limiteViaticos = $("#limite_viaticos").val();
        var agencia = $("#agencia_v").val();
        if( limiteViaticos != ''){

        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Viaticos/limite_viaticos') ?>",
            dataType: "JSON",
            data: { limiteViaticos: limiteViaticos, agencia: agencia },
            success: function (data) {
                if (data == null) {
                    Swal.fire(
                        'Limite de viaticos editado correctamente!',
                        '',
                        'success'
                    )
                    $("#limite_viaticos").val("");
                    $("#viaticos_agencia").val("");
                    $("#total_viaticos").val("");
                } else {
                    document.getElementById('validacion_edit').innerHTML = data;
                }
            },

            error: function (data) {
                var a = JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }else{
        Swal.fire(
                        'Ingrese un valor!',
                        '',
                        'warning'
                    )
    }
    }
   

</script>