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
<form class="card hoverable col s12 m12" actions="" id="frm" name="frm" action="add">
    <div class="row">
        <div class="col m12">
            <div class="card-content">
                <div class="toAdd">
                    <span class="card-title center-align">Asiento Contable</span>

                    <div class="row">
                        <div class="col input-field s3">
                            <input type="date" id="date" name="date" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$date?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate center" required autofocus>
                            <label for="date">Fecha</label>
                        </div>
                        <div class="col input-field s9">
                            <textarea  id="descripcion" name="descripcion" class="materialize-textarea validate" maxlength="100" required data-length="100"></textarea>
                            <label for="descripcion">Descripción</label>
                        </div>
                    </div>

                    <!-- Cabecera -->
                    <div class="row">
                        <div class="col m6 center"><h6>Cuentas  </h6></div>
                        <div class="col m2 center"><h6>Debe     </h6></div>
                        <div class="col m2 center"><h6>Haber    </h6></div>
                        <div class="col m2 center"><h6>Acciones </h6></div>
                    </div>

                    <!-- Cuenta -->
                    <div class="row row-1">
                        <div class="col m6 input-field">
                            <input type="text" size="70" id="autocomplete-input" name="account[1]" class="autocomplete validate" required>
                        </div>
                        <div class="col m2 input-field">
                            <input type="number" min="0" name="debe[1]" class="debe validate right-align" value=""  onkeyup="compare(this, 1);return false;" required>
                        </div>
                        <div class="col m2 input-field">
                            <input type="number" min="0" name="haber[1]" class="haber validate right-align" value="" onkeyup="compare(this, 1);return false;" required>
                        </div>
                        <div class="col m2 input-field center">
                            <a href="#" onclick="addRow(this);return false;" title="Agregar fila" class="btn-floating material-icons" value="1"><i class="material-icons addRow">add</i></a>
                        </div>
                    </div>

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
        $("#frm").submit(function(e)    {
            e.preventDefault()
            if ( compare() ) {
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
            });
            
        });

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
        $('.addRow').html("remove").removeClass("addRow");
        $('a[onclick="addRow(this);return false;"]').attr("onclick", "removeRow(this);return false;");
        xOp ++;
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
        de1.setAttribute("type", "number");
        de1.setAttribute("min", "0");
        de1.setAttribute("name", "debe[" + xOp + "]");
        de1.setAttribute("class", "debe validate right-align");
        de1.setAttribute("required", "required");
        de1.setAttribute("onkeyup", "compare(this, " + xOp + ")");
        var de2 = document.createElement("div");
        de2.setAttribute("class", "col m2 input-field");
        de2.append(de1)

        var ha1 = document.createElement("input");
        ha1.setAttribute("type", "number");
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
        acc1.setAttribute("class", "material-icons addRow");
        acc1.innerHTML = "add";
        var acc2 = document.createElement("a");
        acc2.setAttribute("onclick", "addRow(this);return false;");
        acc2.setAttribute("class", "btn-floating validate");
        acc2.setAttribute("href", "#");
        acc2.setAttribute("value", xOp);
        acc2.append(acc1);
        var acc3 = document.createElement("div");
        acc3.setAttribute("class", "col m2 input-field center");
        acc3.append(acc2);
        
        // APPEND to document
        var acc4 = document.createElement("div");
        acc4.setAttribute("class", "row row-" + xOp);
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
            console.log('es debe')


        } else if ( $(x).attr('name') == "haber[" + fName + "]" ) {
            if ( $('input[name="haber[' + fName + ']"]').val() )
                $('input[name="debe[' + fName + ']"]').prop('disabled', true).removeClass('validate invalid').prop('required', false);
            else
                $('input[name="debe[' + fName + ']"]').prop('disabled', false).addClass('validate').prop('required', true);
            console.log('es haber')
        }


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