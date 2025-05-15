<?php

/**
 *
 */

class Supplier_loginController extends Supplier_mainController
{

  public function init()
  {
    $user = Session::getInstance()->get("user");
    $supplier = Session::getInstance()->get("supplier");

    if ($user || $supplier) {
      header('Location: /supplier/profile');
      // exit;
    }
    parent::init();
  }

  public function indexAction()
  {
    $this->partialsNoUser();
  }

  public function verifyAction()
  {
    $this->setLayout('blanco');
    $isPost = $this->getRequest()->isPost();
    if (!$isPost) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'Método no permitido.'
      ];
      echo json_encode($res);
      exit;
    }
    $email = $this->_getSanitizedParam('email');
    $password = $this->_getSanitizedParam('password');

    $rememberMe = $this->_getSanitizedParam('remember-me');

    $captcha = $_POST['g-recaptcha-response'];
    if (!$this->verifyCaptcha($captcha)) {
      $res = [
        'captchaReset' => true,
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'Captcha no verificado.'
      ];
      echo json_encode($res);
      exit;
    }

    if (!$email || !$password) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'Por favor, complete todos los campos.'
      ];
      echo json_encode($res);
      exit;
    }

    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();
    $userExists = $userSupplierModel->getList("email = '$email'")[0];
    if (!$userExists) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'Usuario o contraseña incorrectos.'
      ];
      echo json_encode($res);
      exit;
    }
    if (!$userExists->email_verified_at || $userExists->email_verified_at == '0000-00-00 00:00:00') {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'El usuario no ha verificado su correo electrónico.'
      ];
      echo json_encode($res);
      exit;
    }

    if ($userExists->status != 1) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'El usuario no está activo.'
      ];
      echo json_encode($res);
      exit;
    }
    if (!password_verify($password, $userExists->password)) {
      $res = [
        'success' => false,
        'title' => 'Error',
        'icon' => 'error',
        'status' => 'error',
        'text' => 'Usuario o contraseña incorrectos.'
      ];
      echo json_encode($res);
      exit;
    }

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier = $supplierModel->getList("id = '" . $userExists->supplier_id . "'")[0];
    Session::getInstance()->set("user", $userExists);
    Session::getInstance()->set("supplier", $supplier);

    $res = [
      'success' => true,
      'title' => 'Éxito',
      'icon' => 'success',
      'status' => 'success',
      'text' => 'Inicio de sesión exitoso.',
      'redirect' => '/supplier/profile'
    ];
    echo json_encode($res);
    exit;
  }

  // Método privado para verificar el captcha
  private function verifyCaptcha($response)
  {
    // Clave secreta de reCAPTCHA
    $secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';

    // URL de verificación de reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secretKey,
      'response' => $response
    );

    // Configuración de la solicitud HTTP POST
    $options = array(
      'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    // Realiza la solicitud y decodifica la respuesta
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // Devuelve true si el captcha es válido
    return $response->success;
  }

  public function logoutAction()
  {
    session_destroy();
    Session::getInstance()->set("user", null);
    Session::getInstance()->set("supplier", null);
    header('Location: /supplier/login');
    exit;
  }
}
