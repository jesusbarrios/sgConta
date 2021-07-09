<style>
    .material-icons{cursor:pointer;}
    i:hover{color:gray;}
</style>
<?php
    $this->table->add_row(array(
        'data'  => '<h5>Balance de resultado</h5>',
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
    $this->db->join('asientos    as t2', 't2.id = t1.asiento_id', 'left');
    $this->db->join('cuentas     as t3', 't3.id = t1.cuenta_id', 'left');
    $cuentas = $this->Jesus->dice(array(
        'get'   => ' asientoDetalles as t1',
        'where' => array(
            't1.estado'         => 'T',
            't2.estado'         => 'T',
            't2.fecha <='       => $until,
            't2.ejercicio_id'   => $ejercicio_id
        ),
        'group_by'  => array('t1.cuenta_id'),
        'select'    => array(
            't1.cuenta_id',
            't3.codigo',
            't3.denominacion',
            't1.debe',
            't1.haber'
        ),
        'order_by'  => array('t3.codigo' => 'asc')
    ));
    if ( $cuentas->result() ) {
        $asiento_descripcion = "";
        $imputable = false;
        $debe = $haber = $saldo = 0;
        $debe   = array();
        $haber  = array();
        $key = 0;
        // Cabecera
        $this->table->add_row(
            array(
                'data'  => 'Activos',
                'style' => 'font-weight:bold;'
            ),
            array(
                'data'  => 'Pasivos',
                'style' => 'font-weight:bold;'
            ),
            array(
                'data'  => 'Patrimonio Neto',
                'style' => 'font-weight:bold;'
            )
        );
        foreach( $cuentas->result() as $cuentas_ ) {
            $key = substr($cuentas_->codigo, 0, 2);
            if ( !array_key_exists($key, $debe) ) {
                $debe[strval($key)] = 0;
                $haber[strval($key)] = 0;
            }
            $debe[strval($key)]     += $cuentas_->debe;
            $haber[strval($key)]    += $cuentas_->haber;
        }

        $activoDebe = $activoHaber = $pasivoDebe = $pasivoHaber = 0;
        if ( array_key_exists('01', $debe) ) {
            $activoDebe = $debe['01'];
            $activoHaber = $haber['01'];
        }
        if ( array_key_exists('02', $debe) ) {
            $pasivoDebe  = $debe['02'];
            $pasivoHaber = $haber['02'];
        }

        $this->table->add_row(array(
            number_format($activoDebe - $activoHaber, 0, ',', '.'),
            number_format($pasivoHaber - $pasivoDebe, 0, ',', '.'),
            number_format(($activoDebe - $activoHaber) - ($pasivoHaber - $pasivoDebe), 0, ',', '.')
        ));

        $this->table->add_row(array('data' => 'hola', 'style' => 'display:none'));

/*
        print_r($debe);
        echo br();
        print_r($haber);
*/
    } else
        $this->table->add_row(array('Sin registros'));
        
        $this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", id="balance" class= "balance responsive-table centered highlight">'));
    echo $this->table->generate();
?>