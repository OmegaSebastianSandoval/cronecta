<?php 
/**
* clase que genera la insercion y edicion  de suppliersbank en la base de datos
*/
class Administracion_Model_DbTable_Suppliersbank extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'supplier_banks';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un suppliersbank y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$country = $data['country'];
		$bank = $data['bank'];
		$office = $data['office'];
		$account_type = $data['account_type'];
		$account_number = $data['account_number'];
		$holder = $data['holder'];
		$account_certificate = $data['account_certificate'];
		$account_certificate_udate = $data['account_certificate_udate'];
		$swift_number = $data['swift_number'];
		$routing_number = $data['routing_number'];
		$iban = $data['iban'];
		$bic = $data['bic'];
		$intermediary_bank = $data['intermediary_bank'];
		$supplier_id = $data['supplier_id'];
		$created_at = date("Y-m-d H:i:s");
		$updated_at = date("Y-m-d H:i:s");
		$query = "INSERT INTO supplier_banks( country, bank, office, account_type, account_number, holder, account_certificate, account_certificate_udate, swift_number, routing_number, iban, bic, intermediary_bank, supplier_id, created_at, updated_at) VALUES ( '$country', '$bank', '$office', '$account_type', '$account_number', '$holder', '$account_certificate', '$account_certificate_udate', '$swift_number', '$routing_number', '$iban', '$bic', '$intermediary_bank', '$supplier_id', '$created_at', '$updated_at')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliersbank  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$country = $data['country'];
		$bank = $data['bank'];
		$office = $data['office'];
		$account_type = $data['account_type'];
		$account_number = $data['account_number'];
		$holder = $data['holder'];
		$account_certificate = $data['account_certificate'];
		$account_certificate_udate = $data['account_certificate_udate'];
		$swift_number = $data['swift_number'];
		$routing_number = $data['routing_number'];
		$iban = $data['iban'];
		$bic = $data['bic'];
		$intermediary_bank = $data['intermediary_bank'];
		$supplier_id = $data['supplier_id'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$query = "UPDATE supplier_banks SET  country = '$country', bank = '$bank', office = '$office', account_type = '$account_type', account_number = '$account_number', holder = '$holder', account_certificate = '$account_certificate', account_certificate_udate = '$account_certificate_udate', swift_number = '$swift_number', routing_number = '$routing_number', iban = '$iban', bic = '$bic', intermediary_bank = '$intermediary_bank', supplier_id = '$supplier_id', created_at = '$created_at', updated_at = '$updated_at' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}