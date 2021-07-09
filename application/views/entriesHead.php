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
                            <input type="text" size="70" id="autocomplete-input" name="account[1]" class="autocomplete validate" required />
                        </div>
                        <div class="col m2 input-field">
                            <input type="text" min="0" name="debe[1]" class="debe validate right-align" onkeyup="compare(this, 1);return false;" required />
                        </div>
                        <div class="col m2 input-field">
                            <input type="text" min="0" name="haber[1]" class="haber validate right-align" onkeyup="compare(this, 1);return false;" required />
                        </div>
                    </div>
                    <!-- Cuenta -->
                    <div class="row row-1">
                        <div class="col m6 input-field">
                            <input type="text" size="70" id="autocomplete-input" name="account[2]" class="autocomplete validate" required>
                        </div>
                        <div class="col m2 input-field">
                            <input type="text" min="0" name="debe[2]" class="debe validate right-align" value=""  onkeyup="compare(this, 2);return false;" required>
                        </div>
                        <div class="col m2 input-field">
                            <input type="text" min="0" name="haber[2]" class="haber validate right-align" value="" onkeyup="compare(this, 2);return false;" required>
                        </div>
                        <!-- <div class="col m2 input-field center">
                            <a href="#" onclick="removeRow(this);return false;" title="Eliminar fila" class="btn-floating material-icons" value="3"><i class="material-icons">remove</i></a>
                        </div> -->
                    </div>

                </div>
                <div class="row row-1">
                    <div class="col offset-m10 m2 input-field center">
                        <a href="#" onclick="addRow(3);return false;" title="Agregar fila" class="btn-floating material-icons" value="3"><i class="material-icons addRow">add</i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col m6 center input-field">
                        <h7>Total</h7>
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" readonly disabled name="totalDebe" class="totalDebe" >
                    </div>
                    <div class="col m2 input-field">
                        <input type="number" min="0" readonly disabled name="totalHaber" class="totalHaber" >
                    </div>
                    <div class="col m2 center"></div>
                </div>

                <div class="row">
                    <div class="col s6 right">
                        <button class="btn waves-light red btnSave" type="submit">
                            <i class="material-icons left">save</i>
                            Guardar
                        </button>
                        <button class="btn waves-light red btnNew green" onclick="refreshForm();return false;">
                            <i class="material-icons left">refresh</i>
                            Nuevo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>