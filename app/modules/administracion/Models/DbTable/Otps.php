<?php 
/**
* clase que genera la insercion y edicion  de otps en la base de datos
*/
class Administracion_Model_DbTable_Otps extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'otps';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un otps y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$user_id = $data['user_id'];
		$user_type = $data['user_type'];
		$otp = $data['otp'];
		$expires_at = $data['expires_at'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO otps( user_id, user_type, otp, expires_at, created_at, updated_at) VALUES ( '$user_id', '$user_type', '$otp', '$expires_at', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un otps  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$user_id = $data['user_id'];
		$user_type = $data['user_type'];
		$otp = $data['otp'];
		$expires_at = $data['expires_at'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE otps SET  user_id = '$user_id', user_type = '$user_type', otp = '$otp', expires_at = '$expires_at', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}