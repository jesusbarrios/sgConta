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
    <?php $this->load->view('nav') ?>

    <div class="container section">
        <div class="row">
            <!-- <div class="col s12 m6"> -->
            <form class="card hoverable col s12 m6" actions="" id="frm" name="frm">
                <div class="card-content">
                    <span class="card-title center-align">Ejercicios Contables</span>

                    <div class="row">
                        <div class="col input-field s3">
                            <input type="number" id="year" name="year" class="validate" min="<?= $min?>" max="<?= $max ?>" required autofocus >
                            <label for="year">Año</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col input-field s12">
                            <input type="text" id="denominacion" name="denominacion" class="validate" required>
                            <label for="denominacion">Denominación</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s6 offset-s1">
                            <button class="btn waves-effect waves-light" type="submit">
                                <i class="material-icons left">save</i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- </div> -->
        </div>
    </div>
    <?php $this->load->view('footer') ?>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
         $(document).ready(function(){
            $("#frm").submit(function(e){
                e.preventDefault();
            })
         });
    </script>
</body>
</html>