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
    <div class="navbar-fixed">
        <nav class="hoverable  teal lighten-2">
            <div class="container nav-wrapper ">
                <a href="" class="brand-logo right">[contabilidad] Sistema de gestión</a>
            </div>
        </nav>
    </div>

    <div class="container section">
        <div class="row">
             <div class="col s12 m4 offset-m4">
                <form class="card hoverable " actions="" id="frmLogin" name="frmLogin">
                    <div class="card-content">
                        <span class="card-title center-align">Acceso al sistema</span>
                        <div class="s12 input-field">
                            <input type="text" id="user" name="user" class="validate" required value="1234567">
                            <label for="user">Usuario</label>
                        </div>
                        <div class="s12 input-field">
                            <input type="password" id="password" name="password" class="validate" required value="NorY0123">
                            <label for="password">contraseña</label>
                        </div>
                        <div class="s12 offset-s1">
                            <button class="btn waves-effect waves-light" type="submit">
                                <i class="material-icons left">vpn_key</i>
                                Ingresar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
         $(document).ready(function(){
            $("#frmLogin").submit(function(e){
                e.preventDefault();
                $.post('<?=$_SERVER["REQUEST_URI"]?>', $("#frmLogin").serialize(), function (respuesta) {
                    if ( respuesta )
                        location.reload();
                    else
                        M.toast({
                            html: 'Datos de usuario incorrectos',
                            displayLength: 2500,
                            inDuration: 1000,
                            outDuration:1000,
                            classes: "red"
                        });
                });
            })
         });
    </script>
</body>
</html>