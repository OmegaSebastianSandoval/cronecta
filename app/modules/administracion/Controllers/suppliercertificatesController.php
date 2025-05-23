<?php
/**
* Controlador de Suppliercertificates que permite la  creacion, edicion  y eliminacion de los suppliercertificates del Sistema
*/
class Administracion_suppliercertificatesController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos suppliercertificates
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
	protected $_csrf_section = "administracion_suppliercertificates";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador suppliercertificates .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Suppliercertificates();
		$this->namefilter = "parametersfiltersuppliercertificates";
		$this->route = "/administracion/suppliercertificates";
		$this->namepages ="pages_suppliercertificates";
		$this->namepageactual ="page_actual_suppliercertificates";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  suppliercertificates con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de suppliercertificates";
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
		$this->_view->list_supplier_id = $this->getSupplierid();
		$this->_view->list_type = $this->getType();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  suppliercertificates  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_suppliercertificates_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_supplier_id = $this->getSupplierid();
		$this->_view->list_type = $this->getType();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar suppliercertificates";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear suppliercertificates";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear suppliercertificates";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un suppliercertificates  y redirecciona al listado de suppliercertificates.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['certification_file']['name'] != ''){
				$data['certification_file'] = $uploadDocument->upload("certification_file");
			}
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SUPPLIERCERTIFICATES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un suppliercertificates  y redirecciona al listado de suppliercertificates.
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
					$uploadDocument =  new Core_Model_Upload_Document();
				if($_FILES['certification_file']['name'] != ''){
					if($content->certification_file){
						$uploadDocument->delete($content->certification_file);
					}
					$data['certification_file'] = $uploadDocument->upload("certification_file");
				} else {
					$data['certification_file'] = $content->certification_file;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR SUPPLIERCERTIFICATES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un suppliercertificates  y redirecciona al listado de suppliercertificates.
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
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->certification_file) && $content->certification_file != '') {
						$uploadDocument->delete($content->certification_file);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR SUPPLIERCERTIFICATES';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Suppliercertificates.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['supplier_id'] = $this->_getSanitizedParam("supplier_id");
		$data['type'] = $this->_getSanitizedParam("type");
		$data['start_date'] = $this->_getSanitizedParam("start_date");
		$data['end_date'] = $this->_getSanitizedParam("end_date");
		$data['certification_file'] = "";
		$data['certification_file_udate'] = $this->_getSanitizedParam("certification_file_udate");
		$data['comment'] = $this->_getSanitizedParam("comment");
		$data['created_at'] = $this->_getSanitizedParam("created_at");
		$data['updated_at'] = $this->_getSanitizedParam("updated_at");
		return $data;
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
			$array[$value->id] = $value->company_name;
		}
		return $array;
	}


	/**
     * Genera los valores del campo type.
     *
     * @return array cadena con los valores del campo type.
     */
	private function getType()
	{
		$array = array();
		$array['Data'] = 'Data';
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
            if ($filters->supplier_id != '') {
                $filtros = $filtros." AND supplier_id LIKE '%".$filters->supplier_id."%'";
            }
            if ($filters->type != '') {
                $filtros = $filtros." AND type ='".$filters->type."'";
            }
            if ($filters->start_date != '') {
                $filtros = $filtros." AND start_date LIKE '%".$filters->start_date."%'";
            }
            if ($filters->end_date != '') {
                $filtros = $filtros." AND end_date LIKE '%".$filters->end_date."%'";
            }
            if ($filters->certification_file != '') {
                $filtros = $filtros." AND certification_file LIKE '%".$filters->certification_file."%'";
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
					$parramsfilter['supplier_id'] =  $this->_getSanitizedParam("supplier_id");
					$parramsfilter['type'] =  $this->_getSanitizedParam("type");
					$parramsfilter['start_date'] =  $this->_getSanitizedParam("start_date");
					$parramsfilter['end_date'] =  $this->_getSanitizedParam("end_date");
					$parramsfilter['certification_file'] =  $this->_getSanitizedParam("certification_file");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}