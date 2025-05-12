<?php 
/**
* clase que genera la insercion y edicion  de supplierusers en la base de datos
*/
class Administracion_Model_DbTable_Supplierusers extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_users';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un supplierusers y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$lastname = $data['lastname'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$password = $data['password'];
		$phone = $data['phone'];
		$document = $data['document'];
		$status = $data['status'];
		$area = $data['area'];
		$remember_token = $data['remember_token'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO supplier_users( supplier_id, name, lastname, email, email_verified_at, password, phone, document, status, area, remember_token, created_at, updated_at) VALUES ( '$supplier_id', '$name', '$lastname', '$email', '$email_verified_at', '$password', '$phone', '$document', '$status', '$area', '$remember_token', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un supplierusers  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$lastname = $data['lastname'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$password = $data['password'];
		$phone = $data['phone'];
		$document = $data['document'];
		$status = $data['status'];
		$area = $data['area'];
		$remember_token = $data['remember_token'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE supplier_users SET  supplier_id = '$supplier_id', name = '$name', lastname = '$lastname', email = '$email', email_verified_at = '$email_verified_at', password = '$password', phone = '$phone', document = '$document', status = '$status', area = '$area', remember_token = '$remember_token', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}