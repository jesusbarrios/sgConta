
<?php
    $this->table->add_row(array(
        'data'  => '<h5>Libro Mayor</h5>',
        'colspan'   => '3',
        'style'     => 'text-align:center; display:none;'
    ));
    $this->table->add_row(array(
        'data'  => '<b>Razon social:</b> Fiuni Informática',
        'colspan'   => '100%',
        'style'     => 'text-align:left; display:none;'
    ));
    $this->table->add_row(array(
        'data'  => '<b>RUC:</b> 80059425-2',
        'colspan'   => '100%',
        'style'     => 'text-align:left; display:none;'
    ));
    $this->table->add_row(array(
        'data'  => "<b>Ejercicio fiscal:</b> $ejercicio",
        'colspan'   => '100%',
        'style'     => 'text-align:left; display:none;'
    ));
    $this->table->add_row(array(
        'data'  => "<b>Periodo del libro mayor:</b> " . date('d/m/Y', strtotime($since)) . " al " . date('d/m/Y', strtotime($until)),
        'colspan'   => '100%',
        'style'     => 'text-align:left'
    ));

    $this->db->join('cuentas as t2', 't2.id = t1.cuenta_id', 'left');
    $this->db->join('asientos as t3', 't3.id = t1.asiento_id', 'left');
    $asientos = $this->Jesus->dice(array(
        'get'   => 'asientoDetalles as t1',
        'where' => array(
            't1.estado' => 'T',
            't3.estado' => 'T',
            't2.estado' => 'T',
            't2.imputable !=' => 'T',
            // 't1.cuenta'         => $cuentas,
            't3.fecha >='  => $since,
            't3.fecha <='  => $until
        ),
        'where_in'  => array('t1.cuenta_id' => $cuentas),
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
        $this->table->add_row(array(
            array(
                'data' => 'Fechas',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                // 'data' => 'Números de <br>Asientos'
                'data' => 'Asientos',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                'data' => 'Debe',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                'data' => 'Haber',
                'style' => 'text-align:center; font-weight:bold;'
            )
        ));
        // echo $asientos->num_rows();
        // return;
        $cuenta = false;
        $debe = $haber = 0;
        foreach( $asientos->result() as $asientos_ ) {
            if ( $asientos_->cuenta != $cuenta ){
                if ( $cuenta )
                    $this->table->add_row(
                        false,
                        array(
                            'data'      => 'Total',
                            'style'     => 'text-align:right; font-weight:bold;'
                        ),
                        array(
                            'data'      => number_format($debe, 0, ',', '.'),
                            'style'     => 'text-align:right; font-weight:bold;'
                        ),
                        array(
                            'data'      => number_format($haber, 0, ',', '.'),
                            'style'     => 'text-align:right; font-weight:bold;'
                        )
                    );
                $cuenta = $asientos_->cuenta;
                $this->table->add_row(array(
                    array(
                        'data' => $asientos_->cuenta,
                        'style' => 'text-align:center; font-weight:bold;',
                        'class' => 'red lighten-5',
                        'colspan'   => '100%',
                    )
                ));
                $debe = $haber = 0;
            }
            $debe += (int) str_replace('.', '', $asientos_->debe);
            $haber += (int) str_replace('.', '', $asientos_->haber);
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
                    'style' => 'text-align:right;',
                    'colspan'   => '1'
                ),
                array(
                    'data' => $asientos_->haber,
                    'style' => 'text-align:right;',
                    'colspan'   => '1'
                ),
            ));
        }
        $this->table->add_row(
            false,
            array(
                'data'      => 'Total',
                'style'     => 'text-align:right; font-weight:bold;'
            ),
            array(
                'data'      => number_format($debe, 0, ',', '.'),
                'style'     => 'text-align:right; font-weight:bold;'
            ),
            array(
                'data'      => number_format($haber, 0, ',', '.'),
                'style'     => 'text-align:right; font-weight:bold;'
            )
        );
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", id="libroMayor" class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>