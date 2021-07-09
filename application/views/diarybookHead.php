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
        <div class="col input-field s4">
            <input type="date" id="date" name="since" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$since?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate center" required autofocus>
            <label for="date">Desde</label>
        </div>
        <div class="col input-field s4">
            <input type="date" id="date" name="until" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$until?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate center" required autofocus>
            <label for="date">Hasta</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <button class="btn red waves-light" type="button" name="btnReport" id='btnReport' onclick="generateReport();return false;">
                <!-- <i class="material-icons left">save</i> -->
                Generar libro
            </button>
            <button class="btn red waves-light" type="button" onclick="exportarExcel();">
                <!-- <i class="material-icons left">save</i> -->
                Exportar
            </button>
        </div>
    </div>
    </form>
</body>
</html>
