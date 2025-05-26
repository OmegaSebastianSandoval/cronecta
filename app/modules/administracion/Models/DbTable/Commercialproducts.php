<?php 
/**
* clase que genera la insercion y edicion  de commercial products en la base de datos
*/
class Administracion_Model_DbTable_Commercialproducts extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'commercial_products';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un commercial product y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$class_code = $data['class_code'];
		$product_code = $data['product_code'];
		$product_name = $data['product_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO commercial_products( class_code, product_code, product_name, created_at, updated_at) VALUES ( '$class_code', '$product_code', '$product_name', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un commercial product  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$class_code = $data['class_code'];
		$product_code = $data['product_code'];
		$product_name = $data['product_name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE commercial_products SET  class_code = '$class_code', product_code = '$product_code', product_name = '$product_name', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	/**
	 * Obtiene los productos activos ordenados por nombre
	 * @return array Array con los productos activos
	 */
	public function getActiveProducts()
	{
		$query = "SELECT product_code, product_name FROM commercial_products ORDER BY product_name ASC";
		$res = $this->_conn->query($query)->fetchAsObject();
		return $res;
	}
}
