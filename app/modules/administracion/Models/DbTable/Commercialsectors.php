<?php

/**
 * clase que genera la insercion y edicion  de commercial sectors en la base de datos
 */
class Administracion_Model_DbTable_Commercialsectors extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'commercial_sectors';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un commercial sector y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$name = $data['name'];
		$query = "INSERT INTO commercial_sectors( name) VALUES ( '$name')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un commercial sector  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$name = $data['name'];
		$query = "UPDATE commercial_sectors SET  name = '$name' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	/**
	 * Obtiene los sectores activos ordenados por nombre
	 * @return array Array con los sectores activos
	 */
	public function getActiveSectors()
	{
		$query = "SELECT id, name FROM commercial_sectors ORDER BY name ASC";
		$res = $this->_conn->query($query)->fetchAsObject();
		return $res;
	}

	public function query($sql)
	{
		return $this->_conn->query($sql)->fetchAsObject();
	}
}
