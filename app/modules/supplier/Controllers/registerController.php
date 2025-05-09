<?php

/**
 * Controlador de Register que permite la  creacion, edicion  y eliminacion de los register del Sistema
 */
class Supplier_registerController extends Supplier_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos register
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
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "supplier_register";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador register .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Supplier_Model_DbTable_Register();
		$this->namefilter = "parametersfilterregister";
		$this->route = "/supplier/register";
		$this->namepages = "pages_register";
		$this->namepageactual = "page_actual_register";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  register con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_register_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_is_legal_entity = $this->getIslegalentity();
		$this->_view->list_state = $this->getState();
		$this->_view->list_country = $this->getCountry();

		$this->_view->list_industry = $this->getIndustry();
		$this->_view->list_supplier_soc_type = $this->getSuppliersoctype();

		$this->_view->routeform = $this->route . "/insert";
		$title = "Registro de proveedor";

		$this->_view->titlesection = $title;
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  register  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_register_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_is_legal_entity = $this->getIslegalentity();
		$this->_view->list_state = $this->getState();
		$this->_view->list_country = $this->getCountry();
		$this->_view->list_industry = $this->getIndustry();
		$this->_view->list_supplier_soc_type = $this->getSuppliersoctype();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$title = "Actualizar register";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear register";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear register";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un register  y redirecciona al listado de register.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadImage =  new Core_Model_Upload_Image();
			if ($_FILES['image']['name'] != '') {
				$data['image'] = $uploadImage->upload("image");
			}
			$uploadDocument =  new Core_Model_Upload_Document();
			if ($_FILES['trade_registry']['name'] != '') {
				$data['trade_registry'] = $uploadDocument->upload("trade_registry");
			}
			if ($_FILES['legal_representative_id']['name'] != '') {
				$data['legal_representative_id'] = $uploadDocument->upload("legal_representative_id");
			}
			if ($_FILES['rut_certificate']['name'] != '') {
				$data['rut_certificate'] = $uploadDocument->upload("rut_certificate");
			}
			if ($_FILES['financial_statements']['name'] != '') {
				$data['financial_statements'] = $uploadDocument->upload("financial_statements");
			}
			if ($_FILES['tax_declaration']['name'] != '') {
				$data['tax_declaration'] = $uploadDocument->upload("tax_declaration");
			}
			if ($_FILES['incorporation_certificate']['name'] != '') {
				$data['incorporation_certificate'] = $uploadDocument->upload("incorporation_certificate");
			}
			$id = $this->mainModel->insert($data);

			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR REGISTER';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un register  y redirecciona al listado de register.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
				$uploadImage =  new Core_Model_Upload_Image();
				if ($_FILES['image']['name'] != '') {
					if ($content->image) {
						$uploadImage->delete($content->image);
					}
					$data['image'] = $uploadImage->upload("image");
				} else {
					$data['image'] = $content->image;
				}
				$uploadDocument =  new Core_Model_Upload_Document();
				if ($_FILES['trade_registry']['name'] != '') {
					if ($content->trade_registry) {
						$uploadDocument->delete($content->trade_registry);
					}
					$data['trade_registry'] = $uploadDocument->upload("trade_registry");
				} else {
					$data['trade_registry'] = $content->trade_registry;
				}

				if ($_FILES['legal_representative_id']['name'] != '') {
					if ($content->legal_representative_id) {
						$uploadDocument->delete($content->legal_representative_id);
					}
					$data['legal_representative_id'] = $uploadDocument->upload("legal_representative_id");
				} else {
					$data['legal_representative_id'] = $content->legal_representative_id;
				}

				if ($_FILES['rut_certificate']['name'] != '') {
					if ($content->rut_certificate) {
						$uploadDocument->delete($content->rut_certificate);
					}
					$data['rut_certificate'] = $uploadDocument->upload("rut_certificate");
				} else {
					$data['rut_certificate'] = $content->rut_certificate;
				}

				if ($_FILES['financial_statements']['name'] != '') {
					if ($content->financial_statements) {
						$uploadDocument->delete($content->financial_statements);
					}
					$data['financial_statements'] = $uploadDocument->upload("financial_statements");
				} else {
					$data['financial_statements'] = $content->financial_statements;
				}

				if ($_FILES['tax_declaration']['name'] != '') {
					if ($content->tax_declaration) {
						$uploadDocument->delete($content->tax_declaration);
					}
					$data['tax_declaration'] = $uploadDocument->upload("tax_declaration");
				} else {
					$data['tax_declaration'] = $content->tax_declaration;
				}

				if ($_FILES['incorporation_certificate']['name'] != '') {
					if ($content->incorporation_certificate) {
						$uploadDocument->delete($content->incorporation_certificate);
					}
					$data['incorporation_certificate'] = $uploadDocument->upload("incorporation_certificate");
				} else {
					$data['incorporation_certificate'] = $content->incorporation_certificate;
				}
				$this->mainModel->update($data, $id);
			}
			$data['id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR REGISTER';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y elimina un register  y redirecciona al listado de register.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadImage =  new Core_Model_Upload_Image();
					if (isset($content->image) && $content->image != '') {
						$uploadImage->delete($content->image);
					}
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->trade_registry) && $content->trade_registry != '') {
						$uploadDocument->delete($content->trade_registry);
					}

					if (isset($content->legal_representative_id) && $content->legal_representative_id != '') {
						$uploadDocument->delete($content->legal_representative_id);
					}

					if (isset($content->rut_certificate) && $content->rut_certificate != '') {
						$uploadDocument->delete($content->rut_certificate);
					}

					if (isset($content->financial_statements) && $content->financial_statements != '') {
						$uploadDocument->delete($content->financial_statements);
					}

					if (isset($content->tax_declaration) && $content->tax_declaration != '') {
						$uploadDocument->delete($content->tax_declaration);
					}

					if (isset($content->incorporation_certificate) && $content->incorporation_certificate != '') {
						$uploadDocument->delete($content->incorporation_certificate);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR REGISTER';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Register.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['is_legal_entity'] = $this->_getSanitizedParam("is_legal_entity");
		$data['filling_date'] = $this->_getSanitizedParam("filling_date");
		$data['counterparty_type'] = $this->_getSanitizedParam("counterparty_type");
		$data['supplier_type'] = $this->_getSanitizedParam("supplier_type");
		$data['company_name'] = $this->_getSanitizedParam("company_name");
		$data['primary_email'] = $this->_getSanitizedParam("primary_email");
		$data['economic_activity'] = $this->_getSanitizedParam("economic_activity");
		$data['ciiu_code'] = $this->_getSanitizedParam("ciiu_code");
		$data['commercial_activity'] = $this->_getSanitizedParamHtml("commercial_activity");
		$data['website'] = $this->_getSanitizedParam("website");
		$data['main_address'] = $this->_getSanitizedParam("main_address");
		$data['company_type'] = $this->_getSanitizedParam("company_type");
		$data['identification_nit'] = $this->_getSanitizedParam("identification_nit");
		$data['city'] = $this->_getSanitizedParam("city");
		$data['state'] = $this->_getSanitizedParam("state");
		$data['country'] = $this->_getSanitizedParam("country");
		$data['landline'] = $this->_getSanitizedParam("landline");
		$data['mobile_phone'] = $this->_getSanitizedParam("mobile_phone");
		$data['trade_registry'] = "";
		$data['legal_representative_id'] = "";
		$data['rut_certificate'] = "";
		$data['financial_statements'] = "";
		$data['tax_declaration'] = "";
		$data['tax_declaration_year'] = $this->_getSanitizedParam("tax_declaration_year");
		$data['tax_declaration_udate'] = $this->_getSanitizedParam("tax_declaration_udate");
		if ($this->_getSanitizedParam("number_of_employees") == '') {
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
		if ($this->_getSanitizedParam("foreign_transactions") == '') {
			$data['foreign_transactions'] = '0';
		} else {
			$data['foreign_transactions'] = $this->_getSanitizedParam("foreign_transactions");
		}
		$data['foreign_transactions_details'] = $this->_getSanitizedParam("foreign_transactions_details");
		if ($this->_getSanitizedParam("foreign_financial_products") == '') {
			$data['foreign_financial_products'] = '0';
		} else {
			$data['foreign_financial_products'] = $this->_getSanitizedParam("foreign_financial_products");
		}
		$data['foreign_financial_products_details'] = $this->_getSanitizedParam("foreign_financial_products_details");
		$data['declarations'] = $this->_getSanitizedParam("declarations");
		if ($this->_getSanitizedParam("is_active") == '') {
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
		$data['image'] = "";
		if ($this->_getSanitizedParam("policy") == '') {
			$data['policy'] = '0';
		} else {
			$data['policy'] = $this->_getSanitizedParam("policy");
		}
		if ($this->_getSanitizedParam("visibility_status") == '') {
			$data['visibility_status'] = '0';
		} else {
			$data['visibility_status'] = $this->_getSanitizedParam("visibility_status");
		}
		$data['facebook'] = $this->_getSanitizedParam("facebook");
		$data['instagram'] = $this->_getSanitizedParam("instagram");
		$data['twitter'] = $this->_getSanitizedParam("twitter");
		$data['linkedin'] = $this->_getSanitizedParam("linkedin");
		$data['slug'] = $this->_getSanitizedParam("slug");
		$data['position'] = $this->_getSanitizedParam("position");
		$data['ip'] = $this->_getSanitizedParam("ip");
		$data['representative_name2'] = $this->_getSanitizedParam("representative_name2");
		$data['document_type2'] = $this->_getSanitizedParam("document_type2");
		$data['document_number2'] = $this->_getSanitizedParam("document_number2");
		$data['document_issue_place2'] = $this->_getSanitizedParam("document_issue_place2");
		$data['document_issue_date2'] = $this->_getSanitizedParam("document_issue_date2");
		$data['representative_birth_country'] = $this->_getSanitizedParam("representative_birth_country");
		$data['representative_birth_country2'] = $this->_getSanitizedParam("representative_birth_country2");
		$data['legal_representative_id2'] = $this->_getSanitizedParam("legal_representative_id2");
		$data['certificate_issue_date'] = $this->_getSanitizedParam("certificate_issue_date");
		$data['company_validity'] = $this->_getSanitizedParam("company_validity");
		$data['company_validity2'] = $this->_getSanitizedParam("company_validity2");
		$data['registry_state'] = $this->_getSanitizedParam("registry_state");
		$data['registry_city'] = $this->_getSanitizedParam("registry_city");
		$data['incorporation_certificate'] = "";
		$data['trade_registry_udate'] = $this->_getSanitizedParam("trade_registry_udate");
		$data['incorporation_certificate_udate'] = $this->_getSanitizedParam("incorporation_certificate_udate");
		$data['rut_certificate_udate'] = $this->_getSanitizedParam("rut_certificate_udate");
		$data['brochure'] = $this->_getSanitizedParam("brochure");
		$data['company_size'] = $this->_getSanitizedParam("company_size");
		$data['company_size_certificate'] = $this->_getSanitizedParam("company_size_certificate");
		$data['company_size_certificate_udate'] = $this->_getSanitizedParam("company_size_certificate_udate");
		$data['foreign_currency'] = $this->_getSanitizedParam("foreign_currency");
		$data['which_foreign_currency'] = $this->_getSanitizedParam("which_foreign_currency");
		$data['foreign_products'] = $this->_getSanitizedParam("foreign_products");
		$data['which_foreign_products'] = $this->_getSanitizedParam("which_foreign_products");
		$data['tax_liabilities'] = $this->_getSanitizedParam("tax_liabilities");
		$data['nontaxable_agent'] = $this->_getSanitizedParamHtml("nontaxable_agent");
		$data['supplier_soc_type'] = $this->_getSanitizedParam("supplier_soc_type");
		return $data;
	}


	public function getsegmentsAction(){
		$this->setLayout('blanco');
		$segmentsModel = new Administracion_Model_DbTable_Industrysegments();
		$industryId = $this->_getSanitizedParam("industryId");
		$segments = $segmentsModel->getList("industry_id = $industryId");
		echo json_encode($segments);
		}
	/**
	 * Genera los valores del campo Tipo de Persona.
	 *
	 * @return array cadena con los valores del campo Tipo de Persona.
	 */
	private function getIslegalentity()
	{
		$array = array();
		$array['1'] = 'Persona Natural';
		$array['2'] = 'Persona Juridica';
		return $array;
	}


	/**
	 * Genera los valores del campo Departamento/Estado.
	 *
	 * @return array cadena con los valores del campo Departamento/Estado.
	 */
	private function getState()
	{
		$array = array();
		$array['Data'] = 'Data';
		return $array;
	}


	/**
	 * Genera los valores del campo Pa&iacute;s.
	 *
	 * @return array cadena con los valores del campo Pa&iacute;s.
	 */
private function getCountry()
{
	$path = PUBLIC_PATH . "skins/countries.json";

	// Verifica que el archivo existe
	if (!file_exists($path)) {
		return [];
	}

	// Lee el contenido del archivo
	$json = file_get_contents($path);
	$countries = json_decode($json, true);

	if (!is_array($countries)) {
		return [];
	}

	// Mover "Colombia" al inicio del array
	usort($countries, function ($a, $b) {
		if ($a['name'] === 'Colombia') return -1;
		if ($b['name'] === 'Colombia') return 1;
		return 0;
	});

	return $countries;
}


	/**
	 * Genera los valores del campo industry.
	 *
	 * @return array cadena con los valores del campo industry.
	 */
	private function getIndustry()
	{
		$modelData = new Supplier_Model_DbTable_Dependindustries();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->name;
		}
		return $array;
	}


	/**
	 * Genera los valores del campo Tipo de sociedad.
	 *
	 * @return array cadena con los valores del campo Tipo de sociedad.
	 */
	private function getSuppliersoctype()
	{

		$array = array();
		$array['S.A.S – Sociedad por Acciones Simplificada'] = 'S.A.S – Sociedad por Acciones Simplificada';
		$array['Ltda. - Limitada'] = 'Ltda. - Limitada';
		$array['S.A. - Sociedad Anónima'] = 'S.A. - Sociedad Anónima';
		$array['En comandita por acciones'] = 'En comandita por acciones';
		$array['Comandita Simple'] = 'Comandita Simple';
		$array['Cooperativa'] = 'Cooperativa';
		$array['Empresa unipersonal'] = 'Empresa unipersonal';
		$array['Sucursal de sociedad extranjera'] = 'Sucursal de sociedad extranjera';
		$array['Otro'] = 'Otro';
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
		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
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
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}
}
