<?php

/**
 * clase que genera la insercion y edicion  de commercial classes en la base de datos
 */
class Administracion_Model_DbTable_Commercialclasses extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'commercial_classes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un commercial class y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$family_code = $data['family_code'];
		$class_code = $data['class_code'];
		$class_name = $data['class_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO commercial_classes( family_code, class_code, class_name, created_at, updated_at) VALUES ( '$family_code', '$class_code', '$class_name', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un commercial class  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$family_code = $data['family_code'];
		$class_code = $data['class_code'];
		$class_name = $data['class_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE commercial_classes SET  family_code = '$family_code', class_code = '$class_code', class_name = '$class_name', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	/**
	 * Obtiene las clases activas ordenadas por nombre
	 * @return array Array con las clases activas
	 */
	public function getActiveClasses()
	{
		$query = "SELECT class_code, class_name FROM commercial_classes ORDER BY class_name ASC";
		$res = $this->_conn->query($query)->fetchAsObject();
		return $res;
	}
}
