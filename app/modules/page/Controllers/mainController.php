<?php 

/**
*
*/

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{

		$this->setLayout('page_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();

		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;
		$this->getLayout()->setData("meta_description","$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords","$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts","$informacion->info_pagina_scripts");
		$botonesModel = new Page_Model_DbTable_Publicidad();
		$this->_view->botones = $botonesModel->getList("publicidad_seccion='3' AND publicidad_estado='1'","orden ASC");

		$this->usuario();

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header",$header);
		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("","orden ASC");
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$this->getLayout()->setData("footer",$footer);
		$adicionales = $this->_view->getRoutPHP('modules/page/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales",$adicionales);
		
	}


	public function usuario(){
		/*
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if($user->user_id == 1){
			$this->editarpage = 1;
		}
		*/

		$clientSession = Session::getInstance()->get("client");
		if ($clientSession) {
			$this->_view->clientSession = $clientSession;
			$this->getLayout()->setData("expanded", true);
		}

	}

	public function getCountry()
	{		
		$path = PUBLIC_PATH . "skins/countries_min.json";

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

		/*
		// Mover "Colombia" al inicio del array
		usort($countries, function ($a, $b) {
			if ($a['name'] === 'Colombia') return -1;
			if ($b['name'] === 'Colombia') return 1;
			return 0;
		});
		*/

		return $countries;
	}


	public function partialsNoUser()
	{
		$this->getLayout()->setData("header", $this->_view->getRoutPHP('modules/supplier/Views/partials/header-no-user.php'));

		$this->getLayout()->setData("footer", $this->_view->getRoutPHP('modules/supplier/Views/partials/footer-no-user.php'));
	}


	public function partialsHome()
	{
		$this->getLayout()->setData("header", $this->_view->getRoutPHP('modules/page/Views/partials/header-home.php'));

		$this->getLayout()->setData("footer", $this->_view->getRoutPHP('modules/page/Views/partials/footer-home.php'));
	}	



	public function encrypt($data)
	{
		if (!is_numeric($data)) {
			return false;
		}
		$key = 2025; // Clave secreta (número fijo)
		return $data * $key + $key; // Operación matemática simple
	}

	public function decrypt($encryptedData)
	{
		if (!is_numeric($encryptedData)) {
			return false;
		}
		$key = 2025;
		return ($encryptedData - $key) / $key;
	}

	public function userTypes()
	{
		$data = [];
		$data[1] = "Cliente";
		$data[2] = "Proveedor";
		return $data;
	}

} 