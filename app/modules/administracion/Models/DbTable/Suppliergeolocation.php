<?php 
/**
* clase que genera la insercion y edicion  de supplier geolocations en la base de datos
*/
class Administracion_Model_DbTable_Suppliergeolocation extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_geolocation';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un supplier geolocation y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$level = $data['level'];
		$query = "INSERT INTO supplier_geolocation( supplier_id, name, level) VALUES ( '$supplier_id', '$name', '$level')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un supplier geolocation  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$level = $data['level'];
		$query = "UPDATE supplier_geolocation SET  supplier_id = '$supplier_id', name = '$name', level = '$level' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}