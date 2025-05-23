<?php 
/**
* clase que genera la insercion y edicion  de suppliercertificates en la base de datos
*/
class Administracion_Model_DbTable_Suppliercertificates extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_certifications';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliercertificates y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$type = $data['type'];
		$start_date = $data['start_date'];
		$end_date = $data['end_date'];
		$certification_file = $data['certification_file'];
		$certification_file_udate = date('Y-m-d H:i:s');
		$comment = $data['comment'];
		$created_at = date('Y-m-d H:i:s');
		$updated_at = date('Y-m-d H:i:s');
		$query = "INSERT INTO supplier_certifications( supplier_id, type, start_date, end_date, certification_file, certification_file_udate, comment, created_at, updated_at) VALUES ( '$supplier_id', '$type', '$start_date', '$end_date', '$certification_file', '$certification_file_udate', '$comment', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliercertificates  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$type = $data['type'];
		$start_date = $data['start_date'];
		$end_date = $data['end_date'];
		$certification_file = $data['certification_file'];
		$certification_file_udate = $data['certification_file_udate'];
		$comment = $data['comment'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE supplier_certifications SET  supplier_id = '$supplier_id', type = '$type', start_date = '$start_date', end_date = '$end_date', certification_file = '$certification_file', certification_file_udate = '$certification_file_udate', comment = '$comment', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}