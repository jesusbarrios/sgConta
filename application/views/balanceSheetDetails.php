<!-- Lista de ejercicios contables -->
<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<!-- <span class="card-title center-align">Libro Diario</span> -->
<?php
    $cuentas = $this->Jesus->dice(array(
        'get'   => 'cuentas as t1',
        'where' => array(
            't1.estado' => 'T',
            // 't1.fecha >='  => $desde,
            // 't1.fecha <='  => $hasta
            // 't1.fecha >='  => '2021-06-15',
            // 't1.fecha <='  => '2021-06-15'
        ),
        'select'    => array(
            't1.id',
            't1.denominacion',
            't1.imputable',
            't1.codigo',
            // Style
            'if(t1.imputable, "text-align:left;", "text-align:left; font-weight:bold;") as style',
            // Debe
            'if(t1.imputable, (SELECT FORMAT(SUM(st1.debe), 0, "de_DE") FROM asientoDetalles as st1 WHERE st1.cuenta_id = t1.id AND st1.estado = "T"), "") as debe',
            // Haber
            'if(t1.imputable, (SELECT FORMAT(SUM(st1.haber), 0, "de_DE") FROM asientoDetalles as st1 WHERE st1.cuenta_id = t1.id AND st1.estado = "T"), "") as haber',
            // Saldo
            'if(t1.imputable, FORMAT((SELECT SUM(st1.debe) FROM asientoDetalles as st1 WHERE st1.cuenta_id = t1.id AND st1.estado = "T") - (SELECT SUM(st1.haber) FROM asientoDetalles as st1 WHERE st1.cuenta_id = t1.id AND st1.estado = "T"), 0, "de_DE"), "") as saldo'
        ),
        'order_by'  => array('t1.codigo' => 'asc')
    ));
    if ( $cuentas->result() ) {
        $asiento_descripcion = "";
        $imputable = false;
        $debe = $haber = $saldo = 0;
        foreach( $cuentas->result() as $cuentas_ ) {
            if ( !$cuentas_->imputable) {
                if ( $imputable )
                    $this->table->add_row(array(
                        false,
                        array(
                            'data'  => 'Total',
                            'style' => 'text-align:right; font-weight:bold;'
                        ),
                        array(
                            'data'  => number_format($debe, 0, ',', '.'),
                            'style' => 'text-align:right; font-weight:bold;'
                        ),
                        array(
                            'data'  => number_format($haber, 0, ',', '.'),
                            'style' => 'text-align:right; font-weight:bold;'
                        ),
                        array(
                            'data'  => number_format($saldo, 0, ',', '.'),
                            'style' => 'text-align:right; font-weight:bold;'
                        )
                    ));
                $imputable = $cuentas_->id;
                $debe = $haber = $saldo = 0;
            }
            $debe   += (int) str_replace('.', '', $cuentas_->debe);
            $haber  += (int) str_replace('.', '', $cuentas_->haber);
            $saldo  += (int) str_replace('.', '', $cuentas_->saldo);

            $this->table->add_row(array(
                array(
                    'data' => $cuentas_->codigo,
                    'style' => $cuentas_->style
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data' => $cuentas_->denominacion,
                    'style' => $cuentas_->style
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->debe,
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->haber,
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->saldo,
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                )
            ));
        }
        if ( $imputable )
            $this->table->add_row(array(
                false,
                array(
                    'data'  => 'Total',
                    'style' => 'text-align:right; font-weight:bold;'
                ),
                array(
                    'data'  => number_format($debe, 0, ',', '.'),
                    'style' => 'text-align:right; font-weight:bold;'
                ),
                array(
                    'data'  => number_format($haber, 0, ',', '.'),
                    'style' => 'text-align:right; font-weight:bold;'
                ),
                array(
                    'data'  => number_format($saldo, 0, ',', '.'),
                    'style' => 'text-align:right; font-weight:bold;'
                )
            ));
        $this->table->set_heading(array(
            'Códigos',
            'Cuentas',
            'Debe',
            'Haber',
            'Saldo'
        ));
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>