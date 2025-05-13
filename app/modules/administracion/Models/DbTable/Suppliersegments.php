<?php 
/**
* clase que genera la insercion y edicion  de suppliersegments en la base de datos
*/
class Administracion_Model_DbTable_Suppliersegments extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_segments';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliersegments y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$segment_id = $data['segment_id'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$industry_id = $data['industry_id'];
		$query = "INSERT INTO supplier_segments( supplier_id, segment_id, created_at, updated_at, industry_id) VALUES ( '$supplier_id', '$segment_id', '$created_at', '$updated_at', '$industry_id')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliersegments  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$segment_id = $data['segment_id'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$industry_id = $data['industry_id'];
		$query = "UPDATE supplier_segments SET  supplier_id = '$supplier_id', segment_id = '$segment_id', created_at = '$created_at', updated_at = '$updated_at', industry_id = '$industry_id' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}