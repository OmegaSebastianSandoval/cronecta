<?php 
/**
* clase que genera la clase dependiente  de suppliersegments en la base de datos
*/
class Administracion_Model_DbTable_Dependindustrysegments extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'industry_segments';

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
	    $select = ' SELECT suppliers.id FROM (suppliers LEFT JOIN supplier_segments ON supplier_segments.supplier_id = suppliers.id) LEFT JOIN industry_segments ON industry_segments.id = supplier_segments.segment_id ' . $filter . ' ' . $orders;
	    $res = $this->_conn->query($select)->fetchAsObject();
	    return $res;
	  }



}