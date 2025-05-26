<?php 
/**
* clase que genera la insercion y edicion  de suppliershareholders en la base de datos
*/
class Administracion_Model_DbTable_Suppliershareholders extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'shareholders';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliershareholders y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$id_type = $data['id_type'];
		$id_number = $data['id_number'];
		$is_pep = $data['is_pep'];
		$place_expedition = $data['place_expedition'];
		$id_date = $data['id_date'];
		$percentage = $data['percentage'];
		$country = $data['country'];
		$is_legal_entity = $data['is_legal_entity'];
		$counterparty_type = $data['counterparty_type'];
		$isPEP = $data['isPEP'];
		$pep_document = $data['pep_document'];
		$shareholder_document = $data['shareholder_document'];
		$shareholder_document_date = $data['shareholder_document_date'];
		$status = $data['status'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO shareholders( supplier_id, name, id_type, id_number, is_pep, place_expedition, id_date, percentage, country, is_legal_entity, counterparty_type, isPEP, pep_document, shareholder_document, shareholder_document_date, status, created_at, updated_at) VALUES ( '$supplier_id', '$name', '$id_type', '$id_number', '$is_pep', '$place_expedition', '$id_date', '$percentage', '$country', '$is_legal_entity', '$counterparty_type', '$isPEP', '$pep_document', '$shareholder_document', '$shareholder_document_date', '$status', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliershareholders  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$name = $data['name'];
		$id_type = $data['id_type'];
		$id_number = $data['id_number'];
		$is_pep = $data['is_pep'];
		$percentage = $data['percentage'];
		$country = $data['country'];
		$is_legal_entity = $data['is_legal_entity'];
		$counterparty_type = $data['counterparty_type'];
		$isPEP = $data['isPEP'];
		$pep_document = $data['pep_document'];
		$shareholder_document = $data['shareholder_document'];
		$status = $data['status'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE shareholders SET  supplier_id = '$supplier_id', name = '$name', id_type = '$id_type', id_number = '$id_number', is_pep = '$is_pep', percentage = '$percentage', country = '$country', is_legal_entity = '$is_legal_entity', counterparty_type = '$counterparty_type', isPEP = '$isPEP', pep_document = '$pep_document', shareholder_document = '$shareholder_document', status = '$status', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}