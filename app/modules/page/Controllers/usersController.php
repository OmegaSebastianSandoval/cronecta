<?php
/**
* Controlador de Users que permite la  creacion, edicion  y eliminacion de los usuarios del Sistema
*/
class Page_usersController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos usuarios
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
	protected $_csrf_section = "page_users";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador users .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Users();
		$this->namefilter = "parametersfilterusers";
		$this->route = "/page/users";
		$this->namepages ="pages_users";
		$this->namepageactual ="page_actual_users";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  usuarios con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de usuarios";
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
     * Genera la Informacion necesaria para editar o crear un  usuario  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_users_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar usuario";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear usuario";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear usuario";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un usuario  y redirecciona al listado de usuarios.
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
			$data['log_tipo'] = 'CREAR USUARIO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un usuario  y redirecciona al listado de usuarios.
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
			$data['log_tipo'] = 'EDITAR USUARIO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un usuario  y redirecciona al listado de usuarios.
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
					$data['log_tipo'] = 'BORRAR USUARIO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Users.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['name'] = $this->_getSanitizedParam("name");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['email_verified_at'] = $this->_getSanitizedParam("email_verified_at");
		$data['password'] = $this->_getSanitizedParam("password");
		$data['phone'] = $this->_getSanitizedParam("phone");
		$data['document'] = $this->_getSanitizedParam("document");
		$data['level'] = $this->_getSanitizedParam("level");
		if($this->_getSanitizedParam("status") == '' ) {
			$data['status'] = '0';
		} else {
			$data['status'] = $this->_getSanitizedParam("status");
		}
		$data['remember_token'] = $this->_getSanitizedParam("remember_token");
		$data['created_at'] = $this->_getSanitizedParam("created_at");
		$data['updated_at'] = $this->_getSanitizedParam("updated_at");
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
            if ($filters->name != '') {
                $filtros = $filtros." AND name LIKE '%".$filters->name."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->email_verified_at != '') {
                $filtros = $filtros." AND email_verified_at LIKE '%".$filters->email_verified_at."%'";
            }
            if ($filters->password != '') {
                $filtros = $filtros." AND password LIKE '%".$filters->password."%'";
            }
            if ($filters->phone != '') {
                $filtros = $filtros." AND phone LIKE '%".$filters->phone."%'";
            }
            if ($filters->document != '') {
                $filtros = $filtros." AND document LIKE '%".$filters->document."%'";
            }
            if ($filters->level != '') {
                $filtros = $filtros." AND level LIKE '%".$filters->level."%'";
            }
            if ($filters->status != '') {
                $filtros = $filtros." AND status LIKE '%".$filters->status."%'";
            }
            if ($filters->remember_token != '') {
                $filtros = $filtros." AND remember_token LIKE '%".$filters->remember_token."%'";
            }
            if ($filters->created_at != '') {
                $filtros = $filtros." AND created_at LIKE '%".$filters->created_at."%'";
            }
            if ($filters->updated_at != '') {
                $filtros = $filtros." AND updated_at LIKE '%".$filters->updated_at."%'";
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
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['email_verified_at'] =  $this->_getSanitizedParam("email_verified_at");
					$parramsfilter['password'] =  $this->_getSanitizedParam("password");
					$parramsfilter['phone'] =  $this->_getSanitizedParam("phone");
					$parramsfilter['document'] =  $this->_getSanitizedParam("document");
					$parramsfilter['level'] =  $this->_getSanitizedParam("level");
					$parramsfilter['status'] =  $this->_getSanitizedParam("status");
					$parramsfilter['remember_token'] =  $this->_getSanitizedParam("remember_token");
					$parramsfilter['created_at'] =  $this->_getSanitizedParam("created_at");
					$parramsfilter['updated_at'] =  $this->_getSanitizedParam("updated_at");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}