<!-- Lista de ejercicios contables -->
<style>
    .edit, .new, .delete{cursor:pointer;}
    .edit:hover, .new:hover{color:green;}
    .delete:hover{color:red;}
</style>
<span class="card-title center-align">Lista de asientos contables de <?= date("d/m/d", strtotime($date))?></span>
<?php
// echo $date . " --";
    // $this->db->join('cuentas as t2', 't2.id = t1.cuenta_id', 'left');
    // $this->db->join('asientos as t3', 't3.id = t1.asiento_id', 'left');
    if ( $asientos = $this->Jesus->dice(array(
        'get'   => 'asientos as t1',
        'where' => array(
            't1.estado'    => 'T',
            // 't3.estado'    => 'T',
            't1.fecha >='  => $date . " 00:00:00",
            't1.fecha <='  => $date . " 23:59:59"
        ),
        'select'    => array(
            't1.descripcion',
            'DATE_FORMAT(t1.fecha,	"%T") as hora',
            // 't1.denominacion as cuenta',
            // 't2.codigo as cuenta_code',
            't1.totalDebe',
            // 't1.haber'
        ),
        'order_by'  => array('t1.id' => 'desc')
    ))->result() ) {
        $asiento_descripcion = "";
        foreach( $asientos as $asientos_ ) {
            /*
            if ( $asiento_descripcion != $asientos_->descripcion)
                $this->table->add_row(array(
                    'data'      => $asiento_descripcion = $asientos_->descripcion,
                    'colspan'   => '4',
                    'style'     => "text-align:center; fotn-style:bold;"
                ));
            */
            $this->table->add_row(array(
                $asientos_->hora,
                $asientos_->descripcion,
                '0',
                $asientos_->totalDebe
            ));
        }
    // if (true) {
        $this->table->set_heading(array(
            'Horas',
            'Descripciones',
            'Operaciones',
            'Montos'
        ));
        
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>