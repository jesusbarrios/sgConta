<?php
class Jesus extends CI_Model{
	/*
	PARA INSERTAR
	$consulta = array(
		'insert'	=> array('documentoTipos' => array('concepto' => 'test', 'abreviacion' => 't', 'fecha' => date('Y-m-d'))),
	);

	DELETE
	$consulta = array(
		'delete'	=> 'documentoTipos',
		'where'		=> array('id' => 39),
	);

	GET
	$consulta = array(
		'get' 		=> 'carreraDetalles',
		// 'group_by' 	=> array('carrera'),
		// 'select' 	=> array('id', 'carrera', 'sede'),
		'order_by' 	=> array('carrera' => 'desc'), 
		// 'where' 	=> array('carrera' => 5, 'sede' => false, 'turno' => false),
		// 'where' 	=> array('carrera' => 5),
		// 'where_not_in'	=> array('carrera' => array(3, 4)),
		'join'		=> array('carreras as t2' => 't2.id = t1.carrera'),
	);
	*/

	function dice($consult){
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		foreach (array_filter($consult, function($e){return is_array($e);}) as $key => $value)//no se toca
			if($this->is_assoc($value))
				foreach (array_filter($value, function($e){return ($e !== false);}) as $key2 => $value2)
					$this->db->$key($key2, $value2);
			else
				$this->db->$key($value);

		foreach (array_filter($consult, function($e){return !is_array($e);}) as $key => $value)//no se toca
			return $this->db->$key($value);//no se toca
	}

	function is_assoc( $array ) {
		//-----
		//Metodo I: Para todos los escalares que siguen la secuencia desde cero,
		//-----
		return array_keys( $array ) !== range( 0, count($array) - 1 );

		//-----
		//FILTRO II: Identifica si todos son enteros
		//-----
		/*foreach(array_keys($array) as $key)
			if (!is_int($key)) return true;
		return false;*/
	}
}
?>