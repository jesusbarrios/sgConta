<!-- Lista de ejercicios contables -->
<style>
    .edit, .new, .delete{cursor:pointer;}
    .edit:hover, .new:hover{color:green;}
    .delete:hover{color:red;}
</style>
<?php
    /*if ( $ejercicios = $this->Jesus->dice(array(
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
                '<i class="material-icons edit">edit</i>'
            ));
        }
        */
    if (true) {
        $this->table->set_heading(array(
            'Fechas',
            'Descripciones',
            'Monto',
            'Acciones'
        ));
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
        echo $this->table->generate();
    }
?>