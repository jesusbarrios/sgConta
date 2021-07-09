<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>

<?php
    $this->table->add_row(array(
        'data'  => '<h5>Libro diario</h5>',
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
        'data'  => "<b>Periodo del libro diario:</b> " . date('d/m/Y', strtotime($since)) . " al " . date('d/m/Y', strtotime($until)),
        'colspan'   => '100%',
        'style'     => 'text-align:left'
    ));
    $asientos = $this->Jesus->dice(array(
        'get'   => 'asientos as t1',
        'where' => array(
            't1.estado' => 'T',
            't1.fecha >='  => $since,
            't1.fecha <='  => $until
        ),
        'select'    => array(
            't1.id',
            't1.descripcion',
            'CONCAT("-", t1.numero, "-") as numero',
            // 'CONCAT(DATE_FORMAT(t1.fecha,	"%W %d/%c/%Y"), t1.numero, ", ", t1.descripcion) as descripcion',
            'FORMAT(t1.totalDebe, 0, "de_DE") as totalDebe',
            'FORMAT(t1.totalHaber, 0, "de_DE") as totalHaber',
            '(SELECT COUNT(t2.id) FROM asientoDetalles as t2 WHERE t2.asiento_id = t1.id) as cuentas',
            'DATE_FORMAT(t1.fecha,	"%W %d/%c/%Y") as fecha',
        ),
        'order_by'  => array('t1.fecha' => 'asc', 't1.numero' => 'asc')
    ));
    if ( $asientos->result() ) {
        // Cabecera
        $this->table->add_row(
            array(
                'data'  => 'Fechas',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                'data'  => 'Conceptos',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                'data'  => 'Debe',
                'style' => 'text-align:center; font-weight:bold;'
            ),
            array(
                'data'  => 'Haber',
                'style' => 'text-align:center; font-weight:bold;'
            )
        );
        // echo 'hola mundo';

        $asiento_descripcion = "";
        foreach( $asientos->result() as $asientos_ ) {

            $this->table->add_row(array(
                array(
                    'data' => $asientos_->fecha,
                    'style' => 'text-align:center; font-weight:bold;',
                    'class' => 'red lighten-5'
                ),
                array(
                    'data' => $asientos_->numero,
                    'style' => 'text-align:center; font-weight:bold;',
                    'class' => 'red lighten-5'
                ),
                array(
                    'class' => 'red lighten-5',
                    'colspan'   => '2'
                )
            ));
            /*$this->table->add_row(array(
                array(
                    'data' => $asientos_->descripcion,
                    'colspan'   => '100%'
                )
            ));*/

            $this->db->join('cuentas as t2', 't2.id = t1.cuenta_id', 'left');
            $operaciones = $this->Jesus->dice(array(
                'get'       => 'asientoDetalles as t1',
                'where'     => array(
                    't1.asiento_id'    => $asientos_->id,
                    't1.estado'        => 'T'
                ),
                'order_by'  => array('t1.id' => 'asc'),
                'select'    => array(
                    // 't2.codigo',
                    // 't2.denominacion',
                    'concat(t2.codigo, " ", t2.denominacion) as denominacion',
                    'if(t1.debe, FORMAT(t1.debe, 0, "de_DE"), "-----") as debe',
                    'if(t1.haber, FORMAT(t1.haber, 0, "de_DE"), "-----") as haber',
                    'if(t1.debe, "0em;", "3em;") as padding',
                )
            ));

            if ( $operaciones->result() ) {
                foreach($operaciones->result() as $operaciones_ ){
                    $this->table->add_row(array(
                        false,
                        array(
                            'data' => $operaciones_->denominacion,
                            // 'style' => 'text-align:left; font-style:italic; padding-left:' . $operaciones_->padding,
                            'style' => 'text-align:left; padding-left:' . $operaciones_->padding,
                        ),
                        array(
                            'data' => $operaciones_->debe,
                            // 'style' => 'text-align:center; font-style:italic;'
                            'style' => 'text-align:center;'
                        ),
                        array(
                            'data' => $operaciones_->haber,
                            // 'style' => 'text-align:center; font-style:italic;'
                            'style' => 'text-align:center;'
                        )
                    ));

                    $data = array();
                }
            }
           
            $this->table->add_row(array(
                // false,
                array(
                    'data' => '<b>Total por </b>' . $asientos_->descripcion . ":",
                    // 'style' => 'text-align:center;',
                    'style' => 'text-align:left;',
                    'colspan'   => '2'
                ),
                array(
                    'data' => $asientos_->totalDebe,
                    'style' => 'text-align:center; font-weight:bold;',
                    'colspan'   => '1'
                ),
                array(
                    'data' => $asientos_->totalHaber,
                    'style' => 'text-align:center; font-weight:bold;',
                    'colspan'   => '1'
                ),
            ));
        }
    } else
        $this->table->add_row(array('Sin registros'));

    $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", id="libroDiario" class= "responsive-table centered highlight">'));
    echo $this->table->generate();
?>