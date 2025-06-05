<?php
/**
* Controlador de Clients que permite la  creacion, edicion  y eliminacion de los clientes del Sistema
*/
class Page_clientsController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos clientes
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
	protected $_csrf_section = "page_clients";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador clients .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Clients();
		$this->namefilter = "parametersfilterclients";
		$this->route = "/page/clients";
		$this->namepages ="pages_clients";
		$this->namepageactual ="page_actual_clients";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  clientes con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de clientes";
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
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  cliente  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_clients_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar cliente";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear cliente";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear cliente";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un cliente  y redirecciona al listado de clientes.
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
			$data['log_tipo'] = 'CREAR CLIENTE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un cliente  y redirecciona al listado de clientes.
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
			$data['log_tipo'] = 'EDITAR CLIENTE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un cliente  y redirecciona al listado de clientes.
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
					$data['log_tipo'] = 'BORRAR CLIENTE';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Clients.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['documentType'] = $this->_getSanitizedParam("documentType");
		$data['nit'] = $this->_getSanitizedParam("nit");
		$data['name'] = $this->_getSanitizedParam("name");
		$data['lastname'] = $this->_getSanitizedParam("lastname");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['email_verified_at'] = $this->_getSanitizedParam("email_verified_at");
		$data['bussinesEmail'] = $this->_getSanitizedParam("bussinesEmail");
		$data['phone'] = $this->_getSanitizedParam("phone");
		$data['whatsapp'] = $this->_getSanitizedParam("whatsapp");
		$data['phoneCode'] = $this->_getSanitizedParam("phoneCode");
		$data['company'] = $this->_getSanitizedParam("company");
		$data['position'] = $this->_getSanitizedParam("position");
		$data['area'] = $this->_getSanitizedParam("area");
		$data['country'] = $this->_getSanitizedParam("country");
		$data['city'] = $this->_getSanitizedParam("city");
		$data['password'] = $this->_getSanitizedParam("password");
		$data['created_at'] = $this->_getSanitizedParam("created_at");
		$data['updated_at'] = $this->_getSanitizedParam("updated_at");
		$data['rut'] = $this->_getSanitizedParam("rut");
		$data['commerce'] = $this->_getSanitizedParam("commerce");
		if($this->_getSanitizedParam("industry_id") == '' ) {
			$data['industry_id'] = '0';
		} else {
			$data['industry_id'] = $this->_getSanitizedParam("industry_id");
		}
		$data['state'] = $this->_getSanitizedParam("state");
		$data['company_nit'] = $this->_getSanitizedParam("company_nit");
		$data['nit_type'] = $this->_getSanitizedParam("nit_type");
		$data['company_country'] = $this->_getSanitizedParam("company_country");
		$data['company_state'] = $this->_getSanitizedParam("company_state");
		$data['company_city'] = $this->_getSanitizedParam("company_city");
		return $data;
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
            if ($filters->documentType != '') {
                $filtros = $filtros." AND documentType LIKE '%".$filters->documentType."%'";
            }
            if ($filters->nit != '') {
                $filtros = $filtros." AND nit LIKE '%".$filters->nit."%'";
            }
            if ($filters->name != '') {
                $filtros = $filtros." AND name LIKE '%".$filters->name."%'";
            }
            if ($filters->lastname != '') {
                $filtros = $filtros." AND lastname LIKE '%".$filters->lastname."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->email_verified_at != '') {
                $filtros = $filtros." AND email_verified_at LIKE '%".$filters->email_verified_at."%'";
            }
            if ($filters->bussinesEmail != '') {
                $filtros = $filtros." AND bussinesEmail LIKE '%".$filters->bussinesEmail."%'";
            }
            if ($filters->phone != '') {
                $filtros = $filtros." AND phone LIKE '%".$filters->phone."%'";
            }
            if ($filters->whatsapp != '') {
                $filtros = $filtros." AND whatsapp LIKE '%".$filters->whatsapp."%'";
            }
            if ($filters->phoneCode != '') {
                $filtros = $filtros." AND phoneCode LIKE '%".$filters->phoneCode."%'";
            }
            if ($filters->company != '') {
                $filtros = $filtros." AND company LIKE '%".$filters->company."%'";
            }
            if ($filters->position != '') {
                $filtros = $filtros." AND position LIKE '%".$filters->position."%'";
            }
            if ($filters->area != '') {
                $filtros = $filtros." AND area LIKE '%".$filters->area."%'";
            }
            if ($filters->country != '') {
                $filtros = $filtros." AND country LIKE '%".$filters->country."%'";
            }
            if ($filters->city != '') {
                $filtros = $filtros." AND city LIKE '%".$filters->city."%'";
            }
            if ($filters->password != '') {
                $filtros = $filtros." AND password LIKE '%".$filters->password."%'";
            }
            if ($filters->created_at != '') {
                $filtros = $filtros." AND created_at LIKE '%".$filters->created_at."%'";
            }
            if ($filters->updated_at != '') {
                $filtros = $filtros." AND updated_at LIKE '%".$filters->updated_at."%'";
            }
            if ($filters->rut != '') {
                $filtros = $filtros." AND rut LIKE '%".$filters->rut."%'";
            }
            if ($filters->commerce != '') {
                $filtros = $filtros." AND commerce LIKE '%".$filters->commerce."%'";
            }
            if ($filters->industry_id != '') {
                $filtros = $filtros." AND industry_id LIKE '%".$filters->industry_id."%'";
            }
            if ($filters->state != '') {
                $filtros = $filtros." AND state LIKE '%".$filters->state."%'";
            }
            if ($filters->company_nit != '') {
                $filtros = $filtros." AND company_nit LIKE '%".$filters->company_nit."%'";
            }
            if ($filters->nit_type != '') {
                $filtros = $filtros." AND nit_type LIKE '%".$filters->nit_type."%'";
            }
            if ($filters->company_country != '') {
                $filtros = $filtros." AND company_country LIKE '%".$filters->company_country."%'";
            }
            if ($filters->company_state != '') {
                $filtros = $filtros." AND company_state LIKE '%".$filters->company_state."%'";
            }
            if ($filters->company_city != '') {
                $filtros = $filtros." AND company_city LIKE '%".$filters->company_city."%'";
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
					$parramsfilter['documentType'] =  $this->_getSanitizedParam("documentType");
					$parramsfilter['nit'] =  $this->_getSanitizedParam("nit");
					$parramsfilter['name'] =  $this->_getSanitizedParam("name");
					$parramsfilter['lastname'] =  $this->_getSanitizedParam("lastname");
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['email_verified_at'] =  $this->_getSanitizedParam("email_verified_at");
					$parramsfilter['bussinesEmail'] =  $this->_getSanitizedParam("bussinesEmail");
					$parramsfilter['phone'] =  $this->_getSanitizedParam("phone");
					$parramsfilter['whatsapp'] =  $this->_getSanitizedParam("whatsapp");
					$parramsfilter['phoneCode'] =  $this->_getSanitizedParam("phoneCode");
					$parramsfilter['company'] =  $this->_getSanitizedParam("company");
					$parramsfilter['position'] =  $this->_getSanitizedParam("position");
					$parramsfilter['area'] =  $this->_getSanitizedParam("area");
					$parramsfilter['country'] =  $this->_getSanitizedParam("country");
					$parramsfilter['city'] =  $this->_getSanitizedParam("city");
					$parramsfilter['password'] =  $this->_getSanitizedParam("password");
					$parramsfilter['created_at'] =  $this->_getSanitizedParam("created_at");
					$parramsfilter['updated_at'] =  $this->_getSanitizedParam("updated_at");
					$parramsfilter['rut'] =  $this->_getSanitizedParam("rut");
					$parramsfilter['commerce'] =  $this->_getSanitizedParam("commerce");
					$parramsfilter['industry_id'] =  $this->_getSanitizedParam("industry_id");
					$parramsfilter['state'] =  $this->_getSanitizedParam("state");
					$parramsfilter['company_nit'] =  $this->_getSanitizedParam("company_nit");
					$parramsfilter['nit_type'] =  $this->_getSanitizedParam("nit_type");
					$parramsfilter['company_country'] =  $this->_getSanitizedParam("company_country");
					$parramsfilter['company_state'] =  $this->_getSanitizedParam("company_state");
					$parramsfilter['company_city'] =  $this->_getSanitizedParam("company_city");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}