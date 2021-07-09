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
<form actions="" id="frm" name="frm" action="" method=''>
    <div class="row">
        <div class="col input-field s12">
            <select multiple id="cuentas[]" name="cuentas[]" autofocus="autofocus">
                <!-- <option value="" disabled selected>Todas las cuentas</option> -->
                <?php
                    if ( $cuentas = $this->Jesus->dice(array(
                        'get'       => 'cuentas AS t2',
                        'select'    => array(
                            't2.id',
                            't2.codigo',
                            't2.imputable',
                            'concat(t2.codigo, " ", t2.denominacion) as denominacion',
                        ),
                        'where'     => array('t2.estado' => 'T'),
                        'order_by'  => array('t2.codigo' => 'asc')
                    ))-> result()) {
                        $grupo  = array();
                        $key    = 0;
                        foreach ( $cuentas as $cuentas_ ) {
                            // no imputables
                            if ( strlen($cuentas_->codigo) < $key ) 
                                echo "</optgroup>";


                            if ( !$cuentas_->imputable ) {
                                echo '<optgroup label="' . $cuentas_->denominacion . '">';
                                $key = strlen($cuentas_->codigo);
                            } else {
                                echo "<option value=$cuentas_->id>$cuentas_->denominacion</option>";
                                $key = strlen($cuentas_->codigo);
                            }
                        }
                    }
                ?>
            </select>
            <label for="cuentas[]">Cuenta</label>
        </div>
    </div>
    <div class="row">
        <div class="col input-field s4">
            <input type="date" id="date" name="since" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$since?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate center" required >
            <label for="date">Desde</label>
        </div>
        <div class="col input-field s4">
            <input type="date" id="date" name="until" min="<?=$this->sesion['ejercicio']?>-01-01" value="<?=$until?>" max="<?=$this->sesion['ejercicio']?>-12-31" class="validate center" required >
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
<script type="text/javascript" src="js/saveAsExcel.js"></script>
<script>
    function generateReport() {
        $.get('<?=$_SERVER["REQUEST_URI"]?>', $('form').serialize(), function (attrib) {
            console.log(attrib);
            // return;
            datas = $.parseJSON(attrib);
            if (datas.details)
                $('#details').html(datas.details);
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