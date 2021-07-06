<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        .row{
            margin-bottom: 10px;
        }
        .col {
            margin-bottom: 0px;
            margin-top: 0px;
        }
        .card .card-content .card-title {
            display: block;
            line-height: 32px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<form class="" actions="" id="frm" name="frm" action="add">
    <div class="row">
        <div class="col input-field s4 offset-s2">
            <input type="date" id="until" name="until" min="<?=$ejercicio?>-01-01" value="<?=$until?>" max="<?=$ejercicio?>-12-31" class="validate center" required autofocus />
            <label for="date">A la fecha</label>
        </div>
        <div class="col s4">
            <button class="btn red waves-light" type="submit" name="btnReport" id='btnReport' onclick="generateReport();return false;">
                <!-- <i class="material-icons left">save</i> -->
                Generar balance
            </button>
            <!-- <button class="btn red waves-light" type="button" onclick="saveAsExcel('balance', 'balanceGeneral.xls');"> -->
            <button class="btn red waves-light" type="button" onclick="exportarExcel();">
                <!-- <i class="material-icons left">save</i> -->
                Exportar
            </button>
        </div>
    </div>
</form>
</body>
</html>