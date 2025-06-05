<?php

/**
 *
 */

class Page_registerController extends Page_mainController
{

  public function indexAction()
  {
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");

    $this->_view->list_country = $this->getCountry();
    $this->_view->list_industry = $this->getIndustry();

    $title = "Registro de comprador";
    $this->_view->titlesection = $title;

    $this->partialsNoUser();

  }

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

  public function storeAction(){
    $this->setLayout('blanco');
    $data = $this->getData();
    $clientModel = new Page_Model_DbTable_Clients();

    $errors = [];
    if (empty($data['nit'])) {
      $errors['nit'] = 'El documento es obligatorio';
    } else {
      $exist = $clientModel->getList("nit = '" . $data['nit'] . "'", "");
      if ($exist) {
        $errors['nit'] = 'El documento ya existe';
      }
    }

    if (empty($data['email'])) {
      $errors['email'] = 'El correo personal es obligatorio';
    } else {
      $exist = $clientModel->getList("email = '" . $data['email'] . "'", "");
      if ($exist) {
        $errors['email'] = 'El correo personal ya existe';
      }
    } 

    if (empty($data['bussinesEmail'])) {
      $errors['bussinesEmail'] = 'El correo corporativo es obligatorio';
    } else {
      $exist = $clientModel->getList("bussinesEmail = '" . $data['bussinesEmail'] . "'", "");
      if ($exist) {
        $errors['bussinesEmail'] = 'El correo corporativo ya existe';
      }
    }

    if (empty($data['company_nit'])) {
      $errors['company_nit'] = 'El documento de la empresa es obligatorio';
    } else {
      $exist = $clientModel->getList("company_nit = '" . $data['company_nit'] . "'", "");
      if ($exist) {
        $errors['company_nit'] = 'El documento de la empresa ya existe';
      }
    }


    if (empty($data['company'])) {
      $errors['company'] = 'El nombre de la empresa es obligatorio';
    } else {
      $exist = $clientModel->getList("company = '" . $data['company'] . "'", "");
      if ($exist) {
        $errors['company'] = 'El nombre de la empresa ya existe';
      }
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

    $client_id = $clientModel->insertar_registro($data);

    if($client_id>0){
      $client = $clientModel->getById($client_id);
      $this->sendOtp($client);

      echo json_encode([
        'success' => true,
        'title' => 'Éxito',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Registro guardado exitosamente, se ha enviado un correo de verificación.',
        'redirect' => '/page/login'
      ]);
      exit;

    }else{
      //error
    }

  }


  public function getData(){

    $data = array();
    $data['documentType'] = $this->_getSanitizedParam("documentType");
    $data['nit'] = $this->_getSanitizedParam("nit");
    $data['name'] = $this->_getSanitizedParam("name");
    $data['lastname'] = $this->_getSanitizedParam("lastname");
    $data['email'] = $this->_getSanitizedParam("email");
    $data['bussinesEmail'] = $this->_getSanitizedParam("bussinesEmail");
    $data['whatsapp'] = $this->_getSanitizedParam("whatsapp");
    $data['phone'] = $this->_getSanitizedParam("phone");
    $data['city'] = $this->_getSanitizedParam("city");
    $data['company'] = $this->_getSanitizedParam("company");
    $data['position'] = $this->_getSanitizedParam("position");
    $data['area'] = $this->_getSanitizedParam("area");
    $data['country'] = $this->_getSanitizedParam("country");
    $data['state'] = $this->_getSanitizedParam("state");
    $data['password'] = $this->_getSanitizedParam("password");
    $data['phoneCode'] = $this->_getSanitizedParam("phoneCode");
    $data['industry_id'] = $this->_getSanitizedParam("industry_id");
    $data['nit_type'] = $this->_getSanitizedParam("nit_type");
    $data['company_nit'] = $this->_getSanitizedParam("company_nit");
    $data['company_country'] = $this->_getSanitizedParam("company_country");
    $data['company_city'] = $this->_getSanitizedParam("company_city");
    $data['company_state'] = $this->_getSanitizedParam("company_state");

    if($data['whatsapp']==""){
      $data['whatsapp']=0;
    }
    if($data['phone']==""){
      $data['phone']=0;
    }    

    return $data;

  }


  public function sendOtp($user)
  {

    // Generar un OTP de 6 dígitos
    $otpCode = rand(100000, 999999);

    $otpData = [
      'user_id' => $user->id,
      'otp' => $otpCode,
      'user_type' => '1',
      'email' => $user->email,
      'created_at' => date('Y-m-d H:i:s'),
      'expires_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
    $otpModel = new Administracion_Model_DbTable_Otps();
    $idOtp = $otpModel->insert($otpData);
    $otp = $otpModel->getById($idOtp);


    $otpEncrypted = $this->encrypt($otpCode);
    $userEncrypted = $this->encrypt($user->id);

    $ruta = RUTA_BUYER . "verifyemail?otp=$otpEncrypted&user=$userEncrypted";

    $mailModel = new Core_Model_Sendingemail($this->_view);
    $boolMail = $mailModel->sendOtp($user, $otp, $ruta);

    return $boolMail;
  }


}
