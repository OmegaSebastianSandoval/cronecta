<?php

/**
 * clase que genera la insercion y edicion  de commercial segments en la base de datos
 */
class Administracion_Model_DbTable_Commercialsegments extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'commercial_segments';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un commercial segment y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$segment_code = $data['segment_code'];
		$segment_name = $data['segment_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$sector_id = $data['sector_id'];
		$query = "INSERT INTO commercial_segments( segment_code, segment_name, created_at, updated_at, sector_id) VALUES ( '$segment_code', '$segment_name', '$created_at', '$updated_at', '$sector_id')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un commercial segment  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$segment_code = $data['segment_code'];
		$segment_name = $data['segment_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$sector_id = $data['sector_id'];
		$query = "UPDATE commercial_segments SET  segment_code = '$segment_code', segment_name = '$segment_name', created_at = '$created_at', updated_at = '$updated_at', sector_id = '$sector_id' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	/**
	 * Obtiene los segmentos activos ordenados por nombre
	 * @return array Array con los segmentos activos
	 */
	public function getActiveSegments()
	{
		$query = "SELECT segment_code, segment_name FROM commercial_segments ORDER BY segment_name ASC";
		$res = $this->_conn->query($query)->fetchAsObject();
		return $res;
	}
}
