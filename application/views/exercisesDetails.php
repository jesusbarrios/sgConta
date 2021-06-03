<!-- Lista de ejercicios contables -->
<style>
    .edit, .delete{cursor:pointer;}
    .edit:hover{color:green;}
    .delete:hover{color:red;}
</style>
<span class="card-title center-align">Lista de ejercicios contables</span>
<?php
    if ( $ejercicios = $this->Jesus->dice(array(
        'get'   => 'ejercicios',
        'where' => array(
            'estado'    => 'T'
        ),
        'select'    => array(
            'id',
            'anho',
            'denominacion',
            'activo'
        ),
        'order_by'  => array('anho' => 'desc')
    ))->result() ) {
        foreach( $ejercicios as $ejercicios_) {
            $this->table->add_row(array(
                $ejercicios_->anho,
                array('data' => $ejercicios_->denominacion, 'style'=> 'text-align:left'),
                $ejercicios_->activo?
                    "<i class='material-icons green-text'>check</i>"
                    : "<i class='material-icons gray-text'>remove</i>",
                '0',
                "<i class='material-icons edit' name='edit' value=$ejercicios_->id>edit</i>
                <i class='material-icons delete' href='#modal1' name='delete' value=$ejercicios_->id>delete</i>",
/*
                '<a class="modal-trigger" href="#confirm">
                    <i class="material-icons">delete</i>
                </a>'
*/
            ));
        }
        $this->table->set_heading(array(
            'Años',
            'Denominaciones',
            'Activo',
            'Asientos',
            array('data' => 'Operaciones', 'colspan' => '2')
        ));
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
        echo $this->table->generate();
    }
?>

<!-- Modal Structure -->
<!-- <div id="confirm" class="modal">
    <div class="modal-content">
        <h4>Por favor confirme</h4>
        <p>¿Estas seguro que quieres eliminar?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn modal-close">Canceler</a>
        <a href="#" class="btn modal-close btnDelete" id="deleteId" name="delete" value="1">Eliminar</a>
    </div>
</div>
-->

<script>
    $(document).ready(function(){
        $(".delete").click(function(e)  {
            if( confirm('Confirmar eliminación') )
                request($(this))
        })
        $(".edit").click(function(e)    { request($(this))})
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
                    $('#year').focus()
                    temp = $('#year').val();
                    $('#year').val('');
                    $('#year').val(temp)
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
    });
</script>