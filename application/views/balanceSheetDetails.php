<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<?php

    $cuentas = $this->Jesus->dice(array(
        'get'   => 'cuentas as t1',
        'where' => array(
            't1.estado'     => 'T',
            // 't1.imputable'  => '1'
            // 't1.fecha <='   => $until,
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
            "if(t1.imputable, (SELECT FORMAT(SUM(st1.debe), 0, 'de_DE') FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), '') as debe",
            // Haber
            "if(t1.imputable, (SELECT FORMAT(SUM(st1.haber), 0, 'de_DE') FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), '') as haber",
            // Saldo
            "if(t1.imputable, FORMAT((SELECT SUM(st1.debe) FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T') - (SELECT SUM(st1.haber) FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), 0, 'de_DE'), '') as saldo"
        ),
        'order_by'  => array('t1.codigo' => 'asc')
    ));
    if ( $cuentas->result() ) {
        $asiento_descripcion = "";
        $imputable = false;
        $debe = $haber = $saldo = 0;
        $this->table->set_caption("Balance hasta " . date('d/m/Y', strtotime($until)));
        foreach( $cuentas->result() as $cuentas_ ) {
            // $padding = (strlen($cuentas_->codigo) - 2);
            /*if ( !$cuentas_->imputable) {
                // if ( $imputable )
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
            }*/
            /*$debe   += (int) str_replace('.', '', $cuentas_->debe);
            $haber  += (int) str_replace('.', '', $cuentas_->haber);
            $saldo  += (int) str_replace('.', '', $cuentas_->saldo);*/

            $this->table->add_row(array(
                array(
                    // 'data'  => $cuentas_->codigo,
                    'data'  => str_pad($cuentas_->codigo, 8, '0', STR_PAD_RIGHT),
                    // 'style' => $cuentas_->style
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->denominacion,
                    'style' => $cuentas_->style . ' padding-left:' . (strlen($cuentas_->codigo) - 2) . 'em;'
                    // 'style' => 'text-align:left; padding-left:' . $operaciones_->padding,
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->debe?     $cuentas_->debe     : ($cuentas_->imputable? '0' : ''),
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->haber?    $cuentas_->haber    : ($cuentas_->imputable? '0' : ''),
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                ),
                array(
                    'data'  => $cuentas_->saldo?    $cuentas_->saldo    : ($cuentas_->imputable? '0' : ''),
                    'style' => 'text-align:right;'
                    // 'class' => 'red lighten-5'
                )
            ));
        }
        /*if ( $imputable )
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
            ));*/
        $this->table->set_heading(array(
            'Códigos',
            'Cuentas',
            'Debe',
            'Haber',
            'Saldo'
        ));
    } else
        $this->table->add_row(array('Sin registros'));
        
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", id="balance" class= "balance responsive-table centered highlight">'));
    echo $this->table->generate();
?>