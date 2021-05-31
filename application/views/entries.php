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
                    <span class="card-title center-align">Asiento Contable</span>

                    <div class="row">
                        <div class="col input-field s5">
                            <select id="exersice" name="exersice" class="validate" autofocus>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                            <label for="exersice">Ejercicio</label>
                        </div>
                        <div class="col input-field s7">
                            <input type="date" id="date" name="date" class="validate" required>
                            <label for="date">Fecha</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col input-field s12">
                            <input type="text" id="descripcion" name="descripcion" class="validate" required>
                            <label for="descripcion">Descripción</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                        <span class="card-title center-align">Operaciones</span>
                        </div>
                    </div>

                    <div class="row">
                        <table class="centered">
                            <thead>
                                <tr>
                                    <th>Cuenta</th>
                                    <th>Debe</th>
                                    <th>Haber</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                    <select>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
                                    </td>
                                    <td><input type="text" value="600000"></td>
                                    <td><input type="text"></td>
                                    <td>
                                        <i class="material-icons delete">delete_sweep</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <select>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
                                    </td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td>
                                        <i class="material-icons new">playlist_add</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Lista de asientos contables</span>
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