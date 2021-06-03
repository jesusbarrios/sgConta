
<form class="card hoverable col s12 m5" actions="" id="frm" name="<?=isset($id)? 'save' : 'add'?>">
    <div class="card-content">
        <span class="card-title center-align">Cuenta Contable</span>

        <div class="row">
            <div class="col input-field s12">
                <input type="hidden" id="id" name="id" value="<?=isset($id)? $id : ''?>">
                <input type="text" id="denominacion" name="denominacion" value="<?=isset($denominacion)? $denominacion : ''?>" class="validate" required autofocus>
                <label for="denominacion" class="active">Denominación</label>
            </div>
        </div>

        <div class="row">
            <div class="col input-field s12 m7">
                <input type="number" id="codigo" name="codigo" value="<?=isset($codigo)? $codigo : ''?>" class="validate" required>
                <label for="codigo" class="active">Código contable</label>
            </div>

            <div class="col input-field s12 m5">
                <label>
                    <input type="checkbox" id="imputable" name="imputable" <?=(isset($imputable) && $imputable)? 'checked' : ''?>>
                    <span>Imputable</span>
                </label>
                
            </div>
        </div>

        <!-- Botones -->
        <div class="row">
            <div class="col s6">
                <?php if (isset($id)){ ?>
                <button class="btn waves-light" type="submit" name="btnSave" id="btnSave">
                    <i class="material-icons left">save</i>
                    Guardar
                </button>
            </div>
            <div class="col s6">
                <button class="btn waves-light" type="button" name="btnNew" id="btnNew">
                    <i class="material-icons left">autorenew</i>
                    Nuevo
                </button>
                <?php } else { ?>
                <button class="btn waves-light" type="submit" name="btnSave" id="btnSave">
                    <i class="material-icons left">add</i>
                    Agregar
                </button>
                <?php } ?>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm").submit(function(e)    {
            e.preventDefault()
            $.post('<?=$_SERVER["REQUEST_URI"]?>',  $("#frm").serialize() + "&action=" + $("#frm").attr('name'), function (attrib) {
                datas = $.parseJSON(attrib);
                M.toast({
                    html: datas.html,
                    displayLength: 2500,
                    inDuration: 1000,
                    outDuration:1000,
                    classes: datas.clases
                });
                if (datas.details)
                    $('#details').html(datas.details);
            });
        })
        $("#btnNew").click(function(e) {
            $.post('<?=$_SERVER["REQUEST_URI"]?>', "action=btnNew", function (attrib) {
                datas = $.parseJSON(attrib);
                if (datas.head) {
                    $('#head').html(datas.head);
                    $( "label" ).removeClass( "active" );
                    $('#denominacion').focus();
                }
                $( "label[name=denominacion]" ).removeClass( "active" );
            });
        })
    });
</script>