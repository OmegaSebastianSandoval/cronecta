<?php

/**
 * clase que genera la insercion y edicion  de commercial families en la base de datos
 */
class Administracion_Model_DbTable_Commercialfamilies extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'commercial_families';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un commercial family y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$segment_code = $data['segment_code'];
		$family_code = $data['family_code'];
		$family_name = $data['family_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO commercial_families( segment_code, family_code, family_name, created_at, updated_at) VALUES ( '$segment_code', '$family_code', '$family_name', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un commercial family  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$segment_code = $data['segment_code'];
		$family_code = $data['family_code'];
		$family_name = $data['family_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE commercial_families SET  segment_code = '$segment_code', family_code = '$family_code', family_name = '$family_name', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	/**
	 * Obtiene las familias activas ordenadas por nombre
	 * @return array Array con las familias activas
	 */
	public function getActiveFamilies()
	{
		$query = "SELECT family_code, family_name FROM commercial_families ORDER BY family_name ASC";
		$res = $this->_conn->query($query)->fetchAsObject();

		return $res;
	}
}
