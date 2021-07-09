<html>
<head>
    <meta charset="UTF-8">
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
    <script>
        // Prepara el formulario para registrar un nuevo asiento
        function refreshForm() {
            $('.btnSave').removeAttr('disabled');
            $('#descripcion, input[type="text"], input[type="number"]').prop('value', '');
            $('.totalDebe, .totalHaber').removeClass("red lighten-3");
            var elements = document.querySelectorAll('.attached');  
            for (var element of elements)
                element.remove();
            $('#descripcion').focus();
        }
        $(document).ready(function(){
            xOp = 1;
            $("#frm").submit(function(e)    {
                e.preventDefault()
                $('.btnSave').prop('disabled', 'true');
                $('.btnNew').focus();
            
                if ( compare() ) {
                    $('.totalDebe').prop('disabled', false);
                    $('.totalHaber').prop('disabled', false);
                    $.post('<?=$_SERVER["REQUEST_URI"]?>', $("#frm").serialize(), function (attrib) {
                        datas = $.parseJSON(attrib);
                        M.toast({
                            html:           datas.html,
                            displayLength:  2500,
                            inDuration:     1000,
                            outDuration:    1000,
                            classes:        datas.clases
                        });
                        if (datas.details)
                            $('#details').html(datas.details);
                    });
                    $('.totalDebe').prop('disabled', true);
                    $('.totalHaber').prop('disabled', true);
                } else {
                    M.toast({
                        html:           "No cumple la partida doble",
                        displayLength:  2500,
                        inDuration:     1000,
                        outDuration:    1000,
                        classes:        "red"
                    });
                }
            })

            // Actualiza el reporte y limpia el formulario al cambiar la fecha
            $( "#date" ).change(function() {
                $.get('<?=$_SERVER["REQUEST_URI"]?>/details',  $("#frm").serialize(), function (attrib) {
                    datas = $.parseJSON(attrib);
                    if (datas.details)
                        $('#details').html(datas.details);
                });
                // Limpia el formulario
                refreshForm();
            });
            //Carga las cuentas en los campos luego recargar el formulario
            $.get('<?=$_SERVER["REQUEST_URI"]?>/accounts',  $("#frm").serialize(), function (attrib) {
                $('input.autocomplete').autocomplete({
                    data : $.parseJSON(attrib),
                });
            });
            $('textarea#descripcion').characterCounter();
            
        });

        function removeRow(x){
            var elements = document.querySelectorAll('.row-' + $(x).attr('value'));  
            for (var element of elements)
                element.remove();
            compare()
        }

        function addRow(x) {
            $('a[onclick="addRow(' + x + ');return false;"]').attr("onclick", "addRow(" + (x + 1) + ");return false;");
            xOp  = x;
            var ac1 = document.createElement("input");
            ac1.setAttribute("type", "text");
            ac1.setAttribute("size", "70");
            ac1.setAttribute("id", "autocomplete-input");
            ac1.setAttribute("name", "account[" + xOp + "]");
            ac1.setAttribute("class", "autocomplete validate left-align");
            ac1.setAttribute("required", "required");
            var ac2 = document.createElement("div");
            ac2.setAttribute("class", "col m6 input-field" );
            ac2.append(ac1)
            var de1 = document.createElement("input");
            de1.setAttribute("type", "text");
            de1.setAttribute("min", "0");
            de1.setAttribute("name", "debe[" + xOp + "]");
            de1.setAttribute("class", "debe validate right-align");
            de1.setAttribute("required", "required");
            de1.setAttribute("onkeyup", "compare(this, " + xOp + ")");
            var de2 = document.createElement("div");
            de2.setAttribute("class", "col m2 input-field");
            de2.append(de1)

            var ha1 = document.createElement("input");
            ha1.setAttribute("type", "text");
            ha1.setAttribute("min", "0");
            ha1.setAttribute("name", "haber[" + xOp + "]");
            ha1.setAttribute("class", "haber validate  right-align");
            ha1.setAttribute("required", "required");
            ha1.setAttribute("onkeyup", "compare(this, " + xOp + ")");
            var ha2 = document.createElement("div");
            ha2.setAttribute("class", "col m2 input-field");
            ha2.append(ha1)

            //Accion
            var acc1 = document.createElement("i");
            acc1.setAttribute("class", "material-icons");
            acc1.innerHTML = "remove";
            var acc2 = document.createElement("a");
            acc2.setAttribute("onclick", "removeRow(this);return false;");
            acc2.setAttribute("class", "btn-floating validate");
            acc2.setAttribute("title", "Eliminar fila");
            acc2.setAttribute("href", "#");
            acc2.setAttribute("value", xOp);
            acc2.append(acc1);
            var acc3 = document.createElement("div");
            acc3.setAttribute("class", "col m2 input-field center");
            acc3.append(acc2);
            
            // APPEND to document
            var acc4 = document.createElement("div");
            acc4.setAttribute("class", "attached row row-" + xOp);
            acc4.append(ac2, de2, ha2, acc3);
            $(".toAdd").append(acc4);

            // Update account options
            $.get('<?=$_SERVER["REQUEST_URI"]?>/accounts', $("#frm").serialize(), function (attrib) {
                $('input.autocomplete').autocomplete({
                    data : $.parseJSON(attrib),
                });
            });
            $('input[name="account[' + xOp + ']"]').focus();

            // $('a[onclick="addRow(this);return false;"]').attr("onclick", "removeRow(this);return false;");
            // ac1.setAttribute("name", "account[" + xOp + "]");
        };

        function compare(x, fName) {
            if ( $(x).attr('name') == "debe[" + fName + "]" ) {
                if ( $('input[name="debe[' + fName + ']"]').val() )
                    $('input[name="haber[' + fName + ']"]').prop('disabled', true).removeClass('validate invalid').prop('required', false);
                else
                    $('input[name="haber[' + fName + ']"]').prop('disabled', false).addClass('validate').prop('required', true);

                x.value = x.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");


            } else if ( $(x).attr('name') == "haber[" + fName + "]" ) {
                if ( $('input[name="haber[' + fName + ']"]').val() )
                    $('input[name="debe[' + fName + ']"]').prop('disabled', true).removeClass('validate invalid').prop('required', false);
                else
                    $('input[name="debe[' + fName + ']"]').prop('disabled', false).addClass('validate').prop('required', true);

                x.value = x.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            }

            var sum = 0;
            $(".debe").each(function(){
                sum += +$(this).val().replace(/\./g, '');
            });
            $(".totalDebe").val(sum);

            var sum = 0;
            $(".haber").each(function(){
                sum += +$(this).val().replace(/\./g, '');
            });
            $(".totalHaber").val(sum);

            if ( $('.totalDebe').val() != $('.totalHaber').val() ){
                $('.totalDebe, .totalHaber').addClass("red lighten-3");
                return false;
            }else {
                $('.totalDebe, .totalHaber').removeClass("red lighten-3");
                return true;
            }
        }

        function deleteEntrie(el, y) {
            $.ajax({
                url: '<?=$_SERVER["REQUEST_URI"]?>/' + y,
                type: 'DELETE',
                // data: y,
                success: function(result) {
                    el.parent().parent().remove();
                    console.log(result);
                    datas = $.parseJSON(result);
                    M.toast({
                        html:           datas.html,
                        displayLength:  2500,
                        inDuration:     1000,
                        outDuration:    1000,
                        classes:        datas.clases
                    });
                }
            });
        }
    </script>
</body>
</html>