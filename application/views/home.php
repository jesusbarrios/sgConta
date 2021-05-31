<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG[conta]</title>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <!-- Menu -->
    <?php $this->load->view('nav'); ?>

    <!-- Contenido -->
    <div class="container section">
        <div class="row">
            <!-- Datos del usuario -->
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                    
                        <span class="card-title center-align">Datos del usuario</span>
                        <table class="striped">
                            <tbody>
                            <tr>
                                <td>Usuario</td>
                                <td><?=$this->sesion['usuario']?></td>
                            </tr>
                            <tr>
                                <td>Documento</td>
                                <td><?=$this->sesion['documento']?></td>
                            </tr>
                            <tr>
                                <td>Rol</td>
                                <td><?=$this->sesion['rol']?></td>
                            </tr>
                            <tr>
                                <td>Último acceso</td>
                                <td><?=$this->sesion['loged_at']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Datos de la empresa -->
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Datos de la empresa</span>
                        <table class="striped">
                            <tbody>
                                <tr>
                                    <td>Razon social</td>
                                    <td><?=$this->sesion['empresa']?></td>
                                </tr>
                                <tr>
                                    <td>RUC</td>
                                    <td><?=$this->sesion['ruc']?></td>
                                </tr>
                                <tr>
                                    <td>Fecha de constitución</td>
                                    <td><?=$this->sesion['constitucion']?></td>
                                </tr>
                                <tr>
                                    <td>Inicio de actividad</td>
                                    <td><?=$this->sesion['inicioActividad']?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('footer'); ?>
</body>
</html>