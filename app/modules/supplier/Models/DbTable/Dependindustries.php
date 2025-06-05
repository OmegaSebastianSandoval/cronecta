<?php 
/**
* clase que genera la clase dependiente  de Registro de proveedor en la base de datos
*/
class Supplier_Model_DbTable_Dependindustries extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'industries';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';


	  public function getSuppliers($filters = '', $order = '')
	  {
	    $filter = '';
	    if ($filters != '') {
	      $filter = ' WHERE ' . $filters;
	    }
	    $orders = "";
	    if ($order != '') {
	      $orders = ' ORDER BY ' . $order;
	    }
	    $select = ' SELECT suppliers.id FROM (suppliers LEFT JOIN supplier_industries ON supplier_industries.supplier_id = suppliers.id) LEFT JOIN industries ON industries.id = supplier_industries.industry_id ' . $filter . ' ' . $orders;
	    $res = $this->_conn->query($select)->fetchAsObject();
	    return $res;
	  }


}