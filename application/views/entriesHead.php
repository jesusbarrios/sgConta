<form class="card hoverable col s12 m12" actions="" id="frm" name="frm" action="add">
    <div class="row">
        <div class="col m12">
            <div class="card-content">
            <div class="toAdd">
                <span class="card-title center-align">Asiento Contable</span>

                <div class="row">
                    <div class="col input-field s3">
                        <input type="date" id="date" name="date" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$date?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate" required autofocus>
                        <label for="date">Fecha</label>
                    </div>
                    <div class="col input-field s9">
                        <textarea  id="descripcion" name="descripcion" class="materialize-textarea validate" maxlength="100" required data-length="100"></textarea>
                        <label for="descripcion">Descripción</label>
                    </div>
                </div>

                <!-- Cabecera -->
                <div class="row">
                    <div class="col m6 center"><h7>Cuentas  </h7></div>
                    <div class="col m2 center"><h7>Debe     </h7></div>
                    <div class="col m2 center"><h7>Haber    </h7></div>
                    <div class="col m2 center"><h7>Acciones </h7></div>
                </div>

                <div class="row">
                    <div class="col m6 input-field">
                        <input type="text" size="70" id="autocomplete-input" name="account[1]" class="autocomplete" >
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" name="debe[1]" class="debe" onkeyup="compare()">
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" name="haber[1]" class="haber" onkeyup="compare()">
                    </div>
                    <div class="col m2 center">
                        <!-- <i class="material-icons new">add_sweep</i> -->
                        <i class="material-icons new">playlist_add</i>
                    </div>
                </div>

                <!-- <div class="row divAdd"></div> -->
            </div>
                <div class="row">
                    <div class="col m6 center input-field">
                        <h7>Total</h7>
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" readonly name="totalDebe" class="totalDebe" >
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" readonly name="totalHaber" class="totalHaber" >
                    </div>
                    <div class="col m2 center"></div>
                </div>

                <div class="row">
                    <div class="col s6 offset-s1">
                        <button class="btn waves-light" type="submit">
                            <i class="material-icons left">save</i>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        xOp = 1;
        $('.new').click(function(){
            xOp ++;
            /*
            //MODELO
            var btn = document.createElement("BUTTON");
            btn.innerHTML = "CLICK ME";
            btn.setAttribute("class", "aviso");
            btn.setAttribute("onclick", "alert()");
            $(".toAdd").append(btn);
            */

            // Account
            var ac1 = document.createElement("input");
            ac1.setAttribute("type", "text");
            ac1.setAttribute("size", "70");
            ac1.setAttribute("id", "autocomplete-input");
            ac1.setAttribute("name", "account[" + xOp + "]");
            ac1.setAttribute("class", "autocomplete");
            var ac2 = document.createElement("div");
            ac2.setAttribute("class", "col m6 input-field" );
            ac2.append(ac1)
            var ac3 = document.createElement("div");
            

            // Debe
            var de1 = document.createElement("input");
            de1.setAttribute("type", "number");
            de1.setAttribute("min", "0");
            de1.setAttribute("name", "debe[" + xOp + "]");
            de1.setAttribute("class", "debe");
            de1.setAttribute("onkeyup", "compare()");

            var de2 = document.createElement("div");
            de2.setAttribute("class", "col m2 input-field");
            de2.append(de1)

            // Haber
            var ha1 = document.createElement("input");
            ha1.setAttribute("type", "number");
            ha1.setAttribute("min", "0");
            ha1.setAttribute("name", "haber[" + xOp + "]");
            ha1.setAttribute("class", "haber");
            ha1.setAttribute("onkeyup", "compare()");

            var ha2 = document.createElement("div");
            ha2.setAttribute("class", "col m2 input-field");
            ha2.append(ha1)

            // Accion
            

            // APPEND to document
            ac3.setAttribute("class", "row field-" + xOp);
            ac3.append(ac2, de2, ha2);
            $(".toAdd").append(ac3);
            
            // $(".field-" + xOp).append(de2);

            

            // Debe
            
            $.get('<?=$_SERVER["REQUEST_URI"]?>/accounts', $("#frm").serialize(), function (attrib) {
                $('input.autocomplete').autocomplete({
                    data : $.parseJSON(attrib),
                });
            });

           /* jQuery(".toAdd").append(
                '<div class="row"><div class="col m6 input-field"><input type="text" size="70" id="autocomplete-input" name="account[' + cantElemento + ']" class="autocomplete" ></div><div class="col m2 input-field"><input type="number" min="0" name="debe[' + cantElemento + ']" class="debe" ></div><div class="col m2 input-field"><input type="number" min="0" name="haber[' + cantElemento + ']" class="haber" ></div><div class="col m2 center"><i onclick="myFunction()" class="material-icons new">playlist_add</i></div></div>'
            );
            $(document).ready();

            /*jQuery(".toAdd").append(jQuery(
                '<div class="row"><div class="col m6 input-field"><input type="text" size="70" id="autocomplete-input" name="account[' + cantElemento + ']" class="autocomplete" ></div><div class="col m2 input-field"><input type="number" min="0" name="debe[' + cantElemento + ']" class="debe" ></div><div class="col m2 input-field"><input type="number" min="0" name="haber[' + cantElemento + ']" class="haber" ></div><div class="col m2 center"><i class="material-icons new" onclick="alertar()">playlist_add</i></div></div>'

            ));*/
            // alert()
        });
        // myFunction()

        function myFunction() {
            alert('hola mundo');
        }
        $("#frm").submit(function(e)    {
            e.preventDefault()
            if ( compare() ) {
                $.post('<?=$_SERVER["REQUEST_URI"]?>', $("#frm").serialize(), function (attrib) {
                    alert(attrib);
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

        $( "#date" ).change(function() {
            $.get('<?=$_SERVER["REQUEST_URI"]?>/details',  $("#frm").serialize(), function (attrib) {
                datas = $.parseJSON(attrib);
                if (datas.details)
                    $('#details').html(datas.details);
                alert( attrib );
            });
            
        });

        $.get('<?=$_SERVER["REQUEST_URI"]?>/accounts',  $("#frm").serialize(), function (attrib) {
            $('input.autocomplete').autocomplete({
                data : $.parseJSON(attrib),
            });
        });

        $('textarea#descripcion').characterCounter();
    });
    /*$('.debe').on("keyup", function() {
        var sum = 0;
        $(".debe").each(function(){
            sum += +$(this).val();
        });
        $(".totalDebe").val(sum);
        compare();
    });
    $('.haber').on("keyup", function() {
        var sum = 0;
        $(".haber").each(function(){
            sum += +$(this).val();
        });
        $(".totalHaber").val(sum);
        compare();
    });*/
    function compare() {
        // alert()
        var sum = 0;
        $(".debe").each(function(){
            sum += +$(this).val();
        });
        $(".totalDebe").val(sum);
        // compare();

        var sum = 0;
        $(".haber").each(function(){
            sum += +$(this).val();
        });
        $(".totalHaber").val(sum);
        // compare();

        if ( $('.totalDebe').val() != $('.totalHaber').val() ){
            $('.totalDebe').addClass("red lighten-3");
            $('.totalHaber').addClass("red lighten-3");
            return false;
        }else {
            $('.totalDebe').removeClass("red lighten-3");
            $('.totalHaber').removeClass("red lighten-3");
            return true;
        }
    }
</script>