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

  #region IndexAction
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
    $this->_view->list_responsabilities = $this->getResponsabilities();
    $this->_view->profileComplete = round($this->getProfileComplete(), 2);
    $this->_view->segmentsIndustries = $this->getSegments();
    $this->_view->list_industry = $this->getIndustry();
    $this->_view->sedesSupplier = $this->getSedes();
    $this->_view->list_certification_types = $this->getCertificationTypes();
    $this->_view->list_banks = $this->getBanks();
    $this->_view->list_certifications = $this->getCertifications();
    $this->_view->list_experiences = $this->getExperiences();
    $this->_view->list_ica_liabilities = $this->getIcaLiabilities();
    $this->_view->list_sst = $this->getSGSST();
    $this->_view->list_shareholders = $this->getShareholders();
    $this->myActivities();


    $this->_view->userSupplier = $userSupplier;
    $this->_view->supplier = $supplier;
    $this->_view->terms = $terms;


    $paises_json = $this->getCountry();

    $paises = array();
    $regiones = array();
    $ciudades = array();

    foreach ($paises_json as $value) {
      $paises[] = $pais = $value['name'];
      $regiones[] = $region = $value['subregion'];

      $array_estados = $value['states'];
      foreach ($array_estados as $estado) {
        $estados[] = $estado['name'];

        $array_ciudades = $estado['cities'];
        foreach ($array_ciudades as $ciudad) {
          $ciudades[] = $ciudad['name'];
        }
      }

      //$pais_region[$region][]=$value;

    }

    $regiones = array_unique($regiones);

    /*
    $items = array();    
    foreach($regiones as $value){
      $items[]=$value;
    }
    foreach($paises as $value){
      $items[]=$value;
    }
    foreach($estados as $value){
      $items[]=$value;
    }
    foreach($ciudades as $value){
      //$items[]=$value;
    } 
        
    $items = array_unique($items);
    asort($items);  
    */
    asort($regiones);

    unset($paises_json);

    // $this->_view->items = $items;
    $this->_view->regiones = $regiones;
    // $this->_view->pais_region = $pais_region;


    $supplier_id = $_SESSION['supplier']->id;
    // $supplier_id = 1;
    $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
    $geolocations = $geolocationModel->getList(" supplier_id='$supplier_id' ", " level ASC, name ASC ");
    $this->_view->geolocations = $geolocations;
  }

  #endregion

  #region UpdateGeneralInfo
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
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
    ];
    echo json_encode($res);
    exit;
  }

  #endregion

  #region UpdateCompanyInfo
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
  #endregion

  #region SaveSegments
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
  #endregion

  #region SaveSedes
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
        $location['mobile_phone'] = str_replace(" ","",$location['mobile_phone']);
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
  #endregion

  #region SaveBankInfo
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
  #endregion

  #region SaveCertifications
  public function savecertificationsAction()
  {
    $this->setLayout('blanco');
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);

    $id = $this->_getSanitizedParam("id");
    $certificationsGroup = $_POST['certifications'] ?? [];

    if (empty($certificationsGroup)) {
      $this->deleteAllCertificationsForSupplier($id);
      $res = [
        'success' => true,
        'title' => 'Listo',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Certificaciones actualizadas correctamente',
      ];
      echo json_encode($res);
      exit;
    }

    $certificadosAConservar = array_filter(array_map(function ($cert) {
      return $cert['existing_file'] ?? null;
    }, $_POST['certifications'] ?? []));

    $this->deleteAllCertificationsForSupplier($id, $certificadosAConservar);

    // Reorganizar archivos
    $archivosReorganizados = $this->reestructurarArchivosCertifications($_FILES['certifications']);


    $uploadDocument = new Core_Model_Upload_Document();

    foreach ($certificationsGroup as $index => $certification) {
      $certificationData = [
        'supplier_id' => $id,
        'type' => $certification['type'],
        'start_date' => $certification['start_date'],
        'end_date' => $certification['end_date'],
        'comment' => $certification['comment'] ?? null,
      ];

      // Si hay archivo nuevo, subirlo
      if (
        isset($archivosReorganizados[$index]['certification_file']) &&
        !empty($archivosReorganizados[$index]['certification_file']['tmp_name'])
      ) {
        $_FILES['certification_file_temp'] = $archivosReorganizados[$index]['certification_file'];
        $certificationData['certification_file'] = $uploadDocument->upload('certification_file_temp');
      } else {
        $certificationData['certification_file'] = $certification['existing_file'] ?? null;
      }

      $supplierCertificationsModel = new Administracion_Model_DbTable_Suppliercertificates();
      $supplierCertificationsModel->insert($certificationData);
    }

    // 1. Volver a cargar los registros actualizados
    $updatedCerts = $supplierCertificationsModel->getList("supplier_id = $id", "");

    // 2. Convertir en arreglo limpio para frontend
    $certsFormatted = array_map(function ($cert) {
      return [
        'type' => $cert->type,
        'start_date' => $cert->start_date,
        'end_date' => $cert->end_date,
        'comment' => $cert->comment,
        'certification_file' => $cert->certification_file
      ];
    }, $updatedCerts);

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Certificaciones actualizadas correctamente',
      'certifications' => $certsFormatted
    ];
    echo json_encode($res);
    exit;
  }
  function reestructurarArchivosCertifications($files)
  {
    $result = [];

    foreach ($files['name'] as $i => $fileGroup) {
      foreach ($fileGroup as $fieldName => $value) {
        $result[$i][$fieldName]['name'] = $files['name'][$i][$fieldName];
        $result[$i][$fieldName]['type'] = $files['type'][$i][$fieldName];
        $result[$i][$fieldName]['tmp_name'] = $files['tmp_name'][$i][$fieldName];
        $result[$i][$fieldName]['error'] = $files['error'][$i][$fieldName];
        $result[$i][$fieldName]['size'] = $files['size'][$i][$fieldName];
      }
    }

    return $result;
  }
  #endregion


  #region SaveExperiences
  public function saveexperiencesAction()
  {
    $this->setLayout('blanco');
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);

    $id = $this->_getSanitizedParam("id");
    $experiencesGroup = $_POST['experiences'] ?? [];

    if (empty($experiencesGroup)) {
      $this->deleteAllExperiencesForSupplier($id);
      $res = [
        'success' => true,
        'title' => 'Listo',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Experiencias actualizadas correctamente',
      ];
      echo json_encode($res);
      exit;
    }

    $documentosAConservar = array_filter(array_map(function ($exp) {
      return $exp['existing_file'] ?? null;
    }, $_POST['experiences'] ?? []));

    $this->deleteAllExperiencesForSupplier($id, $documentosAConservar);

    // Reorganizar archivos
    $archivosReorganizados = $this->reestructurarArchivosExperiences($_FILES['experiences']);

    $uploadDocument = new Core_Model_Upload_Document();

    foreach ($experiencesGroup as $index => $experience) {
      $experienceData = [
        'supplier_id' => $id,
        'company_name' => $experience['company_name'],
        'industry' => $experience['industry'],
        'segments' => $experience['segment'],
        'country' => $experience['country'],
        'state' => $experience['state'],
        'city' => $experience['city'],
        'contract_object' => $experience['contract_object'],
        'contract_value' => $experience['contract_value'],
        'currency' => $experience['currency'],
        'contract_start_year' => $experience['contract_start_year'],
        'contract_end_year' => $experience['contract_current'] ? 'En curso' : $experience['contract_end_year'],
        'contract_current' => $experience['contract_current'] ? 1 : 0,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'document_file_udate' => date('Y-m-d H:i:s'),
      ];

      // Si hay archivo nuevo, subirlo
      if (
        isset($archivosReorganizados[$index]['document_file']) &&
        !empty($archivosReorganizados[$index]['document_file']['tmp_name'])
      ) {
        $_FILES['document_file_temp'] = $archivosReorganizados[$index]['document_file'];
        $experienceData['document_file'] = $uploadDocument->upload('document_file_temp');
      } else {
        $experienceData['document_file'] = $experience['existing_file'] ?? null;
      }

      $supplierExperiencesModel = new Administracion_Model_DbTable_Supplierexperiences();
      $supplierExperiencesModel->insert($experienceData);
    }

    // 1. Volver a cargar los registros actualizados
    $updatedExps = $supplierExperiencesModel->getList("supplier_id = $id", "");

    // 2. Convertir en arreglo limpio para frontend
    $expsFormatted = array_map(function ($exp) {
      return [
        'company_name' => $exp->company_name,
        'industry' => $exp->industry,
        'segments' => $exp->segments,
        'country' => $exp->country,
        'state' => $exp->state,
        'city' => $exp->city,
        'contract_object' => $exp->contract_object,
        'contract_value' => $exp->contract_value,
        'currency' => $exp->currency,
        'contract_start_year' => $exp->contract_start_year,
        'contract_end_year' => $exp->contract_end_year,
        'contract_current' => $exp->contract_current == 1,
        'document_file' => $exp->document_file
      ];
    }, $updatedExps);

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Experiencias actualizadas correctamente',
      'confirmButtonText' => 'Continuar',
      'experiences' => $expsFormatted
    ];
    echo json_encode($res);
    exit;
  }

  #region UpdateFinancialInfo
  public function updatefinancialinfoAction()
  {
    // error_reporting(E_ALL);
    $this->setLayout('blanco');
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);
    $id = $this->_getSanitizedParam("id");
    $idUser = $this->_getSanitizedParam("id-user");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $content = $supplierModel->getById($id);

    if (empty($content)) {
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
    $data = $this->getDataFinancialInfo();
    $uploadDocument = new Core_Model_Upload_Document();

    // Manejar el archivo eeff
    if ($_FILES['eeff']['name'] != '') {
      if ($content->eeff) {
        $uploadDocument->delete($content->eeff);
      }
      $data['eeff'] = $uploadDocument->upload("eeff");
    } else {
      $data['eeff'] = $content->eeff;
    }

    // Manejar el archivo tax_declaration
    if ($_FILES['tax_declaration']['name'] != '') {
      if ($content->tax_declaration) {
        $uploadDocument->delete($content->tax_declaration);
      }
      $data['tax_declaration'] = $uploadDocument->upload("tax_declaration");
    } else {
      $data['tax_declaration'] = $content->tax_declaration;
    }

    $errors = [];

    // Validaciones básicas
    if (empty($data['income_origin'])) {
      $errors['income_origin'] = 'El origen de los recursos es obligatorio';
    }
    if (empty($data['currency_type'])) {
      $errors['currency_type'] = 'El tipo de moneda es obligatorio';
    }
    if (empty($data['equity'])) {
      $errors['equity'] = 'El patrimonio es obligatorio';
    }
    if (empty($data['assets'])) {
      $errors['assets'] = 'Los activos corrientes son obligatorios';
    }
    if (empty($data['liabilities'])) {
      $errors['liabilities'] = 'Los pasivos corrientes son obligatorios';
    }
    if (empty($data['assets_total'])) {
      $errors['assets_total'] = 'Los activos totales son obligatorios';
    }
    if (empty($data['liabilities_total'])) {
      $errors['liabilities_total'] = 'Los pasivos totales son obligatorios';
    }
    if (empty($data['income'])) {
      $errors['income'] = 'Los ingresos son obligatorios';
    }
    if (empty($data['expenses'])) {
      $errors['expenses'] = 'Los egresos operacionales son obligatorios';
    }
    if (empty($data['income_other'])) {
      $errors['income_other'] = 'Los otros ingresos son obligatorios';
    }
    if (empty($data['expenses_other'])) {
      $errors['expenses_other'] = 'Los otros egresos son obligatorios';
    }
    if (empty($data['income_total'])) {
      $errors['income_total'] = 'El total de ingresos es obligatorio';
    }
    if (empty($data['expenses_total'])) {
      $errors['expenses_total'] = 'El total de egresos es obligatorio';
    }
    if (empty($data['utility'])) {
      $errors['utility'] = 'La utilidad operacional es obligatoria';
    }
    if (empty($data['utility_total'])) {
      $errors['utility_total'] = 'La utilidad neta antes de impuestos es obligatoria';
    }
    if (empty($data['financial_expenses'])) {
      $errors['financial_expenses'] = 'Los gastos intereses financieros son obligatorios';
    }

    // Si hay errores, devuelvo de una vez
    if (is_countable($errors) && count($errors) > 0) {
      $errorList = '<ul style="text-align:left; margin:0; padding-left:20px;">';
      foreach ($errors as $msg) {
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

    $supplierModel->updateFinancialInfo($id, $data);

    // Manejar las responsabilidades ICA
    $icaLiabilitiesModel = new Administracion_Model_DbTable_Suppliericaliabilities();

    // Eliminar responsabilidades existentes
    $existingLiabilities = $icaLiabilitiesModel->getList("supplier_id = $id", "");
    if ($existingLiabilities) {
      foreach ($existingLiabilities as $liability) {
        $icaLiabilitiesModel->deleteRegister($liability->id);
      }
    }

    // Insertar nuevas responsabilidades
    if (isset($_POST['ica_liabilities']) && is_array($_POST['ica_liabilities'])) {
      foreach ($_POST['ica_liabilities'] as $liability) {
        $liabilityData = [
          'supplier_id' => $id,
          'country' => $liability['country'],
          'state' => $liability['state'],
          'city' => $liability['city'],
          'code' => $liability['code'],
          'fee' => $liability['fee'],
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ];
        $icaLiabilitiesModel->insert($liabilityData);
      }
    }

    $supplierUpdated = $supplierModel->getById($id);

    // Obtener las responsabilidades ICA actualizadas
    $updatedLiabilities = $icaLiabilitiesModel->getList("supplier_id = $id", "");
    $formattedLiabilities = [];
    if ($updatedLiabilities) {
      foreach ($updatedLiabilities as $liability) {
        $formattedLiabilities[] = [
          'id' => $liability->id,
          'country' => $liability->country,
          'state' => $liability->state,
          'city' => $liability->city,
          'code' => $liability->code,
          'fee' => $liability->fee,
          'created_at' => $liability->created_at,
          'updated_at' => $liability->updated_at
        ];
      }
    }

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información financiera actualizada correctamente',
      'supplier' => $supplierUpdated,
      'ica_liabilities' => $formattedLiabilities
    ];
    echo json_encode($res);
    exit;
  }
  #endregion

  #region update certificados, accionistas y representancion legal
  public function savecertificatesAction()
  {
    error_reporting(E_ERROR);
    $this->setLayout('blanco');
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);
    $id = $this->_getSanitizedParam("id");
    $idUser = $this->_getSanitizedParam("id-user");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $content = $supplierModel->getById($id);

    if (empty($content)) {
      $this->responderError("Error al guardar el registro.");
    }

    // Obtener datos sanitizados
    $data = $this->getDataCertificatesInfo();

    // Validaciones para certificados estáticos
    $errors = [];

    // Validar certificado de existencia
    if (empty($data['certificate_issue_name'])) {
      $errors['certificate_issue_name'] = 'El nombre del documento es obligatorio';
    }
    if (empty($data['certificate_issue_date'])) {
      $errors['certificate_issue_date'] = 'La fecha de expedición es obligatoria';
    }
    if (empty($data['company_date'])) {
      $errors['company_date'] = 'La fecha de constitución es obligatoria';
    }
    if (empty($data['registry_country'])) {
      $errors['registry_country'] = 'El país de registro es obligatorio';
    }
    if (empty($data['registry_state'])) {
      $errors['registry_state'] = 'El departamento/estado de registro es obligatorio';
    }
    if (empty($data['registry_city'])) {
      $errors['registry_city'] = 'La ciudad de registro es obligatoria';
    }

    // Validar representante legal
    if (empty($data['representative_name'])) {
      $errors['representative_name'] = 'El nombre del representante es obligatorio';
    }
    if (empty($data['document_type'])) {
      $errors['document_type'] = 'El tipo de documento es obligatorio';
    }
    if (empty($data['document_number'])) {
      $errors['document_number'] = 'El número de documento es obligatorio';
    }
    if (empty($data['document_issue_place'])) {
      $errors['document_issue_place'] = 'El lugar de expedición es obligatorio';
    }
    if (empty($data['document_issue_date'])) {
      $errors['document_issue_date'] = 'La fecha de expedición es obligatoria';
    }
    if (empty($data['representative_birth_country'])) {
      $errors['representative_birth_country'] = 'La nacionalidad es obligatoria';
    }

    // Validar representante legal suplente
    if (empty($data['representative_name2'])) {
      $errors['representative_name2'] = 'El nombre del representante suplente es obligatorio';
    }
    if (empty($data['document_type2'])) {
      $errors['document_type2'] = 'El tipo de documento es obligatorio';
    }
    if (empty($data['document_number2'])) {
      $errors['document_number2'] = 'El número de documento es obligatorio';
    }
    if (empty($data['document_issue_place2'])) {
      $errors['document_issue_place2'] = 'El lugar de expedición es obligatorio';
    }
    if (empty($data['document_issue_date2'])) {
      $errors['document_issue_date2'] = 'La fecha de expedición es obligatoria';
    }
    if (empty($data['representative_birth_country2'])) {
      $errors['representative_birth_country2'] = 'La nacionalidad es obligatoria';
    }

    // Si hay errores, devolverlos
    if (is_countable($errors) && count($errors) > 0) {
      $errorList = '<ul style="text-align:left; margin:0; padding-left:20px;">';
      foreach ($errors as $msg) {
        $errorList .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
      }
      $errorList .= '</ul>';
      echo json_encode([
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'html' => $errorList,
        'text' => 'Error al guardar el registro.',
      ]);
      exit;
    }

    // Procesar archivos
    $uploadDocument = new Core_Model_Upload_Document();
    $uploadedFiles = [];

    // Función para validar archivos
    function validateFile($file, $allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'], $maxSize = 5242880)
    {
      if (empty($file['name'])) return true;

      // Validar tipo de archivo
      if (!in_array($file['type'], $allowedTypes)) {
        return false;
      }

      // Validar tamaño (5MB por defecto)
      if ($file['size'] > $maxSize) {
        return false;
      }

      return true;
    }

    // Procesar certificado de existencia
    if (!empty($_FILES['trade_registry']['name'])) {
      if (!validateFile($_FILES['trade_registry'])) {
        $this->responderError("El archivo del certificado de existencia debe ser PDF, PNG o JPEG y no debe superar los 5MB");
      }
      if ($content->trade_registry) {
        $uploadDocument->delete($content->trade_registry);
      }
      $data['trade_registry'] = $uploadDocument->upload("trade_registry");
      $uploadedFiles['trade_registry'] = $data['trade_registry'];
    } else {
      $data['trade_registry'] = $content->trade_registry;
    }

    // Procesar certificado RUT
    if (!empty($_FILES['rut_certificate']['name'])) {
      if (!validateFile($_FILES['rut_certificate'])) {
        $this->responderError("El archivo del certificado RUT debe ser PDF, PNG o JPEG y no debe superar los 5MB");
      }
      if ($content->rut_certificate) {
        $uploadDocument->delete($content->rut_certificate);
      }
      $data['rut_certificate'] = $uploadDocument->upload("rut_certificate");
      $uploadedFiles['rut_certificate'] = $data['rut_certificate'];
    } else {
      $data['rut_certificate'] = $content->rut_certificate;
    }

    // Procesar documento representante legal
    if (!empty($_FILES['legal_representative_id']['name'])) {
      if (!validateFile($_FILES['legal_representative_id'])) {
        $this->responderError("El documento del representante legal debe ser PDF, PNG o JPEG y no debe superar los 5MB");
      }
      if ($content->legal_representative_id) {
        $uploadDocument->delete($content->legal_representative_id);
      }
      $data['legal_representative_id'] = $uploadDocument->upload("legal_representative_id");
      $uploadedFiles['legal_representative_id'] = $data['legal_representative_id'];
    } else {
      $data['legal_representative_id'] = $content->legal_representative_id;
    }

    // Procesar documento representante legal suplente
    if (!empty($_FILES['legal_representative_id2']['name'])) {
      if (!validateFile($_FILES['legal_representative_id2'])) {
        $this->responderError("El documento del representante legal suplente debe ser PDF, PNG o JPEG y no debe superar los 5MB");
      }
      if ($content->legal_representative_id2) {
        $uploadDocument->delete($content->legal_representative_id2);
      }
      $data['legal_representative_id2'] = $uploadDocument->upload("legal_representative_id2");
      $uploadedFiles['legal_representative_id2'] = $data['legal_representative_id2'];
    } else {
      $data['legal_representative_id2'] = $content->legal_representative_id2;
    }

    // Actualizar datos en la base de datos
    $supplierModel->updateCertificatesAndRepresentative($id, $data);

    // Procesar accionistas
    $shareholdersGroup = $_POST['shareholders'] ?? [];
    $shareholdersModel = new Administracion_Model_DbTable_Suppliershareholders();

    // Eliminar accionistas existentes
    $this->deleteAllShareholdersForSupplier($id);

    if (!empty($shareholdersGroup)) {
      // Reorganizar archivos de accionistas
      $archivosReorganizados = $this->reestructurarArchivosShareholders($_FILES['shareholders']);

      foreach ($shareholdersGroup as $index => $shareholder) {
        $shareholderData = [
          'supplier_id' => $id,
          'name' => $shareholder['name'],
          'id_type' => $shareholder['id_type'],
          'id_number' => $shareholder['id_number'],
          'place_expedition' => $shareholder['place_expedition'],
          'id_date' => $shareholder['id_date'],
          'country' => $shareholder['country'],
          'percentage' => $shareholder['percentage'],
          'is_legal_entity' => $shareholder['is_legal_entity'],
          'counterparty_type' => $shareholder['counterparty_type'],
          'status' => $shareholder['status'],
          'is_pep' => $shareholder['isPEP'],
          'isPEP' => $shareholder['isPEP'],
          'shareholder_document_date' => $shareholder['shareholder_document_date'],
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ];

        // Procesar documento de accionista
        if (
          isset($archivosReorganizados[$index]['shareholder_document']) &&
          !empty($archivosReorganizados[$index]['shareholder_document']['tmp_name'])
        ) {
          if (!validateFile($archivosReorganizados[$index]['shareholder_document'])) {
            $this->responderError("El documento del accionista debe ser PDF, PNG o JPEG y no debe superar los 5MB");
          }
          $_FILES['shareholder_document_temp'] = $archivosReorganizados[$index]['shareholder_document'];
          $shareholderData['shareholder_document'] = $uploadDocument->upload('shareholder_document_temp');
          $uploadedFiles['shareholders'][$index]['shareholder_document'] = $shareholderData['shareholder_document'];
        } else {
          $shareholderData['shareholder_document'] = $shareholder['existing_shareholder_document'] ?? null;
        }

        // Procesar documento PEP si es necesario
        if ($shareholder['isPEP'] === '1') {
          if (
            isset($archivosReorganizados[$index]['pep_document']) &&
            !empty($archivosReorganizados[$index]['pep_document']['tmp_name'])
          ) {
            if (!validateFile($archivosReorganizados[$index]['pep_document'])) {
              $this->responderError("El documento PEP debe ser PDF, PNG o JPEG y no debe superar los 5MB");
            }
            $_FILES['pep_document_temp'] = $archivosReorganizados[$index]['pep_document'];
            $shareholderData['pep_document'] = $uploadDocument->upload('pep_document_temp');
            $uploadedFiles['shareholders'][$index]['pep_document'] = $shareholderData['pep_document'];
          } else {
            $shareholderData['pep_document'] = $shareholder['existing_pep_document'] ?? null;
          }
        }

        $shareholdersModel->insert($shareholderData);
      }
    }

    // Obtener datos actualizados
    $updatedSupplier = $supplierModel->getById($id);
    $updatedShareholders = $shareholdersModel->getList("supplier_id = $id", "");

    // Formatear respuesta
    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información actualizada correctamente',
      'supplier' => $updatedSupplier,
      'uploaded_files' => $uploadedFiles,
      'shareholders' => array_map(function ($shareholder) {
        return [
          'name' => $shareholder->name,
          'id_type' => $shareholder->id_type,
          'id_number' => $shareholder->id_number,
          'place_expedition' => $shareholder->place_expedition,
          'id_date' => $shareholder->id_date,
          'country' => $shareholder->country,
          'percentage' => $shareholder->percentage,
          'is_legal_entity' => $shareholder->is_legal_entity,
          'counterparty_type' => $shareholder->counterparty_type,
          'status' => $shareholder->status,
          'isPEP' => $shareholder->isPEP,
          'shareholder_document' => $shareholder->shareholder_document,
          'shareholder_document_date' => $shareholder->shareholder_document_date,
          'pep_document' => $shareholder->pep_document
        ];
      }, $updatedShareholders)
    ];

    echo json_encode($res);
    exit;
  }

  function reestructurarArchivosShareholders($files)
  {
    $result = [];

    foreach ($files['name'] as $i => $fileGroup) {
      foreach ($fileGroup as $fieldName => $value) {
        $result[$i][$fieldName]['name'] = $files['name'][$i][$fieldName];
        $result[$i][$fieldName]['type'] = $files['type'][$i][$fieldName];
        $result[$i][$fieldName]['tmp_name'] = $files['tmp_name'][$i][$fieldName];
        $result[$i][$fieldName]['error'] = $files['error'][$i][$fieldName];
        $result[$i][$fieldName]['size'] = $files['size'][$i][$fieldName];
      }
    }

    return $result;
  }

  public function deleteAllShareholdersForSupplier($supplierId = null)
  {
    $shareholdersModel = new Administracion_Model_DbTable_Suppliershareholders();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $shareholders = $shareholdersModel->getList("supplier_id = $id", "");

    if ($shareholders) {
      foreach ($shareholders as $shareholder) {
        if ($shareholder->shareholder_document) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($shareholder->shareholder_document);
        }
        if ($shareholder->pep_document) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($shareholder->pep_document);
        }
        $shareholdersModel->deleteRegister($shareholder->id);
      }
    }
  }
  #endregion

  #region getDataGeneralInfo
  public function getDataGeneralInfo()
  {
    $data = array();
    $data['company_name'] = $this->_getSanitizedParam("company_name");
    $data['supplier_soc_type'] = $this->_getSanitizedParam("supplier_soc_type");
    $data['birth_country'] = $this->_getSanitizedParam("birth_country");
    $data['birth_city'] = $this->_getSanitizedParam("birth_city");
    $data['birth_state'] = $this->_getSanitizedParam("birth_state");
    $data['commercial_activity'] = $this->_getSanitizedParamHtml("commercial_activity");
    $data['position'] = $this->_getSanitizedParam("position");
    $data['area'] = $this->_getSanitizedParam("area");
    $data['image'] = "";

    $data['updated_at'] = date("Y-m-d H:i:s");
    return $data;
  }
  #endregion

  #region getDataUserInfo
  private function getDataUserInfo()
  {
    $data = array();
    $data['name'] = $this->_getSanitizedParam("name");
    $data['lastname'] = $this->_getSanitizedParam("lastname");
    $data['phone'] = str_replace(" ","",$this->_getSanitizedParam("phone"));
    $data['area'] = $this->_getSanitizedParam("area");

    $data['password'] = $this->_getSanitizedParam("password");
    $data['password_confirmation'] = $this->_getSanitizedParam("password_confirmation");
    return $data;
  }
  #endregion

  #region getDataCompanyInfo
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
    $data['mobile_phone'] = str_replace(" ","",$this->_getSanitizedParam("mobile_phone"));
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
  #endregion


  #region getDataFinancialInfo
  private function getDataFinancialInfo()
  {
    $data = array();
    $data['income_origin'] = $this->_getSanitizedParam("income_origin");
    $data['currency_type'] = $this->_getSanitizedParam("currency_type");
    $data['equity'] = $this->_getSanitizedParam("equity");
    $data['assets'] = $this->_getSanitizedParam("assets");
    $data['liabilities'] = $this->_getSanitizedParam("liabilities");
    $data['assets_total'] = $this->_getSanitizedParam("assets_total");
    $data['liabilities_total'] = $this->_getSanitizedParam("liabilities_total");
    $data['income'] = $this->_getSanitizedParam("income");
    $data['expenses'] = $this->_getSanitizedParam("expenses");
    $data['income_other'] = $this->_getSanitizedParam("income_other");
    $data['expenses_other'] = $this->_getSanitizedParam("expenses_other");
    $data['income_total'] = $this->_getSanitizedParam("income_total");
    $data['expenses_total'] = $this->_getSanitizedParam("expenses_total");
    $data['utility'] = $this->_getSanitizedParam("utility");
    $data['utility_total'] = $this->_getSanitizedParam("utility_total");
    $data['financial_expenses'] = $this->_getSanitizedParam("financial_expenses");
    $data['income_other_concept'] = $this->_getSanitizedParam("income_other_concept");
    $data['eeff'] = '';
    $data['eeff_year'] = $this->_getSanitizedParam("eeff_year");
    $data['foreign_currency'] = $this->_getSanitizedParam("foreign_currency");
    $data['which_foreign_currency'] = $this->_getSanitizedParam("which_foreign_currency");
    $data['foreign_products'] = $this->_getSanitizedParam("foreign_products");
    $data['which_foreign_products'] = $this->_getSanitizedParam("which_foreign_products");
    $data['nontaxable_agent'] = $this->_getSanitizedParam("nontaxable_agent");
    $data['tax_regime'] = $this->_getSanitizedParam("tax_regime");
    $data['tax_declaration_year'] = $this->_getSanitizedParam("tax_declaration_year");
    $data['updated_at'] = date("Y-m-d H:i:s");

    // Handle tax_liabilities array - now storing codes instead of names
    $tax_liabilities = $_POST['tax_liabilities'];

    if (is_array($tax_liabilities)) {
      $data['tax_liabilities'] = implode(',', $tax_liabilities);
    } else {
      $data['tax_liabilities'] = '';
    }

    return $data;
  }
  #endregion

  #region getUserSupplier
  public function getUserSupplier($id)
  {
    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();
    $userSupplier = $userSupplierModel->getById($id);
    return $userSupplier;
  }
  #endregion

  #region getSupplier
  public function getSupplier($id)
  {
    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier = $supplierModel->getById($id);
    return $supplier;
  }
  #endregion

  #region getTerms
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
  #endregion

  #region getIslegalentity
  public function getIslegalentity()
  {
    $array = array();
    $array['1'] = 'Persona Natural';
    $array['2'] = 'Persona Juridica';
    return $array;
  }
  #endregion

  #region updateVisibilityStatus
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
  #endregion

  #region getProfileComplete
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
  #endregion

  #region getSegments
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
  #endregion

  #region getSedes
  public function getSedes($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierLocationModel = new Administracion_Model_DbTable_Supplierslocations();
    $sedes = $supplierLocationModel->getList("supplier_id = $id", "");
    return $sedes;
  }
  #endregion

  #region getBanks
  public function getBanks($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierBankInfoModel = new Administracion_Model_DbTable_Suppliersbank();
    $banks = $supplierBankInfoModel->getList("supplier_id = $id", "");
    return $banks;
  }
  #endregion

  #region getCertifications
  public function getCertifications($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierCertificationsModel = new Administracion_Model_DbTable_Suppliercertificates();
    $certifications = $supplierCertificationsModel->getList("supplier_id = $id", "");
    return $certifications;
  }
  #endregion

  #region getExperiences
  public function getExperiences($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierExperiencesModel = new Administracion_Model_DbTable_Supplierexperiences();
    $experiences = $supplierExperiencesModel->getList("supplier_id = $id", "");
    return $experiences;
  }

  #region getIcaLiabilities
  public function getIcaLiabilities($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierIcaLiabilitiesModel = new Administracion_Model_DbTable_Suppliericaliabilities();
    $icaLiabilities = $supplierIcaLiabilitiesModel->getList("supplier_id = $id", "");
    return $icaLiabilities;
  }
  #endregion

  #region getSGSST
  public function getSGSST($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierSSTModel = new Administracion_Model_DbTable_Suppliersst();
    $sst = $supplierSSTModel->getList("supplier_id = $id", "");
    return $sst;
  }
  #endregion  


  public function getShareholders($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierShareholdersModel = new Administracion_Model_DbTable_Suppliershareholders();
    $shareholders = $supplierShareholdersModel->getList("supplier_id = $id", "");
    return $shareholders;
  }

  #region ensureHttps
  public function ensureHttps($url)
  {
    $url = trim($url);
    if (empty($url)) return ''; // si está vacío, retorna vacío
    if (!preg_match('/^https?:\/\//i', $url)) {
      return 'https://' . $url;
    }
    return $url;
  }
  #endregion

  #region deleteAllsegmentsForSupplier
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
  #endregion

  #region deleteSedesForSupplier
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
  #endregion

  #region deleteAllBankInfoForSupplier
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
  #endregion

  #region deleteAllCertificationsForSupplier
  public function deleteAllCertificationsForSupplier($supplierId = null, $excludeCertificates = [])
  {
    $supplierCertificationsModel = new Administracion_Model_DbTable_Suppliercertificates();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $certifications = $supplierCertificationsModel->getList("supplier_id = $id", "");
    if ($certifications) {
      foreach ($certifications as $certification) {
        if ($certification->certification_file && !in_array($certification->certification_file, $excludeCertificates)) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($certification->certification_file);
        }
        $supplierCertificationsModel->deleteRegister($certification->id);
      }
    }
  }
  #endregion


  #region validarPeticionCSRFYDatos
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
  #endregion

  #region responderError
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

  function reestructurarArchivosExperiences($files)
  {
    $result = [];

    foreach ($files['name'] as $i => $fileGroup) {
      foreach ($fileGroup as $fieldName => $value) {
        $result[$i][$fieldName]['name'] = $files['name'][$i][$fieldName];
        $result[$i][$fieldName]['type'] = $files['type'][$i][$fieldName];
        $result[$i][$fieldName]['tmp_name'] = $files['tmp_name'][$i][$fieldName];
        $result[$i][$fieldName]['error'] = $files['error'][$i][$fieldName];
        $result[$i][$fieldName]['size'] = $files['size'][$i][$fieldName];
      }
    }

    return $result;
  }

  public function deleteAllExperiencesForSupplier($supplierId = null, $excludeDocuments = [])
  {
    $supplierExperiencesModel = new Administracion_Model_DbTable_Supplierexperiences();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $experiences = $supplierExperiencesModel->getList("supplier_id = $id", "");
    if ($experiences) {
      foreach ($experiences as $experience) {
        if ($experience->document_file && !in_array($experience->document_file, $excludeDocuments)) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($experience->document_file);
        }
        $supplierExperiencesModel->deleteRegister($experience->id);
      }
    }
  }
  #endregion

  #region SaveSGSST
  public function savesgsstAction()
  {
    $this->setLayout('blanco');
    $this->validarPeticionCSRFYDatos(["id", "id-user"]);

    $id = $this->_getSanitizedParam("id");
    $sstGroup = $_POST['ssts'] ?? [];

    if (empty($sstGroup)) {
      $this->deleteAllSSTForSupplier($id);
      $res = [
        'success' => true,
        'title' => 'Listo',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Información SG-SST actualizada correctamente',
      ];
      echo json_encode($res);
      exit;
    }

    $documentosAConservar = array_filter(array_map(function ($sst) {
      return [
        'arl_accident_certificate' => $sst['existing_arl_accident_certificate'] ?? null,
        'arl_affiliation_certificate' => $sst['existing_arl_affiliation_certificate'] ?? null,
        'evaluation_result_certificate' => $sst['existing_evaluation_result_certificate'] ?? null
      ];
    }, $_POST['ssts'] ?? []));

    $this->deleteAllSSTForSupplier($id, $documentosAConservar);

    // Reorganizar archivos
    $archivosReorganizados = $this->reestructurarArchivosSST($_FILES['ssts']);

    $uploadDocument = new Core_Model_Upload_Document();

    foreach ($sstGroup as $index => $sst) {
      $sstData = [
        'supplier_id' => $id,
        'operation_year' => $sst['operation_year'],
        'fatalities' => $sst['fatalities'],
        'disabling_accidents' => $sst['disabling_accidents'],
        'total_incidents' => $sst['total_incidents'],
        'disability_days' => $sst['disability_days'],
        'workers_number' => $sst['workers_number'],
        'manhours' => $sst['manhours'],
        'risk_level' => $sst['risk_level'],
        'rating_percentage' => $sst['rating_percentage'],
        'arl_accident_certificate_date' => $sst['arl_accident_certificate_date'],
        'arl_affiliation_certificate_date' => $sst['arl_affiliation_certificate_date'],
        'evaluation_result_certificate_date' => $sst['evaluation_result_certificate_date'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];

      // Manejar archivos
      if (
        isset($archivosReorganizados[$index]['arl_accident_certificate']) &&
        !empty($archivosReorganizados[$index]['arl_accident_certificate']['tmp_name'])
      ) {
        $_FILES['arl_accident_certificate_temp'] = $archivosReorganizados[$index]['arl_accident_certificate'];
        $sstData['arl_accident_certificate'] = $uploadDocument->upload('arl_accident_certificate_temp');
      } else {
        $sstData['arl_accident_certificate'] = $sst['existing_arl_accident_certificate'] ?? null;
      }

      if (
        isset($archivosReorganizados[$index]['arl_affiliation_certificate']) &&
        !empty($archivosReorganizados[$index]['arl_affiliation_certificate']['tmp_name'])
      ) {
        $_FILES['arl_affiliation_certificate_temp'] = $archivosReorganizados[$index]['arl_affiliation_certificate'];
        $sstData['arl_affiliation_certificate'] = $uploadDocument->upload('arl_affiliation_certificate_temp');
      } else {
        $sstData['arl_affiliation_certificate'] = $sst['existing_arl_affiliation_certificate'] ?? null;
      }

      if (
        isset($archivosReorganizados[$index]['evaluation_result_certificate']) &&
        !empty($archivosReorganizados[$index]['evaluation_result_certificate']['tmp_name'])
      ) {
        $_FILES['evaluation_result_certificate_temp'] = $archivosReorganizados[$index]['evaluation_result_certificate'];
        $sstData['evaluation_result_certificate'] = $uploadDocument->upload('evaluation_result_certificate_temp');
      } else {
        $sstData['evaluation_result_certificate'] = $sst['existing_evaluation_result_certificate'] ?? null;
      }

      $supplierSSTModel = new Administracion_Model_DbTable_Suppliersst();
      $supplierSSTModel->insert($sstData);
    }

    // Obtener los registros actualizados
    $updatedSSTs = $supplierSSTModel->getList("supplier_id = $id", "");

    // Formatear datos para el frontend
    $sstFormatted = array_map(function ($sst) {
      return [
        'operation_year' => $sst->operation_year,
        'fatalities' => $sst->fatalities,
        'disabling_accidents' => $sst->disabling_accidents,
        'total_incidents' => $sst->total_incidents,
        'disability_days' => $sst->disability_days,
        'workers_number' => $sst->workers_number,
        'manhours' => $sst->manhours,
        'risk_level' => $sst->risk_level,
        'rating_percentage' => $sst->rating_percentage,
        'arl_accident_certificate' => $sst->arl_accident_certificate,
        'arl_accident_certificate_date' => $sst->arl_accident_certificate_date,
        'arl_affiliation_certificate' => $sst->arl_affiliation_certificate,
        'arl_affiliation_certificate_date' => $sst->arl_affiliation_certificate_date,
        'evaluation_result_certificate' => $sst->evaluation_result_certificate,
        'evaluation_result_certificate_date' => $sst->evaluation_result_certificate_date
      ];
    }, $updatedSSTs);

    $res = [
      'success' => true,
      'title' => 'Listo',
      'status' => 'success',
      'icon' => 'success',
      'text' => 'Información SG-SST actualizada correctamente',
      'ssts' => $sstFormatted
    ];
    echo json_encode($res);
    exit;
  }

  function reestructurarArchivosSST($files)
  {
    $result = [];

    foreach ($files['name'] as $i => $fileGroup) {
      foreach ($fileGroup as $fieldName => $value) {
        $result[$i][$fieldName]['name'] = $files['name'][$i][$fieldName];
        $result[$i][$fieldName]['type'] = $files['type'][$i][$fieldName];
        $result[$i][$fieldName]['tmp_name'] = $files['tmp_name'][$i][$fieldName];
        $result[$i][$fieldName]['error'] = $files['error'][$i][$fieldName];
        $result[$i][$fieldName]['size'] = $files['size'][$i][$fieldName];
      }
    }

    return $result;
  }

  public function deleteAllSSTForSupplier($supplierId = null, $excludeDocuments = [])
  {
    $supplierSSTModel = new Administracion_Model_DbTable_Suppliersst();
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $ssts = $supplierSSTModel->getList("supplier_id = $id", "");

    if ($ssts) {
      foreach ($ssts as $sst) {
        // Verificar y eliminar archivos si no están en la lista de exclusión
        if (
          $sst->arl_accident_certificate &&
          !in_array($sst->arl_accident_certificate, array_column($excludeDocuments, 'arl_accident_certificate'))
        ) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($sst->arl_accident_certificate);
        }
        if (
          $sst->arl_affiliation_certificate &&
          !in_array($sst->arl_affiliation_certificate, array_column($excludeDocuments, 'arl_affiliation_certificate'))
        ) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($sst->arl_affiliation_certificate);
        }
        if (
          $sst->evaluation_result_certificate &&
          !in_array($sst->evaluation_result_certificate, array_column($excludeDocuments, 'evaluation_result_certificate'))
        ) {
          $uploadDocument = new Core_Model_Upload_Document();
          $uploadDocument->delete($sst->evaluation_result_certificate);
        }
        $supplierSSTModel->deleteRegister($sst->id);
      }
    }
  }
  #endregion

  #region getDataCertificatesInfo
  private function getDataCertificatesInfo()
  {
    $data = array();

    // Certificado de existencia
    $data['certificate_issue_name'] = $this->_getSanitizedParam("certificate_issue_name");
    $data['certificate_issue_date'] = $this->_getSanitizedParam("certificate_issue_date");
    $data['company_date'] = $this->_getSanitizedParam("company_date");
    $data['company_validity'] = $this->_getSanitizedParam("company_validity");
    $data['company_validity2'] = isset($_POST['company_validity2']) ? 1 : 0;
    $data['registry_country'] = $this->_getSanitizedParam("registry_country");
    $data['registry_state'] = $this->_getSanitizedParam("registry_state");
    $data['registry_city'] = $this->_getSanitizedParam("registry_city");

    // Certificado RUT
    $data['rut_certificate_name'] = $this->_getSanitizedParam("rut_certificate_name");
    $data['rut_certificate_date_expedition'] = $this->_getSanitizedParam("rut_certificate_date_expedition");
    $data['rut_certificate_country'] = $this->_getSanitizedParam("rut_certificate_country");
    $data['rut_certificate_state'] = $this->_getSanitizedParam("rut_certificate_state");
    $data['rut_certificate_city'] = $this->_getSanitizedParam("rut_certificate_city");

    // Representante legal
    $data['representative_name'] = $this->_getSanitizedParam("representative_name");
    $data['document_type'] = $this->_getSanitizedParam("document_type");
    $data['document_number'] = $this->_getSanitizedParam("document_number");
    $data['document_issue_place'] = $this->_getSanitizedParam("document_issue_place");
    $data['document_issue_date'] = $this->_getSanitizedParam("document_issue_date");
    $data['representative_birth_country'] = $this->_getSanitizedParam("representative_birth_country");

    // Representante legal suplente
    $data['representative_name2'] = $this->_getSanitizedParam("representative_name2");
    $data['document_type2'] = $this->_getSanitizedParam("document_type2");
    $data['document_number2'] = $this->_getSanitizedParam("document_number2");
    $data['document_issue_place2'] = $this->_getSanitizedParam("document_issue_place2");
    $data['document_issue_date2'] = $this->_getSanitizedParam("document_issue_date2");
    $data['representative_birth_country2'] = $this->_getSanitizedParam("representative_birth_country2");

    $data['updated_at'] = date("Y-m-d H:i:s");
    return $data;
  }
  #endregion
  public function myActivities()
  {
    $interestModel = new Administracion_Model_DbTable_Supplierclassification();
    $supplier_id =  Session::getInstance()->get("supplier")->id;
    $this->_view->selectedSectors = $selectedSectors = $interestModel->getList("supplier_id='$supplier_id' AND level='1' ");
    $this->_view->selectedSegment = $selectedSegment =  $interestModel->getList("supplier_id='$supplier_id' AND level='2' ");
    $this->_view->selectedFamily = $selectedFamily = $interestModel->getList("supplier_id='$supplier_id' AND level='3' ");
    $this->_view->selectedClass = $selectedClass = $interestModel->getList("supplier_id='$supplier_id' AND level='4' ");
    $this->_view->selectedProduct = $selectedProduct = $interestModel->getList("supplier_id='$supplier_id' AND level='5' ");

    // Mantener las instancias de los modelos para los filtros
    $sectorsModel = new Administracion_Model_DbTable_Commercialsectors();
    $segmentsModel = new Administracion_Model_DbTable_Commercialsegments();
    $familiesModel = new Administracion_Model_DbTable_Commercialfamilies();
    $classesModel = new Administracion_Model_DbTable_Commercialclasses();
    $productModel = new Administracion_Model_DbTable_Commercialproducts();

    $this->_view->sectors = $sectors = $sectorsModel->getList(""," name ASC ");

    //segmentos filtrados
    $f1 = " (1=0 ";
    foreach ($selectedSectors as $value) {
      if ($value->code != "") {
        $f1 .= " OR sector_id='" . $value->code . "' ";
      }
    }
    $f1 .= " ) ";
    $this->_view->segments_filtro = $segmentsModel->getList("$f1", "");

    //familias filtrados
    $f1 = " (1=0 ";
    foreach ($selectedSegment as $value) {
      if ($value->code != "") {
        $f1 .= " OR segment_code='" . $value->code . "' ";
      }
    }
    $f1 .= " ) ";
    $this->_view->family_filtro = $familiesModel->getList("$f1", "");

    //clases filtrados
    $f1 = " (1=0 ";
    foreach ($selectedFamily as $value) {
      if ($value->code != "") {
        $f1 .= " OR family_code='" . $value->code . "' ";
      }
    }
    $f1 .= " ) ";
    $this->_view->class_filtro = $classesModel->getList("$f1", "");

    //productos filtrados
    $f1 = " (1=0 ";
    foreach ($selectedClass as $value) {
      if ($value->code != "") {
        $f1 .= " OR class_code='" . $value->code . "' ";
      }
    }
    $f1 .= " ) ";
    $this->_view->product_filtro = $productModel->getList("$f1", "");
  }

  public function addinterestAction()
  {
    header('Content-Type: application/json; charset=utf-8');
    $this->setLayout('blanco');
    $valores = $this->_getSanitizedParam("valores");
    $nivel = $this->_getSanitizedParam("nivel");
    $supplier_id = $this->_getSanitizedParam("supplier_id");

    $interestModel = new Administracion_Model_DbTable_Supplierclassification();

    $array_valores = explode("|", $valores);
    foreach ($array_valores as $value) {
      if ($value != "") {
        $aux2 = explode("_", $value);
        $data['supplier_id'] = $supplier_id;
        $data['code'] = $aux2[0];
        $data['name'] = $aux2[1];
        $data['level'] = $nivel;
        $interestModel->insert($data);
      }
    }


    $seleccionados = '';
    $selectedItems = $interestModel->getList("supplier_id='$supplier_id' AND level='$nivel' ");
    foreach($selectedItems as $interest){
      $seleccionados.='<span class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest'.$interest->id.'">'.$interest->name.' <i class="fa fa-times" onclick="removeInterest('.$interest->id.',\''.md5($interest->code).'\')"></i></span>';
    }

    $filtrados='';
    //FILTRAR SEGMENTOS SI SE AGREGA SECTOR
    if($nivel==1){
      $segmentsModel= new Administracion_Model_DbTable_Commercialsegments();
      //segmentos filtrados
      $f1=" (1=0 ";
      foreach($selectedItems as $value){
        if($value->code!=""){
          $f1.=" OR sector_id='".$value->code."' ";
        }
      }
      $f1.=" ) ";
      $segments_filtro = $segmentsModel->getList("$f1","");
      foreach($segments_filtro as $key => $segment){
        $seleccionado='';
        $existe = $interestModel->getList(" code='".$segment->segment_code."' AND supplier_id='$supplier_id' ","");
        if(count((array)$existe)>0){
          $seleccionado='checked';
        }
        $filtrados.='<div class="col-lg-6 mb-4"><label><input class="form-check-input check_interest'.md5($segment->segment_code).'" type="checkbox" id="segment'.$key.'" value="'.$segment->segment_code.'_'.$segment->segment_name.'" '.$seleccionado.' > '.$segment->segment_name.'</label></div>';
      }
    }

    //FILTRAR FAMILIAS SI SE AGREGA SEGMENTO
    if($nivel==2){
      $familyModel= new Administracion_Model_DbTable_Commercialfamilies();
      //familias filtrados
      $f1=" (1=0 ";
      foreach($selectedItems as $value){
        if($value->code!=""){
          $f1.=" OR segment_code='".$value->code."' ";
        }
      }
      $f1.=" ) ";
      $family_filtro = $familyModel->getList("$f1","");
      foreach($family_filtro as $key => $family){
        $seleccionado='';
        $existe = $interestModel->getList(" code='".$family->family_code."' AND supplier_id='$supplier_id' ","");
        if(count((array)$existe)>0){
          $seleccionado='checked';
        }
        $filtrados.='<div class="col-lg-6 mb-4"><label><input class="form-check-input check_interest'.md5($family->family_code).'" type="checkbox" id="family'.$key.'" value="'.$family->family_code.'_'.$family->family_name.'" '.$seleccionado.' > '.$family->family_name.'</label></div>';
      }
    }

    //FILTRAR CLASES SI SE AGREGA FAMILIA
    if($nivel==3){
      $classModel= new Administracion_Model_DbTable_Commercialclasses();
      //segmentos filtrados
      $f1=" (1=0 ";
      foreach($selectedItems as $value){
        if($value->code!=""){
          $f1.=" OR family_code='".$value->code."' ";
        }
      }
      $f1.=" ) ";
      $clase_filtro = $classModel->getList("$f1","");
      foreach($clase_filtro as $key => $class1){
        $seleccionado='';
        $existe = $interestModel->getList(" code='".$class1->class_code."' AND supplier_id='$supplier_id' ","");
        if(count((array)$existe)>0){
          $seleccionado='checked';
        }        
        $filtrados.='<div class="col-lg-6 mb-4"><label><input class="form-check-input check_interest'.md5($class1->class_code).'" type="checkbox" id="class'.$key.'" value="'.$class1->class_code.'_'.$class1->class_name.'" '.$seleccionado.' > '.$class1->class_name.'</label></div>';
      }
    }

    //FILTRAR PRODUCTOS SI SE AGREGA CLASE
    if($nivel==4){
      $productModel= new Administracion_Model_DbTable_Commercialproducts();
      //segmentos filtrados
      $f1=" (1=0 ";
      foreach($selectedItems as $value){
        if($value->code!=""){
          $f1.=" OR class_code='".$value->code."' ";
        }
      }
      $f1.=" ) ";
      $productos_filtro = $productModel->getList("$f1","");
      foreach($productos_filtro as $key => $product){
        $seleccionado='';
        $existe = $interestModel->getList(" code='".$product->product_code."' AND supplier_id='$supplier_id' ","");
        if(count((array)$existe)>0){
          $seleccionado='checked';
        }        
        $filtrados.='<div class="col-lg-6 mb-4"><label><input class="form-check-input check_interest'.md5($product->product_code).'" type="checkbox" id="product'.$key.'" value="'.$product->product_code.'_'.$product->product_name.'" '.$seleccionado.' > '.$product->product_name.'</label></div>';
      }
    }            

    $res['seleccionados']=$seleccionados;
    $res['filtrados']=$filtrados;
    echo json_encode($res);

  }

  public function removeinterestAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");

    $interestModel = new Administracion_Model_DbTable_Supplierclassification();
    if ($id > 0) {
      $interestModel->deleteRegister($id);
    }
  }


  public function additemAction()
  {
    // error_reporting(E_ALL);
    $this->setLayout('blanco');
    $buscador = $this->_getSanitizedParam("buscador");
    $aux = explode("_", $buscador);
    $nivel = $aux[0];
    $codigo = $aux[1];

    $interestModel = new Administracion_Model_DbTable_Supplierclassification();
    $sectorsModel = new Administracion_Model_DbTable_Commercialsectors();
    $segmentsModel = new Administracion_Model_DbTable_Commercialsegments();
    $familyModel = new Administracion_Model_DbTable_Commercialfamilies();
    $classModel = new Administracion_Model_DbTable_Commercialclasses();
    $productModel = new Administracion_Model_DbTable_Commercialproducts();

    if ($nivel == 1) {
      $sector = $sectorsModel->getById($codigo);
      $data['supplier_id'] = Session::getInstance()->get("supplier")->id;
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);
    }
    if ($nivel == 2) {
      $segmentos = $segmentsModel->getList("segment_code='$codigo'", "");
      $segmento = $segmentos[0];
      $data['supplier_id'] = Session::getInstance()->get("supplier")->id;
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);
    }
    if ($nivel == 3) {
      $familias = $familyModel->getList("family_code='$codigo'", "");
      $familia = $familias[0];
      $data['supplier_id'] = Session::getInstance()->get("supplier")->id;
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $segment_code = $familia->segment_code;
      $segmentos = $segmentsModel->getList("segment_code='$segment_code'", "");
      $segmento = $segmentos[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);
    }

    if ($nivel == 4) {
      $clases = $classModel->getList("class_code='$codigo'", "");
      $clase = $clases[0];
      $data['supplier_id'] = Session::getInstance()->get("supplier")->id;
      $data['code'] = $clase->class_code;
      $data['name'] = $clase->class_name;
      $data['level'] = 4;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $family_code = $clase->family_code;
      $familias = $familyModel->getList("family_code='$family_code'", "");
      $familia = $familias[0];
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $segment_code = $familia->segment_code;
      $segmentos = $segmentsModel->getList("segment_code='$segment_code'", "");
      $segmento = $segmentos[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);
    }

    if ($nivel == 5) {
      $productos = $productModel->getList("product_code='$codigo'", "");
      $producto = $productos[0];
      $data['supplier_id'] = Session::getInstance()->get("supplier")->id;
      $data['code'] = $producto->product_code;
      $data['name'] = $producto->product_name;
      $data['level'] = 5;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $class_code = $producto->class_code;
      $clases = $classModel->getList("class_code='$class_code'", "");
      $clase = $clases[0];
      $data['code'] = $clase->class_code;
      $data['name'] = $clase->class_name;
      $data['level'] = 4;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $family_code = $clase->family_code;
      $familias = $familyModel->getList("family_code='$family_code'", "");
      $familia = $familias[0];
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $segment_code = $familia->segment_code;
      $segmentos = $segmentsModel->getList("segment_code='$segment_code'", "");
      $segmento = $segmentos[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $data['created_at'] = date("Y-m-d H:i:s");
      $data['updated_at'] = date("Y-m-d H:i:s");
      $interestModel->insert($data);
    }

    header("Location:/supplier/profile/?tab=11");
  }

  public function searchItemsAction()
  {
    $this->setLayout('blanco');
    $search = $this->_getSanitizedParam("search");

    if (empty($search)) {
      echo json_encode(['results' => []]);
      exit;
    }

    $sectorsModel = new Administracion_Model_DbTable_Commercialsectors();
    /*     $segmentsModel = new Administracion_Model_DbTable_Commercialsegments();
    $familiesModel = new Administracion_Model_DbTable_Commercialfamilies();
    $classesModel = new Administracion_Model_DbTable_Commercialclasses();
    $productModel = new Administracion_Model_DbTable_Commercialproducts(); */

    $search = "%" . $search . "%";

    $sql = "SELECT '1' as level, id as code, name COLLATE utf8mb4_unicode_ci as item_name FROM commercial_sectors 
            WHERE name COLLATE utf8mb4_unicode_ci LIKE '" . $search . "' 
            UNION ALL
            SELECT '2' as level, segment_code as code, segment_name COLLATE utf8mb4_unicode_ci as item_name 
            FROM commercial_segments 
            WHERE segment_name COLLATE utf8mb4_unicode_ci LIKE '" . $search . "'
            UNION ALL
            SELECT '3' as level, family_code as code, family_name COLLATE utf8mb4_unicode_ci as item_name 
            FROM commercial_families 
            WHERE family_name COLLATE utf8mb4_unicode_ci LIKE '" . $search . "'
            UNION ALL
            SELECT '4' as level, class_code as code, class_name COLLATE utf8mb4_unicode_ci as item_name 
            FROM commercial_classes 
            WHERE class_name COLLATE utf8mb4_unicode_ci LIKE '" . $search . "'
            UNION ALL
            SELECT '5' as level, product_code as code, product_name COLLATE utf8mb4_unicode_ci as item_name 
            FROM commercial_products 
            WHERE product_name COLLATE utf8mb4_unicode_ci LIKE '" . $search . "'
            ORDER BY level, item_name ASC";


    $result = $sectorsModel->query($sql);

    $items = [];
    foreach ($result as $row) {
      $items[] = [
        'id' => $row->level . "_" . $row->code,
        'text' => $row->item_name
      ];
    }

    echo json_encode(['results' => $items]);
    exit;
  }

  public function searchAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");

    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");

    $q = $this->_getSanitizedParam("q");
    $q = strtolower($q);

    $paises_json = $this->getCountry();

    $paises = array();
    $regiones = array();
    $ciudades = array();

    foreach ($paises_json as $value) {

      if (strpos(strtolower($value['name']), $q) !== false) {
        $paises[] = $pais = $value['name'];
      }
      if (strpos(strtolower($value['subregion']), $q) !== false) {
        $regiones[] = $region = $value['subregion'];
      }

      $array_estados = $value['states'];

      foreach ($array_estados as $estado) {
        if (strpos(strtolower($estado['name']), $q) !== false) {
          $estados[] = $estado['name'];
        }

        $array_ciudades = $estado['cities'];
        foreach ($array_ciudades as $ciudad) {
          if (strpos(strtolower($ciudad['name']), $q) !== false) {
            $ciudades[] = $ciudad['name'];
          }
        }
      }

      //$pais_region[$region][]=$value;

    }

    $regiones = array_unique($regiones);

    $items = array();
    $i = 0;
    foreach ($regiones as $value) {
      $items[] = array("id" => $value."_1", "text" => $value);
    }
    foreach ($paises as $value) {
      $items[] = array("id" => $value."_2", "text" => $value);
    }
    foreach ($estados as $value) {
      $items[] = array("id" => $value."_3", "text" => $value);
    }
    foreach ($ciudades as $value) {
      $items[] = array("id" => $value."_4", "text" => $value);
    }


    //$items = array_unique($items);
    //asort($items);  

    $res['results'] = $items;
    echo json_encode($res);
  }


  public function get_geolocationsAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");


    $supplier_id = $_SESSION['supplier']->id;
    $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
    $geolocations = $geolocationModel->getList(" supplier_id='$supplier_id' ", " level ASC, name ASC ");
    $div = '';
    foreach($geolocations as $geolocation){
      $div.='<span class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 geolocation'.$geolocation->id.'">'.$geolocation->name.' <i class="fa fa-times" onclick="remove_geolocation('.$geolocation->id.')"></i>
        </span>';
    }


    $res['geolocations'] = $div;
    echo json_encode($res);
  }

  public function get_paisesAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");
    $paises_json = $this->getCountry();
    $region = $this->_getSanitizedParam("region");

    foreach ($paises_json as $value) {
      $subregion = $value['subregion'];
      if ($subregion == $region) {
        $paises[] = $pais = $value['name'];
      }
    }

    $div_paises = '';
    foreach ($paises as $pais) {
      $pais_md5 = md5($pais);
      $div_paises .= '<li class="mb-1 paises"><a class="dropdown-item" onclick="get_estados(\'' . $pais_md5 . '\')">' . $pais . ' <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\'' . $pais . '\',2);" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>

        <div id="div_estados'.$pais_md5.'" class="estados" style="margin-left: 20px;"></div>
      ';
    }

    $res['paises'] = $div_paises;
    echo json_encode($res);
  }

  public function get_estadosAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");
    $paises_json = $this->getCountry();
    $pais_md52 = $this->_getSanitizedParam("pais");

    foreach ($paises_json as $value) {
      $pais = $value['name'];
      $pais_md5 = md5($pais);
      if ($pais_md5 == $pais_md52) {
        $array_estados = $value['states'];
        foreach ($array_estados as $estado) {
          $estados[] = $estado['name'];
        }
        break;
      }
    }

    $div_estados = '';
    foreach ($estados as $estado) {
      $estado_md5 = md5($estado);
      $div_estados .= '<li class="mb-1 estados"><a class="dropdown-item" onclick="get_ciudades(\'' . $estado_md5 . '\',\'' . $pais_md52 . '\')">' . $estado . ' <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\'' . $estado . '\',3);" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>

        <div id="div_ciudades'.$estado_md5.'" class="ciudades" style="margin-left: 30px;"></div>
      ';
    }

    $res['estados'] = $div_estados;
    echo json_encode($res);
  }


  public function get_ciudadesAction()
  {
    //error_reporting(E_ERROR);
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");
    $paises_json = $this->getCountry();
    $pais_md52 = $this->_getSanitizedParam("pais");
    $estado_md52 = $this->_getSanitizedParam("estado");

    foreach ($paises_json as $value) {
      $pais = $value['name'];
      $pais_md5 = md5($pais);
      if ($pais_md5 == $pais_md52) {
        $array_estados = $value['states'];
        foreach ($array_estados as $estado) {
          $estado1 = $estado['name'];
          $estado_md5 = md5($estado1);
          if ($estado_md5 == $estado_md52) {
            $array_ciudades = $estado['cities'];
            foreach ($array_ciudades as $ciudad) {
              $ciudades[] = $ciudad['name'];
            }
            break;
          }
        }
        break;
      }
    }

    $div_ciudades = '';
    foreach ($ciudades as $ciudad) {
      $div_ciudades .= '<li class="mb-1 estados"><a class="dropdown-item" >' . $ciudad . '</a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\'' . $ciudad . '\',4);" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>';
    }

    $res['ciudades'] = $div_ciudades;
    echo json_encode($res);
  }

  public function worldwideAction()
  {
    $this->setLayout('blanco');
    $valor = $this->_getSanitizedParam("valor");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier_id = $_SESSION['supplier']->id;

    if ($valor != "" and $supplier_id != "") {
      $supplierModel->editField($supplier_id, "worldwide", $valor);
    }
  }

  public function agregar_ubicacionAction()
  {
    $this->setLayout('blanco');
    $valor = $this->_getSanitizedParam("valor");
    $nivel = $this->_getSanitizedParam("nivel");

    if($nivel==""){
      $aux = explode("_",$valor);
      $valor = $aux[0];
      $nivel = $aux[1];
    }

    // $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier_id = $_SESSION['supplier']->id;
    // $supplier_id = 1;

    if ($valor != "" and $supplier_id != "") {
      $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
      $data['supplier_id'] = $supplier_id;
      $data['name'] = $valor;
      $data['level'] = $nivel;
      $geolocationModel->insert($data);
    }
  }

  public function borrar_ubicacionAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $supplier_id = $_SESSION['supplier']->id;
    if ($id != "" and $supplier_id != "") {
      $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
      $geolocationModel->deleteRegister($id);
    }
  }

  public function completitud1Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);


    $contador=0;
    $llenos=0;
    
    $contador++;
    if($supplier->image!=""){ $llenos++; }
    $contador++;
    if($userSupplier->name!=""){ $llenos++; }
    $contador++;
    if($userSupplier->lastname!=""){ $llenos++; }
    $contador++;
    if($userSupplier->email!=""){ $llenos++; }
    $contador++;
    if($userSupplier->phone!=""){ $llenos++; }
    $contador++;
    if($supplier->position!=""){ $llenos++; }
    $contador++;
    if($userSupplier->area!=""){ $llenos++; }
    $contador++;
    if($supplier->company_name!=""){ $llenos++; }
    $contador++;
    if($supplier->supplier_soc_type!=""){ $llenos++; } 
    $contador++;
    if($supplier->birth_country!=""){ $llenos++; } 
    $contador++;
    if($supplier->birth_state!=""){ $llenos++; } 
    $contador++;
    if($supplier->birth_city!=""){ $llenos++; }                        
    $contador++;
    if($supplier->commercial_activity!=""){ $llenos++; }           


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }

  public function completitud2Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);


    $contador=0;
    $llenos=0;
    
    $contador++;
    if($supplier->is_legal_entity!=""){ $llenos++; }
    $contador++;
    if($supplier->counterparty_type!=""){ $llenos++; }
    $contador++;
    if($supplier->company_type!=""){ $llenos++; }
    $contador++;
    if($supplier->activity_type!=""){ $llenos++; }
    $contador++;
    if($supplier->main_address!=""){ $llenos++; }
    $contador++;
    if($supplier->country!=""){ $llenos++; }
    $contador++;
    if($supplier->state!=""){ $llenos++; }
    $contador++;
    if($supplier->city!=""){ $llenos++; }
    $contador++;
    if($supplier->mobile_phone!=""){ $llenos++; } 
    $contador++;
    if($supplier->primary_email!=""){ $llenos++; } 
    $contador++;
    if($supplier->company_size!=""){ $llenos++; } 
    $contador++;
    if($supplier->company_size_certificate!=""){ $llenos++; }                        
    $contador++;
    if($supplier->number_of_employees!=""){ $llenos++; }  
    $contador++;
    if($supplier->website!=""){ $llenos++; }  
    $contador++;
    if($supplier->brochure!=""){ $llenos++; }  
    $contador++;
    if($supplier->facebook!=""){ $llenos++; }   
    $contador++;
    if($supplier->instagram!=""){ $llenos++; }  
    $contador++;
    if($supplier->twitter!=""){ $llenos++; }  
    $contador++;
    if($supplier->linkedin!=""){ $llenos++; }  
    $contador++;
    if($supplier->keywords!=""){ $llenos++; }                                        
        


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }  

  public function completitud3Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
   
    $id = $supplierSession->id;

    $industriesModel = new Administracion_Model_DbTable_Supplierindustries();
    $segmentsModel = new Administracion_Model_DbTable_Suppliersegments();
    if($id) {
      $industries = $industriesModel->getList(" supplier_id = $id ", "");
      foreach ($industries as $industry) {
        $industry->segments = $segmentsModel->getList("industry_id = $industry->id AND supplier_id = $id ", "");
      }
    } else {
      $industries = [];
    }

    $porcentaje=0;
    if(count($industries)>0 and count($industries[0]->segments)>0){
      $porcentaje=100;
    }

    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }    


  public function completitud4Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);


    $contador=0;
    $llenos=0;
    
    $contador++;
    if($supplier->certificate_issue_name!=""){ $llenos++; }
    $contador++;
    if($supplier->trade_registry!=""){ $llenos++; }
    $contador++;
    if($supplier->certificate_issue_date!=""){ $llenos++; }
    $contador++;
    if($supplier->company_date!=""){ $llenos++; }
    $contador++;
    if($supplier->company_validity!=""){ $llenos++; }
    $contador++;
    if($supplier->registry_country!=""){ $llenos++; }
    $contador++;
    if($supplier->registry_state!=""){ $llenos++; }
    $contador++;
    if($supplier->registry_city!=""){ $llenos++; }
    $contador++;
    if($supplier->rut_certificate_name!=""){ $llenos++; } 
    $contador++;
    if($supplier->rut_certificate!=""){ $llenos++; } 
    $contador++;
    if($supplier->rut_certificate_date_expedition!=""){ $llenos++; } 
    $contador++;
    if($supplier->rut_certificate_country!=""){ $llenos++; }                        
    $contador++;
    if($supplier->rut_certificate_state!=""){ $llenos++; }  
    $contador++;
    if($supplier->rut_certificate_city!=""){ $llenos++; }  
    $contador++;
    if($supplier->representative_name!=""){ $llenos++; }  
    $contador++;
    if($supplier->document_type!=""){ $llenos++; }   
    $contador++;
    if($supplier->document_number!=""){ $llenos++; }  
    $contador++;
    if($supplier->document_issue_place!=""){ $llenos++; }  
    $contador++;
    if($supplier->document_issue_date!=""){ $llenos++; }  
    $contador++;
    if($supplier->representative_birth_country!=""){ $llenos++; }
    $contador++;
    if($supplier->legal_representative_id!=""){ $llenos++; }
    $contador++;
    if($supplier->representative_name2!=""){ $llenos++; }
    $contador++;
    if($supplier->document_type2!=""){ $llenos++; }
    $contador++;
    if($supplier->document_number2!=""){ $llenos++; }
    $contador++;
    if($supplier->document_issue_place2!=""){ $llenos++; }
    $contador++;
    if($supplier->document_issue_date2!=""){ $llenos++; }
    $contador++;
    if($supplier->representative_birth_country2!=""){ $llenos++; }
    $contador++;
    if($supplier->legal_representative_id2!=""){ $llenos++; }

    $contador++;
    $list_shareholders = $this->getShareholders();
    if(count($list_shareholders)>0){
      $llenos++;
    }                                                                                
        


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }  


  public function completitud5Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $supplier_id = $supplier->id;
    $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
    $geolocations = $geolocationModel->getList(" supplier_id='$supplier_id' ", " name ASC ");

    $contador=0;
    $llenos=0;
    

    $contador++;
    $sedes = $this->getSedes();
    if(count($sedes)>0){
      $llenos++;
    }                                                                                

    $contador++;
    if($supplier->worldwide==1 or count($geolocations)>0){ $llenos++; }

    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }    

  public function completitud6Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $contador=0;
    $llenos=0;
    
    $list_experiences = $this->getExperiences();
    foreach($list_experiences as $value){
      $contador++;
      if($value->company_name!=""){ $llenos++; }
      $contador++;
      if($value->industry!=""){ $llenos++; } 
      $contador++;
      if($value->segments!=""){ $llenos++; }
      $contador++;
      if($value->country!=""){ $llenos++; } 
      $contador++;
      if($value->state!=""){ $llenos++; }
      $contador++;
      if($value->city!=""){ $llenos++; }     
      $contador++;
      if($value->contract_start_year!=""){ $llenos++; } 
      $contador++;
      if($value->contract_end_year!=""){ $llenos++; } 
      $contador++;
      if($value->contract_object!=""){ $llenos++; } 
      $contador++;
      if($value->contract_value!=""){ $llenos++; }  
      $contador++;
      if($value->currency!=""){ $llenos++; }     
      $contador++;
      if($value->document_file!=""){ $llenos++; }                           

    }                                                                              


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }      


  public function completitud7Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $contador=0;
    $llenos=0;
    
    $bancos = $this->getBanks();
    foreach($bancos as $value){
      $contador++;
      if($value->country!=""){ $llenos++; }
      $contador++;
      if($value->bank!=""){ $llenos++; } 
      $contador++;
      if($value->office!=""){ $llenos++; }
      $contador++;
      if($value->account_type!=""){ $llenos++; } 
      $contador++;
      if($value->account_number!=""){ $llenos++; }
      $contador++;
      if($value->holder!=""){ $llenos++; }     
      $contador++;
      if($value->account_certificate!=""){ $llenos++; } 

      if($value->country!="Colombia" and $value->country!=""){
        $contador++;
        if($value->swift_number!=""){ $llenos++; } 
        $contador++;
        if($value->routing_number!=""){ $llenos++; } 
        $contador++;
        if($value->iban!=""){ $llenos++; }  
        $contador++;
        if($value->bic!=""){ $llenos++; }     
        $contador++;
        if($value->intermediary_bank!=""){ $llenos++; }   
      }

    }                                                                              


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  } 


  public function completitud8Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);


    $contador=0;
    $llenos=0;
    
    $contador++;
    if($supplier->income_origin!=""){ $llenos++; }
    $contador++;
    if($supplier->currency_type!=""){ $llenos++; }
    $contador++;
    if($supplier->equity!=""){ $llenos++; }
    $contador++;
    if($supplier->assets!=""){ $llenos++; }
    $contador++;
    if($supplier->liabilities!=""){ $llenos++; }
    $contador++;
    if($supplier->assets_total!=""){ $llenos++; }
    $contador++;
    if($supplier->liabilities_total!=""){ $llenos++; }
    $contador++;
    if($supplier->income!=""){ $llenos++; }
    $contador++;
    if($supplier->expenses!=""){ $llenos++; } 
    $contador++;
    if($supplier->income_other!=""){ $llenos++; } 
    $contador++;
    if($supplier->expenses_other!=""){ $llenos++; } 
    $contador++;
    if($supplier->income_total!=""){ $llenos++; }                        
    $contador++;
    if($supplier->expenses_total!=""){ $llenos++; }  
    $contador++;
    if($supplier->utility!=""){ $llenos++; }  
    $contador++;
    if($supplier->utility_total!=""){ $llenos++; }  
    $contador++;
    if($supplier->financial_expenses!=""){ $llenos++; }   
    $contador++;
    if($supplier->income_other_concept!=""){ $llenos++; }  
    $contador++;
    if($supplier->eeff!=""){ $llenos++; }  
    $contador++;
    if($supplier->eeff_year!=""){ $llenos++; }  
    $contador++;
    if($supplier->foreign_currency!=""){ $llenos++; }
    $contador++;
    if($supplier->foreign_products!=""){ $llenos++; }
    $contador++;
    if($supplier->tax_liabilities!=""){ $llenos++; }
    $contador++;
    if($supplier->nontaxable_agent!=""){ $llenos++; }
    $contador++;
    if($supplier->tax_regime!=""){ $llenos++; }
    $contador++;
    if($supplier->tax_declaration_year!=""){ $llenos++; }
    $contador++;
    if($supplier->tax_declaration!=""){ $llenos++; }

    $contador++;
    $list_ica_liabilities = $this->getIcaLiabilities();
    if(count($list_ica_liabilities)>0){
      $llenos++;
    }                                                                                
        


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  } 


  public function completitud9Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $contador=0;
    $llenos=0;
    
    $certifications = $this->getCertifications();
    foreach($certifications as $value){
      $contador++;
      if($value->type!=""){ $llenos++; }
      $contador++;
      if($value->start_date!=""){ $llenos++; } 
      $contador++;
      if($value->end_date!=""){ $llenos++; }
      $contador++;
      if($value->certification_file!=""){ $llenos++; } 
      $contador++;
      if($value->comment!=""){ $llenos++; }
    }                                                                              


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  } 

  public function completitud10Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $contador=0;
    $llenos=0;
    
    $ssts = $this->getSGSST();
    foreach($ssts as $value){
      $contador++;
      if($value->operation_year!=""){ $llenos++; }
      $contador++;
      if($value->fatalities!=""){ $llenos++; } 
      $contador++;
      if($value->disabling_accidents!=""){ $llenos++; }
      $contador++;
      if($value->total_incidents!=""){ $llenos++; } 
      $contador++;
      if($value->disability_days!=""){ $llenos++; }
      $contador++;
      if($value->workers_number!=""){ $llenos++; }
      $contador++;
      if($value->manhours!=""){ $llenos++; }
      $contador++;
      if($value->risk_level!=""){ $llenos++; } 
      $contador++;
      if($value->rating_percentage!=""){ $llenos++; }
      $contador++;
      if($value->arl_accident_certificate!=""){ $llenos++; }
      $contador++;
      if($value->arl_accident_certificate_date!=""){ $llenos++; }
      $contador++;
      if($value->arl_affiliation_certificate!=""){ $llenos++; } 
      $contador++;
      if($value->arl_affiliation_certificate_date!=""){ $llenos++; }
      $contador++;
      if($value->evaluation_result_certificate!=""){ $llenos++; }
      $contador++;
      if($value->evaluation_result_certificate_date!=""){ $llenos++; } 
                            
    }                                                                              


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  }   


  public function completitud11Action(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplier = $this->getUserSupplier($userSession->id);
    $supplier = $this->getSupplier($supplierSession->id);

    $interestModel = new Administracion_Model_DbTable_Supplierclassification();
    $supplier_id =  Session::getInstance()->get("supplier")->id;
    $this->_view->selectedSectors = $selectedSectors = $interestModel->getList("supplier_id='$supplier_id' AND level='1' ");
    $this->_view->selectedSegment = $selectedSegment =  $interestModel->getList("supplier_id='$supplier_id' AND level='2' ");
    $this->_view->selectedFamily = $selectedFamily = $interestModel->getList("supplier_id='$supplier_id' AND level='3' ");
    $this->_view->selectedClass = $selectedClass = $interestModel->getList("supplier_id='$supplier_id' AND level='4' ");
    $this->_view->selectedProduct = $selectedProduct = $interestModel->getList("supplier_id='$supplier_id' AND level='5' ");

    $contador=0;
    $llenos=0;

    $contador++;
    if(count($selectedSectors)>0){ $llenos++; }
    $contador++;
    if(count($selectedSegment)>0){ $llenos++; }
    $contador++;
    if(count($selectedFamily)>0){ $llenos++; }
    $contador++;
    if(count($selectedClass)>0){ $llenos++; }
    $contador++;
    if(count($selectedProduct)>0){ $llenos++; }


    $porcentaje = round($llenos/$contador*100);
    $res['porcentaje'] = $porcentaje;
    echo json_encode($res);

  } 

  public function completitudtotalAction(){
    $this->setLayout('blanco');
    $total = $this->_getSanitizedParam("total");

    $userSession = Session::getInstance()->get("user");
    $supplierSession = Session::getInstance()->get("supplier");
    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();

    if($total>0){
      $userSupplierModel->editField($userSession->id,"completeness",$total);
    }

  }


}
