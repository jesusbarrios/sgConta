<!-- Lista de ejercicios contables -->
<style>
    .edit, .delete{cursor:pointer;}
    .edit:hover{color:green;}
    .delete:hover{color:red;}
</style>
<span class="card-title center-align">Lista de cuentas contables</span>
<?php
    if ( $cuentas = $this->Jesus->dice(array(
        'get'   => 'cuentas',
        'where' => array(
            'estado'    => 'T'
        ),
        'select'    => array(
            'id',
            'codigo',
            'denominacion',
            'if(imputable, "si", "no") as imputable'
        ),
        'order_by'  => array('codigo' => 'asc')
    ))->result() ) {
        foreach( $cuentas as $cuentas_) {
            $this->table->add_row(array(
                array('data' => $cuentas_->codigo, 'style'=> 'text-align:left'),
                array('data' => $cuentas_->denominacion, 'style'=> 'text-align:left'),
                $cuentas_->imputable,
                "<i class='material-icons edit' name='edit' value=$cuentas_->id>edit</i>",
                "<i class='material-icons delete' href='#modal1' name='delete' value=$cuentas_->id>delete</i>",
                // '<a class="modal-trigger" href="#confirm">del</a>'

                // '<a class="modal-trigger" href="#confirm">
                //     <i class="material-icons">delete</i>
                // </a>'
            ));
        }
        $this->table->set_heading(array(
            'Códigos',
            'Denominaciones',
            'Imputables',
            array('colspan' => 2, 'data' => 'Operaciones')
        ));
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
        echo $this->table->generate();
    }
?>

<!-- Modal Structure -->
<!--
<div id="confirm" class="modal">
    <div class="modal-content">
        <h4>Por favor confirme</h4>
        <p>¿Estas seguro que quieres eliminar?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn modal-close">Canceler</a>
        <a href="#" class="btn modal-close delete" id="deleteId" name="delete" value="1">Eliminar</a>
    </div>
</div>
-->
<script>
    $(document).ready(function(){
        // Delete
        $(".delete").click(function(e)  {
            if( confirm('Confirmar eliminación') );
                // request($(this))
            return true;
        })
        // Edit
        $(".edit").click(function(e)    { request($(this))})
        // Request
        function request(e) {
            $.post('<?=$_SERVER["REQUEST_URI"]?>',  $("form").serialize() + "&action=" + e.attr('name') + "&value=" + e.attr('value'), function (attrib) {
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
                if (datas.head){
                    $('#head').html(datas.head);
                    $('#denominacion').focus()
                    temp = $('#denominacion').val();
                    $('#denominacion').val('');
                    $('#denominacion').val(temp)
                }
            });
        }
    });
</script>