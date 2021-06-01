
            <form class="card hoverable col s12 m5" actions="" id="frm" name="frm">
                <div class="card-content">
                    <span class="card-title center-align">Ejercicios Contables</span>

                    <div class="row">
                        <div class="col input-field s4">
                            <input type="hidden" id="id" name="id" value="<?=isset($id)? $id : ''?>">
                            <input type="number" id="year" placeholder="año" name="year" value="<?=isset($anho)? $anho : ''?>" class="validate" min="<?= $min?>" max="<?= $max ?>" required autofocus >
                            <label for="year">Año</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col input-field s12">
                            <input type="text" id="denominacion" name="denominacion" value="<?=isset($denominacion)? $denominacion : ''?>" class="validate" required>
                            <label for="denominacion">Denominación</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s6 offset-s1">
                            <button class="btn waves-light" type="submit" name="btnSave" id="btnSave">
                                <i class="material-icons left">save</i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>


<script>
        $(document).ready(function(){
        $("#frm").submit(function(e)    { e.preventDefault()})
        $("#btnSave").click(function(e) { request($(this))})
        function request(e) {
            $.post('<?=$_SERVER["REQUEST_URI"]?>',  $("form").serialize() + "&action=" + e.attr('name'), function (attrib) {
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
        }
        });
</script>