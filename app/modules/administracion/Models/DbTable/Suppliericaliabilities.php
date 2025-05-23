<?php

/**
 * clase que genera la insercion y edicion  de suppliericaliabilities en la base de datos
 */
class Administracion_Model_DbTable_Suppliericaliabilities extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_icaliabilities';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliericaliabilities y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$code = $data['code'];
		$fee = $data['fee'];
		$supplier_id = $data['supplier_id'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO supplier_icaliabilities( country, state, city, code, fee, supplier_id, created_at, updated_at) VALUES ( '$country', '$state', '$city', '$code', '$fee', '$supplier_id', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliericaliabilities  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$code = $data['code'];
		$fee = $data['fee'];
		$supplier_id = $data['supplier_id'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE supplier_icaliabilities SET  country = '$country', state = '$state', city = '$city', code = '$code', fee = '$fee', supplier_id = '$supplier_id', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}
}
