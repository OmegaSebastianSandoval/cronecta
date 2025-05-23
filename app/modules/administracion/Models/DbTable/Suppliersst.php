<?php 
/**
* clase que genera la insercion y edicion  de suppliersst en la base de datos
*/
class Administracion_Model_DbTable_Suppliersst extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_ssts';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliersst y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$supplier_id = $data['supplier_id'];
		$operation_year = $data['operation_year'];
		$fatalities = $data['fatalities'];
		$disabling_accidents = $data['disabling_accidents'];
		$total_incidents = $data['total_incidents'];
		$disability_days = $data['disability_days'];
		$workers_number = $data['workers_number'];
		$manhours = $data['manhours'];
		$risk_level = $data['risk_level'];
		$rating_percentage = $data['rating_percentage'];
		$arl_accident_certificate = $data['arl_accident_certificate'];
		$arl_accident_certificate_date = $data['arl_accident_certificate_date'];
		$arl_affiliation_certificate = $data['arl_affiliation_certificate'];
		$arl_affiliation_certificate_date = $data['arl_affiliation_certificate_date'];
		$evaluation_result_certificate = $data['evaluation_result_certificate'];
		$evaluation_result_certificate_date = $data['evaluation_result_certificate_date'];
		$arl_accident_certificate_udate = $data['arl_accident_certificate_udate'];
		$arl_affiliation_certificate_udate = $data['arl_affiliation_certificate_udate'];
		$evaluation_result_certificate_udate = $data['evaluation_result_certificate_udate'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "INSERT INTO supplier_ssts( supplier_id, operation_year, fatalities, disabling_accidents, total_incidents, disability_days, workers_number, manhours, risk_level, rating_percentage, arl_accident_certificate, arl_accident_certificate_date, arl_affiliation_certificate, arl_affiliation_certificate_date, evaluation_result_certificate, evaluation_result_certificate_date, arl_accident_certificate_udate, arl_affiliation_certificate_udate, evaluation_result_certificate_udate, created_at, updated_at) VALUES ( '$supplier_id', '$operation_year', '$fatalities', '$disabling_accidents', '$total_incidents', '$disability_days', '$workers_number', '$manhours', '$risk_level', '$rating_percentage', '$arl_accident_certificate', '$arl_accident_certificate_date', '$arl_affiliation_certificate', '$arl_affiliation_certificate_date', '$evaluation_result_certificate', '$evaluation_result_certificate_date', '$arl_accident_certificate_udate', '$arl_affiliation_certificate_udate', '$evaluation_result_certificate_udate', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliersst  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$supplier_id = $data['supplier_id'];
		$operation_year = $data['operation_year'];
		$fatalities = $data['fatalities'];
		$disabling_accidents = $data['disabling_accidents'];
		$total_incidents = $data['total_incidents'];
		$disability_days = $data['disability_days'];
		$workers_number = $data['workers_number'];
		$manhours = $data['manhours'];
		$risk_level = $data['risk_level'];
		$rating_percentage = $data['rating_percentage'];
		$arl_accident_certificate = $data['arl_accident_certificate'];
		$arl_accident_certificate_date = $data['arl_accident_certificate_date'];
		$arl_affiliation_certificate = $data['arl_affiliation_certificate'];
		$arl_affiliation_certificate_date = $data['arl_affiliation_certificate_date'];
		$evaluation_result_certificate = $data['evaluation_result_certificate'];
		$evaluation_result_certificate_date = $data['evaluation_result_certificate_date'];
		$arl_accident_certificate_udate = $data['arl_accident_certificate_udate'];
		$arl_affiliation_certificate_udate = $data['arl_affiliation_certificate_udate'];
		$evaluation_result_certificate_udate = $data['evaluation_result_certificate_udate'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE supplier_ssts SET  supplier_id = '$supplier_id', operation_year = '$operation_year', fatalities = '$fatalities', disabling_accidents = '$disabling_accidents', total_incidents = '$total_incidents', disability_days = '$disability_days', workers_number = '$workers_number', manhours = '$manhours', risk_level = '$risk_level', rating_percentage = '$rating_percentage', arl_accident_certificate = '$arl_accident_certificate', arl_accident_certificate_date = '$arl_accident_certificate_date', arl_affiliation_certificate = '$arl_affiliation_certificate', arl_affiliation_certificate_date = '$arl_affiliation_certificate_date', evaluation_result_certificate = '$evaluation_result_certificate', evaluation_result_certificate_date = '$evaluation_result_certificate_date', arl_accident_certificate_udate = '$arl_accident_certificate_udate', arl_affiliation_certificate_udate = '$arl_affiliation_certificate_udate', evaluation_result_certificate_udate = '$evaluation_result_certificate_udate', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}