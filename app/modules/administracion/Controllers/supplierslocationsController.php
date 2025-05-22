<?php
/**
* Controlador de Supplierslocations que permite la  creacion, edicion  y eliminacion de los supplierlocations del Sistema
*/
class Administracion_supplierslocationsController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos supplierlocations
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_supplierslocations";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador supplierslocations .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Supplierslocations();
		$this->namefilter = "parametersfiltersupplierslocations";
		$this->route = "/administracion/supplierslocations";
		$this->namepages ="pages_supplierslocations";
		$this->namepageactual ="page_actual_supplierslocations";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  supplierlocations con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de supplierlocations";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->list_country = $this->getCountry();
		$this->_view->list_state = $this->getState();
		$this->_view->list_city = $this->getCity();
		$this->_view->list_supplier_id = $this->getSupplierid();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  supplierlocations  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_supplierslocations_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_country = $this->getCountry();
		$this->_view->list_state = $this->getState();
		$this->_view->list_city = $this->getCity();
		$this->_view->list_supplier_id = $this->getSupplierid();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar supplierlocations";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear supplierlocations";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear supplierlocations";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un supplierlocations  y redirecciona al listado de supplierlocations.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SUPPLIERLOCATIONS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un supplierlocations  y redirecciona al listado de supplierlocations.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR SUPPLIERLOCATIONS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un supplierlocations  y redirecciona al listado de supplierlocations.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR SUPPLIERLOCATIONS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Supplierslocations.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['name'] = $this->_getSanitizedParam("name");
		$data['country'] = $this->_getSanitizedParam("country");
		$data['state'] = $this->_getSanitizedParam("state");
		$data['city'] = $this->_getSanitizedParam("city");
		$data['address'] = $this->_getSanitizedParam("address");
		$data['mobile_phone'] = $this->_getSanitizedParam("mobile_phone");
		$data['coverage_north'] = $this->_getSanitizedParam("coverage_north");
		$data['coverage_east'] = $this->_getSanitizedParam("coverage_east");
		$data['coverage_west'] = $this->_getSanitizedParam("coverage_west");
		$data['coverage_south'] = $this->_getSanitizedParam("coverage_south");
		$data['supplier_id'] = $this->_getSanitizedParam("supplier_id");
		$data['updated_at'] = $this->_getSanitizedParam("updated_at");
		$data['created_at'] = $this->_getSanitizedParam("created_at");
		return $data;
	}

	/**
     * Genera los valores del campo country.
     *
     * @return array cadena con los valores del campo country.
     */
	private function getCountry()
	{
		$array = array();
		$array['Data'] = 'Data';
		return $array;
	}


	/**
     * Genera los valores del campo state.
     *
     * @return array cadena con los valores del campo state.
     */
	private function getState()
	{
		$array = array();
		$array['Data'] = 'Data';
		return $array;
	}


	/**
     * Genera los valores del campo city.
     *
     * @return array cadena con los valores del campo city.
     */
	private function getCity()
	{
		$array = array();
		$array['Data'] = 'Data';
		return $array;
	}


	/**
     * Genera los valores del campo supplier_id.
     *
     * @return array cadena con los valores del campo supplier_id.
     */
	private function getSupplierid()
	{
		$modelData = new Administracion_Model_DbTable_Dependsuppliers();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->company_type;
		}
		return $array;
	}

	/**
     * Genera la consulta con los filtros de este controlador.
     *
     * @return array cadena con los filtros que se van a asignar a la base de datos
     */
    protected function getFilter()
    {
    	$filtros = " 1 = 1 ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->name != '') {
                $filtros = $filtros." AND name LIKE '%".$filters->name."%'";
            }
            if ($filters->country != '') {
                $filtros = $filtros." AND country ='".$filters->country."'";
            }
            if ($filters->state != '') {
                $filtros = $filtros." AND state ='".$filters->state."'";
            }
            if ($filters->city != '') {
                $filtros = $filtros." AND city ='".$filters->city."'";
            }
            if ($filters->supplier_id != '') {
                $filtros = $filtros." AND supplier_id LIKE '%".$filters->supplier_id."%'";
            }
		}
        return $filtros;
    }

    /**
     * Recibe y asigna los filtros de este controlador
     *
     * @return void
     */
    protected function filters()
    {
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();
					$parramsfilter['name'] =  $this->_getSanitizedParam("name");
					$parramsfilter['country'] =  $this->_getSanitizedParam("country");
					$parramsfilter['state'] =  $this->_getSanitizedParam("state");
					$parramsfilter['city'] =  $this->_getSanitizedParam("city");
					$parramsfilter['supplier_id'] =  $this->_getSanitizedParam("supplier_id");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}