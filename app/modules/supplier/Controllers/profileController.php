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
    $this->_view->profileComplete = round($this->getProfileComplete(), 2);
    $this->_view->segments = $this->getSegments();
    $this->_view->list_industry = $this->getIndustry();
    $this->_view->sedesSupplier = $this->getSedes();
    $this->_view->list_certification_types = $this->getCertificationTypes();
    $this->_view->list_banks = $this->getBanks();
    $this->_view->list_certifications = $this->getCertifications();
    $this->_view->list_experiences = $this->getExperiences();
    $this->_view->list_ica_liabilities = $this->getIcaLiabilities();
    $this->_view->list_sst = $this->getSGSST();

    $this->_view->userSupplier = $userSupplier;
    $this->_view->supplier = $supplier;
    $this->_view->terms = $terms;
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
      'title' => 'Success',
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
      'title' => 'Success',
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

  #region getDataGeneralInfo
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
  #endregion

  #region getDataUserInfo
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
    $data['tax_declaration_year'] = "";
    $data['updated_at'] = date("Y-m-d H:i:s");
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

}
