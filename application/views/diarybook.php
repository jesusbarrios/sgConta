<html>
<head>
    <meta charset="UTF-8">
    <!-- <meta charset="UTF-8"/> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG[conta]</title>

    <link rel="stylesheet" href="css/myStyle.css">

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
            <div class="col s12 m12">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Libro diario</span>
                        <!-- Cabecera -->
                        <div id="head">
                            <?= $head ?>
                        </div>
                        <!-- Reporte -->
                        <div id="details">
                            <?= $details ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('footer') ?>
    <!--Import jQuery before materialize.js-->
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/saveAsExcel.js"></script> -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    <script type="text/javaScript">
        function exportarExcel(){
            $("#libroDiario").table2excel({
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: "balanceResultado", // do include extension
                fileext:'.xls',
                preserveColors: false // set to true if you want background colors and font colors preserved
            });
        }
        function generateReport() {
            $.get('<?=$_SERVER["REQUEST_URI"]?>', $('form').serialize(), function (attrib) {
                console.log(attrib);
                datas = $.parseJSON(attrib);
                if (datas.details)
                    $('#details').html(datas.details);
                if (datas.html)
                    M.toast({
                        html:           datas.html,
                        displayLength:  2500,
                        inDuration:     1000,
                        outDuration:    1000,
                        classes:        datas.clases
                    });
            });
        }
    </script>
</body>
</html>