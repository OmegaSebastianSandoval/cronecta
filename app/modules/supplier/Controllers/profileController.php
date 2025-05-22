<?php

/**
 *
 */

class Supplier_profileController extends Supplier_mainController
{

  public $botonPanel = 4;

  protected $_csrf_section = "supplier_profile";

  public function init()
  {
    $user = Session::getInstance()->get("user");
    $supplier = Session::getInstance()->get("supplier");

    if (!$user || !$supplier) {
      header('Location: /supplier/login');
      exit;
    }
    parent::init();
  }
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
    $this->_view->sedesSupplier = $this->getSedes();
    $this->_view->list_certification_types = $this->getCertificationTypes();
    $this->_view->list_banks = $this->getBanks();


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

  public function savesegmentsAction()
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
    $industries = $_POST['industry'] ?? [];
    $segments = $_POST['segment'] ?? [];

    $groups = [];

    foreach ($industries as $index => $industryId) {
      $group = [
        'industry' => $industryId,
        'segments' => $segments[$index] ?? []
      ];
      $groups[] = $group;
    }

    $this->deleteAllsegmentsForSupplier();
    if (is_countable($groups) && count($groups) > 0) {
      $industriesSupplierModel =  new Administracion_Model_DbTable_Supplierindustries();
      $segmentsSupplierModel =  new Administracion_Model_DbTable_Suppliersegments();

      foreach ($groups as $group) {
        $industryId = $group['industry'];
        if ($industryId) {
          $dataIndustry = [
            'supplier_id' => $id,
            'industry_id' => $industryId,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
          ];
          $idIndustry = $industriesSupplierModel->insert($dataIndustry);
        }
        $segments = $group['segments'];
        foreach ($segments as $segment) {
          $dataSegment = [
            'industry_id' => $idIndustry,
            'segment_id' => $segment,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'supplier_id' => $id
          ];
          $segmentId = $segmentsSupplierModel->insert($dataSegment);
        }
      }
    }

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
    ];
    echo json_encode($res);
    exit;
  }

  public function savesedesAction()
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
    $names = $_POST['location_name'] ?? [];
    $addresses = $_POST['location_address'] ?? [];
    $phones = $_POST['location_mobile_phone'] ?? [];
    $countries = $_POST['location_country'] ?? [];
    $states = $_POST['location_state'] ?? [];
    $cities = $_POST['location_city'] ?? [];

    $locations = [];

    for ($i = 0; $i < count($names); $i++) {
      $locations[] = [
        'name'         => $names[$i] ?? '',
        'address'      => $addresses[$i] ?? '',
        'mobile_phone' => $phones[$i] ?? '',
        'country'      => $countries[$i] ?? '',
        'state'        => $states[$i] ?? '',
        'city'         => $cities[$i] ?? '',
      ];
    }
    $this->deleteSedesForSupplier($id);
    if (is_countable($locations) && count($locations) > 0) {

      $supplierLocationModel = new Administracion_Model_DbTable_Supplierslocations();
      foreach ($locations as $location) {
        $dataLocation = [
          'name' => $location['name'],
          'address' => $location['address'],
          'mobile_phone' => $location['mobile_phone'],
          'country' => $location['country'],
          'state' => $location['state'],
          'city' => $location['city'],
          'supplier_id' => $id,
          'updated_at' => date("Y-m-d H:i:s"),
          'created_at' => date("Y-m-d H:i:s"),
        ];
        $supplierLocationModel->insert($dataLocation);
      }
    }
    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
    ];
    echo json_encode($res);
    exit;
  }

  public function savebankinfoAction()
  {
    $this->setLayout('blanco');
    //error_reporting(E_ALL);
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);

    $id = $this->_getSanitizedParam("id");
    $idUser = $this->_getSanitizedParam("id-user");
    $uploadDocument = new Core_Model_Upload_Document();
    if (is_countable($_POST['country']) && count($_POST['country']) > 0) {
      $accountCount = count($_POST['country']);
    } else {
      $this->deleteAllBankInfoForSupplier($id);
      $res = [
        'success' => true,
        'title' => 'Listo',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Información bancaria actualizada correctamente',
      ];
      echo json_encode($res);
      exit;
    }
    $accountData = [];
    $uploadedFiles = [];

    // Procesar cada cuenta bancaria
    for ($i = 0; $i < $accountCount; $i++) {
      $certificatePath = $_POST['existing_account_certificate'][$i] ?? null;

      // Manejar la subida del certificado bancario si existe
      if (!empty($_FILES['account_certificate']['name'][$i])) {
        // Configurar el nombre temporal del archivo para el uploader
        $_FILES['account_certificate_temp'] = [
          'name' => $_FILES['account_certificate']['name'][$i],
          'type' => $_FILES['account_certificate']['type'][$i],
          'tmp_name' => $_FILES['account_certificate']['tmp_name'][$i],
          'error' => $_FILES['account_certificate']['error'][$i],
          'size' => $_FILES['account_certificate']['size'][$i]
        ];

        try {
          $certificatePath = $uploadDocument->upload("account_certificate_temp");
          $uploadedFiles[] = $certificatePath;
        } catch (Exception $e) {
          // Manejar el error de subida
          $res = [
            'success' => false,
            'title' => 'Error',
            'status' => 'error',
            'icon' => 'error',
            'text' => 'Error al subir el archivo: ' . $e->getMessage()
          ];
          echo json_encode($res);
          exit;
        }
      }




      $accountData[] = [
        'country' => $_POST['country'][$i],
        'bank' => $_POST['bank'][$i],
        'office' => $_POST['office'][$i],
        'account_type' => $_POST['account_type'][$i],
        'holder' => $_POST['holder'][$i],
        'account_number' => $_POST['account_number'][$i],
        'account_certificate_udate' => $_POST['account_certificate_udate'][$i],
        'swift_number' => $_POST['swift_number'][$i],
        'routing_number' => $_POST['routing_number'][$i],
        'iban' => $_POST['iban'][$i],
        'bic' => $_POST['bic'][$i],
        'intermediary_bank' => $_POST['intermediary_bank'][$i],
        'account_certificate' => $certificatePath,
        'supplier_id' => $id,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
      ];
    }


    // Eliminar registros anteriores y guardar los nuevos
    $certificadosAConservar = array_filter(array_map(function ($v) {
      return $v ?? null;
    }, $_POST['existing_account_certificate'] ?? []));
    $this->deleteAllBankInfoForSupplier($id, $certificadosAConservar);
    $supplierBankInfoModel = new Administracion_Model_DbTable_Suppliersbank();

    foreach ($accountData as $account) {
      $supplierBankInfoModel->insert($account);
    }

    // Obtener los datos actualizados para devolver a la vista
    $updatedAccounts = $supplierBankInfoModel->getList("supplier_id = $id", "");

    // Preparar la respuesta con los datos actualizados
    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información bancaria actualizada correctamente',
      'accounts' => array_map(function ($account) {
        return [
          'id' => $account->id,
          'country' => $account->country,
          'bank' => $account->bank,
          'account_number' => $account->account_number,
          'account_certificate' => $account->account_certificate ? $account->account_certificate : null,
          'account_certificate_udate' => $account->account_certificate_udate,
          'swift_number' => $account->swift_number,
          'routing_number' => $account->routing_number,
          'iban' => $account->iban,
          'bic' => $account->bic,
          'intermediary_bank' => $account->intermediary_bank,
          'office' => $account->office,
          'account_type' => $account->account_type,
          'holder' => $account->holder,
          'updated_at' => $account->updated_at,
          'created_at' => $account->created_at,
        ];
      }, $updatedAccounts),
      'uploaded_files' => array_map(function ($file) {
        return $file;
      }, $uploadedFiles)
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
    if ($id) {
      $industries = $industriesModel->getList("supplier_id = $id", "");
      foreach ($industries as $industry) {
        $industry->segments = $segmentsModel->getList("industry_id = $industry->id AND supplier_id = $id ", "");
      }
    } else {
      $industries = [];
    }

    return $industries;
  }

  public function getSedes($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierLocationModel = new Administracion_Model_DbTable_Supplierslocations();
    $sedes = $supplierLocationModel->getList("supplier_id = $id", "");
    return $sedes;
  }

  public function getBanks($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierBankInfoModel = new Administracion_Model_DbTable_Suppliersbank();
    $banks = $supplierBankInfoModel->getList("supplier_id = $id", "");
    return $banks;
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

  public function deleteAllsegmentsForSupplier($supplierId = null)
  {
    $industriesSegmentsModel = new Administracion_Model_DbTable_Supplierindustries();
    $segmentsSupplierModel = new Administracion_Model_DbTable_Suppliersegments();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;

    $industriesSupplier = $industriesSegmentsModel->getList("supplier_id = $id", "");
    $segmentsSupplier = $segmentsSupplierModel->getList("supplier_id = $id", "");

    if ($industriesSupplier) {
      foreach ($industriesSupplier as $industry) {
        $industriesSegmentsModel->deleteRegister($industry->id);
      }
    }
    if ($segmentsSupplier) {
      foreach ($segmentsSupplier as $segment) {
        $segmentsSupplierModel->deleteRegister($segment->id);
      }
    }
  }

  public function deleteSedesForSupplier($supplierId = null)
  {
    $supplierLocationModel = new Administracion_Model_DbTable_Supplierslocations();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $locations = $supplierLocationModel->getList("supplier_id = $id", "");
    if ($locations) {
      foreach ($locations as $location) {
        $supplierLocationModel->deleteRegister($location->id);
      }
    }
  }

  public function deleteAllBankInfoForSupplier($supplierId = null, $excludeCertificates = [])
  {
    $supplierBankInfoModel = new Administracion_Model_DbTable_Suppliersbank();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $bankInfo = $supplierBankInfoModel->getList("supplier_id = $id", "");
    if ($bankInfo) {
      foreach ($bankInfo as $bank) {
        if ($bank->account_certificate && !in_array($bank->account_certificate, $excludeCertificates)) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($bank->account_certificate);
        }
        $supplierBankInfoModel->deleteRegister($bank->id);
      }
    }
  }

  protected function validarPeticionCSRFYDatos($requiredFields = [])
  {
    $csrf = $this->_getSanitizedParam("csrf");
    $csrfSection = $this->_getSanitizedParam("csrf_section");

    if (!$this->getRequest()->isPost()) {
      $this->responderError("Error al guardar el registro.");
    }

    if (Session::getInstance()->get('csrf')[$csrfSection] !== $csrf) {
      $this->responderError("Token CSRF inválido.");
    }

    foreach ($requiredFields as $field) {
      $value = $this->_getSanitizedParam($field);
      if (empty($value)) {
        $this->responderError("Falta el campo obligatorio: $field");
      }
    }
  }
  protected function responderError($mensaje)
  {
    echo json_encode([
      'success' => false,
      'title' => 'Error',
      'status' => 'error',
      'icon' => 'error',
      'text' => $mensaje
    ]);
    exit;
  }
}
