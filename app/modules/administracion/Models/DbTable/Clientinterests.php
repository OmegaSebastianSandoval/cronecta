<?php 
/**
* clase que genera la insercion y edicion  de client interests en la base de datos
*/
class Administracion_Model_DbTable_Clientinterests extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'client_interests';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un client interest y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$client_id = $data['client_id'];
		$code = $data['code'];
		$name = $data['name'];
		$created_at = $data['created_at'] = date("Y-m-d H:i:s");
		$updated_at = $data['updated_at'] = date("Y-m-d H:i:s");
		$level = $data['level'];
		$query = "INSERT IGNORE INTO client_interests( client_id, code, name, created_at, updated_at, level) VALUES ( '$client_id', '$code', '$name', '$created_at', '$updated_at', '$level')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un client interest  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$client_id = $data['client_id'];
		$code = $data['code'];
		$name = $data['name'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$level = $data['level'];
		$query = "UPDATE client_interests SET  client_id = '$client_id', code = '$code', name = '$name', created_at = '$created_at', updated_at = '$updated_at', level = '$level' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}