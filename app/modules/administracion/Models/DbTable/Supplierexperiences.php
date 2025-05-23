<?php 
/**
* clase que genera la insercion y edicion  de supplierexperiences en la base de datos
*/
class Administracion_Model_DbTable_Supplierexperiences extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_experiences';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un supplierexperiences y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$company_name = $data['company_name'];
		$industry = $data['industry'];
		$segments = $data['segments'];
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$contract_start_year = $data['contract_start_year'];
		$contract_end_year = $data['contract_end_year'];
		$contract_object = $data['contract_object'];
		$contract_value = $data['contract_value'];
		$currency = $data['currency'];
		$document_file = $data['document_file'];
		$document_file_udate = $data['document_file_udate'];
		$supplier_id = $data['supplier_id'];
		$updated_at = $data['updated_at'];
		$created_at = $data['created_at'];
		$query = "INSERT INTO supplier_experiences( company_name, industry, segments, country, state, city, contract_start_year, contract_end_year, contract_object, contract_value, currency, document_file, document_file_udate, supplier_id, updated_at, created_at) VALUES ( '$company_name', '$industry', '$segments', '$country', '$state', '$city', '$contract_start_year', '$contract_end_year', '$contract_object', '$contract_value', '$currency', '$document_file', '$document_file_udate', '$supplier_id', '$updated_at', '$created_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un supplierexperiences  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$company_name = $data['company_name'];
		$industry = $data['industry'];
		$segments = $data['segments'];
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$contract_start_year = $data['contract_start_year'];
		$contract_end_year = $data['contract_end_year'];
		$contract_object = $data['contract_object'];
		$contract_value = $data['contract_value'];
		$currency = $data['currency'];
		$document_file = $data['document_file'];
		$document_file_udate = $data['document_file_udate'];
		$supplier_id = $data['supplier_id'];
		$updated_at = $data['updated_at'];
		$created_at = $data['created_at'];
		$query = "UPDATE supplier_experiences SET  company_name = '$company_name', industry = '$industry', segments = '$segments', country = '$country', state = '$state', city = '$city', contract_start_year = '$contract_start_year', contract_end_year = '$contract_end_year', contract_object = '$contract_object', contract_value = '$contract_value', currency = '$currency', document_file = '$document_file', document_file_udate = '$document_file_udate', supplier_id = '$supplier_id', updated_at = '$updated_at', created_at = '$created_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}