<!-- Lista de ejercicios contables -->
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
                $ejercicios_->denominacion,
                '0'
            ));
        }
        $this->table->set_heading(array(
            'Años',
            'Denominaciones',
            'Asientos'
        ));
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "striped">'));
        echo $this->table->generate();
    }
?>