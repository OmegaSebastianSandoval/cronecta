<?php 
/**
* clase que genera la insercion y edicion  de clientes en la base de datos
*/
class Page_Model_DbTable_Clients extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'clients';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un cliente y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$documentType = $data['documentType'];
		$nit = $data['nit'];
		$name = $data['name'];
		$lastname = $data['lastname'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$bussinesEmail = $data['bussinesEmail'];
		$phone = $data['phone'];
		$whatsapp = $data['whatsapp'];
		$phoneCode = $data['phoneCode'];
		$company = $data['company'];
		$position = $data['position'];
		$area = $data['area'];
		$country = $data['country'];
		$city = $data['city'];
		$password = $data['password'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$rut = $data['rut'];
		$commerce = $data['commerce'];
		$industry_id = $data['industry_id'];
		$state = $data['state'];
		$company_nit = $data['company_nit'];
		$nit_type = $data['nit_type'];
		$company_country = $data['company_country'];
		$company_state = $data['company_state'];
		$company_city = $data['company_city'];
		$query = "INSERT INTO clients( documentType, nit, name, lastname, email, email_verified_at, bussinesEmail, phone, whatsapp, phoneCode, company, position, area, country, city, password, created_at, updated_at, rut, commerce, industry_id, state, company_nit, nit_type, company_country, company_state, company_city) VALUES ( '$documentType', '$nit', '$name', '$lastname', '$email', '$email_verified_at', '$bussinesEmail', '$phone', '$whatsapp', '$phoneCode', '$company', '$position', '$area', '$country', '$city', '$password', '$created_at', '$updated_at', '$rut', '$commerce', '$industry_id', '$state', '$company_nit', '$nit_type', '$company_country', '$company_state', '$company_city')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}


	public function insertar_registro($data){
		$documentType = $data['documentType'];
		$nit = $data['nit'];
		$name = $data['name'];
		$lastname = $data['lastname'];
		$email = $data['email'];
		//$email_verified_at = $data['email_verified_at'];
		$bussinesEmail = $data['bussinesEmail'];
		$phone = $data['phone'];
		$whatsapp = $data['whatsapp'];
		$phoneCode = $data['phoneCode'];
		$company = $data['company'];
		$position = $data['position'];
		$area = $data['area'];
		$country = $data['country'];
		$city = $data['city'];
		$password = password_hash($data['password'], PASSWORD_DEFAULT);
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$rut = $data['rut'];
		//$commerce = $data['commerce'];
		$industry_id = $data['industry_id'];
		$state = $data['state'];
		$company_nit = $data['company_nit'];
		$nit_type = $data['nit_type'];
		$company_country = $data['company_country'];
		$company_state = $data['company_state'];
		$company_city = $data['company_city'];

		$created_at = date("Y-m-d H:i:s");
		$updated_at = date("Y-m-d H:i:s");

		$query = "INSERT INTO clients( documentType, nit, name, lastname, email, bussinesEmail, phone, whatsapp, phoneCode, company, position, area, country, city, password, created_at, updated_at, industry_id, state, company_nit, nit_type, company_country, company_state, company_city) VALUES ( '$documentType', '$nit', '$name', '$lastname', '$email', '$bussinesEmail', '$phone', '$whatsapp', '$phoneCode', '$company', '$position', '$area', '$country', '$city', '$password', '$created_at', '$updated_at', '$industry_id', '$state', '$company_nit', '$nit_type', '$company_country', '$company_state', '$company_city')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}	

	/**
	 * update Recibe la informacion de un cliente  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$documentType = $data['documentType'];
		$nit = $data['nit'];
		$name = $data['name'];
		$lastname = $data['lastname'];
		$email = $data['email'];
		$email_verified_at = $data['email_verified_at'];
		$bussinesEmail = $data['bussinesEmail'];
		$phone = $data['phone'];
		$whatsapp = $data['whatsapp'];
		$phoneCode = $data['phoneCode'];
		$company = $data['company'];
		$position = $data['position'];
		$area = $data['area'];
		$country = $data['country'];
		$city = $data['city'];
		$password = $data['password'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$rut = $data['rut'];
		$commerce = $data['commerce'];
		$industry_id = $data['industry_id'];
		$state = $data['state'];
		$company_nit = $data['company_nit'];
		$nit_type = $data['nit_type'];
		$company_country = $data['company_country'];
		$company_state = $data['company_state'];
		$company_city = $data['company_city'];
		$query = "UPDATE clients SET  documentType = '$documentType', nit = '$nit', name = '$name', lastname = '$lastname', email = '$email', email_verified_at = '$email_verified_at', bussinesEmail = '$bussinesEmail', phone = '$phone', whatsapp = '$whatsapp', phoneCode = '$phoneCode', company = '$company', position = '$position', area = '$area', country = '$country', city = '$city', password = '$password', created_at = '$created_at', updated_at = '$updated_at', rut = '$rut', commerce = '$commerce', industry_id = '$industry_id', state = '$state', company_nit = '$company_nit', nit_type = '$nit_type', company_country = '$company_country', company_state = '$company_state', company_city = '$company_city' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}