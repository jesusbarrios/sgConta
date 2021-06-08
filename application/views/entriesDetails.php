<!-- Lista de ejercicios contables -->
<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<span class="card-title center-align">Lista de asientos contables de <?= date("d/m/Y", strtotime($date))?></span>
<?php
    if ( $asientos = $this->Jesus->dice(array(
        'get'   => 'asientos as t1',
        'where' => array(
            't1.estado' => 'T',
            't1.fecha'  => $date,
        ),
        'select'    => array(
            't1.id',
            't1.descripcion',
            't1.numero',
            'FORMAT(t1.totalDebe, 0, "de_DE") as totalDebe',
            '(SELECT COUNT(t2.id) FROM asientoDetalles as t2 WHERE t2.asiento_id = t1.id) as cuentas'
        ),
        'order_by'  => array('t1.id' => 'desc')
    ))->result() ) {
        $asiento_descripcion = "";
        foreach( $asientos as $asientos_ ) {

            $this->table->add_row(array(
                $asientos_->numero,
                array(
                    'data' => $asientos_->descripcion,
                    'style' => 'text-align:left;',
                ),
                $asientos_->cuentas,
                $asientos_->totalDebe,
                "<i class='material-icons edit' name='edit' value=$asientos_->id>edit</i>
                <i class='material-icons delete' href='#modal1' name='delete' value=$asientos_->id>delete</i>",
            ));
        }
        $this->table->set_heading(array(
            'Números de<br>asiento',
            'Descripciones',
            'Cantidades de<br>cuentas',
            'Montos',
            'Acciones'
        ));
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>