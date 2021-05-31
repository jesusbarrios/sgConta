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
            <form class="card hoverable col s12 m5" actions="" id="frm" name="frm">
                <div class="card-content">
                    <span class="card-title center-align">Cuenta Contable</span>

                    <div class="row">
                        <div class="col input-field s12">
                            <input type="text" id="denominacion" name="denominacion" class="validate" required autofocus>
                            <label for="denominacion">Denominación</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col input-field s12 m7">
                            <input type="number" id="cuenta" name="cuenta" class="validate" required>
                            <label for="cuenta">N<sup>ro</sup> de cuenta contable</label>
                        </div>

                        <div class="col input-field s12 m5">
                            <label>
                                <input type="checkbox">
                                <span>Imputable</span>
                            </label>
                            
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
            <!-- Lista de ejercicios contables -->
            <div class="col s12 m7">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Lista de cuentas contables</span>
                        <?= $lista ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('footer') ?>

    <script>
         $(document).ready(function(){
            $("#frm").submit(function(e){
                e.preventDefault();
                $.post('<?=$_SERVER["REQUEST_URI"]?>', $("#frm").serialize(), function (attrib) {
                    datas = $.parseJSON(attrib);
                    M.toast({
                        html: datas.html,
                        displayLength: 2500,
                        inDuration: 1000,
                        outDuration:1000,
                        classes: datas.clases
                    });
                });
            })
         });
    </script>
</body>
</html>