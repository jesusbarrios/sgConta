<!-- Lista de ejercicios contables -->
<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<span class="card-title center-align">Libro Mayor</span>
<?php
    $this->db->join('cuentas as t2', 't2.id = t1.cuenta_id', 'left');
    $this->db->join('asientos as t3', 't3.id = t1.asiento_id', 'left');
    $asientos = $this->Jesus->dice(array(
        'get'   => 'asientoDetalles as t1',
        'where' => array(
            't1.estado' => 'T',
            't3.estado' => 'T',
            't2.estado' => 'T',
            't2.imputable !=' => 'T',
            // 't1.fecha >='  => $desde,
            // 't1.fecha <='  => $hasta
            't3.fecha >='  => '2021-06-15',
            't3.fecha <='  => '2021-06-15'
        ),
        'select'    => array(
            't2.denominacion as cuenta',
            't1.id',
            // 't1.descripcion',
            'CONCAT("-", t3.numero, "-") as numero',
            // 'CONCAT(DATE_FORMAT(t1.fecha,	"%W %d/%c/%Y"), t1.numero, ", ", t1.descripcion) as descripcion',
            'FORMAT(t1.debe, 0, "de_DE") as debe',
            'FORMAT(t1.haber, 0, "de_DE") as haber',
            // '(SELECT COUNT(t2.id) FROM asientoDetalles as t2 WHERE t2.asiento_id = t1.id) as cuentas',
            'DATE_FORMAT(t3.fecha,	"%W %d/%c/%Y") as fecha',
        ),
        'order_by'  => array('t1.cuenta_id' => 'asc', 't3.numero' => 'asc')
    ));
    if ( $asientos->result() ) {
        $cuenta = "";
        foreach( $asientos->result() as $asientos_ ) {
            if ( $asientos_->cuenta != $cuenta ){
                $cuenta = $asientos_->cuenta;
                $this->table->add_row(array(
                    array(
                        'data' => $asientos_->cuenta,
                        'style' => 'text-align:center; font-weight:bold;',
                        'class' => 'red lighten-5',
                        'colspan'   => '100%',
                    )
                ));
            }
            $this->table->add_row(array(
                array(
                    'data' => $asientos_->fecha,
                    'style' => 'text-align:center;',
                    'colspan'   => '1'
                ),
                array(
                    'data' => $asientos_->numero,
                    'style' => 'text-align:center;',
                    'colspan'   => '1'
                ),
                array(
                    'data' => $asientos_->debe,
                    'style' => 'text-align:center;',
                    'colspan'   => '1'
                ),
                array(
                    'data' => $asientos_->haber,
                    'style' => 'text-align:center;',
                    'colspan'   => '1'
                ),
            ));
        }
        $this->table->set_heading(array(
            array(
                'data' => 'Fechas'
            ),
            array(
                'data' => 'Números de <br>Asientos'
            ),
            array(
                'data' => 'Debe'
            ),
            array(
                'data' => 'Haber'
            )
        ));
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>