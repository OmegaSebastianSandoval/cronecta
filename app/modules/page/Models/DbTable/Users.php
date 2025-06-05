<?php 
/**
* clase que genera la insercion y edicion  de usuarios en la base de datos
*/
class Page_Model_DbTable_Users extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'users';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un usuario y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$name = $data['name'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$password = $data['password'];
		$phone = $data['phone'];
		$document = $data['document'];
		$level = $data['level'];
		$status = $data['status'];
		$remember_token = $data['remember_token'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO users( name, email, email_verified_at, password, phone, document, level, status, remember_token, created_at, updated_at) VALUES ( '$name', '$email', '$email_verified_at', '$password', '$phone', '$document', '$level', '$status', '$remember_token', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un usuario  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$name = $data['name'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$password = $data['password'];
		$phone = $data['phone'];
		$document = $data['document'];
		$level = $data['level'];
		$status = $data['status'];
		$remember_token = $data['remember_token'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE users SET  name = '$name', email = '$email', email_verified_at = '$email_verified_at', password = '$password', phone = '$phone', document = '$document', level = '$level', status = '$status', remember_token = '$remember_token', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}