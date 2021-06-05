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
            <div id="head">
                <?= $head ?>
            </div>
            <!-- </div> -->
            <!-- Lista de ejercicios contables -->
            <div class="col s12 m12">
                <div class="card hoverable">
                    <div class="card-content" id="details">
                        <?= $details ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('footer') ?>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>