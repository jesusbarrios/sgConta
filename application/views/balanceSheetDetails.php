<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<?php
    $this->table->add_row(array(
        'data'  => '<h5>Balance General</h5>',
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
        'data'  => "<b>Periodo del balance:</b> 01/01/" . $ejercicio . " al " . date('d/m/Y', strtotime($until)),
        'colspan'   => '100%',
        'style'     => 'text-align:left'
    ));

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
            "if(t1.imputable, (SELECT FORMAT(SUM(st1.debe), 0, 'de_DE') FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio_id AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), '') as debe",
            // Haber
            "if(t1.imputable, (SELECT FORMAT(SUM(st1.haber), 0, 'de_DE') FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio_id AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), '') as haber",
            // Saldo
            "if(t1.imputable, FORMAT((SELECT SUM(st1.debe) FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio_id AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T') - (SELECT SUM(st1.haber) FROM asientoDetalles as st1 INNER JOIN asientos as st2 ON st2.id = st1.asiento_id AND st2.ejercicio_id = $ejercicio_id AND st2.fecha <= '$until' WHERE st1.cuenta_id = t1.id AND st1.estado = 'T'), 0, 'de_DE'), '') as saldo"
        ),
        'order_by'  => array('t1.codigo' => 'asc')
    ));
    if ( $cuentas->result() ) {
        $this->table->add_row(
            array(
                'data'  => 'Códigos',
                'style' => 'text-align:center; font-weight:bold'
            ),
            array(
                'data'  => 'Cuentas',
                'style' => 'text-align:center; font-weight:bold'
            ),
            array(
                'data'  => 'Debe',
                'style' => 'text-align:center; font-weight:bold'
            ),
            array(
                'data'  => 'Haber',
                'style' => 'text-align:center; font-weight:bold'
            ),
            array(
                'data'  => 'Saldo',
                'style' => 'text-align:center; font-weight:bold'
            )
        );
        $asiento_descripcion = "";
        $imputable = false;
        $debe = $haber = $saldo = 0;
        foreach( $cuentas->result() as $cuentas_ ) {
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
    } else
        $this->table->add_row(array('Sin registros'));
        
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", id="balance" class= "balance responsive-table centered highlight">'));
    echo $this->table->generate();
?>