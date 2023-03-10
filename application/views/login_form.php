<html>
    <?php
    if (isset($this->session->userdata['login'])) {
        echo $this->session->userdata('id');

    header("location: http://localhost/crud_ajax/index.php/employee/");
    }
    ?>
    <head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login.css">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id="main">
            <div id="login">
                <h2>Iniciar Sesion</h2>
                <hr/>
                <form action="<?= base_url()?>index.php/iniciar" method='post'>
                    <label>Correo :</label>
                    <input type="text" name="username" id="name" placeholder="username"/><br /><br />
                    <label>Clave :</label>
                    <input type="password" name="password" id="password" placeholder="**********"/><br/><br />
                    <input type="submit" value=" Ingresar " name="submit"/><br />
                </form>
            </div>
        </div>
    </body>
</html>