<!DOCTYPE html>
<html lang="es">
<head>
    <title>Empleados AlterCredit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link media="all" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.maskMoney.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link media="all" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link media="all" rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/altercredit.css?'.time();?>">

    <!-- css y js del login -->
    <script src="<?php echo base_url(); ?>assets/js/material.min.js"></script>

    <!--Para utilizar Checkbox Toogle-->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"/>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!--Para utilizar Checkbox Toogle-->

        <!--Para utilizar material-icons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material/material-icons.css">
        <!--Para utilizar material-icons -->

    <!--Se Utiliza para dar estilo a la impresion de los permisos-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/impresion.css">

    <!-- Libreria que solo se utiliza para el icono del calendario-->
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    <!-- Libreria para dar el estilo al calendario -->
<!--    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/calendario/bootstrap-iso.css">-->


    <script src="<?php echo base_url(); ?>assets/js/material.min.js"></script>
    <!--<script src='https://kit.fontawesome.com/a076d05399.js'></script>-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/alert.css" />
    <script src="<?php echo base_url(); ?>assets/js/cute-alert.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">


    <script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
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
</script>
</script>
</head>
<body>
