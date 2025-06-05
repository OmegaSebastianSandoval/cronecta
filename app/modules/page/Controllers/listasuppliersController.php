<?php
/**
* Controlador de Listasuppliers que permite la  creacion, edicion  y eliminacion de los suppliers del Sistema
*/
class Page_listasuppliersController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos suppliers
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
	protected $_csrf_section = "page_listasuppliers";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador listasuppliers .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Listasuppliers();
		$this->namefilter = "parametersfilterlistasuppliers";
		$this->route = "/page/listasuppliers";
		$this->namepages ="pages_listasuppliers";
		$this->namepageactual ="page_actual_listasuppliers";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  suppliers con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de suppliers";
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
     * Genera la Informacion necesaria para editar o crear un  suppliers  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_listasuppliers_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar suppliers";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear suppliers";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear suppliers";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un suppliers  y redirecciona al listado de suppliers.
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
			$data['log_tipo'] = 'CREAR SUPPLIERS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un suppliers  y redirecciona al listado de suppliers.
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
			$data['log_tipo'] = 'EDITAR SUPPLIERS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un suppliers  y redirecciona al listado de suppliers.
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
					$data['log_tipo'] = 'BORRAR SUPPLIERS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Listasuppliers.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['brochure'] = $this->_getSanitizedParam("brochure");
		$data['certificate_issue_date'] = $this->_getSanitizedParam("certificate_issue_date");
		$data['certificate_issue_name'] = $this->_getSanitizedParam("certificate_issue_name");
		$data['company_size'] = $this->_getSanitizedParam("company_size");
		$data['company_size_certificate'] = $this->_getSanitizedParam("company_size_certificate");
		$data['company_size_certificate_udate'] = $this->_getSanitizedParam("company_size_certificate_udate");
		$data['company_validity'] = $this->_getSanitizedParam("company_validity");
		$data['company_validity2'] = $this->_getSanitizedParam("company_validity2");
		$data['document_issue_date2'] = $this->_getSanitizedParam("document_issue_date2");
		$data['document_issue_place2'] = $this->_getSanitizedParam("document_issue_place2");
		$data['document_number2'] = $this->_getSanitizedParam("document_number2");
		$data['document_type2'] = $this->_getSanitizedParam("document_type2");
		$data['facebook'] = $this->_getSanitizedParam("facebook");
		$data['foreign_currency'] = $this->_getSanitizedParam("foreign_currency");
		$data['foreign_products'] = $this->_getSanitizedParam("foreign_products");
		$data['incorporation_certificate'] = $this->_getSanitizedParam("incorporation_certificate");
		$data['incorporation_certificate_udate'] = $this->_getSanitizedParam("incorporation_certificate_udate");
		$data['instagram'] = $this->_getSanitizedParam("instagram");
		$data['ip'] = $this->_getSanitizedParam("ip");
		$data['legal_representative_id2'] = $this->_getSanitizedParam("legal_representative_id2");
		$data['linkedin'] = $this->_getSanitizedParam("linkedin");
		$data['nontaxable_agent'] = $this->_getSanitizedParam("nontaxable_agent");
		if($this->_getSanitizedParam("policy") == '' ) {
			$data['policy'] = '0';
		} else {
			$data['policy'] = $this->_getSanitizedParam("policy");
		}
		$data['position'] = $this->_getSanitizedParam("position");
		$data['registry_city'] = $this->_getSanitizedParam("registry_city");
		$data['registry_country'] = $this->_getSanitizedParam("registry_country");
		$data['registry_state'] = $this->_getSanitizedParam("registry_state");
		$data['representative_birth_country'] = $this->_getSanitizedParam("representative_birth_country");
		$data['representative_birth_country2'] = $this->_getSanitizedParam("representative_birth_country2");
		$data['representative_name2'] = $this->_getSanitizedParam("representative_name2");
		$data['rut_certificate_udate'] = $this->_getSanitizedParam("rut_certificate_udate");
		$data['slug'] = $this->_getSanitizedParam("slug");
		$data['supplier_soc_type'] = $this->_getSanitizedParam("supplier_soc_type");
		$data['tax_liabilities'] = $this->_getSanitizedParam("tax_liabilities");
		$data['tax_regime'] = $this->_getSanitizedParam("tax_regime");
		$data['trade_registry_udate'] = $this->_getSanitizedParam("trade_registry_udate");
		$data['twitter'] = $this->_getSanitizedParam("twitter");
		if($this->_getSanitizedParam("visibility_status") == '' ) {
			$data['visibility_status'] = '0';
		} else {
			$data['visibility_status'] = $this->_getSanitizedParam("visibility_status");
		}
		$data['which_foreign_currency'] = $this->_getSanitizedParam("which_foreign_currency");
		$data['which_foreign_products'] = $this->_getSanitizedParam("which_foreign_products");
		$data['worldwide'] = $this->_getSanitizedParam("worldwide");
		$data['is_legal_entity'] = $this->_getSanitizedParam("is_legal_entity");
		$data['filling_date'] = $this->_getSanitizedParam("filling_date");
		$data['counterparty_type'] = $this->_getSanitizedParam("counterparty_type");
		$data['supplier_type'] = $this->_getSanitizedParam("supplier_type");
		$data['company_name'] = $this->_getSanitizedParam("company_name");
		$data['primary_email'] = $this->_getSanitizedParam("primary_email");
		$data['economic_activity'] = $this->_getSanitizedParam("economic_activity");
		$data['ciiu_code'] = $this->_getSanitizedParam("ciiu_code");
		$data['commercial_activity'] = $this->_getSanitizedParam("commercial_activity");
		$data['website'] = $this->_getSanitizedParam("website");
		$data['main_address'] = $this->_getSanitizedParam("main_address");
		$data['company_type'] = $this->_getSanitizedParam("company_type");
		$data['identification_nit'] = $this->_getSanitizedParam("identification_nit");
		$data['city'] = $this->_getSanitizedParam("city");
		$data['state'] = $this->_getSanitizedParam("state");
		$data['country'] = $this->_getSanitizedParam("country");
		$data['landline'] = $this->_getSanitizedParam("landline");
		$data['mobile_phone'] = $this->_getSanitizedParam("mobile_phone");
		$data['trade_registry'] = $this->_getSanitizedParam("trade_registry");
		$data['legal_representative_id'] = $this->_getSanitizedParam("legal_representative_id");
		$data['rut_certificate_name'] = $this->_getSanitizedParam("rut_certificate_name");
		$data['rut_certificate'] = $this->_getSanitizedParam("rut_certificate");
		$data['rut_certificate_date_expedition'] = $this->_getSanitizedParam("rut_certificate_date_expedition");
		$data['rut_certificate_country'] = $this->_getSanitizedParam("rut_certificate_country");
		$data['rut_certificate_state'] = $this->_getSanitizedParam("rut_certificate_state");
		$data['rut_certificate_city'] = $this->_getSanitizedParam("rut_certificate_city");
		$data['financial_statements'] = $this->_getSanitizedParam("financial_statements");
		$data['tax_declaration'] = $this->_getSanitizedParam("tax_declaration");
		$data['tax_declaration_year'] = $this->_getSanitizedParam("tax_declaration_year");
		$data['tax_declaration_udate'] = $this->_getSanitizedParam("tax_declaration_udate");
		if($this->_getSanitizedParam("number_of_employees") == '' ) {
			$data['number_of_employees'] = '0';
		} else {
			$data['number_of_employees'] = $this->_getSanitizedParam("number_of_employees");
		}
		$data['company_date'] = $this->_getSanitizedParam("company_date");
		$data['representative_name'] = $this->_getSanitizedParam("representative_name");
		$data['document_type'] = $this->_getSanitizedParam("document_type");
		$data['document_number'] = $this->_getSanitizedParam("document_number");
		$data['document_issue_place'] = $this->_getSanitizedParam("document_issue_place");
		$data['nationality'] = $this->_getSanitizedParam("nationality");
		$data['document_issue_date'] = $this->_getSanitizedParam("document_issue_date");
		$data['birthdate'] = $this->_getSanitizedParam("birthdate");
		$data['birth_country'] = $this->_getSanitizedParam("birth_country");
		$data['birth_city'] = $this->_getSanitizedParam("birth_city");
		$data['birth_state'] = $this->_getSanitizedParam("birth_state");
		$data['manages_public_funds'] = $this->_getSanitizedParam("manages_public_funds");
		$data['public_recognition'] = $this->_getSanitizedParam("public_recognition");
		$data['relationship_with_publicly_exposed_person'] = $this->_getSanitizedParam("relationship_with_publicly_exposed_person");
		$data['resource_origin'] = $this->_getSanitizedParam("resource_origin");
		$data['currency_type'] = $this->_getSanitizedParam("currency_type");
		$data['liabilities'] = $this->_getSanitizedParam("liabilities");
		$data['income'] = $this->_getSanitizedParam("income");
		$data['other_income'] = $this->_getSanitizedParam("other_income");
		$data['other_income_concept'] = $this->_getSanitizedParam("other_income_concept");
		if($this->_getSanitizedParam("foreign_transactions") == '' ) {
			$data['foreign_transactions'] = '0';
		} else {
			$data['foreign_transactions'] = $this->_getSanitizedParam("foreign_transactions");
		}
		$data['foreign_transactions_details'] = $this->_getSanitizedParam("foreign_transactions_details");
		if($this->_getSanitizedParam("foreign_financial_products") == '' ) {
			$data['foreign_financial_products'] = '0';
		} else {
			$data['foreign_financial_products'] = $this->_getSanitizedParam("foreign_financial_products");
		}
		$data['foreign_financial_products_details'] = $this->_getSanitizedParam("foreign_financial_products_details");
		$data['declarations'] = $this->_getSanitizedParam("declarations");
		if($this->_getSanitizedParam("is_active") == '' ) {
			$data['is_active'] = '0';
		} else {
			$data['is_active'] = $this->_getSanitizedParam("is_active");
		}
		$data['subscription_expiry_date'] = $this->_getSanitizedParam("subscription_expiry_date");
		$data['created_at'] = $this->_getSanitizedParam("created_at");
		$data['updated_at'] = $this->_getSanitizedParam("updated_at");
		$data['activity_type'] = $this->_getSanitizedParam("activity_type");
		$data['keywords'] = $this->_getSanitizedParam("keywords");
		$data['info_state'] = $this->_getSanitizedParam("info_state");
		$data['assets'] = $this->_getSanitizedParam("assets");
		$data['expenses'] = $this->_getSanitizedParam("expenses");
		$data['equity'] = $this->_getSanitizedParam("equity");
		$data['other_expenses'] = $this->_getSanitizedParam("other_expenses");
		$data['income_origin'] = $this->_getSanitizedParam("income_origin");
		$data['assets_total'] = $this->_getSanitizedParam("assets_total");
		$data['liabilities_total'] = $this->_getSanitizedParam("liabilities_total");
		$data['income_other'] = $this->_getSanitizedParam("income_other");
		$data['eeff'] = $this->_getSanitizedParam("eeff");
		$data['eeff_year'] = $this->_getSanitizedParam("eeff_year");
		$data['eeff_udate'] = $this->_getSanitizedParam("eeff_udate");
		$data['expenses_other'] = $this->_getSanitizedParam("expenses_other");
		$data['income_total'] = $this->_getSanitizedParam("income_total");
		$data['expenses_total'] = $this->_getSanitizedParam("expenses_total");
		$data['utility'] = $this->_getSanitizedParam("utility");
		$data['utility_total'] = $this->_getSanitizedParam("utility_total");
		$data['financial_expenses'] = $this->_getSanitizedParam("financial_expenses");
		$data['income_other_concept'] = $this->_getSanitizedParam("income_other_concept");
		$data['industry'] = $this->_getSanitizedParam("industry");
		$data['image'] = $this->_getSanitizedParam("image");
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
            if ($filters->is_legal_entity != '') {
                $filtros = $filtros." AND is_legal_entity LIKE '%".$filters->is_legal_entity."%'";
            }
            if ($filters->filling_date != '') {
                $filtros = $filtros." AND filling_date LIKE '%".$filters->filling_date."%'";
            }
            if ($filters->counterparty_type != '') {
                $filtros = $filtros." AND counterparty_type LIKE '%".$filters->counterparty_type."%'";
            }
            if ($filters->supplier_type != '') {
                $filtros = $filtros." AND supplier_type LIKE '%".$filters->supplier_type."%'";
            }
            if ($filters->company_name != '') {
                $filtros = $filtros." AND company_name LIKE '%".$filters->company_name."%'";
            }
            if ($filters->primary_email != '') {
                $filtros = $filtros." AND primary_email LIKE '%".$filters->primary_email."%'";
            }
            if ($filters->economic_activity != '') {
                $filtros = $filtros." AND economic_activity LIKE '%".$filters->economic_activity."%'";
            }
            if ($filters->ciiu_code != '') {
                $filtros = $filtros." AND ciiu_code LIKE '%".$filters->ciiu_code."%'";
            }
            if ($filters->commercial_activity != '') {
                $filtros = $filtros." AND commercial_activity LIKE '%".$filters->commercial_activity."%'";
            }
            if ($filters->website != '') {
                $filtros = $filtros." AND website LIKE '%".$filters->website."%'";
            }
            if ($filters->main_address != '') {
                $filtros = $filtros." AND main_address LIKE '%".$filters->main_address."%'";
            }
            if ($filters->company_type != '') {
                $filtros = $filtros." AND company_type LIKE '%".$filters->company_type."%'";
            }
            if ($filters->identification_nit != '') {
                $filtros = $filtros." AND identification_nit LIKE '%".$filters->identification_nit."%'";
            }
            if ($filters->city != '') {
                $filtros = $filtros." AND city LIKE '%".$filters->city."%'";
            }
            if ($filters->state != '') {
                $filtros = $filtros." AND state LIKE '%".$filters->state."%'";
            }
            if ($filters->country != '') {
                $filtros = $filtros." AND country LIKE '%".$filters->country."%'";
            }
            if ($filters->landline != '') {
                $filtros = $filtros." AND landline LIKE '%".$filters->landline."%'";
            }
            if ($filters->mobile_phone != '') {
                $filtros = $filtros." AND mobile_phone LIKE '%".$filters->mobile_phone."%'";
            }
            if ($filters->trade_registry != '') {
                $filtros = $filtros." AND trade_registry LIKE '%".$filters->trade_registry."%'";
            }
            if ($filters->legal_representative_id != '') {
                $filtros = $filtros." AND legal_representative_id LIKE '%".$filters->legal_representative_id."%'";
            }
            if ($filters->rut_certificate_name != '') {
                $filtros = $filtros." AND rut_certificate_name LIKE '%".$filters->rut_certificate_name."%'";
            }
            if ($filters->rut_certificate != '') {
                $filtros = $filtros." AND rut_certificate LIKE '%".$filters->rut_certificate."%'";
            }
            if ($filters->rut_certificate_date_expedition != '') {
                $filtros = $filtros." AND rut_certificate_date_expedition LIKE '%".$filters->rut_certificate_date_expedition."%'";
            }
            if ($filters->rut_certificate_country != '') {
                $filtros = $filtros." AND rut_certificate_country LIKE '%".$filters->rut_certificate_country."%'";
            }
            if ($filters->rut_certificate_state != '') {
                $filtros = $filtros." AND rut_certificate_state LIKE '%".$filters->rut_certificate_state."%'";
            }
            if ($filters->rut_certificate_city != '') {
                $filtros = $filtros." AND rut_certificate_city LIKE '%".$filters->rut_certificate_city."%'";
            }
            if ($filters->financial_statements != '') {
                $filtros = $filtros." AND financial_statements LIKE '%".$filters->financial_statements."%'";
            }
            if ($filters->tax_declaration != '') {
                $filtros = $filtros." AND tax_declaration LIKE '%".$filters->tax_declaration."%'";
            }
            if ($filters->tax_declaration_year != '') {
                $filtros = $filtros." AND tax_declaration_year LIKE '%".$filters->tax_declaration_year."%'";
            }
            if ($filters->tax_declaration_udate != '') {
                $filtros = $filtros." AND tax_declaration_udate LIKE '%".$filters->tax_declaration_udate."%'";
            }
            if ($filters->number_of_employees != '') {
                $filtros = $filtros." AND number_of_employees LIKE '%".$filters->number_of_employees."%'";
            }
            if ($filters->company_date != '') {
                $filtros = $filtros." AND company_date LIKE '%".$filters->company_date."%'";
            }
            if ($filters->representative_name != '') {
                $filtros = $filtros." AND representative_name LIKE '%".$filters->representative_name."%'";
            }
            if ($filters->document_type != '') {
                $filtros = $filtros." AND document_type LIKE '%".$filters->document_type."%'";
            }
            if ($filters->document_number != '') {
                $filtros = $filtros." AND document_number LIKE '%".$filters->document_number."%'";
            }
            if ($filters->document_issue_place != '') {
                $filtros = $filtros." AND document_issue_place LIKE '%".$filters->document_issue_place."%'";
            }
            if ($filters->nationality != '') {
                $filtros = $filtros." AND nationality LIKE '%".$filters->nationality."%'";
            }
            if ($filters->document_issue_date != '') {
                $filtros = $filtros." AND document_issue_date LIKE '%".$filters->document_issue_date."%'";
            }
            if ($filters->birthdate != '') {
                $filtros = $filtros." AND birthdate LIKE '%".$filters->birthdate."%'";
            }
            if ($filters->birth_country != '') {
                $filtros = $filtros." AND birth_country LIKE '%".$filters->birth_country."%'";
            }
            if ($filters->birth_city != '') {
                $filtros = $filtros." AND birth_city LIKE '%".$filters->birth_city."%'";
            }
            if ($filters->birth_state != '') {
                $filtros = $filtros." AND birth_state LIKE '%".$filters->birth_state."%'";
            }
            if ($filters->manages_public_funds != '') {
                $filtros = $filtros." AND manages_public_funds LIKE '%".$filters->manages_public_funds."%'";
            }
            if ($filters->public_recognition != '') {
                $filtros = $filtros." AND public_recognition LIKE '%".$filters->public_recognition."%'";
            }
            if ($filters->relationship_with_publicly_exposed_person != '') {
                $filtros = $filtros." AND relationship_with_publicly_exposed_person LIKE '%".$filters->relationship_with_publicly_exposed_person."%'";
            }
            if ($filters->resource_origin != '') {
                $filtros = $filtros." AND resource_origin LIKE '%".$filters->resource_origin."%'";
            }
            if ($filters->currency_type != '') {
                $filtros = $filtros." AND currency_type LIKE '%".$filters->currency_type."%'";
            }
            if ($filters->liabilities != '') {
                $filtros = $filtros." AND liabilities LIKE '%".$filters->liabilities."%'";
            }
            if ($filters->income != '') {
                $filtros = $filtros." AND income LIKE '%".$filters->income."%'";
            }
            if ($filters->other_income != '') {
                $filtros = $filtros." AND other_income LIKE '%".$filters->other_income."%'";
            }
            if ($filters->other_income_concept != '') {
                $filtros = $filtros." AND other_income_concept LIKE '%".$filters->other_income_concept."%'";
            }
            if ($filters->foreign_transactions != '') {
                $filtros = $filtros." AND foreign_transactions LIKE '%".$filters->foreign_transactions."%'";
            }
            if ($filters->foreign_transactions_details != '') {
                $filtros = $filtros." AND foreign_transactions_details LIKE '%".$filters->foreign_transactions_details."%'";
            }
            if ($filters->foreign_financial_products != '') {
                $filtros = $filtros." AND foreign_financial_products LIKE '%".$filters->foreign_financial_products."%'";
            }
            if ($filters->foreign_financial_products_details != '') {
                $filtros = $filtros." AND foreign_financial_products_details LIKE '%".$filters->foreign_financial_products_details."%'";
            }
            if ($filters->declarations != '') {
                $filtros = $filtros." AND declarations LIKE '%".$filters->declarations."%'";
            }
            if ($filters->is_active != '') {
                $filtros = $filtros." AND is_active LIKE '%".$filters->is_active."%'";
            }
            if ($filters->subscription_expiry_date != '') {
                $filtros = $filtros." AND subscription_expiry_date LIKE '%".$filters->subscription_expiry_date."%'";
            }
            if ($filters->created_at != '') {
                $filtros = $filtros." AND created_at LIKE '%".$filters->created_at."%'";
            }
            if ($filters->updated_at != '') {
                $filtros = $filtros." AND updated_at LIKE '%".$filters->updated_at."%'";
            }
            if ($filters->activity_type != '') {
                $filtros = $filtros." AND activity_type LIKE '%".$filters->activity_type."%'";
            }
            if ($filters->keywords != '') {
                $filtros = $filtros." AND keywords LIKE '%".$filters->keywords."%'";
            }
            if ($filters->info_state != '') {
                $filtros = $filtros." AND info_state LIKE '%".$filters->info_state."%'";
            }
            if ($filters->assets != '') {
                $filtros = $filtros." AND assets LIKE '%".$filters->assets."%'";
            }
            if ($filters->expenses != '') {
                $filtros = $filtros." AND expenses LIKE '%".$filters->expenses."%'";
            }
            if ($filters->equity != '') {
                $filtros = $filtros." AND equity LIKE '%".$filters->equity."%'";
            }
            if ($filters->other_expenses != '') {
                $filtros = $filtros." AND other_expenses LIKE '%".$filters->other_expenses."%'";
            }
            if ($filters->income_origin != '') {
                $filtros = $filtros." AND income_origin LIKE '%".$filters->income_origin."%'";
            }
            if ($filters->assets_total != '') {
                $filtros = $filtros." AND assets_total LIKE '%".$filters->assets_total."%'";
            }
            if ($filters->liabilities_total != '') {
                $filtros = $filtros." AND liabilities_total LIKE '%".$filters->liabilities_total."%'";
            }
            if ($filters->income_other != '') {
                $filtros = $filtros." AND income_other LIKE '%".$filters->income_other."%'";
            }
            if ($filters->eeff != '') {
                $filtros = $filtros." AND eeff LIKE '%".$filters->eeff."%'";
            }
            if ($filters->eeff_year != '') {
                $filtros = $filtros." AND eeff_year LIKE '%".$filters->eeff_year."%'";
            }
            if ($filters->eeff_udate != '') {
                $filtros = $filtros." AND eeff_udate LIKE '%".$filters->eeff_udate."%'";
            }
            if ($filters->expenses_other != '') {
                $filtros = $filtros." AND expenses_other LIKE '%".$filters->expenses_other."%'";
            }
            if ($filters->income_total != '') {
                $filtros = $filtros." AND income_total LIKE '%".$filters->income_total."%'";
            }
            if ($filters->expenses_total != '') {
                $filtros = $filtros." AND expenses_total LIKE '%".$filters->expenses_total."%'";
            }
            if ($filters->utility != '') {
                $filtros = $filtros." AND utility LIKE '%".$filters->utility."%'";
            }
            if ($filters->utility_total != '') {
                $filtros = $filtros." AND utility_total LIKE '%".$filters->utility_total."%'";
            }
            if ($filters->financial_expenses != '') {
                $filtros = $filtros." AND financial_expenses LIKE '%".$filters->financial_expenses."%'";
            }
            if ($filters->income_other_concept != '') {
                $filtros = $filtros." AND income_other_concept LIKE '%".$filters->income_other_concept."%'";
            }
            if ($filters->industry != '') {
                $filtros = $filtros." AND industry LIKE '%".$filters->industry."%'";
            }
            if ($filters->image != '') {
                $filtros = $filtros." AND image LIKE '%".$filters->image."%'";
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
					$parramsfilter['is_legal_entity'] =  $this->_getSanitizedParam("is_legal_entity");
					$parramsfilter['filling_date'] =  $this->_getSanitizedParam("filling_date");
					$parramsfilter['counterparty_type'] =  $this->_getSanitizedParam("counterparty_type");
					$parramsfilter['supplier_type'] =  $this->_getSanitizedParam("supplier_type");
					$parramsfilter['company_name'] =  $this->_getSanitizedParam("company_name");
					$parramsfilter['primary_email'] =  $this->_getSanitizedParam("primary_email");
					$parramsfilter['economic_activity'] =  $this->_getSanitizedParam("economic_activity");
					$parramsfilter['ciiu_code'] =  $this->_getSanitizedParam("ciiu_code");
					$parramsfilter['commercial_activity'] =  $this->_getSanitizedParam("commercial_activity");
					$parramsfilter['website'] =  $this->_getSanitizedParam("website");
					$parramsfilter['main_address'] =  $this->_getSanitizedParam("main_address");
					$parramsfilter['company_type'] =  $this->_getSanitizedParam("company_type");
					$parramsfilter['identification_nit'] =  $this->_getSanitizedParam("identification_nit");
					$parramsfilter['city'] =  $this->_getSanitizedParam("city");
					$parramsfilter['state'] =  $this->_getSanitizedParam("state");
					$parramsfilter['country'] =  $this->_getSanitizedParam("country");
					$parramsfilter['landline'] =  $this->_getSanitizedParam("landline");
					$parramsfilter['mobile_phone'] =  $this->_getSanitizedParam("mobile_phone");
					$parramsfilter['trade_registry'] =  $this->_getSanitizedParam("trade_registry");
					$parramsfilter['legal_representative_id'] =  $this->_getSanitizedParam("legal_representative_id");
					$parramsfilter['rut_certificate_name'] =  $this->_getSanitizedParam("rut_certificate_name");
					$parramsfilter['rut_certificate'] =  $this->_getSanitizedParam("rut_certificate");
					$parramsfilter['rut_certificate_date_expedition'] =  $this->_getSanitizedParam("rut_certificate_date_expedition");
					$parramsfilter['rut_certificate_country'] =  $this->_getSanitizedParam("rut_certificate_country");
					$parramsfilter['rut_certificate_state'] =  $this->_getSanitizedParam("rut_certificate_state");
					$parramsfilter['rut_certificate_city'] =  $this->_getSanitizedParam("rut_certificate_city");
					$parramsfilter['financial_statements'] =  $this->_getSanitizedParam("financial_statements");
					$parramsfilter['tax_declaration'] =  $this->_getSanitizedParam("tax_declaration");
					$parramsfilter['tax_declaration_year'] =  $this->_getSanitizedParam("tax_declaration_year");
					$parramsfilter['tax_declaration_udate'] =  $this->_getSanitizedParam("tax_declaration_udate");
					$parramsfilter['number_of_employees'] =  $this->_getSanitizedParam("number_of_employees");
					$parramsfilter['company_date'] =  $this->_getSanitizedParam("company_date");
					$parramsfilter['representative_name'] =  $this->_getSanitizedParam("representative_name");
					$parramsfilter['document_type'] =  $this->_getSanitizedParam("document_type");
					$parramsfilter['document_number'] =  $this->_getSanitizedParam("document_number");
					$parramsfilter['document_issue_place'] =  $this->_getSanitizedParam("document_issue_place");
					$parramsfilter['nationality'] =  $this->_getSanitizedParam("nationality");
					$parramsfilter['document_issue_date'] =  $this->_getSanitizedParam("document_issue_date");
					$parramsfilter['birthdate'] =  $this->_getSanitizedParam("birthdate");
					$parramsfilter['birth_country'] =  $this->_getSanitizedParam("birth_country");
					$parramsfilter['birth_city'] =  $this->_getSanitizedParam("birth_city");
					$parramsfilter['birth_state'] =  $this->_getSanitizedParam("birth_state");
					$parramsfilter['manages_public_funds'] =  $this->_getSanitizedParam("manages_public_funds");
					$parramsfilter['public_recognition'] =  $this->_getSanitizedParam("public_recognition");
					$parramsfilter['relationship_with_publicly_exposed_person'] =  $this->_getSanitizedParam("relationship_with_publicly_exposed_person");
					$parramsfilter['resource_origin'] =  $this->_getSanitizedParam("resource_origin");
					$parramsfilter['currency_type'] =  $this->_getSanitizedParam("currency_type");
					$parramsfilter['liabilities'] =  $this->_getSanitizedParam("liabilities");
					$parramsfilter['income'] =  $this->_getSanitizedParam("income");
					$parramsfilter['other_income'] =  $this->_getSanitizedParam("other_income");
					$parramsfilter['other_income_concept'] =  $this->_getSanitizedParam("other_income_concept");
					$parramsfilter['foreign_transactions'] =  $this->_getSanitizedParam("foreign_transactions");
					$parramsfilter['foreign_transactions_details'] =  $this->_getSanitizedParam("foreign_transactions_details");
					$parramsfilter['foreign_financial_products'] =  $this->_getSanitizedParam("foreign_financial_products");
					$parramsfilter['foreign_financial_products_details'] =  $this->_getSanitizedParam("foreign_financial_products_details");
					$parramsfilter['declarations'] =  $this->_getSanitizedParam("declarations");
					$parramsfilter['is_active'] =  $this->_getSanitizedParam("is_active");
					$parramsfilter['subscription_expiry_date'] =  $this->_getSanitizedParam("subscription_expiry_date");
					$parramsfilter['created_at'] =  $this->_getSanitizedParam("created_at");
					$parramsfilter['updated_at'] =  $this->_getSanitizedParam("updated_at");
					$parramsfilter['activity_type'] =  $this->_getSanitizedParam("activity_type");
					$parramsfilter['keywords'] =  $this->_getSanitizedParam("keywords");
					$parramsfilter['info_state'] =  $this->_getSanitizedParam("info_state");
					$parramsfilter['assets'] =  $this->_getSanitizedParam("assets");
					$parramsfilter['expenses'] =  $this->_getSanitizedParam("expenses");
					$parramsfilter['equity'] =  $this->_getSanitizedParam("equity");
					$parramsfilter['other_expenses'] =  $this->_getSanitizedParam("other_expenses");
					$parramsfilter['income_origin'] =  $this->_getSanitizedParam("income_origin");
					$parramsfilter['assets_total'] =  $this->_getSanitizedParam("assets_total");
					$parramsfilter['liabilities_total'] =  $this->_getSanitizedParam("liabilities_total");
					$parramsfilter['income_other'] =  $this->_getSanitizedParam("income_other");
					$parramsfilter['eeff'] =  $this->_getSanitizedParam("eeff");
					$parramsfilter['eeff_year'] =  $this->_getSanitizedParam("eeff_year");
					$parramsfilter['eeff_udate'] =  $this->_getSanitizedParam("eeff_udate");
					$parramsfilter['expenses_other'] =  $this->_getSanitizedParam("expenses_other");
					$parramsfilter['income_total'] =  $this->_getSanitizedParam("income_total");
					$parramsfilter['expenses_total'] =  $this->_getSanitizedParam("expenses_total");
					$parramsfilter['utility'] =  $this->_getSanitizedParam("utility");
					$parramsfilter['utility_total'] =  $this->_getSanitizedParam("utility_total");
					$parramsfilter['financial_expenses'] =  $this->_getSanitizedParam("financial_expenses");
					$parramsfilter['income_other_concept'] =  $this->_getSanitizedParam("income_other_concept");
					$parramsfilter['industry'] =  $this->_getSanitizedParam("industry");
					$parramsfilter['image'] =  $this->_getSanitizedParam("image");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}