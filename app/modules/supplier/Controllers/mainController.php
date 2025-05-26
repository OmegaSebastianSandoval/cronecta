<?php

/**
 *
 */

class Supplier_mainController extends Controllers_Abstract
{

	public $template;
	public $editarpage = 0;
	public $botonPanel = 0;

	public function init()
	{
		$this->setLayout('supplier_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		$infopageModel = new Page_Model_DbTable_Informacion();
		$this->_view->botonpanel = $this->botonPanel;
		$userSession = Session::getInstance()->get("user");
		$supplierSession = Session::getInstance()->get("supplier");
		if ($supplierSession) {
			$userSession->supplierSessionInfo = $supplierSession;
			$this->_view->userSession = $userSession;
			$this->getLayout()->setData("expanded", true);
		}



		$informacion = $infopageModel->getById(1);
		$this->_view->infopage = $informacion;
		$this->getLayout()->setData("meta_description", "$informacion->info_pagina_descripcion");
		$this->getLayout()->setData("meta_keywords", "$informacion->info_pagina_tags");
		$this->getLayout()->setData("scripts", "$informacion->info_pagina_scripts");
		$botonesModel = new Page_Model_DbTable_Publicidad();
		$this->_view->botones = $botonesModel->getList("publicidad_seccion='3' AND publicidad_estado='1'", "orden ASC");

		$header = $this->_view->getRoutPHP('modules/supplier/Views/partials/header.php');
		$this->getLayout()->setData("header", $header);
		$enlaceModel = new Page_Model_DbTable_Enlace();
		$this->_view->enlaces = $enlaceModel->getList("", "orden ASC");
		$footer = $this->_view->getRoutPHP('modules/supplier/Views/partials/footer.php');
		$this->getLayout()->setData("footer", $footer);

		$adicionales = $this->_view->getRoutPHP('modules/supplier/Views/partials/adicionales.php');
		$this->getLayout()->setData("adicionales", $adicionales);
		$this->usuario();
	}


	public function usuario()
	{
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if ($user->user_id == 1) {
			$this->editarpage = 1;
		}
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

	public function partialsNoUser()
	{
		$this->getLayout()->setData("header", $this->_view->getRoutPHP('modules/supplier/Views/partials/header-no-user.php'));

		$this->getLayout()->setData("footer", $this->_view->getRoutPHP('modules/supplier/Views/partials/footer-no-user.php'));
	}

	/**
	 * Genera los valores del campo Tipo de sociedad.
	 *
	 * @return array cadena con los valores del campo Tipo de sociedad.
	 */
	public function getSuppliersoctype()
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
	public function getCountry()
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
	public function getResponsabilities()
	{
		$path = PUBLIC_PATH . "skins/dian_responsabilities2.json";

		// Verifica que el archivo existe
		if (!file_exists($path)) {
			return [];
		}

		// Lee el contenido del archivo
		$json = file_get_contents($path);
		$responsabilities = json_decode($json, true);


		return $responsabilities;
	}

	public function getCertificationTypes(): array
	{
		$types = [
			"(HACCP) Sistema de Análisis de Riesgos de Control en Puntos Críticos (HACCP)",
			"(ISO 14001) Sistema de Gestión Ambiental",
			"(ISO 22000) Sistema de Gestión de Seguridad de los Alimentos",
			"(ISO 28000) Sistema de Gestión de Seguridad en la Cadena de Suministro",
			"(ISO 50001) Sistema de Gestión de la Organización",
			"(ISO 55001) Sistema de Gestión de Activos",
			"(ISO 9001) Sistema de Gestión de la Calidad",
			"(ISO/IEC 17021-1:2015) Evaluación de la Conformidad",
			"(ISO/IEC 17043:2010) Evaluación de la Conformidad. Requisitos Generales para los Ensayos de Aptitud",
			"(ISO/IEC 17065:2012) Evaluación de la Conformidad",
			"(ISO/IEC 27001) Sistema de Gestión de Seguridad de la Información",
			"(ISO/TS 29001) Sistema de Gestión de la Calidad",
			"(NTC 5555) Sistema de Gestión de la Calidad",
			"(NTC 6001) Sistema de Gestión de la Calidad",
			"(NTCGP 1000) Sistema de Gestión de la Calidad",
			"(RUC) Gestión de Seguridad, Salud Ocupacional y Ambiente / Consejo Colombiano de Seguridad",
			"Acreditación de Servicios Logísticos ante el DGRED",
			"Acreditación Equipos Audiovisuales ante el DGRED",
			"Acreditación ISO IEC 17025",
			"Acta Tratamiento Residuos Peligrosos",
			"BASC",
			"Buenas Prácticas Ambientales",
			"C-TPAT",
			"Carta de Exclusividad",
			"Carta de Representación",
			"Certificación PMP (Project Management Professional)",
			"Certificación Póliza DIAN, Código Aduanero",
			"Certificado API 653",
			"Certificado de Calidad Turística",
			"Certificado de Dedicación Exclusiva (Min Minas)",
			"Certificado NTS AV03",
			"Certificado NTS AV04",
			"Cumplimiento de la Regulación NGS",
			"Declaration of Beneficial Ownership - Lufkin Industries LLC",
			"Distribuidor Autorizado",
			"Fabricante",
			"Habilitación Transporte",
			"IATA",
			"ISM Code Código Internacional de Gestión de la Seguridad Operacional del Buque y la Prevención de la Contaminación (Código IGS)",
			"ISO 17025",
			"ISO 20252:2012",
			"ISO 27001",
			"ISO 39001:2012 Seguridad Vial",
			"ISO 45001",
			"ISO 50001-2011",
			"ISO/IEC 17020:2012",
			"ISO/IEC 17024:2012",
			"ISO/IEC 20000-1:2011",
			"Licencia Ambiental Resolución 1470 CORTOLIMA",
			"Licencia de Explotación Comercial",
			"Licencia de Operación",
			"Licencia Min. TIC y ANE para Frecuencias Uso de Repetidores",
			"Licencia Sanitaria Aplicación de Plaguicidas, Roedores, SEC - Salud",
			"Manipulación de Alimentos",
			"Modelo de Economía Circular Aplicado al Alcance del Servicio",
			"Nivel II del Programa GAE de la SDA",
			"NORSOK S-0006",
			"NORSOK SWA-006",
			"NTC 3808 Taller de Recarga y Mantenimiento de Extintores",
			"NTC 6072 para los Centros de Formación",
			"Operador Económico Autorizado (OEA)",
			"Patente Generador de Nitrógeno",
			"Piloto de Dron",
			"Plan de Emergencia y Contingencia",
			"Plan Estratégico de Seguridad Vial (PESV)",
			"Prestación de Servicios en Salud Ocupacional",
			"Programa Gestión Ambiental",
			"Protocolos de Bioseguridad",
			"Póliza de Seguro Según Decreto 1843 de 1991 Art. 131",
			"Póliza Resp. Civil Extracontractual Decreto 356 de 1994",
			"Registro Nacional de Turismo",
			"Registro Sanitario",
			"Registro Visita Asociado de Negocio",
			"Registro Único de Comercializadores de Minerales",
			"Registro Único de Proponente (RUP)",
			"Representante Exclusivo",
			"Representante para Minería y Puertos",
			"Resolución 12292 Actividad como Agencia de Aduanas",
			"Resolución como Distribuidor Autorizado de Servicios",
			"Resolución de Transporte",
			"Resolución Facturación",
			"Responsabilidad Social",
			"RETIE",
			"RUCOM - Registro Único de Comercializadores de Minerales",
			"SAP Colombia S.A.S",
			"The National Board",
			"Turismo con Enfoque Regenerativo",


		];
		// Creamos array asociativo con llave => valor igual
		return array_combine($types, $types);
	}

	public function getIndustry()
	{
		$modelData = new Supplier_Model_DbTable_Dependindustries();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->name;
		}
		return $array;
	}

}
