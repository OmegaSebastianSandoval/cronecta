<?php

/**
 *
 */

class Supplier_profileController extends Supplier_mainController
{

  public $botonPanel = 4;

  protected $_csrf_section = "supplier_profile";


  public function indexAction()
  {
    $this->_csrf_section = "supplier_profile_" . date("YmdHis");
    $this->_csrf->generateCode($this->_csrf_section);
    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");

    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);
    $terms = $this->getTerms();
    $this->_view->list_supplier_soc_type = $this->getSuppliersoctype();
    $this->_view->list_country = $this->getCountry();
    $this->_view->profileComplete = round($this->getProfileComplete(), 2);


    $this->_view->userSupplier = $userSupplier;
    $this->_view->supplier = $supplier;
    $this->_view->terms = $terms;
  }


  public function updategeneralinfoAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");

    $isPost = $this->getRequest()->isPost();
    if (!$isPost) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro.'
      ];
      echo json_encode($res);
      exit;
    }

    if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] !== $csrf) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro.'
      ];
      echo json_encode($res);
      exit;
    }

    $data = $this->getDataGeneralInfo();
    $id = $this->_getSanitizedParam("id");
    $idUser = $this->_getSanitizedParam("id-user");
    if (empty($id) || empty($idUser)) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro.'
      ];
      echo json_encode($res);
      exit;
    }
    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();

    $content = $supplierModel->getById($id);
    $userContent = $userSupplierModel->getById($idUser);

    if (empty($content) || empty($userContent)) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro.'
      ];
      echo json_encode($res);
      exit;
    }

    $uploadImage =  new Core_Model_Upload_Image();

    if ($_FILES['image']['name'] != '') {
      if ($content->image) {
        $uploadImage->delete($content->image);
      }
      $data['image'] = $uploadImage->upload("image");
    } else {
      $data['image'] = $content->image;
    }

    $errors = [];

    // — 1) RAZÓN SOCIAL —
    if (empty($data['company_name'])) {
      $errors['company_name'] = 'La razón social es obligatoria';
    } else {
      $exist = $supplierModel->getList("company_name = '" . $data['company_name'] . "' AND id != '" . $id . "'", "");
      if ($exist) {
        $errors['company_name'] = 'La razón social ya existe';
      }
    }
    // — 3) TIPO DE SOCIEDAD —
    if (empty($data['supplier_soc_type'])) {
      $errors['supplier_soc_type'] = 'El tipo de sociedad es obligatorio';
    }

    // — 4) ACTIVIDAD COMERCIAL (mínimo 12 caracteres) —
    $act = $data['commercial_activity'] ?? '';
    if ($act === '') {
      $errors['commercial_activity'] = 'La actividad comercial es obligatoria';
    } elseif (mb_strlen($act) < 12) {
      $errors['commercial_activity'] = 'La actividad comercial debe tener al menos 12 caracteres';
    }
    if (empty($data['position'])) {
      $errors['position'] = 'El cargo es obligatorio';
    }


    $userData = $this->getDataUserInfo();

    if (empty($userData['name'])) {
      $errors['name'] = 'El nombre es obligatorio';
    }
    if (empty($userData['lastname'])) {
      $errors['lastname'] = 'El apellido es obligatorio';
    }
    if (empty($userData['area'])) {
      $errors['area'] = 'El departamento es obligatorio';
    }
    if (empty($userData['phone']) || !preg_match('/^\d{7,15}$/', $userData['phone'])) {
      $errors['phone'] = 'El teléfono es obligatorio y debe tener entre 7 y 15 dígitos';
    }

    // Si hay errores, devuelvo de una vez
    if (is_countable($errors) && count($errors) > 0) {
      $errorList = '<ul style="text-align:left; margin:0; padding-left:20px;">';
      foreach ($errors as $msg) {
        // escapa cualquier carácter especial
        $errorList .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
      }
      $errorList .= '</ul>';
      echo json_encode([
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'html' => $errorList,
        'text' => 'Error al guardar el registro.',
        'data' => $data,

      ]);
      exit;
    }

    $supplierModel->updateProfile($id, $data);
    $userSupplierModel->updateProfile($idUser, $userData);

    $res = [
      'success' => true,
      'title' => 'Success',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
    ];
    echo json_encode($res);
    exit;
  }

  public function getDataGeneralInfo()
  {
    $data = array();
    $data['company_name'] = $this->_getSanitizedParam("company_name");
    $data['supplier_soc_type'] = $this->_getSanitizedParam("supplier_soc_type");
    $data['country'] = $this->_getSanitizedParam("country");
    $data['city'] = $this->_getSanitizedParam("city");
    $data['state'] = $this->_getSanitizedParam("state");
    $data['commercial_activity'] = $this->_getSanitizedParamHtml("commercial_activity");
    $data['position'] = $this->_getSanitizedParam("position");
    $data['image'] = "";

    $data['updated_at'] = date("Y-m-d H:i:s");



    return $data;
  }
  private function getDataUserInfo()
  {
    $data = array();
    $data['name'] = $this->_getSanitizedParam("name");
    $data['lastname'] = $this->_getSanitizedParam("lastname");
    $data['phone'] = $this->_getSanitizedParam("phone");
    $data['area'] = $this->_getSanitizedParam("area");

    $data['password'] = $this->_getSanitizedParam("password");
    $data['password_confirmation'] = $this->_getSanitizedParam("password_confirmation");
    return $data;
  }
  public function getUserSupplier($id)
  {
    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();
    $userSupplier = $userSupplierModel->getById($id);
    return $userSupplier;
  }

  public function getSupplier($id)
  {
    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier = $supplierModel->getById($id);
    return $supplier;
  }

  public function getTerms()
  {
    $termsModel = new Administracion_Model_DbTable_Terms();
    $terminos = $termsModel->getList("", "");

    $terms  = [];
    foreach ($terminos as $term) {
      $terms[$term->id] = $term;
    }
    return $terms;
  }
  private function getIslegalentity()
  {
    $array = array();
    $array['1'] = 'Persona Natural';
    $array['2'] = 'Persona Juridica';
    return $array;
  }

  public function updateVisibilityStatusAction()
  {
    $this->setLayout("blanco");
    $id = $this->_getSanitizedParam('id');
    $visibility_status = $this->_getSanitizedParam('visibility_status');
    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier = $supplierModel->getById($id);
    if ($supplier) {
      $supplierModel->editField($id, 'visibility_status', $visibility_status);
      if ($visibility_status == 1) {
        $text = "Visibilidad activada correctamente";
      } else {
        $text = "Visibilidad desactivada correctamente";
      }
      echo json_encode(['success' => true, 'text' => $text]);
    } else {
      echo json_encode(['success' => false]);
    }
  }


  public function getProfileComplete($supplierId = null)
  {
    // $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $supplierModel = new Administracion_Model_DbTable_Supplier();
    if ($supplierId) {
      $supplier = $supplierModel->getById($supplierId);
    } else {
      $supplier = $supplierModel->getById($supplierSession->id);
    }
    $camposClave = [
      'company_name',          // Nombre de la compañía
      'primary_email',         // Email principal
      'economic_activity',     // Actividad económica
      'main_address',          // Dirección principal
      'identification_nit',    // NIT de identificación
      'city',                  // Ciudad
      'country',               // País
      'representative_name',   // Nombre del representante
      'mobile_phone',          // Teléfono móvil
    ];

    $camposLlenos = 0;
    foreach ($camposClave as $campo) {
      if (!empty($supplier->{$campo})) {
        $camposLlenos++;
      }
    }
    $totalCampos = count($camposClave);
    $porcentajeCompletitud = ($camposLlenos / $totalCampos) * 100;
    return $porcentajeCompletitud;
  }

  function getCertificationTypes(): array {
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
        "Certificado de Calidad Turística",
        "Certificado de Dedicación Exclusiva (Min Minas)",
        "Certificado NTS AV03",
        "Certificado NTS AV04",
        "Certificado API 653",
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
        "Póliza de Seguro Según Decreto 1843 de 1991 Art. 131",
        "Póliza Resp. Civil Extracontractual Decreto 356 de 1994",
        "Prestación de Servicios en Salud Ocupacional",
        "Programa Gestión Ambiental",
        "Protocolos de Bioseguridad",
        "Registro Nacional de Turismo",
        "Registro Sanitario",
        "Registro Único de Comercializadores de Minerales",
        "Registro Visita Asociado de Negocio",
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
        "Registro Único de Proponente (RUP)"

    ];

    // Creamos array asociativo con llave => valor igual
    return array_combine($types, $types);
}

}
