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
        'order_by'  => array('anho' => 'desc')
    ))->result() ) {
        foreach( $ejercicios as $ejercicios_) {
            $this->table->add_row(array(
                $ejercicios_->anho,
                array('data' => $ejercicios_->denominacion, 'style'=> 'text-align:left'),
                '0',
                "<i class='material-icons edit' name='edit' value=$ejercicios_->id>edit</i>
                <i class='material-icons delete' name='delete' value=$ejercicios_->id>delete</i>"
            ));
        }
        $this->table->set_heading(array(
            'Años',
            'Denominaciones',
            'Asientos',
            'Operaciones'
        ));
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
        echo $this->table->generate();
    }
?>

<script>
    $(document).ready(function(){
        $(".delete").click(function(e)  { request($(this))})
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
</script>