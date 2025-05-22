<?php 
/**
* clase que genera la insercion y edicion  de supplierlocations en la base de datos
*/
class Administracion_Model_DbTable_Supplierslocations extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_locations';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un supplierlocations y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$name = $data['name'];
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$address = $data['address'];
		$mobile_phone = $data['mobile_phone'];
		$coverage_north = $data['coverage_north'];
		$coverage_east = $data['coverage_east'];
		$coverage_west = $data['coverage_west'];
		$coverage_south = $data['coverage_south'];
		$supplier_id = $data['supplier_id'];
		$updated_at = $data['updated_at'];
		$created_at = $data['created_at'];
		$query = "INSERT INTO supplier_locations( name, country, state, city, address, mobile_phone, coverage_north, coverage_east, coverage_west, coverage_south, supplier_id, updated_at, created_at) VALUES ( '$name', '$country', '$state', '$city', '$address', '$mobile_phone', '$coverage_north', '$coverage_east', '$coverage_west', '$coverage_south', '$supplier_id', '$updated_at', '$created_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un supplierlocations  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$name = $data['name'];
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$address = $data['address'];
		$mobile_phone = $data['mobile_phone'];
		$coverage_north = $data['coverage_north'];
		$coverage_east = $data['coverage_east'];
		$coverage_west = $data['coverage_west'];
		$coverage_south = $data['coverage_south'];
		$supplier_id = $data['supplier_id'];
		$updated_at = $data['updated_at'];
		$created_at = $data['created_at'];
		$query = "UPDATE supplier_locations SET  name = '$name', country = '$country', state = '$state', city = '$city', address = '$address', mobile_phone = '$mobile_phone', coverage_north = '$coverage_north', coverage_east = '$coverage_east', coverage_west = '$coverage_west', coverage_south = '$coverage_south', supplier_id = '$supplier_id', updated_at = '$updated_at', created_at = '$created_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}