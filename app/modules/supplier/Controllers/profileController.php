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
    $this->_view->segments = $this->getSegments();
		$this->_view->list_industry = $this->getIndustry();


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


  public function updateCompanyInfoAction()
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

    $data = $this->getDataCompanyInfo();
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


    $errors = [];

    if (empty($data['is_legal_entity'])) {
      $errors['is_legal_entity'] = 'El tipo de sociedad es obligatorio';
    }
    if (empty($data['counterparty_type'])) {
      $errors['counterparty_type'] = 'El tipo de contraparte es obligatorio';
    }
    if (empty($data['company_type'])) {
      $errors['company_type'] = 'El tipo de empresa es obligatorio';
    }
    if (empty($data['activity_type'])) {
      $errors['activity_type'] = 'El tipo de actividad es obligatorio';
    }
    if (empty($data['main_address'])) {
      $errors['main_address'] = 'La dirección principal es obligatoria';
    }
    if (empty($data['country'])) {
      $errors['country'] = 'El país es obligatorio';
    }
    if (empty($data['company_size'])) {
      $errors['company_size'] = 'El tamaño de la empresa es obligatorio';
    }
    $emailPrimary = $data['primary_email'];
    if (empty($emailPrimary)) {
      $errors['primary_email'] = 'El email principal es obligatorio';
    }
    if (!filter_var($emailPrimary, FILTER_VALIDATE_EMAIL)) {
      $errors['primary_email'] = 'El email principal no es válido';
    }
    $emailExist = $supplierModel->getList("primary_email = '" . $emailPrimary . "' AND id != '" . $id . "'", "");
    if ($emailExist) {
      $errors['primary_email'] = 'El email principal ya existe';
    }
    if (empty($data['mobile_phone']) || !preg_match('/^\d{7,15}$/', $data['mobile_phone'])) {
      $errors['mobile_phone'] = 'El teléfono móvil es obligatorio y debe tener entre 7 y 15 dígitos';
    }


    if ($data['number_of_employees'] <= 0) {
      $errors['number_of_employees'] = 'El número de empleados es obligatorio';
    }
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
    $uploadDocument =  new Core_Model_Upload_Document();
    if ($_FILES['company_size_certificate']['name'] != '') {
      if ($content->company_size_certificate) {
        $uploadDocument->delete($content->company_size_certificate);
      }
      $data['company_size_certificate'] = $uploadDocument->upload("company_size_certificate");
    } else {
      $data['company_size_certificate'] = $content->company_size_certificate;
    }
    if ($_FILES['brochure']['name'] != '') {
      if ($content->brochure) {
        $uploadDocument->delete($content->brochure);
      }
      $data['brochure'] = $uploadDocument->upload("brochure");
    } else {
      $data['brochure'] = $content->brochure;
    }


    $supplierModel->updateProfileCompany($id, $data);

    $supplier = $supplierModel->getById($id);
    Session::getInstance()->set("supplier", $supplier);

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
      'brochure' => "/files/$supplier->brochure",
      'company_size_certificate' => "/files/$supplier->company_size_certificate",
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

  public function getDataCompanyInfo()
  {
    $data = array();
    $data['is_legal_entity'] = $this->_getSanitizedParam("is_legal_entity");
    $data['counterparty_type'] = $this->_getSanitizedParam("counterparty_type");
    $data['company_type'] = $this->_getSanitizedParam("company_type");
    $data['activity_type'] = $this->_getSanitizedParam("activity_type");
    $data['main_address'] = $this->_getSanitizedParam("main_address");
    $data['country'] = $this->_getSanitizedParam("country");
    $data['state'] = $this->_getSanitizedParam("state");
    $data['city'] = $this->_getSanitizedParam("city");
    $data['mobile_phone'] = $this->_getSanitizedParam("mobile_phone");
    $data['primary_email'] = $this->_getSanitizedParam("primary_email");
    $data['company_size'] = $this->_getSanitizedParam("company_size");
    $data['company_size_certificate'] = "";
    $data['number_of_employees'] = $this->_getSanitizedParam("number_of_employees");
    $data['website'] = $this->ensureHttps($this->_getSanitizedParam("website") ?? "");
    $data['brochure'] = "";
    $data['facebook'] = $this->ensureHttps($this->_getSanitizedParam("facebook") ?? "");
    $data['instagram'] = $this->ensureHttps($this->_getSanitizedParam("instagram"));
    $data['twitter'] = $this->ensureHttps($this->_getSanitizedParam("twitter") ?? "");
    $data['linkedin'] = $this->ensureHttps($this->_getSanitizedParam("linkedin") ?? "");
    $data['keywords'] = $this->_getSanitizedParam("keywords");
    $data['updated_at'] = date("Y-m-d H:i:s");
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
  public function getIslegalentity()
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

  public function getSegments($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");

    $id = $supplierId ?? $supplierSession->id;
    $industriesModel = new Administracion_Model_DbTable_Supplierindustries();
    $segmentsModel = new Administracion_Model_DbTable_Suppliersegments();
    $industries = $industriesModel->getList("supplier_id = $id", "");
    foreach ($industries as $industry) {
      $industry->segments = $segmentsModel->getList("industry_id = $industry->id AND supplier_id = $id ", "");
    }

    return $industries;
  }
  public function ensureHttps($url)
  {
    $url = trim($url);
    if (empty($url)) return ''; // si está vacío, retorna vacío
    if (!preg_match('/^https?:\/\//i', $url)) {
      return 'https://' . $url;
    }
    return $url;
  }
}
